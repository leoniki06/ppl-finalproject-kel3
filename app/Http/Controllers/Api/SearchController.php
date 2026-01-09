<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    // ---------- Helpers ----------
    protected function normalizeCategories(Request $request): array
    {
        $cats = [];

        $categories = $request->input('categories');

        if (is_string($categories)) {
            $cats = array_filter(array_map('trim', explode(',', $categories)));
        } elseif (is_array($categories)) {
            $cats = array_filter(array_map('trim', $categories));
        }

        // fallback single category
        $single = $request->input('category');
        if (is_string($single) && trim($single) !== '') {
            $cats[] = trim($single);
        }

        $cats = array_values(array_unique(array_filter($cats)));
        return $cats;
    }

    protected function applySearchTerm($query, ?string $term)
    {
        $term = trim((string) $term);
        if ($term === '') return $query;

        $table = (new Product())->getTable();

        $cols = [];
        foreach (['name', 'description', 'brand', 'category'] as $c) {
            if (Schema::hasColumn($table, $c)) $cols[] = $c;
        }
        if (!$cols) return $query;

        $query->where(function ($q) use ($cols, $term) {
            foreach ($cols as $i => $col) {
                if ($i === 0) $q->where($col, 'LIKE', "%{$term}%");
                else $q->orWhere($col, 'LIKE', "%{$term}%");
            }
        });

        return $query;
    }

    protected function applyFilters($query, Request $request)
    {
        $table = (new Product())->getTable();

        // price
        if ($request->filled('min_price') && Schema::hasColumn($table, 'price')) {
            $query->where('price', '>=', (float) $request->min_price);
        }
        if ($request->filled('max_price') && Schema::hasColumn($table, 'price')) {
            $query->where('price', '<=', (float) $request->max_price);
        }

        // ✅ rating: frontend kamu kirim "rating", tapi backend kadang pakai "min_rating"
        $minRating = $request->input('min_rating');
        if ($minRating === null || $minRating === '') {
            $minRating = $request->input('rating');
        }

        if ($minRating !== null && $minRating !== '' && (float)$minRating > 0) {
            if (Schema::hasColumn($table, 'rating')) {
                $query->where('rating', '>=', (float) $minRating);
            }
        }

        // categories
        $cats = $this->normalizeCategories($request);
        if ($cats && Schema::hasColumn($table, 'category')) {
            $query->whereIn('category', $cats);
        }

        return $query;
    }

    protected function applyAvailability($query, Request $request)
    {
        $table = (new Product())->getTable();

        // OPTIONAL flags (kalau suatu saat kamu pakai)
        if ($request->input('is_active') == '1' && Schema::hasColumn($table, 'is_active')) {
            $query->where('is_active', 1);
        }

        if ($request->input('in_stock') == '1') {
            if (Schema::hasColumn($table, 'stock')) $query->where('stock', '>', 0);
            elseif (Schema::hasColumn($table, 'quantity')) $query->where('quantity', '>', 0);
        }

        if ($request->input('not_expired') == '1' && Schema::hasColumn($table, 'expiry_date')) {
            $today = now()->toDateString();
            $query->where(function ($q) use ($today) {
                $q->whereNull('expiry_date')->orWhere('expiry_date', '>=', $today);
            });
        }

        return $query;
    }

    protected function applySorting($query, Request $request)
    {
        $table = (new Product())->getTable();
        $sort = (string) ($request->sort_by ?? 'newest');

        switch ($sort) {
            case 'price_asc':
                if (Schema::hasColumn($table, 'price')) $query->orderBy('price', 'asc');
                else $query->orderByDesc('id');
                break;

            case 'price_desc':
                if (Schema::hasColumn($table, 'price')) $query->orderBy('price', 'desc');
                else $query->orderByDesc('id');
                break;

            case 'rating':
                if (Schema::hasColumn($table, 'rating')) $query->orderBy('rating', 'desc');
                else $query->orderByDesc('id');
                break;

            case 'expiry':
                if (Schema::hasColumn($table, 'expiry_date')) $query->orderBy('expiry_date', 'asc');
                else $query->orderByDesc('id');
                break;

            case 'newest':
            default:
                if (Schema::hasColumn($table, 'created_at')) $query->orderBy('created_at', 'desc');
                else $query->orderByDesc('id');
                break;
        }

        return $query;
    }

    // ✅ MAIN endpoint (dipakai oleh /api/search dan /api/products/search)
    public function index(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'q' => 'nullable|string|max:255',

                'min_price' => 'nullable|numeric|min:0',
                'max_price' => 'nullable|numeric|min:0',

                'min_rating' => 'nullable|numeric|min:0|max:5',
                'rating' => 'nullable|numeric|min:0|max:5',

                'categories' => 'nullable',
                'category' => 'nullable|string|max:255',

                'sort_by' => 'nullable|in:price_asc,price_desc,rating,newest,expiry',

                'is_active' => 'nullable|in:0,1',
                'in_stock' => 'nullable|in:0,1',
                'not_expired' => 'nullable|in:0,1',

                'page' => 'nullable|integer|min:1',
                'per_page' => 'nullable|integer|min:1|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $query = Product::query();

            // search term
            $this->applySearchTerm($query, $request->q);

            // filters
            $this->applyFilters($query, $request);

            // availability flags (optional)
            $this->applyAvailability($query, $request);

            // sorting
            $this->applySorting($query, $request);

            $perPage = (int) ($request->per_page ?? 12);
            $products = $query->paginate($perPage);

            // ✅ response dibuat biar JS kamu pasti kebaca
            // normalizeSearchPayload() kamu bisa ambil payload.data.data
            return response()->json([
                'success' => true,
                'data' => [
                    'data' => $products->items(),
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'total' => $products->total(),
                    'per_page' => $products->perPage(),
                ],
                'applied_filters' => [
                    'q' => (string) ($request->q ?? ''),
                    'min_price' => $request->min_price,
                    'max_price' => $request->max_price,
                    'min_rating' => $request->min_rating ?? $request->rating,
                    'categories' => $this->normalizeCategories($request),
                    'sort_by' => $request->sort_by ?? 'newest',
                ],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error searching products',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // ===== keep old endpoints (biar gak rusak) =====
    public function searchProducts(Request $request)
    {
        return $this->index($request);
    }

    // ===== sisanya boleh kamu biarin, tapi minimal return index sudah beres =====
    public function byCategory(Request $request, $category)
    {
        $request->merge(['category' => $category]);
        return $this->index($request);
    }

    public function expiringSoon(Request $request)
    {
        // Optional: implement later
        return response()->json(['success' => true, 'data' => ['data' => []]]);
    }

    public function discounted(Request $request)
    {
        // Optional: implement later
        return response()->json(['success' => true, 'data' => ['data' => []]]);
    }

    public function autocompleteProducts(Request $request)
    {
        return response()->json(['success' => true, 'data' => []]);
    }

    public function autocompleteCategories(Request $request)
    {
        return response()->json(['success' => true, 'data' => []]);
    }

    public function autocompleteBrands(Request $request)
    {
        return response()->json(['success' => true, 'data' => []]);
    }
}
