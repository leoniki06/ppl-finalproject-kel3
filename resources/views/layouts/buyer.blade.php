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

    <!-- ========== CUSTOM CSS VARIABLES & GLOBAL STYLES ========== -->
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

    <!-- ========== NAVBAR STYLES ========== -->
    <style>
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

    <!-- ========== SEARCH COMPONENT STYLES ========== -->
    <style>
        /* Search Wrapper */
        .search-wrapper {
            position: relative;
            width: 420px;
        }

        /* Search Container */
        .search-container {
            display: flex;
            align-items: center;
            background: var(--white);
            border-radius: 30px;
            border: 1.5px solid rgba(63, 35, 5, 0.15);
            box-shadow: 0 2px 8px rgba(63, 35, 5, 0.05);
            transition: var(--transition);
            overflow: hidden;
        }

        .search-container:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(63, 35, 5, 0.15);
        }

        .search-input-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 0 15px;
        }

        .search-icon-left {
            color: var(--text-light);
            margin-right: 10px;
            font-size: 16px;
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 12px 0;
            font-size: 15px;
            font-weight: 500;
            color: var(--text-dark);
            background: transparent;
        }

        .search-input::placeholder {
            color: var(--text-light);
            font-weight: 400;
        }

        .search-actions {
            display: flex;
            align-items: center;
            gap: 5px;
            padding-right: 5px;
        }

        .search-action-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .filter-btn {
            position: relative;
            color: var(--primary-color);
        }

        .filter-btn:hover {
            background: rgba(63, 35, 5, 0.08);
        }

        .filter-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--accent-color);
            color: var(--primary-dark);
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .search-btn {
            background: var(--primary-color);
            color: var(--white);
        }

        .search-btn:hover {
            background: var(--primary-dark);
            transform: scale(1.05);
        }

        /* Search Dropdown */
        .search-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow-medium);
            margin-top: 10px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition);
            z-index: 1001;
            max-height: 500px;
            overflow: hidden;
        }

        .search-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .search-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid rgba(63, 35, 5, 0.1);
        }

        .search-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--primary-color);
            font-weight: 600;
        }

        .search-clear-btn {
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
        }

        .search-clear-btn:hover {
            color: var(--primary-color);
        }

        .search-content {
            max-height: 400px;
            overflow-y: auto;
        }

        /* History Section */
        .search-history {
            padding: 15px 20px;
        }

        .history-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            color: var(--text-dark);
            font-size: 14px;
        }

        .clear-history-btn {
            background: none;
            border: none;
            color: var(--danger-color);
            font-size: 12px;
            cursor: pointer;
            transition: var(--transition);
        }

        .clear-history-btn:hover {
            opacity: 0.8;
        }

        .history-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .history-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            background: rgba(63, 35, 5, 0.03);
            border-radius: 10px;
            cursor: pointer;
            transition: var(--transition);
        }

        .history-item:hover {
            background: rgba(63, 35, 5, 0.08);
        }

        .history-text {
            color: var(--text-dark);
            font-size: 14px;
        }

        .history-time {
            color: var(--text-light);
            font-size: 12px;
        }

        /* Filter Section */
        .filter-section {
            padding: 15px 20px;
        }

        .filter-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .filter-group {
            margin-bottom: 25px;
        }

        .filter-group-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .filter-group-label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-dark);
            font-weight: 500;
            font-size: 14px;
        }

        .filter-group-value {
            color: var(--text-light);
            font-size: 12px;
        }

        /* Price Filter */
        /* Ganti bagian price filter yang ada dengan ini: */
        .price-filter {
            padding: 10px 0;
        }

        .price-inputs {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .price-input-group {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .price-input-group label {
            font-size: 11px;
            color: var(--text-light);
            margin-bottom: 5px;
        }

        .price-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid rgba(63, 35, 5, 0.15);
            border-radius: 8px;
            font-size: 13px;
            color: var(--text-dark);
            background: var(--white);
            transition: var(--transition);
        }

        .price-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(63, 35, 5, 0.1);
        }

        .price-separator {
            color: var(--text-light);
            font-size: 14px;
            margin: 0 5px;
        }

        .price-slider {
            width: 100%;
            height: 4px;
            -webkit-appearance: none;
            appearance: none;
            background: rgba(63, 35, 5, 0.1);
            border-radius: 2px;
            outline: none;
            margin: 15px 0 5px;
        }

        .price-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            background: var(--primary-color);
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid var(--white);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .price-slider::-moz-range-thumb {
            width: 18px;
            height: 18px;
            background: var(--primary-color);
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid var(--white);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .price-labels {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: var(--text-light);
        }

        /* Rating Filter */
        .rating-options {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .rating-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            background: rgba(63, 35, 5, 0.03);
            border-radius: 10px;
            cursor: pointer;
            transition: var(--transition);
        }

        .rating-option.selected,
        .rating-option:hover {
            background: rgba(63, 35, 5, 0.08);
        }

        .rating-stars {
            display: flex;
            gap: 2px;
            color: #FFD700;
        }

        .rating-label {
            font-size: 14px;
            color: var(--text-dark);
        }

        /* Category Filter */
        .category-options {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .category-chip {
            padding: 8px 15px;
            background: rgba(63, 35, 5, 0.05);
            border-radius: 20px;
            font-size: 12px;
            color: var(--text-dark);
            cursor: pointer;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .category-chip.selected {
            background: var(--primary-color);
            color: var(--white);
            border-color: var(--primary-color);
        }

        .category-chip:hover {
            background: rgba(63, 35, 5, 0.1);
        }

        /* Distance Filter */
        .distance-filter {
            padding: 10px 0;
        }

        .distance-slider {
            width: 100%;
            height: 4px;
            -webkit-appearance: none;
            appearance: none;
            background: rgba(63, 35, 5, 0.1);
            border-radius: 2px;
            outline: none;
            margin: 20px 0;
        }

        .distance-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            background: var(--primary-color);
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid var(--white);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .distance-value {
            text-align: center;
            font-size: 14px;
            color: var(--text-dark);
        }

        /* Active Filters */
        .active-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(63, 35, 5, 0.1);
        }

        .filter-tag {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            background: var(--primary-color);
            color: var(--white);
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }

        .remove-filter {
            background: none;
            border: none;
            color: var(--white);
            cursor: pointer;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <!-- ========== SEARCH RESULTS STYLES ========== -->
    <style>
        .search-results-container {
            position: fixed;
            top: 100px;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--bg-light);
            z-index: 999;
            display: none;
            overflow-y: auto;
            padding: 20px;
        }

        .search-results-container.show {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .search-results-header {
            max-width: 1500px;
            margin: 0 auto 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(63, 35, 5, 0.1);
        }

        .results-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .results-count {
            font-size: 14px;
            color: var(--text-light);
            margin-left: 10px;
        }

        .results-summary {
            font-size: 14px;
            color: var(--text-dark);
            background: var(--white);
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid rgba(63, 35, 5, 0.1);
        }

        .close-results-btn {
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 18px;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: var(--transition);
        }

        .close-results-btn:hover {
            background: rgba(63, 35, 5, 0.1);
            color: var(--primary-color);
        }

        .search-results-grid {
            max-width: 1500px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            padding: 20px 0;
        }

        .product-card {
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-light);
            transition: var(--transition);
            cursor: pointer;
            border: 1px solid rgba(63, 35, 5, 0.08);
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
            border-color: var(--primary-light);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: linear-gradient(135deg, #f9f5f0, #e8dfd3);
        }

        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--danger-color);
            color: var(--white);
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(255, 71, 87, 0.3);
        }

        .product-content {
            padding: 20px;
        }

        .product-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .product-name {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .product-category {
            font-size: 12px;
            color: var(--text-light);
            background: rgba(63, 35, 5, 0.05);
            padding: 2px 8px;
            border-radius: 10px;
            display: inline-block;
        }

        .product-price {
            font-size: 20px;
            font-weight: 700;
            color: var(--accent-color);
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            margin: 10px 0;
        }

        .rating-stars-small {
            display: flex;
            gap: 1px;
        }

        .rating-stars-small i {
            color: #FFD700;
            font-size: 12px;
        }

        .rating-value {
            font-size: 12px;
            color: var(--text-light);
        }

        .product-description {
            font-size: 13px;
            color: var(--text-dark);
            line-height: 1.5;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(63, 35, 5, 0.1);
        }

        .product-distance {
            font-size: 12px;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .product-distance i {
            color: var(--primary-color);
        }

        .product-expiry {
            font-size: 12px;
            color: var(--danger-color);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .add-to-cart-btn {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .add-to-cart-btn:hover {
            background: var(--primary-dark);
            transform: scale(1.05);
        }

        .no-results {
            text-align: center;
            padding: 60px 20px;
            grid-column: 1 / -1;
        }

        .no-results-icon {
            font-size: 60px;
            color: var(--text-light);
            margin-bottom: 20px;
        }

        .no-results-title {
            font-size: 20px;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .no-results-text {
            color: var(--text-light);
            margin-bottom: 20px;
        }

        .try-again-btn {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .try-again-btn:hover {
            background: var(--primary-dark);
        }

        /* Loading State */
        .loading-results {
            text-align: center;
            padding: 60px 20px;
            grid-column: 1 / -1;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(63, 35, 5, 0.1);
            border-top-color: var(--primary-color);
            border-radius: 50%;
            margin: 0 auto 20px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            color: var(--text-light);
        }

        @media (max-width: 1300px) {
            .search-wrapper {
                width: 400px;
            }

            .search-results-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }

        @media (max-width: 1024px) {
            .search-wrapper {
                width: 100%;
                order: 3;
                margin: 10px 0;
            }

            .search-results-container {
                padding: 15px;
            }

            .search-results-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 15px;
            }
        }

        @media (max-width: 768px) {
            .search-wrapper {
                width: 100%;
            }

            .search-content {
                max-height: 300px;
            }

            .search-results-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .search-results-grid {
                grid-template-columns: 1fr;
            }

            .product-card {
                max-width: 400px;
                margin: 0 auto;
            }
        }
    </style>

    <!-- ========== FOOTER STYLES ========== -->
    <style>
        .footer {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            color: var(--white);
            padding: 60px 0 30px;
            margin-top: 80px;
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-color), var(--danger-color), var(--success-color), var(--accent-color));
            background-size: 200% 100%;
            animation: gradientMove 3s linear infinite;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            100% {
                background-position: 200% 50%;
            }
        }

        .footer-container {
            max-width: 1500px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1.5fr;
            gap: 50px;
            margin-bottom: 50px;
        }

        .footer-column {
            display: flex;
            flex-direction: column;
        }

        .footer-brand {
            margin-bottom: 25px;
        }

        .footer-logo {
            width: 140px;
            height: auto;
            margin-bottom: 20px;
            filter: brightness(0) invert(1);
            transition: var(--transition);
        }

        .footer-logo:hover {
            transform: scale(1.05);
        }

        .footer-description {
            font-size: 14px;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 25px;
        }

        .footer-social {
            display: flex;
            gap: 12px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            transition: var(--transition);
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .social-icon:hover {
            background: var(--accent-color);
            border-color: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 159, 28, 0.3);
        }

        .footer-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 25px;
            color: var(--white);
            position: relative;
            padding-bottom: 12px;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 3px;
            background: var(--accent-color);
            border-radius: 2px;
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .footer-link {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            font-size: 14px;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 0;
        }

        .footer-link:hover {
            color: var(--accent-color);
            transform: translateX(5px);
        }

        .footer-link i {
            font-size: 12px;
            opacity: 0;
            transition: var(--transition);
        }

        .footer-link:hover i {
            opacity: 1;
        }

        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
            line-height: 1.6;
        }

        .contact-icon {
            width: 40px;
            height: 40px;
            min-width: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-color);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .contact-text {
            flex: 1;
        }

        .contact-text strong {
            display: block;
            color: var(--white);
            margin-bottom: 5px;
            font-weight: 600;
        }

        .footer-newsletter {
            margin-top: 10px;
        }

        .newsletter-text {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .newsletter-form {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .newsletter-input {
            flex: 1;
            padding: 12px 18px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.1);
            color: var(--white);
            font-size: 14px;
            transition: var(--transition);
        }

        .newsletter-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .newsletter-input:focus {
            outline: none;
            border-color: var(--accent-color);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 3px rgba(255, 159, 28, 0.2);
        }

        .newsletter-btn {
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            background: var(--accent-color);
            color: var(--primary-dark);
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
        }

        .newsletter-btn:hover {
            background: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
        }

        .footer-apps {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 15px;
        }

        .app-button {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 15px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: var(--white);
            text-decoration: none;
            transition: var(--transition);
            cursor: pointer;
        }

        .app-button:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: var(--accent-color);
            transform: translateX(5px);
        }

        .app-icon {
            font-size: 24px;
        }

        .app-text {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .app-text small {
            font-size: 10px;
            opacity: 0.8;
        }

        .app-text strong {
            font-size: 14px;
            font-weight: 600;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-copyright {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
        }

        .footer-copyright a {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .footer-copyright a:hover {
            color: var(--white);
        }

        .footer-bottom-links {
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
        }

        .footer-bottom-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 13px;
            transition: var(--transition);
            position: relative;
        }

        .footer-bottom-link::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 0;
            height: 2px;
            background: var(--accent-color);
            transition: var(--transition);
        }

        .footer-bottom-link:hover {
            color: var(--white);
        }

        .footer-bottom-link:hover::after {
            width: 100%;
        }

        .footer-payment {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .payment-icon {
            width: 50px;
            height: 32px;
            background: var(--white);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5px;
            transition: var(--transition);
            cursor: pointer;
        }

        .payment-icon:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
        }

        .payment-icon i {
            font-size: 18px;
            color: var(--primary-color);
        }

        /* Scroll to Top Button */
        .scroll-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(63, 35, 5, 0.3);
        }

        .scroll-to-top.show {
            display: flex;
        }

        .scroll-to-top:hover {
            background: var(--accent-color);
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(255, 159, 28, 0.4);
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .footer-content {
                grid-template-columns: 2fr 1fr 1fr 1.5fr;
                gap: 40px;
            }
        }

        @media (max-width: 992px) {
            .footer-content {
                grid-template-columns: 1fr 1fr;
                gap: 40px;
            }

            .footer-column:first-child {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 768px) {
            .footer {
                padding: 40px 0 20px;
                margin-top: 60px;
            }

            .footer-container {
                padding: 0 20px;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 35px;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .footer-bottom-links {
                justify-content: center;
            }

            .footer-payment {
                justify-content: center;
            }

            .scroll-to-top {
                bottom: 20px;
                right: 20px;
                width: 45px;
                height: 45px;
            }
        }

        @media (max-width: 480px) {
            .newsletter-form {
                flex-direction: column;
            }

            .newsletter-btn {
                width: 100%;
            }

            .footer-apps {
                margin-top: 10px;
            }
        }
    </style>

    <!-- ========== NOTIFICATION STYLES ========== -->
    <style>
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
    </style>
</head>

<body>
    <!-- ========== HEADER/NAVBAR SECTION ========== -->
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

        <!-- ========== SEARCH COMPONENT ========== -->
        <div class="search-wrapper">
            <!-- Search Input -->
            <div class="search-container" id="searchContainer">
                <div class="search-input-wrapper">
                    <i class="fas fa-search search-icon-left"></i>
                    <input type="text" class="search-input" placeholder="Search for food items..." id="searchInput"
                        autocomplete="off" />
                </div>

                <div class="search-actions">
                    <!-- Filter Button -->
                    <button class="search-action-btn filter-btn" id="filterBtn" onclick="toggleFilter()">
                        <i class="fas fa-filter"></i>
                        <span class="filter-badge" id="filterBadge">0</span>
                    </button>

                    <!-- Search Button -->
                    <button class="search-action-btn search-btn" onclick="performSearch()">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <!-- Search Dropdown (History + Filter) -->
            <div class="search-dropdown" id="searchDropdown">
                <!-- Header -->
                <div class="search-header">
                    <div class="search-title">
                        <i class="fas fa-search"></i>
                        <span id="searchTitle">Search</span>
                    </div>
                    <button class="search-clear-btn" onclick="clearAll()">Clear All</button>
                </div>

                <!-- Content -->
                <div class="search-content" id="searchContent">
                    <!-- History Section (shown by default) -->
                    <div class="search-history" id="historySection">
                        <div class="history-title">
                            <span>Recent Searches</span>
                            <button class="clear-history-btn" onclick="clearHistory()">Clear All</button>
                        </div>
                        <div class="history-list" id="historyList">
                            <!-- History items will be dynamically added here -->
                        </div>
                    </div>

                    <!-- Filter Section (hidden by default) -->
                    <div class="filter-section" id="filterSection" style="display: none;">
                        <div class="filter-title">
                            <i class="fas fa-sliders-h"></i>
                            Search Filters
                        </div>

                        <!-- Price Filter -->
                        <div class="filter-group">
                            <div class="filter-group-header">
                                <div class="filter-group-label">
                                    <i class="fas fa-tag"></i>
                                    Price Range
                                </div>
                                <div class="filter-group-value" id="priceValue">Rp 0 - 50,000</div>
                            </div>
                            <div class="price-filter">
                                <div class="price-inputs">
                                    <div class="price-input-group">
                                        <label>Min Price</label>
                                        <input type="number" class="price-input" id="minPriceInput" placeholder="0"
                                            min="0" max="100000" step="1000"
                                            onchange="updatePriceFromInput()">
                                    </div>
                                    <div class="price-separator">-</div>
                                    <div class="price-input-group">
                                        <label>Max Price</label>
                                        <input type="number" class="price-input" id="maxPriceInput"
                                            placeholder="50000" min="0" max="100000" step="1000"
                                            onchange="updatePriceFromInput()">
                                    </div>
                                </div>
                                <input type="range" class="price-slider" id="priceSlider" min="0"
                                    max="100000" step="1000" value="50000" oninput="updatePriceFromSlider()">
                                <div class="price-labels">
                                    <span>Rp 0</span>
                                    <span>Rp 25k</span>
                                    <span>Rp 50k</span>
                                    <span>Rp 75k</span>
                                    <span>Rp 100k</span>
                                </div>
                            </div>
                        </div>

                        <!-- Rating Filter -->
                        <div class="filter-group">
                            <div class="filter-group-header">
                                <div class="filter-group-label">
                                    <i class="fas fa-star"></i>
                                    Rating
                                </div>
                                <div class="filter-group-value" id="ratingValue">All</div>
                            </div>
                            <div class="rating-options">
                                <<div class="rating-option" onclick="selectRating(4, event)">
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-label">All Ratings</span>
                            </div>
                            <div class="rating-option" onclick="selectRating(4)">
                                <div class="rating-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <span class="rating-label">4.0 & above</span>
                            </div>
                            <div class="rating-option" onclick="selectRating(3)">
                                <div class="rating-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <span class="rating-label">3.0 & above</span>
                            </div>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="filter-group">
                        <div class="filter-group-header">
                            <div class="filter-group-label">
                                <i class="fas fa-utensils"></i>
                                Category
                            </div>
                            <div class="filter-group-value" id="categoryValue">All</div>
                        </div>
                        <div class="category-options">
                            <div class="category-chip" onclick="toggleCategory('bakery')">
                                <span>Bread & Bakery</span>
                            </div>
                            <div class="category-chip" onclick="toggleCategory('dairy')">
                                <span>Dairy Products</span>
                            </div>
                            <div class="category-chip" onclick="toggleCategory('fruits')">
                                <span>Fruits & Vegetables</span>
                            </div>
                            <div class="category-chip" onclick="toggleCategory('meat')">
                                <span>Meat & Fish</span>
                            </div>
                            <div class="category-chip" onclick="toggleCategory('ready')">
                                <span>Ready to Eat</span>
                            </div>
                        </div>
                    </div>

                    <!-- Active Filters -->
                    <div class="active-filters" id="activeFilters">
                        <!-- Active filter tags will be added here -->
                    </div>
                </div>
            </div>
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

    <!-- ========== SEARCH RESULTS CONTAINER ========== -->
    <div class="search-results-container" id="searchResultsContainer">
        <div class="search-results-header">
            <div>
                <span class="results-title">Search Results</span>
                <span class="results-count" id="resultsCount">(0 items)</span>
                <div class="results-summary" id="resultsSummary">No filters applied</div>
            </div>
            <button class="close-results-btn" onclick="closeResults()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="search-results-grid" id="searchResultsGrid">
            <!-- Search results will be dynamically added here -->
        </div>
    </div>

    <!-- ========== MAIN CONTENT ========== -->
    <main>
        @yield('content')
    </main>

    <!-- ========== NOTIFICATION ========== -->
    <div class="notification" id="notification">
        <i class="fas fa-check-circle"></i>
        <span id="notificationMessage">Product added to cart!</span>
    </div>

    <!-- ========== FOOTER SECTION ========== -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <!-- Column 1: Brand & Social -->
                <div class="footer-column">
                    <div class="footer-brand">
                        <img src="{{ asset('images/LOGO LASTBITE.png') }}" alt="LastBite Logo" class="footer-logo">
                        <p class="footer-description">
                            LastBite is your trusted platform to reduce food waste and save money.
                            We connect you with quality food at amazing prices before it goes to waste.
                        </p>
                    </div>
                    <div class="footer-social">
                        <a href="https://facebook.com" target="_blank" class="social-icon" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://instagram.com" target="_blank" class="social-icon" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://twitter.com" target="_blank" class="social-icon" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://linkedin.com" target="_blank" class="social-icon" title="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://youtube.com" target="_blank" class="social-icon" title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div class="footer-column">
                    <h3 class="footer-title">Quick Links</h3>
                    <div class="footer-links">
                        <a href="{{ route('dashboard') }}" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            Home
                        </a>
                        <a href="#" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            About Us
                        </a>
                        <a href="#" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            How It Works
                        </a>
                        <a href="{{ route('cart.index') }}" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            Shopping Cart
                        </a>
                        <a href="{{ route('favorites') }}" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            Favorites
                        </a>
                    </div>
                </div>

                <!-- Column 3: Support -->
                <div class="footer-column">
                    <h3 class="footer-title">Support</h3>
                    <div class="footer-links">
                        <a href="#" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            Help Center
                        </a>
                        <a href="#" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            FAQs
                        </a>
                        <a href="#" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            Terms & Conditions
                        </a>
                        <a href="#" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            Privacy Policy
                        </a>
                        <a href="#" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            Contact Us
                        </a>
                    </div>
                </div>

                <!-- Column 4: Contact Info -->
                <div class="footer-column">
                    <h3 class="footer-title">Contact Us</h3>
                    <div class="footer-contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-text">
                            <strong>Address</strong>
                            Jl. Raya Darmo No. 123<br>
                            Surabaya, East Java 60241
                        </div>
                    </div>
                    <div class="footer-contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="contact-text">
                            <strong>Phone</strong>
                            +62 812-3456-7890
                        </div>
                    </div>
                    <div class="footer-contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-text">
                            <strong>Email</strong>
                            support@lastbite.com
                        </div>
                    </div>
                </div>

                <!-- Column 5: Newsletter & Apps -->
                <div class="footer-column">
                    <h3 class="footer-title">Stay Updated</h3>
                    <div class="footer-newsletter">
                        <p class="newsletter-text">
                            Subscribe to our newsletter for special offers and updates!
                        </p>
                        <form class="newsletter-form" onsubmit="handleNewsletterSubmit(event)">
                            <input type="email" class="newsletter-input" placeholder="Your email address"
                                id="newsletterEmail" required>
                            <button type="submit" class="newsletter-btn">
                                Subscribe
                            </button>
                        </form>
                    </div>

                    <h4 class="footer-title" style="margin-top: 25px;">Download App</h4>
                    <div class="footer-apps">
                        <a href="#" class="app-button">
                            <i class="fab fa-apple app-icon"></i>
                            <div class="app-text">
                                <small>Download on the</small>
                                <strong>App Store</strong>
                            </div>
                        </a>
                        <a href="#" class="app-button">
                            <i class="fab fa-google-play app-icon"></i>
                            <div class="app-text">
                                <small>Get it on</small>
                                <strong>Google Play</strong>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="footer-copyright">
                    &copy; 2024 <a href="{{ route('dashboard') }}">LastBite</a>. All rights reserved.
                    Made with <i class="fas fa-heart" style="color: var(--danger-color);"></i> to reduce food waste.
                </div>

                <div class="footer-bottom-links">
                    <a href="#" class="footer-bottom-link">Privacy Policy</a>
                    <a href="#" class="footer-bottom-link">Terms of Service</a>
                    <a href="#" class="footer-bottom-link">Cookie Policy</a>
                    <a href="#" class="footer-bottom-link">Sitemap</a>
                </div>

                <div class="footer-payment">
                    <span style="color: rgba(255, 255, 255, 0.7); font-size: 13px; margin-right: 10px;">
                        We Accept:
                    </span>
                    <div class="payment-icon" title="Visa">
                        <i class="fab fa-cc-visa"></i>
                    </div>
                    <div class="payment-icon" title="Mastercard">
                        <i class="fab fa-cc-mastercard"></i>
                    </div>
                    <div class="payment-icon" title="PayPal">
                        <i class="fab fa-cc-paypal"></i>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop" onclick="scrollToTop()">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- ========== JAVASCRIPT DEPENDENCIES ========== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- ========== JAVASCRIPT CODE ========== -->
    <script>
        // ========== SEARCH & FILTER STATE ==========
        let searchState = {
            query: '',
            filters: {
                price: {
                    min: 0,
                    max: 50000
                },
                rating: 0,
                categories: []
            },
            activeFilters: 0
        };

        // ========== SEARCH HISTORY MANAGEMENT ==========
        function saveToHistory(query) {
            if (!query.trim()) return;

            let history = JSON.parse(localStorage.getItem('lastbite_search_history') || '[]');

            // Remove if already exists
            history = history.filter(item => item.query !== query);

            // Add to beginning
            history.unshift({
                query: query,
                timestamp: new Date().toISOString(),
                timeText: 'Just now'
            });

            // Keep only last 10 items
            history = history.slice(0, 10);

            localStorage.setItem('lastbite_search_history', JSON.stringify(history));
            updateHistoryDisplay();
        }

        function updateHistoryDisplay() {
            const historyList = document.getElementById('historyList');
            if (!historyList) return;

            const history = JSON.parse(localStorage.getItem('lastbite_search_history') || '[]');

            if (history.length === 0) {
                historyList.innerHTML =
                    '<div class="no-history" style="text-align: center; padding: 20px; color: var(--text-light);">No recent searches</div>';
                return;
            }

            // Update time text for each item
            history.forEach(item => {
                const now = new Date();
                const searchTime = new Date(item.timestamp);
                const diffMinutes = Math.floor((now - searchTime) / (1000 * 60));

                if (diffMinutes < 1) item.timeText = 'Just now';
                else if (diffMinutes < 60) item.timeText = `${diffMinutes}m ago`;
                else if (diffMinutes < 1440) item.timeText = `${Math.floor(diffMinutes / 60)}h ago`;
                else item.timeText = `${Math.floor(diffMinutes / 1440)}d ago`;
            });

            historyList.innerHTML = history.map(item => `
            <div class="history-item" onclick="searchFromHistory('${item.query.replace(/'/g, "\\'")}')">
                <div class="history-text">${item.query}</div>
                <div class="history-time">${item.timeText}</div>
            </div>
        `).join('');
        }

        function searchFromHistory(query) {
            document.getElementById('searchInput').value = query;
            performSearch();
            hideSearchDropdown();
        }

        function clearHistory() {
            localStorage.removeItem('lastbite_search_history');
            updateHistoryDisplay();
            showNotification('Search history cleared', 'info');
        }

        // ========== FILTER FUNCTIONS ==========
        function toggleFilter() {
            const filterSection = document.getElementById('filterSection');
            const historySection = document.getElementById('historySection');
            const searchTitle = document.getElementById('searchTitle');

            if (filterSection.style.display === 'none') {
                filterSection.style.display = 'block';
                historySection.style.display = 'none';
                searchTitle.textContent = 'Filters';
                updateFilterBadge();
            } else {
                filterSection.style.display = 'none';
                historySection.style.display = 'block';
                searchTitle.textContent = 'Search';
            }
        }

        function selectRating(rating) {
            document.querySelectorAll('.rating-option').forEach(opt => {
                opt.classList.remove('selected');
            });
            event.target.closest('.rating-option').classList.add('selected');

            searchState.filters.rating = rating;
            updateActiveFilters();
        }

        function toggleCategory(category) {
            const chip = event.target.closest('.category-chip');
            chip.classList.toggle('selected');

            if (chip.classList.contains('selected')) {
                if (!searchState.filters.categories.includes(category)) {
                    searchState.filters.categories.push(category);
                }
            } else {
                searchState.filters.categories = searchState.filters.categories.filter(c => c !== category);
            }

            updateActiveFilters();
        }

        function updatePriceFromSlider() {
            const slider = document.getElementById('priceSlider');
            const maxPriceInput = document.getElementById('maxPriceInput');
            const priceValue = document.getElementById('priceValue');

            const maxPrice = parseInt(slider.value);
            searchState.filters.price.max = maxPrice;
            maxPriceInput.value = maxPrice;

            priceValue.textContent = `Rp 0 - ${maxPrice.toLocaleString()}`;
            updateActiveFilters();
        }

        function updatePriceFromInput() {
            const minPriceInput = document.getElementById('minPriceInput');
            const maxPriceInput = document.getElementById('maxPriceInput');
            const priceSlider = document.getElementById('priceSlider');
            const priceValue = document.getElementById('priceValue');

            let minPrice = parseInt(minPriceInput.value) || 0;
            let maxPrice = parseInt(maxPriceInput.value) || 50000;

            // Validasi
            if (minPrice < 0) minPrice = 0;
            if (maxPrice > 100000) maxPrice = 100000;
            if (minPrice > maxPrice) minPrice = maxPrice - 1000;
            if (maxPrice < minPrice) maxPrice = minPrice + 1000;

            searchState.filters.price.min = minPrice;
            searchState.filters.price.max = maxPrice;

            minPriceInput.value = minPrice;
            maxPriceInput.value = maxPrice;
            priceSlider.value = maxPrice;

            priceValue.textContent = `Rp ${minPrice.toLocaleString()} - ${maxPrice.toLocaleString()}`;
            updateActiveFilters();
        }

        function updateActiveFilters() {
            let activeCount = 0;

            // Count active filters
            if (searchState.filters.rating > 0) activeCount++;
            if (searchState.filters.categories.length > 0) activeCount++;
            if (searchState.filters.price.min > 0 || searchState.filters.price.max < 50000) activeCount++;

            searchState.activeFilters = activeCount;

            // Update filter badge
            const filterBadge = document.getElementById('filterBadge');
            if (filterBadge) {
                filterBadge.textContent = activeCount;
                filterBadge.style.display = activeCount > 0 ? 'inline-block' : 'none';
            }
        }

        function updateFilterBadge() {
            updateActiveFilters(); // Just alias for consistency
        }

        function clearRatingFilter() {
            searchState.filters.rating = 0;
            document.querySelectorAll('.rating-option').forEach(opt => {
                opt.classList.remove('selected');
            });
            document.querySelector('.rating-option[onclick="selectRating(0)"]').classList.add('selected');
            updateActiveFilters();
        }

        function clearCategoryFilter() {
            searchState.filters.categories = [];
            document.querySelectorAll('.category-chip').forEach(chip => {
                chip.classList.remove('selected');
            });
            updateActiveFilters();
        }

        function clearPriceFilter() {
            searchState.filters.price = {
                min: 0,
                max: 50000
            };
            document.getElementById('minPriceInput').value = '';
            document.getElementById('maxPriceInput').value = '50000';
            document.getElementById('priceSlider').value = '50000';
            document.getElementById('priceValue').textContent = 'Rp 0 - 50,000';
            updateActiveFilters();
        }

        function clearAll() {
            clearRatingFilter();
            clearCategoryFilter();
            clearPriceFilter();
            showNotification('All filters cleared', 'info');
        }

        // ========== SEARCH FUNCTIONS ==========
        function performSearch() {
            const query = document.getElementById('searchInput').value.trim();

            if (!query) {
                showNotification('Please enter a search keyword', 'warning');
                // Show search dropdown if empty
                showSearchDropdown();
                return;
            }

            searchState.query = query;
            saveToHistory(query);
            hideSearchDropdown();
            showSearchResults();

            // Fetch real data from your server
            fetchSearchResults(query);
        }

        // ========== FETCH REAL PRODUCT DATA ==========
        async function fetchSearchResults(query) {
            const resultsGrid = document.getElementById('searchResultsGrid');
            const resultsCount = document.getElementById('resultsCount');
            const resultsSummary = document.getElementById('resultsSummary');

            // Show loading state
            resultsGrid.innerHTML = `
        <div class="loading-results">
            <div class="loading-spinner"></div>
            <div class="loading-text">Searching for "${query}"...</div>
        </div>
    `;

            try {
                // Build query parameters - GUNAKAN INI
                const params = new URLSearchParams({
                    q: query,
                    min_price: searchState.filters.price.min,
                    max_price: searchState.filters.price.max,
                    min_rating: searchState.filters.rating,
                    categories: searchState.filters.categories.join(',')
                });

                // ENDPOINT YANG HARUS DIGUNAKAN:
                const endpoint = `/api/products/search?${params}`;

                console.log('Fetching from:', endpoint); // Debug log

                const response = await fetch(endpoint, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                console.log('API Response:', result); // Debug log

                if (result.success) {
                    let products = [];

                    // Handle response structure
                    if (result.data && result.data.products) {
                        products = result.data.products;
                    } else if (result.data && Array.isArray(result.data)) {
                        products = result.data;
                    } else if (Array.isArray(result.data)) {
                        products = result.data;
                    } else if (result.products) {
                        products = result.products;
                    }

                    console.log('Products found:', products.length); // Debug log

                    if (products.length === 0) {
                        // Try fallback search
                        simulateSearchFallback(query);
                    } else {
                        displaySearchResults(products, query);
                    }
                } else {
                    // If API returns error, use fallback
                    console.error('API Error:', result.message);
                    simulateSearchFallback(query);
                }

            } catch (error) {
                console.error('Error fetching search results:', error);
                // Use fallback for testing
                simulateSearchFallback(query);
            }
        }

        // ========== DISPLAY SEARCH RESULTS (DASHBOARD STYLE) ==========
        function displaySearchResults(products, query) {
            const resultsGrid = document.getElementById('searchResultsGrid');
            const resultsCount = document.getElementById('resultsCount');
            const resultsSummary = document.getElementById('resultsSummary');

            // Update results count
            const itemText = products.length === 1 ? 'item' : 'items';
            resultsCount.textContent = `(${products.length} ${itemText})`;

            // Update summary
            let summary = `Results for "${query}"`;
            if (searchState.activeFilters > 0) {
                summary += ` with ${searchState.activeFilters} filter${searchState.activeFilters > 1 ? 's' : ''}`;
            }
            resultsSummary.textContent = summary;

            // Display results
            if (products.length === 0) {
                resultsGrid.innerHTML = createNoResultsTemplate(query);
            } else {
                resultsGrid.innerHTML = createProductsGridTemplate(products, query);
            }
        }

        // ========== TEMPLATE: NO RESULTS ==========
        function createNoResultsTemplate(query) {
            return `
        <div class="no-search-results" style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
            <div class="no-results-icon" style="font-size: 80px; color: var(--text-light); margin-bottom: 20px;">
                <i class="fas fa-search"></i>
            </div>
            <h2 class="no-results-title" style="font-size: 28px; color: var(--primary-color); margin-bottom: 15px; font-weight: 600;">
                No products found for "${query}"
            </h2>
            <p class="no-results-text" style="color: var(--text-light); margin-bottom: 30px; max-width: 600px; margin-left: auto; margin-right: auto;">
                Try adjusting your search or filter to find what you're looking for.
            </p>
            <button class="try-again-btn" onclick="clearAllFilters()"
                style="background: var(--primary-color); color: var(--white); border: none; padding: 12px 30px; border-radius: 25px; font-size: 15px; font-weight: 600; cursor: pointer; transition: var(--transition); margin-bottom: 40px;">
                Clear All Filters
            </button>

            <!-- Recommended Products Section -->
            <div class="recommended-section" style="margin-top: 60px; padding-top: 40px; border-top: 1px solid rgba(63, 35, 5, 0.1);">
                <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px;">
                    <div class="section-title" style="display: flex; align-items: center; gap: 15px;">
                        <i class="fas fa-star star-icon" style="color: #FF9F1C; font-size: 32px;"></i>
                        <h2 style="font-size: 28px; font-weight: 700; color: var(--primary-color); margin: 0;">
                            Recommended Products
                        </h2>
                    </div>
                </div>

                <div class="recommended-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto;">
                    ${generateRecommendedProducts()}
                </div>
            </div>
        </div>
    `;
        }

        // ========== TEMPLATE: PRODUCTS GRID (DASHBOARD STYLE) ==========
        function createProductsGridTemplate(products, query) {
            return `
        <div style="grid-column: 1 / -1; width: 100%;">
            <!-- Search Results Grid -->
            <div class="search-results-display" style="margin-bottom: 60px;">
                <div class="products-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; margin-bottom: 50px;">
                    ${products.map(product => createProductCardTemplate(product)).join('')}
                </div>
            </div>

            <!-- Recommended Products Section -->
            <div class="recommended-section" style="margin-top: 40px; padding-top: 40px; border-top: 1px solid rgba(63, 35, 5, 0.1);">
                <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px;">
                    <div class="section-title" style="display: flex; align-items: center; gap: 15px;">
                        <i class="fas fa-star star-icon" style="color: #FF9F1C; font-size: 32px;"></i>
                        <h2 style="font-size: 28px; font-weight: 700; color: var(--primary-color); margin: 0;">
                            You Might Also Like
                        </h2>
                    </div>
                </div>

                <div class="recommended-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto;">
                    ${generateRecommendedProducts()}
                </div>
            </div>
        </div>
    `;
        }

        // ========== TEMPLATE: PRODUCT CARD (DASHBOARD STYLE) ==========
        function createProductCardTemplate(product) {
            const badge = getExpiryBadge(product.expiry_date);
            const badgeClass = badge === 'Expiring Today' ? 'flash-badge' : 'recommended-badge';

            return `
        <div class="product-card" style="width: 100%; max-width: 280px; background: var(--white); border-radius: 15px; overflow: hidden; box-shadow: var(--shadow-light); transition: var(--transition); position: relative; display: flex; flex-direction: column; margin: 0 auto; cursor: pointer;"
            onclick="viewProductDetail(${product.id})">
            <span class="${badgeClass}"
                  style="position: absolute; top: 15px; left: 15px; background: ${badge === 'Expiring Today' ? 'var(--danger-color)' : 'var(--success-color)'}; color: var(--white); padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 700; z-index: 2; text-transform: uppercase; letter-spacing: 1px;">
                ${badge}
            </span>

            <div class="product-image-container" style="position: relative; width: 100%; height: 200px; overflow: hidden;">
                <img src="${product.image_url || getDefaultImageByCategory(product.category)}"
                     alt="${product.name}"
                     class="product-image"
                     style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;"
                     onerror="this.src='${getDefaultImageByCategory(product.category)}'">
            </div>

            <div class="product-info" style="padding: 20px; flex-grow: 1; display: flex; flex-direction: column; text-align: left;">
                <div class="product-brand" style="font-size: 12px; color: var(--text-light); font-weight: 500; margin-bottom: 8px; display: flex; align-items: center; gap: 5px;">
                    <i class="fas fa-store"></i>
                    ${product.brand || 'LastBite'}
                </div>

                <h3 class="product-name" style="font-size: 16px; font-weight: 600; color: var(--text-dark); margin-bottom: 10px; line-height: 1.3; height: 42px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                    ${product.name}
                </h3>

                <span class="product-category" style="display: inline-block; background: rgba(63, 35, 5, 0.08); color: var(--primary-color); padding: 4px 12px; border-radius: 15px; font-size: 11px; font-weight: 600; margin-bottom: 12px; align-self: flex-start;">
                    ${getCategoryName(product.category)}
                </span>

                <div class="product-rating" style="display: flex; align-items: center; gap: 8px; margin-bottom: 15px;">
                    <div class="stars" style="color: #FFC107; font-size: 14px;">
                        ${getStarRating(product.rating || 4.5)}
                    </div>
                    <span class="rating-count" style="font-size: 12px; color: var(--text-light); font-weight: 500;">
                        (${product.rating_count || 10})
                    </span>
                </div>

                <div class="product-price" style="display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 15px; border-top: 1px solid rgba(0, 0, 0, 0.08);">
                    <div class="price-container" style="display: flex; flex-direction: column; gap: 2px;">
                        <span class="current-price" style="font-size: 20px; font-weight: 700; color: var(--danger-color);">
                            Rp ${parseInt(product.price || 0).toLocaleString()}
                        </span>
                        ${product.original_price && product.original_price > product.price ? `
                                                    <div>
                                                        <span class="original-price" style="font-size: 14px; color: var(--text-light); text-decoration: line-through;">
                                                            Rp ${parseInt(product.original_price).toLocaleString()}
                                                        </span>
                                                        <span class="discount-percent" style="font-size: 12px; color: var(--success-color); font-weight: 600; margin-left: 5px;">
                                                            -${calculateDiscountPercent(product.price, product.original_price)}%
                                                        </span>
                                                    </div>
                                                ` : ''}
                    </div>

                    <button class="add-to-cart-btn"
                            onclick="addToCart(${product.id}, '${product.name.replace(/'/g, "\\'")}', ${parseInt(product.price)}, '${product.image_url || ''}', '${product.brand || 'LastBite'}', '${product.category || 'General'}', ${product.rating || 4.5}, ${product.rating_count || 10}); event.stopPropagation()"
                            style="width: 44px; height: 44px; background: var(--primary-color); color: var(--white); border: none; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: var(--transition); flex-shrink: 0;">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
        }

        // ========== GENERATE RECOMMENDED PRODUCTS ==========
        function generateRecommendedProducts() {
            // Sample recommended products (similar to dashboard)
            const recommendedProducts = [{
                    id: 101,
                    name: 'Artisan Sourdough Bread',
                    brand: 'BreadTalk',
                    category: 'bakery',
                    price: 25000,
                    original_price: 45000,
                    rating: 4.7,
                    rating_count: 128,
                    image_url: 'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    expiry_date: new Date(Date.now() + 86400000).toISOString() // Tomorrow
                },
                {
                    id: 102,
                    name: 'Fresh Milk 1L',
                    brand: 'Greenfields',
                    category: 'dairy',
                    price: 18000,
                    original_price: 28000,
                    rating: 4.5,
                    rating_count: 76,
                    image_url: 'https://images.unsplash.com/photo-1563636619-e9143da7973b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    expiry_date: new Date(Date.now() + 2 * 86400000).toISOString() // 2 days
                },
                {
                    id: 103,
                    name: 'Organic Apples (1kg)',
                    brand: 'Fresh Market',
                    category: 'fruits',
                    price: 35000,
                    original_price: 45000,
                    rating: 4.9,
                    rating_count: 210,
                    image_url: 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    expiry_date: new Date(Date.now() + 3 * 86400000).toISOString() // 3 days
                },
                {
                    id: 104,
                    name: 'Premium Beef Steak (300g)',
                    brand: 'Meat Master',
                    category: 'meat',
                    price: 65000,
                    original_price: 85000,
                    rating: 4.8,
                    rating_count: 167,
                    image_url: 'https://images.unsplash.com/photo-1604503468505-1d2d6a9a6c8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    expiry_date: new Date(Date.now() + 86400000).toISOString() // Tomorrow
                }
            ];

            return recommendedProducts.map(product => createProductCardTemplate(product)).join('');
        }

        // ========== HELPER FUNCTIONS ==========
        function calculateDiscountPercent(currentPrice, originalPrice) {
            if (!originalPrice || originalPrice <= currentPrice) return 0;
            const discount = ((originalPrice - currentPrice) / originalPrice) * 100;
            return Math.round(discount);
        }

        function viewProductDetail(productId) {
            // Redirect to product detail page
            window.location.href = `/product/${productId}`;
        }

        async function fetchSearchResults(query) {
            const resultsGrid = document.getElementById('searchResultsGrid');
            const resultsCount = document.getElementById('resultsCount');
            const resultsSummary = document.getElementById('resultsSummary');

            // Show loading state
            resultsGrid.innerHTML = `
        <div class="loading-results" style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
            <div class="loading-spinner" style="width: 40px; height: 40px; border: 3px solid rgba(63, 35, 5, 0.1); border-top-color: var(--primary-color); border-radius: 50%; margin: 0 auto 20px; animation: spin 1s linear infinite;"></div>
            <div class="loading-text" style="color: var(--text-light);">Searching for "${query}"...</div>
        </div>
    `;

            try {
                // Build query parameters
                const params = new URLSearchParams({
                    q: query,
                    min_price: searchState.filters.price.min,
                    max_price: searchState.filters.price.max,
                    min_rating: searchState.filters.rating,
                    categories: searchState.filters.categories.join(',')
                });

                // Use the API endpoint
                const endpoint = `/api/products/search?${params}`;

                console.log('Search API call to:', endpoint);

                const response = await fetch(endpoint, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                console.log('API Response:', result);

                if (result.success && result.data) {
                    const products = result.data.products || [];
                    console.log(`${products.length} products found`);

                    // Debug: Log product names for verification
                    products.forEach((p, i) => {
                        console.log(`${i + 1}. ${p.name} (${p.category}) - Rp${p.price}`);
                    });

                    displaySearchResults(products, query);

                    // Jika tidak ada hasil, coba ambil dari dashboard data
                    if (products.length === 0) {
                        console.log('No API results, trying dashboard data...');
                        getProductsFromDashboard(query);
                    }
                } else {
                    console.log('API returned error, trying dashboard data...');
                    getProductsFromDashboard(query);
                }

            } catch (error) {
                console.error('Error fetching search results:', error);
                console.log('Using dashboard data as fallback...');
                getProductsFromDashboard(query);
            }
        }

        // ========== AMBIL DATA DARI DASHBOARD ==========
        async function getProductsFromDashboard(query) {
            try {
                console.log('Attempting to fetch from dashboard endpoint...');

                // Coba ambil dari endpoint dashboard
                const response = await fetch('/api/dashboard/products', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.ok) {
                    const result = await response.json();
                    console.log('Dashboard data:', result);

                    if (result.success && result.data) {
                        const allProducts = [
                            ...(result.data.flash_sale || []),
                            ...(result.data.recommended || []),
                            ...(result.data.categories || []).flatMap(cat => cat.products || [])
                        ];

                        // Filter products based on search query
                        const filteredProducts = filterProductsFromDashboard(allProducts, query);
                        console.log(`Found ${filteredProducts.length} products from dashboard data`);

                        displaySearchResults(filteredProducts, query);
                        return;
                    }
                }

                // Jika semua gagal, gunakan data dummy dari dashboard
                console.log('Using hardcoded dashboard data...');
                useHardcodedDashboardData(query);

            } catch (error) {
                console.error('Error getting dashboard data:', error);
                useHardcodedDashboardData(query);
            }
        }

        function filterProductsFromDashboard(products, query) {
            if (!query) return products;

            const searchLower = query.toLowerCase();

            return products.filter(product => {
                if (!product || !product.name) return false;

                // Check in multiple fields
                const nameMatch = product.name.toLowerCase().includes(searchLower);
                const descriptionMatch = product.description && product.description.toLowerCase().includes(
                    searchLower);
                const categoryMatch = product.category && product.category.toLowerCase().includes(searchLower);
                const brandMatch = product.brand && product.brand.toLowerCase().includes(searchLower);

                // Also check individual words
                const searchWords = searchLower.split(' ').filter(word => word.length > 2);
                let wordMatch = false;

                if (searchWords.length > 0) {
                    const productText =
                        `${product.name} ${product.description || ''} ${product.category || ''} ${product.brand || ''}`
                        .toLowerCase();
                    wordMatch = searchWords.some(word => productText.includes(word));
                }

                return nameMatch || descriptionMatch || categoryMatch || brandMatch || wordMatch;
            });
        }

        function useHardcodedDashboardData(query) {
            // Data produk dari dashboard JavaScript
            const dashboardProducts = [
                // Flash Sale Products
                {
                    id: 1,
                    name: 'Artisan Sourdough Bread',
                    brand: 'BreadTalk',
                    category: 'bakery',
                    price: 25000,
                    original_price: 45000,
                    discount_percent: 44,
                    rating: 4.7,
                    rating_count: 128,
                    image_url: 'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    is_flash_sale: true,
                    description: 'Freshly baked artisan sourdough bread'
                },
                {
                    id: 2,
                    name: 'French Croissants (Pack of 4)',
                    brand: 'Holland Bakery',
                    category: 'bakery',
                    price: 32000,
                    original_price: 55000,
                    discount_percent: 42,
                    rating: 4.8,
                    rating_count: 95,
                    image_url: 'https://images.unsplash.com/photo-1555507036-ab794f27d2e9?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    is_flash_sale: true,
                    description: 'Buttery French croissants'
                },
                {
                    id: 3,
                    name: 'Fresh Milk 1L',
                    brand: 'Greenfields',
                    category: 'dairy',
                    price: 18000,
                    original_price: 28000,
                    discount_percent: 36,
                    rating: 4.5,
                    rating_count: 76,
                    image_url: 'https://images.unsplash.com/photo-1563636619-e9143da7973b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    is_flash_sale: true,
                    description: 'Fresh cow milk'
                },
                {
                    id: 4,
                    name: 'Greek Yogurt (500g)',
                    brand: 'Yoplait',
                    category: 'dairy',
                    price: 22000,
                    original_price: 35000,
                    discount_percent: 37,
                    rating: 4.6,
                    rating_count: 89,
                    image_url: 'https://images.unsplash.com/photo-1567306300913-3def25b4c99b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    is_flash_sale: true,
                    description: 'Greek style yogurt'
                },

                // Recommended Products
                {
                    id: 5,
                    name: 'Organic Apples (1kg)',
                    brand: 'Fresh Market',
                    category: 'fruits',
                    price: 35000,
                    original_price: 45000,
                    discount_percent: 22,
                    rating: 4.9,
                    rating_count: 210,
                    image_url: 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    is_flash_sale: false,
                    description: 'Fresh organic apples'
                },
                {
                    id: 6,
                    name: 'Premium Beef Steak (300g)',
                    brand: 'Meat Master',
                    category: 'meat',
                    price: 65000,
                    original_price: 85000,
                    discount_percent: 24,
                    rating: 4.8,
                    rating_count: 167,
                    image_url: 'https://images.unsplash.com/photo-1604503468505-1d2d6a9a6c8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    is_flash_sale: false,
                    description: 'Premium quality beef steak'
                },
                {
                    id: 7,
                    name: 'Chocolate Chip Cookies (Pack of 6)',
                    brand: 'Mrs. Fields',
                    category: 'bakery',
                    price: 28000,
                    original_price: 40000,
                    discount_percent: 30,
                    rating: 4.7,
                    rating_count: 142,
                    image_url: 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    is_flash_sale: false,
                    description: 'Chocolate chip cookies'
                },
                {
                    id: 8,
                    name: 'Fresh Orange Juice (1L)',
                    brand: 'Tropicana',
                    category: 'fruits',
                    price: 32000,
                    original_price: 42000,
                    discount_percent: 24,
                    rating: 4.6,
                    rating_count: 98,
                    image_url: 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    is_flash_sale: false,
                    description: 'Fresh orange juice'
                }
            ];

            const filtered = filterProductsFromDashboard(dashboardProducts, query);
            console.log(`Found ${filtered.length} products from hardcoded data`);

            displaySearchResults(filtered, query);
        }

        // ========== HELPER FUNCTIONS ==========
        function getCategoryName(category) {
            const categories = {
                'bakery': 'Bakery & Bread',
                'dairy': 'Dairy Products',
                'fruits': 'Fruits & Vegetables',
                'meat': 'Meat & Fish',
                'ready': 'Ready to Eat',
                'bakery & bread': 'Bakery & Bread',
                'dairy & beverages': 'Dairy Products',
                'fruits & vegetables': 'Fruits & Vegetables',
                'meat & fish': 'Meat & Fish',
                'eggs & dairy products': 'Dairy Products'
            };
            return categories[category?.toLowerCase()] || category || 'General';
        }

        function getStarRating(rating) {
            let stars = '';
            const fullStars = Math.floor(rating);
            const hasHalfStar = rating % 1 >= 0.5;

            for (let i = 0; i < 5; i++) {
                if (i < fullStars) {
                    stars += '<i class="fas fa-star"></i>';
                } else if (i === fullStars && hasHalfStar) {
                    stars += '<i class="fas fa-star-half-alt"></i>';
                } else {
                    stars += '<i class="far fa-star"></i>';
                }
            }
            return stars;
        }

        function getExpiryBadge(expiryDate) {
            if (!expiryDate) return 'Fresh';

            const today = new Date();
            const expiry = new Date(expiryDate);
            const diffTime = expiry - today;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays <= 0) return 'Expiring Today';
            if (diffDays <= 1) return 'Expiring Tomorrow';
            if (diffDays <= 3) return 'Expiring Soon';
            return 'Fresh';
        }

        function formatExpiryDate(expiryDate) {
            if (!expiryDate) return 'Soon';

            const date = new Date(expiryDate);
            const today = new Date();
            const diffTime = date - today;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays <= 0) return 'Today';
            if (diffDays === 1) return 'Tomorrow';
            if (diffDays <= 7) return `${diffDays} days`;

            // Format as readable date
            return date.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric'
            });
        }

        function clearAllFilters() {
            clearAll();
            // Re-run search with current query
            if (searchState.query) {
                performSearch();
            }
        }

        // ========== UI CONTROL FUNCTIONS ==========
        function showSearchDropdown() {
            const searchDropdown = document.getElementById('searchDropdown');
            if (searchDropdown) {
                searchDropdown.classList.add('show');
            }
        }

        function hideSearchDropdown() {
            const searchDropdown = document.getElementById('searchDropdown');
            if (searchDropdown) {
                searchDropdown.classList.remove('show');
            }
        }

        function showSearchResults() {
            const searchResultsContainer = document.getElementById('searchResultsContainer');
            if (searchResultsContainer) {
                searchResultsContainer.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeResults() {
            const searchResultsContainer = document.getElementById('searchResultsContainer');
            if (searchResultsContainer) {
                searchResultsContainer.classList.remove('show');
                document.body.style.overflow = '';
            }
        }

        // ========== EVENT LISTENERS ==========
        document.addEventListener('DOMContentLoaded', function() {
            // Search input events
            const searchInput = document.getElementById('searchInput');

            if (searchInput) {
                searchInput.addEventListener('focus', function() {
                    showSearchDropdown();
                    updateHistoryDisplay();
                });

                searchInput.addEventListener('input', function() {
                    // Could add live search suggestions here
                    if (this.value.trim()) {
                        // For future: show search suggestions
                    }
                });

                // Enter key for search
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        performSearch();
                    }
                });
            }

            // Click outside to close dropdown
            document.addEventListener('click', function(event) {
                const searchWrapper = document.querySelector('.search-wrapper');
                const searchDropdown = document.getElementById('searchDropdown');

                if (searchWrapper && searchDropdown &&
                    !searchWrapper.contains(event.target) &&
                    searchDropdown.classList.contains('show')) {
                    hideSearchDropdown();
                }
            });

            // Initialize
            updateHistoryDisplay();
            updateActiveFilters();

            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.getElementById('navbarContainer');
                if (navbar) {
                    navbar.classList.toggle('navbar-scrolled', window.scrollY > 50);
                }
            });

            // Initialize price inputs
            const minPriceInput = document.getElementById('minPriceInput');
            const maxPriceInput = document.getElementById('maxPriceInput');
            if (minPriceInput) minPriceInput.value = '';
            if (maxPriceInput) maxPriceInput.value = '50000';

            console.log('Search system initialized successfully');
        });

        // ========== SHARED FUNCTIONS ==========
        function showNotification(message, type = 'success') {
            const notification = document.getElementById('notification');
            if (!notification) return;

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
            }, 3000);
        }

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

        window.addToCart = function(productId, productName, price, productImageUrl = '', productBrand = '',
            productCategory = '', productRating = 4.5, productRatingCount = 10) {
            try {
                let cart = JSON.parse(localStorage.getItem('lastbite_cart') || '[]');
                const existingItem = cart.find(item => item.id === productId);

                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    let imageUrl = productImageUrl;
                    if (!imageUrl) {
                        imageUrl = getDefaultImageByCategory(productCategory);
                    }

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
                        image_url: imageUrl,
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
                return true;
            } catch (error) {
                console.error('Error adding to cart:', error);
                showNotification('Failed to add item to cart', 'error');
                return false;
            }
        };

        function getDefaultImageByCategory(category) {
            const defaultImages = {
                'bakery': 'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'dairy': 'https://images.unsplash.com/photo-1563636619-e9143da7973b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'fruits': 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'fruit': 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'meat': 'https://images.unsplash.com/photo-1604503468505-1d2d6a9a6c8f?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'vegetable': 'https://images.unsplash.com/photo-1540420773420-3366772f4999?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'
            };

            return defaultImages[category?.toLowerCase()] ||
                'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80';
        }

        // Initialize cart count on load
        updateCartCount();
        setInterval(updateCartCount, 2000);

        // ========== FOOTER JAVASCRIPT ==========

        // Newsletter Subscription
        function handleNewsletterSubmit(event) {
            event.preventDefault();

            const emailInput = document.getElementById('newsletterEmail');
            const email = emailInput.value.trim();

            if (!email) {
                showNotification('Please enter your email address', 'warning');
                return;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showNotification('Please enter a valid email address', 'error');
                return;
            }

            // Simulate API call
            showNotification('Processing...', 'info');

            setTimeout(() => {
                // Here you would normally send to your backend
                try {
                    // Store in localStorage (for demo purposes)
                    let subscribers = JSON.parse(localStorage.getItem('lastbite_subscribers') || '[]');

                    if (subscribers.includes(email)) {
                        showNotification('This email is already subscribed!', 'warning');
                        return;
                    }

                    subscribers.push(email);
                    localStorage.setItem('lastbite_subscribers', JSON.stringify(subscribers));

                    showNotification('Thank you for subscribing! 🎉', 'success');
                    emailInput.value = '';

                    // Optional: Send to backend
                    // fetch('/api/newsletter/subscribe', {
                    //     method: 'POST',
                    //     headers: { 'Content-Type': 'application/json' },
                    //     body: JSON.stringify({ email: email })
                    // });

                } catch (error) {
                    console.error('Newsletter subscription error:', error);
                    showNotification('Something went wrong. Please try again.', 'error');
                }
            }, 1000);
        }

        // Scroll to Top Functionality
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Show/Hide Scroll to Top Button
        window.addEventListener('scroll', function() {
            const scrollToTopBtn = document.getElementById('scrollToTop');
            if (scrollToTopBtn) {
                if (window.pageYOffset > 300) {
                    scrollToTopBtn.classList.add('show');
                } else {
                    scrollToTopBtn.classList.remove('show');
                }
            }
        });

        // Smooth scroll for footer links
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scroll to all anchor links in footer
            const footerLinks = document.querySelectorAll('.footer a[href^="#"]');

            footerLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');

                    if (href === '#') {
                        e.preventDefault();
                        return;
                    }

                    const target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Social media link tracking (optional)
            const socialIcons = document.querySelectorAll('.social-icon');
            socialIcons.forEach(icon => {
                icon.addEventListener('click', function(e) {
                    const platform = this.getAttribute('title');
                    console.log(`Social media clicked: ${platform}`);
                    // You can add analytics tracking here
                });
            });

            // App button tracking (optional)
            const appButtons = document.querySelectorAll('.app-button');
            appButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const appStore = this.querySelector('strong').textContent;
                    console.log(`App download clicked: ${appStore}`);
                    showNotification(`Redirecting to ${appStore}...`, 'info');
                    // Add your app store links here
                });
            });

            // Payment icon hover effects
            const paymentIcons = document.querySelectorAll('.payment-icon');
            paymentIcons.forEach(icon => {
                icon.addEventListener('mouseenter', function() {
                    const paymentMethod = this.getAttribute('title');
                    console.log(`Payment method hovered: ${paymentMethod}`);
                });
            });

            console.log('Footer initialized successfully');
        });

        // Dynamic year update (optional)
        function updateCopyrightYear() {
            const copyrightText = document.querySelector('.footer-copyright');
            if (copyrightText) {
                const currentYear = new Date().getFullYear();
                copyrightText.innerHTML = copyrightText.innerHTML.replace('2024', currentYear);
            }
        }

        // Call on page load
        updateCopyrightYear();
    </script>

    <!-- Additional scripts from child pages -->
    @stack('scripts')
</body>

</html>
