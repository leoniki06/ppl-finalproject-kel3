<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

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
Route::get('/role', function () {
    return view('role');
})->name('role');

// 6. LOGIN & REGISTER
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// ==================== SIMPLE FORGOT PASSWORD ROUTE ====================
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password/check-email', [ForgotPasswordController::class, 'checkEmail'])->name('password.check');
Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');

// ==================== PUBLIC PRODUCT ROUTES ====================
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// ==================== PROTECTED ROUTES (HANYA UNTUK USER YANG LOGIN) ====================
Route::middleware(['checkauth'])->group(function () {
    // DASHBOARD (setelah login)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Alternatif: jika ingin ProductController menangani dashboard
    // Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');

    // PROFILE ROUTES
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile');
        Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/delete-photo', [ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');
        Route::get('/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    });

    // CART ROUTES (hanya untuk yang login)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    // FAVORITES ROUTES
    Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites');

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // CHECKOUT (redirect ke cart jika belum siap)
    Route::get('/checkout', function () {
        return redirect()->route('cart.index');
    })->name('cart.checkout');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/cart/summary', [CartController::class, 'getCartSummary'])->name('cart.summary');

});
