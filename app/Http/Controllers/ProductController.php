<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::query()
            ->where('is_active', true)
            ->whereKey($id)
            ->firstOrFail();

        $recommendedProducts = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->where('id', '!=', $product->id)
            ->where(function ($q) {
                $q->whereNull('expiry_date')
                  ->orWhereDate('expiry_date', '>=', now()->toDateString());
            })
            ->orderByDesc('rating')
            ->orderByDesc('rating_count')
            ->limit(4)
            ->get();

        // Impact: tetap seperti punyamu (ini bukan dummy gambar; ini angka kategori)
        $impact = $this->calculateImpact($product);

        return view('products.show', compact('product', 'recommendedProducts', 'impact'));
    }

    private function calculateImpact($product)
    {
        $impacts = [
            'bakery' => ['co2_saved' => '8.2', 'water_saved' => '280', 'food_saved' => '1.8'],
            'dairy'  => ['co2_saved' => '10.5', 'water_saved' => '320', 'food_saved' => '2.1'],
            'fruits' => ['co2_saved' => '5.7', 'water_saved' => '180', 'food_saved' => '1.2'],
            'meat'   => ['co2_saved' => '25.3', 'water_saved' => '850', 'food_saved' => '3.5'],
        ];

        $category = $product->category ?? 'bakery';
        return $impacts[$category] ?? ['co2_saved' => '12.5', 'water_saved' => '380', 'food_saved' => '2.5'];
    }
}
