<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification - LastBite</title>

    <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<div class="OTP">
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

    {{-- KONTEN OTP --}}
    <div class="group-2">
        <h1 class="text-wrapper-4">Enter OTP Pembeli</h1>

        <p class="p">
            Kode 4 digit telah dikirim ke email kamu, silakan masukkan di bawah ini.
        </p>

        <form method="POST" action="{{ route('otp.fakeSubmit') }}">
            @csrf

            <div class="group-3">
                <input class="frame otp-input" type="text" name="otp1">
                <input class="frame otp-input" type="text" name="otp2">
                <input class="frame otp-input" type="text" name="otp3">
                <input class="frame otp-input" type="text" name="otp4">
            </div>

            <button type="submit" class="button">
                <span class="text-wrapper-5">Submit</span>
            </button>
        </form>
    </div>

<script src="{{ asset('js/app-lastbite.js') }}"></script>
</body>
</html>
