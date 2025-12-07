<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Untuk sementara, tampilkan halaman cart kosong
        return view('cart.index');
    }

    public function add(Request $request)
    {
        // Logika untuk menambah item ke cart
    }

    public function remove(Request $request)
    {
        // Logika untuk menghapus item dari cart
    }
    
    public function update(Request $request)
    {
        // Logika untuk update quantity
    }

    public function checkout(Request $request)
    {
        // Logika untuk checkout
    }
}
