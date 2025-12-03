<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// ==================== PUBLIC ROUTES ====================

// Splash Screen
Route::get('/', function () {
    return view('splash');
})->name('splash');

// About
Route::get('/about', function () {
    return view('about');
})->name('about');

// Edukasi
Route::get('/edukasi', function () {
    return view('edukasi');
})->name('edukasi');

// Fitur
Route::get('/fitur', function () {
    return view('fitur');
})->name('fitur');

// Pilih Role
Route::get('/role', function () {
    return view('role');
})->name('role');

// ==================== AUTH ROUTES ====================

// LOGIN PAGE
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// REGISTER PAGE
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== FORGOT PASSWORD ROUTES ====================

// Tampilkan halaman forgot password
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

// Proses forgot password (POST) - MENGIRIM OTP
Route::post('/forgot-password', function (Request $request) {
    // Validasi email - PERBAIKI SYNTAX INI
    $request->validate([
        'email' => 'required|email|exists:users,email' // Pastikan email ada di database
    ]);

    // Generate OTP
    $otp = rand(100000, 999999);
    $expiresAt = now()->addMinutes(10);

    // Simpan OTP di database (gunakan tabel sementara)
    DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $request->email],
        [
            'token' => $otp,
            'created_at' => now(),
            'expires_at' => $expiresAt
        ]
    );

    // Simpan email di session
    session(['reset_email' => $request->email]);
    session(['otp_code' => $otp]);

    // **UNTUK TESTING: TAMPILKAN OTP DI LAYAR (HAPUS DI PRODUKSI)**
    return redirect()->route('otp')->with([
        'success' => 'OTP berhasil dikirim!',
        'email' => $request->email,
        'debug_otp' => $otp // Hanya untuk debugging
    ]);

    /*
    // KODE UNTUK MENGIRIM EMAIL (NON-AKTIFKAN DULU UNTUK TESTING)
    try {
        Mail::send('emails.password-reset-otp', ['otp' => $otp], function($message) use ($request) {
            $message->to($request->email)
                    ->subject('Reset Password OTP - Lastbite');
        });

        return redirect()->route('otp')->with([
            'success' => 'OTP telah dikirim ke email Anda!',
            'email' => $request->email
        ]);
    } catch (\Exception $e) {
        return back()->withErrors(['email' => 'Gagal mengirim email. ' . $e->getMessage()]);
    }
    */
})->name('password.email');

// OTP Verification Page
Route::get('/otp', function () {
    if (!session('reset_email')) {
        return redirect()->route('password.request');
    }

    return view('auth.otp-verification', [
        'email' => session('reset_email')
    ]);
})->name('otp');

// Proses OTP verification
Route::post('/otp', function (Request $request) {
    // Validasi OTP
    $request->validate([
        'otp' => 'required|digits:6'
    ]);

    // Ambil OTP dari session (untuk testing)
    $storedOTP = session('otp_code');

    // Atau ambil dari database (untuk produksi)
    // $otpRecord = DB::table('password_reset_tokens')
    //     ->where('email', session('reset_email'))
    //     ->where('token', $request->otp)
    //     ->where('expires_at', '>', now())
    //     ->first();

    // Untuk testing, bandingkan dengan session
    if ($request->otp != $storedOTP) {
        return back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
    }

    // Hapus OTP dari session setelah berhasil
    session()->forget('otp_code');

    // Redirect ke reset password
    return redirect()->route('password.reset')->with([
        'email' => session('reset_email'),
        'success' => 'OTP berhasil diverifikasi!'
    ]);
})->name('otp.verify');

// Reset Password Page
Route::get('/reset-password', function () {
    if (!session('reset_email')) {
        return redirect()->route('password.request');
    }

    return view('auth.reset-password', [
        'email' => session('reset_email')
    ]);
})->name('password.reset');

// Proses reset password
Route::post('/reset-password', function (Request $request) {
    // Validasi
    $request->validate([
        'password' => 'required|min:8|confirmed'
    ]);

    // Update password di database
    $user = User::where('email', session('reset_email'))->first();

    if ($user) {
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus token reset dari database
        DB::table('password_reset_tokens')
            ->where('email', session('reset_email'))
            ->delete();

        // Hapus session
        session()->forget('reset_email');

        return redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }

    return back()->withErrors(['email' => 'User tidak ditemukan.']);
})->name('password.update');

// ==================== PROTECTED ROUTES ====================

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/beranda', function () {
        return view('beranda');
    })->name('beranda');
});
