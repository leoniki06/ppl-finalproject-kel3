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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body>
    <!-- =========================================== -->
    <!-- HEADER SECTION -->
    <!-- =========================================== -->
    <style>
        /* ========== HEADER STYLES ========== */
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

    <script>
        // ========== HEADER JAVASCRIPT ==========
        function performSearch() {
            const query = document.getElementById('searchInput').value.trim();
            if (query) {
                showNotification(`Searching for: ${query}`);
                document.getElementById('searchInput').value = '';
            } else {
                showNotification('Please enter a search keyword', 'warning');
            }
        }

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

        // Shared notification function
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
    </script>

    <!-- =========================================== -->
    <!-- DASHBOARD SECTION -->
    <!-- =========================================== -->
    <style>
        /* ========== DASHBOARD LAYOUT ========== */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .content-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .section-container {
            margin-bottom: 60px;
        }

        /* Scroll padding for navbar */
        #flash-sale,
        #recommended-foods {
            scroll-margin-top: 120px;
        }

        /* ========== HERO BANNER ========== */
        .hero-section {
            margin: 30px auto 20px;
            max-width: 1400px;
            width: 100%;
            padding: 0 40px;
        }

        .hero-banner {
            position: relative;
            width: 100%;
            height: 450px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-medium);
        }

        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            background-size: cover;
            background-position: center;
        }

        .hero-slide.active {
            opacity: 1;
        }

        .hero-slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to right, rgba(63, 35, 5, 0.85), rgba(63, 35, 5, 0.6));
        }

        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: var(--white);
            z-index: 2;
            width: 90%;
            max-width: 800px;
        }

        .hero-tagline {
            font-size: 16px;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 15px;
            opacity: 0.9;
            color: var(--accent-color);
        }

        .hero-title {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 15px;
            line-height: 1.1;
            text-transform: uppercase;
            letter-spacing: -0.5px;
        }

        .hero-subtitle {
            font-size: 32px;
            font-weight: 600;
            color: var(--accent-color);
            margin-bottom: 25px;
        }

        .hero-description {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 30px;
            opacity: 0.9;
            font-weight: 400;
        }

        .hero-cta {
            display: inline-block;
            background: var(--accent-color);
            color: var(--primary-color);
            padding: 14px 35px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            border: 2px solid transparent;
            font-size: 16px;
        }

        .hero-cta:hover {
            background: transparent;
            color: var(--accent-color);
            border-color: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 159, 28, 0.3);
        }

        .hero-dots {
            position: relative;
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
            padding-bottom: 20px;
        }

        .hero-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: rgba(63, 35, 5, 0.2);
            cursor: pointer;
            transition: var(--transition);
        }

        .hero-dot.active {
            background: var(--accent-color);
            transform: scale(1.3);
            box-shadow: 0 0 0 3px rgba(255, 159, 28, 0.2);
        }

        /* ========== FLASH SALE INDICATORS ========== */
        .flash-sale-dots {
            position: relative;
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 20px;
            padding-bottom: 10px;
        }

        .flash-sale-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(63, 35, 5, 0.2);
            cursor: pointer;
            transition: var(--transition);
        }

        .flash-sale-dot.active {
            background: var(--danger-color);
            transform: scale(1.3);
            box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.2);
        }

        /* ========== CATEGORIES SECTION ========== */
        .categories-section {
            margin-top: 20px;
            margin-bottom: 60px;
            padding: 0 20px;
        }

        .section-title-container {
            max-width: 1200px;
            margin: 0 auto 40px;
            text-align: center;
        }

        .categories-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 35px;
            position: relative;
            display: inline-block;
        }

        .categories-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--accent-color);
            border-radius: 2px;
        }

        .categories-grid {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 35px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .category-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            transition: var(--transition);
            width: 120px;
        }

        .category-item:hover {
            transform: translateY(-10px);
        }

        .category-circle {
            width: 100px;
            height: 100px;
            background: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            box-shadow: var(--shadow-light);
            transition: var(--transition);
            border: 3px solid transparent;
        }

        .category-item:hover .category-circle {
            background: var(--primary-color);
            transform: scale(1.05);
            box-shadow: var(--shadow-medium);
            border-color: var(--accent-color);
        }

        .category-icon {
            font-size: 40px;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .category-item:hover .category-icon {
            color: var(--white);
            transform: scale(1.1);
        }

        .category-name {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
            transition: var(--transition);
        }

        .category-item:hover .category-name {
            color: var(--primary-color);
        }

        /* ========== SECTION HEADER ========== */
        .section-header-container {
            max-width: 1200px;
            margin: 0 auto 35px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(63, 35, 5, 0.1);
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .section-title h2 {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }

        .flash-icon {
            color: var(--danger-color);
            font-size: 32px;
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

        .star-icon {
            color: #FF9F1C;
            font-size: 32px;
        }

        .countdown-timer {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--primary-color);
            color: var(--white);
            padding: 12px 24px;
            border-radius: 30px;
            box-shadow: var(--shadow-light);
            margin-left: 20px;
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
            padding: 12px 28px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 15px;
        }

        .see-more-btn:hover {
            background: var(--primary-color);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(63, 35, 5, 0.2);
        }

        /* ========== FLASH SALE SECTION ========== */
        .flash-sale-section {
            margin-bottom: 70px;
            position: relative;
        }

        .swiper-container {
            position: relative;
            padding: 10px 5px 20px;
            overflow: hidden;
            max-width: 1200px;
            margin: 0 auto;
        }

        .swiper {
            padding: 15px 10px;
        }

        .swiper-slide {
            height: auto;
            display: flex;
            justify-content: center;
        }

        /* ========== PRODUCT CARD ========== */
        .product-card {
            width: 100%;
            max-width: 280px;
            background: var(--white);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow-light);
            transition: var(--transition);
            position: relative;
            display: flex;
            flex-direction: column;
            margin: 0 auto;
            cursor: pointer;
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
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            z-index: 2;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .recommended-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--success-color);
            color: var(--white);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            z-index: 2;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .product-image-container {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-actions {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            z-index: 2;
        }

        .favorite-btn {
            width: 36px;
            height: 36px;
            background: var(--white);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            color: var(--text-dark);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .favorite-btn:hover {
            background: var(--primary-color);
            color: var(--white);
            transform: scale(1.1);
        }

        .favorite-btn.active {
            background: var(--danger-color);
            color: var(--white);
        }

        .product-info {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        .product-brand {
            font-size: 12px;
            color: var(--text-light);
            font-weight: 500;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .product-name {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 10px;
            line-height: 1.3;
            height: 42px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-category {
            display: inline-block;
            background: rgba(63, 35, 5, 0.08);
            color: var(--primary-color);
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 12px;
            align-self: flex-start;
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
            margin-top: auto;
            padding-top: 15px;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
        }

        .price-container {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .current-price {
            font-size: 20px;
            font-weight: 700;
            color: var(--danger-color);
        }

        .original-price {
            font-size: 14px;
            color: var(--text-light);
            text-decoration: line-through;
        }

        .discount-percent {
            font-size: 12px;
            color: var(--success-color);
            font-weight: 600;
            margin-left: 5px;
        }

        .add-to-cart-btn {
            width: 44px;
            height: 44px;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .add-to-cart-btn:hover {
            background: var(--accent-color);
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 6px 15px rgba(63, 35, 5, 0.2);
        }

        /* Swiper Navigation */
        .swiper-button-next,
        .swiper-button-prev {
            width: 44px;
            height: 44px;
            background: var(--white);
            border-radius: 50%;
            box-shadow: var(--shadow-medium);
            color: var(--primary-color);
            transition: var(--transition);
            top: 45%;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 16px;
            font-weight: bold;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: var(--primary-color);
            color: var(--white);
            transform: scale(1.1);
        }

        .swiper-button-next {
            right: 10px;
        }

        .swiper-button-prev {
            left: 10px;
        }

        .swiper-pagination-bullet {
            background: var(--primary-light);
            opacity: 0.5;
            width: 8px;
            height: 8px;
            transition: var(--transition);
        }

        .swiper-pagination-bullet-active {
            background: var(--primary-color);
            opacity: 1;
            transform: scale(1.2);
        }

        /* ========== RECOMMENDED SECTION ========== */
        .recommended-section {
            margin-bottom: 70px;
        }

        .category-filter-container {
            max-width: 1200px;
            margin: 0 auto 35px;
        }

        .category-filter {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .category-btn {
            padding: 10px 24px;
            background: var(--white);
            border: 2px solid var(--primary-color);
            border-radius: 25px;
            color: var(--primary-color);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            font-size: 14px;
        }

        .category-btn:hover,
        .category-btn.active {
            background: var(--primary-color);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(63, 35, 5, 0.15);
        }

        .recommended-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
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
        @media (max-width: 1200px) {
            .hero-title {
                font-size: 42px;
            }

            .hero-subtitle {
                font-size: 28px;
            }

            .hero-banner {
                height: 400px;
            }

            .recommended-grid {
                grid-template-columns: repeat(3, 1fr);
                max-width: 900px;
            }
        }

        @media (max-width: 1024px) {
            .hero-title {
                font-size: 36px;
            }

            .hero-subtitle {
                font-size: 24px;
            }

            .hero-banner {
                height: 350px;
            }

            .categories-grid {
                gap: 25px;
            }

            .category-circle {
                width: 85px;
                height: 85px;
            }

            .category-icon {
                font-size: 35px;
            }

            .recommended-grid {
                grid-template-columns: repeat(2, 1fr);
                max-width: 600px;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 0 15px;
            }

            .section-header-container,
            .category-filter-container,
            .swiper-container {
                padding: 0 15px;
            }

            .hero-title {
                font-size: 32px;
            }

            .hero-subtitle {
                font-size: 22px;
            }

            .hero-banner {
                height: 300px;
            }

            .hero-cta {
                padding: 12px 28px;
                font-size: 15px;
            }

            .categories-title {
                font-size: 24px;
            }

            .categories-grid {
                gap: 20px;
            }

            .category-item {
                width: 100px;
            }

            .category-circle {
                width: 75px;
                height: 75px;
            }

            .category-icon {
                font-size: 30px;
            }

            .category-name {
                font-size: 13px;
            }

            .section-title h2 {
                font-size: 24px;
            }

            .timer-display {
                font-size: 18px;
            }

            .recommended-grid {
                grid-template-columns: 1fr;
                max-width: 400px;
                padding: 0 15px;
            }

            .swiper-button-next,
            .swiper-button-prev {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .hero-section {
                padding: 0 10px;
            }

            .hero-title {
                font-size: 28px;
            }

            .hero-subtitle {
                font-size: 20px;
            }

            .hero-banner {
                height: 250px;
            }

            .hero-cta {
                padding: 10px 24px;
                font-size: 14px;
            }

            .categories-grid {
                gap: 15px;
            }

            .category-item {
                width: 85px;
            }

            .category-circle {
                width: 65px;
                height: 65px;
            }

            .category-icon {
                font-size: 25px;
            }

            .category-name {
                font-size: 12px;
            }

            .section-title {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .countdown-timer {
                padding: 8px 15px;
                margin-left: 0;
            }

            .see-more-btn {
                padding: 10px 20px;
                font-size: 14px;
            }
        }
    </style>

    <!-- ========== HERO BANNER ========== -->
    <section class="hero-section">
        <div class="hero-banner" id="heroBanner">
            <!-- Slides will be added by JavaScript -->
        </div>
        <div class="hero-dots" id="heroDots">
            <!-- Dots will be added by JavaScript -->
        </div>
    </section>

    <!-- ========== CATEGORIES SECTION ========== -->
    <section class="categories-section">
        <div class="section-title-container">
            <h2 class="categories-title">Browse Categories</h2>
        </div>
        <div class="content-container">
            <div class="categories-grid" id="categoriesGrid">
                <!-- Category items will be loaded by JavaScript -->
            </div>
        </div>
    </section>

    <!-- ========== FLASH SALE SECTION ========== -->
    <section class="flash-sale-section" id="flash-sale">
        <div class="section-header-container">
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
        </div>

        <div class="swiper-container">
            <div class="swiper" id="flashSaleSwiper">
                <div class="swiper-wrapper" id="flashSaleProducts">
                    <!-- Flash sale products will be loaded by JavaScript -->
                </div>
                <!-- Add Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <!-- Flash Sale Indicators -->
            <div class="flash-sale-dots" id="flashSaleDots">
                <!-- Dots will be added by JavaScript -->
            </div>
        </div>
    </section>

    <!-- ========== RECOMMENDED SECTION ========== -->
    <section class="recommended-section" id="recommended-foods">
        <div class="section-header-container">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-star star-icon"></i>
                    <h2>Recommended Foods</h2>
                </div>
            </div>
        </div>

        <div class="category-filter-container">
            <div class="category-filter" id="categoryFilter">
                <!-- Category buttons will be generated by JavaScript -->
            </div>
        </div>

        <div class="content-container">
            <div class="recommended-grid" id="recommendedGrid">
                <!-- Recommended products will be loaded by JavaScript -->
            </div>
        </div>
    </section>

    <script>
        // ========== DASHBOARD JAVASCRIPT ==========
        // Data
        const heroSlides = [{
                image: 'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                tagline: 'Reducing Food Waste, One Bite at a Time',
                title: 'Wasting Food?',
                subtitle: 'LastBite Here',
                description: 'Fresh food at amazing prices while saving the planet'
            },
            {
                image: 'https://images.unsplash.com/photo-1563636619-e9143da7973b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                tagline: 'Limited Time Offer!',
                title: 'Big Food Sale',
                subtitle: 'Up to 50% OFF!',
                description: 'Redefine your everyday meals with fresh ingredients'
            },
            {
                image: 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                tagline: 'Fresh & Healthy',
                title: 'Organic Collection',
                subtitle: 'Farm to Table',
                description: 'Quality produce delivered to your doorstep'
            },
            {
                image: 'https://images.unsplash.com/photo-1604503468505-1d2d6a9a6c8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                tagline: 'Premium Quality',
                title: 'Daily Essentials',
                subtitle: 'Best Prices Guaranteed',
                description: 'Everything you need for delicious home-cooked meals'
            }
        ];

        // Categories tanpa "Eggs & Dairy"
        const categories = [{
                id: "bakery",
                name: "Bakery & Bread",
                icon: "fas fa-bread-slice",
                image: "https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
            },
            {
                id: "dairy",
                name: "Dairy Products",
                icon: "fas fa-wine-bottle",
                image: "https://images.unsplash.com/photo-1563636619-e9143da7973b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
            },
            {
                id: "fruits",
                name: "Fruits & Vegetables",
                icon: "fas fa-apple-alt",
                image: "https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
            },
            {
                id: "meat",
                name: "Meat & Fish",
                icon: "fas fa-drumstick-bite",
                image: "https://images.unsplash.com/photo-1604503468505-1d2d6a9a6c8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
            }
        ];

        // Database produk lengkap untuk rekomendasi otomatis
        const productDatabase = [
            // Bakery Products
            {
                id: 101,
                name: "Artisan Sourdough Bread",
                brand: "Heritage Bakery",
                image: "https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 25000,
                originalPrice: 40000,
                rating: 4.7,
                ratingCount: 3200,
                category: "bakery",
                discount: 38
            },
            {
                id: 102,
                name: "Whole Grain Baguette",
                brand: "Paris Bakery",
                image: "https://images.unsplash.com/photo-1586190848861-99aa4a171e90?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 18000,
                originalPrice: 28000,
                rating: 4.5,
                ratingCount: 2100,
                category: "bakery",
                discount: 36
            },
            {
                id: 103,
                name: "Cinnamon Roll 4 pcs",
                brand: "Sweet Bakery",
                image: "https://images.unsplash.com/photo-1555507036-ab794f27d2e9?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 32000,
                originalPrice: 45000,
                rating: 4.8,
                ratingCount: 3800,
                category: "bakery",
                discount: 29
            },
            {
                id: 104,
                name: "Multigrain Bread Loaf",
                brand: "Health Bakery",
                image: "https://images.unsplash.com/photo-1608198093002-ad4e005484ec?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 22000,
                originalPrice: 35000,
                rating: 4.4,
                ratingCount: 1800,
                category: "bakery",
                discount: 37
            },

            // Dairy Products (tanpa telur)
            {
                id: 201,
                name: "Fresh Milk 1L Premium",
                brand: "Greenfields",
                image: "https://images.unsplash.com/photo-1563636619-e9143da7973b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 28000,
                originalPrice: 38000,
                rating: 4.6,
                ratingCount: 4200,
                category: "dairy",
                discount: 26
            },
            {
                id: 202,
                name: "Greek Yogurt 500g",
                brand: "Healthy Choice",
                image: "https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 22000,
                originalPrice: 32000,
                rating: 4.7,
                ratingCount: 3100,
                category: "dairy",
                discount: 31
            },
            {
                id: 203,
                name: "Cheddar Cheese 200g",
                brand: "Dairy King",
                image: "https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 35000,
                originalPrice: 48000,
                rating: 4.5,
                ratingCount: 2400,
                category: "dairy",
                discount: 27
            },
            {
                id: 204,
                name: "Fresh Orange Juice 1L",
                brand: "Sunshine Drinks",
                image: "https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 24000,
                originalPrice: 34000,
                rating: 4.6,
                ratingCount: 2300,
                category: "dairy",
                discount: 29
            },

            // Fruits & Vegetables
            {
                id: 301,
                name: "Organic Apples 1kg",
                brand: "Farm Fresh",
                image: "https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 32000,
                originalPrice: 48000,
                rating: 4.8,
                ratingCount: 5200,
                category: "fruits",
                discount: 33
            },
            {
                id: 302,
                name: "Bananas Organic Bunch",
                brand: "Tropical Fruits",
                image: "https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 15000,
                originalPrice: 22000,
                rating: 4.6,
                ratingCount: 4100,
                category: "fruits",
                discount: 32
            },
            {
                id: 303,
                name: "Organic Tomatoes 500g",
                brand: "Garden Fresh",
                image: "https://images.unsplash.com/photo-1592924357228-91a4daadcfea?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 12000,
                originalPrice: 18000,
                rating: 4.4,
                ratingCount: 1500,
                category: "fruits",
                discount: 33
            },
            {
                id: 304,
                name: "Fresh Carrots 1kg",
                brand: "Organic Farm",
                image: "https://images.unsplash.com/photo-1592924357228-91a4daadcfea?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 10000,
                originalPrice: 15000,
                rating: 4.6,
                ratingCount: 1900,
                category: "fruits",
                discount: 33
            },

            // Meat & Fish
            {
                id: 401,
                name: "Chicken Breast 500g",
                brand: "Best Chicken",
                image: "https://images.unsplash.com/photo-1604503468505-1d2d6a9a6c8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 38000,
                originalPrice: 52000,
                rating: 4.6,
                ratingCount: 3800,
                category: "meat",
                discount: 27
            },
            {
                id: 402,
                name: "Salmon Fillet 300g Fresh",
                brand: "Ocean Fresh",
                image: "https://images.unsplash.com/photo-1467003909585-2f8a72700288?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 58000,
                originalPrice: 78000,
                rating: 4.8,
                ratingCount: 4800,
                category: "meat",
                discount: 26
            },
            {
                id: 403,
                name: "Whole Chicken 1.2kg",
                brand: "Farm Fresh",
                image: "https://images.unsplash.com/photo-1604503468505-1d2d6a9a6c8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 48000,
                originalPrice: 65000,
                rating: 4.5,
                ratingCount: 2900,
                category: "meat",
                discount: 26
            },
            {
                id: 404,
                name: "Beef Steak 400g Premium",
                brand: "Prime Beef",
                image: "https://images.unsplash.com/photo-1546833999-b9f581a1996d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 68000,
                originalPrice: 90000,
                rating: 4.9,
                ratingCount: 3500,
                category: "meat",
                discount: 24
            }
        ];

        // Flash Sale Products (tetap sama)
        const flashSaleProducts = [{
                id: 1,
                name: "Roti Sisir - Fresh Artisan Bread",
                brand: "Holland Bakery",
                image: "https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 20000,
                originalPrice: 35000,
                rating: 4.5,
                ratingCount: 3000,
                category: "bakery",
                type: "flash",
                discount: 43
            },
            {
                id: 2,
                name: "Fresh Milk - 1L Premium",
                brand: "Greenfields",
                image: "https://images.unsplash.com/photo-1563636619-e9143da7973b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 25000,
                originalPrice: 32000,
                rating: 4.7,
                ratingCount: 4200,
                category: "dairy",
                type: "flash",
                discount: 22
            },
            {
                id: 3,
                name: "Organic Apples - 1kg Pack",
                brand: "Farm Fresh",
                image: "https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 30000,
                originalPrice: 45000,
                rating: 4.8,
                ratingCount: 5200,
                category: "fruits",
                type: "flash",
                discount: 33
            },
            {
                id: 4,
                name: "Chicken Breast - 500g",
                brand: "Best Chicken",
                image: "https://images.unsplash.com/photo-1604503468505-1d2d6a9a6c8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 35000,
                originalPrice: 48000,
                rating: 4.6,
                ratingCount: 3800,
                category: "meat",
                type: "flash",
                discount: 27
            },
            {
                id: 5,
                name: "Croissant - 4 pcs Assorted",
                brand: "Paris Bakery",
                image: "https://images.unsplash.com/photo-1555507036-ab794f27d2e9?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
                price: 28000,
                originalPrice: 40000,
                rating: 4.4,
                ratingCount: 2900,
                category: "bakery",
                type: "flash",
                discount: 30
            }
        ];

        const defaultImages = {
            bakery: "https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
            dairy: "https://images.unsplash.com/photo-1563636619-e9143da7973b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
            fruits: "https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80",
            meat: "https://images.unsplash.com/photo-1604503468505-1d2d6a9a6c8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
        };

        const categoryNames = {
            "bakery": "Bakery & Bread",
            "dairy": "Dairy Products",
            "fruits": "Fruits & Vegetables",
            "meat": "Meat & Fish",
            "all": "All Products"
        };

        // Variables
        let currentSlide = 0;
        let flashSaleSwiper = null;
        let recommendedProducts = [];
        let recommendedRefreshInterval = null;

        // Hero Slideshow
        function initializeHeroSlideshow() {
            const heroBanner = document.getElementById('heroBanner');
            const heroDots = document.getElementById('heroDots');

            // Create slides
            heroSlides.forEach((slide, index) => {
                const slideDiv = document.createElement('div');
                slideDiv.className = `hero-slide ${index === 0 ? 'active' : ''}`;
                slideDiv.style.backgroundImage = `url('${slide.image}')`;
                heroBanner.appendChild(slideDiv);

                // Create dot
                const dot = document.createElement('div');
                dot.className = `hero-dot ${index === 0 ? 'active' : ''}`;
                dot.dataset.index = index;
                dot.addEventListener('click', () => goToSlide(index));
                heroDots.appendChild(dot);
            });

            // Create hero content
            const heroContent = document.createElement('div');
            heroContent.className = 'hero-content';
            heroBanner.appendChild(heroContent);

            // Auto-change slides every 5 seconds
            setInterval(() => {
                goToSlide((currentSlide + 1) % heroSlides.length);
            }, 5000);

            updateHeroContent(0);
        }

        function goToSlide(index) {
            const slides = document.querySelectorAll('.hero-slide');
            const dots = document.querySelectorAll('.hero-dot');

            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            slides[index].classList.add('active');
            dots[index].classList.add('active');
            currentSlide = index;
            updateHeroContent(index);
        }

        function updateHeroContent(index) {
            const slide = heroSlides[index];
            const heroContent = document.querySelector('.hero-content');

            if (heroContent) {
                heroContent.innerHTML = `
                    <div class="hero-tagline">${slide.tagline}</div>
                    <h1 class="hero-title">${slide.title}</h1>
                    <div class="hero-subtitle">${slide.subtitle}</div>
                    <p class="hero-description">${slide.description}</p>
                    <a href="#flash-sale" class="hero-cta">Shop Flash Sale</a>
                `;
            }
        }

        // Categories
        function renderCategories() {
            const categoriesGrid = document.getElementById('categoriesGrid');
            categoriesGrid.innerHTML = categories.map(category => `
                <div class="category-item" data-category="${category.id}" onclick="filterByCategory('${category.id}')">
                    <div class="category-circle">
                        <i class="${category.icon} category-icon"></i>
                    </div>
                    <span class="category-name">${category.name}</span>
                </div>
            `).join('');
        }

        // Product Functions
        function formatPrice(price) {
            return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function formatNumber(num) {
            if (num >= 1000) return (num / 1000).toFixed(1).replace(/\.0$/, '') + 'k';
            return num.toString();
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

        function getProductImage(product) {
            if (!product.image || product.image.trim() === '') {
                return defaultImages[product.category] ||
                    'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80';
            }
            return product.image;
        }

        function renderProductCard(product, isFlashSale = false) {
            const stars = generateStars(product.rating);
            const discountPercent = Math.round(((product.originalPrice - product.price) / product.originalPrice) * 100);
            const productImage = getProductImage(product);

            return `
                <div class="product-card" onclick="showProductDetails(${product.id})">
                    ${isFlashSale ?
                        '<span class="flash-badge">Flash Sale</span>' :
                        '<span class="recommended-badge">Recommended</span>'
                    }
                    <div class="product-image-container">
                        <img src="${productImage}" alt="${product.name}" class="product-image">
                        <div class="product-actions">
                            <button class="favorite-btn" onclick="toggleFavorite(${product.id}, this); event.stopPropagation()">
                                <i class="far fa-star"></i>
                            </button>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-brand">
                            <i class="fas fa-store"></i>
                            ${product.brand}
                        </div>
                        <h3 class="product-name">${product.name}</h3>
                        <span class="product-category">${categoryNames[product.category]}</span>
                        <div class="product-rating">
                            <div class="stars">${stars}</div>
                            <span class="rating-count">(${formatNumber(product.ratingCount)})</span>
                        </div>
                        <div class="product-price">
                            <div class="price-container">
                                <span class="current-price">Rp${formatPrice(product.price)}</span>
                                <div>
                                    <span class="original-price">Rp${formatPrice(product.originalPrice)}</span>
                                    <span class="discount-percent">-${discountPercent}%</span>
                                </div>
                            </div>
                            <button class="add-to-cart-btn" onclick="addToCart(${product.id}, '${product.name}', ${product.price}); event.stopPropagation()">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        // Flash Sale
        function renderFlashSale() {
            const container = document.getElementById('flashSaleProducts');
            const dotsContainer = document.getElementById('flashSaleDots');

            container.innerHTML = flashSaleProducts.map(product => `
                <div class="swiper-slide">
                    ${renderProductCard(product, true)}
                </div>
            `).join('');

            // Create dots for flash sale
            dotsContainer.innerHTML = '';
            const numSlides = flashSaleProducts.length;
            for (let i = 0; i < numSlides; i++) {
                const dot = document.createElement('div');
                dot.className = `flash-sale-dot ${i === 0 ? 'active' : ''}`;
                dot.dataset.index = i;
                dot.addEventListener('click', () => {
                    flashSaleSwiper.slideTo(i);
                });
                dotsContainer.appendChild(dot);
            }

            initializeFlashSaleSwiper();
        }

        function initializeFlashSaleSwiper() {
            if (flashSaleSwiper) {
                flashSaleSwiper.destroy();
            }

            flashSaleSwiper = new Swiper('#flashSaleSwiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 25,
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 30,
                    },
                },
                on: {
                    slideChange: function() {
                        const dots = document.querySelectorAll('.flash-sale-dot');
                        const activeIndex = this.realIndex;

                        dots.forEach((dot, index) => {
                            if (index === activeIndex) {
                                dot.classList.add('active');
                            } else {
                                dot.classList.remove('active');
                            }
                        });
                    }
                }
            });
        }

        // Fungsi untuk generate rekomendasi produk secara acak
        function generateRecommendedProducts() {
            // Ambil 12 produk secara acak dari database
            const shuffled = [...productDatabase].sort(() => 0.5 - Math.random());
            recommendedProducts = shuffled.slice(0, 12);

            // Tambahkan timestamp untuk tracking
            recommendedProducts.forEach((product, index) => {
                product.generatedAt = new Date().toISOString();
                product.recommendationId = Date.now() + index;
            });

            return recommendedProducts;
        }

        // Fungsi untuk refresh rekomendasi setiap 5 menit
        function startRecommendedRefresh() {
            // Refresh pertama kali
            refreshRecommendedProducts();

            // Set interval setiap 5 menit (300000 ms)
            recommendedRefreshInterval = setInterval(() => {
                refreshRecommendedProducts();
                showNotification("Recommended products updated! 🍽️", "success");
            }, 300000); // 5 menit = 300000 milidetik
        }

        function refreshRecommendedProducts() {
            generateRecommendedProducts();
            renderRecommendedProducts('all');
        }

        // Recommended Products
        function renderCategoryFilter() {
            const categories = ["all", ...new Set(recommendedProducts.map(p => p.category))];
            const container = document.getElementById('categoryFilter');

            container.innerHTML = categories.map(category => `
                <button class="category-btn ${category === 'all' ? 'active' : ''}"
                        data-category="${category}"
                        onclick="filterRecommendedProducts('${category}')">
                    ${categoryNames[category] || category}
                </button>
            `).join('');
        }

        function renderRecommendedProducts(filterCategory = 'all') {
            const container = document.getElementById('recommendedGrid');
            let filteredProducts = recommendedProducts;

            if (filterCategory !== 'all') {
                filteredProducts = recommendedProducts.filter(p => p.category === filterCategory);
            }

            container.innerHTML = filteredProducts.map(product =>
                renderProductCard(product, false)
            ).join('');

            // Update active button
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.category === filterCategory) {
                    btn.classList.add('active');
                }
            });
        }

        function filterRecommendedProducts(category) {
            renderRecommendedProducts(category);
            showNotification(`Showing ${categoryNames[category] || category}`, 'info');
        }

        function filterByCategory(category) {
            filterRecommendedProducts(category);
            document.getElementById('recommended-foods').scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Cart Functions
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

        // Other Functions
        function toggleFavorite(productId, button) {
            button.classList.toggle('active');
            if (button.classList.contains('active')) {
                showNotification('Added to favorites!', 'success');
            } else {
                showNotification('Removed from favorites', 'info');
            }
        }

        function showProductDetails(productId) {
            // Cari produk dari semua sumber
            let product = [...flashSaleProducts, ...recommendedProducts].find(p => p.id === productId);

            if (!product) {
                // Cari dari database jika tidak ditemukan
                product = productDatabase.find(p => p.id === productId);
            }

            if (product) {
                showNotification(`Viewing details for ${product.name}`, 'info');
                // Simpan produk yang sedang dilihat untuk halaman detail
                localStorage.setItem('lastbite_viewing_product', JSON.stringify(product));
                // Redirect ke halaman detail produk (bisa diimplementasikan nanti)
                // window.location.href = `/product/${productId}`;
            }
        }

        // Countdown Timer - Global 24-hour timer
        function updateCountdownTimer() {
            const timerElement = document.getElementById('countdownTimer');

            const getRemainingTime = () => {
                const storedTime = localStorage.getItem('lastbite_flashsale_time');
                const now = Date.now();

                if (storedTime) {
                    const endTime = parseInt(storedTime);
                    const remaining = Math.floor((endTime - now) / 1000);

                    if (remaining > 0) {
                        return remaining;
                    }
                }

                const endTime = now + (24 * 60 * 60 * 1000);
                localStorage.setItem('lastbite_flashsale_time', endTime.toString());
                return 24 * 60 * 60;
            };

            let totalSeconds = getRemainingTime();

            const timerInterval = setInterval(() => {
                if (totalSeconds <= 0) {
                    clearInterval(timerInterval);
                    timerElement.textContent = "SALE ENDED";
                    timerElement.style.color = "#FF4757";

                    setTimeout(() => {
                        const endTime = Date.now() + (24 * 60 * 60 * 1000);
                        localStorage.setItem('lastbite_flashsale_time', endTime.toString());
                        updateCountdownTimer();
                    }, 5000);
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

        // Initialize Dashboard
        function initializeDashboard() {
            initializeHeroSlideshow();
            renderCategories();
            renderFlashSale();

            // Generate dan render rekomendasi produk
            generateRecommendedProducts();
            renderCategoryFilter();
            renderRecommendedProducts();

            // Mulai refresh otomatis setiap 5 menit
            startRecommendedRefresh();

            updateCountdownTimer();
            updateCartCount();

            console.log('Dashboard initialized');
            console.log(`Loaded ${recommendedProducts.length} recommended products (will refresh every 5 minutes)`);
            console.log(`Loaded ${flashSaleProducts.length} flash sale products`);
            console.log('Flash sale timer synchronized globally');
        }

        // Clean up interval saat halaman ditutup
        window.addEventListener('beforeunload', () => {
            if (recommendedRefreshInterval) {
                clearInterval(recommendedRefreshInterval);
            }
        });

        // Initialize when DOM is loaded
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeDashboard);
        } else {
            initializeDashboard();
        }
    </script>

    <!-- =========================================== -->
    <!-- FOOTER SECTION -->
    <!-- =========================================== -->
    <style>
        /* ========== FOOTER STYLES ========== */
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

    <script>
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

            console.log('Footer initialized successfully');
        }
    </script>

    <!-- =========================================== -->
    <!-- MAIN INITIALIZATION -->
    <!-- =========================================== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // ========== MAIN INITIALIZATION ==========
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all sections
            initializeDashboard();
            initializeFooter();

            // Newsletter input enter key (dashboard)
            const newsletterEmail = document.getElementById('newsletterEmail');
            if (newsletterEmail) {
                newsletterEmail.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') subscribeNewsletter();
                });
            }

            console.log('LastBite Website Fully Initialized');
        });

        // Shared newsletter function (for old dashboard newsletter)
        function subscribeNewsletter() {
            const email = document.getElementById('newsletterEmail')?.value.trim();
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
    </script>
</body>

</html>
