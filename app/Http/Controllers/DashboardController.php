<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Get flash sale products (products with discount > 20%)
            $flashSaleProducts = Product::where('discount_percent', '>=', 20)
                ->where('stock', '>', 0)
                ->orderBy('discount_percent', 'DESC')
                ->limit(10)
                ->get();

            // Get recommended products (top rated or featured)
            $recommendedProducts = Product::where('rating', '>=', 4.0)
                ->where('stock', '>', 0)
                ->orderBy('rating', 'DESC')
                ->orderBy('sold_count', 'DESC')
                ->limit(12)
                ->get();

            // Jika tidak ada produk yang recommended, ambil random products
            if ($recommendedProducts->isEmpty()) {
                $recommendedProducts = Product::where('stock', '>', 0)
                    ->inRandomOrder()
                    ->limit(12)
                    ->get();
            }

            // Hero slides data
            $heroSlides = [
                [
                    'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                    'tagline' => 'Reducing Food Waste, One Bite at a Time',
                    'title' => 'Welcome to LastBite',
                    'subtitle' => 'Fresh Food, Lower Prices',
                    'description' => 'Save money while saving the planet from food waste'
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                    'tagline' => 'Fresh & Delicious',
                    'title' => 'Near-Expiry Foods',
                    'subtitle' => 'Up to 70% Off',
                    'description' => 'High-quality food at unbeatable prices'
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1563636619-e9143da7973b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                    'tagline' => 'Sustainable Eating',
                    'title' => 'Eco-Friendly Choice',
                    'subtitle' => 'Help Reduce Food Waste',
                    'description' => 'Join our mission to save perfectly good food from landfills'
                ]
            ];

            return view('dashboard', compact(
                'flashSaleProducts',
                'recommendedProducts',
                'heroSlides'
            ));

        } catch (\Exception $e) {
            // Fallback jika ada error
            $flashSaleProducts = collect();
            $recommendedProducts = collect();
            $heroSlides = [];

            return view('dashboard', compact(
                'flashSaleProducts',
                'recommendedProducts',
                'heroSlides'
            ));
        }
    }
}
