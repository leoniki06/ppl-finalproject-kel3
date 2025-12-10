<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegistrationForm(Request $request)
    {
        // Daftar industri untuk dropdown
        $industries = [
            'Restoran',
            'Kafe',
            'Bakery',
            'Supermarket',
            'Minimarket',
            'Hotel',
            'Catering',
            'Food Court',
            'Toko Roti',
            'Warung Makan',
            'Kantin',
            'Pasar',
            'Lainnya'
        ];

        // Role yang dipilih dari parameter URL
        $selectedRole = $request->query('role', 'pembeli');

        // Validasi role
        if (!in_array($selectedRole, ['pembeli', 'penjual'])) {
            $selectedRole = 'pembeli';
        }

        return view('auth.register', [
            'industries' => $industries,
            'selectedRole' => $selectedRole
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:pembeli,penjual',
            'company_based' => 'required_if:role,penjual|nullable|string|max:255',
            'industry' => 'required_if:role,penjual|nullable|string|max:255',
            'privacy_policy' => 'required|accepted'
        ], [
            'company_based.required_if' => 'Company location is required for sellers.',
            'industry.required_if' => 'Industry is required for sellers.',
            'privacy_policy.required' => 'You must accept the Privacy Policy.',
            'privacy_policy.accepted' => 'You must accept the Privacy Policy.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'company_based' => $request->company_based,
            'industry' => $request->industry
        ]);

        // Login user
        auth()->login($user);

        // Redirect berdasarkan role
        if ($user->role === 'penjual') {
            return redirect()->route('seller.dashboard')->with('success', 'Registration successful!');
        }

        return redirect()->route('buyer.dashboard')->with('success', 'Registration successful!');
    }
}
