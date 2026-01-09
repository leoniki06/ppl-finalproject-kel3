<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class CartController extends Controller
{
    /**
     * Display cart page with recommended products
     */
    public function index()
    {
        Log::info('CartController::index() called');

        $cartItems = collect([]);

        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())
                ->with('product')
                ->get()
                ->map(function ($item) {
                    $price = (int) ($item->product?->price ?? $item->price ?? 0);

                    return (object) [
                        'id' => (int) ($item->product?->id ?? $item->product_id),
                        'product_id' => (int) ($item->product?->id ?? $item->product_id),

                        'name' => $item->product?->name ?? '',
                        'price' => $price,
                        'original_price' => (int) ($item->product?->original_price ?? $price),
                        'quantity' => (int) $item->quantity,
                        'selected' => true,
                        'image_url' => $this->resolveProductImage($item->product?->image_url),
                        'brand' => $item->product?->brand ?? 'LastBite',
                        'category' => $item->product?->category,
                        'expiry_date' => $item->product?->expiry_date ?? null,
                        'rating' => $item->product?->rating ?? 4.5,
                        'rating_count' => $item->product?->rating_count ?? 10,
                        'description' => $item->product?->description ?? 'Fresh product with great quality and best price.',
                        'discount_percent' => $item->product?->discount_percent ?? 0,
                        'is_flash_sale' => (bool) ($item->product?->is_flash_sale ?? false),
                    ];
                });
        }

        $selectedItems = $cartItems->filter(fn($it) => (bool) ($it->selected ?? false));
        $subtotal = $selectedItems->sum(fn($it) => ((int) $it->price) * ((int) $it->quantity));
        $shipping = 0;
        $tax = (int) round($subtotal * 0.1);
        $total = $subtotal + $shipping + $tax;

        $recommendedProducts = $this->getRecommendedProducts($cartItems);

        return view('cart.index', [
            'cartItems' => $cartItems,
            'recommendedProducts' => $recommendedProducts,
            'summary' => [
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
                'item_qty' => (int) $selectedItems->sum('quantity'),
                'line_count' => (int) $selectedItems->count(),
            ],
        ]);
    }

    /**
     * Recommended products (DB only, no dummy)
     */
    private function getRecommendedProducts($cartItems)
    {
        $cartProductIds = collect($cartItems)
            ->map(fn($it) => (int) ($it->product_id ?? $it->id ?? 0))
            ->filter(fn($id) => $id > 0)
            ->unique()
            ->values()
            ->toArray();

        $categories = collect($cartItems)
            ->map(fn($it) => $it->category ?? null)
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $q = Product::query()
            ->whereNotIn('id', $cartProductIds)
            ->where('stock', '>', 0);

        if (!empty($categories)) {
            $q->where(function ($query) use ($categories) {
                $query->whereIn('category', $categories)
                    ->orWhere('is_flash_sale', true)
                    ->orWhere('discount_percent', '>=', 20);
            });
        } else {
            $q->where(function ($query) {
                $query->where('is_flash_sale', true)
                    ->orWhere('discount_percent', '>=', 20);
            });
        }

        $recommended = $q->inRandomOrder()->limit(8)->get();

        if ($recommended->count() < 4) {
            $additional = Product::query()
                ->whereNotIn('id', $cartProductIds)
                ->whereNotIn('id', $recommended->pluck('id')->toArray())
                ->where('stock', '>', 0)
                ->inRandomOrder()
                ->limit(8 - $recommended->count())
                ->get();

            $recommended = $recommended->merge($additional);
        }

        return $recommended;
    }

    /**
     * Helper: build cart items + summary (SHAPE cocok untuk cart.js)
     */
    private function buildCartPayload()
    {
        $rows = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        $items = $rows->map(function ($row) {
            return [
                'id' => (int) $row->product_id,
                'product_id' => (int) $row->product_id,
                'name' => $row->product?->name ?? '',
                'price' => (int) ($row->product?->price ?? $row->price ?? 0),
                'original_price' => (int) ($row->product?->original_price ?? ($row->product?->price ?? $row->price ?? 0)),
                'quantity' => (int) $row->quantity,
                'image_url' => $this->resolveProductImage($row->product?->image_url),
                'brand' => $row->product?->brand ?? 'LastBite',
                'category' => $row->product?->category,
                'expiry_date' => $row->product?->expiry_date,
                'rating' => $row->product?->rating ?? 4.5,
                'rating_count' => $row->product?->rating_count ?? 10,
                'description' => $row->product?->description ?? '',
                'discount_percent' => $row->product?->discount_percent ?? 0,
                'is_flash_sale' => (bool) ($row->product?->is_flash_sale ?? false),
            ];
        })->values()->toArray();

        $subtotal = 0;
        foreach ($items as $it) {
            $subtotal += ((int) $it['quantity']) * ((int) $it['price']);
        }

        // NOTE: cart.js kamu pakai FEES delivery/service sendiri.
        // Tapi kita tetap kasih summary biar konsisten.
        $shipping = 0;
        $tax = (int) round($subtotal * 0.1);
        $total = $subtotal + $shipping + $tax;

        $cartCount = (int) $rows->sum('quantity');

        return [
            'items' => $items,                 // ✅ INI yang cart.js butuh
            'cart_items' => $items,            // (opsional) kompatibilitas lama
            'summary' => [
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
            ],
            'cart_count' => $cartCount,
        ];
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first',
            ], 401);
        }

        $product = Product::findOrFail((int) $request->product_id);
        $qtyToAdd = (int) $request->quantity;

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        $nextQty = $cartItem ? ((int) $cartItem->quantity + $qtyToAdd) : $qtyToAdd;

        if ((int) $product->stock < $nextQty) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock',
            ], 400);
        }

        if ($cartItem) {
            $cartItem->quantity = $nextQty;
            $cartItem->price = (int) $product->price;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => (int) $product->id,
                'quantity'   => $qtyToAdd,
                'price'      => (int) $product->price,
            ]);
        }

        $payload = $this->buildCartPayload();

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            ...$payload,
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first',
            ], 401);
        }

        Cart::where('user_id', Auth::id())
            ->where('product_id', (int) $request->product_id)
            ->delete();

        $payload = $this->buildCartPayload();

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart',
            ...$payload,
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first',
            ], 401);
        }

        $productId = (int) $request->product_id;
        $qty = (int) $request->quantity;

        $product = Product::findOrFail($productId);

        if ((int) $product->stock < $qty) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock',
            ], 400);
        }

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if (!$cartItem) {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $productId,
                'quantity'   => $qty,
                'price'      => (int) $product->price,
            ]);
        } else {
            $cartItem->quantity = $qty;
            $cartItem->price = (int) $product->price;
            $cartItem->save();
        }

        $payload = $this->buildCartPayload();

        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
            ...$payload,
        ]);
    }

    private function resolveProductImage(?string $url): ?string
    {
        $url = (string) ($url ?? '');
        $url = trim($url);

        // Kalau kosong: jangan pakai placeholder eksternal.
        // Return null saja biar UI kamu pakai "image-empty" (icon) atau placeholder lokal.
        if ($url === '') return null;

        // Kalau sudah URL penuh
        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        // Kalau sudah "storage/xxx"
        if (str_starts_with($url, 'storage/')) {
            return asset($url);
        }

        // Default: anggap ada di storage
        return asset('storage/' . ltrim($url, '/'));
    }



    /**
     * API summary untuk cart.js
     * ✅ IMPORTANT: harus return key "items" (bukan hanya cart_items)
     */
    public function getCartSummary()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        $payload = $this->buildCartPayload();

        return response()->json([
            'success' => true,
            ...$payload,
        ]);
    }
}
