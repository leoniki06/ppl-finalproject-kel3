<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;

class SellerPayoutController extends Controller
{
    public function index()
    {
        return view('seller.payouts');
    }

    public function withdraw()
    {
        return back()->with('success', 'Permintaan payout dikirim (dummy)');
    }
}
