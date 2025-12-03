<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gradient-to-r from-blue-50 to-indigo-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl p-8 max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full mb-4">
                <i class="fas fa-key text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Reset Password</h1>
            <p class="text-gray-600">Create a new strong password for your account</p>
        </div>

        <!-- Reset Password Form -->
        <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
            @csrf

            <!-- New Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock mr-2"></i>New Password
                </label>
                <div class="relative">
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 pl-12 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200"
                        placeholder="Enter new password">
                    <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <button type="button" id="togglePassword"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <p class="text-xs text-gray-500 mt-2">Must be at least 8 characters long</p>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock mr-2"></i>Confirm Password
                </label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full px-4 py-3 pl-12 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200"
                        placeholder="Confirm new password">
                    <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <button type="button" id="toggleConfirmPassword"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Password Strength Indicator -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Password Strength</h3>
                <div class="flex space-x-1 mb-2">
                    <div id="strength-bar-1" class="h-2 flex-1 bg-gray-300 rounded-full"></div>
                    <div id="strength-bar-2" class="h-2 flex-1 bg-gray-300 rounded-full"></div>
                    <div id="strength-bar-3" class="h-2 flex-1 bg-gray-300 rounded-full"></div>
                    <div id="strength-bar-4" class="h-2 flex-1 bg-gray-300 rounded-full"></div>
                </div>
                <p id="strength-text" class="text-sm text-gray-600">Enter a password to check strength</p>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold py-3 px-4 rounded-lg hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                <i class="fas fa-save mr-2"></i>Reset Password
            </button>
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
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                icon.className = 'fas fa-eye';
            }
        });

        // Toggle confirm password visibility
        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const confirmInput = document.getElementById('password_confirmation');
            const icon = this.querySelector('i');
            if (confirmInput.type === 'password') {
                confirmInput.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                confirmInput.type = 'password';
                icon.className = 'fas fa-eye';
            }
        });

        // Password strength checker
        const passwordInput = document.getElementById('password');
        const bars = [
            document.getElementById('strength-bar-1'),
            document.getElementById('strength-bar-2'),
            document.getElementById('strength-bar-3'),
            document.getElementById('strength-bar-4')
        ];
        const strengthText = document.getElementById('strength-text');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;

            // Check criteria
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            // Update bars
            bars.forEach((bar, index) => {
                if (index < strength) {
                    let color;
                    if (strength === 1) color = 'bg-red-500';
                    else if (strength === 2) color = 'bg-yellow-500';
                    else if (strength === 3) color = 'bg-blue-500';
                    else color = 'bg-green-500';

                    bar.className = `h-2 flex-1 ${color} rounded-full transition-all duration-300`;
                } else {
                    bar.className = 'h-2 flex-1 bg-gray-300 rounded-full transition-all duration-300';
                }
            });

            // Update text
            const texts = [
                'Very Weak',
                'Weak',
                'Good',
                'Strong',
                'Very Strong'
            ];
            strengthText.textContent = texts[strength];
            strengthText.className = `text-sm font-medium ${
                strength === 0 ? 'text-red-600' :
                strength === 1 ? 'text-yellow-600' :
                strength === 2 ? 'text-blue-600' :
                'text-green-600'
            }`;
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
                return false;
            }

            if (password.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long!');
                return false;
            }
        });
    </script>
</body>

</html>
