<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gradient-to-r from-blue-50 to-indigo-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl p-8 max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full mb-4">
                <i class="fas fa-shield-alt text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">OTP Verification</h1>
            <p class="text-gray-600">Enter the 6-digit code sent to your email</p>
        </div>

        <!-- OTP Form -->
        <form action="{{ route('otp.verify') }}" method="POST" class="space-y-6">
            @csrf

            <!-- OTP Input -->
            <div>
                <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">Enter OTP</label>
                <div class="flex justify-center space-x-3">
                    @for ($i = 1; $i <= 6; $i++)
                        <input type="text" name="otp[]" maxlength="1"
                            class="otp-digit w-12 h-14 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200"
                            oninput="moveToNext(this, {{ $i }})"
                            onkeydown="moveToPrevious(event, {{ $i }})">
                    @endfor
                </div>
                <input type="hidden" name="otp" id="otp-full">
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold py-3 px-4 rounded-lg hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-md hover:shadow-lg">
                Verify OTP
            </button>

            <!-- Resend OTP -->
            <div class="text-center pt-4 border-t border-gray-100">
                <p class="text-gray-600">Didn't receive code?</p>
                <button type="button" id="resend-btn"
                    class="text-indigo-600 font-semibold hover:text-indigo-800 transition-colors duration-200">
                    Resend OTP <span id="countdown" class="text-gray-500"></span>
                </button>
            </div>
        </form>

        <!-- Back to Login -->
        <div class="text-center mt-6">
            <a href="{{ route('login') }}"
                class="inline-flex items-center text-gray-600 hover:text-gray-800 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Login
            </a>
        </div>
    </div>

    <script>
        // Combine OTP digits
        document.querySelector('form').addEventListener('submit', function(e) {
            const digits = document.querySelectorAll('.otp-digit');
            let fullOtp = '';
            digits.forEach(input => {
                fullOtp += input.value;
            });
            document.getElementById('otp-full').value = fullOtp;
        });

        // Auto move to next input
        function moveToNext(input, index) {
            if (input.value.length === 1 && index < 6) {
                document.querySelector(`.otp-digit:nth-child(${index + 1})`).focus();
            }
        }

        // Move to previous input on backspace
        function moveToPrevious(event, index) {
            if (event.key === 'Backspace' && !event.target.value && index > 1) {
                document.querySelector(`.otp-digit:nth-child(${index - 1})`).focus();
            }
        }

        // Resend OTP with countdown
        let countdown = 60;
        const resendBtn = document.getElementById('resend-btn');
        const countdownEl = document.getElementById('countdown');

        function updateCountdown() {
            if (countdown > 0) {
                resendBtn.disabled = true;
                countdownEl.textContent = `(${countdown}s)`;
                countdown--;
                setTimeout(updateCountdown, 1000);
            } else {
                resendBtn.disabled = false;
                countdownEl.textContent = '';
            }
        }

        resendBtn.addEventListener('click', function() {
            // Trigger resend OTP logic here
            alert('OTP resent! Check your email.');
            countdown = 60;
            updateCountdown();
        });

        // Initialize countdown
        updateCountdown();

        // Auto focus first input
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.otp-digit').focus();
        });
    </script>
</body>

</html>
