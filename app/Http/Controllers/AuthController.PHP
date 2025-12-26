<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login - DIPERBARUI untuk redirect berdasarkan role
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            $request->session()->put('user_id', $user->id);
            $request->session()->put('user_role', $user->role);

            // Redirect berdasarkan role user
            if ($user->role === 'seller') {
                return redirect()->route('seller.dashboard')
                    ->with('success', 'Login seller berhasil!');
            }

            // Default ke dashboard pembeli
            return redirect()->route('dashboard')
                ->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Show registration form
    public function showRegisterForm(Request $request)
    {
    // Ambil role dari URL parameter
    $selectedRole = $request->query('role', 'buyer');

    // Validasi role
    if (!in_array($selectedRole, ['buyer', 'seller'])) {
        $selectedRole = 'buyer';
    }

    return view('auth.register', [
        'selectedRole' => $selectedRole
    ]);
    }

    // Handle registration - DIPERBARUI untuk menyimpan role
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:buyer,seller', // Validasi role
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Simpan role
        ]);

        Auth::login($user);

        // Redirect berdasarkan role setelah registrasi
        if ($user->role === 'seller') {
            return redirect()->route('seller.dashboard')
                ->with('success', 'Registrasi seller berhasil!');
        }

        return redirect()->route('dashboard')
            ->with('success', 'Registrasi berhasil!');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logout berhasil!');
    }

    // ========== ROLE SELECTION METHODS ==========

    // Show role selection page (untuk halaman /role)
    public function showRoleSelection()
    {
        return view('role');
    }

    // Handle role selection (jika ada form POST di halaman role)
    public function selectRole(Request $request)
    {
        // Validasi input role
        $request->validate([
            'role' => 'required|in:buyer,seller',
        ]);

        // Simpan role ke session untuk digunakan saat registrasi
        $request->session()->put('selected_role', $request->role);

        // Redirect ke halaman register dengan role yang dipilih
        return redirect()->route('register')
            ->with('selected_role', $request->role);
    }
}