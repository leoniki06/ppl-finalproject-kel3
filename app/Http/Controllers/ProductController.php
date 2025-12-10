<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        try {
            // Ambil produk flash sale (maksimal 5)
            $flashSaleProducts = Product::where('is_flash_sale', true)
                ->where('stock', '>', 0)
                ->where('expiry_date', '>', now())
                ->orderBy('discount_percent', 'desc')
                ->take(5)
                ->get();

            // Jika tidak ada produk flash sale, ambil beberapa produk dengan diskon tertinggi
            if ($flashSaleProducts->isEmpty()) {
                $flashSaleProducts = Product::where('stock', '>', 0)
                    ->where('expiry_date', '>', now())
                    ->where('discount_percent', '>', 20)
                    ->orderBy('discount_percent', 'desc')
                    ->take(5)
                    ->get();
            }

            // Ambil produk rekomendasi (maksimal 8)
            $recommendedProducts = Product::where('is_recommended', true)
                ->where('stock', '>', 0)
                ->where('expiry_date', '>', now())
                ->orderBy('rating', 'desc')
                ->take(8)
                ->get();

            // Jika produk rekomendasi kurang dari 4, tambahkan produk terbaik lainnya
            if ($recommendedProducts->count() < 4) {
                $additionalProducts = Product::where('stock', '>', 0)
                    ->where('expiry_date', '>', now())
                    ->whereNotIn('id', $recommendedProducts->pluck('id'))
                    ->orderBy('rating', 'desc')
                    ->orderBy('discount_percent', 'desc')
                    ->take(8 - $recommendedProducts->count())
                    ->get();

                $recommendedProducts = $recommendedProducts->merge($additionalProducts);
            }

            // Data hero slides
            $heroSlides = [
                [
                    'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                    'tagline' => 'Reducing Food Waste, One Bite at a Time',
                    'title' => 'Wasting Food?',
                    'subtitle' => 'LastBite Here',
                    'description' => 'Fresh food at amazing prices while saving the planet'
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1563636619-e9143da7973b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                    'tagline' => 'Limited Time Offer!',
                    'title' => 'Big Food Sale',
                    'subtitle' => 'Up to 50% OFF!',
                    'description' => 'Redefine your everyday meals with fresh ingredients'
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                    'tagline' => 'Fresh & Healthy',
                    'title' => 'Organic Collection',
                    'subtitle' => 'Farm to Table',
                    'description' => 'Quality produce delivered to your doorstep'
                ],
            ];

            // Kategori
            $categories = [
                ['id' => 'bakery', 'name' => 'Bakery & Bread', 'icon' => 'fas fa-bread-slice'],
                ['id' => 'dairy', 'name' => 'Dairy Products', 'icon' => 'fas fa-wine-bottle'],
                ['id' => 'fruits', 'name' => 'Fruits & Vegetables', 'icon' => 'fas fa-apple-alt'],
                ['id' => 'meat', 'name' => 'Meat & Fish', 'icon' => 'fas fa-drumstick-bite'],
            ];

            return view('dashboard', compact(
                'flashSaleProducts',
                'recommendedProducts',
                'categories',
                'heroSlides'
            ));

        } catch (\Exception $e) {
            // Fallback jika ada error
            $flashSaleProducts = collect();
            $recommendedProducts = collect();

            $categories = [
                ['id' => 'bakery', 'name' => 'Bakery & Bread', 'icon' => 'fas fa-bread-slice'],
                ['id' => 'dairy', 'name' => 'Dairy Products', 'icon' => 'fas fa-wine-bottle'],
                ['id' => 'fruits', 'name' => 'Fruits & Vegetables', 'icon' => 'fas fa-apple-alt'],
                ['id' => 'meat', 'name' => 'Meat & Fish', 'icon' => 'fas fa-drumstick-bite'],
            ];

            $heroSlides = [
                [
                    'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                    'tagline' => 'Welcome to LastBite',
                    'title' => 'Reducing Food Waste',
                    'subtitle' => 'Save Money, Save Planet',
                    'description' => 'Fresh food at amazing prices'
                ]
            ];

            return view('dashboard', compact(
                'flashSaleProducts',
                'recommendedProducts',
                'categories',
                'heroSlides'
            ));
        }
    }

    // Detail produk
    public function show($id)
    {
        $product = Product::with('seller')
            ->where('stock', '>', 0)
            ->where('expiry_date', '>', now())
            ->findOrFail($id);

        // Produk rekomendasi dari kategori yang sama (kecuali produk saat ini)
        $recommendedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->where('expiry_date', '>', now())
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Jika produk rekomendasi kurang, tambahkan produk dari kategori lain
        if ($recommendedProducts->count() < 4) {
            $additionalProducts = Product::where('category', '!=', $product->category)
                ->where('id', '!=', $product->id)
                ->where('stock', '>', 0)
                ->where('expiry_date', '>', now())
                ->inRandomOrder()
                ->take(4 - $recommendedProducts->count())
                ->get();

            $recommendedProducts = $recommendedProducts->merge($additionalProducts);
        }

        // Hitung impact berdasarkan kategori
        $impact = $this->calculateImpact($product->category);

        return view('products.show', compact('product', 'recommendedProducts', 'impact'));
    }

    // Fungsi untuk menghitung impact berdasarkan kategori
    private function calculateImpact($category)
    {
        switch ($category) {
            case 'bakery':
                return [
                    'co2_saved' => 1.2,
                    'water_saved' => 400,
                    'food_saved' => 0.8,
                ];
            case 'dairy':
                return [
                    'co2_saved' => 2.5,
                    'water_saved' => 800,
                    'food_saved' => 1.2,
                ];
            case 'fruits':
                return [
                    'co2_saved' => 0.8,
                    'water_saved' => 300,
                    'food_saved' => 0.5,
                ];
            case 'meat':
                return [
                    'co2_saved' => 5.0,
                    'water_saved' => 1500,
                    'food_saved' => 2.0,
                ];
            default:
                return [
                    'co2_saved' => 1.5,
                    'water_saved' => 500,
                    'food_saved' => 1.0,
                ];
        }
    }
}
