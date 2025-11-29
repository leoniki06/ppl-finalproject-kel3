<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <title>Login Penjual - LastBite</title>
</head>
<body>
    <div class="LOGIN-PEMBELI">

        {{-- BACKGROUND / HERO KIRI --}}
        <img class="group" src="{{ asset('images/hero-auth.png') }}" alt="Hero LastBite" />

        {{-- LOGO KIRI ATAS --}}
        <img class="logo-small" src="{{ asset('images/logo-lastbite.png') }}" alt="LastBite">

    {{-- NAVBAR ATAS --}}
    <div class="navbar">
        <a href="{{ route('beranda') }}" class="text-wrapper">Home</a>
        <a href="{{ route('fitur') }}" class="text-wrapper-2">Fitur</a>
        <a href="{{ route('role') }}" class="text-wrapper-2">Role</a>
        <a href="{{ route('about') }}" class="text-wrapper-2">About Us</a>

        <div class="profile">
            <span class="text-wrapper-3">Profile</span>
            <img src="{{ asset('images/profile.png') }}" alt="Profile" class="gg-profile">
        </div>
    </div>


        {{-- KONTEN UTAMA LOGIN PEMBELI --}}
        <div class="group-2">

            <div class="text-wrapper-4">Log In</div>

            {{-- Sudah punya akun? --}}
            <div class="group-3">
                <span class="text-wrapper-5">Don’t have an account?</span>
                <a href="{{ url('/sign-up?role=penjual') }}" class="text-wrapper-6">Sign Up</a>
            </div>
            {{-- FORM LOGIN PEMBELI --}}
            <form class="js-form" data-form-type="login-buyer" method="POST" action="#">
                @csrf

                {{-- Email --}}
                <div class="frame">
                    <input
                        type="email"
                        name="email"
                        class="input-field"
                        placeholder="Your Email"
                        required
                    />
                </div>

                {{-- Password --}}
                <div class="frame-2">
                    <input
                        type="password"
                        name="password"
                        class="input-field"
                        placeholder="Your Password"
                        data-type="password"
                        required
                    />
                    <div class="el-eye-close">
                        <img class="vector" src="{{ asset('images/hide-password.png') }}" alt="Hide password" />
                    </div>
                </div>

                {{-- Tombol Log In --}}
                <button type="submit" class="button">
                    <div class="text-wrapper-9">Log In</div>
                </button>
            </form>

            {{-- Forgot password + garis pemisah + Google login + terms --}}
            <div class="group-4">
                <div class="text-wrapper-10">
                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                </div>

                <div class="group-5">
                    <div class="divider"></div>
                    <div class="text-wrapper-11">or continue with</div>
                    <div class="divider-2"></div>
                </div>
            </div>

            {{-- Tombol Google --}}
            <button class="label-wrapper" type="button">
                <div class="label">
                    <div class="google">
                        <img class="img" src="{{ asset('images/logo-google.png') }}" alt="Google logo" />
                    </div>
                    <div class="text-wrapper-12">Google</div>
                </div>
            </button>

            {{-- Terms & Privacy --}}
            <p class="by-clicking-continue">
                <span class="span">By clicking continue, you agree to our </span>
                <span class="text-wrapper-13">Terms of Service</span>
                <span class="span"> and </span>
                <span class="text-wrapper-13">Privacy Policy</span>
            </p>
        </div>
    </div>

