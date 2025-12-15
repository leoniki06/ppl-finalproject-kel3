<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ========== DASHBOARD API ROUTES ==========
Route::prefix('dashboard')->group(function () {
    // Get all dashboard products (flash sale, recommended, categories)
    Route::get('/products', [DashboardController::class, 'getProducts']);

    // Get flash sale products
    Route::get('/flash-sale', [DashboardController::class, 'getFlashSale']);

    // Get recommended products
    Route::get('/recommended', [DashboardController::class, 'getRecommended']);

    // Get products by category for dashboard
    Route::get('/categories', [DashboardController::class, 'getCategoriesWithProducts']);

    // Get hero banners
    Route::get('/banners', [DashboardController::class, 'getHeroBanners']);
});

// Products API with search capabilities
Route::prefix('products')->group(function () {
    // Search products with various filters
    Route::get('/search', [SearchController::class, 'searchProducts']);

    // Get products by category
    Route::get('/category/{category}', [SearchController::class, 'byCategory']);

    // Get products near expiry
    Route::get('/expiring-soon', [SearchController::class, 'expiringSoon']);

    // Get discounted products
    Route::get('/discounted', [SearchController::class, 'discounted']);
});

// Autocomplete endpoints
Route::prefix('autocomplete')->group(function () {
    // Product name autocomplete
    Route::get('/products', [SearchController::class, 'autocompleteProducts']);

    // Category autocomplete
    Route::get('/categories', [SearchController::class, 'autocompleteCategories']);

    // Brand autocomplete
    Route::get('/brands', [SearchController::class, 'autocompleteBrands']);
});
