<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // HAPUS dulu jika mau fresh start
        // Product::truncate();

        // Tentukan seller_id yang valid (misal: 1 untuk admin default)
        // Jika database belum ada user, kita akan bypass foreign key sementara
        $sellerId = $this->getOrCreateSeller();

        $products = [
            [
                'name' => 'Chocolate Chip Cookies (Pack of 6)',
                'description' => 'Fresh product with great quality and best price. Perfect for snack time!',
                'price' => 28000,
                'original_price' => 40000,
                'discount_percent' => 30,
                'category' => 'bakery',
                'brand' => 'LastBite',
                'stock' => 50,
                'image_url' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.5,
                'rating_count' => 102,
                'is_flash_sale' => true,
                'expiry_date' => now()->addDays(3),
                'seller_id' => $sellerId,
            ],
            [
                'name' => 'Organic Apples (1kg)',
                'description' => 'Fresh organic apples, slightly past their peak but still delicious and nutritious.',
                'price' => 35000,
                'original_price' => 55000,
                'discount_percent' => 36,
                'category' => 'fruit',
                'brand' => 'LastBite',
                'stock' => 30,
                'image_url' => 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.3,
                'rating_count' => 87,
                'is_flash_sale' => false,
                'expiry_date' => now()->addDays(2),
                'seller_id' => $sellerId,
            ],
            [
                'name' => 'Fresh Milk 1L',
                'description' => 'High quality fresh milk with great taste. Expiring soon but still fresh!',
                'price' => 18000,
                'original_price' => 25000,
                'discount_percent' => 28,
                'category' => 'dairy',
                'brand' => 'LastBite',
                'stock' => 45,
                'image_url' => 'https://images.unsplash.com/photo-1563636619-e9143da7973b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.7,
                'rating_count' => 156,
                'is_flash_sale' => true,
                'expiry_date' => now()->addDays(1),
                'seller_id' => $sellerId,
            ],
            [
                'name' => 'Whole Wheat Bread',
                'description' => 'Freshly baked whole wheat bread. Perfect for breakfast and sandwiches.',
                'price' => 22000,
                'original_price' => 32000,
                'discount_percent' => 31,
                'category' => 'bakery',
                'brand' => 'LastBite',
                'stock' => 60,
                'image_url' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.6,
                'rating_count' => 134,
                'is_flash_sale' => false,
                'expiry_date' => now()->addDays(2),
                'seller_id' => $sellerId,
            ],
            [
                'name' => 'Banana (1kg)',
                'description' => 'Sweet ripe bananas, great for smoothies and snacks. Slight brown spots but perfectly edible.',
                'price' => 15000,
                'original_price' => 22000,
                'discount_percent' => 32,
                'category' => 'fruit',
                'brand' => 'LastBite',
                'stock' => 40,
                'image_url' => 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.4,
                'rating_count' => 98,
                'is_flash_sale' => true,
                'expiry_date' => now()->addDays(1),
                'seller_id' => $sellerId,
            ],
            [
                'name' => 'Croissant (Pack of 4)',
                'description' => 'Buttery and flaky croissants, freshly baked this morning. Perfect with coffee!',
                'price' => 32000,
                'original_price' => 48000,
                'discount_percent' => 33,
                'category' => 'bakery',
                'brand' => 'LastBite',
                'stock' => 25,
                'image_url' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.8,
                'rating_count' => 176,
                'is_flash_sale' => false,
                'expiry_date' => now()->addDays(2),
                'seller_id' => $sellerId,
            ],
            [
                'name' => 'Greek Yogurt 500g',
                'description' => 'Creamy Greek yogurt with high protein content. Healthy breakfast option!',
                'price' => 25000,
                'original_price' => 35000,
                'discount_percent' => 29,
                'category' => 'dairy',
                'brand' => 'LastBite',
                'stock' => 35,
                'image_url' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.5,
                'rating_count' => 123,
                'is_flash_sale' => true,
                'expiry_date' => now()->addDays(3),
                'seller_id' => $sellerId,
            ],
            [
                'name' => 'Mixed Vegetables (500g)',
                'description' => 'Fresh mixed vegetables including carrots, broccoli, and cauliflower. Great for stir-fry!',
                'price' => 20000,
                'original_price' => 30000,
                'discount_percent' => 33,
                'category' => 'vegetable',
                'brand' => 'LastBite',
                'stock' => 55,
                'image_url' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.2,
                'rating_count' => 89,
                'is_flash_sale' => false,
                'expiry_date' => now()->addDays(2),
                'seller_id' => $sellerId,
            ],
            [
                'name' => 'Artisan Sourdough Bread',
                'description' => 'Freshly baked sourdough bread, crusty exterior with soft interior.',
                'price' => 25000,
                'original_price' => 45000,
                'discount_percent' => 44,
                'category' => 'bakery',
                'brand' => 'BreadTalk',
                'stock' => 15,
                'image_url' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.7,
                'rating_count' => 128,
                'is_flash_sale' => true,
                'expiry_date' => now()->addDays(2),
                'seller_id' => $sellerId,
            ],
            [
                'name' => 'French Croissants (Pack of 4)',
                'description' => 'Buttery, flaky croissants perfect for breakfast.',
                'price' => 32000,
                'original_price' => 55000,
                'discount_percent' => 42,
                'category' => 'bakery',
                'brand' => 'Holland Bakery',
                'stock' => 8,
                'image_url' => 'https://images.unsplash.com/photo-1555507036-ab794f27d2e9?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.8,
                'rating_count' => 95,
                'is_flash_sale' => true,
                'expiry_date' => now()->addDays(1),
                'seller_id' => $sellerId,
            ],
            [
                'name' => 'Cheddar Cheese Block (200g)',
                'description' => 'Aged cheddar cheese, sharp and flavorful.',
                'price' => 38000,
                'original_price' => 52000,
                'discount_percent' => 27,
                'category' => 'dairy',
                'brand' => 'Kraft',
                'stock' => 11,
                'image_url' => 'https://images.unsplash.com/photo-1552767059-ce182ead6c1b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.5,
                'rating_count' => 87,
                'is_flash_sale' => false,
                'expiry_date' => now()->addDays(7),
                'seller_id' => $sellerId,
            ],
            [
                'name' => 'Whole Chicken (1.5kg)',
                'description' => 'Fresh whole chicken, perfect for roasting or grilling.',
                'price' => 75000,
                'original_price' => 95000,
                'discount_percent' => 21,
                'category' => 'meat',
                'brand' => 'Farm Fresh',
                'stock' => 5,
                'image_url' => 'https://images.unsplash.com/photo-1602476524182-2cf6586b1021?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.7,
                'rating_count' => 112,
                'is_flash_sale' => false,
                'expiry_date' => now()->addDays(2),
                'seller_id' => $sellerId,
            ],
        ];

        // Insert products - gunakan DB::table untuk bypass model validation jika perlu
        foreach ($products as $product) {
            // Cek apakah produk sudah ada
            $existing = Product::where('name', $product['name'])->first();
            if (!$existing) {
                Product::create($product);
            }
        }

        $this->command->info(count($products) . ' products seeded successfully!');
    }

    /**
     * Get or create seller user
     */
    private function getOrCreateSeller()
    {
        // Coba ambil user pertama yang ada
        $user = DB::table('users')->first();

        if ($user) {
            return $user->id;
        }

        // Jika tidak ada user, coba buat dulu (temporary bypass foreign key)
        try {
            $userId = DB::table('users')->insertGetId([
                'name' => 'System Seller',
                'email' => 'system@lastbite.com',
                'password' => bcrypt('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return $userId;
        } catch (\Exception $e) {
            // Jika masih gagal, gunakan ID 1 (temporary)
            return 1;
        }
    }
}
