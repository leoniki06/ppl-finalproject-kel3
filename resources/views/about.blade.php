<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - LastBite</title>

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
        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 120px 40px 80px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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
            margin-bottom: 30px;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .hero-description {
            font-size: 1.2rem;
            color: var(--text-secondary);
            max-width: 800px;
            margin: 0 auto 40px;
            line-height: 1.8;
        }

        /* Content Sections */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            margin-bottom: 80px;
        }

        .mission-section,
        .vision-section {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(63, 35, 5, 0.08);
        }

        .section-title {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 25px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .section-icon {
            font-size: 2.5rem;
        }

        .section-description {
            font-size: 1.1rem;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 25px;
        }

        .feature-list {
            list-style: none;
            padding: 0;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
            padding: 20px;
            background: rgba(63, 35, 5, 0.03);
            border-radius: 12px;
            border-left: 4px solid var(--accent-color);
        }

        .feature-icon {
            font-size: 1.5rem;
            color: var(--accent-color);
            flex-shrink: 0;
        }

        .feature-text strong {
            color: var(--primary-color);
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .feature-text p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Impact Section */
        .impact-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #5a3510 100%);
            padding: 60px 40px;
            border-radius: 20px;
            color: white;
            text-align: center;
            margin-bottom: 80px;
            box-shadow: 0 15px 40px rgba(63, 35, 5, 0.15);
        }

        .impact-title {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .impact-description {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 700px;
            margin: 0 auto 50px;
            line-height: 1.7;
        }

        .impact-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .impact-stat {
            text-align: center;
        }

        .impact-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
            display: block;
        }

        .impact-label {
            font-size: 1.1rem;
            opacity: 0.9;
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

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .btn {
            padding: 16px 40px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            border: 2px solid transparent;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background: white;
            color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(63, 35, 5, 0.2);
        }

        .btn-secondary {
            background: transparent;
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-secondary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(63, 35, 5, 0.2);
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

            .content-grid {
                gap: 40px;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
            }

            .about-container {
                padding: 100px 20px 60px;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-description {
                font-size: 1.1rem;
                padding: 0 10px;
            }

            .content-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .mission-section,
            .vision-section {
                padding: 30px;
            }

            .impact-section {
                padding: 40px 20px;
            }

            .impact-stats {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.7rem;
            }

            .impact-title {
                font-size: 2rem;
            }

            .impact-number {
                font-size: 2.5rem;
            }

            .footer-links {
                flex-direction: column;
                gap: 15px;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
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
            animation: fadeInUp 0.8s ease-out;
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
    <div class="about-container">
        <!-- Hero Section -->
        <section class="hero-section animate">
            <h1 class="hero-title">What is LastBite?</h1>
            <p class="hero-description">
                LastBite is a revolutionary platform that facilitates the sale of perfectly good,
                excess food from restaurants, cafes, and suppliers at affordable prices.
                We connect food that would otherwise go to waste with people who appreciate great value.
            </p>
        </section>

        <!-- Mission & Vision -->
        <div class="content-grid">
            <!-- Mission -->
            <section class="mission-section animate">
                <h2 class="section-title">
                    <span class="section-icon">🎯</span>
                    Our Mission
                </h2>
                <p class="section-description">
                    To significantly reduce food waste while making quality food accessible to everyone,
                    creating a sustainable food ecosystem that benefits businesses, consumers, and our planet.
                </p>

                <ul class="feature-list">
                    <li class="feature-item">
                        <span class="feature-icon">♻️</span>
                        <div class="feature-text">
                            <strong>Reduce Food Waste</strong>
                            <p>Save perfectly good food from ending up in landfills</p>
                        </div>
                    </li>
                    <li class="feature-item">
                        <span class="feature-icon">💰</span>
                        <div class="feature-text">
                            <strong>Save Money</strong>
                            <p>Get great food at 30-70% off regular prices</p>
                        </div>
                    </li>
                    <li class="feature-item">
                        <span class="feature-icon">🌍</span>
                        <div class="feature-text">
                            <strong>Help The Planet</strong>
                            <p>Reduce carbon footprint by preventing food waste</p>
                        </div>
                    </li>
                </ul>
            </section>

            <!-- Vision -->
            <section class="vision-section animate">
                <h2 class="section-title">
                    <span class="section-icon">🚀</span>
                    Our Vision
                </h2>
                <p class="section-description">
                    To become Indonesia's leading platform for sustainable food consumption,
                    transforming how businesses and consumers think about food surplus and
                    creating a nationwide movement against food waste.
                </p>

                <ul class="feature-list">
                    <li class="feature-item">
                        <span class="feature-icon">🏪</span>
                        <div class="feature-text">
                            <strong>Partner Restaurants</strong>
                            <p>Help businesses recover costs on surplus inventory</p>
                        </div>
                    </li>
                    <li class="feature-item">
                        <span class="feature-icon">🤝</span>
                        <div class="feature-text">
                            <strong>Community Impact</strong>
                            <p>Build a community committed to sustainable living</p>
                        </div>
                    </li>
                    <li class="feature-item">
                        <span class="feature-icon">📈</span>
                        <div class="feature-text">
                            <strong>Sustainable Growth</strong>
                            <p>Create economic opportunities while protecting the environment</p>
                        </div>
                    </li>
                </ul>
            </section>
        </div>

        <!-- Impact Section -->
        <section class="impact-section animate">
            <h2 class="impact-title">Our Impact</h2>
            <p class="impact-description">
                Since our launch, we've made significant strides in reducing food waste and
                creating positive environmental and social impact across Indonesia.
            </p>

            <div class="impact-stats">
                <div class="impact-stat">
                    <span class="impact-number">50K+</span>
                    <span class="impact-label">Meals Saved</span>
                </div>
                <div class="impact-stat">
                    <span class="impact-number">200+</span>
                    <span class="impact-label">Partner Outlets</span>
                </div>
                <div class="impact-stat">
                    <span class="impact-number">10K+</span>
                    <span class="impact-label">Happy Customers</span>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="cta-section animate">
            <h2 class="cta-title">Join Our Mission</h2>
            <p class="cta-description">
                Whether you're a restaurant with surplus food or a conscious consumer looking
                for great deals, you can be part of the solution to food waste.
            </p>

            <div class="cta-buttons">
                <a href="{{ url('/edukasi') }}" class="btn btn-primary">Learn More →</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">Get Started</a>
            </div>
        </section>

        <!-- Footer -->
        <footer class="page-footer">
            <div class="footer-links">
                <a href="{{ url('/') }}" class="footer-link">Home</a>
                <a href="{{ url('/about') }}" class="footer-link">About</a>
                <a href="{{ url('/edukasi') }}" class="footer-link">Education</a>
                <a href="{{ url('/fitur') }}" class="footer-link">Features</a>
            </div>
            <p>© 2024 LastBite. All rights reserved. Building a sustainable future, one meal at a time.</p>
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
