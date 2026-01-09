<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\DashboardController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ✅ ADD: universal search endpoint (sesuai JS fallback "/api/search")
Route::get('/search', [SearchController::class, 'index']);

// ========== DASHBOARD API ROUTES ==========
Route::prefix('dashboard')->group(function () {
    Route::get('/products', [DashboardController::class, 'getProducts']);
    Route::get('/flash-sale', [DashboardController::class, 'getFlashSale']);
    Route::get('/recommended', [DashboardController::class, 'getRecommended']);
    Route::get('/categories', [DashboardController::class, 'getCategoriesWithProducts']);
    Route::get('/banners', [DashboardController::class, 'getHeroBanners']);
});

// Products API with search capabilities
Route::prefix('products')->group(function () {
    // ✅ FIX: arahkan ke index juga biar konsisten
    Route::get('/search', [SearchController::class, 'index']);

    Route::get('/category/{category}', [SearchController::class, 'byCategory']);
    Route::get('/expiring-soon', [SearchController::class, 'expiringSoon']);
    Route::get('/discounted', [SearchController::class, 'discounted']);
});

// Autocomplete endpoints
Route::prefix('autocomplete')->group(function () {
    Route::get('/products', [SearchController::class, 'autocompleteProducts']);
    Route::get('/categories', [SearchController::class, 'autocompleteCategories']);
    Route::get('/brands', [SearchController::class, 'autocompleteBrands']);
});
