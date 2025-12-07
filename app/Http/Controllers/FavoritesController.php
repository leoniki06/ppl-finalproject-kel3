<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function index()
    {
        // Untuk sementara, tampilkan halaman favorites kosong
        return view('favorites.index');
    }

    public function add(Request $request)
    {
        // Logika untuk menambah ke favorites
    }

    public function remove(Request $request)
    {
        // Logika untuk menghapus dari favorites
    }
}
