<?php
// File: app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\PasswordResetOtp;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // ========== LOGIN ==========
    public function showLoginForm(Request $request)
    {
        $selectedRole = $request->query('role');
        return view('auth.login', compact('selectedRole'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    // ========== REGISTER ==========
    public function showRegisterForm(Request $request)
    {
        $selectedRole = $request->query('role');
        $industries = [
            'Restoran',
            'Kafe',
            'Bakery',
            'Catering',
            'Hotel',
            'Supermarket',
            'Minimarket',
            'Food Court',
            'Lainnya'
        ];

        return view('auth.register', compact('selectedRole', 'industries'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:pembeli,penjual',
            'company_based' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'privacy_policy' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'company_based' => $request->company_based,
            'industry' => $request->industry,
            'phone' => $request->phone,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil!');
    }

    // ========== LOGOUT ==========
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('splash')->with('success', 'Logout berhasil!');
    }

    // ========== FORGOT PASS, OTP, RESET PASS ==========

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Generate OTP
        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(10);

        // Simpan OTP di database
        PasswordResetOtp::updateOrCreate(
            ['email' => $request->email],
            ['otp' => $otp, 'expires_at' => $expiresAt]
        );

        // Kirim email OTP (contoh sederhana)
        Mail::send('emails.password-reset-otp', [
            'otp' => $otp,
            'email' => $request->email
        ], function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Reset Password OTP');
        });

        session(['reset_email' => $request->email]);

        return redirect()->route('otp')->with('success', 'OTP telah dikirim ke email Anda!');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $otpRecord = PasswordResetOtp::where('email', session('reset_email'))
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'OTP tidak valid atau sudah kadaluarsa.']);
        }

        // OTP valid, hapus dari database
        $otpRecord->delete();

        return redirect()->route('password.reset')->with('success', 'OTP berhasil diverifikasi!');
    }
}
