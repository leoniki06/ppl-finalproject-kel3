<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/beranda', function () {
    return view('beranda');
})->name('beranda');

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

Route::get('/login-penjual', function () {
    return view('login-penjual');
})->name('login.penjual');

Route::get('/login-pembeli', function () {
    return view('login-pembeli');
})->name('login.pembeli');

// SIGN UP

// GET: tampilkan halaman form sign up (sign-up.blade.php)
Route::get('/sign-up', function () {
    return view('sign-up');
})->name('signup');

// Redirect URL lama ke sign up baru (kalau masih ada link lama)
Route::redirect('/sign-up-penjual', '/sign-up?role=penjual');
Route::redirect('/sign-up-pembeli', '/sign-up?role=pembeli');

// POST: proses data sign up
Route::post('/sign-up', [RegisterController::class, 'store'])->name('register');


// FORGOT PASSWORD (tampil form)
Route::get('/forgot-password', function () {
    return view('forgot-password');
})->name('password.request');

// FORGOT PASSWORD (klik Submit → ke OTP)
Route::post('/forgot-password', function () {
    // di sini kita abaikan input email
    return redirect()->route('otp');
})->name('password.fakeSubmit');

// OTP (tampil form)
Route::get('/otp', function () {
    return view('otp');
})->name('otp');

// OTP (klik Submit → ke RESET PASSWORD)
Route::post('/otp', function () {
    return redirect()->route('password.reset.form');
})->name('otp.fakeSubmit');

// RESET PASSWORD (tampil form)
Route::get('/reset-password', function () {
    return view('reset-password');
})->name('password.reset.form');

Route::post('/reset-password', function () {
    return redirect()->route('login.pembeli'); // atau login.penjual, terserah
})->name('password.reset.fakeSubmit');
