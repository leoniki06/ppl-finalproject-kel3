<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;

class SellerPayoutController extends Controller
{
    public function index()
    {
        $sellerId = auth()->id();

        $pendingBalance = Order::where('seller_id', $sellerId)
            ->where('status', 'pending')
            ->sum('total_amount');

        $availableBalance = Order::where('seller_id', $sellerId)
            ->where('status', 'completed')
            ->sum('total_amount');

        $nextPayout = $availableBalance * 0.6;

        $transactions = Order::where('seller_id', $sellerId)
            ->latest()
            ->take(10)
            ->get();

        // ✅ INI YANG FIX ERROR KAMU
        return view('seller.payouts', compact(
            'availableBalance',
            'pendingBalance',
            'nextPayout',
            'transactions'
        ));
    }

    public function withdraw()
    {
        return back()->with('success', 'Permintaan payout dikirim (dummy)');
    }
}
