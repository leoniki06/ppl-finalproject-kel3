<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastBite - Reduce Food Waste</title>

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
            overflow-x: hidden;
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
            justify-content: flex-end;
            align-items: center;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(63, 35, 5, 0.05);
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
        .splash-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 100px 40px 60px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        /* Logo Area */
        .logo-area {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
            z-index: 2;
        }

        .main-logo {
            height: 120px;
            margin-bottom: 20px;
            filter: drop-shadow(0 5px 15px rgba(63, 35, 5, 0.1));
        }

        .brand-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .brand-tagline {
            font-size: 1.2rem;
            color: var(--text-secondary);
            font-weight: 400;
            max-width: 500px;
            margin: 0 auto;
        }

        /* Food Items Container */
        .food-items-container {
            position: relative;
            width: 100%;
            height: 400px;
            margin: 40px 0 60px;
        }

        /* Food Items - Position them creatively */
        .food-item {
            position: absolute;
            transition: transform 0.5s ease;
            filter: drop-shadow(0 8px 20px rgba(63, 35, 5, 0.15));
        }

        .food-item:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .cookie-dark-1 {
            width: 80px;
            top: 10%;
            left: 10%;
        }

        .pretzel {
            width: 100px;
            top: 20%;
            right: 15%;
        }

        .cookie-light {
            width: 70px;
            bottom: 30%;
            left: 15%;
        }

        .cookie-dark-2 {
            width: 85px;
            bottom: 20%;
            right: 20%;
        }

        .cake {
            width: 110px;
            top: 40%;
            left: 50%;
            transform: translateX(-50%);
        }

        /* Call to Action */
        .cta-container {
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .cta-title {
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-weight: 600;
        }

        .next-btn {
            display: inline-block;
            padding: 16px 50px;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: 2px solid var(--primary-color);
            box-shadow: 0 8px 25px rgba(63, 35, 5, 0.2);
        }

        .next-btn:hover {
            background: white;
            color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(63, 35, 5, 0.25);
        }

        /* Stats Bar */
        .stats-bar {
            display: flex;
            justify-content: center;
            gap: 60px;
            margin-top: 80px;
            padding: 30px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(63, 35, 5, 0.08);
            position: relative;
            z-index: 2;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            display: block;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.95rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* Background Elements */
        .bg-circle {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(212, 165, 116, 0.1) 0%, rgba(63, 35, 5, 0.05) 100%);
            z-index: 1;
        }

        .circle-1 {
            width: 300px;
            height: 300px;
            top: 10%;
            left: -150px;
        }

        .circle-2 {
            width: 400px;
            height: 400px;
            bottom: 10%;
            right: -200px;
        }

        /* Footer */
        .splash-footer {
            text-align: center;
            margin-top: 60px;
            padding-top: 30px;
            border-top: 1px solid rgba(63, 35, 5, 0.1);
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .brand-title {
                font-size: 3rem;
            }

            .food-items-container {
                height: 350px;
            }

            .stats-bar {
                gap: 40px;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
            }

            .splash-container {
                padding: 90px 20px 40px;
            }

            .brand-title {
                font-size: 2.5rem;
            }

            .brand-tagline {
                font-size: 1.1rem;
                padding: 0 20px;
            }

            .food-items-container {
                height: 300px;
                margin: 30px 0 40px;
            }

            .food-item {
                width: 60px !important;
            }

            .cake {
                width: 80px !important;
            }

            .cta-title {
                font-size: 1.5rem;
            }

            .stats-bar {
                flex-direction: column;
                gap: 25px;
                padding: 25px;
                margin-top: 50px;
            }

            .stat-number {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .brand-title {
                font-size: 2rem;
            }

            .main-logo {
                height: 80px;
            }

            .food-items-container {
                height: 250px;
            }

            .food-item {
                width: 50px !important;
            }

            .cake {
                width: 70px !important;
            }

            .next-btn {
                padding: 14px 40px;
                font-size: 1rem;
            }
        }

        /* Animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        .delay-1 {
            animation-delay: 0.5s;
        }

        .delay-2 {
            animation-delay: 1s;
        }

        .delay-3 {
            animation-delay: 1.5s;
        }

        .delay-4 {
            animation-delay: 2s;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="{{ route('login') }}" class="nav-login-btn">Log In</a>
    </nav>

    <!-- Main Content -->
    <div class="splash-container">
        <!-- Background Circles -->
        <div class="bg-circle circle-1"></div>
        <div class="bg-circle circle-2"></div>

        <!-- Logo & Brand -->
        <div class="logo-area">
            <img class="main-logo" src="{{ asset('images/logo-lastbite.png') }}" alt="LastBite">
            <h1 class="brand-title">LastBite</h1>
            <p class="brand-tagline">Reduce Food Waste, Save Our Planet - One Meal at a Time</p>
        </div>

        <!-- Animated Food Items -->
        <div class="food-items-container">
            <img class="food-item cookie-dark-1 floating" src="{{ asset('images/cookie-dark.png') }}" alt="Cookie">
            <img class="food-item pretzel floating delay-1" src="{{ asset('images/pretzel.png') }}" alt="Pretzel">
            <img class="food-item cookie-light floating delay-2" src="{{ asset('images/cookie-light.png') }}"
                alt="Cookie">
            <img class="food-item cookie-dark-2 floating delay-3" src="{{ asset('images/cookie-dark.png') }}"
                alt="Cookie">
            <img class="food-item cake floating delay-4" src="{{ asset('images/cake.png') }}" alt="Cake">
        </div>

        <!-- Call to Action -->
        <div class="cta-container">
            <h2 class="cta-title">Ready to Make a Difference?</h2>
            <a href="{{ url('/about') }}" class="next-btn">Discover How →</a>
        </div>

        <!-- Stats -->
        <div class="stats-bar">
            <div class="stat-item">
                <span class="stat-number">50K+</span>
                <span class="stat-label">Food Items Saved</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">200+</span>
                <span class="stat-label">Partner Restaurants</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">10K+</span>
                <span class="stat-label">Happy Users</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="splash-footer">
            <p>© 2024 LastBite. All rights reserved. Join us in creating a sustainable future.</p>
        </div>
    </div>

    <script>
        // Add interactive hover effects
        document.addEventListener('DOMContentLoaded', function() {
            const foodItems = document.querySelectorAll('.food-item');

            foodItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.zIndex = '10';
                });

                item.addEventListener('mouseleave', function() {
                    this.style.zIndex = '1';
                });
            });

            // Add scroll effect to navbar
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
    </script>
</body>

</html>
