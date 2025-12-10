<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LastBite</title>

    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #3F2305;
            --secondary-color: #f5f5f5;
            --accent-color: #d4a574;
            --text-primary: #333333;
            --text-secondary: #666666;
            --border-color: #e0e0e0;
            --success-color: #4CAF50;
            --error-color: #f44336;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f9f7f3 0%, #f0ebe4 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(63, 35, 5, 0.08);
        }

        /* Left Panel - Illustration/Brand */
        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, var(--primary-color) 0%, #5a3510 100%);
            padding: 60px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .brand-logo {
            font-size: 3.5rem;
            margin-bottom: 20px;
        }

        .brand-name {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .brand-tagline {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 300;
            margin-bottom: 40px;
        }

        .illustration {
            width: 80%;
            max-width: 300px;
            opacity: 0.9;
        }

        /* Right Panel - Login Form */
        .right-panel {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 40px;
        }

        .form-title {
            font-size: 2rem;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-subtitle {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-primary);
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            font-size: 1rem;
            color: var(--text-primary);
            background: white;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(63, 35, 5, 0.1);
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 0.9rem;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input {
            width: 18px;
            height: 18px;
        }

        .forgot-link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: block;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
            border: 2px solid var(--primary-color);
        }

        .btn-primary:hover {
            background: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 30px 0;
            color: var(--text-secondary);
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-color);
        }

        .divider-text {
            padding: 0 15px;
            font-size: 0.9rem;
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .register-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            background: rgba(244, 67, 54, 0.1);
            color: var(--error-color);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: center;
            border-left: 4px solid var(--error-color);
        }

        .success-message {
            background: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: center;
            border-left: 4px solid var(--success-color);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .login-container {
                flex-direction: column;
                max-width: 500px;
            }

            .left-panel {
                padding: 40px 30px;
            }

            .right-panel {
                padding: 40px 30px;
            }

            .brand-name {
                font-size: 1.8rem;
            }

            .form-title {
                font-size: 1.7rem;
            }
        }

        @media (max-width: 480px) {
            .left-panel {
                padding: 30px 20px;
            }

            .right-panel {
                padding: 30px 20px;
            }

            .remember-forgot {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Left Panel - Brand Area -->
        <div class="left-panel">
            <div class="brand-logo">🍽️</div>
            <h1 class="brand-name">LastBite</h1>
            <p class="brand-tagline">Reduce Food Waste, Save Our Planet</p>
            <div class="illustration">
                <!-- Placeholder untuk ilustrasi -->
                <div style="font-size: 5rem; opacity: 0.7;">🌱</div>
            </div>
        </div>

        <!-- Right Panel - Login Form -->
        <div class="right-panel">
            <div class="form-header">
                <h2 class="form-title">Welcome Back</h2>
                <p class="form-subtitle">Sign in to your account to continue</p>
            </div>

            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}"
                        placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" class="form-input"
                            placeholder="Enter your password" required>
                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">
                            Show
                        </button>
                    </div>
                </div>

                <div class="remember-forgot">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="forgot-link">
                        Forgot Password?
                    </a>
                </div>

                <button type="submit" class="btn btn-primary">Sign In</button>

                <div class="divider">
                    <span class="divider-text">New to LastBite?</span>
                </div>

                @php
                    // Ambil role dari query parameter atau default ke 'buyer'
                    $selectedRole = request()->query('role', 'buyer');
                @endphp

                <a href="{{ route('register', ['role' => $selectedRole]) }}" class="btn btn-primary">
                    Create New Account
                </a>

                <div class="register-link">
                    Don't have an account?
                    <a href="{{ route('register', ['role' => $selectedRole]) }}">
                        Sign up here
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.querySelector('.toggle-password');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.textContent = 'Hide';
            } else {
                passwordInput.type = 'password';
                toggleButton.textContent = 'Show';
            }
        }

        // Auto-focus pada email field
        document.addEventListener('DOMContentLoaded', function() {
            const emailField = document.getElementById('email');
            if (emailField && !emailField.value) {
                emailField.focus();
            }
        });
    </script>
</body>

</html>
