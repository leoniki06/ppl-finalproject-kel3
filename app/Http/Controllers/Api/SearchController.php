<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    /**
     * Basic search endpoint
     */
    public function index(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'q' => 'nullable|string|max:255',
                'page' => 'nullable|integer|min:1',
                'per_page' => 'nullable|integer|min:1|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $query = Product::query();

            // Apply search term
            if ($request->has('q') && !empty($request->q)) {
                $searchTerm = $request->q;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('brand', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('category', 'LIKE', "%{$searchTerm}%");
                });
            }

            // Only show available products
            $query->where('stock', '>', 0)
                ->where('is_available', true);

            // Apply sorting
            $query->orderBy('created_at', 'desc');

            // Pagination
            $perPage = $request->per_page ?? 12;
            $products = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Search results retrieved successfully',
                'data' => [
                    'products' => $products->items(),
                    'pagination' => [
                        'current_page' => $products->currentPage(),
                        'total_pages' => $products->lastPage(),
                        'total_items' => $products->total(),
                        'per_page' => $products->perPage(),
                        'has_more' => $products->hasMorePages(),
                    ],
                    'filters' => [
                        'query' => $request->q ?? '',
                        'applied_filters' => $request->only(['q'])
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error searching products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Advanced search with filters
     */
    public function filter(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'q' => 'nullable|string|max:255',
                'categories' => 'nullable|array',
                'categories.*' => 'string',
                'min_price' => 'nullable|numeric|min:0',
                'max_price' => 'nullable|numeric|min:0',
                'min_rating' => 'nullable|numeric|min:0|max:5',
                'sort_by' => 'nullable|in:price_asc,price_desc,rating,newest,expiry',
                'page' => 'nullable|integer|min:1',
                'per_page' => 'nullable|integer|min:1|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $query = Product::query();

            // Apply search term
            if ($request->has('q') && !empty($request->q)) {
                $searchTerm = $request->q;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('brand', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('category', 'LIKE', "%{$searchTerm}%");
                });
            }

            // Filter by categories
            if ($request->has('categories') && !empty($request->categories)) {
                $query->whereIn('category', $request->categories);
            }

            // Filter by price range
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

            // Only show available products
            $query->where('stock', '>', 0)
                ->where('is_available', true);

            // Apply sorting
            switch ($request->sort_by) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'rating':
                    $query->orderBy('rating', 'desc');
                    break;
                case 'expiry':
                    $query->orderBy('expiry_date', 'asc');
                    break;
                case 'newest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }

            // Pagination
            $perPage = $request->per_page ?? 12;
            $products = $query->paginate($perPage);

            // Get available filters for frontend
            $availableCategories = Product::where('stock', '>', 0)
                ->where('is_available', true)
                ->distinct('category')
                ->pluck('category')
                ->filter()
                ->values();

            $priceRange = Product::where('stock', '>', 0)
                ->where('is_available', true)
                ->select([
                    DB::raw('MIN(price) as min_price'),
                    DB::raw('MAX(price) as max_price')
                ])
                ->first();

            return response()->json([
                'success' => true,
                'message' => 'Search results retrieved successfully',
                'data' => [
                    'products' => $products->items(),
                    'pagination' => [
                        'current_page' => $products->currentPage(),
                        'total_pages' => $products->lastPage(),
                        'total_items' => $products->total(),
                        'per_page' => $products->perPage(),
                        'has_more' => $products->hasMorePages(),
                    ],
                    'available_filters' => [
                        'categories' => $availableCategories,
                        'price_range' => [
                            'min' => (float) ($priceRange->min_price ?? 0),
                            'max' => (float) ($priceRange->max_price ?? 100000)
                        ]
                    ],
                    'applied_filters' => $request->only(['q', 'categories', 'min_price', 'max_price', 'min_rating', 'sort_by'])
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error filtering products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search products with all filters (compatible with frontend)
     * RECOMMENDED ENDPOINT FOR FRONTEND
     */
    public function searchProducts(Request $request)
    {
        try {
            $query = Product::query();

            // Apply search term
            if ($request->has('q') && !empty($request->q)) {
                $searchTerm = $request->q;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('brand', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('category', 'LIKE', "%{$searchTerm}%");
                });
            }

            // Filter by price range
            if ($request->has('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }
            if ($request->has('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }

            // Filter by rating
            if ($request->has('min_rating') && $request->min_rating > 0) {
                $query->where('rating', '>=', $request->min_rating);
            }

            // Filter by categories
            if ($request->has('categories') && !empty($request->categories)) {
                $categories = explode(',', $request->categories);
                $query->whereIn('category', $categories);
            }

            // Only show available products
            $query->where('stock', '>', 0)
                ->where('is_available', true);

            // Default sorting by relevance/date
            $query->orderBy('created_at', 'desc');

            // Limit results
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
                'message' => 'Error searching products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get search suggestions
     */
    public function suggestions(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'q' => 'required|string|min:1|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $searchTerm = $request->q;

            // Get product suggestions
            $productSuggestions = Product::where('name', 'LIKE', "{$searchTerm}%")
                ->where('stock', '>', 0)
                ->where('is_available', true)
                ->select('name', 'id', 'image_url')
                ->distinct()
                ->take(5)
                ->get()
                ->map(function ($product) {
                    return [
                        'type' => 'product',
                        'text' => $product->name,
                        'value' => $product->name,
                        'image' => $product->image_url,
                        'id' => $product->id
                    ];
                });

            // Get category suggestions from product categories
            $categorySuggestions = Product::where('stock', '>', 0)
                ->where('is_available', true)
                ->where('category', 'LIKE', "{$searchTerm}%")
                ->select('category as name')
                ->distinct()
                ->take(3)
                ->get()
                ->map(function ($item) {
                    return [
                        'type' => 'category',
                        'text' => $item->name,
                        'value' => $item->name
                    ];
                });

            $suggestions = $productSuggestions->merge($categorySuggestions)->take(8);

            return response()->json([
                'success' => true,
                'data' => [
                    'suggestions' => $suggestions,
                    'query' => $searchTerm
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting suggestions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get products by category
     */
    public function byCategory(Request $request, $category)
    {
        try {
            $query = Product::query()
                ->where('category', $category)
                ->where('stock', '>', 0)
                ->where('is_available', true);

            // Apply price filters if provided
            if ($request->has('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }
            if ($request->has('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }

            // Apply rating filter
            if ($request->has('min_rating')) {
                $query->where('rating', '>=', $request->min_rating);
            }

            // Sort by expiry date (closest first)
            $query->orderBy('expiry_date', 'asc')
                ->orderBy('created_at', 'desc');

            $perPage = $request->per_page ?? 12;
            $products = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => [
                    'products' => $products->items(),
                    'category' => $category,
                    'total' => $products->total(),
                    'pagination' => [
                        'current_page' => $products->currentPage(),
                        'total_pages' => $products->lastPage(),
                        'per_page' => $products->perPage()
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting category products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get products expiring soon
     */
    public function expiringSoon(Request $request)
    {
        try {
            $days = $request->days ?? 3;
            $dateLimit = now()->addDays($days)->toDateString();

            $query = Product::query()
                ->where('expiry_date', '<=', $dateLimit)
                ->where('expiry_date', '>=', now()->toDateString())
                ->where('stock', '>', 0)
                ->where('is_available', true)
                ->orderBy('expiry_date', 'asc')
                ->orderBy('price', 'asc');

            $perPage = $request->per_page ?? 12;
            $products = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => [
                    'products' => $products->items(),
                    'total' => $products->total(),
                    'expiry_days' => $days,
                    'pagination' => [
                        'current_page' => $products->currentPage(),
                        'total_pages' => $products->lastPage(),
                        'per_page' => $products->perPage()
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting expiring products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get discounted products
     */
    public function discounted(Request $request)
    {
        try {
            $query = Product::query()
                ->where('discount_percentage', '>', 0)
                ->where('stock', '>', 0)
                ->where('is_available', true)
                ->orderBy('discount_percentage', 'desc')
                ->orderBy('expiry_date', 'asc');

            $perPage = $request->per_page ?? 12;
            $products = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => [
                    'products' => $products->items(),
                    'total' => $products->total(),
                    'pagination' => [
                        'current_page' => $products->currentPage(),
                        'total_pages' => $products->lastPage(),
                        'per_page' => $products->perPage()
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting discounted products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Autocomplete product names
     */
    public function autocompleteProducts(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'q' => 'required|string|min:1|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $searchTerm = $request->q;

            $products = Product::where('name', 'LIKE', "{$searchTerm}%")
                ->where('stock', '>', 0)
                ->where('is_available', true)
                ->select('name', 'id', 'image_url', 'price')
                ->distinct()
                ->take(10)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting autocomplete suggestions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Autocomplete categories from products
     */
    public function autocompleteCategories(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'q' => 'required|string|min:1|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $searchTerm = $request->q;

            $categories = Product::where('category', 'LIKE', "{$searchTerm}%")
                ->where('stock', '>', 0)
                ->where('is_available', true)
                ->select('category as name')
                ->distinct()
                ->take(10)
                ->get()
                ->map(function ($item) {
                    return [
                        'name' => $item->name,
                        'slug' => strtolower(str_replace(' ', '-', $item->name))
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting category suggestions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Autocomplete brands
     */
    public function autocompleteBrands(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'q' => 'required|string|min:1|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $searchTerm = $request->q;

            $brands = Product::where('brand', 'LIKE', "{$searchTerm}%")
                ->where('stock', '>', 0)
                ->where('is_available', true)
                ->select('brand')
                ->distinct()
                ->take(10)
                ->get()
                ->pluck('brand')
                ->filter();

            return response()->json([
                'success' => true,
                'data' => $brands
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting brand suggestions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get search history for authenticated user
     */
    public function history(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // In a real app, you would store search history in database
            // This is a simplified version
            $history = []; // You would fetch from database here

            return response()->json([
                'success' => true,
                'data' => [
                    'history' => $history,
                    'total' => count($history)
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting search history',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear search history
     */
    public function clearHistory(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // In a real app, you would delete search history from database
            // This is a simplified version

            return response()->json([
                'success' => true,
                'message' => 'Search history cleared successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error clearing search history',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
