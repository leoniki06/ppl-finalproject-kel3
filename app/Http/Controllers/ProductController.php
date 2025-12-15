<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Show product details
     */
    public function show($id)
    {
        try {
            // Find the product - jika tidak ada di database, gunakan dummy
            $product = Product::find($id);

            // Jika produk tidak ditemukan di database, gunakan dummy data
            if (!$product) {
                $product = $this->createDummyProduct($id);
            }

            // DAPATKAN SEMUA PRODUK DUMMY untuk rekomendasi
            $allDummyProducts = $this->getAllDummyProducts();

            // Konversi $product ke array jika perlu
            $productArray = is_object($product) ? (array) $product : $product;
            $productId = is_object($product) ? $product->id : $product['id'];

            // Filter produk rekomendasi (exclude produk yang sedang dilihat)
            $recommendedProducts = array_filter($allDummyProducts, function ($prod) use ($productId) {
                $prodId = is_array($prod) ? $prod['id'] : $prod->id;
                return $prodId != $productId;
            });

            // Acak dan ambil 4 produk
            shuffle($recommendedProducts);
            $recommendedProducts = array_slice($recommendedProducts, 0, 4);

            // Konversi ke collection untuk view (pastikan sebagai object)
            $recommendedProducts = collect($recommendedProducts)->map(function ($item) {
                return is_array($item) ? (object) $item : $item;
            });

            // Pastikan $product sebagai object
            if (is_array($product)) {
                $product = (object) $product;
            }

            // Calculate positive impact
            $impact = $this->calculateImpact($product);

            return view('products.show', compact('product', 'recommendedProducts', 'impact'));
        } catch (\Exception $e) {
            // Fallback jika error
            $product = $this->createDummyProduct($id);

            // Ambil dummy products untuk rekomendasi
            $allDummyProducts = $this->getAllDummyProducts();

            // Filter produk
            $recommendedProducts = array_filter($allDummyProducts, function ($prod) use ($id) {
                $prodId = is_array($prod) ? $prod['id'] : $prod->id;
                return $prodId != $id;
            });

            shuffle($recommendedProducts);
            $recommendedProducts = array_slice($recommendedProducts, 0, 4);

            // Konversi ke object
            $recommendedProducts = collect($recommendedProducts)->map(function ($item) {
                return is_array($item) ? (object) $item : $item;
            });

            // Pastikan $product sebagai object
            if (is_array($product)) {
                $product = (object) $product;
            }

            $impact = $this->calculateImpact($product);

            return view('products.show', compact('product', 'recommendedProducts', 'impact'));
        }
    }

    /**
     * Get all dummy products (flash sale + recommended)
     */
    private function getAllDummyProducts()
    {
        // Kumpulkan semua produk dummy sebagai array
        $allProducts = [];

        // Tambahkan semua produk dari ID 1-12
        for ($i = 1; $i <= 12; $i++) {
            $product = $this->createDummyProduct($i);
            if ($product) {
                // Konversi object ke array untuk konsistensi
                $allProducts[] = is_object($product) ? (array) $product : $product;
            }
        }

        return $allProducts;
    }

    // app/Http/Controllers/ProductController.php
    public function search(Request $request)
    {
        try {
            $query = Product::query();

            // Search by name or description
            if ($request->has('q') && !empty($request->q)) {
                $searchTerm = $request->q;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('description', 'LIKE', "%{$searchTerm}%");
                });
            }

            // Filter by price
            if ($request->has('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }
            if ($request->has('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }

            // Filter by rating
            if ($request->has('min_rating')) {
                $query->where('rating', '>=', $request->min_rating);
            }

            // Filter by categories
            if ($request->has('categories') && !empty($request->categories)) {
                $categories = explode(',', $request->categories);
                $query->whereIn('category', $categories);
            }

            // Only show available products
            $query->where('stock', '>', 0);

            $products = $query->take(50)->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'products' => $products,
                    'total' => $products->count()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error searching products'
            ], 500);
        }
    }

    /**
     * Create dummy product for testing - KEMBALIKAN SEBAGAI OBJECT
     */
    private function createDummyProduct($id)
    {
        $dummyProducts = [
            1 => [
                'id' => 1,
                'name' => 'Artisan Sourdough Bread',
                'description' => 'Freshly baked sourdough bread, crusty exterior with soft interior. Best consumed within 2 days. Perfect for breakfast or as a side with soup.',
                'price' => 25000,
                'original_price' => 45000,
                'discount_percent' => 44,
                'category' => 'bakery',
                'brand' => 'BreadTalk',
                'image_url' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.7,
                'rating_count' => 128,
                'stock' => 15,
                'sold_count' => 342,
                'is_flash_sale' => true,
                'expiry_date' => now()->addDays(2),
            ],
            2 => [
                'id' => 2,
                'name' => 'French Croissants (Pack of 4)',
                'description' => 'Buttery, flaky croissants perfect for breakfast. Made with real butter and baked fresh daily. Enjoy with coffee or tea.',
                'price' => 32000,
                'original_price' => 55000,
                'discount_percent' => 42,
                'category' => 'bakery',
                'brand' => 'Holland Bakery',
                'image_url' => 'https://images.unsplash.com/photo-1555507036-ab794f27d2e9?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.8,
                'rating_count' => 95,
                'stock' => 8,
                'sold_count' => 210,
                'is_flash_sale' => true,
                'expiry_date' => now()->addDays(1),
            ],
            3 => [
                'id' => 3,
                'name' => 'Fresh Milk 1L',
                'description' => 'Fresh pasteurized milk from local dairy farms. Rich in calcium and essential nutrients. Perfect for cereal, coffee, or drinking straight.',
                'price' => 18000,
                'original_price' => 28000,
                'discount_percent' => 36,
                'category' => 'dairy',
                'brand' => 'Greenfields',
                'image_url' => 'https://images.unsplash.com/photo-1563636619-e9143da7973b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.5,
                'rating_count' => 76,
                'stock' => 12,
                'sold_count' => 189,
                'is_flash_sale' => true,
                'expiry_date' => now()->addDays(3),
            ],
            4 => [
                'id' => 4,
                'name' => 'Greek Yogurt (500g)',
                'description' => 'Creamy Greek yogurt, high in protein and probiotics. Great for smoothies, breakfast bowls, or as a healthy snack.',
                'price' => 22000,
                'original_price' => 35000,
                'discount_percent' => 37,
                'category' => 'dairy',
                'brand' => 'Yoplait',
                'image_url' => 'https://images.unsplash.com/photo-1567306300913-3def25b4c99b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.6,
                'rating_count' => 89,
                'stock' => 6,
                'sold_count' => 156,
                'is_flash_sale' => true,
                'expiry_date' => now()->addDays(2),
            ],
            5 => [
                'id' => 5,
                'name' => 'Organic Apples (1kg)',
                'description' => 'Fresh organic apples, crisp and sweet. Perfect for snacking, baking, or making juice. No pesticides used.',
                'price' => 35000,
                'original_price' => 45000,
                'discount_percent' => 22,
                'category' => 'fruits',
                'brand' => 'Fresh Market',
                'image_url' => 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.9,
                'rating_count' => 210,
                'stock' => 25,
                'sold_count' => 456,
                'is_flash_sale' => false,
                'expiry_date' => now()->addDays(5),
            ],
            6 => [
                'id' => 6,
                'name' => 'Premium Beef Steak (300g)',
                'description' => 'High-quality beef steak, tender and flavorful. Perfect for grilling or pan-searing. Source from local farms.',
                'price' => 65000,
                'original_price' => 85000,
                'discount_percent' => 24,
                'category' => 'meat',
                'brand' => 'Meat Master',
                'image_url' => 'https://images.unsplash.com/photo-1604503468505-1d2d6a9a6c8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.8,
                'rating_count' => 167,
                'stock' => 10,
                'sold_count' => 289,
                'is_flash_sale' => false,
                'expiry_date' => now()->addDays(2),
            ],
            7 => [
                'id' => 7,
                'name' => 'Chocolate Chip Cookies (Pack of 6)',
                'description' => 'Soft and chewy cookies with rich chocolate chips. Made with real butter and premium chocolate. Perfect with milk.',
                'price' => 28000,
                'original_price' => 40000,
                'discount_percent' => 30,
                'category' => 'bakery',
                'brand' => 'Mrs. Fields',
                'image_url' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.7,
                'rating_count' => 142,
                'stock' => 18,
                'sold_count' => 321,
                'is_flash_sale' => false,
                'expiry_date' => now()->addDays(3),
            ],
            8 => [
                'id' => 8,
                'name' => 'Fresh Orange Juice (1L)',
                'description' => '100% pure orange juice, no added sugar or preservatives. Freshly squeezed and pasteurized for maximum freshness.',
                'price' => 32000,
                'original_price' => 42000,
                'discount_percent' => 24,
                'category' => 'fruits',
                'brand' => 'Tropicana',
                'image_url' => 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.6,
                'rating_count' => 98,
                'stock' => 14,
                'sold_count' => 234,
                'is_flash_sale' => false,
                'expiry_date' => now()->addDays(2),
            ],
            9 => [
                'id' => 9,
                'name' => 'Salmon Fillet (250g)',
                'description' => 'Fresh salmon fillet, rich in omega-3 fatty acids. Perfect for grilling, baking, or pan-searing. Source from sustainable fisheries.',
                'price' => 55000,
                'original_price' => 75000,
                'discount_percent' => 27,
                'category' => 'meat',
                'brand' => 'Ocean Fresh',
                'image_url' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.9,
                'rating_count' => 189,
                'stock' => 7,
                'sold_count' => 198,
                'is_flash_sale' => false,
                'expiry_date' => now()->addDays(1),
            ],
            10 => [
                'id' => 10,
                'name' => 'Mixed Berries (500g)',
                'description' => 'Fresh strawberries, blueberries, and raspberries. Perfect for smoothies, desserts, or as a healthy snack.',
                'price' => 45000,
                'original_price' => 60000,
                'discount_percent' => 25,
                'category' => 'fruits',
                'brand' => 'Berry Best',
                'image_url' => 'https://images.unsplash.com/photo-1488459716781-31db52582fe9?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.8,
                'rating_count' => 123,
                'stock' => 9,
                'sold_count' => 176,
                'is_flash_sale' => false,
                'expiry_date' => now()->addDays(2),
            ],
            11 => [
                'id' => 11,
                'name' => 'Cheddar Cheese Block (200g)',
                'description' => 'Aged cheddar cheese, sharp and flavorful. Perfect for sandwiches, burgers, or cheese boards.',
                'price' => 38000,
                'original_price' => 52000,
                'discount_percent' => 27,
                'category' => 'dairy',
                'brand' => 'Kraft',
                'image_url' => 'https://images.unsplash.com/photo-1552767059-ce182ead6c1b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.5,
                'rating_count' => 87,
                'stock' => 11,
                'sold_count' => 143,
                'is_flash_sale' => false,
                'expiry_date' => now()->addDays(7),
            ],
            12 => [
                'id' => 12,
                'name' => 'Whole Chicken (1.5kg)',
                'description' => 'Fresh whole chicken, perfect for roasting or grilling. Source from free-range farms. No hormones or antibiotics.',
                'price' => 75000,
                'original_price' => 95000,
                'discount_percent' => 21,
                'category' => 'meat',
                'brand' => 'Farm Fresh',
                'image_url' => 'https://images.unsplash.com/photo-1602476524182-2cf6586b1021?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'rating' => 4.7,
                'rating_count' => 112,
                'stock' => 5,
                'sold_count' => 89,
                'is_flash_sale' => false,
                'expiry_date' => now()->addDays(2),
            ],
        ];

        // Check if product ID exists in dummy data
        if (isset($dummyProducts[$id])) {
            // Kembalikan sebagai object untuk konsistensi
            return (object) $dummyProducts[$id];
        }

        // Default product if ID not found
        return (object) [
            'id' => $id,
            'name' => 'Product ' . $id,
            'description' => 'This is a sample product description.',
            'price' => 25000,
            'original_price' => 45000,
            'discount_percent' => 44,
            'category' => 'bakery',
            'brand' => 'LastBite',
            'image_url' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
            'rating' => 4.5,
            'rating_count' => 100,
            'stock' => 10,
            'sold_count' => 200,
            'is_flash_sale' => $id <= 4,
            'expiry_date' => now()->addDays(3),
        ];
    }

    /**
     * Calculate positive impact of saving food
     */
    private function calculateImpact($product)
    {
        // Simple impact calculation based on product weight/category
        $impacts = [
            'bakery' => ['co2_saved' => '8.2', 'water_saved' => '280', 'food_saved' => '1.8'],
            'dairy' => ['co2_saved' => '10.5', 'water_saved' => '320', 'food_saved' => '2.1'],
            'fruits' => ['co2_saved' => '5.7', 'water_saved' => '180', 'food_saved' => '1.2'],
            'meat' => ['co2_saved' => '25.3', 'water_saved' => '850', 'food_saved' => '3.5'],
        ];

        // Akses category dengan benar baik dari object maupun array
        if (is_object($product)) {
            $category = $product->category ?? 'bakery';
        } else {
            $category = $product['category'] ?? 'bakery';
        }

        return $impacts[$category] ?? ['co2_saved' => '12.5', 'water_saved' => '380', 'food_saved' => '2.5'];
    }
}
