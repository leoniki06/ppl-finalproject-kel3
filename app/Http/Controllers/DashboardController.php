<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Base rule: aktif, stok > 0, belum expired
        $base = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->whereDate('expiry_date', '>=', now()->toDateString());

        // Ambil selected category dari query string (mis: ?category=bakery)
        $selectedCategory = trim((string) $request->query('category', ''));

        // Flash sale = flag atau diskon >= 20
        $flashSaleProducts = (clone $base)
            ->where(function ($q) {
                $q->where('is_flash_sale', true)
                    ->orWhere('discount_percent', '>=', 20);
            })
            ->orderByDesc('discount_percent')
            ->limit(10)
            ->get();

        // Recommended = flag recommended, kalau kosong fallback ke rating terbaik
        $recommendedQuery = (clone $base)
            ->where('is_recommended', true);

        // Jika user klik kategori, filter rekomendasi berdasarkan category DB
        if ($selectedCategory !== '') {
            $recommendedQuery->where('category', $selectedCategory);
        }

        $recommendedProducts = $recommendedQuery
            ->orderByDesc('rating')
            ->orderByDesc('rating_count')
            ->limit(12)
            ->get();

        if ($recommendedProducts->isEmpty()) {
            $fallbackQuery = (clone $base);

            if ($selectedCategory !== '') {
                $fallbackQuery->where('category', $selectedCategory);
            }

            $recommendedProducts = $fallbackQuery
                ->orderByDesc('rating')
                ->orderByDesc('rating_count')
                ->limit(12)
                ->get();
        }

        // HERO slides (static UI content)
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

        /**
         * Build 5 kategori dari DB (distinct) yang memang tersedia di base query.
         * Ini yang bikin tombol categories beneran “based on DB”.
         */
        $dbCategories = (clone $base)
            ->select('category')
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->filter()
            ->values();

        // Ambil maksimal 5 kategori. Kalau DB < 5, ya tampil sesuai jumlahnya.
        $dbCategories = $dbCategories->take(5)->values();

        // Icon mapping (opsional): kalau kategori tidak match, fallback icon.
        $iconMap = [
            'bakery' => 'fa-bread-slice',
            'meals'  => 'fa-bowl-food',
            'drinks' => 'fa-mug-hot',
            'snacks' => 'fa-cookie-bite',
            'fresh'  => 'fa-carrot',
        ];

        // Bentuk payload untuk window.categories (dipakai dashboard.js buildCategories)
        $categoriesUi = $dbCategories->map(function ($cat) use ($iconMap) {
            $key = strtolower(trim((string) $cat));
            $icon = $iconMap[$key] ?? 'fa-utensils';

            // Link: kembali ke dashboard + filter category + scroll ke recommendations
            $link = route('dashboard', ['category' => $key, 'scroll' => 'recommendations']) . '#recommendations';

            return [
                'name' => ucfirst($key),
                'icon' => $icon,
                'link' => $link,
            ];
        })->values();

        return view('dashboard', compact(
            'flashSaleProducts',
            'recommendedProducts',
            'heroSlides',
            'categoriesUi',
            'selectedCategory'
        ));
    }
}
