<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoritesController;

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
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');

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
});
