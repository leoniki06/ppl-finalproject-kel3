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


// ==================== PUBLIC ROUTES ====================
Route::get('/', fn() => view('splash'))->name('splash');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/edukasi', fn() => view('edukasi'))->name('edukasi');
Route::get('/fitur', fn() => view('fitur'))->name('fitur');

Route::get('/role', [AuthController::class, 'showRoleSelection'])->name('role');
Route::post('/role/select', [AuthController::class, 'selectRole'])->name('role.select');

// PUBLIC PRODUCT DETAIL
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');


// ==================== AUTH ROUTES (GUEST ONLY) ====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
    Route::post('/forgot-password/check-email', [ForgotPasswordController::class, 'checkEmail'])->name('password.check');
    Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');
});


// ==================== AUTHENTICATED ROUTES ====================
Route::middleware('auth')->group(function () {

    // BUYER DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ==================== SELLER ROUTES (WAJIB SELLER) ====================
    Route::prefix('seller')->name('seller.')->middleware('seller')->group(function () {

        Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');

        // PRODUCTS
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
        Route::post('/orders/{id}/mark-paid', [SellerOrderController::class, 'markPaid'])->name('orders.markPaid');

        // STORE
        Route::get('/store/profile', [SellerStoreController::class, 'edit'])->name('store.profile');
        Route::put('/store/profile', [SellerStoreController::class, 'update'])->name('store.profile.update');

        // FINANCE / PAYOUTS
        Route::get('/finance', [SellerPayoutController::class, 'index'])->name('finance.index');
        Route::get('/payouts', [SellerPayoutController::class, 'index'])->name('payouts.index');
        Route::post('/payouts/withdraw', [SellerPayoutController::class, 'withdraw'])->name('payouts.withdraw');
    });


    // ==================== PROFILE ====================
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile');
        Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/delete-photo', [ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');

        // shortcut
        Route::get('/orders', fn() => redirect()->route('orders.index'))->name('profile.orders');
    });


    // ==================== CART ====================
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::post('/remove', [CartController::class, 'remove'])->name('remove');
        Route::post('/update', [CartController::class, 'update'])->name('update');

        // redirect lama yang kamu pakai
        Route::get('/checkout', fn() => redirect()->route('checkout.index'))->name('checkout');
        Route::get('/summary', [CartController::class, 'getCartSummary'])->name('summary');
    });


    /// ==================== CHECKOUT ====================
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
        Route::post('/confirm', [CheckoutController::class, 'confirm'])->name('confirm');
    });



    // ==================== ORDERS ====================
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::post('/store', [OrderController::class, 'store'])->name('store');
    });


    // ==================== FAVORITES ====================
    Route::prefix('favorites')->group(function () {
        Route::get('/', [FavoritesController::class, 'index'])->name('favorites');
        Route::post('/toggle', [FavoritesController::class, 'toggle'])->name('favorites.toggle');
        Route::post('/remove/{id}', [FavoritesController::class, 'remove'])->name('favorites.remove');
        Route::post('/clear', [FavoritesController::class, 'clear'])->name('favorites.clear');

        Route::get('/count', [FavoritesController::class, 'count'])->name('favorites.count');
        Route::get('/status/{productId}', [FavoritesController::class, 'checkStatus'])->name('favorites.status');
        Route::get('/list', [FavoritesController::class, 'list'])->name('favorites.list');
    });
});
