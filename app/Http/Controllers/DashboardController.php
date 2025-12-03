<?php
// File: app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Hanya user yang sudah login
    }

    public function index()
    {
        $user = auth()->user();
        $flashSaleProducts = Product::all();

        // Tampilkan pesan selamat datang
        session()->flash('welcome', 'Selamat datang, ' . $user->name . '!');

        return view('dashboard', compact('flashSaleProducts', 'user'));
    }
}
