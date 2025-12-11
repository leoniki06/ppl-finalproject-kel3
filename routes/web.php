<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ProductController;


// ==================== PUBLIC ROUTES ====================
Route::get('/', function () {
    return view('splash');
})->name('splash');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/edukasi', function () {
    return view('edukasi');
})->name('edukasi');

Route::get('/fitur', function () {
    return view('fitur');
})->name('fitur');

Route::get('/role', function () {
    return view('role');
})->name('role');

// ==================== SIMPLE FORGOT PASSWORD ROUTE ====================
// Forgot Password - Simple Email Only
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password/check-email', [ForgotPasswordController::class, 'checkEmail'])->name('password.check');
Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');

// ==================== AUTH ROUTES (NO MIDDLEWARE) ====================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== PROTECTED ROUTES (WITH MIDDLEWARE) ====================
Route::middleware(['checkauth'])->group(function () {
    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // PROFILE ROUTES
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile');
        Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/delete-photo', [ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');
        Route::get('/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    });

    // Di dalam middleware group atau sesuai kebutuhan:
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites');

// ==================== PRODUCT ====================
// Dashboard route
Route::get('/', [ProductController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard.index');

// Product detail route
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');


// routes/web.php
Route::get('/checkout', function () {
    // Redirect ke cart page dulu jika belum ada checkout
    return redirect()->route('cart.index');
})->name('cart.checkout');

// Atau langsung ke cart page
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

});

// Route untuk halaman keranjang
Route::get('/cart', function () {
    return view('cart.index');
})->name('cart.index');