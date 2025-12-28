<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;

class SellerStoreController extends Controller
{
    public function edit()
    {
        return view('seller.store-profile');
    }

    public function update()
    {
        return back()->with('success', 'Profil toko berhasil disimpan (dummy)');
    }
}
