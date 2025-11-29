<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - LastBite</title>

    <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="BERANDA-SPLASH">
        <div class="group-wrapper">
            <div class="group">
                <div class="div">
                    <div class="frame-wrapper">
                        <div class="frame">
                            <img class="logo" src="{{ asset('images/logo-lastbite.png') }}" alt="LastBite" />
                            <img class="cookies" src="{{ asset('images/cookie-dark.png') }}" alt="Cookie Dark" />
                            <img class="pretzel" src="{{ asset('images/pretzel.png') }}" alt="Pretzel" />
                            <img class="img" src="{{ asset('images/cookie-light.png') }}" alt="Cookie Light" />
                            <img class="cookies-2" src="{{ asset('images/cookie-dark.png') }}" alt="Cookie Dark" />
                            <img class="cake" src="{{ asset('images/cake.png') }}" alt="Cake" />
                            <a href="{{ url('/about') }}" class="tombol">
                                <div class="text-wrapper">Next</div>
                            </a>
                        </div>
                    </div>

                    {{-- TOP BAR --}}
                    <div class="frame-2">
                        <div class="group-2"></div>
                        <a href="{{ url('/login-penjual') }}" class="div-wrapper">
                            <div class="text-wrapper">Log In</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
