<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Waste Education - LastBite</title>

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
        .education-container {
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

        .did-you-know {
            font-size: 1.1rem;
            color: var(--accent-color);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
            display: block;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 30px;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .hero-title span {
            color: #e74c3c;
            position: relative;
        }

        .hero-title span::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background: #e74c3c;
            border-radius: 2px;
        }

        .hero-image-container {
            position: relative;
            margin: 60px 0;
        }

        .hero-image {
            max-width: 600px;
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(63, 35, 5, 0.15);
        }

        /* Problem Statement */
        .problem-section {
            background: white;
            padding: 60px 50px;
            border-radius: 20px;
            margin-bottom: 80px;
            box-shadow: 0 10px 40px rgba(63, 35, 5, 0.08);
            position: relative;
            overflow: hidden;
        }

        .problem-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
            background: linear-gradient(to bottom, #e74c3c, #f39c12);
        }

        .problem-title {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-weight: 600;
        }

        .problem-description {
            font-size: 1.2rem;
            color: var(--text-secondary);
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .impact-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 50px;
        }

        .impact-card {
            background: rgba(63, 35, 5, 0.03);
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(63, 35, 5, 0.1);
        }

        .impact-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(63, 35, 5, 0.1);
        }

        .impact-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            display: block;
        }

        .impact-card-title {
            font-size: 1.3rem;
            color: var(--primary-color);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .impact-card-description {
            font-size: 0.95rem;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* Solution Section */
        .solution-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #5a3510 100%);
            padding: 80px 50px;
            border-radius: 20px;
            margin-bottom: 80px;
            color: white;
            text-align: center;
            box-shadow: 0 15px 40px rgba(63, 35, 5, 0.15);
        }

        .solution-title {
            font-size: 2.5rem;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .solution-description {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 800px;
            margin: 0 auto 50px;
            line-height: 1.8;
        }

        .solution-features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
            text-align: left;
            max-width: 900px;
            margin: 0 auto;
        }

        .solution-feature {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        .feature-number {
            background: rgba(255, 255, 255, 0.2);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .feature-content h4 {
            font-size: 1.3rem;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .feature-content p {
            opacity: 0.9;
            line-height: 1.6;
        }

        /* Facts Section */
        .facts-section {
            background: white;
            padding: 60px;
            border-radius: 20px;
            margin-bottom: 80px;
            box-shadow: 0 10px 40px rgba(63, 35, 5, 0.08);
        }

        .facts-title {
            font-size: 2rem;
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 50px;
            font-weight: 600;
        }

        .facts-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
        }

        .fact-item {
            text-align: center;
            padding: 40px 30px;
            background: rgba(76, 175, 80, 0.1);
            border-radius: 15px;
            border: 2px solid rgba(76, 175, 80, 0.2);
        }

        .fact-item:nth-child(2) {
            background: rgba(33, 150, 243, 0.1);
            border-color: rgba(33, 150, 243, 0.2);
        }

        .fact-item:nth-child(3) {
            background: rgba(156, 39, 176, 0.1);
            border-color: rgba(156, 39, 176, 0.2);
        }

        .fact-item:nth-child(4) {
            background: rgba(255, 152, 0, 0.1);
            border-color: rgba(255, 152, 0, 0.2);
        }

        .fact-stat {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 15px;
            display: block;
        }

        .fact-description {
            font-size: 1.1rem;
            color: var(--text-secondary);
            line-height: 1.6;
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
            max-width: 700px;
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

        .btn-secondary {
            background: transparent;
            color: var(--primary-color);
            border-color: var(--primary-color);
            margin-left: 20px;
        }

        .btn-secondary:hover {
            background: var(--primary-color);
            color: white;
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

            .impact-grid,
            .solution-features,
            .facts-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
            }

            .education-container {
                padding: 100px 20px 60px;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .problem-section,
            .solution-section,
            .facts-section {
                padding: 40px 30px;
            }

            .impact-card {
                padding: 25px 20px;
            }

            .solution-feature {
                flex-direction: column;
                text-align: center;
            }

            .btn-secondary {
                margin-left: 0;
                margin-top: 15px;
                display: block;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem;
            }

            .problem-title,
            .solution-title,
            .facts-title,
            .cta-title {
                font-size: 1.8rem;
            }

            .fact-stat {
                font-size: 2.5rem;
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

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .pulse {
            animation: pulse 2s infinite;
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
    <div class="education-container">
        <!-- Hero Section -->
        <section class="hero-section animate">
            <span class="did-you-know">Did you know?</span>
            <h1 class="hero-title">
                Over <span>1/3</span> of the world's food<br>
                ends up in landfills
            </h1>

            <div class="hero-image-container">
                <img class="hero-image" src="{{ asset('images/foodwaste.png') }}" alt="Food Waste Statistics">
            </div>
        </section>

        <!-- Problem Statement -->
        <section class="problem-section animate">
            <h2 class="problem-title">The Food Waste Crisis</h2>
            <p class="problem-description">
                While most of this wasted food is still perfectly edible, it continues to contribute to rising food
                prices,
                environmental degradation, and depletion of valuable resources. Food waste is not just about wasted
                food—it's
                about wasted water, energy, labor, and the significant greenhouse gas emissions from decomposing food in
                landfills.
            </p>

            <div class="impact-grid">
                <div class="impact-card">
                    <span class="impact-icon">💰</span>
                    <h3 class="impact-card-title">Economic Impact</h3>
                    <p class="impact-card-description">
                        Food waste costs the global economy approximately $1 trillion annually,
                        driving up food prices and reducing economic efficiency.
                    </p>
                </div>

                <div class="impact-card">
                    <span class="impact-icon">🌍</span>
                    <h3 class="impact-card-title">Environmental Impact</h3>
                    <p class="impact-card-description">
                        Food waste generates 8-10% of global greenhouse gas emissions—if it were a country,
                        it would be the third largest emitter after China and the US.
                    </p>
                </div>

                <div class="impact-card">
                    <span class="impact-icon">👥</span>
                    <h3 class="impact-card-title">Social Impact</h3>
                    <p class="impact-card-description">
                        While food is wasted, millions face hunger. The food wasted globally could feed
                        all undernourished people worldwide four times over.
                    </p>
                </div>
            </div>
        </section>

        <!-- Solution Section -->
        <section class="solution-section animate">
            <h2 class="solution-title">LastBite: The Solution</h2>
            <p class="solution-description">
                With LastBite, you can help reduce waste while enjoying delicious food at more affordable prices.
                We're building a community committed to sustainable consumption and responsible food management.
            </p>

            <div class="solution-features">
                <div class="solution-feature">
                    <div class="feature-number">1</div>
                    <div class="feature-content">
                        <h4>Rescue Perfectly Good Food</h4>
                        <p>We connect restaurants with surplus food to consumers who appreciate great value,
                            preventing edible food from going to waste.</p>
                    </div>
                </div>

                <div class="solution-feature">
                    <div class="feature-number">2</div>
                    <div class="feature-content">
                        <h4>Save 30-70% on Quality Food</h4>
                        <p>Get access to high-quality meals from your favorite restaurants at significantly
                            reduced prices, making gourmet food more accessible.</p>
                    </div>
                </div>

                <div class="solution-feature">
                    <div class="feature-number">3</div>
                    <div class="feature-content">
                        <h4>Reduce Environmental Impact</h4>
                        <p>Every meal saved from waste reduces carbon emissions, conserves resources,
                            and contributes to a more sustainable food system.</p>
                    </div>
                </div>

                <div class="solution-feature">
                    <div class="feature-number">4</div>
                    <div class="feature-content">
                        <h4>Support Local Businesses</h4>
                        <p>Help restaurants recover costs on surplus inventory, improve their sustainability
                            metrics, and build customer loyalty.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Facts Section -->
        <section class="facts-section animate">
            <h2 class="facts-title">Shocking Food Waste Facts</h2>

            <div class="facts-grid">
                <div class="fact-item">
                    <span class="fact-stat">931M tons</span>
                    <p class="fact-description">of food wasted globally each year</p>
                </div>

                <div class="fact-item">
                    <span class="fact-stat">61%</span>
                    <p class="fact-description">of food waste comes from households</p>
                </div>

                <div class="fact-item">
                    <span class="fact-stat">26%</span>
                    <p class="fact-description">from food service businesses</p>
                </div>

                <div class="fact-item">
                    <span class="fact-stat">13%</span>
                    <p class="fact-description">from retail outlets</p>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="cta-section animate">
            <h2 class="cta-title">Be Part of the Solution</h2>
            <p class="cta-description">
                Every meal saved makes a difference. Join thousands of conscious consumers and businesses
                who are already making an impact with LastBite.
            </p>

            <a href="{{ url('/fitur') }}" class="btn">Explore Features →</a>
            <a href="{{ route('register') }}" class="btn btn-secondary">Join Now</a>
        </section>

        <!-- Footer -->
        <footer class="page-footer">
            <div class="footer-links">
                <a href="{{ url('/') }}" class="footer-link">Home</a>
                <a href="{{ url('/about') }}" class="footer-link">About</a>
                <a href="{{ url('/edukasi') }}" class="footer-link">Education</a>
                <a href="{{ url('/fitur') }}" class="footer-link">Features</a>
            </div>
            <p>© 2024 LastBite. All rights reserved. Together, we can create a waste-free future.</p>
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

            // Add pulse animation to CTA button
            const ctaBtn = document.querySelector('.btn');
            if (ctaBtn) {
                setInterval(() => {
                    ctaBtn.classList.toggle('pulse');
                }, 4000);
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
    </script>
</body>

</html>
