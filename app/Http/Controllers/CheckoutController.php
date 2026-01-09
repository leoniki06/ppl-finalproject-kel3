<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('cart.index')
                ->with('error', 'Please login to checkout');
        }

        return view('checkout');
    }

    public function process(Request $request)
    {
        $request->validate([
            'items'               => 'required|array|min:1',
            'items.*.product_id'  => 'required|integer|exists:products,id',
            'items.*.quantity'    => 'required|integer|min:1',
            'shipping_address'    => 'required|string',
            'payment_method'      => 'required|string',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        $userId = Auth::id();

        // normalisasi payment_method biar konsisten
        $pm = strtolower(trim((string)$request->payment_method));
        $isCod = in_array($pm, ['cod', 'cash_on_delivery', 'cash'], true);

        Log::info('CHECKOUT_START', [
            'db'      => DB::connection()->getDatabaseName(),
            'user_id' => $userId,
            'payment_method' => $pm,
            'payload' => $request->all(),
        ]);

        try {
            $result = DB::transaction(function () use ($request, $userId, $pm, $isCod) {

                $itemsReq = collect($request->items)->map(fn ($it) => [
                    'product_id' => (int)($it['product_id'] ?? 0),
                    'quantity'   => (int)($it['quantity'] ?? 0),
                ]);

                $productIds = $itemsReq->pluck('product_id')->all();

                $cartRows = Cart::where('user_id', $userId)
                    ->whereIn('product_id', $productIds)
                    ->get()
                    ->keyBy('product_id');

                if ($cartRows->isEmpty()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Selected items not found in cart',
                    ], 400);
                }

                $products = Product::lockForUpdate()
                    ->whereIn('id', $productIds)
                    ->get()
                    ->keyBy('id');

                foreach ($itemsReq as $it) {
                    $p = $products->get($it['product_id']);

                    if (!$p) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Product missing',
                        ], 404);
                    }

                    if (empty($p->seller_id)) {
                        return response()->json([
                            'success' => false,
                            'message' => "Product {$p->name} belum punya seller_id",
                        ], 422);
                    }

                    if ((int)$p->stock < (int)$it['quantity']) {
                        return response()->json([
                            'success' => false,
                            'message' => "Insufficient stock for {$p->name}",
                        ], 400);
                    }
                }

                // split per seller
                $itemsGroupedBySeller = $itemsReq->groupBy(function ($it) use ($products) {
                    $p = $products->get($it['product_id']);
                    return (int)$p->seller_id;
                });

                $createdOrders = [];

                foreach ($itemsGroupedBySeller as $sellerId => $sellerItems) {

                    $total = 0;
                    foreach ($sellerItems as $it) {
                        $p = $products->get($it['product_id']);
                        $total += ((float)$p->price) * ((int)$it['quantity']);
                    }

                    // ✅ aturan pembayaran:
                    // COD => unpaid
                    // selain COD (QRIS, dsb) => paid
                    $paymentStatus = $isCod ? 'unpaid' : 'paid';
                    $paidAt = $isCod ? null : now();

                    // status order: kamu bebas.
                    // Banyak sistem: QRIS paid tapi status tetap pending (menunggu diproses seller)
                    // Jadi kita set:
                    // - COD: pending
                    // - QRIS: pending (paid), bukan completed
                    $orderStatus = 'pending';

                    $order = Order::create([
                        'order_number'     => 'ORD-' . now()->format('YmdHis') . '-' . $userId . '-' . Str::upper(Str::random(4)),
                        'user_id'          => $userId,
                        'seller_id'        => (int)$sellerId,
                        'total_amount'     => $total,
                        'status'           => $orderStatus,
                        'shipping_address' => (string)$request->shipping_address,
                        'payment_method'   => $pm,
                        'payment_status'   => $paymentStatus,
                        'paid_at'          => $paidAt,
                    ]);

                    foreach ($sellerItems as $it) {
                        $p = $products->get($it['product_id']);
                        $qty = (int)$it['quantity'];

                        OrderItem::create([
                            'order_id'   => $order->id,
                            'product_id' => $p->id,
                            'quantity'   => $qty,
                            'price'      => (float)$p->price,
                        ]);

                        $p->decrement('stock', $qty);
                    }

                    $createdOrders[] = $order;
                }

                Cart::where('user_id', $userId)
                    ->whereIn('product_id', $productIds)
                    ->delete();

                $orderNumbers = collect($createdOrders)->pluck('order_number')->values()->all();

                return response()->json([
                    'success'       => true,
                    'message'       => count($orderNumbers) > 1 ? 'Checkout created (split by seller)' : 'Checkout created',
                    'order_id'      => $orderNumbers[0] ?? null,
                    'order_numbers' => $orderNumbers,
                    'payment_method' => $pm,
                    'payment_status' => $isCod ? 'unpaid' : 'paid',
                ]);
            });

            return $result;

        } catch (\Throwable $e) {
            Log::error('CHECKOUT_FAILED', [
                'user_id' => $userId,
                'error'   => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'order_id' => 'nullable|string',
            'order_numbers' => 'nullable|array',
            'order_numbers.*' => 'string',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required',
            ], 401);
        }

        $userId = Auth::id();

        $numbers = [];
        if (is_array($request->order_numbers) && count($request->order_numbers) > 0) {
            $numbers = $request->order_numbers;
        } elseif (!empty($request->order_id)) {
            $numbers = [(string)$request->order_id];
        } else {
            return response()->json([
                'success' => false,
                'message' => 'order_id or order_numbers is required',
            ], 422);
        }

        $orders = Order::where('user_id', $userId)
            ->whereIn('order_number', $numbers)
            ->get();

        if ($orders->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        foreach ($orders as $order) {
            $order->update([
                'payment_status' => 'paid',
                'paid_at'        => now(),
                // jangan auto completed kalau kamu mau seller yang nyelesaikan
                // 'status' => 'completed',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment confirmed',
            'confirmed_orders' => $orders->pluck('order_number')->values()->all(),
        ]);
    }
}
