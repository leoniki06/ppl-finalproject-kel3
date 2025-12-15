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

        // Ambil cart items
        $cartItems = collect([]);

        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())
                ->with('product')
                ->get()
                ->map(function ($item) {
                    return (object)[
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                        'price' => $item->price,
                        'original_price' => $item->product->original_price ?? $item->price,
                        'quantity' => $item->quantity,
                        'selected' => true,
                        'image_url' => $item->product->image_url,
                        'brand' => $item->product->brand ?? 'LastBite',
                        'category' => $item->product->category,
                        'expiry_date' => $item->product->expiry_date ?? null,
                        'rating' => $item->product->rating ?? 4.5,
                        'rating_count' => $item->product->rating_count ?? 10,
                        'description' => $item->product->description ?? 'Fresh product with great quality and best price.',
                        'discount_percent' => $item->product->discount_percent ?? 0,
                        'is_flash_sale' => $item->product->is_flash_sale ?? false,
                    ];
                });
        }

        // REVISI: Algoritma rekomendasi SAMA dengan ProductController
        $recommendedProducts = $this->getRecommendedProducts($cartItems);

        Log::info('Passing to view - Cart Items: ' . $cartItems->count() . ', Recommended: ' . $recommendedProducts->count());

        return view('cart.index', [
            'cartItems' => $cartItems,
            'recommendedProducts' => $recommendedProducts
        ]);
    }

    /**
     * Get recommended products - SAMA DENGAN PRODUCT CONTROLLER
     */
    private function getRecommendedProducts($cartItems)
    {
        // ALGORITMA REKOMENDASI: SAMA DENGAN PRODUCT CONTROLLER
        // 1. Prioritaskan produk dengan kategori yang sama dengan produk di cart
        // 2. Prioritaskan flash sale
        // 3. Exclude produk yang sudah ada di cart

        $cartProductIds = $cartItems->pluck('id')->toArray();
        $categories = $cartItems->pluck('category')->unique()->toArray();

        if (empty($categories)) {
            $categories = ['bakery', 'dairy', 'fruit'];
        }

        // Ambil produk dari database
        $recommended = Product::whereNotIn('id', $cartProductIds)
            ->where(function ($query) use ($categories) {
                // Prioritaskan kategori yang sama dengan cart
                $query->whereIn('category', $categories)
                    ->orWhere('is_flash_sale', true)
                    ->orWhere('discount_percent', '>=', 20);
            })
            ->where('stock', '>', 0)
            ->inRandomOrder()
            ->limit(8)
            ->get();

        // Jika tidak cukup produk, tambahkan produk random
        if ($recommended->count() < 4) {
            $additionalProducts = Product::whereNotIn('id', $cartProductIds)
                ->whereNotIn('id', $recommended->pluck('id'))
                ->inRandomOrder()
                ->limit(8 - $recommended->count())
                ->get();

            $recommended = $recommended->merge($additionalProducts);
        }

        // Jika masih tidak ada produk, gunakan dummy
        if ($recommended->isEmpty()) {
            $recommended = collect([
                (object)[
                    'id' => 1,
                    'name' => 'Artisan Sourdough Bread',
                    'price' => 25000,
                    'original_price' => 45000,
                    'discount_percent' => 44,
                    'category' => 'bakery',
                    'brand' => 'BreadTalk',
                    'image_url' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    'rating' => 4.7,
                    'rating_count' => 128,
                    'is_flash_sale' => true,
                    'description' => 'Freshly baked sourdough bread, crusty exterior with soft interior.'
                ],
                (object)[
                    'id' => 3,
                    'name' => 'Fresh Milk 1L',
                    'price' => 18000,
                    'original_price' => 28000,
                    'discount_percent' => 36,
                    'category' => 'dairy',
                    'brand' => 'Greenfields',
                    'image_url' => 'https://images.unsplash.com/photo-1563636619-e9143da7973b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    'rating' => 4.5,
                    'rating_count' => 76,
                    'is_flash_sale' => true,
                    'description' => 'Fresh pasteurized milk from local dairy farms.'
                ],
                (object)[
                    'id' => 5,
                    'name' => 'Organic Apples (1kg)',
                    'price' => 35000,
                    'original_price' => 45000,
                    'discount_percent' => 22,
                    'category' => 'fruit',
                    'brand' => 'Fresh Market',
                    'image_url' => 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    'rating' => 4.9,
                    'rating_count' => 210,
                    'is_flash_sale' => false,
                    'description' => 'Fresh organic apples, crisp and sweet.'
                ],
                (object)[
                    'id' => 7,
                    'name' => 'Chocolate Chip Cookies (Pack of 6)',
                    'price' => 28000,
                    'original_price' => 40000,
                    'discount_percent' => 30,
                    'category' => 'bakery',
                    'brand' => 'Mrs. Fields',
                    'image_url' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    'rating' => 4.7,
                    'rating_count' => 142,
                    'is_flash_sale' => false,
                    'description' => 'Soft and chewy cookies with rich chocolate chips.'
                ]
            ]);
        }

        return $recommended;
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock'
            ], 400);
        }

        if (Auth::check()) {
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $request->quantity;
                $cartItem->save();
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'price' => $product->price
                ]);
            }

            $product->stock -= $request->quantity;
            $product->save();
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$request->product_id])) {
                $cart[$request->product_id]['quantity'] += $request->quantity;
            } else {
                $cart[$request->product_id] = [
                    'product_id' => $request->product_id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $request->quantity,
                    'image_url' => $product->image_url,
                    'category' => $product->category
                ];
            }

            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'cart_count' => $this->getCartCount()
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        if (Auth::check()) {
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->first();

            if ($cartItem) {
                $product = Product::find($request->product_id);
                if ($product) {
                    $product->stock += $cartItem->quantity;
                    $product->save();
                }

                $cartItem->delete();
            }
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$request->product_id])) {
                unset($cart[$request->product_id]);
                session()->put('cart', $cart);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart',
            'cart_count' => $this->getCartCount()
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::find($request->product_id);

        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock'
            ], 400);
        }

        if (Auth::check()) {
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->first();

            if ($cartItem) {
                $quantityDiff = $request->quantity - $cartItem->quantity;
                $cartItem->quantity = $request->quantity;
                $cartItem->save();

                $product->stock -= $quantityDiff;
                $product->save();
            }
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$request->product_id])) {
                $cart[$request->product_id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
            'cart_count' => $this->getCartCount(),
            'subtotal' => $this->getCartSubtotal()
        ]);
    }

    /**
     * Get cart count for current user
     */
    private function getCartCount()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cart = session()->get('cart', []);
            $count = 0;
            foreach ($cart as $item) {
                $count += $item['quantity'];
            }
            return $count;
        }
    }

    /**
     * Get cart subtotal
     */
    private function getCartSubtotal()
    {
        $subtotal = 0;

        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
            foreach ($cartItems as $item) {
                $subtotal += $item->quantity * $item->price;
            }
        } else {
            $cart = session()->get('cart', []);
            foreach ($cart as $item) {
                $subtotal += $item['quantity'] * $item['price'];
            }
        }

        return $subtotal;
    }

    /**
     * Process checkout
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:cash,credit_card,transfer'
        ]);

        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())
                ->with('product')
                ->get();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty'
                ], 400);
            }

            $order = new \App\Models\Order();
            $order->user_id = Auth::id();
            $order->total_amount = $this->getCartSubtotal();
            $order->shipping_address = $request->shipping_address;
            $order->payment_method = $request->payment_method;
            $order->status = 'pending';
            $order->save();

            foreach ($cartItems as $cartItem) {
                $orderItem = new \App\Models\OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $cartItem->product_id;
                $orderItem->quantity = $cartItem->quantity;
                $orderItem->price = $cartItem->price;
                $orderItem->save();
            }

            Cart::where('user_id', Auth::id())->delete();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'order_id' => $order->id
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Please login to checkout'
            ], 401);
        }
    }

    /**
     * Get cart summary for API
     */
    public function getCartSummary()
    {
        $cartItems = [];

        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())
                ->with('product')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->product_id,
                        'name' => $item->product->name,
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'image_url' => $item->product->image_url,
                        'category' => $item->product->category
                    ];
                });
        } else {
            $cart = session()->get('cart', []);
            foreach ($cart as $item) {
                $cartItems[] = $item;
            }
        }

        $subtotal = $this->getCartSubtotal();
        $shipping = 0;
        $tax = $subtotal * 0.1;
        $total = $subtotal + $shipping + $tax;

        return response()->json([
            'success' => true,
            'cart_items' => $cartItems,
            'summary' => [
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total
            ]
        ]);
    }
}
