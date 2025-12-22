<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function index()
    {
        // Cek jika ada data checkout di session
        if (!session()->has('checkout_items') && !Auth::check()) {
            return redirect()->route('cart.index')->with('error', 'Please add items to cart first');
        }

        return view('checkout');
    }

    public function process(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'payment_method' => 'required|string',
            'total_amount' => 'required|numeric'
        ]);

        // Simpan ke session untuk guest users
        if (!Auth::check()) {
            session([
                'checkout_data' => [
                    'items' => $request->items,
                    'payment_method' => $request->payment_method,
                    'total_amount' => $request->total_amount,
                    'notes' => $request->notes,
                    'timestamp' => now()
                ]
            ]);

            return response()->json([
                'success' => true,
                'order_id' => 'GUEST-' . time() . '-' . rand(1000, 9999),
                'message' => 'Order processed successfully (guest)'
            ]);
        }

        // Create order untuk user yang login
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => 'LB-' . time() . '-' . rand(1000, 9999),
            'total_amount' => $request->total_amount,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'delivery_address' => Auth::user()->address,
            'notes' => $request->notes
        ]);

        // Create order items
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity']
            ]);
        }

        return response()->json([
            'success' => true,
            'order_id' => $order->order_number,
            'message' => 'Order placed successfully'
        ]);
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string'
        ]);

        // Untuk guest users
        if (strpos($request->order_id, 'GUEST-') === 0) {
            return response()->json([
                'success' => true,
                'message' => 'Payment confirmed successfully (guest)'
            ]);
        }

        // Untuk logged in users
        if (Auth::check()) {
            $order = Order::where('order_number', $request->order_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $order->update(['status' => 'completed']);

            return response()->json([
                'success' => true,
                'message' => 'Payment confirmed successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Authentication required'
        ], 401);
    }
}
