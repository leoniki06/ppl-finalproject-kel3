<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LastBite - My Profile</title>

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
        }

        .logo {
            width: 100px;
            height: auto;
            object-fit: contain;
            cursor: pointer;
            transition: var(--transition);
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
        }

        .catalog-btn:hover {
            background: var(--primary-color);
            color: white;
        }

        .catalog-text {
            color: var(--primary-color);
            font-size: 16px;
            font-weight: 600;
        }

        .catalog-btn:hover .catalog-text {
            color: white;
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
            border: 1.5px solid rgba(63, 35, 5, 0.15);
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
        }

        .search-icon-container:hover {
            background: var(--primary-dark);
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
            color: white;
            text-decoration: none;
        }

        .cart-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            text-decoration: none;
            color: white;
        }

        .cart-text {
            color: var(--white);
            font-size: 16px;
            font-weight: 600;
        }

        .cart-icon {
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
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
        }

        /* Avatar di Navbar */
        .profile-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            display: block;
        }

        .profile-avatar div {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .profile-text {
            color: var(--primary-color);
            font-size: 15px;
            font-weight: 600;
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
            text-decoration: none;
        }

        .dropdown-item:hover {
            background: rgba(63, 35, 5, 0.08);
            color: var(--primary-color);
            text-decoration: none;
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
            color: var(--primary-light);
        }

        /* ========== PROFILE CONTENT ========== */
        .profile-layout {
            display: flex;
            gap: 40px;
            margin: 40px auto;
            max-width: 1400px;
            padding: 0 20px;
        }

        /* User Info Card (Left Sidebar) */
        .user-info-card {
            width: 320px;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow-medium);
            position: sticky;
            top: 120px;
            height: fit-content;
        }

        .user-avatar-large {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 25px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .user-avatar-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .avatar-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .user-avatar-large:hover .avatar-overlay {
            opacity: 1;
        }

        .user-name {
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
        }

        .user-title {
            font-size: 16px;
            opacity: 0.9;
            text-align: center;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .personal-id {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 12px;
            margin-top: 25px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
        }

        .id-label {
            font-size: 12px;
            opacity: 0.8;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .id-value {
            font-size: 18px;
            font-weight: 600;
            font-family: 'Courier New', monospace;
            margin-bottom: 10px;
        }

        /* Profile Content (Main Area) */
        .profile-content {
            flex: 1;
            min-width: 0;
        }

        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .profile-title {
            font-size: 36px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }

        .edit-profile-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
        }

        .edit-profile-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(63, 35, 5, 0.2);
        }

        /* Profile Info Grid */
        .profile-info-grid {
            background: var(--white);
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow-medium);
            margin-bottom: 30px;
            border: 1px solid rgba(63, 35, 5, 0.08);
        }

        .info-section {
            margin-bottom: 40px;
        }

        .info-section:last-child {
            margin-bottom: 0;
        }

        .section-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 15px;
            display: block;
        }

        .info-value {
            font-size: 18px;
            font-weight: 500;
            color: var(--text-dark);
            padding: 12px 0;
            min-height: 50px;
            display: flex;
            align-items: center;
        }

        /* Device Management */
        .device-management {
            background: linear-gradient(135deg, rgba(63, 35, 5, 0.03), rgba(63, 35, 5, 0.01));
            border-radius: 16px;
            padding: 25px;
            margin-top: 30px;
            border: 1px solid rgba(63, 35, 5, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .device-info {
            flex: 1;
        }

        .device-status {
            font-weight: 500;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .device-count {
            font-size: 14px;
            color: var(--text-light);
        }

        .signout-btn {
            background: var(--white);
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
            border: none;
        }

        .signout-btn:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(63, 35, 5, 0.2);
        }

        /* Recent Orders */
        .orders-section {
            background: var(--white);
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow-medium);
            margin-top: 30px;
            border: 1px solid rgba(63, 35, 5, 0.08);
        }

        .orders-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .section-subtitle {
            font-size: 24px;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }

        .view-all-btn {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .view-all-btn:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            text-decoration: none;
        }

        .orders-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .order-card {
            background: var(--bg-light);
            border-radius: 15px;
            padding: 25px;
            transition: var(--transition);
            border: 1px solid rgba(63, 35, 5, 0.05);
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-light);
            border-color: var(--primary-color);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(63, 35, 5, 0.1);
        }

        .order-id {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 16px;
        }

        .order-status {
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-completed {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .order-details {
            font-size: 14px;
            color: var(--text-dark);
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .order-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid rgba(63, 35, 5, 0.1);
            font-weight: 600;
        }

        .total-amount {
            color: var(--primary-color);
            font-size: 18px;
        }

        /* Help Center */
        .help-section {
            background: linear-gradient(135deg, rgba(63, 35, 5, 0.03), rgba(63, 35, 5, 0.01));
            border-radius: 20px;
            padding: 40px;
            margin-top: 30px;
            border: 1px solid rgba(63, 35, 5, 0.05);
        }

        .help-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .help-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .help-item {
            background: var(--white);
            padding: 25px;
            border-radius: 15px;
            box-shadow: var(--shadow-light);
            transition: var(--transition);
            border: 1px solid rgba(63, 35, 5, 0.05);
            cursor: pointer;
        }

        .help-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
            border-color: var(--primary-color);
        }

        .help-question {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 10px;
            font-size: 16px;
        }

        .help-answer {
            font-size: 14px;
            color: var(--text-light);
            line-height: 1.6;
        }

        /* ========== MODAL STYLES ========== */
        .edit-modal .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: var(--shadow-medium);
            overflow: hidden;
        }

        .edit-modal .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            padding: 25px 30px;
            border-bottom: none;
            border-radius: 20px 20px 0 0;
        }

        .edit-modal .modal-title {
            font-weight: 600;
            font-size: 22px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .edit-modal .modal-body {
            padding: 30px;
            max-height: 70vh;
            overflow-y: auto;
        }

        .edit-modal .modal-footer {
            border-top: 1px solid rgba(63, 35, 5, 0.1);
            padding: 20px 30px;
            background: var(--bg-light);
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control,
        .form-select {
            border: 2px solid rgba(63, 35, 5, 0.1);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 16px;
            transition: var(--transition);
            background: var(--white);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(63, 35, 5, 0.1);
            outline: none;
        }

        .form-text {
            font-size: 13px;
            color: var(--text-light);
            margin-top: 5px;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
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

        .notification-warning {
            background: #ffc107;
            color: var(--text-dark);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1200px) {
            .profile-layout {
                flex-direction: column;
            }

            .user-info-card {
                width: 100%;
                position: static;
                margin-bottom: 30px;
            }
        }

        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                gap: 20px;
                align-items: flex-start;
            }

            .edit-profile-btn {
                width: 100%;
                justify-content: center;
            }

            .device-management {
                flex-direction: column;
                gap: 20px;
                align-items: flex-start;
            }

            .signout-btn {
                width: 100%;
                justify-content: center;
            }

            .orders-grid,
            .help-grid {
                grid-template-columns: 1fr;
            }

            .profile-info-grid,
            .orders-section,
            .help-section {
                padding: 25px;
            }
        }

        @media (max-width: 576px) {
            .profile-title {
                font-size: 28px;
            }

            .info-value {
                font-size: 16px;
            }

            .navbar-container {
                padding: 15px 20px;
            }

            .search-container {
                width: 200px;
            }
        }

        /* Alert Styles */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: rgba(40, 167, 69, 0.1);
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
        }

        .bg-warning {
            background-color: #ffc107 !important;
            color: #212529 !important;
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
            color: white !important;
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
        <a href="{{ route('cart.index') }}" class="cart-btn">
            <div class="cart-text">Cart</div>
            <div class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-badge" id="cartCount">0</span>
            </div>
        </a>

        <!-- Profile Dropdown -->
        <div class="nav-item dropdown">
            <button class="profile-btn" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile-avatar" id="navbarProfileAvatar">
                    @php
                        $user = auth()->user();
                        if ($user && $user->profile_photo) {
                            $avatarUrl = asset('storage/profile-photos/' . $user->profile_photo) . '?t=' . time();
                            echo '<img src="' .
                                $avatarUrl .
                                '" alt="Profile" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">';
                        } else {
                            $initial = $user ? strtoupper(substr($user->name, 0, 1)) : 'G';
                            echo '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">' .
                                $initial .
                                '</div>';
                        }
                    @endphp
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

    <!-- ========== PROFILE CONTENT ========== -->
    <div class="profile-layout">
        <!-- User Info Card -->
        <div class="user-info-card">
            <div class="user-avatar-large" id="profileAvatar" onclick="triggerPhotoUpload()">
                @if ($user->profile_photo)
                    <img src="{{ asset('storage/profile-photos/' . $user->profile_photo) }}" alt="Profile Photo"
                        id="avatarImage">
                @else
                    <div id="avatarInitial" style="font-size: 40px; color: white;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <div class="avatar-overlay">
                    <i class="fas fa-camera"></i>
                </div>
            </div>
            <input type="file" id="profilePhotoInput" accept="image/*" style="display: none;"
                onchange="uploadProfilePhoto(this)">

            <h2 class="user-name" id="userName">{{ $user->name }}</h2>
            <div class="user-title">
                @if ($user->role == 'seller')
                    Seller @LastBite
                @else
                    Premium Buyer @LastBite
                @endif
            </div>

            <div class="personal-id">
                <div class="id-label">User ID</div>
                <div class="id-value" id="personalId">LB-{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</div>
                <a href="#" class="id-link" onclick="triggerPhotoUpload()"
                    style="margin-top: 10px; display: inline-block; color: var(--accent-color); text-decoration: none;">
                    <i class="fas fa-camera me-1"></i> Change Photo
                </a>
                @if ($user->profile_photo)
                    <br>
                    <a href="#" class="id-link text-danger" onclick="deleteProfilePhoto()"
                        style="margin-top: 5px; display: inline-block; text-decoration: none;">
                        <i class="fas fa-trash me-1"></i> Remove Photo
                    </a>
                @endif
            </div>
        </div>

        <!-- Main Profile Content -->
        <div class="profile-content">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <!-- Profile Header -->
            <div class="profile-header">
                <h1 class="profile-title">Profile</h1>
                <button class="edit-profile-btn" id="editProfileBtn" data-bs-toggle="modal"
                    data-bs-target="#editProfileModal">
                    <i class="fas fa-edit"></i>
                    Edit Profile
                </button>
            </div>

            <!-- Profile Information Grid -->
            <div class="profile-info-grid">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="info-section">
                            <span class="section-label">EMAIL</span>
                            <div class="info-value" id="emailValue">{{ $user->email ?? 'guest@example.com' }}</div>
                        </div>

                        <div class="info-section">
                            <span class="section-label">ROLE</span>
                            <div class="info-value">
                                @if ($user->role == 'seller')
                                    <span class="badge bg-warning">Penjual</span>
                                @else
                                    <span class="badge bg-primary">Pembeli</span>
                                @endif
                            </div>
                        </div>

                        <div class="info-section">
                            <span class="section-label">REGISTRATION DATE</span>
                            <div class="info-value" id="registrationValue">
                                {{ $user->created_at->format('d F Y') ?? date('d F Y') }}</div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="info-section">
                            <span class="section-label">PHONE</span>
                            <div class="info-value" id="phoneValue">{{ $user->phone ?? '+62 812 3456 7890' }}</div>
                        </div>

                        <div class="info-section">
                            <span class="section-label">ADDRESS</span>
                            <div class="info-value" id="addressValue">{{ $user->address ?? 'Jakarta, Indonesia' }}
                            </div>
                        </div>

                        <div class="info-section">
                            <span class="section-label">PASSWORD</span>
                            <div class="info-value password">••••••••••</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Device Management -->
            <div class="device-management">
                <div class="device-info">
                    <div class="device-status">Currently logged in on this device</div>
                    <div class="device-count">Last active: Just now</div>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="signout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        Sign Out
                    </button>
                </form>
            </div>

            <!-- Recent Orders -->
            <div class="orders-section">
                <div class="orders-header">
                    <h2 class="section-subtitle">Recent Orders</h2>
                    <a href="{{ route('profile.orders') }}" class="view-all-btn">
                        View All
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="orders-grid">
                    <!-- Dummy order data -->
                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-id">#LB-2024-001</div>
                            <div class="order-status status-completed">Completed</div>
                        </div>
                        <div class="order-details">
                            Artisan Bread Package, Fresh Salad Bowl
                        </div>
                        <div class="order-total">
                            <span>Total:</span>
                            <span class="total-amount">Rp 85.000</span>
                        </div>
                    </div>

                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-id">#LB-2024-002</div>
                            <div class="order-status status-completed">Completed</div>
                        </div>
                        <div class="order-details">
                            Sushi Combo, Green Tea
                        </div>
                        <div class="order-total">
                            <span>Total:</span>
                            <span class="total-amount">Rp 90.000</span>
                        </div>
                    </div>

                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-id">#LB-2024-003</div>
                            <div class="order-status status-pending">Pending</div>
                        </div>
                        <div class="order-details">
                            Fruits & Vegetables Box
                        </div>
                        <div class="order-total">
                            <span>Total:</span>
                            <span class="total-amount">Rp 120.000</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Center -->
            <div class="help-section">
                <h2 class="help-title">
                    <i class="fas fa-question-circle"></i>
                    Help Center
                </h2>

                <div class="help-grid">
                    <div class="help-item" onclick="showHelp('edit-profile')">
                        <div class="help-question">How to edit my profile information?</div>
                        <div class="help-answer">Click "Edit Profile" button to update your personal details, email,
                            and preferences.</div>
                    </div>

                    <div class="help-item" onclick="showHelp('track-order')">
                        <div class="help-question">How to track my order?</div>
                        <div class="help-answer">Go to "Order History" in profile dropdown to view and track your
                            orders.</div>
                    </div>

                    <div class="help-item" onclick="showHelp('change-password')">
                        <div class="help-question">How to change password?</div>
                        <div class="help-answer">Click "Edit Profile" and fill the password section to update your
                            password.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== EDIT PROFILE MODAL ========== -->
    <div class="modal fade edit-modal" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">
                        <i class="fas fa-user-edit"></i>
                        Edit Profile Information
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('profile.update') }}" method="POST" id="editProfileForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <!-- Foto Profil Section -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label">
                                    <i class="fas fa-camera"></i> Profile Photo
                                </label>

                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <div class="avatar-preview"
                                            style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; background: #f0f0f0; border: 2px dashed #ddd;">
                                            @if ($user->profile_photo)
                                                <img id="photoPreview"
                                                    src="{{ asset('storage/profile-photos/' . $user->profile_photo) }}"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <div id="photoPreview"
                                                    style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #666;">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex-grow-1">
                                        <input type="file" class="form-control" id="profile_photo"
                                            name="profile_photo" accept="image/*" onchange="previewPhoto(event)">
                                        <div class="form-text">
                                            Upload foto profil (JPEG, PNG, JPG, GIF). Max 2MB.
                                        </div>

                                        @if ($user->profile_photo)
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="remove_photo"
                                                    name="remove_photo" value="1">
                                                <label class="form-check-label text-danger" for="remove_photo">
                                                    Hapus foto profil
                                                </label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user"></i> Full Name
                                </label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i> Email Address
                                </label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $user->email) }}" required>
                                <div class="form-text">We'll send notifications to this email</div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone"></i> Phone Number
                                </label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone', $user->phone ?? '') }}">
                                <div class="form-text">For delivery updates</div>
                            </div>

                            <div class="col-md-6">
                                <label for="address" class="form-label">
                                    <i class="fas fa-map-marker-alt"></i> Address
                                </label>
                                <textarea class="form-control" id="address" name="address" rows="2">{{ old('address', $user->address ?? '') }}</textarea>
                            </div>
                        </div>

                        <!-- Password Change Section -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">
                                    <i class="fas fa-key"></i> Change Password
                                </label>
                                <button type="button" class="btn btn-sm btn-outline-primary"
                                    onclick="togglePasswordSection()">
                                    Change Password
                                </button>
                            </div>
                            <div id="passwordSection" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control" id="current_password"
                                                name="current_password">
                                            <button type="button" class="password-toggle"
                                                onclick="togglePasswordVisibility('current_password')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control" id="new_password"
                                                name="new_password">
                                            <button type="button" class="password-toggle"
                                                onclick="togglePasswordVisibility('new_password')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="form-text">Min 8 characters with letters & numbers</div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Confirm New
                                        Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="new_password_confirmation"
                                            name="new_password_confirmation">
                                        <button type="button" class="password-toggle"
                                            onclick="togglePasswordVisibility('new_password_confirmation')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ========== JAVASCRIPT ========== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // CSRF Token
        const csrfToken = "{{ csrf_token() }}";

        // ========== PROFILE FUNCTIONS ==========
        function triggerPhotoUpload() {
            document.getElementById('profilePhotoInput').click();
        }

        function previewPhoto(event) {
            const input = event.target;
            const preview = document.getElementById('photoPreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    if (preview.tagName === 'IMG') {
                        preview.src = e.target.result;
                    } else {
                        // Jika div, ganti dengan img
                        const img = document.createElement('img');
                        img.id = 'photoPreview';
                        img.src = e.target.result;
                        img.style.width = '100%';
                        img.style.height = '100%';
                        img.style.objectFit = 'cover';
                        preview.parentNode.replaceChild(img, preview);
                    }
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function uploadProfilePhoto(input) {
            if (input.files && input.files[0]) {
                // Validasi file
                const file = input.files[0];
                const maxSize = 2 * 1024 * 1024; // 2MB
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

                if (file.size > maxSize) {
                    showNotification('File terlalu besar. Maksimal 2MB.', 'error');
                    input.value = '';
                    return;
                }

                if (!validTypes.includes(file.type)) {
                    showNotification('Format file tidak didukung. Gunakan JPEG, PNG, JPG, atau GIF.', 'error');
                    input.value = '';
                    return;
                }

                // Tampilkan loading
                showNotification('Mengupload foto...', 'info');

                // Buat FormData
                const formData = new FormData();
                formData.append('profile_photo', file);
                formData.append('_token', csrfToken);
                formData.append('name', '{{ $user->name }}');
                formData.append('email', '{{ $user->email }}');

                // Kirim ke server
                fetch('{{ route('profile.update') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update preview avatar
                            const avatar = document.getElementById('profileAvatar');
                            if (data.avatar_url) {
                                avatar.innerHTML = `<img src="${data.avatar_url}" alt="Profile Photo"
                                style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                <div class="avatar-overlay">
                                    <i class="fas fa-camera"></i>
                                </div>`;
                            }

                            showNotification('Foto profil berhasil diupload!', 'success');

                            // Refresh halaman setelah 1.5 detik
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showNotification(data.message || 'Gagal upload foto', 'error');
                            input.value = '';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Terjadi kesalahan saat upload foto', 'error');
                        input.value = '';
                    });
            }
        }

        function deleteProfilePhoto() {
            if (confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
                showNotification('Menghapus foto profil...', 'info');

                fetch('{{ route('profile.delete-photo') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Update avatar preview
                            const avatar = document.getElementById('profileAvatar');
                            const initial = '{{ strtoupper(substr($user->name, 0, 1)) }}';
                            avatar.innerHTML = `<div style="font-size: 40px; color: white;">${initial}</div>
                    <div class="avatar-overlay">
                        <i class="fas fa-camera"></i>
                    </div>`;

                            showNotification('Foto profil berhasil dihapus!', 'success');

                            // Refresh halaman setelah 1.5 detik
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showNotification(data.message || 'Gagal menghapus foto', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Terjadi kesalahan saat menghapus foto', 'error');
                    });
            }

            // Setelah upload foto berhasil, dispatch event
            if (data.success && data.avatar_url) {
                // Dispatch event untuk memberitahu halaman lain
                const avatarUpdatedEvent = new CustomEvent('avatarUpdated', {
                    detail: {
                        avatar_url: data.avatar_url
                    }
                });
                window.dispatchEvent(avatarUpdatedEvent);

                // Juga update localStorage untuk sinkronisasi
                localStorage.setItem('last_avatar_update', new Date().getTime());
                localStorage.setItem('last_avatar_url', data.avatar_url);
            }

            // Setelah hapus foto berhasil, dispatch event
            if (data.success) {
                // Dispatch event untuk memberitahu halaman lain
                const avatarDeletedEvent = new Event('avatarDeleted');
                window.dispatchEvent(avatarDeletedEvent);

                // Clear localStorage
                localStorage.removeItem('last_avatar_update');
                localStorage.removeItem('last_avatar_url');
            }
        }

        function togglePasswordSection() {
            const passwordSection = document.getElementById('passwordSection');
            if (passwordSection.style.display === 'none') {
                passwordSection.style.display = 'block';
            } else {
                passwordSection.style.display = 'none';
                document.getElementById('current_password').value = '';
                document.getElementById('new_password').value = '';
                document.getElementById('new_password_confirmation').value = '';
            }
        }

        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function showNotification(message, type = 'success') {
            // Remove existing notification
            const existingNotification = document.querySelector('.notification');
            if (existingNotification) {
                existingNotification.remove();
            }

            // Create new notification element
            const notification = document.createElement('div');
            notification.className = `notification show notification-${type}`;

            let icon = 'fas fa-check-circle';
            if (type === 'error') icon = 'fas fa-exclamation-circle';
            if (type === 'warning') icon = 'fas fa-exclamation-triangle';
            if (type === 'info') icon = 'fas fa-info-circle';

            notification.innerHTML = `<i class="${icon}"></i><span>${message}</span>`;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 400);
            }, 3000);
        }

        function showHelp(topic) {
            const helpMessages = {
                'edit-profile': 'To edit your profile, click the "Edit Profile" button at the top right. You can update your personal information, email, phone number, and preferences in the modal that appears.',
                'track-order': 'Go to "Order History" in the profile dropdown menu to view all your past orders and track current orders in real-time. You can also view recent orders in the "Recent Orders" section below.',
                'change-password': 'Click "Edit Profile" button, then click "Change Password" to expand the password section. Enter your current password and new password, then confirm the new password.'
            };

            alert(helpMessages[topic] || 'Help information not available for this topic.');
        }

        // ========== INITIALIZATION ==========
        document.addEventListener('DOMContentLoaded', function() {
            // Search input enter key
            document.getElementById('searchInput')?.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const query = this.value.trim();
                    if (query) {
                        showNotification(`Searching for: ${query}`, 'info');
                        this.value = '';
                    } else {
                        showNotification('Please enter a search keyword', 'warning');
                    }
                }
            });

            // Form validation
            const form = document.getElementById('editProfileForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const newPassword = document.getElementById('new_password')?.value;
                    const confirmPassword = document.getElementById('new_password_confirmation')?.value;

                    if (newPassword || confirmPassword) {
                        if (newPassword && newPassword.length < 8) {
                            e.preventDefault();
                            showNotification('New password must be at least 8 characters', 'error');
                            return false;
                        }

                        if (newPassword !== confirmPassword) {
                            e.preventDefault();
                            showNotification('New passwords do not match', 'error');
                            return false;
                        }
                    }

                    // Show loading
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                        submitBtn.disabled = true;
                    }

                    return true;
                });
            }

            // ========== PROFILE PHOTO FUNCTIONS ==========
            function triggerPhotoUpload() {
                document.getElementById('profilePhotoInput').click();
            }

            function previewPhoto(event) {
                const input = event.target;
                const preview = document.getElementById('photoPreview');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        if (preview.tagName === 'IMG') {
                            preview.src = e.target.result;
                        } else {
                            // Jika div, ganti dengan img
                            const img = document.createElement('img');
                            img.id = 'photoPreview';
                            img.src = e.target.result;
                            img.style.width = '100%';
                            img.style.height = '100%';
                            img.style.objectFit = 'cover';
                            preview.parentNode.replaceChild(img, preview);
                        }
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            function uploadProfilePhoto(input) {
                if (input.files && input.files[0]) {
                    // Validasi file
                    const file = input.files[0];
                    const maxSize = 2 * 1024 * 1024; // 2MB
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

                    if (file.size > maxSize) {
                        showNotification('File terlalu besar. Maksimal 2MB.', 'error');
                        input.value = '';
                        return;
                    }

                    if (!validTypes.includes(file.type)) {
                        showNotification('Format file tidak didukung. Gunakan JPEG, PNG, JPG, atau GIF.', 'error');
                        input.value = '';
                        return;
                    }

                    // Tampilkan preview segera di semua avatar
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Update avatar besar
                        const mainAvatar = document.getElementById('profileAvatar');
                        mainAvatar.innerHTML = `<img src="${e.target.result}" alt="Profile Photo"
                style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                <div class="avatar-overlay">
                    <i class="fas fa-camera"></i>
                </div>`;

                        // Update avatar kecil di navbar
                        const navbarAvatar = document.getElementById('navbarProfileAvatar');
                        navbarAvatar.innerHTML = `<img src="${e.target.result}" alt="Profile"
                style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">`;
                    };
                    reader.readAsDataURL(file);

                    // Tampilkan loading
                    showNotification('Mengupload foto...', 'info');

                    // Buat FormData
                    const formData = new FormData();
                    formData.append('profile_photo', file);
                    formData.append('_token', csrfToken);
                    formData.append('name', '{{ $user->name }}');
                    formData.append('email', '{{ $user->email }}');

                    // Kirim ke server
                    fetch('{{ route('profile.update') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Upload response:', data);

                            if (data.success) {
                                // Update semua avatar dengan URL dari server (dengan timestamp untuk bypass cache)
                                if (data.avatar_url) {
                                    updateAllAvatars(data.avatar_url);
                                }

                                showNotification('Foto profil berhasil diupload!', 'success');

                                // Update modal preview jika terbuka
                                const modalPreview = document.getElementById('photoPreview');
                                if (modalPreview && data.avatar_url) {
                                    if (modalPreview.tagName === 'IMG') {
                                        modalPreview.src = data.avatar_url + '?t=' + new Date().getTime();
                                    }
                                }

                                // Reset input file
                                input.value = '';

                            } else {
                                showNotification(data.message || 'Gagal upload foto', 'error');
                                // Kembalikan semua avatar ke state sebelumnya
                                resetAllAvatars();
                                input.value = '';
                            }
                        })
                        .catch(error => {
                            console.error('Upload error:', error);
                            showNotification('Terjadi kesalahan saat upload foto: ' + error.message, 'error');
                            // Kembalikan semua avatar ke state sebelumnya
                            resetAllAvatars();
                            input.value = '';
                        });
                }
            }

            // Fungsi untuk update semua avatar
            function updateAllAvatars(avatarUrl) {
                const timestamp = new Date().getTime();
                const urlWithTimestamp = avatarUrl + (avatarUrl.includes('?') ? '&' : '?') + 't=' + timestamp;

                // 1. Update avatar besar di profile card
                const mainAvatar = document.getElementById('profileAvatar');
                mainAvatar.innerHTML = `<img src="${urlWithTimestamp}" alt="Profile Photo"
        style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
        <div class="avatar-overlay">
            <i class="fas fa-camera"></i>
        </div>`;

                // 2. Update avatar kecil di navbar
                const navbarAvatar = document.getElementById('navbarProfileAvatar');
                navbarAvatar.innerHTML = `<img src="${urlWithTimestamp}" alt="Profile"
        style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">`;

                // 3. Update avatar di modal preview
                const modalPreview = document.getElementById('photoPreview');
                if (modalPreview) {
                    if (modalPreview.tagName === 'IMG') {
                        modalPreview.src = urlWithTimestamp;
                    } else {
                        // Jika div, ganti dengan img
                        const img = document.createElement('img');
                        img.id = 'photoPreview';
                        img.src = urlWithTimestamp;
                        img.style.width = '100%';
                        img.style.height = '100%';
                        img.style.objectFit = 'cover';
                        modalPreview.parentNode.replaceChild(img, modalPreview);
                    }
                }
            }

            // Fungsi untuk reset semua avatar
            function resetAllAvatars() {
                @if ($user->profile_photo)
                    const currentPhoto = '{{ asset('storage/profile-photos/' . $user->profile_photo) }}?t=' +
                        new Date().getTime();

                    // Reset avatar besar
                    const mainAvatar = document.getElementById('profileAvatar');
                    mainAvatar.innerHTML = `<img src="${currentPhoto}" alt="Profile Photo"
            style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
            <div class="avatar-overlay">
                <i class="fas fa-camera"></i>
            </div>`;

                    // Reset avatar navbar
                    const navbarAvatar = document.getElementById('navbarProfileAvatar');
                    navbarAvatar.innerHTML = `<img src="${currentPhoto}" alt="Profile"
            style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">`;

                    // Reset modal preview
                    const modalPreview = document.getElementById('photoPreview');
                    if (modalPreview && modalPreview.tagName === 'IMG') {
                        modalPreview.src = currentPhoto;
                    }
                @else
                    const initial = '{{ strtoupper(substr($user->name, 0, 1)) }}';

                    // Reset avatar besar
                    const mainAvatar = document.getElementById('profileAvatar');
                    mainAvatar.innerHTML = `<div style="font-size: 40px; color: white;">${initial}</div>
            <div class="avatar-overlay">
                <i class="fas fa-camera"></i>
            </div>`;

                    // Reset avatar navbar
                    const navbarAvatar = document.getElementById('navbarProfileAvatar');
                    navbarAvatar.innerHTML =
                        `<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">${initial}</div>`;

                    // Reset modal preview
                    const modalPreview = document.getElementById('photoPreview');
                    if (modalPreview) {
                        if (modalPreview.tagName === 'IMG') {
                            // Ganti dengan div initial
                            const previewContainer = modalPreview.parentElement;
                            const div = document.createElement('div');
                            div.id = 'photoPreview';
                            div.style.width = '100%';
                            div.style.height = '100%';
                            div.style.display = 'flex';
                            div.style.alignItems = 'center';
                            div.style.justifyContent = 'center';
                            div.style.fontSize = '24px';
                            div.style.color = '#666';
                            div.textContent = initial;
                            previewContainer.replaceChild(div, modalPreview);
                        }
                    }
                @endif
            }

            function deleteProfilePhoto() {
                if (confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
                    showNotification('Menghapus foto profil...', 'info');

                    fetch('{{ route('profile.delete-photo') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Delete response:', data);

                            if (data.success) {
                                // Update semua avatar ke default
                                const initial = '{{ strtoupper(substr($user->name, 0, 1)) }}';

                                // Update avatar besar
                                const mainAvatar = document.getElementById('profileAvatar');
                                mainAvatar.innerHTML = `<div style="font-size: 40px; color: white;">${initial}</div>
                    <div class="avatar-overlay">
                        <i class="fas fa-camera"></i>
                    </div>`;

                                // Update avatar navbar
                                const navbarAvatar = document.getElementById('navbarProfileAvatar');
                                navbarAvatar.innerHTML =
                                    `<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">${initial}</div>`;

                                // Update modal preview
                                const modalPreview = document.getElementById('photoPreview');
                                if (modalPreview) {
                                    if (modalPreview.tagName === 'IMG') {
                                        // Ganti dengan div initial
                                        const previewContainer = modalPreview.parentElement;
                                        const div = document.createElement('div');
                                        div.id = 'photoPreview';
                                        div.style.width = '100%';
                                        div.style.height = '100%';
                                        div.style.display = 'flex';
                                        div.style.alignItems = 'center';
                                        div.style.justifyContent = 'center';
                                        div.style.fontSize = '24px';
                                        div.style.color = '#666';
                                        div.textContent = initial;
                                        previewContainer.replaceChild(div, modalPreview);
                                    }
                                }

                                showNotification('Foto profil berhasil dihapus!', 'success');

                            } else {
                                showNotification(data.message || 'Gagal menghapus foto', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Delete error:', error);
                            showNotification('Terjadi kesalahan saat menghapus foto', 'error');
                        });
                }
            }
        });
    </script>
</body>

</html>
