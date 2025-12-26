<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerOrderController;
use App\Http\Controllers\Seller\SellerStoreController;
use App\Http\Controllers\Seller\SellerPayoutController;

// ==================== PUBLIC ROUTES (BISA DIAKSES TANPA LOGIN) ====================

// 1. SPLASH PAGE (Halaman pertama yang diakses)
Route::get('/', function () {
    return view('splash');
})->name('splash');

// 2. ABOUT PAGE
Route::get('/about', function () {
    return view('about');
})->name('about');

// 3. EDUKASI PAGE
Route::get('/edukasi', function () {
    return view('edukasi');
})->name('edukasi');

// 4. FITUR PAGE
Route::get('/fitur', function () {
    return view('fitur');
})->name('fitur');

// 5. ROLE PAGE
Route::get('/role', [AuthController::class, 'showRoleSelection'])->name('role');
Route::post('/role/select', [AuthController::class, 'selectRole'])->name('role.select');

// ==================== AUTHENTICATION ROUTES ====================

// Login Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Register Routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// ==================== PASSWORD RESET ROUTES ====================
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password/check-email', [ForgotPasswordController::class, 'checkEmail'])->name('password.check');
Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');

// ==================== PUBLIC PRODUCT ROUTES ====================
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// ==================== PROTECTED ROUTES (HANYA UNTUK USER YANG LOGIN) ====================
Route::middleware(['checkauth'])->group(function () {

    // ==================== DASHBOARD ROUTES ====================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==================== SELLER DASHBOARD ROUTES ====================
    Route::prefix('seller')->name('seller.')->group(function () {
        Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');

        // PROUDCTS
        Route::get('/products', [SellerProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [SellerProductController::class, 'create'])->name('products.create');
        Route::post('/products', [SellerProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', [SellerProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [SellerProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [SellerProductController::class, 'destroy'])->name('products.destroy');
        Route::patch('/products/{id}/toggle-status', [SellerProductController::class, 'toggleStatus'])->name('products.toggleStatus');

        // ORDERS
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [SellerOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{id}/status', [SellerOrderController::class, 'updateStatus'])->name('orders.updateStatus');

        //STORE
        Route::get('/store/profile', [SellerStoreController::class, 'edit'])->name('store.profile');
        Route::put('/store/profile', [SellerStoreController::class, 'update'])->name('store.profile.update');

        // PAYOUTS
        Route::get('/payouts', [SellerPayoutController::class, 'index'])->name('payouts.index');
        Route::post('/payouts/withdraw', [SellerPayoutController::class, 'withdraw'])->name('payouts.withdraw');

    });

    // ==================== PROFILE ROUTES ====================
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile');
        Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/delete-photo', [ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');
        Route::get('/orders', function () {
            return redirect()->route('orders.index');
        })->name('profile.orders');
    });

    // ==================== CART ROUTES ====================
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add', [CartController::class, 'add'])->name('cart.add');
        Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/update', [CartController::class, 'update'])->name('cart.update');
    });

    // ==================== CHECKOUT ROUTES ====================
    Route::prefix('checkout')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');
        Route::post('/confirm', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
    });

    // ==================== ORDER ROUTES ====================
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::post('/store', [OrderController::class, 'store'])->name('orders.store');
    });

    // ==================== FAVORITES ROUTES ====================
    Route::prefix('favorites')->group(function () {
        Route::get('/', [FavoritesController::class, 'index'])->name('favorites');
        Route::post('/toggle', [FavoritesController::class, 'toggle'])->name('favorites.toggle');
        Route::post('/remove/{id}', [FavoritesController::class, 'remove'])->name('favorites.remove');
        Route::post('/clear', [FavoritesController::class, 'clear'])->name('favorites.clear');
        Route::get('/count', [FavoritesController::class, 'count'])->name('favorites.count');
        Route::get('/status/{productId}', [FavoritesController::class, 'checkStatus'])->name('favorites.status');
        Route::get('/list', [FavoritesController::class, 'list'])->name('favorites.list');
    });

    // ==================== LOGOUT ROUTE ====================
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ==================== REDIRECT ROUTES ====================
    Route::get('/cart/checkout', function () {
        return redirect()->route('checkout.index');
    })->name('cart.checkout');

    // ==================== ORDER HISTORY ROUTES ====================
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');

});
