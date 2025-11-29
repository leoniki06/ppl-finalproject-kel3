<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Role - LastBite</title>

    <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="PILIH-ROLE">
        <div class="group">
            <div class="frame">
                <a href="{{ url('/login-penjual') }}" class="tombol">
                    <div class="text-wrapper">Next</div>
                </a>

                <div class="div">Siapakah Anda?</div>

                {{-- Kartu Pembeli --}}
                <a href="{{ url('/login-pembeli') }}" class="a">
                    <img class="image-removebg" src="{{ asset('images/buyer.png') }}" alt="Pembeli" />
                    <div class="text-wrapper-2">Pembeli</div>
                </a>

                {{-- Kartu Penjual --}}
                <a href="{{ url('/login-penjual') }}" class="a-2">
                    <img class="img" src="{{ asset('images/seller.png') }}" alt="Penjual" />
                    <div class="text-wrapper-2">Penjual</div>
                </a>
            </div>

            <div class="frame-2">
                <div class="group-2"></div>
                <a href="{{ url('/login-penjual') }}" class="div-wrapper">
                    <div class="text-wrapper">Log In</div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
