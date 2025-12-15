<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LastBite - Reducing Food Waste')</title>

    <!-- CSS & JS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Custom CSS Variables -->
    <style>
        :root {
            --primary-color: #3F2305;
            --primary-light: #6E3F0C;
            --primary-dark: #2A1703;
            --accent-color: #FF9F1C;
            --danger-color: #FF4757;
            --success-color: #2ECC71;
            --text-dark: #2C2C2C;
            --text-light: #7A7A7A;
            --bg-light: #F9F5F0;
            --white: #FFFFFF;
            --shadow-light: 0 4px 20px rgba(63, 35, 5, 0.08);
            --shadow-medium: 0 6px 25px rgba(63, 35, 5, 0.12);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg-light);
            color: var(--text-dark);
            min-height: 100vh;
            scroll-behavior: smooth;
        }
    </style>
</head>

<body>
    <!-- ========== HEADER/NAVBAR SECTION ========== -->
    <style>
        /* ========== NAVBAR STYLES (Sama dengan Dashboard) ========== */
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
            cursor: pointer;
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

        @media (max-width: 1300px) {
            .navbar-container {
                width: 95%;
                padding: 15px 25px;
            }

            .search-container {
                width: 350px;
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
        }
    </style>

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
            <ul class="dropdown-menu" id="catalogDropdown">
                <li>
                    <h6 class="dropdown-header">Food Categories</h6>
                </li>
                <li><a class="dropdown-item" href="#" data-category="bakery"><i
                            class="fas fa-bread-slice"></i>Bakery & Bread</a></li>
                <li><a class="dropdown-item" href="#" data-category="dairy"><i
                            class="fas fa-wine-bottle"></i>Dairy & Beverages</a></li>
                <li><a class="dropdown-item" href="#" data-category="fruits"><i
                            class="fas fa-apple-alt"></i>Fruits & Vegetables</a></li>
                <li><a class="dropdown-item" href="#" data-category="meat"><i
                            class="fas fa-drumstick-bite"></i>Meat & Fish</a></li>
                <li><a class="dropdown-item" href="#" data-category="eggs"><i class="fas fa-egg"></i>Eggs & Dairy
                        Products</a></li>
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

    <!-- ========== MAIN CONTENT ========== -->
    <main>
        @yield('content')
    </main>

    <!-- ========== FOOTER SECTION ========== -->
    <style>
        /* ========== FOOTER STYLES (Sama dengan Dashboard) ========== */
        .lastbite-footer {
            font-family: 'Poppins', sans-serif;
            background: var(--primary-dark);
            color: var(--white);
            margin-top: 80px;
            border-radius: 20px 20px 0 0;
            overflow: hidden;
            box-shadow: 0 -4px 30px rgba(0, 0, 0, 0.1);
        }

        .footer-top {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            padding: 60px 20px;
            position: relative;
            overflow: hidden;
        }

        .footer-top::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%233F2305' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.1;
        }

        .footer-impact {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .impact-title {
            margin-bottom: 40px;
        }

        .impact-title i {
            font-size: 48px;
            color: var(--accent-color);
            margin-bottom: 20px;
            display: block;
        }

        .impact-title h3 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--white);
        }

        .impact-title p {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.8);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .impact-stats {
            display: flex;
            justify-content: center;
            gap: 60px;
            flex-wrap: wrap;
            margin-top: 40px;
        }

        .stat-item {
            text-align: center;
            min-width: 150px;
        }

        .stat-number {
            font-size: 42px;
            font-weight: 800;
            color: var(--accent-color);
            margin-bottom: 10px;
            font-family: 'Poppins', sans-serif;
        }

        .stat-label {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }

        .footer-main {
            padding: 80px 20px;
            background: var(--primary-color);
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 50px;
        }

        .footer-column {
            display: flex;
            flex-direction: column;
        }

        .brand-column {
            max-width: 400px;
        }

        .footer-brand {
            margin-bottom: 25px;
        }

        .footer-logo {
            height: 60px;
            width: auto;
            margin-bottom: 15px;
            filter: brightness(0) invert(1);
        }

        .brand-tagline {
            font-size: 18px;
            font-weight: 600;
            color: var(--accent-color);
            letter-spacing: 0.5px;
        }

        .footer-description {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
            margin-bottom: 30px;
            font-size: 15px;
        }

        .footer-newsletter {
            background: rgba(255, 255, 255, 0.05);
            padding: 25px;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-newsletter h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--white);
        }

        .footer-newsletter p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            margin-bottom: 20px;
        }

        .newsletter-form {
            display: flex;
            gap: 10px;
        }

        .newsletter-input {
            flex: 1;
            padding: 12px 20px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            color: var(--white);
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: var(--transition);
        }

        .newsletter-input:focus {
            outline: none;
            border-color: var(--accent-color);
            background: rgba(255, 255, 255, 0.1);
        }

        .newsletter-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .newsletter-btn {
            background: var(--accent-color);
            color: var(--primary-dark);
            border: none;
            border-radius: 10px;
            width: 50px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .newsletter-btn:hover {
            background: #FFB347;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 159, 28, 0.3);
        }

        .footer-heading {
            font-size: 18px;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-heading::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--accent-color);
            border-radius: 2px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 15px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: var(--transition);
            padding: 5px 0;
        }

        .footer-links a:hover {
            color: var(--accent-color);
            transform: translateX(5px);
        }

        .footer-links i {
            width: 20px;
            text-align: center;
            color: var(--accent-color);
            font-size: 14px;
        }

        .footer-bottom {
            background: var(--gray-darker);
            padding: 30px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-bottom-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .copyright p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            margin: 5px 0;
        }

        .footer-mission {
            color: var(--accent-color) !important;
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        .footer-social {
            display: flex;
            gap: 15px;
        }

        .social-link {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: var(--transition);
        }

        .social-link:hover {
            background: var(--accent-color);
            color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(255, 159, 28, 0.3);
        }

        .payment-methods {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .payment-methods i {
            font-size: 28px;
            color: rgba(255, 255, 255, 0.7);
            transition: var(--transition);
        }

        .payment-methods i:hover {
            color: var(--accent-color);
            transform: translateY(-2px);
        }

        /* Responsive Footer */
        @media (max-width: 1024px) {
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 40px;
            }

            .brand-column {
                grid-column: span 2;
                max-width: 100%;
            }

            .impact-stats {
                gap: 40px;
            }

            .stat-item {
                min-width: 120px;
            }

            .stat-number {
                font-size: 36px;
            }
        }

        @media (max-width: 768px) {
            .footer-top {
                padding: 40px 20px;
            }

            .footer-main {
                padding: 60px 20px;
            }

            .impact-title h3 {
                font-size: 28px;
            }

            .impact-title p {
                font-size: 16px;
            }

            .impact-stats {
                gap: 30px;
            }

            .stat-item {
                min-width: 100px;
            }

            .stat-number {
                font-size: 32px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .brand-column {
                grid-column: span 1;
            }

            .footer-bottom-content {
                flex-direction: column;
                text-align: center;
                gap: 25px;
            }

            .newsletter-form {
                flex-direction: column;
            }

            .newsletter-btn {
                width: 100%;
                padding: 12px;
            }
        }

        @media (max-width: 576px) {
            .footer-top {
                padding: 30px 15px;
            }

            .footer-main {
                padding: 40px 15px;
            }

            .impact-title h3 {
                font-size: 24px;
            }

            .impact-title p {
                font-size: 15px;
            }

            .impact-stats {
                flex-direction: column;
                gap: 30px;
            }

            .stat-item {
                min-width: auto;
            }

            .footer-links a {
                font-size: 14px;
            }
        }
    </style>

    <footer class="lastbite-footer">
        <div class="footer-top">
            <div class="footer-container">
                <div class="footer-impact">
                    <div class="impact-title">
                        <i class="fas fa-leaf"></i>
                        <h3>Our Impact Together</h3>
                        <p>Every purchase contributes to our mission of reducing food waste</p>
                    </div>
                    <div class="impact-stats">
                        <div class="stat-item">
                            <div class="stat-number" data-count="52784">0</div>
                            <div class="stat-label">Kg Food Saved</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number" data-count="25643">0</div>
                            <div class="stat-label">Meals Shared</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number" data-count="103245">0</div>
                            <div class="stat-label">CO₂ Reduced</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-main">
            <div class="footer-container">
                <div class="footer-grid">
                    <!-- Brand Column -->
                    <div class="footer-column brand-column">
                        <div class="footer-brand">
                            <img src="{{ asset('images/LOGO LASTBITE.png') }}" alt="LastBite" class="footer-logo">
                            <div class="brand-tagline">Rescue Food, Save Planet</div>
                        </div>
                        <p class="footer-description">
                            LastBite is a food rescue platform connecting surplus food with conscious consumers.
                            Together we fight food waste and build a sustainable future.
                        </p>

                        <div class="footer-newsletter">
                            <h4>Stay Updated</h4>
                            <p>Get weekly food rescue tips & exclusive offers</p>
                            <div class="newsletter-form">
                                <input type="email" placeholder="Your email address" class="newsletter-input"
                                    id="footerNewsletterEmail">
                                <button class="newsletter-btn" onclick="subscribeFooterNewsletter()">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links Column -->
                    <div class="footer-column">
                        <h4 class="footer-heading">Quick Links</h4>
                        <ul class="footer-links">
                            <li><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i>Home</a></li>
                            <li><a href="#"><i class="fas fa-bolt"></i>Flash Sale</a></li>
                            <li><a href="#"><i class="fas fa-th-large"></i>Categories</a>
                            </li>
                            <li><a href="#"><i class="fas fa-info-circle"></i>About Us</a></li>
                            <li><a href="#"><i class="fas fa-envelope"></i>Contact</a></li>
                        </ul>
                    </div>

                    <!-- Account Column -->
                    <div class="footer-column">
                        <h4 class="footer-heading">My Account</h4>
                        <ul class="footer-links">
                            <li><a href="#"><i class="fas fa-user"></i>My Profile</a></li>
                            <li><a href="#"><i class="fas fa-shopping-cart"></i>My Cart</a>
                            </li>
                            <li><a href="#"><i class="fas fa-heart"></i>Favorites</a></li>
                            <li><a href="#"><i class="fas fa-history"></i>Order
                                    History</a></li>
                            <li><a href="#"><i class="fas fa-truck"></i>Track Order</a></li>
                        </ul>
                    </div>

                    <!-- Support Column -->
                    <div class="footer-column">
                        <h4 class="footer-heading">Support</h4>
                        <ul class="footer-links">
                            <li><a href="#"><i class="fas fa-question-circle"></i>FAQ</a></li>
                            <li><a href="#"><i class="fas fa-headset"></i>Help Center</a></li>
                            <li><a href="#"><i class="fas fa-shipping-fast"></i>Shipping
                                    Info</a></li>
                            <li><a href="#"><i class="fas fa-exchange-alt"></i>Returns
                                    Policy</a></li>
                            <li><a href="#"><i class="fas fa-shield-alt"></i>Privacy Policy</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-container">
                <div class="footer-bottom-content">
                    <div class="copyright">
                        <p>&copy; <span id="footerYear">2024</span> LastBite. All rights reserved.</p>
                        <p class="footer-mission">Fighting food waste, one bite at a time</p>
                    </div>

                    <div class="footer-social">
                        <a href="#" class="social-link" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>

                    <div class="payment-methods">
                        <i class="fab fa-cc-visa" title="Visa"></i>
                        <i class="fab fa-cc-mastercard" title="Mastercard"></i>
                        <i class="fab fa-cc-paypal" title="PayPal"></i>
                        <i class="fab fa-cc-apple-pay" title="Apple Pay"></i>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Notification -->
    <div class="notification" id="notification">
        <i class="fas fa-check-circle"></i>
        <span id="notificationMessage">Product added to cart!</span>
    </div>

    <!-- ========== JAVASCRIPT ========== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // ========== NAVBAR JAVASCRIPT ==========
        // Search function
        function performSearch() {
            const query = document.getElementById('searchInput').value.trim();
            if (query) {
                showNotification(`Searching for: ${query}`);
                document.getElementById('searchInput').value = '';
            } else {
                showNotification('Please enter a search keyword', 'warning');
            }
        }

        // Setup catalog dropdown
        function setupCatalogDropdown() {
            const dropdownItems = document.querySelectorAll('#catalogDropdown .dropdown-item');
            dropdownItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const category = this.dataset.category;
                    filterByCategory(category);

                    // Close dropdown
                    const dropdown = document.querySelector('.catalog-btn');
                    if (dropdown) {
                        bootstrap.Dropdown.getInstance(dropdown)?.hide();
                    }
                });
            });
        }

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

        // Update cart count
        function updateCartCount() {
            try {
                const cart = JSON.parse(localStorage.getItem('lastbite_cart') || '[]');
                const totalItems = cart.reduce((total, item) => total + (item.quantity || 1), 0);
                const cartCountElement = document.getElementById('cartCount');

                if (cartCountElement) {
                    cartCountElement.textContent = totalItems;
                    cartCountElement.style.display = totalItems > 0 ? 'inline-block' : 'none';
                }
            } catch (error) {
                console.error('Error updating cart count:', error);
            }
        }

        // Filter by category
        function filterByCategory(category) {
            const categoryNames = {
                "bakery": "Bakery & Bread",
                "dairy": "Dairy Products",
                "fruits": "Fruits & Vegetables",
                "meat": "Meat & Fish",
                "all": "All Products"
            };

            showNotification(`Filtering by ${categoryNames[category] || category}`, 'info');
        }

        // ========== FOOTER JAVASCRIPT ==========
        // Counter Animation
        function animateFooterCounters() {
            const counters = document.querySelectorAll('.stat-number');

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

        // Newsletter Subscription
        function setupFooterNewsletter() {
            const newsletterForm = document.querySelector('.newsletter-form');
            if (newsletterForm) {
                const input = newsletterForm.querySelector('.newsletter-input');
                const button = newsletterForm.querySelector('.newsletter-btn');

                button.addEventListener('click', subscribeFooterNewsletter);
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') subscribeFooterNewsletter();
                });
            }
        }

        function subscribeFooterNewsletter() {
            const input = document.getElementById('footerNewsletterEmail');
            const email = input.value.trim();
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
            input.value = '';
        }

        // Update Copyright Year
        function updateFooterCopyright() {
            document.getElementById('footerYear').textContent = new Date().getFullYear();
        }

        // Initialize Footer
        function initializeFooter() {
            animateFooterCounters();
            setupFooterNewsletter();
            updateFooterCopyright();
        }

        // ========== SHARED FUNCTIONS ==========
        // Notification function
        function showNotification(message, type = 'success') {
            // Remove existing notification
            const existingNotification = document.getElementById('notification');

            // Create notification element if doesn't exist
            let notification = existingNotification;
            if (!notification) {
                notification = document.createElement('div');
                notification.id = 'notification';
                notification.className = 'notification';
                document.body.appendChild(notification);
            }

            notification.className = 'notification';
            notification.classList.add('show');

            if (type === 'success') {
                notification.classList.add('notification-success');
                notification.innerHTML = `<i class="fas fa-check-circle"></i><span>${message}</span>`;
            } else if (type === 'error') {
                notification.classList.add('notification-error');
                notification.innerHTML = `<i class="fas fa-exclamation-circle"></i><span>${message}</span>`;
            } else if (type === 'warning') {
                notification.innerHTML = `<i class="fas fa-exclamation-triangle"></i><span>${message}</span>`;
            } else {
                notification.innerHTML = `<i class="fas fa-info-circle"></i><span>${message}</span>`;
            }

            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    if (notification.parentNode && notification.id !== 'notification') {
                        notification.remove();
                    }
                }, 400);
            }, 3000);
        }

        // Add CSS for notification
        if (!document.querySelector('#notification-style')) {
            const style = document.createElement('style');
            style.id = 'notification-style';
            style.textContent = `
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
                @media (max-width: 768px) {
                    .notification {
                        bottom: 20px;
                        right: 20px;
                        left: 20px;
                        max-width: none;
                    }
                }
            `;
            document.head.appendChild(style);
        }

        // ========== MAIN INITIALIZATION ==========
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize navbar
            setupCatalogDropdown();
            updateCartCount();

            // Initialize footer
            initializeFooter();

            // Check scroll position
            window.dispatchEvent(new Event('scroll'));

            // Update cart count every 2 seconds for synchronization
            setInterval(updateCartCount, 2000);

            console.log('Layout initialized successfully');
        });

        // Initialize navbar for other pages
        window.initializeNavbar = function() {
            setupCatalogDropdown();
            updateCartCount();
            window.dispatchEvent(new Event('scroll'));
        };

        // Add to cart function for use in child pages
        // ========== ADD TO CART FUNCTION (REVISED) ==========
        window.addToCart = function(productId, productName, price, productImageUrl = '', productBrand = '',
            productCategory = '', productRating = 4.5, productRatingCount = 10) {
            try {
                // DEBUG: Log parameter yang diterima
                console.log('addToCart called with:', {
                    productId,
                    productName,
                    price,
                    productImageUrl,
                    productBrand,
                    productCategory
                });

                let cart = JSON.parse(localStorage.getItem('lastbite_cart') || '[]');
                const existingItem = cart.find(item => item.id === productId);

                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    // Dapatkan gambar default berdasarkan kategori jika image_url kosong
                    let imageUrl = productImageUrl;
                    if (!imageUrl) {
                        imageUrl = getDefaultImageByCategory(productCategory);
                    }

                    // Pastikan image_url valid
                    if (!imageUrl || imageUrl === '') {
                        imageUrl =
                            'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80';
                    }

                    cart.push({
                        id: productId,
                        name: productName,
                        price: price,
                        quantity: 1,
                        selected: true,
                        image_url: imageUrl, // PASTIKAN image_url
                        brand: productBrand || 'LastBite',
                        category: productCategory || 'General',
                        expiry_date: 'Soon',
                        rating: productRating,
                        rating_count: productRatingCount,
                        description: 'Fresh product with great quality and best price.',
                        addedAt: new Date().toISOString()
                    });
                }

                localStorage.setItem('lastbite_cart', JSON.stringify(cart));
                updateCartCount();
                showNotification(`${productName} added to cart!`, 'success');

                // DEBUG: Log cart setelah update
                console.log('Cart after update:', cart);

                return true;
            } catch (error) {
                console.error('Error adding to cart:', error);
                showNotification('Failed to add item to cart', 'error');
                return false;
            }
        };

        // Helper function untuk gambar default berdasarkan kategori
        function getDefaultImageByCategory(category) {
            const defaultImages = {
                'bakery': 'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'dairy': 'https://images.unsplash.com/photo-1563636619-e9143da7973b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'fruits': 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'fruit': 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'meat': 'https://images.unsplash.com/photo-1604503468505-1d2d6a9a6c8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'vegetable': 'https://images.unsplash.com/photo-1540420773420-3366772f4999?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'
            };

            return defaultImages[category] ||
                'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80';
        }
    </script>

    <!-- Additional scripts from child pages -->
    @stack('scripts')
</body>

</html>
