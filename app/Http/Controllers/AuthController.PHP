<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm(Request $request)
    {
        $selectedRole = $request->query('role', 'buyer');
        if (!in_array($selectedRole, ['buyer', 'seller'])) {
            $selectedRole = 'buyer';
        }

        return view('auth.login', compact('selectedRole'));
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'role' => 'required|in:buyer,seller',
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'nullable',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Validasi: user harus login sesuai role yang dipilih
            if ($user->role !== $data['role']) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withErrors(['role' => 'Role tidak sesuai. Pilih role yang benar.'])
                    ->onlyInput('email');
            }

            if ($user->role === 'seller') {
                return redirect()->route('seller.dashboard')->with('success', 'Login seller berhasil!');
            }

            return redirect()->route('dashboard')->with('success', 'Login buyer berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }


    public function showRegisterForm(Request $request)
    {
        $selectedRole = $request->query('role', 'buyer');
        if (!in_array($selectedRole, ['buyer', 'seller'])) {
            $selectedRole = 'buyer';
        }


        return view('auth.register', [
            'selectedRole' => $selectedRole
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:buyer,seller',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        Auth::login($user);

        if ($user->role === 'seller') {
            return redirect()->route('seller.dashboard')->with('success', 'Registrasi seller berhasil!');
        }

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logout berhasil!');
    }

    public function showRoleSelection()
    {
        return view('role');
    }

    public function selectRole(Request $request)
    {
        $request->validate([
            'role' => 'required|in:customer,seller',
        ]);

        $request->session()->put('selected_role', $request->role);

        return redirect()->route('register', ['role' => $request->role]);
    }
}
