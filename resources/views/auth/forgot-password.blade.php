<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - LastBite</title>

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
        }

        /* Left Panel - Hero Image */
        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, var(--primary-color) 0%, #5a3510 100%);
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.3;
        }

        .back-to-home {
            position: absolute;
            top: 40px;
            left: 40px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            z-index: 2;
            opacity: 0.9;
            transition: opacity 0.3s ease;
        }

        .back-to-home:hover {
            opacity: 1;
        }

        .back-icon {
            font-size: 1.2rem;
        }

        .hero-content {
            text-align: center;
            position: relative;
            z-index: 2;
            max-width: 500px;
        }

        .brand-logo {
            width: 100px;
            height: 100px;
            margin-bottom: 30px;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.2));
        }

        .brand-name {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .brand-tagline {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 40px;
            font-weight: 300;
        }

        .hero-image {
            width: 100%;
            max-width: 400px;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        }

        /* Right Panel - Form */
        .right-panel {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .form-container {
            width: 100%;
            max-width: 450px;
        }

        .form-header {
            margin-bottom: 40px;
            text-align: center;
        }

        .form-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 15px;
            letter-spacing: -0.5px;
        }

        .form-subtitle {
            font-size: 1.1rem;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .form-subtitle a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .form-subtitle a:hover {
            text-decoration: underline;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 30px;
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            color: var(--text-primary);
            font-weight: 500;
            font-size: 1rem;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 1rem;
            color: var(--text-primary);
            background: white;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(63, 35, 5, 0.1);
        }

        .form-input::placeholder {
            color: #999;
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 18px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid var(--primary-color);
            margin-top: 10px;
        }

        .submit-btn:hover {
            background: white;
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(63, 35, 5, 0.15);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* Success Message */
        .success-message {
            background: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            font-size: 1rem;
            text-align: center;
            border-left: 4px solid var(--success-color);
            display: none;
        }

        .success-message.show {
            display: block;
            animation: slideIn 0.5s ease-out;
        }

        /* Error Message */
        .error-message {
            background: rgba(244, 67, 54, 0.1);
            color: var(--error-color);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            font-size: 1rem;
            text-align: center;
            border-left: 4px solid var(--error-color);
            display: none;
        }

        .error-message.show {
            display: block;
            animation: slideIn 0.5s ease-out;
        }

        /* Instructions */
        .instructions {
            background: rgba(63, 35, 5, 0.05);
            padding: 25px;
            border-radius: 12px;
            margin-top: 40px;
            border-left: 4px solid var(--accent-color);
        }

        .instructions-title {
            font-size: 1.1rem;
            color: var(--primary-color);
            margin-bottom: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .instructions-list {
            list-style: none;
            padding: 0;
        }

        .instructions-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 12px;
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .instructions-item:last-child {
            margin-bottom: 0;
        }

        .item-icon {
            color: var(--accent-color);
            font-size: 1.2rem;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* Login Link */
        .login-link {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid var(--border-color);
            color: var(--text-secondary);
            font-size: 1rem;
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Animation */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate {
            animation: fadeIn 0.8s ease-out;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .left-panel {
                padding: 40px;
            }

            .right-panel {
                padding: 40px;
            }

            .form-title {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .left-panel {
                padding: 40px 20px;
                min-height: 300px;
            }

            .right-panel {
                padding: 40px 20px;
            }

            .back-to-home {
                top: 20px;
                left: 20px;
            }

            .brand-logo {
                width: 80px;
                height: 80px;
                margin-bottom: 20px;
            }

            .brand-name {
                font-size: 2rem;
            }

            .brand-tagline {
                font-size: 1rem;
            }

            .hero-image {
                max-width: 300px;
            }

            .form-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .brand-name {
                font-size: 1.8rem;
            }

            .form-title {
                font-size: 1.8rem;
            }

            .form-container {
                padding: 0 15px;
            }

            .instructions {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Left Panel - Hero & Brand -->
    <div class="left-panel">
        <a href="{{ url('/') }}" class="back-to-home">
            <span class="back-icon">←</span>
            <span>Back to Home</span>
        </a>

        <div class="hero-content animate">
            <img class="brand-logo" src="{{ asset('images/logo-lastbite.png') }}" alt="LastBite">
            <h1 class="brand-name">LastBite</h1>
            <p class="brand-tagline">Reduce Food Waste, Save Our Planet</p>

            <img class="hero-image" src="{{ asset('images/hero-auth.png') }}" alt="Food Rescue">
        </div>
    </div>

    <!-- Right Panel - Reset Password Form -->
    <div class="right-panel">
        <div class="form-container animate">
            <div class="form-header">
                <h2 class="form-title">Reset Password</h2>
                <p class="form-subtitle">
                    Enter your email address and we'll send you a link to reset your password.
                    <br>Remember your password? <a href="{{ route('login') }}">Sign in here</a>
                </p>
            </div>

            <!-- Success Message from Session -->
            @if (session('success'))
                <div class="success-message show">
                    <strong>✓ {{ session('success') }}</strong><br>
                    Please check your email for the password reset link.
                </div>
            @endif

            <!-- Reset Password Form -->
            <form method="POST" action="{{ route('password.email') }}" id="resetForm">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-input"
                        placeholder="Enter your registered email address" value="{{ old('email') }}" required
                        autocomplete="email" autofocus>
                    @error('email')
                        <div class="error-message show">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">
                    Send Reset Link
                </button>
            </form>

            <!-- Instructions -->
            <div class="instructions">
                <div class="instructions-title">
                    <span>📧</span>
                    <span>What happens next?</span>
                </div>
                <ul class="instructions-list">
                    <li class="instructions-item">
                        <span class="item-icon">✓</span>
                        <span>We'll send a password reset link to your email</span>
                    </li>
                    <li class="instructions-item">
                        <span class="item-icon">✓</span>
                        <span>Click the link in the email to reset your password</span>
                    </li>
                    <li class="instructions-item">
                        <span class="item-icon">✓</span>
                        <span>Create a new password and sign back in</span>
                    </li>
                </ul>
            </div>

            <!-- Login Link -->
            <div class="login-link">
                Remember your password? <a href="{{ route('login') }}">Sign in to your account</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('resetForm');
            const emailInput = document.getElementById('email');

            // Auto-focus email input on page load
            emailInput.focus();

            // Form validation
            form.addEventListener('submit', function(e) {
                const email = emailInput.value.trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!emailRegex.test(email)) {
                    e.preventDefault();
                    alert('Please enter a valid email address');
                    emailInput.focus();
                    return;
                }
            });

            // Add animation to form elements
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.animate').forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(30px)';
                element.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
                observer.observe(element);
            });
        });
    </script>
</body>

</html>
