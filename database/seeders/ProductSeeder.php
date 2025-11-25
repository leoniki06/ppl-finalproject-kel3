<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [];

        for ($i = 15; $i <= 31; $i++) {
            $products[] = [
                'name' => $i % 2 == 0 ? 'Rot1 Sisir' : 'Rp20k',
                'price' => 'Rp20k',
                'store' => 'Holland Bakery',
                'rating' => 5,
                'review_count' => 35,
                'cart_count' => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Product::insert($products);
    }
}
