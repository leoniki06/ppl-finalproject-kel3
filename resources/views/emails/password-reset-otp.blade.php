<!DOCTYPE html>
<html>

<head>
    <title>Reset Password OTP</title>
</head>

<body>
    <h2>Reset Password OTP</h2>
    <p>Halo,</p>
    <p>Anda telah meminta untuk mereset password. Gunakan kode OTP berikut:</p>

    <div style="background-color: #f4f4f4; padding: 20px; text-align: center; margin: 20px 0;">
        <h1 style="color: #333; font-size: 32px; letter-spacing: 5px; margin: 0;">{{ $otp }}</h1>
    </div>

    <p>Kode ini akan kadaluarsa dalam 10 menit.</p>
    <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>

    <p>Terima kasih,<br>{{ config('app.name') }}</p>
</body>

</html>
