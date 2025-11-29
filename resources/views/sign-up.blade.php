<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - LastBite</title>

    <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
@php
    // ambil role dari query ?role=penjual / ?role=pembeli
    $role = request('role');
    if (! in_array($role, ['penjual', 'pembeli'])) {
        $role = 'pembeli';
    }

    // tentukan link login sesuai role
    $loginUrl = $role === 'penjual' ? url('/login-penjual') : url('/login-pembeli');
@endphp

<div class="SIGN-UP-PENJUAL">
    {{-- HERO KIRI --}}
    <div class="group">
        <img src="{{ asset('images/hero-auth.png') }}" alt="LastBite Hero"
             style="width:100%; height:100%; object-fit:cover;">
    </div>

    {{-- LOGO KECIL KIRI ATAS --}}
    <div class="div">
        <a href="{{ route('beranda') }}">
            <img src="{{ asset('images/logo-lastbite.png') }}" alt="LastBite"
                 style="width:94px; height:71px; object-fit:contain;">
        </a>
    </div>

    {{-- NAVBAR ATAS (sama seperti halaman lain) --}}
    <div class="navbar">
        <a href="{{ route('beranda') }}" class="text-wrapper">Home</a>
        <a href="{{ route('fitur') }}" class="text-wrapper2">Fitur</a>
        <a href="{{ route('role') }}" class="text-wrapper2">Role</a>
        <a href="{{ route('about') }}" class="text-wrapper2">About Us</a>

        <div class="profile">
            <span class="text-wrapper3">Profile</span>
            <img src="{{ asset('images/profile.png') }}" alt="Profile" class="gg-profile">
        </div>
    </div>

    {{-- CARD FORM SIGN UP --}}
    <div class="group-2">
        <h1 class="text-wrapper4">Sign Up</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- role dibawa dari login, tidak ditampilkan --}}
            <input type="hidden" name="role" value="{{ $role }}">

            {{-- NAMA --}}
            <div class="frame">
                <input
                    type="text"
                    name="name"
                    class="auth-input"
                    placeholder="Your Name"
                    required>
            </div>

            {{-- EMAIL --}}
            <div class="div-wrapper">
                <input
                    type="email"
                    name="email"
                    class="auth-input"
                    placeholder="Your Email"
                    required>
            </div>

            {{-- PASSWORD --}}
            <div class="div-wrapper">
                <input
                    type="password"
                    name="password"
                    class="auth-input"
                    placeholder="Your Password"
                    required>
            </div>

            {{-- KONFIRMASI PASSWORD --}}
            <div class="div-wrapper">
                <input
                    type="password"
                    name="password_confirmation"
                    class="auth-input"
                    placeholder="Confirm Password"
                    required>
            </div>

            {{-- BUTTON SIGN UP --}}
            <button type="submit" class="button">
                <span class="text-wrapper7">Sign Up</span>
            </button>
        </form>

        {{-- TEKS TERMS --}}
        <p class="by-clicking-continue">
            <span class="span">By clicking continue, you agree to our</span>
            <span class="text-wrapper8"> Terms of Service</span>
            <span class="span"> and</span>
            <span class="text-wrapper8"> Privacy Policy</span>
        </p>

        {{-- LINK LOGIN --}}
        <div class="frame-2">
            <div class="frame-3">
                <span class="text-wrapper9">Joined us Before?</span>
            </div>
            <div class="frame-4">
                <a href="{{ $loginUrl }}" class="text-wrapper10">Login</a>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/app-lastbite.js') }}"></script>
</body>
</html>
