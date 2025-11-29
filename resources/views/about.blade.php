<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang LastBite</title>

    <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="ABOUT-US">
        <div class="group">
            <div class="frame">
                <a href="{{ url('/edukasi') }}" class="tombol">
                    <div class="text-wrapper">Next</div>
                </a>

                <p class="div">
                    Lastbite adalah sebuah program yang memfasilitasi penjualan makanan yang masih layak konsumsi namun
                    berlebih atau mendekati tanggal kedaluwarsa dari restoran, kafe, atau supplier, dengan harga terjangkau.
                </p>

                <div class="text-wrapper-2">Apa Itu LastBite?</div>
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
