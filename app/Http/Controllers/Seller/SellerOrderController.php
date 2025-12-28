<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;

class SellerOrderController extends Controller
{
    public function index()
    {
        return view('seller.orders');
    }

    public function show($id)
    {
        return view('seller.order-detail', compact('id'));
    }

    public function updateStatus($id)
    {
        return back()->with('success', "Status order $id diupdate (dummy)");
    }
}
