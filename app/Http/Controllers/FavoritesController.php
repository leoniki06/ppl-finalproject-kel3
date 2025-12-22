<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get user's favorites
        $favorites = Favorite::where('user_id', $user->id)
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        // Jika menggunakan localStorage frontend, gunakan view yang berbeda
        return view('favorites', [
            'user' => $user,
            'favorites' => $favorites
        ]);
    }

    public function toggle(Request $request)
    {
        $user = Auth::user();
        $productId = $request->input('product_id');

        // Cek apakah produk sudah difavoritkan
        $existing = Favorite::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            // Hapus dari favorites
            $existing->delete();
            $isFavorite = false;
            $message = 'Removed from favorites';
        } else {
            // Tambah ke favorites
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $productId
            ]);
            $isFavorite = true;
            $message = 'Added to favorites';
        }

        return response()->json([
            'success' => true,
            'is_favorite' => $isFavorite,
            'message' => $message,
            'count' => Favorite::where('user_id', $user->id)->count()
        ]);
    }

    public function remove($id)
    {
        $user = Auth::user();

        $favorite = Favorite::where('user_id', $user->id)
            ->where('id', $id)
            ->first();

        if ($favorite) {
            $favorite->delete();
        }

        return redirect()->route('favorites')
            ->with('success', 'Item removed from favorites');
    }

    public function clear(Request $request)
    {
        $user = Auth::user();

        Favorite::where('user_id', $user->id)->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'All favorites cleared'
            ]);
        }

        return redirect()->route('favorites')
            ->with('success', 'All favorites cleared');
    }

    public function count()
    {
        $user = Auth::user();
        $count = Favorite::where('user_id', $user->id)->count();

        return response()->json([
            'count' => $count
        ]);
    }

    public function checkStatus($productId)
    {
        $user = Auth::user();
        $isFavorite = Favorite::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();

        return response()->json([
            'is_favorite' => $isFavorite
        ]);
    }

    public function list()
    {
        $user = Auth::user();

        $favorites = Favorite::where('user_id', $user->id)
            ->with(['product' => function ($query) {
                $query->select('id', 'name', 'price', 'discounted_price', 'image', 'category', 'expiry_date');
            }])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($favorite) {
                return [
                    'id' => $favorite->product->id,
                    'name' => $favorite->product->name,
                    'price' => $favorite->product->price,
                    'discounted_price' => $favorite->product->discounted_price,
                    'image' => $favorite->product->image,
                    'category' => $favorite->product->category,
                    'expiry_date' => $favorite->product->expiry_date,
                    'added_at' => $favorite->created_at->toISOString()
                ];
            });

        return response()->json($favorites);
    }
}
