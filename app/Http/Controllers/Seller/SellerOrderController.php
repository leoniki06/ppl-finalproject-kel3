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
        ->where('seller_id', $sellerId) // ✅ 1 order = 1 seller (ini kuncinya)
        ->when($q, function ($query) use ($q) {
            $query->where(function ($qq) use ($q) {
                $qq->where('order_number', 'like', "%{$q}%")
                   ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$q}%"));
            });
        })
        ->when($status, fn($query) => $query->where('status', $status))
        ->when($pay, fn($query) => $query->where('payment_status', $pay))
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
}