<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = auth()->id();

        $q = $request->query('q');
        $status = $request->query('status');
        $pay = $request->query('pay');
        $sort = $request->query('sort', 'latest');

        $orders = Order::query()
            ->with(['user', 'items.product'])
            ->withCount('items')
            ->where('seller_id', $sellerId)
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('order_number', 'like', "%{$q}%")
                        ->orWhereHas('user', function ($u) use ($q) {
                            $u->where('name', 'like', "%{$q}%");
                        });
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($pay, function ($query) use ($pay) {
                $query->where('payment_status', $pay);
            })
            ->when($sort, function ($query) use ($sort) {
                return match ($sort) {
                    'oldest' => $query->oldest(),
                    'total_desc' => $query->orderBy('total_amount', 'desc'),
                    'total_asc' => $query->orderBy('total_amount', 'asc'),
                    default => $query->latest(),
                };
            })
            ->paginate(10)
            ->withQueryString();

        return view('seller.orders.index', compact('orders', 'q', 'status', 'pay', 'sort'));
    }

    public function show($id)
    {
        $sellerId = auth()->id();

        $order = Order::with(['user', 'items.product'])
            ->withCount('items')
            ->where('seller_id', $sellerId)
            ->findOrFail($id);

        return view('seller.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $sellerId = auth()->id();

        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled'
        ]);

        $order = Order::where('seller_id', $sellerId)->findOrFail($id);

        $order->status = $request->status;

        if ($request->status === 'processing') {
            $order->processed_at = now();
        }

        if ($request->status === 'shipped') {
            $order->shipped_at = now();
        }

        if ($request->status === 'completed') {
            $order->completed_at = now();
        }

        $order->save();

        return back()->with('success', 'Status pesanan berhasil diupdate.');
    }

    public function markPaid($id)
    {
        $sellerId = auth()->id();

        $order = Order::where('seller_id', $sellerId)->findOrFail($id);

        $order->payment_status = 'paid';
        $order->paid_at = now();
        $order->save();

        return back()->with('success', 'Pembayaran COD berhasil dikonfirmasi.');
    }
}
