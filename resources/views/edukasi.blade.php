<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edukasi Food Waste - LastBite</title>

    <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="INTRO-EDUKASI">
        <div class="group">
            <div class="frame">
                <div class="div">
                    <div class="text-wrapper">Tahukah kamu?</div>
                    <div class="text-wrapper-2">Lebih dari 1/3 makanan</div>
                    <p class="text-wrapper-2">dunia berakhir di tempat sampah</p>
                </div>

                <div class="group-2">
                    <p class="padahal-sebagian">
                        Padahal sebagian besar masih layak untuk dinikmati. Food waste membuat harga pangan meningkat,
                        merusak lingkungan, dan menghabiskan sumber daya yang berharga.
                    </p>
                    <p class="dengan-lastbite-kamu">
                        Dengan LastBite, kamu bisa membantu mengurangi <br />pemborosan sekaligus menikmati makanan enak
                        dengan <br />harga lebih hemat.
                    </p>
                </div>

                <a href="{{ url('/fitur') }}" class="tombol">
                    <div class="text-wrapper-3">Next</div>
                </a>

                <img class="image-removebg" src="{{ asset('images/foodwaste.png') }}" alt="Food waste" />
            </div>

            <div class="frame-2">
                <div class="group-3"></div>
                <a href="{{ url('/login-penjual') }}" class="div-wrapper">
                    <div class="text-wrapper-3">Log In</div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
