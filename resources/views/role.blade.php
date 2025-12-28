<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Your Role - LastBite</title>

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
            --buyer-color: #2196F3;
            --seller-color: #4CAF50;
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
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(63, 35, 5, 0.05);
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .nav-logo {
            height: 35px;
        }

        .nav-brand-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .nav-login-btn {
            padding: 10px 30px;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            border: 2px solid var(--primary-color);
        }

        .nav-login-btn:hover {
            background: white;
            color: var(--primary-color);
        }

        /* Main Container */
        .role-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 140px 40px 80px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* Hero Section */
        .hero-section {
            text-align: center;
            margin-bottom: 80px;
            position: relative;
            max-width: 800px;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 20px;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 60px;
        }

        /* Role Selection */
        .role-selection {
            display: flex;
            gap: 40px;
            justify-content: center;
            width: 100%;
            max-width: 1000px;
            margin-bottom: 80px;
        }

        .role-card {
            flex: 1;
            background: white;
            border-radius: 25px;
            padding: 60px 40px;
            text-align: center;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 15px 40px rgba(63, 35, 5, 0.08);
            border: 3px solid transparent;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 500px;
        }

        .role-card:hover {
            transform: translateY(-20px);
            box-shadow: 0 25px 60px rgba(63, 35, 5, 0.15);
        }

        .role-card.buyer:hover {
            border-color: var(--buyer-color);
        }

        .role-card.seller:hover {
            border-color: var(--seller-color);
        }

        .role-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
        }

        .role-card.buyer::before {
            background: linear-gradient(to right, #64b5f6, #2196F3);
        }

        .role-card.seller::before {
            background: linear-gradient(to right, #81c784, #4CAF50);
        }

        .role-icon {
            width: 160px;
            height: 160px;
            margin-bottom: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .role-card.buyer .role-icon {
            background: linear-gradient(135deg, rgba(33, 150, 243, 0.1) 0%, rgba(33, 150, 243, 0.05) 100%);
        }

        .role-card.seller .role-icon {
            background: linear-gradient(135deg, rgba(76, 175, 80, 0.1) 0%, rgba(76, 175, 80, 0.05) 100%);
        }

        .role-icon img {
            width: 120px;
            height: 120px;
            object-fit: contain;
            filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.1));
        }

        .role-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 25px;
            color: var(--text-primary);
        }

        .role-card.buyer .role-title {
            color: var(--buyer-color);
        }

        .role-card.seller .role-title {
            color: var(--seller-color);
        }

        .role-description {
            font-size: 1.1rem;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 40px;
            flex-grow: 1;
        }

        .role-features {
            list-style: none;
            padding: 0;
            width: 100%;
            text-align: left;
            margin-bottom: 40px;
        }

        .role-feature {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(63, 35, 5, 0.03);
            border-radius: 12px;
        }

        .role-card.buyer .role-feature {
            border-left: 4px solid var(--buyer-color);
        }

        .role-card.seller .role-feature {
            border-left: 4px solid var(--seller-color);
        }

        .feature-icon {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .feature-text {
            font-size: 0.95rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .role-button {
            padding: 16px 40px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            width: 100%;
            text-align: center;
            margin-top: auto;
        }

        .role-card.buyer .role-button {
            background: var(--buyer-color);
            color: white;
            border-color: var(--buyer-color);
        }

        .role-card.buyer .role-button:hover {
            background: white;
            color: var(--buyer-color);
        }

        .role-card.seller .role-button {
            background: var(--seller-color);
            color: white;
            border-color: var(--seller-color);
        }

        .role-card.seller .role-button:hover {
            background: white;
            color: var(--seller-color);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 60px 0;
            color: var(--text-secondary);
            position: relative;
            width: 100%;
            max-width: 500px;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 45%;
            height: 1px;
            background: var(--border-color);
        }

        .divider::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            width: 45%;
            height: 1px;
            background: var(--border-color);
        }

        .divider-text {
            padding: 0 20px;
            font-size: 1rem;
            background: linear-gradient(135deg, #f9f7f3 0%, #f0ebe4 100%);
            position: relative;
            z-index: 1;
        }

        /* Already Have Account */
        .existing-account {
            text-align: center;
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(63, 35, 5, 0.08);
            max-width: 600px;
            width: 100%;
        }

        .existing-title {
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            font-weight: 600;
        }

        .existing-description {
            font-size: 1.1rem;
            color: var(--text-secondary);
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .login-btn {
            padding: 16px 50px;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: 2px solid var(--primary-color);
            display: inline-block;
            box-shadow: 0 8px 25px rgba(63, 35, 5, 0.2);
        }

        .login-btn:hover {
            background: white;
            color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(63, 35, 5, 0.25);
        }

        /* Footer */
        .page-footer {
            text-align: center;
            margin-top: 80px;
            padding-top: 40px;
            border-top: 1px solid rgba(63, 35, 5, 0.1);
            color: var(--text-secondary);
            font-size: 0.9rem;
            width: 100%;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 20px;
        }

        .footer-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: var(--accent-color);
        }

        /* Animation */
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

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .float {
            animation: float 3s ease-in-out infinite;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-title {
                font-size: 3rem;
            }

            .role-selection {
                flex-direction: column;
                align-items: center;
                max-width: 500px;
            }

            .role-card {
                width: 100%;
                min-height: auto;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
            }

            .role-container {
                padding: 120px 20px 60px;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .role-card {
                padding: 40px 30px;
            }

            .role-icon {
                width: 120px;
                height: 120px;
                margin-bottom: 30px;
            }

            .role-icon img {
                width: 90px;
                height: 90px;
            }

            .role-title {
                font-size: 1.8rem;
            }

            .existing-account {
                padding: 40px 30px;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem;
            }

            .role-title {
                font-size: 1.6rem;
            }

            .existing-title {
                font-size: 1.5rem;
            }

            .divider::before,
            .divider::after {
                width: 40%;
            }

            .footer-links {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="{{ url('/') }}" class="nav-brand">
            <img class="nav-logo" src="{{ asset('images/logo-lastbite.png') }}" alt="LastBite">
            <span class="nav-brand-name">LastBite</span>
        </a>
        <a href="{{ route('login') }}" class="nav-login-btn">Log In</a>
    </nav>

    <!-- Main Content -->
    <div class="role-container">
        <!-- Hero Section -->
        <section class="hero-section animate">
            <h1 class="hero-title">Who Are You?</h1>
            <p class="hero-subtitle">
                Choose your role to get started with LastBite. Whether you want to save money on delicious meals
                or reduce food waste from your business, we have the perfect solution for you.
            </p>
        </section>

        <!-- Role Selection -->
        <div class="role-selection">
            <!-- Buyer Card -->
            <a href="{{ route('register') }}?role=buyer" class="role-card buyer animate">
                <div class="role-icon float">
                    <img src="{{ asset('images/buyer.png') }}" alt="Buyer">
                </div>
                <h2 class="role-title">Buyer</h2>
                <p class="role-description">
                    Looking for delicious meals at amazing prices? Join as a buyer to discover discounted
                    food from your favorite restaurants and help reduce food waste.
                </p>

                <ul class="role-features">
                    <li class="role-feature">
                        <span class="feature-icon">💰</span>
                        <span class="feature-text">Save 30-70% on quality meals</span>
                    </li>
                    <li class="role-feature">
                        <span class="feature-icon">📍</span>
                        <span class="feature-text">Discover restaurants near you</span>
                    </li>
                    <li class="role-feature">
                        <span class="feature-icon">🌱</span>
                        <span class="feature-text">Make a positive environmental impact</span>
                    </li>
                </ul>

                <div class="role-button">Join as Buyer</div>
            </a>

            <!-- Seller Card -->
            <a href="{{ route('register') }}?role=seller" class="role-card seller animate">
                <div class="role-icon float" style="animation-delay: 0.5s;">
                    <img src="{{ asset('images/seller.png') }}" alt="Seller">
                </div>
                <h2 class="role-title">Seller</h2>
                <p class="role-description">
                    Have surplus food? Join as a seller to connect with conscious consumers,
                    reduce waste, and recover costs on excess inventory.
                </p>

                <ul class="role-features">
                    <li class="role-feature">
                        <span class="feature-icon">📈</span>
                        <span class="feature-text">Recover costs on surplus food</span>
                    </li>
                    <li class="role-feature">
                        <span class="feature-icon">👥</span>
                        <span class="feature-text">Reach new customers</span>
                    </li>
                    <li class="role-feature">
                        <span class="feature-icon">🏆</span>
                        <span class="feature-text">Build your sustainable brand</span>
                    </li>
                </ul>

                <div class="role-button">Join as Seller</div>
            </a>
        </div>

        <!-- Divider -->
        <div class="divider">
            <span class="divider-text">Already have an account?</span>
        </div>

        <!-- Existing Account Section -->
        <div class="existing-account animate">
            <h3 class="existing-title">Welcome Back!</h3>
            <p class="existing-description">
                If you already have a LastBite account, you can sign in directly.
                Your journey to reducing food waste continues here.
            </p>
            <a href="{{ route('login') }}" class="login-btn">Sign In to Your Account</a>
        </div>

        <!-- Footer -->
        <footer class="page-footer">
            <div class="footer-links">
                <a href="{{ url('/') }}" class="footer-link">Home</a>
                <a href="{{ url('/about') }}" class="footer-link">About</a>
                <a href="{{ url('/edukasi') }}" class="footer-link">Education</a>
                <a href="{{ url('/fitur') }}" class="footer-link">Features</a>
            </div>
            <p>© 2024 LastBite. All rights reserved. Choose your role, join our mission.</p>
        </footer>
    </div>

    <script>
        // Animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const animateElements = document.querySelectorAll('.animate');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';

                        // Add float animation to role icons
                        if (entry.target.classList.contains('role-card')) {
                            const icon = entry.target.querySelector('.role-icon');
                            if (icon) {
                                icon.classList.add('float');
                            }
                        }
                    }
                });
            }, {
                threshold: 0.1
            });

            animateElements.forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(30px)';
                element.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
                observer.observe(element);
            });

            // Store selected role in sessionStorage
            const buyerCard = document.querySelector('.role-card.buyer');
            const sellerCard = document.querySelector('.role-card.seller');

            if (buyerCard) {
                buyerCard.addEventListener('click', function() {
                    sessionStorage.setItem('selectedRole', 'pembeli');
                });
            }

            if (sellerCard) {
                sellerCard.addEventListener('click', function() {
                    sessionStorage.setItem('selectedRole', 'penjual');
                });
            }

            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.navbar');
                if (window.scrollY > 50) {
                    navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                    navbar.style.boxShadow = '0 2px 30px rgba(63, 35, 5, 0.1)';
                } else {
                    navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                    navbar.style.boxShadow = '0 2px 20px rgba(63, 35, 5, 0.05)';
                }
            });
        });
        <!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Your Role - LastBite</title>

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
            --buyer-color: #2196F3;
            --seller-color: #4CAF50;
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
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(63, 35, 5, 0.05);
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .nav-logo {
            height: 35px;
        }

        .nav-brand-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .nav-login-btn {
            padding: 10px 30px;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            border: 2px solid var(--primary-color);
        }

        .nav-login-btn:hover {
            background: white;
            color: var(--primary-color);
        }

        /* Main Container */
        .role-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 140px 40px 80px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* Hero Section */
        .hero-section {
            text-align: center;
            margin-bottom: 80px;
            position: relative;
            max-width: 800px;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 20px;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 60px;
        }

        /* Role Selection */
        .role-selection {
            display: flex;
            gap: 40px;
            justify-content: center;
            width: 100%;
            max-width: 1000px;
            margin-bottom: 80px;
        }

        .role-card {
            flex: 1;
            background: white;
            border-radius: 25px;
            padding: 60px 40px;
            text-align: center;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 15px 40px rgba(63, 35, 5, 0.08);
            border: 3px solid transparent;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 500px;
        }

        .role-card:hover {
            transform: translateY(-20px);
            box-shadow: 0 25px 60px rgba(63, 35, 5, 0.15);
        }

        .role-card.buyer:hover {
            border-color: var(--buyer-color);
        }

        .role-card.seller:hover {
            border-color: var(--seller-color);
        }

        .role-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
        }

        .role-card.buyer::before {
            background: linear-gradient(to right, #64b5f6, #2196F3);
        }

        .role-card.seller::before {
            background: linear-gradient(to right, #81c784, #4CAF50);
        }

        .role-icon {
            width: 160px;
            height: 160px;
            margin-bottom: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .role-card.buyer .role-icon {
            background: linear-gradient(135deg, rgba(33, 150, 243, 0.1) 0%, rgba(33, 150, 243, 0.05) 100%);
        }

        .role-card.seller .role-icon {
            background: linear-gradient(135deg, rgba(76, 175, 80, 0.1) 0%, rgba(76, 175, 80, 0.05) 100%);
        }

        .role-icon img {
            width: 120px;
            height: 120px;
            object-fit: contain;
            filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.1));
        }

        .role-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 25px;
            color: var(--text-primary);
        }

        .role-card.buyer .role-title {
            color: var(--buyer-color);
        }

        .role-card.seller .role-title {
            color: var(--seller-color);
        }

        .role-description {
            font-size: 1.1rem;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 40px;
            flex-grow: 1;
        }

        .role-features {
            list-style: none;
            padding: 0;
            width: 100%;
            text-align: left;
            margin-bottom: 40px;
        }

        .role-feature {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(63, 35, 5, 0.03);
            border-radius: 12px;
        }

        .role-card.buyer .role-feature {
            border-left: 4px solid var(--buyer-color);
        }

        .role-card.seller .role-feature {
            border-left: 4px solid var(--seller-color);
        }

        .feature-icon {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .feature-text {
            font-size: 0.95rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .role-button {
            padding: 16px 40px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            width: 100%;
            text-align: center;
            margin-top: auto;
        }

        .role-card.buyer .role-button {
            background: var(--buyer-color);
            color: white;
            border-color: var(--buyer-color);
        }

        .role-card.buyer .role-button:hover {
            background: white;
            color: var(--buyer-color);
        }

        .role-card.seller .role-button {
            background: var(--seller-color);
            color: white;
            border-color: var(--seller-color);
        }

        .role-card.seller .role-button:hover {
            background: white;
            color: var(--seller-color);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 60px 0;
            color: var(--text-secondary);
            position: relative;
            width: 100%;
            max-width: 500px;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 45%;
            height: 1px;
            background: var(--border-color);
        }

        .divider::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            width: 45%;
            height: 1px;
            background: var(--border-color);
        }

        .divider-text {
            padding: 0 20px;
            font-size: 1rem;
            background: linear-gradient(135deg, #f9f7f3 0%, #f0ebe4 100%);
            position: relative;
            z-index: 1;
        }

        /* Already Have Account */
        .existing-account {
            text-align: center;
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(63, 35, 5, 0.08);
            max-width: 600px;
            width: 100%;
        }

        .existing-title {
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            font-weight: 600;
        }

        .existing-description {
            font-size: 1.1rem;
            color: var(--text-secondary);
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .login-btn {
            padding: 16px 50px;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: 2px solid var(--primary-color);
            display: inline-block;
            box-shadow: 0 8px 25px rgba(63, 35, 5, 0.2);
        }

        .login-btn:hover {
            background: white;
            color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(63, 35, 5, 0.25);
        }

        /* Footer */
        .page-footer {
            text-align: center;
            margin-top: 80px;
            padding-top: 40px;
            border-top: 1px solid rgba(63, 35, 5, 0.1);
            color: var(--text-secondary);
            font-size: 0.9rem;
            width: 100%;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 20px;
        }

        .footer-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: var(--accent-color);
        }

        /* Animation */
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

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .float {
            animation: float 3s ease-in-out infinite;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-title {
                font-size: 3rem;
            }

            .role-selection {
                flex-direction: column;
                align-items: center;
                max-width: 500px;
            }

            .role-card {
                width: 100%;
                min-height: auto;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
            }

            .role-container {
                padding: 120px 20px 60px;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .role-card {
                padding: 40px 30px;
            }

            .role-icon {
                width: 120px;
                height: 120px;
                margin-bottom: 30px;
            }

            .role-icon img {
                width: 90px;
                height: 90px;
            }

            .role-title {
                font-size: 1.8rem;
            }

            .existing-account {
                padding: 40px 30px;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem;
            }

            .role-title {
                font-size: 1.6rem;
            }

            .existing-title {
                font-size: 1.5rem;
            }

            .divider::before,
            .divider::after {
                width: 40%;
            }

            .footer-links {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="{{ url('/') }}" class="nav-brand">
            <img class="nav-logo" src="{{ asset('images/logo-lastbite.png') }}" alt="LastBite">
            <span class="nav-brand-name">LastBite</span>
        </a>
        <a href="{{ route('login') }}" class="nav-login-btn">Log In</a>
    </nav>

    <!-- Main Content -->
    <div class="role-container">
        <!-- Hero Section -->
        <section class="hero-section animate">
            <h1 class="hero-title">Who Are You?</h1>
            <p class="hero-subtitle">
                Choose your role to get started with LastBite. Whether you want to save money on delicious meals
                or reduce food waste from your business, we have the perfect solution for you.
            </p>
        </section>

        <!-- Role Selection -->
        <div class="role-selection">
            <!-- Buyer Card -->
            <a href="{{ route('register') }}?role=pembeli" class="role-card buyer animate">
                <div class="role-icon float">
                    <img src="{{ asset('images/buyer.png') }}" alt="Buyer">
                </div>
                <h2 class="role-title">Buyer</h2>
                <p class="role-description">
                    Looking for delicious meals at amazing prices? Join as a buyer to discover discounted
                    food from your favorite restaurants and help reduce food waste.
                </p>

                <ul class="role-features">
                    <li class="role-feature">
                        <span class="feature-icon">💰</span>
                        <span class="feature-text">Save 30-70% on quality meals</span>
                    </li>
                    <li class="role-feature">
                        <span class="feature-icon">📍</span>
                        <span class="feature-text">Discover restaurants near you</span>
                    </li>
                    <li class="role-feature">
                        <span class="feature-icon">🌱</span>
                        <span class="feature-text">Make a positive environmental impact</span>
                    </li>
                </ul>

                <div class="role-button">Join as Buyer</div>
            </a>

            <!-- Seller Card -->
            <a href="{{ route('register') }}?role=penjual" class="role-card seller animate">
                <div class="role-icon float" style="animation-delay: 0.5s;">
                    <img src="{{ asset('images/seller.png') }}" alt="Seller">
                </div>
                <h2 class="role-title">Seller</h2>
                <p class="role-description">
                    Have surplus food? Join as a seller to connect with conscious consumers,
                    reduce waste, and recover costs on excess inventory.
                </p>

                <ul class="role-features">
                    <li class="role-feature">
                        <span class="feature-icon">📈</span>
                        <span class="feature-text">Recover costs on surplus food</span>
                    </li>
                    <li class="role-feature">
                        <span class="feature-icon">👥</span>
                        <span class="feature-text">Reach new customers</span>
                    </li>
                    <li class="role-feature">
                        <span class="feature-icon">🏆</span>
                        <span class="feature-text">Build your sustainable brand</span>
                    </li>
                </ul>

                <div class="role-button">Join as Seller</div>
            </a>
        </div>

        <!-- Divider -->
        <div class="divider">
            <span class="divider-text">Already have an account?</span>
        </div>

        <!-- Existing Account Section -->
        <div class="existing-account animate">
            <h3 class="existing-title">Welcome Back!</h3>
            <p class="existing-description">
                If you already have a LastBite account, you can sign in directly.
                Your journey to reducing food waste continues here.
            </p>
            <a href="{{ route('login') }}" class="login-btn">Sign In to Your Account</a>
        </div>

        <!-- Footer -->
        <footer class="page-footer">
            <div class="footer-links">
                <a href="{{ url('/') }}" class="footer-link">Home</a>
                <a href="{{ url('/about') }}" class="footer-link">About</a>
                <a href="{{ url('/edukasi') }}" class="footer-link">Education</a>
                <a href="{{ url('/fitur') }}" class="footer-link">Features</a>
            </div>
            <p>© 2024 LastBite. All rights reserved. Choose your role, join our mission.</p>
        </footer>
    </div>

    <script>
        // Animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const animateElements = document.querySelectorAll('.animate');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';

                        // Add float animation to role icons
                        if (entry.target.classList.contains('role-card')) {
                            const icon = entry.target.querySelector('.role-icon');
                            if (icon) {
                                icon.classList.add('float');
                            }
                        }
                    }
                });
            }, {
                threshold: 0.1
            });

            animateElements.forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(30px)';
                element.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
                observer.observe(element);
            });

            // Store selected role in sessionStorage
            const buyerCard = document.querySelector('.role-card.buyer');
            const sellerCard = document.querySelector('.role-card.seller');

            if (buyerCard) {
                buyerCard.addEventListener('click', function() {
                    sessionStorage.setItem('selectedRole', 'pembeli');
                });
            }

            if (sellerCard) {
                sellerCard.addEventListener('click', function() {
                    sessionStorage.setItem('selectedRole', 'penjual');
                });
            }

            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.navbar');
                if (window.scrollY > 50) {
                    navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                    navbar.style.boxShadow = '0 2px 30px rgba(63, 35, 5, 0.1)';
                } else {
                    navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                    navbar.style.boxShadow = '0 2px 20px rgba(63, 35, 5, 0.05)';
                }
            });
        });
</html>
    </script>
</body>

</html>
