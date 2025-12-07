<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastBite - Reducing Food Waste</title>

    <!-- CSS & JS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ========== ROOT VARIABLES ========== */
        :root {
            --primary-color: #3F2305;
            --primary-light: #6E3F0C;
            --primary-dark: #2A1703;
            --accent-color: #FF9F1C;
            --danger-color: #FF4757;
            --text-dark: #2C2C2C;
            --text-light: #7A7A7A;
            --bg-light: #F9F5F0;
            --white: #FFFFFF;
            --gray-dark: #1A1A1A;
            --gray-darker: #0F0F0F;
            --shadow-light: 0 4px 20px rgba(63, 35, 5, 0.08);
            --shadow-medium: 0 6px 25px rgba(63, 35, 5, 0.12);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ========== RESET & BASE ========== */
        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg-light);
            color: var(--text-dark);
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ========== HEADER/NAVBAR ========== */
        .navbar-container {
            width: 90%;
            max-width: 1500px;
            justify-content: space-between;
            align-items: center;
            display: flex;
            background: var(--white);
            padding: 15px 40px;
            border-radius: 12px;
            box-shadow: var(--shadow-medium);
            position: sticky;
            top: 20px;
            z-index: 1000;
            margin: 20px auto;
            transition: var(--transition);
        }

        .navbar-scrolled {
            padding: 12px 30px;
            box-shadow: 0 8px 30px rgba(63, 35, 5, 0.12);
        }

        .logo {
            width: 100px;
            height: auto;
            object-fit: contain;
            cursor: pointer;
            transition: var(--transition);
            filter: drop-shadow(0 2px 4px rgba(63, 35, 5, 0.1));
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .catalog-btn {
            min-width: 130px;
            height: 44px;
            padding: 0 18px;
            border-radius: 30px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            display: flex;
            background: var(--white);
            border: 1.5px solid var(--primary-color);
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .catalog-btn:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(63, 35, 5, 0.15);
        }

        .catalog-btn:hover .catalog-text,
        .catalog-btn:hover .catalog-icon {
            color: var(--white);
        }

        .catalog-text {
            color: var(--primary-color);
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.2px;
            transition: var(--transition);
        }

        .catalog-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .search-container {
            width: 420px;
            height: 48px;
            padding-left: 20px;
            padding-right: 8px;
            background: var(--white);
            border-radius: 30px;
            justify-content: space-between;
            align-items: center;
            display: flex;
            transition: var(--transition);
            position: relative;
            border: 1.5px solid rgba(63, 35, 5, 0.15);
            box-shadow: 0 2px 8px rgba(63, 35, 5, 0.05);
        }

        .search-container:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(63, 35, 5, 0.15);
        }

        .search-input {
            color: var(--text-dark);
            font-size: 15px;
            font-weight: 500;
            background: transparent;
            border: none;
            outline: none;
            flex: 1;
            padding: 0 10px;
        }

        .search-input::placeholder {
            color: var(--text-light);
            font-weight: 400;
        }

        .search-icon-container {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .search-icon-container:hover {
            background: var(--primary-dark);
            transform: scale(1.05);
        }

        .search-icon {
            color: var(--white);
            font-size: 16px;
        }

        .cart-btn {
            min-width: 120px;
            height: 48px;
            padding: 0 20px;
            border-radius: 30px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            display: flex;
            background: var(--primary-color);
            border: none;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .cart-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(63, 35, 5, 0.2);
        }

        .cart-text {
            color: var(--white);
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .cart-icon {
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            position: relative;
        }

        .cart-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: var(--accent-color);
            color: var(--primary-dark);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .profile-btn {
            min-width: 130px;
            height: 48px;
            padding: 0 18px;
            border-radius: 30px;
            justify-content: center;
            align-items: center;
            gap: 12px;
            display: flex;
            background: var(--white);
            border: 1.5px solid rgba(63, 35, 5, 0.15);
            cursor: pointer;
            transition: var(--transition);
        }

        .profile-btn:hover {
            background: var(--bg-light);
            border-color: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(63, 35, 5, 0.08);
        }

        .profile-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(63, 35, 5, 0.2);
        }

        .profile-avatar i {
            color: var(--white);
            font-size: 14px;
        }

        .profile-text {
            color: var(--primary-color);
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow-medium);
            padding: 0.75rem 0;
            min-width: 260px;
            border-top: 3px solid var(--primary-color);
            margin-top: 10px;
        }

        .dropdown-header {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 0.85rem;
            padding: 0.5rem 1.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 0.75rem 1.25rem;
            margin: 0.1rem 0.75rem;
            transition: var(--transition);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-dark);
        }

        .dropdown-item:hover {
            background: rgba(63, 35, 5, 0.08);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
            color: var(--primary-light);
        }

        /* ========== DASHBOARD/HERO ========== */
        .hero-section {
            margin: 30px 0 40px;
        }

        .hero-banner {
            position: relative;
            width: 100%;
            height: 400px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-medium);
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(rgba(63, 35, 5, 0.7), rgba(63, 35, 5, 0.4));
            z-index: 1;
        }

        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 10s ease;
        }

        .hero-banner:hover .hero-image {
            transform: scale(1.05);
        }

        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: var(--white);
            z-index: 2;
            width: 100%;
            padding: 0 20px;
        }

        .hero-tagline {
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .hero-title {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 10px;
            line-height: 1.1;
        }

        .hero-subtitle {
            font-size: 28px;
            font-weight: 600;
            color: var(--accent-color);
            margin-bottom: 20px;
        }

        .hero-cta {
            display: inline-block;
            background: var(--accent-color);
            color: var(--primary-color);
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            border: 2px solid transparent;
        }

        .hero-cta:hover {
            background: transparent;
            color: var(--accent-color);
            border-color: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 159, 28, 0.3);
        }

        /* ========== FLASH SALE ========== */
        .flash-sale-section {
            margin-bottom: 60px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(63, 35, 5, 0.1);
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .flash-icon {
            color: var(--danger-color);
            font-size: 28px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .section-title h2 {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }

        .countdown-timer {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--primary-color);
            color: var(--white);
            padding: 10px 20px;
            border-radius: 30px;
            box-shadow: var(--shadow-light);
        }

        .timer-icon {
            font-size: 18px;
        }

        .timer-display {
            font-size: 20px;
            font-weight: 600;
            letter-spacing: 1px;
            font-variant-numeric: tabular-nums;
        }

        .see-more-btn {
            background: var(--white);
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .see-more-btn:hover {
            background: var(--primary-color);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(63, 35, 5, 0.2);
        }

        .products-carousel-container {
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .products-carousel {
            display: flex;
            gap: 25px;
            padding: 10px 5px;
            animation: scroll-left 60s linear infinite;
            animation-play-state: running;
        }

        .products-carousel:hover {
            animation-play-state: paused;
        }

        @keyframes scroll-left {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(calc(-250px * 8 - 25px * 8));
            }
        }

        .product-card {
            flex: 0 0 250px;
            background: var(--white);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow-light);
            transition: var(--transition);
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-medium);
        }

        .flash-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--danger-color);
            color: var(--white);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            z-index: 2;
        }

        .product-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .product-info {
            padding: 20px;
        }

        .product-brand {
            font-size: 12px;
            color: var(--text-light);
            font-weight: 500;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .store-icon {
            color: var(--primary-light);
        }

        .product-name {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 10px;
            line-height: 1.3;
            height: 40px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
        }

        .stars {
            color: #FFC107;
            font-size: 14px;
        }

        .rating-count {
            font-size: 12px;
            color: var(--text-light);
            font-weight: 500;
        }

        .product-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .price-tag {
            font-size: 18px;
            font-weight: 700;
            color: var(--danger-color);
        }

        .original-price {
            font-size: 14px;
            color: var(--text-light);
            text-decoration: line-through;
            margin-left: 5px;
        }

        .add-to-cart-btn {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .add-to-cart-btn:hover {
            background: var(--accent-color);
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 6px 15px rgba(63, 35, 5, 0.2);
        }

        .cart-icon {
            font-size: 16px;
        }

        /* ========== FOOTER ========== */
        .lastbite-footer {
            font-family: 'Poppins', sans-serif;
            background: var(--gray-darker);
            color: var(--white);
            margin-top: auto;
            width: 100%;
            border-radius: 20px;
            overflow: hidden;
            margin-top: 40px;
            box-shadow: var(--shadow-medium);
        }

        .impact-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            padding: 70px 0;
            position: relative;
            overflow: hidden;
        }

        .impact-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-bottom: 50px;
        }

        .impact-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 30px 24px;
            text-align: center;
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 200px;
            position: relative;
            overflow: hidden;
        }

        .impact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--accent-color), transparent);
            opacity: 0;
            transition: var(--transition);
        }

        .impact-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.25);
        }

        .impact-card:hover::before {
            opacity: 1;
        }

        .impact-icon {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
            color: var(--white);
            transition: var(--transition);
        }

        .impact-card:hover .impact-icon {
            transform: scale(1.15) rotate(10deg);
            background: var(--accent-color);
            box-shadow: 0 8px 20px rgba(255, 159, 28, 0.3);
        }

        .impact-number {
            font-size: 42px;
            font-weight: 700;
            margin: 0 0 10px 0;
            background: linear-gradient(135deg, var(--white) 0%, var(--accent-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
            letter-spacing: -0.5px;
        }

        .impact-text {
            font-size: 15px;
            opacity: 0.9;
            margin: 0;
            font-weight: 500;
            line-height: 1.5;
            max-width: 160px;
            color: rgba(255, 255, 255, 0.9);
        }

        .impact-message {
            text-align: center;
            max-width: 750px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .impact-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 20px;
            background: linear-gradient(135deg, var(--white) 30%, var(--accent-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1.2;
        }

        .impact-description {
            font-size: 17px;
            opacity: 0.9;
            line-height: 1.7;
            margin: 0 auto;
            max-width: 650px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 400;
        }

        .footer-main {
            padding: 70px 0;
            background: var(--gray-dark);
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 50px;
        }

        .footer-about {
            padding-right: 30px;
        }

        .footer-brand {
            margin-bottom: 25px;
        }

        .footer-logo-wrapper {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .footer-logo {
            display: block;
            font-size: 28px;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 2px;
            letter-spacing: 1px;
        }

        .footer-tagline {
            display: block;
            font-size: 15px;
            color: var(--accent-color);
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .footer-description {
            font-size: 15px;
            line-height: 1.7;
            opacity: 0.8;
            margin-bottom: 30px;
            color: rgba(255, 255, 255, 0.8);
        }

        .newsletter-section {
            margin: 30px 0;
            padding: 25px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .newsletter-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--white);
            margin-bottom: 5px;
        }

        .newsletter-subtitle {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 15px;
        }

        .newsletter-form {
            display: flex;
            gap: 10px;
        }

        .newsletter-input {
            flex: 1;
            padding: 14px 18px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 30px;
            color: var(--white);
            font-size: 14px;
            transition: var(--transition);
        }

        .newsletter-input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.12);
        }

        .newsletter-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .newsletter-button {
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            border: none;
            border-radius: 50%;
            color: var(--white);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .newsletter-button:hover {
            background: var(--primary-dark);
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(63, 35, 5, 0.3);
        }

        .footer-social {
            display: flex;
            gap: 14px;
            margin-top: 25px;
        }

        .social-link {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: var(--transition);
            font-size: 16px;
            position: relative;
            overflow: hidden;
        }

        .social-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--primary-color);
            border-radius: 50%;
            transform: scale(0);
            transition: var(--transition);
        }

        .social-link:hover::before {
            transform: scale(1);
        }

        .social-link i {
            position: relative;
            z-index: 1;
        }

        .social-link:hover {
            color: var(--white);
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(63, 35, 5, 0.3);
        }

        .footer-subtitle {
            font-size: 17px;
            font-weight: 600;
            margin-bottom: 22px;
            color: var(--accent-color);
            position: relative;
            padding-bottom: 10px;
        }

        .footer-subtitle::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 45px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 14px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14.5px;
            padding: 6px 0;
            font-weight: 400;
        }

        .footer-links a:hover {
            color: var(--accent-color);
            transform: translateX(5px);
        }

        .footer-links i {
            font-size: 14px;
            width: 22px;
            opacity: 0.7;
            transition: var(--transition);
        }

        .footer-links a:hover i {
            opacity: 1;
            color: var(--accent-color);
            transform: scale(1.1);
        }

        .footer-bottom {
            background: var(--gray-darker);
            padding: 28px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .footer-bottom-content {
            display: grid;
            grid-template-columns: 2fr 1.5fr 1fr;
            gap: 30px;
            align-items: center;
        }

        .copyright {
            font-size: 14.5px;
            opacity: 0.7;
            margin: 0;
            color: rgba(255, 255, 255, 0.7);
        }

        .heart {
            color: #ff6b6b;
            animation: heartbeat 1.5s infinite;
            display: inline-block;
            margin: 0 4px;
        }

        @keyframes heartbeat {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }
        }

        .footer-legal {
            display: flex;
            align-items: center;
            gap: 18px;
            justify-content: center;
        }

        .legal-link {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 13.5px;
            transition: var(--transition);
            white-space: nowrap;
            font-weight: 400;
        }

        .legal-link:hover {
            color: var(--accent-color);
        }

        .separator {
            color: rgba(255, 255, 255, 0.3);
            font-size: 12px;
        }

        .footer-payments {
            text-align: right;
        }

        .payment-methods {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
        }

        .payment-methods i {
            font-size: 24px;
            color: rgba(255, 255, 255, 0.6);
            transition: var(--transition);
            cursor: pointer;
        }

        .payment-methods i:hover {
            color: var(--white);
            transform: translateY(-2px);
        }

        /* ========== NOTIFICATION ========== */
        .notification {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--primary-color);
            color: var(--white);
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: var(--shadow-medium);
            z-index: 9999;
            transform: translateX(120%);
            transition: transform 0.4s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            max-width: 350px;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification-success {
            background: #28a745;
        }

        .notification-error {
            background: #dc3545;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1300px) {
            .navbar-container {
                width: 95%;
                padding: 15px 25px;
            }

            .search-container {
                width: 350px;
            }

            .footer-grid {
                gap: 40px;
            }

            .impact-grid {
                gap: 25px;
            }
        }

        @media (max-width: 1200px) {
            .hero-title {
                font-size: 38px;
            }

            .hero-subtitle {
                font-size: 24px;
            }

            .hero-banner {
                height: 350px;
            }
        }

        @media (max-width: 1024px) {
            .navbar-container {
                flex-wrap: wrap;
                gap: 15px;
                padding: 15px;
            }

            .search-container {
                width: 100%;
                order: 3;
                margin-top: 10px;
            }

            .catalog-btn,
            .cart-btn,
            .profile-btn {
                flex: 1;
                min-width: auto;
            }

            .impact-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 25px;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 40px 30px;
            }

            .footer-about {
                grid-column: 1 / -1;
                padding-right: 0;
                text-align: center;
                padding-bottom: 40px;
                margin-bottom: 10px;
            }

            .newsletter-form {
                max-width: 400px;
                margin: 0 auto;
            }

            .footer-social {
                justify-content: center;
            }

            .footer-bottom-content {
                grid-template-columns: 1fr;
                gap: 20px;
                text-align: center;
            }

            .payment-methods {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .navbar-container {
                width: 100%;
                padding: 12px 15px;
                border-radius: 10px;
            }

            .logo {
                width: 85px;
            }

            .catalog-text,
            .cart-text,
            .profile-text {
                font-size: 14px;
            }

            .hero-title {
                font-size: 32px;
            }

            .hero-subtitle {
                font-size: 20px;
            }

            .hero-banner {
                height: 300px;
            }

            .hero-tagline {
                font-size: 12px;
            }

            .section-title h2 {
                font-size: 24px;
            }

            .timer-display {
                font-size: 18px;
            }

            .product-card {
                flex: 0 0 220px;
            }

            .impact-section {
                padding: 60px 0;
            }

            .impact-grid {
                grid-template-columns: 1fr;
                max-width: 400px;
                margin: 0 auto 40px;
            }

            .impact-title {
                font-size: 28px;
            }

            .impact-description {
                font-size: 16px;
            }

            .footer-main {
                padding: 60px 0;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 35px;
            }

            .footer-column {
                text-align: center;
            }

            .footer-subtitle::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .footer-links a:hover {
                transform: translateX(0);
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 28px;
            }

            .hero-subtitle {
                font-size: 18px;
            }

            .hero-banner {
                height: 250px;
            }

            .hero-content {
                padding: 0 15px;
            }

            .section-title {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .countdown-timer {
                padding: 8px 15px;
            }

            .products-carousel {
                gap: 15px;
            }

            .product-card {
                flex: 0 0 200px;
            }

            .impact-section {
                padding: 50px 0;
            }

            .impact-card {
                padding: 25px 20px;
                min-height: 180px;
            }

            .impact-icon {
                width: 56px;
                height: 56px;
                font-size: 22px;
            }

            .impact-number {
                font-size: 36px;
            }

            .impact-title {
                font-size: 26px;
            }

            .footer-main {
                padding: 50px 0;
            }

            .footer-legal {
                flex-wrap: wrap;
                gap: 10px;
            }

            .footer-bottom {
                padding: 24px 0;
            }

            .copyright {
                font-size: 13.5px;
            }

            .legal-link {
                font-size: 13px;
            }

            .payment-methods {
                gap: 12px;
            }

            .payment-methods i {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>
    <!-- ========== HEADER ========== -->
    <div class="navbar-container" id="navbarContainer">
        <!-- Logo - Redirect to Dashboard -->
        <a href="{{ route('dashboard') }}" style="text-decoration: none;">
            <img class="logo" src="{{ asset('images/LOGO LASTBITE.png') }}" alt="Last Bite" />
        </a>

        <!-- Catalog Dropdown -->
        <div class="nav-item dropdown">
            <button class="catalog-btn" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="catalog-text">Catalog</div>
                <div class="catalog-icon">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <h6 class="dropdown-header">Food Categories</h6>
                </li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-bread-slice"></i>Bakery & Bread</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-wine-bottle"></i>Dairy & Beverages</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-apple-alt"></i>Fruits & Vegetables</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-drumstick-bite"></i>Meat & Fish</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-egg"></i>Eggs & Dairy Products</a></li>
            </ul>
        </div>

        <!-- Search -->
        <div class="search-container">
            <input type="text" class="search-input" placeholder="Search for food items..." id="searchInput" />
            <div class="search-icon-container" onclick="performSearch()">
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>

        <!-- Cart - Redirect to Cart Page -->
        <a href="{{ route('cart.index') }}" style="text-decoration: none;">
            <button class="cart-btn">
                <div class="cart-text">Cart</div>
                <div class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge" id="cartCount">0</span>
                </div>
            </button>
        </a>

        <!-- Profile Dropdown -->
        <div class="nav-item dropdown">
            <button class="profile-btn" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile-avatar">
                    @php
                        $user = auth()->user();
                        $initial = $user ? strtoupper(substr($user->name, 0, 1)) : 'G';
                    @endphp
                    {{ $initial }}
                </div>
                <div class="profile-text">Profile</div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user-circle"></i>My
                        Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('profile.orders') }}"><i class="fas fa-history"></i>Order
                        History</a></li>
                <li><a class="dropdown-item" href="{{ route('favorites') }}"><i class="fas fa-heart"></i>Favorites</a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger"
                            style="border: none; background: none; width: 100%; text-align: left; cursor: pointer;">
                            <i class="fas fa-sign-out-alt"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- ========== DASHBOARD ========== -->
    <div class="container">
        <section class="hero-section">
            <div class="hero-banner">
                <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80"
                    alt="LastBite Hero Banner" class="hero-image">
                <div class="hero-content">
                    <div class="hero-tagline">Reducing Food Waste, One Bite at a Time</div>
                    <h1 class="hero-title">Wasting Food?</h1>
                    <div class="hero-subtitle">LastBite Here</div>
                    <a href="#flash-sale" class="hero-cta">Shop Flash Sale</a>
                </div>
            </div>
        </section>

        <section class="flash-sale-section" id="flash-sale">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-bolt flash-icon"></i>
                    <h2>Flash Sale</h2>
                    <div class="countdown-timer">
                        <i class="fas fa-clock timer-icon"></i>
                        <div class="timer-display" id="countdownTimer">24:00:00</div>
                    </div>
                </div>
                <a href="/flash-sale" class="see-more-btn">
                    See More
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="products-carousel-container">
                <div class="products-carousel" id="productsCarousel">
                    <!-- Products will be loaded by JavaScript -->
                </div>
            </div>
        </section>
    </div>

    <!-- ========== FOOTER ========== -->
    <footer class="lastbite-footer">
        <div class="impact-section">
            <div class="container">
                <div class="impact-grid">
                    <div class="impact-card">
                        <div class="impact-icon"><i class="fas fa-leaf"></i></div>
                        <div class="impact-content">
                            <h3 class="impact-number" data-count="50000">0</h3>
                            <p class="impact-text">Food Saved (kg)</p>
                        </div>
                    </div>
                    <div class="impact-card">
                        <div class="impact-icon"><i class="fas fa-utensils"></i></div>
                        <div class="impact-content">
                            <h3 class="impact-number" data-count="25000">0</h3>
                            <p class="impact-text">Meals Shared</p>
                        </div>
                    </div>
                    <div class="impact-card">
                        <div class="impact-icon"><i class="fas fa-cloud"></i></div>
                        <div class="impact-content">
                            <h3 class="impact-number" data-count="100000">0</h3>
                            <p class="impact-text">CO₂ Reduced (kg)</p>
                        </div>
                    </div>
                    <div class="impact-card">
                        <div class="impact-icon"><i class="fas fa-handshake"></i></div>
                        <div class="impact-content">
                            <h3 class="impact-number" data-count="5000">0</h3>
                            <p class="impact-text">Families Helped</p>
                        </div>
                    </div>
                </div>

                <div class="impact-message">
                    <h2 class="impact-title">Creating Real Impact Together</h2>
                    <p class="impact-description">
                        Every purchase at Last Bite helps reduce food waste,
                        supports environmental sustainability, and provides food access to those in need.
                    </p>
                </div>
            </div>
        </div>

        <div class="footer-main">
            <div class="container">
                <div class="footer-grid">
                    <div class="footer-column footer-about">
                        <div class="footer-brand">
                            <div class="footer-logo-wrapper">
                                <span class="footer-logo">LASTBITE</span>
                                <span class="footer-tagline">Rescue Food, Save Planet</span>
                            </div>
                        </div>
                        <p class="footer-description">
                            Last Bite is a food rescue platform connecting surplus food
                            with those who need it. Together we can reduce food waste
                            and create positive impact for our planet.
                        </p>

                        <div class="newsletter-section">
                            <h4 class="newsletter-title">Stay Updated</h4>
                            <p class="newsletter-subtitle">Get the latest news on food sustainability</p>
                            <div class="newsletter-form">
                                <input type="email" class="newsletter-input" placeholder="Enter your email"
                                    id="newsletterEmail" />
                                <button class="newsletter-button" onclick="subscribeNewsletter()">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>

                        <div class="footer-social">
                            <a href="#" class="social-link" aria-label="Instagram"><i
                                    class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link" aria-label="Facebook"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link" aria-label="Twitter"><i
                                    class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link" aria-label="LinkedIn"><i
                                    class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-link" aria-label="YouTube"><i
                                    class="fab fa-youtube"></i></a>
                        </div>
                    </div>

                    <div class="footer-column">
                        <h4 class="footer-subtitle">Resources</h4>
                        <ul class="footer-links">
                            <li><a href="#"><i class="fas fa-book"></i>Food Safety Guide</a></li>
                            <li><a href="#"><i class="fas fa-utensil-spoon"></i>Recipes & Tips</a></li>
                            <li><a href="#"><i class="fas fa-graduation-cap"></i>Food Waste Education</a></li>
                            <li><a href="#"><i class="fas fa-newspaper"></i>Blog & Articles</a></li>
                            <li><a href="#"><i class="fas fa-chart-line"></i>Impact Dashboard</a></li>
                        </ul>
                    </div>

                    <div class="footer-column">
                        <h4 class="footer-subtitle">Support</h4>
                        <ul class="footer-links">
                            <li><a href="#"><i class="fas fa-question-circle"></i>Help Center</a></li>
                            <li><a href="#"><i class="fas fa-headset"></i>Contact Support</a></li>
                            <li><a href="#"><i class="fas fa-shipping-fast"></i>Delivery Info</a></li>
                            <li><a href="#"><i class="fas fa-exchange-alt"></i>Returns Policy</a></li>
                            <li><a href="#"><i class="fas fa-credit-card"></i>Payment Options</a></li>
                        </ul>
                    </div>

                    <div class="footer-column">
                        <h4 class="footer-subtitle">Company</h4>
                        <ul class="footer-links">
                            <li><a href="#"><i class="fas fa-building"></i>About Us</a></li>
                            <li><a href="#"><i class="fas fa-map-marker-alt"></i>Store Locator</a></li>
                            <li><a href="#"><i class="fas fa-handshake"></i>Partner Program</a></li>
                            <li><a href="#"><i class="fas fa-briefcase"></i>Careers</a></li>
                            <li><a href="#"><i class="fas fa-shield-alt"></i>Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <div class="copyright">
                        <p>&copy; <span id="currentYear">2024</span> Last Bite. All rights reserved. <span
                                class="heart">❤</span> Made with love for a better planet.</p>
                    </div>

                    <div class="footer-legal">
                        <a href="#" class="legal-link">Terms of Service</a>
                        <span class="separator">•</span>
                        <a href="#" class="legal-link">Privacy Policy</a>
                        <span class="separator">•</span>
                        <a href="#" class="legal-link">Cookie Policy</a>
                        <span class="separator">•</span>
                        <a href="#" class="legal-link">Accessibility</a>
                    </div>

                    <div class="footer-payments">
                        <div class="payment-methods">
                            <i class="fab fa-cc-visa" title="Visa"></i>
                            <i class="fab fa-cc-mastercard" title="Mastercard"></i>
                            <i class="fab fa-cc-paypal" title="PayPal"></i>
                            <i class="fab fa-cc-apple-pay" title="Apple Pay"></i>
                            <i class="fab fa-cc-amazon-pay" title="Amazon Pay"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- ========== NOTIFICATION ========== -->
    <div class="notification" id="notification">
        <i class="fas fa-check-circle"></i>
        <span id="notificationMessage">Product added to cart!</span>
    </div>

    <!-- ========== JAVASCRIPT ========== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ========== PRODUCT DATA ==========
        const products = [{
                id: 1,
                name: "Roti Sisir - Fresh Artisan Bread",
                brand: "Holland Bakery",
                image: "https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 20000,
                originalPrice: 35000,
                rating: 4.5,
                ratingCount: 3000
            },
            {
                id: 2,
                name: "Roti Sisir - Whole Wheat Bread",
                brand: "Holland Bakery",
                image: "https://images.unsplash.com/photo-1608198093002-ad4e005484ec?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 20000,
                originalPrice: 32000,
                rating: 4.0,
                ratingCount: 2800
            },
            {
                id: 3,
                name: "Roti Sisir - Multigrain Bread",
                brand: "Holland Bakery",
                image: "https://images.unsplash.com/photo-1549931319-a545dcf3bc73?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 20000,
                originalPrice: 38000,
                rating: 5.0,
                ratingCount: 3200
            },
            {
                id: 4,
                name: "Roti Sisir - Artisan Bread",
                brand: "Holland Bakery",
                image: "https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 20000,
                originalPrice: 35000,
                rating: 4.5,
                ratingCount: 3000
            }
        ];

        // ========== SHARED FUNCTIONS ==========
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function selectCategory(category) {
            showNotification(`Opening ${category} category`, 'info');
        }

        function performSearch() {
            const query = document.getElementById('searchInput').value.trim();
            if (query) {
                showNotification(`Searching for: ${query}`);
                document.getElementById('searchInput').value = '';
            } else {
                showNotification('Please enter a search keyword', 'warning');
            }
        }

        function openCart() {
            showNotification('Opening shopping cart', 'info');
        }

        function updateCartCount() {
            try {
                const cart = JSON.parse(localStorage.getItem('lastbite_cart') || '[]');
                const totalItems = cart.reduce((total, item) => total + (item.quantity || 1), 0);
                const cartCountElement = document.getElementById('cartCount');

                if (cartCountElement) {
                    cartCountElement.textContent = totalItems;
                    if (totalItems > 0) {
                        cartCountElement.style.transform = 'scale(1.2)';
                        setTimeout(() => cartCountElement.style.transform = 'scale(1)', 300);
                    }
                }
            } catch (error) {
                console.error('Error updating cart count:', error);
            }
        }

        function addToCart(productId, productName, price) {
            try {
                let cart = JSON.parse(localStorage.getItem('lastbite_cart') || '[]');
                const existingItem = cart.find(item => item.id === productId);

                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        id: productId,
                        name: productName,
                        price: price,
                        quantity: 1,
                        addedAt: new Date().toISOString()
                    });
                }

                localStorage.setItem('lastbite_cart', JSON.stringify(cart));
                updateCartCount();
                showNotification(`${productName} added to cart!`, 'success');

            } catch (error) {
                console.error('Error adding to cart:', error);
                showNotification('Failed to add item to cart', 'error');
            }
        }

        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                localStorage.removeItem('lastbite_cart');
                sessionStorage.clear();
                showNotification('Successfully logged out', 'success');
            }
        }

        function showNotification(message, type = 'success') {
            const notification = document.getElementById('notification');
            notification.className = 'notification';
            notification.classList.add('show');

            if (type === 'success') {
                notification.classList.add('notification-success');
                notification.innerHTML = `<i class="fas fa-check-circle"></i><span>${message}</span>`;
            } else if (type === 'error') {
                notification.classList.add('notification-error');
                notification.innerHTML = `<i class="fas fa-exclamation-circle"></i><span>${message}</span>`;
            } else {
                notification.innerHTML = `<i class="fas fa-info-circle"></i><span>${message}</span>`;
            }

            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.innerHTML = '', 400);
            }, 3000);
        }

        // ========== DASHBOARD FUNCTIONS ==========
        function updateCountdownTimer() {
            const timerElement = document.getElementById('countdownTimer');
            let totalSeconds = 24 * 60 * 60;

            const timerInterval = setInterval(() => {
                if (totalSeconds <= 0) {
                    clearInterval(timerInterval);
                    timerElement.textContent = "SALE ENDED";
                    timerElement.style.color = "#FF4757";
                    return;
                }

                const hours = Math.floor(totalSeconds / 3600);
                const minutes = Math.floor((totalSeconds % 3600) / 60);
                const seconds = totalSeconds % 60;

                timerElement.textContent =
                    `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                totalSeconds--;
            }, 1000);
        }

        function renderProducts() {
            const carousel = document.getElementById('productsCarousel');
            let productsHTML = '';

            products.forEach(product => {
                const stars = generateStars(product.rating);
                productsHTML += `
                    <div class="product-card">
                        <span class="flash-badge">FLASH SALE</span>
                        <img src="${product.image}" alt="${product.name}" class="product-image">
                        <div class="product-info">
                            <div class="product-brand">
                                <i class="fas fa-store store-icon"></i>
                                ${product.brand}
                            </div>
                            <h3 class="product-name">${product.name}</h3>
                            <div class="product-rating">
                                <div class="stars">${stars}</div>
                                <span class="rating-count">(${formatNumber(product.ratingCount)})</span>
                            </div>
                            <div class="product-price">
                                <div class="price">
                                    <span class="price-tag">Rp${formatPrice(product.price)}</span>
                                    <span class="original-price">Rp${formatPrice(product.originalPrice)}</span>
                                </div>
                                <button class="add-to-cart-btn" onclick="addToCart(${product.id}, '${product.name}', ${product.price})">
                                    <i class="fas fa-shopping-cart cart-icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });

            // Duplicate for infinite scroll
            carousel.innerHTML = productsHTML + productsHTML + productsHTML + productsHTML;
        }

        function generateStars(rating) {
            let stars = '';
            const fullStars = Math.floor(rating);
            const hasHalfStar = rating % 1 >= 0.5;

            for (let i = 0; i < fullStars; i++) stars += '<i class="fas fa-star"></i>';
            if (hasHalfStar) stars += '<i class="fas fa-star-half-alt"></i>';

            const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
            for (let i = 0; i < emptyStars; i++) stars += '<i class="far fa-star"></i>';

            return stars;
        }

        function formatPrice(price) {
            return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function formatNumber(num) {
            if (num >= 1000) return (num / 1000).toFixed(1).replace(/\.0$/, '') + 'k';
            return num.toString();
        }

        // ========== FOOTER FUNCTIONS ==========
        function updateCopyrightYear() {
            document.getElementById('currentYear').textContent = new Date().getFullYear();
        }

        function subscribeNewsletter() {
            const email = document.getElementById('newsletterEmail').value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!email) {
                showNotification('Please enter your email address', 'warning');
                return;
            }

            if (!emailRegex.test(email)) {
                showNotification('Please enter a valid email address', 'error');
                return;
            }

            showNotification('Thank you for subscribing to our newsletter!', 'success');
            document.getElementById('newsletterEmail').value = '';
        }

        // ========== COUNTER ANIMATION ==========
        function animateCounters() {
            const counters = document.querySelectorAll('.impact-number');

            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-count'));
                const duration = 2000;
                const increment = target / (duration / 16);
                let current = 0;

                const updateCounter = () => {
                    if (current < target) {
                        current += increment;
                        counter.textContent = Math.floor(current).toLocaleString();
                        setTimeout(updateCounter, 16);
                    } else {
                        counter.textContent = target.toLocaleString();
                    }
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            updateCounter();
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.5
                });

                observer.observe(counter);
            });
        }

        // ========== INITIALIZATION ==========
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize components
            updateCartCount();
            updateCountdownTimer();
            renderProducts();
            updateCopyrightYear();
            animateCounters();

            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.getElementById('navbarContainer');
                if (navbar) {
                    navbar.classList.toggle('navbar-scrolled', window.scrollY > 50);
                }
            });

            // Search input enter key
            document.getElementById('searchInput')?.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') performSearch();
            });

            // Newsletter input enter key
            document.getElementById('newsletterEmail')?.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') subscribeNewsletter();
            });

            // Setup carousel hover
            const carousel = document.getElementById('productsCarousel');
            if (carousel) {
                carousel.addEventListener('mouseenter', () => {
                    carousel.style.animationPlayState = 'paused';
                });
                carousel.addEventListener('mouseleave', () => {
                    carousel.style.animationPlayState = 'running';
                });
            }

            console.log('LastBite Website Initialized');
        });
    </script>
</body>

</html>
