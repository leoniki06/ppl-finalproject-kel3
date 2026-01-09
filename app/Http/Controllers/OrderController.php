<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        return redirect()->route('profile')->with('scroll_to', 'orders');
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
            'total_amount' => 'required|numeric',
            'address' => 'required|string',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        $userId = Auth::id();

        try {
            $res = DB::transaction(function () use ($request, $userId) {

                $itemsReq = collect($request->items)->map(fn($it) => [
                    'product_id' => (int)$it['product_id'],
                    'quantity'   => (int)$it['quantity'],
                ]);

                $productIds = $itemsReq->pluck('product_id')->all();

                $products = Product::lockForUpdate()
                    ->whereIn('id', $productIds)
                    ->get()
                    ->keyBy('id');

                foreach ($itemsReq as $it) {
                    $p = $products->get($it['product_id']);

                    if (!$p) {
                        throw new \Exception('Product missing');
                    }
                    if (empty($p->seller_id)) {
                        throw new \Exception("Product {$p->name} belum punya seller_id");
                    }
                    if ((int)$p->stock < (int)$it['quantity']) {
                        throw new \Exception("Insufficient stock for {$p->name}");
                    }
                }

                // ✅ split per seller
                $grouped = $itemsReq->groupBy(function ($it) use ($products) {
                    return (int)$products->get($it['product_id'])->seller_id;
                });

                $created = [];

                foreach ($grouped as $sellerId => $sellerItems) {
                    $total = 0;

                    foreach ($sellerItems as $it) {
                        $p = $products->get($it['product_id']);
                        $total += ((float)$p->price) * ((int)$it['quantity']);
                    }

                    $order = Order::create([
                        'user_id'          => $userId,
                        'seller_id'        => (int)$sellerId,
                        'order_number'     => 'ORD-' . now()->format('YmdHis') . '-' . $userId . '-' . Str::upper(Str::random(4)),
                        'total_amount'     => $total,
                        'payment_method'   => $request->payment_method,
                        'status'           => 'pending',
                        'shipping_address' => $request->address,       // ✅ FIX FIELD
                        'payment_status'   => 'unpaid',
                    ]);

                    foreach ($sellerItems as $it) {
                        $p = $products->get($it['product_id']);
                        $qty = (int)$it['quantity'];

                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $p->id,
                            'quantity' => $qty,
                            'price' => (float)$p->price,
                        ]);

                        $p->decrement('stock', $qty);
                    }

                    $created[] = $order;
                }

                return collect($created)->pluck('order_number')->values()->all();
            });

            return response()->json([
                'success' => true,
                'order_id' => $res[0] ?? null,
                'order_numbers' => $res,
                'message' => 'Order saved successfully'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
