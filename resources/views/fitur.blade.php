<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Features - LastBite</title>

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
            --feature-1: #4CAF50;
            --feature-2: #2196F3;
            --feature-3: #9C27B0;
            --feature-4: #FF9800;
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
        .features-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 120px 40px 80px;
            min-height: 100vh;
        }

        /* Hero Section */
        .hero-section {
            text-align: center;
            margin-bottom: 80px;
            position: relative;
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
            max-width: 700px;
            margin: 0 auto 50px;
            line-height: 1.7;
        }

        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
            margin-bottom: 80px;
        }

        .feature-card {
            background: white;
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(63, 35, 5, 0.08);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .feature-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 50px rgba(63, 35, 5, 0.15);
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
        }

        .feature-card:nth-child(1)::before {
            background: var(--feature-1);
        }

        .feature-card:nth-child(2)::before {
            background: var(--feature-2);
        }

        .feature-card:nth-child(3)::before {
            background: var(--feature-3);
        }

        .feature-card:nth-child(4)::before {
            background: var(--feature-4);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            margin-bottom: 30px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .feature-card:nth-child(1) .feature-icon {
            background: rgba(76, 175, 80, 0.1);
        }

        .feature-card:nth-child(2) .feature-icon {
            background: rgba(33, 150, 243, 0.1);
        }

        .feature-card:nth-child(3) .feature-icon {
            background: rgba(156, 39, 176, 0.1);
        }

        .feature-card:nth-child(4) .feature-icon {
            background: rgba(255, 152, 0, 0.1);
        }

        .feature-icon img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .feature-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 20px;
            line-height: 1.3;
        }

        .feature-card:nth-child(1) .feature-title {
            color: var(--feature-1);
        }

        .feature-card:nth-child(2) .feature-title {
            color: var(--feature-2);
        }

        .feature-card:nth-child(3) .feature-title {
            color: var(--feature-3);
        }

        .feature-card:nth-child(4) .feature-title {
            color: var(--feature-4);
        }

        .feature-description {
            font-size: 1.1rem;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .feature-benefits {
            list-style: none;
            padding: 0;
            text-align: left;
            width: 100%;
        }

        .feature-benefit {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 15px;
            padding: 12px 15px;
            background: rgba(63, 35, 5, 0.03);
            border-radius: 10px;
        }

        .benefit-icon {
            font-size: 1.2rem;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .benefit-text {
            font-size: 0.95rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        /* Value Proposition */
        .value-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #5a3510 100%);
            padding: 80px 60px;
            border-radius: 20px;
            margin-bottom: 80px;
            color: white;
            text-align: center;
            box-shadow: 0 15px 40px rgba(63, 35, 5, 0.15);
            position: relative;
            overflow: hidden;
        }

        .value-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.1;
        }

        .value-title {
            font-size: 2.5rem;
            margin-bottom: 30px;
            font-weight: 600;
            position: relative;
            z-index: 2;
        }

        .value-stats {
            display: flex;
            justify-content: center;
            gap: 60px;
            margin: 50px 0;
            position: relative;
            z-index: 2;
        }

        .value-stat {
            text-align: center;
        }

        .value-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
            display: block;
        }

        .value-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .value-description {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
            position: relative;
            z-index: 2;
        }

        /* How It Works */
        .how-it-works {
            background: white;
            padding: 60px 50px;
            border-radius: 20px;
            margin-bottom: 80px;
            box-shadow: 0 10px 40px rgba(63, 35, 5, 0.08);
        }

        .how-it-works-title {
            font-size: 2rem;
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 50px;
            font-weight: 600;
        }

        .steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            max-width: 900px;
            margin: 0 auto;
        }

        .steps::before {
            content: '';
            position: absolute;
            top: 40px;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(to right, var(--feature-1), var(--feature-2), var(--feature-3), var(--feature-4));
            z-index: 1;
        }

        .step {
            text-align: center;
            position: relative;
            z-index: 2;
            flex: 1;
            padding: 0 20px;
        }

        .step-number {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            border: 3px solid var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0 auto 20px;
            position: relative;
        }

        .step-title {
            font-size: 1.3rem;
            color: var(--primary-color);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .step-description {
            font-size: 0.95rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        /* CTA Section */
        .cta-section {
            text-align: center;
            padding: 60px 0;
        }

        .cta-title {
            font-size: 2.2rem;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-weight: 600;
        }

        .cta-description {
            font-size: 1.1rem;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto 40px;
            line-height: 1.7;
        }

        .btn {
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

        .btn:hover {
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

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-title {
                font-size: 3rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .value-stats {
                flex-wrap: wrap;
                gap: 40px;
            }

            .steps {
                flex-direction: column;
                gap: 40px;
            }

            .steps::before {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
            }

            .features-container {
                padding: 100px 20px 60px;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .feature-card {
                padding: 40px 30px;
            }

            .value-section {
                padding: 60px 40px;
            }

            .how-it-works {
                padding: 40px 30px;
            }

            .value-number {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem;
            }

            .value-title,
            .how-it-works-title,
            .cta-title {
                font-size: 1.8rem;
            }

            .feature-title {
                font-size: 1.5rem;
            }

            .value-section {
                padding: 40px 30px;
            }

            .footer-links {
                flex-direction: column;
                gap: 15px;
            }
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
                transform: translateY(-10px);
            }
        }

        .float {
            animation: float 3s ease-in-out infinite;
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
    <div class="features-container">
        <!-- Hero Section -->
        <section class="hero-section animate">
            <h1 class="hero-title">LastBite Features</h1>
            <p class="hero-subtitle">
                Discover how LastBite makes it easy to save money, reduce food waste, and enjoy delicious meals
                from your favorite restaurants. Our platform is designed with both consumers and businesses in mind.
            </p>
        </section>

        <!-- Features Grid -->
        <div class="features-grid">
            <!-- Feature 1: Jelajahi Makanan Diskon -->
            <div class="feature-card animate">
                <div class="feature-icon">
                    <img src="{{ asset('images/fitur-sale.png') }}" alt="Sale">
                </div>
                <h3 class="feature-title">Explore Discounted Meals</h3>
                <p class="feature-description">
                    Discover a wide variety of delicious meals at special discounted prices.
                    From gourmet dishes to everyday favorites, find amazing deals that suit your taste.
                </p>

                <ul class="feature-benefits">
                    <li class="feature-benefit">
                        <span class="benefit-icon">✅</span>
                        <span class="benefit-text">Real-time updates on available discounts</span>
                    </li>
                    <li class="feature-benefit">
                        <span class="benefit-icon">✅</span>
                        <span class="benefit-text">Filter by cuisine, price, and distance</span>
                    </li>
                    <li class="feature-benefit">
                        <span class="benefit-icon">✅</span>
                        <span class="benefit-text">Save your favorite items for later</span>
                    </li>
                </ul>
            </div>

            <!-- Feature 2: Cari Restoran Terdekat -->
            <div class="feature-card animate">
                <div class="feature-icon">
                    <img src="{{ asset('images/fitur-store-location.png') }}" alt="Store location">
                </div>
                <h3 class="feature-title">Find Nearby Restaurants</h3>
                <p class="feature-description">
                    Locate the best restaurants in your area with our intelligent location-based search.
                    Get directions, operating hours, and real-time availability.
                </p>

                <ul class="feature-benefits">
                    <li class="feature-benefit">
                        <span class="benefit-icon">📍</span>
                        <span class="benefit-text">Interactive map with restaurant locations</span>
                    </li>
                    <li class="feature-benefit">
                        <span class="benefit-icon">📍</span>
                        <span class="benefit-text">Distance and travel time estimates</span>
                    </li>
                    <li class="feature-benefit">
                        <span class="benefit-icon">📍</span>
                        <span class="benefit-text">User ratings and reviews</span>
                    </li>
                </ul>
            </div>

            <!-- Feature 3: Notifikasi Penawaran Khusus -->
            <div class="feature-card animate">
                <div class="feature-icon">
                    <img src="{{ asset('images/fitur-notif.png') }}" alt="Notification">
                </div>
                <h3 class="feature-title">Special Offer Notifications</h3>
                <p class="feature-description">
                    Never miss a great deal with personalized notifications. Get alerted about flash sales,
                    new restaurant additions, and time-sensitive offers.
                </p>

                <ul class="feature-benefits">
                    <li class="feature-benefit">
                        <span class="benefit-icon">🔔</span>
                        <span class="benefit-text">Customizable notification preferences</span>
                    </li>
                    <li class="feature-benefit">
                        <span class="benefit-icon">🔔</span>
                        <span class="benefit-text">Real-time push notifications</span>
                    </li>
                    <li class="feature-benefit">
                        <span class="benefit-icon">🔔</span>
                        <span class="benefit-text">Personalized based on your preferences</span>
                    </li>
                </ul>
            </div>

            <!-- Feature 4: Harga Sebelum-Sesudah -->
            <div class="feature-card animate">
                <div class="feature-icon">
                    <img src="{{ asset('images/fitur-money.png') }}" alt="Money">
                </div>
                <h3 class="feature-title">Before & After Pricing</h3>
                <p class="feature-description">
                    Compare original prices with discounted rates and see exactly how much you're saving
                    on every order. Transparency that builds trust.
                </p>

                <ul class="feature-benefits">
                    <li class="feature-benefit">
                        <span class="benefit-icon">💰</span>
                        <span class="benefit-text">Clear price comparison display</span>
                    </li>
                    <li class="feature-benefit">
                        <span class="benefit-icon">💰</span>
                        <span class="benefit-text">Savings percentage calculation</span>
                    </li>
                    <li class="feature-benefit">
                        <span class="benefit-icon">💰</span>
                        <span class="benefit-text">Monthly savings tracking</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Value Proposition -->
        <section class="value-section animate">
            <h2 class="value-title">The LastBite Advantage</h2>

            <div class="value-stats">
                <div class="value-stat">
                    <span class="value-number">30-70%</span>
                    <span class="value-label">Average Savings</span>
                </div>
                <div class="value-stat">
                    <span class="value-number">24/7</span>
                    <span class="value-label">Real-time Updates</span>
                </div>
                <div class="value-stat">
                    <span class="value-number">100%</span>
                    <span class="value-label">Quality Guaranteed</span>
                </div>
            </div>

            <p class="value-description">
                Join thousands of satisfied customers who save money while making a positive environmental impact.
                LastBite isn't just an app—it's a movement towards sustainable consumption and smart savings.
            </p>
        </section>

        <!-- How It Works -->
        <section class="how-it-works animate">
            <h2 class="how-it-works-title">How LastBite Works</h2>

            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3 class="step-title">Browse & Discover</h3>
                    <p class="step-description">
                        Explore discounted meals from restaurants near you
                    </p>
                </div>

                <div class="step">
                    <div class="step-number">2</div>
                    <h3 class="step-title">Select & Order</h3>
                    <p class="step-description">
                        Choose your favorite meals and place your order
                    </p>
                </div>

                <div class="step">
                    <div class="step-number">3</div>
                    <h3 class="step-title">Pick Up & Enjoy</h3>
                    <p class="step-description">
                        Collect your order and enjoy delicious food
                    </p>
                </div>

                <div class="step">
                    <div class="step-number">4</div>
                    <h3 class="step-title">Save & Repeat</h3>
                    <p class="step-description">
                        Track your savings and help reduce food waste
                    </p>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="cta-section animate">
            <h2 class="cta-title">Ready to Start Saving?</h2>
            <p class="cta-description">
                Join the LastBite community today and experience the perfect blend of great food,
                amazing savings, and positive environmental impact.
            </p>

            <a href="{{ url('/role') }}" class="btn">Choose Your Role →</a>
        </section>

        <!-- Footer -->
        <footer class="page-footer">
            <div class="footer-links">
                <a href="{{ url('/') }}" class="footer-link">Home</a>
                <a href="{{ url('/about') }}" class="footer-link">About</a>
                <a href="{{ url('/edukasi') }}" class="footer-link">Education</a>
                <a href="{{ url('/fitur') }}" class="footer-link">Features</a>
            </div>
            <p>© 2024 LastBite. All rights reserved. Smart savings, sustainable future.</p>
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

                        // Add float animation to feature cards on hover
                        if (entry.target.classList.contains('feature-card')) {
                            entry.target.addEventListener('mouseenter', function() {
                                this.classList.add('float');
                            });

                            entry.target.addEventListener('mouseleave', function() {
                                this.classList.remove('float');
                            });
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
    </script>
</body>

</html>
