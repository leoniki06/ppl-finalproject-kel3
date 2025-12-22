<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        // Redirect ke profile page dengan anchor #orders
        return redirect()->route('profile')->with('scroll_to', 'orders');

        // Atau jika tetap ingin view terpisah:
        // return view('profile'); // Ganti 'orders' dengan 'profile'
    }

    public function store(Request $request)
    {
        // Simpan order ke database
        $request->validate([
            'items' => 'required|array',
            'payment_method' => 'required|string',
            'total_amount' => 'required|numeric',
            'address' => 'required|string'
        ]);

        if (Auth::check()) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'LB-' . time() . '-' . rand(1000, 9999),
                'total_amount' => $request->total_amount,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
                'delivery_address' => $request->address,
                'notes' => $request->notes ?? ''
            ]);

            return response()->json([
                'success' => true,
                'order_id' => $order->order_number,
                'message' => 'Order saved successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User not authenticated'
        ]);
    }
}
