<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitur LastBite</title>

    <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="FITUR-LASTBITE">
        <div class="group">
            <div class="frame">
                <a href="{{ url('/role') }}" class="tombol">
                    <div class="text-wrapper">Next</div>
                </a>

                <div class="div">Fitur LastBite</div>

                {{-- Kartu fitur 1 --}}
                <div class="frame-fitur">
                    <div class="a">
                        <img class="streamline-freehand" src="{{ asset('images/fitur-sale.png') }}" alt="Sale" />
                        <div class="text-wrapper-2">Jelajahi Makanan Diskon</div>
                    </div>
                    <p class="p">Temukan berbagai makanan dengan harga diskon khusus</p>
                </div>

                {{-- Kartu fitur 2 --}}
                <div class="a-wrapper">
                    <div class="a-2">
                        <img class="mdi-shop-location" src="{{ asset('images/fitur-store-location.png') }}" alt="Store location" />
                        <div class="text-wrapper-3">Cari Restoran Terdekat</div>
                        <p class="text-wrapper-4">Informasi lokasi restoran terbaik di sekitar anda</p>
                    </div>
                </div>

                {{-- Kartu fitur 3 --}}
                <div class="div-wrapper">
                    <div class="a-2">
                        <img class="img" src="{{ asset('images/fitur-notif.png') }}" alt="Notification" />
                        <div class="text-wrapper-5">Notifikasi Penawaran Khusus</div>
                        <p class="text-wrapper-6">Dapatkan pemberitahuan promo di notifikasi anda</p>
                    </div>
                </div>

                {{-- Kartu fitur 4 --}}
                <div class="frame-fitur-2">
                    <div class="a-3">
                        <img class="tdesign-money" src="{{ asset('images/fitur-money.png') }}" alt="Money" />
                        <div class="harga-sebelum">Harga<br />Sebelum-Sesudah</div>
                        <p class="text-wrapper-7">
                            Bandingkan harga normal dan harga diskon, dan lihat seberapa besar kamu berhemat di setiap pesanan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="frame-2">
                <div class="group-2"></div>
                <a href="{{ url('/login-penjual') }}" class="tombol-2">
                    <div class="text-wrapper">Log In</div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
