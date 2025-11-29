<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - LastBite</title>

    <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<div class="RESET-PASSWORD">
    {{-- HERO KIRI --}}
    <div class="group">
        <img src="{{ asset('images/hero-auth.png') }}" alt="LastBite Hero" style="width:100%; height:100%; object-fit:cover;">
    </div>

    {{-- LOGO --}}
    <div class="div" style="top:25px; left:54px; width:70px; height:70px;">
        <a href="{{ url('/beranda') }}">
            <img src="{{ asset('images/logo-lastbite.png') }}" alt="LastBite" style="width:100%; height:100%; object-fit:contain;">
        </a>
    </div>

    {{-- NAVBAR --}}
    <div class="navbar">
        <a href="{{ url('/beranda') }}" class="text-wrapper">Home</a>
        <a href="{{ url('/fitur') }}" class="text-wrapper">Fitur</a>
        <a href="{{ url('/role') }}" class="text-wrapper-2">Role</a>
        <a href="{{ url('/about') }}" class="text-wrapper-2">About Us</a>

        <div class="profile">
            <span class="text-wrapper-3">Profile</span>
            <img src="{{ asset('images/profile.png') }}" alt="Profile" class="gg-profile">
        </div>
    </div>

    {{-- FORM RESET --}}
    <div class="group-2">
        <h1 class="text-wrapper-4">Reset Password</h1>

        <form method="POST" action="{{ route('password.reset.fakeSubmit') }}">
            @csrf

            {{-- INPUT PASSWORD BARU --}}
            <div class="frame">
                <input type="password" name="password"
                       class="auth-input" placeholder="New Password">
            </div>

            {{-- INPUT CONFIRM PASSWORD --}}
            <div class="frame">
                <input type="password" name="password_confirmation"
                       class="auth-input" placeholder="Confirm Password">
            </div>

            <button type="submit" class="button">
                <span class="text-wrapper-7">Submit</span>
            </button>
        </form>
    </div>

<script src="{{ asset('js/app-lastbite.js') }}"></script>
</body>
</html>
