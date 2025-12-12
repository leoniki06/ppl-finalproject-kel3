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

    /* ========== SEARCH AND FILTER STYLES ========== */
    .search-wrapper {
        position: relative;
        width: 420px;
    }

    .search-container {
        width: 100%;
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
        z-index: 1001;
    }

    .search-container:focus-within {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(63, 35, 5, 0.15);
    }

    .search-container.active {
        border-radius: 15px 15px 0 0;
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

    /* Filter Button */
    .filter-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--white);
        border: 1.5px solid rgba(63, 35, 5, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        margin-left: 8px;
        color: var(--primary-color);
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: var(--primary-color);
        color: var(--white);
        border-color: var(--primary-color);
        transform: scale(1.05);
    }

    /* Search History Dropdown */
    .search-history-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--white);
        border-radius: 0 0 15px 15px;
        box-shadow: var(--shadow-medium);
        max-height: 300px;
        overflow-y: auto;
        display: none;
        z-index: 1000;
        border: 1.5px solid rgba(63, 35, 5, 0.15);
        border-top: none;
    }

    .search-history-dropdown.active {
        display: block;
    }

    .search-history-header {
        padding: 12px 20px;
        border-bottom: 1px solid rgba(63, 35, 5, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .search-history-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--primary-color);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .clear-history-btn {
        background: none;
        border: none;
        color: var(--text-light);
        font-size: 12px;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 4px;
        transition: var(--transition);
    }

    .clear-history-btn:hover {
        color: var(--danger-color);
        background: rgba(255, 71, 87, 0.1);
    }

    .search-history-list {
        list-style: none;
    }

    .search-history-item {
        padding: 12px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        transition: var(--transition);
        border-bottom: 1px solid rgba(63, 35, 5, 0.05);
    }

    .search-history-item:hover {
        background: rgba(63, 35, 5, 0.05);
    }

    .search-history-item:last-child {
        border-bottom: none;
    }

    .search-history-text {
        color: var(--text-dark);
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .search-history-text i {
        color: var(--primary-light);
        font-size: 12px;
    }

    .search-history-time {
        color: var(--text-light);
        font-size: 12px;
    }

    .search-history-empty {
        padding: 20px;
        text-align: center;
        color: var(--text-light);
        font-size: 14px;
        display: none;
    }

    /* Filter Modal */
    .filter-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        padding: 20px;
    }

    .filter-modal.active {
        display: flex;
    }

    .filter-content {
        background: var(--white);
        border-radius: 20px;
        max-width: 800px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: var(--shadow-medium);
    }

    .filter-header {
        padding: 25px 30px;
        border-bottom: 1px solid rgba(63, 35, 5, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .filter-title {
        font-size: 22px;
        font-weight: 700;
        color: var(--primary-color);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .filter-title i {
        color: var(--accent-color);
    }

    .filter-close {
        background: none;
        border: none;
        color: var(--text-light);
        font-size: 24px;
        cursor: pointer;
        transition: var(--transition);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .filter-close:hover {
        background: rgba(63, 35, 5, 0.1);
        color: var(--primary-color);
    }

    .filter-body {
        padding: 30px;
    }

    .filter-section {
        margin-bottom: 30px;
    }

    .filter-section-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filter-section-title i {
        color: var(--accent-color);
    }

    .filter-options {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .filter-option {
        padding: 10px 20px;
        background: var(--bg-light);
        border: 1.5px solid rgba(63, 35, 5, 0.1);
        border-radius: 25px;
        font-size: 14px;
        font-weight: 500;
        color: var(--text-dark);
        cursor: pointer;
        transition: var(--transition);
    }

    .filter-option:hover {
        border-color: var(--primary-color);
        background: var(--white);
    }

    .filter-option.active {
        background: var(--primary-color);
        color: var(--white);
        border-color: var(--primary-color);
    }

    .filter-range {
        padding: 20px;
        background: var(--bg-light);
        border-radius: 15px;
    }

    .filter-range-values {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .filter-range-value {
        font-size: 14px;
        color: var(--text-dark);
        font-weight: 500;
    }

    .filter-range-slider {
        width: 100%;
        height: 6px;
        background: rgba(63, 35, 5, 0.1);
        border-radius: 3px;
        outline: none;
        -webkit-appearance: none;
    }

    .filter-range-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: var(--primary-color);
        cursor: pointer;
        border: 3px solid var(--white);
        box-shadow: 0 2px 5px rgba(63, 35, 5, 0.2);
    }

    /* Distance Filter Specific */
    .distance-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 10px;
    }

    .distance-option {
        padding: 15px;
        background: var(--bg-light);
        border: 1.5px solid rgba(63, 35, 5, 0.1);
        border-radius: 12px;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
    }

    .distance-option:hover {
        border-color: var(--primary-color);
        background: var(--white);
    }

    .distance-option.active {
        background: var(--primary-color);
        border-color: var(--primary-color);
    }

    .distance-value {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 5px;
    }

    .distance-option.active .distance-value {
        color: var(--white);
    }

    .distance-label {
        font-size: 12px;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .distance-option.active .distance-label {
        color: rgba(255, 255, 255, 0.9);
    }

    /* Rating Filter */
    .rating-options {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .rating-option {
        padding: 12px 20px;
        background: var(--bg-light);
        border: 1.5px solid rgba(63, 35, 5, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 15px;
        cursor: pointer;
        transition: var(--transition);
    }

    .rating-option:hover {
        border-color: var(--primary-color);
        background: var(--white);
    }

    .rating-option.active {
        background: var(--primary-color);
        border-color: var(--primary-color);
    }

    .rating-stars {
        display: flex;
        gap: 2px;
    }

    .rating-star {
        color: #FFD700;
        font-size: 16px;
    }

    .rating-option.active .rating-star {
        color: var(--white);
    }

    .rating-text {
        font-size: 14px;
        font-weight: 500;
        color: var(--text-dark);
    }

    .rating-option.active .rating-text {
        color: var(--white);
    }

    .rating-count {
        margin-left: auto;
        font-size: 12px;
        color: var(--text-light);
        background: var(--white);
        padding: 2px 8px;
        border-radius: 10px;
    }

    .rating-option.active .rating-count {
        background: rgba(255, 255, 255, 0.2);
        color: var(--white);
    }

    .filter-footer {
        padding: 20px 30px;
        border-top: 1px solid rgba(63, 35, 5, 0.1);
        display: flex;
        justify-content: space-between;
        gap: 15px;
    }

    .filter-reset {
        padding: 12px 30px;
        background: var(--white);
        border: 1.5px solid rgba(63, 35, 5, 0.15);
        border-radius: 25px;
        font-size: 15px;
        font-weight: 600;
        color: var(--text-dark);
        cursor: pointer;
        transition: var(--transition);
    }

    .filter-reset:hover {
        border-color: var(--danger-color);
        color: var(--danger-color);
        background: rgba(255, 71, 87, 0.05);
    }

    .filter-apply {
        padding: 12px 40px;
        background: var(--primary-color);
        border: none;
        border-radius: 25px;
        font-size: 15px;
        font-weight: 600;
        color: var(--white);
        cursor: pointer;
        transition: var(--transition);
        flex: 1;
    }

    .filter-apply:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(63, 35, 5, 0.2);
    }

    /* ========== NAVBAR LAYOUT FIXES ========== */
    .navbar-left-section {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .navbar-center-section {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .navbar-right-section {
        display: flex;
        align-items: center;
        gap: 15px;
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

        .search-wrapper {
            width: 350px;
        }
    }

    @media (max-width: 1024px) {
        .navbar-container {
            flex-wrap: wrap;
            gap: 15px;
            padding: 15px;
        }

        .search-wrapper {
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

        .navbar-left-section,
        .navbar-center-section,
        .navbar-right-section {
            gap: 10px;
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

        .filter-content {
            max-height: 80vh;
        }

        .filter-body {
            padding: 20px;
        }

        .filter-options {
            justify-content: center;
        }

        .distance-options {
            grid-template-columns: repeat(2, 1fr);
        }

        .navbar-left-section,
        .navbar-center-section,
        .navbar-right-section {
            gap: 8px;
        }
    }

    @media (max-width: 480px) {
        .filter-footer {
            flex-direction: column;
        }

        .filter-option {
            padding: 8px 16px;
            font-size: 13px;
        }

        .cart-btn,
        .profile-btn {
            min-width: 110px;
            padding: 0 12px;
        }

        .cart-text,
        .profile-text {
            font-size: 13px;
        }
    }
</style>

<!-- Filter Modal -->
<div class="filter-modal" id="filterModal">
    <div class="filter-content">
        <div class="filter-header">
            <h2 class="filter-title"><i class="fas fa-filter"></i> Filter Options</h2>
            <button class="filter-close" id="filterClose">&times;</button>
        </div>

        <div class="filter-body">
            <!-- Price Filter -->
            <div class="filter-section">
                <h3 class="filter-section-title"><i class="fas fa-tag"></i> Price Range</h3>
                <div class="filter-range">
                    <div class="filter-range-values">
                        <span class="filter-range-value" id="minPriceValue">Rp 0</span>
                        <span class="filter-range-value" id="maxPriceValue">Rp 100.000</span>
                    </div>
                    <input type="range" min="0" max="100000" value="0" class="filter-range-slider" id="minPriceSlider">
                    <input type="range" min="0" max="100000" value="100000" class="filter-range-slider" id="maxPriceSlider">
                </div>
            </div>

            <!-- Rating Filter -->
            <div class="filter-section">
                <h3 class="filter-section-title"><i class="fas fa-star"></i> Minimum Rating</h3>
                <div class="rating-options" id="ratingOptions">
                    <div class="rating-option" data-rating="4">
                        <div class="rating-stars">
                            <i class="fas fa-star rating-star"></i>
                            <i class="fas fa-star rating-star"></i>
                            <i class="fas fa-star rating-star"></i>
                            <i class="fas fa-star rating-star"></i>
                            <i class="far fa-star rating-star"></i>
                        </div>
                        <span class="rating-text">4 Stars & Up</span>
                        <span class="rating-count">128</span>
                    </div>
                    <div class="rating-option" data-rating="3">
                        <div class="rating-stars">
                            <i class="fas fa-star rating-star"></i>
                            <i class="fas fa-star rating-star"></i>
                            <i class="fas fa-star rating-star"></i>
                            <i class="far fa-star rating-star"></i>
                            <i class="far fa-star rating-star"></i>
                        </div>
                        <span class="rating-text">3 Stars & Up</span>
                        <span class="rating-count">256</span>
                    </div>
                    <div class="rating-option" data-rating="2">
                        <div class="rating-stars">
                            <i class="fas fa-star rating-star"></i>
                            <i class="fas fa-star rating-star"></i>
                            <i class="far fa-star rating-star"></i>
                            <i class="far fa-star rating-star"></i>
                            <i class="far fa-star rating-star"></i>
                        </div>
                        <span class="rating-text">2 Stars & Up</span>
                        <span class="rating-count">312</span>
                    </div>
                </div>
            </div>

            <!-- Category Filter -->
            <div class="filter-section">
                <h3 class="filter-section-title"><i class="fas fa-utensils"></i> Food Category</h3>
                <div class="filter-options" id="categoryOptions">
                    <button class="filter-option active" data-category="all">All Categories</button>
                    <button class="filter-option" data-category="bakery">Bakery & Bread</button>
                    <button class="filter-option" data-category="dairy">Dairy & Beverages</button>
                    <button class="filter-option" data-category="fruits">Fruits & Vegetables</button>
                    <button class="filter-option" data-category="meat">Meat & Fish</button>
                    <button class="filter-option" data-category="eggs">Eggs & Dairy</button>
                    <button class="filter-option" data-category="ready">Ready-to-Eat</button>
                    <button class="filter-option" data-category="frozen">Frozen Foods</button>
                </div>
            </div>

            <!-- Distance Filter -->
            <div class="filter-section">
                <h3 class="filter-section-title"><i class="fas fa-location-dot"></i> Maximum Distance</h3>
                <div class="distance-options" id="distanceOptions">
                    <div class="distance-option" data-distance="1">
                        <div class="distance-value">1 km</div>
                        <div class="distance-label">Walking</div>
                    </div>
                    <div class="distance-option" data-distance="3">
                        <div class="distance-value">3 km</div>
                        <div class="distance-label">Short Drive</div>
                    </div>
                    <div class="distance-option" data-distance="5">
                        <div class="distance-value">5 km</div>
                        <div class="distance-label">Neighborhood</div>
                    </div>
                    <div class="distance-option active" data-distance="10">
                        <div class="distance-value">10 km</div>
                        <div class="distance-label">City Area</div>
                    </div>
                    <div class="distance-option" data-distance="20">
                        <div class="distance-value">20 km</div>
                        <div class="distance-label">Any Distance</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="filter-footer">
            <button class="filter-reset" id="resetFilters">Reset All Filters</button>
            <button class="filter-apply" id="applyFilters">Apply Filters</button>
        </div>
    </div>
</div>

<div class="navbar-container" id="navbarContainer">
    <!-- Left Section: Logo -->
    <div class="navbar-left-section">
        <a href="{{ route('dashboard') }}" style="text-decoration: none;">
            <img class="logo" src="{{ asset('images/LOGO LASTBITE.png') }}" alt="Last Bite" />
        </a>
    </div>

    <!-- Center Section: Catalog and Search -->
    <div class="navbar-center-section">
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

        <!-- =========================================== -->
        <!-- INTEGRATED SEARCH WITH HISTORY, FILTER & RESULTS -->
        <!-- =========================================== -->
        <style>
            /* ========== INTEGRATED SEARCH COMPONENT ========== */
            .search-wrapper {
                position: relative;
                width: 300px;
                margin: 0 10px;
            }

            .search-container {
                position: relative;
                width: 100%;
                height: 48px;
                background: var(--white);
                border-radius: 30px;
                display: flex;
                align-items: center;
                padding: 0 15px;
                border: 1.5px solid rgba(63, 35, 5, 0.15);
                box-shadow: 0 2px 8px rgba(63, 35, 5, 0.05);
                transition: var(--transition);
            }

            .search-container:focus-within,
            .search-container.active {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(63, 35, 5, 0.15);
            }

            .search-container.has-filters {
                border-color: var(--accent-color);
            }

            .search-input-wrapper {
                flex: 1;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .search-icon-left {
                color: var(--text-light);
                font-size: 14px;
            }

            .search-input {
                flex: 1;
                height: 100%;
                border: none;
                outline: none;
                background: transparent;
                font-size: 15px;
                font-weight: 500;
                color: var(--text-dark);
                padding: 0;
                width: 100%;
            }

            .search-input::placeholder {
                color: var(--text-light);
                font-weight: 400;
            }

            .search-actions {
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .search-action-btn {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background: transparent;
                border: none;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: var(--transition);
                color: var(--text-light);
                position: relative;
            }

            .search-action-btn:hover {
                background: rgba(63, 35, 5, 0.08);
                color: var(--primary-color);
            }

            .filter-btn {
                color: var(--primary-color);
            }

            .filter-btn.active {
                background: var(--primary-color);
                color: var(--white);
            }

            .filter-badge {
                position: absolute;
                top: -3px;
                right: -3px;
                background: var(--accent-color);
                color: var(--primary-dark);
                font-size: 10px;
                font-weight: 700;
                width: 16px;
                height: 16px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            }

            .search-btn {
                background: var(--primary-color);
                color: var(--white);
            }

            .search-btn:hover {
                background: var(--primary-dark);
                transform: scale(1.05);
            }

            /* Search Dropdown Panel */
            .search-dropdown {
                position: absolute;
                top: calc(100% + 8px);
                left: 0;
                right: 0;
                background: var(--white);
                border-radius: 16px;
                box-shadow: var(--shadow-medium);
                z-index: 1100;
                display: none;
                border: 1px solid rgba(63, 35, 5, 0.1);
                max-height: 500px;
                overflow: hidden;
                animation: slideDown 0.3s ease;
            }

            @keyframes slideDown {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .search-dropdown.show {
                display: block;
            }

            /* Search Header */
            .search-header {
                padding: 15px 20px;
                border-bottom: 1px solid rgba(63, 35, 5, 0.1);
                background: var(--bg-light);
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .search-title {
                font-size: 14px;
                font-weight: 600;
                color: var(--primary-color);
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .search-clear-btn {
                background: none;
                border: none;
                color: var(--text-light);
                font-size: 13px;
                cursor: pointer;
                padding: 4px 8px;
                border-radius: 4px;
                transition: var(--transition);
            }

            .search-clear-btn:hover {
                color: var(--danger-color);
                background: rgba(255, 71, 87, 0.1);
            }

            /* Search Content */
            .search-content {
                max-height: 400px;
                overflow-y: auto;
                padding: 0;
            }

            /* Search History Section */
            .search-history {
                padding: 15px 20px;
                border-bottom: 1px solid rgba(63, 35, 5, 0.1);
            }

            .history-title {
                font-size: 12px;
                font-weight: 600;
                color: var(--primary-color);
                margin-bottom: 10px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .clear-history-btn {
                background: none;
                border: none;
                color: var(--text-light);
                font-size: 11px;
                cursor: pointer;
                padding: 2px 6px;
                border-radius: 3px;
                transition: var(--transition);
            }

            .clear-history-btn:hover {
                color: var(--danger-color);
            }

            .history-list {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .history-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 8px 12px;
                border-radius: 8px;
                cursor: pointer;
                transition: var(--transition);
            }

            .history-item:hover {
                background: rgba(63, 35, 5, 0.05);
            }

            .history-content {
                display: flex;
                align-items: center;
                gap: 10px;
                flex: 1;
            }

            .history-icon {
                color: var(--text-light);
                font-size: 12px;
                width: 16px;
            }

            .history-text {
                font-size: 14px;
                color: var(--text-dark);
                font-weight: 500;
            }

            .history-time {
                font-size: 11px;
                color: var(--text-light);
                margin-left: 8px;
                font-style: italic;
            }

            .history-remove {
                background: none;
                border: none;
                color: var(--text-light);
                font-size: 11px;
                cursor: pointer;
                padding: 4px;
                border-radius: 50%;
                opacity: 0;
                transition: var(--transition);
            }

            .history-item:hover .history-remove {
                opacity: 1;
            }

            .history-remove:hover {
                color: var(--danger-color);
                background: rgba(255, 71, 87, 0.1);
            }

            .no-history {
                text-align: center;
                padding: 20px;
                color: var(--text-light);
                font-size: 13px;
                font-style: italic;
            }

            /* Filter Section */
            .filter-section {
                padding: 20px;
            }

            .filter-title {
                font-size: 14px;
                font-weight: 600;
                color: var(--primary-color);
                margin-bottom: 15px;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .filter-group {
                margin-bottom: 20px;
            }

            .filter-group-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 10px;
            }

            .filter-group-label {
                font-size: 13px;
                font-weight: 600;
                color: var(--primary-dark);
                display: flex;
                align-items: center;
                gap: 6px;
            }

            .filter-group-label i {
                font-size: 12px;
                color: var(--primary-light);
            }

            .filter-group-value {
                font-size: 12px;
                color: var(--accent-color);
                font-weight: 600;
            }

            /* Price Range */
            .price-range-container {
                padding: 10px 0;
            }

            .price-range-slider {
                width: 100%;
                height: 4px;
                background: rgba(63, 35, 5, 0.1);
                border-radius: 2px;
                position: relative;
                margin: 15px 0;
            }

            .price-range-track {
                position: absolute;
                height: 100%;
                background: var(--primary-color);
                border-radius: 2px;
                left: 0%;
                right: 0%;
            }

            .price-range-handle {
                position: absolute;
                width: 18px;
                height: 18px;
                background: var(--white);
                border: 2px solid var(--primary-color);
                border-radius: 50%;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                box-shadow: 0 2px 5px rgba(63, 35, 5, 0.2);
            }

            .price-range-labels {
                display: flex;
                justify-content: space-between;
                font-size: 11px;
                color: var(--text-light);
                margin-top: 5px;
            }

            /* Rating Filter */
            .rating-options {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .rating-option {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 8px 12px;
                border-radius: 8px;
                cursor: pointer;
                transition: var(--transition);
                border: 1px solid rgba(63, 35, 5, 0.1);
            }

            .rating-option:hover {
                border-color: var(--primary-color);
                background: rgba(63, 35, 5, 0.05);
            }

            .rating-option.selected {
                border-color: var(--primary-color);
                background: rgba(63, 35, 5, 0.1);
            }

            .rating-option input {
                display: none;
            }

            .rating-stars {
                display: flex;
                gap: 2px;
            }

            .rating-stars i {
                color: #FFD700;
                font-size: 12px;
            }

            .rating-label {
                font-size: 13px;
                color: var(--text-dark);
                margin-left: auto;
            }

            /* Category Filter */
            .category-options {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
            }

            .category-chip {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 6px 12px;
                background: var(--bg-light);
                border: 1px solid rgba(63, 35, 5, 0.1);
                border-radius: 20px;
                font-size: 12px;
                color: var(--text-dark);
                cursor: pointer;
                transition: var(--transition);
                user-select: none;
            }

            .category-chip:hover {
                border-color: var(--primary-color);
                background: rgba(63, 35, 5, 0.05);
            }

            .category-chip.selected {
                background: var(--primary-color);
                color: var(--white);
                border-color: var(--primary-color);
            }

            /* Distance Filter */
            .distance-filter {
                padding: 10px 0;
            }

            .distance-slider {
                width: 100%;
                height: 4px;
                background: rgba(63, 35, 5, 0.1);
                border-radius: 2px;
                margin: 15px 0;
                -webkit-appearance: none;
                appearance: none;
            }

            .distance-slider::-webkit-slider-thumb {
                -webkit-appearance: none;
                appearance: none;
                width: 18px;
                height: 18px;
                background: var(--white);
                border: 2px solid var(--primary-color);
                border-radius: 50%;
                cursor: pointer;
                box-shadow: 0 2px 5px rgba(63, 35, 5, 0.2);
            }

            .distance-slider::-moz-range-thumb {
                width: 18px;
                height: 18px;
                background: var(--white);
                border: 2px solid var(--primary-color);
                border-radius: 50%;
                cursor: pointer;
                box-shadow: 0 2px 5px rgba(63, 35, 5, 0.2);
            }

            .distance-value {
                text-align: center;
                font-size: 13px;
                color: var(--primary-color);
                font-weight: 600;
                margin-top: 10px;
            }

            /* Active Filters */
            .active-filters {
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
                margin-top: 15px;
                padding: 15px 0;
                border-top: 1px solid rgba(63, 35, 5, 0.1);
            }

            .active-filter-tag {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 4px 10px;
                background: var(--primary-color);
                color: var(--white);
                border-radius: 15px;
                font-size: 11px;
                font-weight: 500;
            }

            .filter-remove {
                background: none;
                border: none;
                color: var(--white);
                cursor: pointer;
                padding: 0;
                font-size: 10px;
                opacity: 0.8;
                transition: var(--transition);
            }

            .filter-remove:hover {
                opacity: 1;
            }

            /* Search Footer */
            .search-footer {
                padding: 15px 20px;
                border-top: 1px solid rgba(63, 35, 5, 0.1);
                background: var(--bg-light);
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .filter-count {
                font-size: 13px;
                color: var(--primary-color);
                font-weight: 600;
            }

            .search-apply-btn {
                padding: 8px 20px;
                background: var(--primary-color);
                color: var(--white);
                border: none;
                border-radius: 20px;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                transition: var(--transition);
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .search-apply-btn:hover {
                background: var(--primary-dark);
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(63, 35, 5, 0.2);
            }

            /* ========== SEARCH RESULTS DISPLAY ========== */
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
                to { transform: rotate(360deg); }
            }

            .loading-text {
                color: var(--text-light);
            }

            /* Responsive */
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

        <!-- Integrated Search Component -->
        <div class="search-wrapper">
            <!-- Search Input -->
            <div class="search-container" id="searchContainer">
                <div class="search-input-wrapper">
                    <i class="fas fa-search search-icon-left"></i>
                    <input type="text"
                           class="search-input"
                           placeholder="Search Product"
                           id="searchInput"
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
                        <span id="searchTitle">Pencarian</span>
                    </div>
                    <button class="search-clear-btn" onclick="clearAll()">Bersihkan</button>
                </div>

                <!-- Content -->
                <div class="search-content" id="searchContent">
                    <!-- History Section (shown by default) -->
                    <div class="search-history" id="historySection">
                        <div class="history-title">
                            <span>Pencarian Terakhir</span>
                            <button class="clear-history-btn" onclick="clearHistory()">Hapus Semua</button>
                        </div>
                        <div class="history-list" id="historyList">
                            <!-- History items will be dynamically added here -->
                        </div>
                    </div>

                    <!-- Filter Section (hidden by default) -->
                    <div class="filter-section" id="filterSection" style="display: none;">
                        <div class="filter-title">
                            <i class="fas fa-sliders-h"></i>
                            Filter Pencarian
                        </div>

                        <!-- Price Filter -->
                        <div class="filter-group">
                            <div class="filter-group-header">
                                <div class="filter-group-label">
                                    <i class="fas fa-tag"></i>
                                    Harga
                                </div>
                                <div class="filter-group-value" id="priceValue">Rp 0 - 50k+</div>
                            </div>
                            <div class="price-range-container">
                                <div class="price-range-slider" id="priceRangeSlider">
                                    <div class="price-range-track" id="priceRangeTrack"></div>
                                    <div class="price-range-handle" id="priceMinHandle"></div>
                                    <div class="price-range-handle" id="priceMaxHandle"></div>
                                </div>
                                <div class="price-range-labels">
                                    <span>Rp 0</span>
                                    <span>Rp 10k</span>
                                    <span>Rp 20k</span>
                                    <span>Rp 30k</span>
                                    <span>Rp 40k</span>
                                    <span>Rp 50k+</span>
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
                                <div class="filter-group-value" id="ratingValue">Semua</div>
                            </div>
                            <div class="rating-options">
                                <div class="rating-option selected" onclick="selectRating(0)">
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-label">Semua Rating</span>
                                </div>
                                <div class="rating-option" onclick="selectRating(4)">
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <span class="rating-label">4.0 ke atas</span>
                                </div>
                                <div class="rating-option" onclick="selectRating(3)">
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <span class="rating-label">3.0 ke atas</span>
                                </div>
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div class="filter-group">
                            <div class="filter-group-header">
                                <div class="filter-group-label">
                                    <i class="fas fa-utensils"></i>
                                    Kategori
                                </div>
                                <div class="filter-group-value" id="categoryValue">Semua</div>
                            </div>
                            <div class="category-options">
                                <div class="category-chip" onclick="toggleCategory('bakery')">
                                    <span>Roti & Bakery</span>
                                </div>
                                <div class="category-chip" onclick="toggleCategory('dairy')">
                                    <span>Produk Susu</span>
                                </div>
                                <div class="category-chip" onclick="toggleCategory('fruits')">
                                    <span>Buah & Sayur</span>
                                </div>
                                <div class="category-chip" onclick="toggleCategory('meat')">
                                    <span>Daging & Ikan</span>
                                </div>
                                <div class="category-chip" onclick="toggleCategory('ready')">
                                    <span>Siap Saji</span>
                                </div>
                            </div>
                        </div>

                        <!-- Distance Filter -->
                        <div class="filter-group">
                            <div class="filter-group-header">
                                <div class="filter-group-label">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Jarak
                                </div>
                                <div class="filter-group-value" id="distanceValue">10 km</div>
                            </div>
                            <div class="distance-filter">
                                <input type="range"
                                       min="1"
                                       max="20"
                                       value="10"
                                       class="distance-slider"
                                       id="distanceSlider"
                                       oninput="updateDistance()">
                                <div class="distance-value">
                                    Dalam <span id="distanceText">10</span> km
                                </div>
                            </div>
                        </div>

                        <!-- Active Filters -->
                        <div class="active-filters" id="activeFilters">
                            <!-- Active filter tags will be added here -->
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="search-footer">
                    <div class="filter-count">
                        <span id="filterCount">0</span> filter aktif
                    </div>
                    <button class="search-apply-btn" onclick="applySearch()">
                        <i class="fas fa-search"></i>
                        Terapkan Pencarian
                    </button>
                </div>
            </div>
        </div>

        <!-- Search Results Display Area -->
        <div class="search-results-container" id="searchResultsContainer">
            <div class="search-results-header">
                <div>
                    <h2 class="results-title">
                        Hasil Pencarian
                        <span class="results-count" id="resultsCount">(0 produk)</span>
                    </h2>
                    <div class="results-summary" id="resultsSummary">
                        Menampilkan hasil pencarian...
                    </div>
                </div>
                <button class="close-results-btn" onclick="closeResults()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="search-results-grid" id="searchResultsGrid">
                <!-- Search results will be dynamically added here -->
            </div>
        </div>

        <script>
            // ========== INTEGRATED SEARCH COMPONENT ==========

            // State management
            let searchHistory = JSON.parse(localStorage.getItem('lastbite_search_history')) || [];
            let currentFilters = {
                priceRange: { min: 0, max: 50000 },
                minRating: 0,
                categories: [],
                maxDistance: 10
            };
            let showFilters = false;
            let currentSearchQuery = '';
            let searchResults = [];

            // Sample product data (replace with API call)
            const sampleProducts = [
                {
                    id: 1,
                    name: "Roti Tawar Gandum",
                    category: "bakery",
                    price: 15000,
                    originalPrice: 25000,
                    rating: 4.5,
                    description: "Roti tawar gandum segar, diskon 40% karena mendekati tanggal kadaluarsa",
                    distance: 2.5,
                    expiry: "2 hari lagi",
                    image: "https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=300&fit=crop"
                },
                {
                    id: 2,
                    name: "Susu Segar Murni",
                    category: "dairy",
                    price: 12000,
                    originalPrice: 18000,
                    rating: 4.2,
                    description: "Susu segar murni, diskon 33% karena mendekati tanggal kadaluarsa",
                    distance: 1.8,
                    expiry: "1 hari lagi",
                    image: "https://images.unsplash.com/photo-1563636619-e9143da7973b?w=400&h=300&fit=crop"
                },
                {
                    id: 3,
                    name: "Apel Fuji Premium",
                    category: "fruits",
                    price: 25000,
                    originalPrice: 35000,
                    rating: 4.7,
                    description: "Apel Fuji segar, diskon 28% karena mendekati kesegaran optimal",
                    distance: 3.2,
                    expiry: "3 hari lagi",
                    image: "https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?w-400&h=300&fit=crop"
                },
                {
                    id: 4,
                    name: "Daging Sapi Fillet",
                    category: "meat",
                    price: 45000,
                    originalPrice: 65000,
                    rating: 4.8,
                    description: "Daging sapi fillet premium, diskon 30% karena mendekati tanggal kadaluarsa",
                    distance: 4.5,
                    expiry: "Hari ini",
                    image: "https://images.unsplash.com/photo-1546833999-b9f581a1996d?w=400&h=300&fit=crop"
                },
                {
                    id: 5,
                    name: "Salad Buah Segar",
                    category: "ready",
                    price: 18000,
                    originalPrice: 25000,
                    rating: 4.3,
                    description: "Salad buah segar dengan yogurt, diskon 28% karena mendekati tanggal kadaluarsa",
                    distance: 2.1,
                    expiry: "Hari ini",
                    image: "https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=400&h=300&fit=crop"
                },
                {
                    id: 6,
                    name: "Croissant Keju",
                    category: "bakery",
                    price: 8000,
                    originalPrice: 15000,
                    rating: 4.6,
                    description: "Croissant keju lembut, diskon 47% karena mendekati tanggal kadaluarsa",
                    distance: 1.5,
                    expiry: "1 hari lagi",
                    image: "https://images.unsplash.com/photo-1555507036-ab794f27d2e9?w=400&h=300&fit=crop"
                },
                {
                    id: 7,
                    name: "Yogurt Greek",
                    category: "dairy",
                    price: 14000,
                    originalPrice: 22000,
                    rating: 4.4,
                    description: "Yogurt Greek rendah lemak, diskon 36% karena mendekati tanggal kadaluarsa",
                    distance: 3.8,
                    expiry: "2 hari lagi",
                    image: "https://images.unsplash.com/photo-1567306301404-7362a5c5c8b6?w=400&h=300&fit=crop"
                },
                {
                    id: 8,
                    name: "Strawberry Organik",
                    category: "fruits",
                    price: 22000,
                    originalPrice: 32000,
                    rating: 4.9,
                    description: "Strawberry organik segar, diskon 31% karena mendekati kesegaran optimal",
                    distance: 5.2,
                    expiry: "1 hari lagi",
                    image: "https://images.unsplash.com/photo-1464965911861-746a04b4bca6?w=400&h=300&fit=crop"
                }
            ];

            // Initialize
            document.addEventListener('DOMContentLoaded', function() {
                loadSearchHistory();
                initializePriceSlider();
                updateUI();

                // Search input events
                const searchInput = document.getElementById('searchInput');
                const searchContainer = document.getElementById('searchContainer');

                searchInput.addEventListener('focus', function() {
                    searchContainer.classList.add('active');
                    showDropdown();
                    showHistory();
                });

                searchInput.addEventListener('input', function() {
                    const query = this.value.trim();
                    document.getElementById('searchTitle').textContent =
                        query ? `Mencari: "${query}"` : 'Pencarian';
                    currentSearchQuery = query;
                });

                // Enter key for search
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        performSearch();
                    }
                });

                // Click outside to close dropdown
                document.addEventListener('click', function(e) {
                    const searchWrapper = document.querySelector('.search-wrapper');
                    const dropdown = document.getElementById('searchDropdown');

                    if (!searchWrapper.contains(e.target) && dropdown.classList.contains('show')) {
                        hideDropdown();
                        searchContainer.classList.remove('active');
                    }
                });
            });

            // Dropdown Management
            function showDropdown() {
                const dropdown = document.getElementById('searchDropdown');
                dropdown.classList.add('show');
            }

            function hideDropdown() {
                const dropdown = document.getElementById('searchDropdown');
                dropdown.classList.remove('show');
            }

            function toggleFilter() {
                showFilters = !showFilters;
                const filterBtn = document.getElementById('filterBtn');
                const historySection = document.getElementById('historySection');
                const filterSection = document.getElementById('filterSection');

                if (showFilters) {
                    filterBtn.classList.add('active');
                    historySection.style.display = 'none';
                    filterSection.style.display = 'block';
                    document.getElementById('searchTitle').textContent = 'Filter Pencarian';
                } else {
                    filterBtn.classList.remove('active');
                    historySection.style.display = 'block';
                    filterSection.style.display = 'none';
                    const query = document.getElementById('searchInput').value.trim();
                    document.getElementById('searchTitle').textContent =
                        query ? `Mencari: "${query}"` : 'Pencarian';
                }
            }

            function showHistory() {
                showFilters = false;
                const filterBtn = document.getElementById('filterBtn');
                const historySection = document.getElementById('historySection');
                const filterSection = document.getElementById('filterSection');

                filterBtn.classList.remove('active');
                historySection.style.display = 'block';
                filterSection.style.display = 'none';
            }

            // Search History
            function loadSearchHistory() {
                const historyList = document.getElementById('historyList');

                if (searchHistory.length === 0) {
                    historyList.innerHTML = '<div class="no-history">Belum ada riwayat pencarian</div>';
                    return;
                }

                historyList.innerHTML = searchHistory.map((item, index) => {
                    const timeAgo = getTimeAgo(item.timestamp);
                    return `
                        <div class="history-item" onclick="useHistory('${item.query}', ${index})">
                            <div class="history-content">
                                <i class="fas fa-search history-icon"></i>
                                <div>
                                    <span class="history-text">${item.query}</span>
                                    <span class="history-time">${timeAgo}</span>
                                </div>
                            </div>
                            <button class="history-remove" onclick="removeHistory(${index}, event)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                }).join('');
            }

            function getTimeAgo(timestamp) {
                const now = new Date();
                const past = new Date(timestamp);
                const diffMs = now - past;
                const diffMins = Math.floor(diffMs / 60000);
                const diffHours = Math.floor(diffMs / 3600000);
                const diffDays = Math.floor(diffMs / 86400000);

                if (diffMins < 1) return 'baru saja';
                if (diffMins < 60) return `${diffMins}m lalu`;
                if (diffHours < 24) return `${diffHours}j lalu`;
                if (diffDays < 7) return `${diffDays}h lalu`;
                return `${Math.floor(diffDays / 7)}w lalu`;
            }

            function saveToHistory(query) {
                query = query.trim();
                if (!query) return;

                // Remove if same query exists
                const existingIndex = searchHistory.findIndex(item => item.query === query);
                if (existingIndex > -1) {
                    searchHistory.splice(existingIndex, 1);
                }

                // Add to beginning
                searchHistory.unshift({
                    query: query,
                    timestamp: new Date().toISOString(),
                    filters: { ...currentFilters }
                });

                // Keep only last 10 items
                if (searchHistory.length > 10) {
                    searchHistory = searchHistory.slice(0, 10);
                }

                localStorage.setItem('lastbite_search_history', JSON.stringify(searchHistory));
                loadSearchHistory();
            }

            function useHistory(query, index) {
                document.getElementById('searchInput').value = query;
                currentSearchQuery = query;

                // Restore filters from history if available
                if (searchHistory[index].filters) {
                    currentFilters = { ...searchHistory[index].filters };
                    applyFiltersToUI();
                    updateUI();
                }

                performSearch();
            }

            function removeHistory(index, event) {
                event.stopPropagation();
                searchHistory.splice(index, 1);
                localStorage.setItem('lastbite_search_history', JSON.stringify(searchHistory));
                loadSearchHistory();
            }

            function clearHistory() {
                if (searchHistory.length === 0) return;

                if (confirm('Hapus semua riwayat pencarian?')) {
                    searchHistory = [];
                    localStorage.removeItem('lastbite_search_history');
                    loadSearchHistory();
                    showNotification('Riwayat pencarian berhasil dihapus', 'success');
                }
            }

            // Filter Functions
            function initializePriceSlider() {
                const slider = document.getElementById('priceRangeSlider');
                const minHandle = document.getElementById('priceMinHandle');
                const maxHandle = document.getElementById('priceMaxHandle');
                const track = document.getElementById('priceRangeTrack');

                function updateSlider() {
                    const minPercent = (currentFilters.priceRange.min / 50000) * 100;
                    const maxPercent = (currentFilters.priceRange.max / 50000) * 100;

                    minHandle.style.left = `${minPercent}%`;
                    maxHandle.style.left = `${maxPercent}%`;
                    track.style.left = `${minPercent}%`;
                    track.style.right = `${100 - maxPercent}%`;

                    updatePriceDisplay();
                }

                function getPriceFromPosition(x) {
                    const rect = slider.getBoundingClientRect();
                    const percent = Math.max(0, Math.min(1, (x - rect.left) / rect.width));
                    return Math.round(percent * 50000);
                }

                function startDrag(handle, isMin) {
                    return function(e) {
                        e.preventDefault();
                        const startX = e.clientX;
                        const startPrice = isMin ? currentFilters.priceRange.min : currentFilters.priceRange.max;

                        function drag(e) {
                            const deltaX = e.clientX - startX;
                            const rect = slider.getBoundingClientRect();
                            const deltaPercent = deltaX / rect.width;
                            const deltaPrice = Math.round(deltaPercent * 50000);

                            let newPrice = startPrice + deltaPrice;
                            newPrice = Math.max(0, Math.min(50000, newPrice));

                            if (isMin) {
                                currentFilters.priceRange.min = Math.min(newPrice, currentFilters.priceRange.max - 5000);
                            } else {
                                currentFilters.priceRange.max = Math.max(newPrice, currentFilters.priceRange.min + 5000);
                            }

                            updateSlider();
                            updateUI();
                        }

                        function stopDrag() {
                            document.removeEventListener('mousemove', drag);
                            document.removeEventListener('mouseup', stopDrag);
                        }

                        document.addEventListener('mousemove', drag);
                        document.addEventListener('mouseup', stopDrag);
                    };
                }

                minHandle.addEventListener('mousedown', startDrag(minHandle, true));
                maxHandle.addEventListener('mousedown', startDrag(maxHandle, false));

                updateSlider();
            }

            function updatePriceDisplay() {
                const min = currentFilters.priceRange.min;
                const max = currentFilters.priceRange.max;

                const minText = min === 0 ? 'Rp 0' : `Rp ${min/1000}k`;
                const maxText = max === 50000 ? 'Rp 50k+' : `Rp ${max/1000}k`;

                document.getElementById('priceValue').textContent = `${minText} - ${maxText}`;
            }

            function selectRating(rating) {
                currentFilters.minRating = rating;

                // Update UI
                document.querySelectorAll('.rating-option').forEach(option => {
                    option.classList.remove('selected');
                });

                const ratingOptions = document.querySelectorAll('.rating-option');
                if (rating === 0) {
                    ratingOptions[0].classList.add('selected');
                    document.getElementById('ratingValue').textContent = 'Semua';
                } else if (rating === 4) {
                    ratingOptions[1].classList.add('selected');
                    document.getElementById('ratingValue').textContent = '4.0+';
                } else if (rating === 3) {
                    ratingOptions[2].classList.add('selected');
                    document.getElementById('ratingValue').textContent = '3.0+';
                }

                updateUI();
            }

            function toggleCategory(category) {
                const chip = document.querySelector(`.category-chip[onclick*="${category}"]`);
                const index = currentFilters.categories.indexOf(category);

                if (index === -1) {
                    currentFilters.categories.push(category);
                    chip.classList.add('selected');
                } else {
                    currentFilters.categories.splice(index, 1);
                    chip.classList.remove('selected');
                }

                updateCategoryDisplay();
                updateUI();
            }

            function updateCategoryDisplay() {
                const count = currentFilters.categories.length;
                if (count === 0) {
                    document.getElementById('categoryValue').textContent = 'Semua';
                } else if (count === 1) {
                    document.getElementById('categoryValue').textContent = '1 kategori';
                } else {
                    document.getElementById('categoryValue').textContent = `${count} kategori`;
                }
            }

            function updateDistance() {
                const slider = document.getElementById('distanceSlider');
                const value = slider.value;
                currentFilters.maxDistance = parseInt(value);

                document.getElementById('distanceText').textContent = value;
                document.getElementById('distanceValue').textContent = value === '20' ? 'Semua' : `${value} km`;

                updateUI();
            }

            function applyFiltersToUI() {
                // Apply price range
                updatePriceDisplay();

                // Apply rating
                selectRating(currentFilters.minRating);

                // Apply categories
                document.querySelectorAll('.category-chip').forEach(chip => {
                    chip.classList.remove('selected');
                });
                currentFilters.categories.forEach(category => {
                    const chip = document.querySelector(`.category-chip[onclick*="${category}"]`);
                    if (chip) chip.classList.add('selected');
                });
                updateCategoryDisplay();

                // Apply distance
                document.getElementById('distanceSlider').value = currentFilters.maxDistance;
                updateDistance();
            }

            // Update UI
            function updateUI() {
                // Calculate active filter count
                let filterCount = 0;

                if (currentFilters.priceRange.min > 0 || currentFilters.priceRange.max < 50000) filterCount++;
                if (currentFilters.minRating > 0) filterCount++;
                if (currentFilters.categories.length > 0) filterCount++;
                if (currentFilters.maxDistance < 20) filterCount++;

                // Update badge
                document.getElementById('filterBadge').textContent = filterCount;
                document.getElementById('filterCount').textContent = filterCount;

                // Update search container
                const searchContainer = document.getElementById('searchContainer');
                if (filterCount > 0) {
                    searchContainer.classList.add('has-filters');
                } else {
                    searchContainer.classList.remove('has-filters');
                }

                // Update active filters display
                updateActiveFilters();
            }

            function updateActiveFilters() {
                const container = document.getElementById('activeFilters');
                const filters = [];

                // Price filter
                if (currentFilters.priceRange.min > 0 || currentFilters.priceRange.max < 50000) {
                    const min = currentFilters.priceRange.min === 0 ? 'Rp 0' : `Rp ${currentFilters.priceRange.min/1000}k`;
                    const max = currentFilters.priceRange.max === 50000 ? 'Rp 50k+' : `Rp ${currentFilters.priceRange.max/1000}k`;
                    filters.push({
                        label: `Harga: ${min} - ${max}`,
                        remove: () => {
                            currentFilters.priceRange = { min: 0, max: 50000 };
                            updatePriceDisplay();
                            updateUI();
                        }
                    });
                }

                // Rating filter
                if (currentFilters.minRating > 0) {
                    filters.push({
                        label: `Rating: ${currentFilters.minRating}+`,
                        remove: () => {
                            selectRating(0);
                        }
                    });
                }

                // Category filters
                currentFilters.categories.forEach(category => {
                    const categoryNames = {
                        'bakery': 'Roti & Bakery',
                        'dairy': 'Produk Susu',
                        'fruits': 'Buah & Sayur',
                        'meat': 'Daging & Ikan',
                        'ready': 'Siap Saji'
                    };

                    filters.push({
                        label: categoryNames[category],
                        remove: () => {
                            toggleCategory(category);
                        }
                    });
                });

                // Distance filter
                if (currentFilters.maxDistance < 20) {
                    filters.push({
                        label: `Jarak: ${currentFilters.maxDistance} km`,
                        remove: () => {
                            document.getElementById('distanceSlider').value = 20;
                            updateDistance();
                        }
                    });
                }

                // Render active filters
                if (filters.length > 0) {
                    container.innerHTML = filters.map(filter => `
                        <div class="active-filter-tag">
                            ${filter.label}
                            <button class="filter-remove" onclick="event.stopPropagation(); ${filter.remove.toString().replace('()', '')}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `).join('');
                    container.style.display = 'flex';
                } else {
                    container.innerHTML = '';
                    container.style.display = 'none';
                }
            }

            // Search Functions
            function performSearch() {
                const query = document.getElementById('searchInput').value.trim();
                currentSearchQuery = query;

                if (!query && getActiveFilterCount() === 0) {
                    showNotification('Masukkan kata kunci pencarian', 'warning');
                    return;
                }

                if (query) {
                    saveToHistory(query);
                }

                applySearch();
            }

            function applySearch() {
                showLoadingResults();

                // Simulate API delay
                setTimeout(() => {
                    // Filter products based on search query and filters
                    const filteredProducts = filterProducts();
                    searchResults = filteredProducts;

                    // Display results
                    displaySearchResults(filteredProducts);

                    // Show notification
                    showSearchNotification(filteredProducts.length);

                    // Close dropdown
                    hideDropdown();
                    document.getElementById('searchContainer').classList.remove('active');
                }, 800);
            }

            function filterProducts() {
                return sampleProducts.filter(product => {
                    // Filter by search query
                    if (currentSearchQuery) {
                        const searchLower = currentSearchQuery.toLowerCase();
                        const nameMatch = product.name.toLowerCase().includes(searchLower);
                        const descMatch = product.description.toLowerCase().includes(searchLower);
                        const categoryMatch = product.category.toLowerCase().includes(searchLower);

                        if (!nameMatch && !descMatch && !categoryMatch) {
                            return false;
                        }
                    }

                    // Filter by price range
                    if (product.price < currentFilters.priceRange.min || product.price > currentFilters.priceRange.max) {
                        return false;
                    }

                    // Filter by rating
                    if (currentFilters.minRating > 0 && product.rating < currentFilters.minRating) {
                        return false;
                    }

                    // Filter by categories
                    if (currentFilters.categories.length > 0 && !currentFilters.categories.includes(product.category)) {
                        return false;
                    }

                    // Filter by distance
                    if (currentFilters.maxDistance < 20 && product.distance > currentFilters.maxDistance) {
                        return false;
                    }

                    return true;
                });
            }

            function displaySearchResults(products) {
                const container = document.getElementById('searchResultsContainer');
                const grid = document.getElementById('searchResultsGrid');
                const resultsCount = document.getElementById('resultsCount');
                const resultsSummary = document.getElementById('resultsSummary');

                // Show results container
                container.classList.add('show');

                // Update counts
                resultsCount.textContent = `(${products.length} produk)`;

                // Update summary
                let summary = '';
                if (currentSearchQuery) {
                    summary += `Hasil pencarian untuk "<strong>${currentSearchQuery}</strong>"`;
                }
                if (getActiveFilterCount() > 0) {
                    if (summary) summary += ' ';
                    summary += `dengan <strong>${getActiveFilterCount()} filter</strong>`;
                }
                if (!summary) {
                    summary = 'Menampilkan semua produk';
                }
                resultsSummary.innerHTML = summary;

                // Display products or no results message
                if (products.length === 0) {
                    grid.innerHTML = `
                        <div class="no-results">
                            <div class="no-results-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3 class="no-results-title">Tidak ada produk ditemukan</h3>
                            <p class="no-results-text">
                                ${currentSearchQuery ? `Tidak ada produk yang cocok dengan "${currentSearchQuery}"` : 'Tidak ada produk yang sesuai dengan filter'}
                            </p>
                            <button class="try-again-btn" onclick="clearAll()">
                                Coba Pencarian Lain
                            </button>
                        </div>
                    `;
                } else {
                    grid.innerHTML = products.map(product => `
                        <div class="product-card" onclick="viewProductDetail(${product.id})">
                            <div style="position: relative;">
                                <img src="${product.image}" alt="${product.name}" class="product-image">
                                <span class="product-badge">Diskon ${Math.round((1 - product.price / product.originalPrice) * 100)}%</span>
                            </div>
                            <div class="product-content">
                                <div class="product-header">
                                    <div>
                                        <h3 class="product-name">${product.name}</h3>
                                        <span class="product-category">${getCategoryName(product.category)}</span>
                                    </div>
                                    <div class="product-price">Rp ${product.price.toLocaleString()}</div>
                                </div>
                                <div class="product-rating">
                                    <div class="rating-stars-small">
                                        ${getStarIcons(product.rating)}
                                    </div>
                                    <span class="rating-value">${product.rating}</span>
                                </div>
                                <p class="product-description">${product.description}</p>
                                <div class="product-footer">
                                    <div>
                                        <div class="product-distance">
                                            <i class="fas fa-map-marker-alt"></i>
                                            ${product.distance} km
                                        </div>
                                        <div class="product-expiry">
                                            <i class="fas fa-clock"></i>
                                            ${product.expiry}
                                        </div>
                                    </div>
                                    <button class="add-to-cart-btn" onclick="addToCart(${product.id}, event)">
                                        <i class="fas fa-cart-plus"></i>
                                        Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                    `).join('');
                }
            }

            function getCategoryName(category) {
                const categories = {
                    'bakery': 'Roti & Bakery',
                    'dairy': 'Produk Susu',
                    'fruits': 'Buah & Sayur',
                    'meat': 'Daging & Ikan',
                    'ready': 'Siap Saji'
                };
                return categories[category] || category;
            }

            function getStarIcons(rating) {
                const stars = [];
                const fullStars = Math.floor(rating);
                const hasHalfStar = rating % 1 >= 0.5;

                for (let i = 1; i <= 5; i++) {
                    if (i <= fullStars) {
                        stars.push('<i class="fas fa-star"></i>');
                    } else if (i === fullStars + 1 && hasHalfStar) {
                        stars.push('<i class="fas fa-star-half-alt"></i>');
                    } else {
                        stars.push('<i class="far fa-star"></i>');
                    }
                }

                return stars.join('');
            }

            function showLoadingResults() {
                const container = document.getElementById('searchResultsContainer');
                const grid = document.getElementById('searchResultsGrid');

                container.classList.add('show');
                grid.innerHTML = `
                    <div class="loading-results">
                        <div class="loading-spinner"></div>
                        <p class="loading-text">Mencari produk...</p>
                    </div>
                `;
            }

            function showSearchNotification(resultCount) {
                let message;
                if (currentSearchQuery && resultCount > 0) {
                    message = `Ditemukan ${resultCount} produk untuk "${currentSearchQuery}"`;
                } else if (currentSearchQuery && resultCount === 0) {
                    message = `Tidak ditemukan produk untuk "${currentSearchQuery}"`;
                } else if (resultCount > 0) {
                    message = `Menampilkan ${resultCount} produk dengan filter`;
                } else {
                    message = 'Tidak ada produk yang sesuai';
                }

                showNotification(message, resultCount > 0 ? 'success' : 'warning');
            }

            function getActiveFilterCount() {
                let count = 0;
                if (currentFilters.priceRange.min > 0 || currentFilters.priceRange.max < 50000) count++;
                if (currentFilters.minRating > 0) count++;
                if (currentFilters.categories.length > 0) count++;
                if (currentFilters.maxDistance < 20) count++;
                return count;
            }

            function clearAll() {
                // Clear input
                document.getElementById('searchInput').value = '';
                currentSearchQuery = '';

                // Reset filters
                currentFilters = {
                    priceRange: { min: 0, max: 50000 },
                    minRating: 0,
                    categories: [],
                    maxDistance: 10
                };

                applyFiltersToUI();
                updateUI();
                showHistory();

                showNotification('Semua pencarian dan filter direset', 'success');
            }

            function closeResults() {
                const container = document.getElementById('searchResultsContainer');
                container.classList.remove('show');
            }

            // Product Actions (placeholder functions)
            function viewProductDetail(productId) {
                console.log('View product detail:', productId);
                showNotification(`Membuka detail produk ${productId}`, 'success');
                // In real implementation, redirect to product detail page
            }

            function addToCart(productId, event) {
                event.stopPropagation();
                console.log('Add to cart:', productId);
                showNotification('Produk ditambahkan ke keranjang', 'success');
                // In real implementation, update cart count via API
            }

            // Notification function
            function showNotification(message, type = 'success') {
                if (typeof window.showNotification === 'function') {
                    window.showNotification(message, type);
                } else {
                    console.log(`${type.toUpperCase()}: ${message}`);

                    // Create a simple notification
                    const notification = document.createElement('div');
                    notification.style.cssText = `
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        background: ${type === 'success' ? '#2ECC71' : '#FF4757'};
                        color: white;
                        padding: 12px 20px;
                        border-radius: 8px;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                        z-index: 9999;
                        animation: slideIn 0.3s ease;
                    `;
                    notification.innerHTML = `
                        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                        <span style="margin-left: 8px;">${message}</span>
                    `;

                    document.body.appendChild(notification);

                    setTimeout(() => {
                        notification.style.animation = 'slideOut 0.3s ease';
                        setTimeout(() => notification.remove(), 300);
                    }, 3000);
                }
            }
        </script>

        <!-- Search History Dropdown -->
        <div class="search-history-dropdown" id="searchHistory">
            <div class="search-history-header">
                <span class="search-history-title">Recent Searches</span>
                <button class="clear-history-btn" onclick="clearSearchHistory()">Clear All</button>
            </div>
            <ul class="search-history-list" id="searchHistoryList">
                <!-- Search history items will be dynamically added here -->
            </ul>
            <div class="search-history-empty" id="emptyHistory">
                <i class="fas fa-clock"></i>
                <p>No recent searches</p>
            </div>
        </div>
    </div>

    <!-- Right Section: Cart and Profile -->
    <div class="navbar-right-section">
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
</div>

<script>
    // ========== SEARCH AND FILTER JAVASCRIPT ==========

    // Local storage key for search history
    const SEARCH_HISTORY_KEY = 'lastbite_search_history';
    const MAX_HISTORY_ITEMS = 10;

    // Current filter state
    let currentFilters = {
        minPrice: 0,
        maxPrice: 100000,
        minRating: 0,
        category: 'all',
        maxDistance: 10
    };

    // Initialize search history
    function initSearchHistory() {
        const history = getSearchHistory();
        updateSearchHistoryDisplay(history);
    }

    // Get search history from localStorage
    function getSearchHistory() {
        const historyJson = localStorage.getItem(SEARCH_HISTORY_KEY);
        return historyJson ? JSON.parse(historyJson) : [];
    }

    // Save search to history
    function saveToSearchHistory(query) {
        let history = getSearchHistory();

        // Remove if already exists
        history = history.filter(item => item.query.toLowerCase() !== query.toLowerCase());

        // Add new search to beginning
        const searchItem = {
            query: query,
            timestamp: new Date().toISOString(),
            timeAgo: 'Just now'
        };

        history.unshift(searchItem);

        // Limit to max items
        if (history.length > MAX_HISTORY_ITEMS) {
            history = history.slice(0, MAX_HISTORY_ITEMS);
        }

        // Update time ago for all items
        history.forEach(updateTimeAgo);

        // Save to localStorage
        localStorage.setItem(SEARCH_HISTORY_KEY, JSON.stringify(history));

        // Update display
        updateSearchHistoryDisplay(history);
    }

    // Update time ago for search items
    function updateTimeAgo(item) {
        const now = new Date();
        const searchTime = new Date(item.timestamp);
        const diffMs = now - searchTime;
        const diffMins = Math.floor(diffMs / (1000 * 60));
        const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
        const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));

        if (diffMins < 1) {
            item.timeAgo = 'Just now';
        } else if (diffMins < 60) {
            item.timeAgo = `${diffMins} ${diffMins === 1 ? 'minute' : 'minutes'} ago`;
        } else if (diffHours < 24) {
            item.timeAgo = `${diffHours} ${diffHours === 1 ? 'hour' : 'hours'} ago`;
        } else {
            item.timeAgo = `${diffDays} ${diffDays === 1 ? 'day' : 'days'} ago`;
        }

        return item;
    }

    // Update search history display
    function updateSearchHistoryDisplay(history) {
        const historyList = document.getElementById('searchHistoryList');
        const emptyHistory = document.getElementById('emptyHistory');
        const historyDropdown = document.getElementById('searchHistory');

        historyList.innerHTML = '';

        if (history.length === 0) {
            emptyHistory.style.display = 'block';
            return;
        }

        emptyHistory.style.display = 'none';

        history.forEach(item => {
            const li = document.createElement('li');
            li.className = 'search-history-item';
            li.innerHTML = `
                <div class="search-history-text">
                    <i class="fas fa-search"></i>
                    <span>${item.query}</span>
                </div>
                <div class="search-history-time">${item.timeAgo}</div>
            `;

            li.addEventListener('click', () => {
                document.getElementById('searchInput').value = item.query;
                performSearch();
            });

            historyList.appendChild(li);
        });
    }

    // Clear all search history
    function clearSearchHistory() {
        if (confirm('Are you sure you want to clear all search history?')) {
            localStorage.removeItem(SEARCH_HISTORY_KEY);
            initSearchHistory();
            showNotification('Search history cleared', 'success');
        }
    }

    // Initialize filter values
    function initFilters() {
        // Price sliders
        const minPriceSlider = document.getElementById('minPriceSlider');
        const maxPriceSlider = document.getElementById('maxPriceSlider');
        const minPriceValue = document.getElementById('minPriceValue');
        const maxPriceValue = document.getElementById('maxPriceValue');

        function formatPrice(price) {
            return 'Rp ' + price.toLocaleString('id-ID');
        }

        function updatePriceValues() {
            const minVal = parseInt(minPriceSlider.value);
            const maxVal = parseInt(maxPriceSlider.value);

            if (minVal > maxVal) {
                minPriceSlider.value = maxVal;
            }

            minPriceValue.textContent = formatPrice(parseInt(minPriceSlider.value));
            maxPriceValue.textContent = formatPrice(parseInt(maxPriceSlider.value));

            currentFilters.minPrice = parseInt(minPriceSlider.value);
            currentFilters.maxPrice = parseInt(maxPriceSlider.value);
        }

        minPriceSlider.addEventListener('input', updatePriceValues);
        maxPriceSlider.addEventListener('input', updatePriceValues);

        updatePriceValues();

        // Rating options
        const ratingOptions = document.querySelectorAll('.rating-option');
        ratingOptions.forEach(option => {
            option.addEventListener('click', function() {
                ratingOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                currentFilters.minRating = parseInt(this.dataset.rating);
            });
        });

        // Category options
        const categoryOptions = document.querySelectorAll('#categoryOptions .filter-option');
        categoryOptions.forEach(option => {
            option.addEventListener('click', function() {
                categoryOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                currentFilters.category = this.dataset.category;
            });
        });

        // Distance options
        const distanceOptions = document.querySelectorAll('.distance-option');
        distanceOptions.forEach(option => {
            option.addEventListener('click', function() {
                distanceOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                currentFilters.maxDistance = parseInt(this.dataset.distance);
            });
        });

        // Reset filters button
        document.getElementById('resetFilters').addEventListener('click', resetFilters);

        // Apply filters button
        document.getElementById('applyFilters').addEventListener('click', applyFilters);
    }

    // Reset all filters to default
    function resetFilters() {
        currentFilters = {
            minPrice: 0,
            maxPrice: 100000,
            minRating: 0,
            category: 'all',
            maxDistance: 10
        };

        // Reset UI
        document.getElementById('minPriceSlider').value = 0;
        document.getElementById('maxPriceSlider').value = 100000;
        document.getElementById('minPriceValue').textContent = 'Rp 0';
        document.getElementById('maxPriceValue').textContent = 'Rp 100.000';

        document.querySelectorAll('.rating-option').forEach(opt => opt.classList.remove('active'));
        document.querySelectorAll('#categoryOptions .filter-option').forEach(opt => {
            opt.classList.remove('active');
            if (opt.dataset.category === 'all') opt.classList.add('active');
        });

        document.querySelectorAll('.distance-option').forEach(opt => {
            opt.classList.remove('active');
            if (opt.dataset.distance === '10') opt.classList.add('active');
        });

        showNotification('Filters reset to default', 'success');
    }

    // Apply filters and close modal
    function applyFilters() {
        closeFilterModal();
        showNotification('Filters applied successfully', 'success');

        // In a real application, you would trigger a search or filter operation here
        console.log('Applied filters:', currentFilters);

        // Example: If there's a search query, perform search with filters
        const searchQuery = document.getElementById('searchInput').value.trim();
        if (searchQuery) {
            performSearchWithFilters(searchQuery, currentFilters);
        }
    }

    // Perform search with current filters
    function performSearchWithFilters(query, filters) {
        // This would be your actual search implementation
        console.log(`Searching for "${query}" with filters:`, filters);

        // Show loading state
        showNotification(`Searching for "${query}" with applied filters...`, 'info');

        // Save to history
        saveToSearchHistory(query);
    }

    // Toggle filter modal
    function toggleFilterModal() {
        const modal = document.getElementById('filterModal');
        const filterToggle = document.getElementById('filterToggle');

        if (modal.classList.contains('active')) {
            closeFilterModal();
        } else {
            openFilterModal();
        }
    }

    function openFilterModal() {
        const modal = document.getElementById('filterModal');
        const filterToggle = document.getElementById('filterToggle');

        modal.classList.add('active');
        filterToggle.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeFilterModal() {
        const modal = document.getElementById('filterModal');
        const filterToggle = document.getElementById('filterToggle');

        modal.classList.remove('active');
        filterToggle.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Enhanced search function
    function performSearch() {
        const query = document.getElementById('searchInput').value.trim();

        if (query) {
            // Check if filters are active
            const filterToggle = document.getElementById('filterToggle');
            const hasActiveFilters = !(currentFilters.minPrice === 0 &&
                                      currentFilters.maxPrice === 100000 &&
                                      currentFilters.minRating === 0 &&
                                      currentFilters.category === 'all' &&
                                      currentFilters.maxDistance === 10);

            if (hasActiveFilters) {
                // Use search with filters
                performSearchWithFilters(query, currentFilters);
            } else {
                // Regular search
                console.log(`Searching for: ${query}`);
                showNotification(`Searching for: ${query}`, 'info');

                // Save to history
                saveToSearchHistory(query);
            }

            // Close search history dropdown
            document.getElementById('searchHistory').classList.remove('active');
            document.getElementById('searchContainer').classList.remove('active');
        } else {
            showNotification('Please enter a search keyword', 'warning');
        }
    }

    // Setup search input events
    function setupSearchInput() {
        const searchInput = document.getElementById('searchInput');
        const searchContainer = document.getElementById('searchContainer');
        const searchHistory = document.getElementById('searchHistory');

        searchInput.addEventListener('focus', function() {
            const history = getSearchHistory();
            if (history.length > 0) {
                searchHistory.classList.add('active');
                searchContainer.classList.add('active');
            }
        });

        searchInput.addEventListener('input', function() {
            if (this.value.trim() === '') {
                searchHistory.classList.remove('active');
                searchContainer.classList.remove('active');
            }
        });

        // Close search history when clicking outside
        document.addEventListener('click', function(event) {
            if (!searchContainer.contains(event.target) &&
                !searchHistory.contains(event.target)) {
                searchHistory.classList.remove('active');
                searchContainer.classList.remove('active');
            }
        });
    }

    // ========== INITIALIZATION ==========
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize search history
        initSearchHistory();

        // Initialize filters
        initFilters();

        // Setup search input
        setupSearchInput();

        // Setup filter toggle
        document.getElementById('filterToggle').addEventListener('click', toggleFilterModal);
        document.getElementById('filterClose').addEventListener('click', closeFilterModal);

        // Close modal when clicking outside
        document.getElementById('filterModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeFilterModal();
            }
        });

        // Search input enter key
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') performSearch();
        });

        // Initialize catalog dropdown
        setupCatalogDropdown();

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbarContainer');
            if (navbar) {
                navbar.classList.toggle('navbar-scrolled', window.scrollY > 50);
            }
        });
    });

    // ========== EXISTING FUNCTIONS ==========
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

    function filterByCategory(category) {
        console.log(`Filtering by category: ${category}`);
        showNotification(`Showing ${category} category items`, 'info');

        // Update search input placeholder
        const searchInput = document.getElementById('searchInput');
        searchInput.placeholder = `Search in ${category}...`;

        // Set category filter
        currentFilters.category = category;

        // Update UI
        document.querySelectorAll('#categoryOptions .filter-option').forEach(opt => {
            opt.classList.remove('active');
            if (opt.dataset.category === category) opt.classList.add('active');
        });

        // Trigger search if there's a query
        const query = searchInput.value.trim();
        if (query) {
            performSearchWithFilters(query, currentFilters);
        }
    }

    function showNotification(message, type = 'success') {
        // Use your existing notification system or create a simple one
        alert(`${type.toUpperCase()}: ${message}`);
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
                    @if (isset($flashSaleProducts) && $flashSaleProducts->count() > 0)
                        @foreach ($flashSaleProducts as $product)
                            <div class="swiper-slide">
                                <div class="product-card"
                                    onclick="window.location.href='{{ route('product.show', $product->id) }}'">
                                    <span class="flash-badge">Flash Sale</span>
                                    <div class="product-image-container">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                            class="product-image">
                                    </div>
                                    <div class="product-info">
                                        <div class="product-brand">
                                            <i class="fas fa-store"></i>
                                            {{ $product->brand }}
                                        </div>
                                        <h3 class="product-name">{{ $product->name }}</h3>
                                        <span class="product-category">{{ ucfirst($product->category) }}</span>
                                        <div class="product-rating">
                                            <div class="stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= floor($product->rating))
                                                        <i class="fas fa-star"></i>
                                                    @elseif($i - 0.5 <= $product->rating)
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span
                                                class="rating-count">({{ number_format($product->rating_count) }})</span>
                                        </div>
                                        <div class="product-price">
                                            <div class="price-container">
                                                <span
                                                    class="current-price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                                <div>
                                                    <span
                                                        class="original-price">Rp{{ number_format($product->original_price, 0, ',', '.') }}</span>
                                                    <span
                                                        class="discount-percent">-{{ $product->discount_percent }}%</span>
                                                </div>
                                            </div>
                                            <button class="add-to-cart-btn"
                                                onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}); event.stopPropagation()">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Fallback jika tidak ada produk -->
                        <div class="swiper-slide">
                            <div class="product-card">
                                <span class="flash-badge">Coming Soon</span>
                                <div class="product-image-container">
                                    <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                                        alt="No Products" class="product-image">
                                </div>
                                <div class="product-info">
                                    <div class="product-brand">
                                        <i class="fas fa-store"></i>
                                        LastBite
                                    </div>
                                    <h3 class="product-name">More Flash Sale Products Coming Soon!</h3>
                                    <span class="product-category">Stay Tuned</span>
                                    <div class="product-rating">
                                        <div class="stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <span class="rating-count">(0)</span>
                                    </div>
                                    <div class="product-price">
                                        <div class="price-container">
                                            <span class="current-price">Check Back Later</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
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

        <div class="content-container">
            <div class="recommended-grid" id="recommendedGrid">
                @foreach ($recommendedProducts as $product)
                    <div class="product-card"
                        onclick="window.location.href='{{ route('product.show', $product->id) }}'">
                        @if ($product->is_flash_sale)
                            <span class="flash-badge">Flash Sale</span>
                        @else
                            <span class="recommended-badge">Recommended</span>
                        @endif
                        <div class="product-image-container">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image">
                        </div>
                        <div class="product-info">
                            <div class="product-brand">
                                <i class="fas fa-store"></i>
                                {{ $product->brand }}
                            </div>
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <span class="product-category">{{ ucfirst($product->category) }}</span>
                            <div class="product-rating">
                                <div class="stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($product->rating))
                                            <i class="fas fa-star"></i>
                                        @elseif($i - 0.5 <= $product->rating)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="rating-count">({{ number_format($product->rating_count) }})</span>
                            </div>
                            <div class="product-price">
                                <div class="price-container">
                                    <span
                                        class="current-price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                    <div>
                                        <span
                                            class="original-price">Rp{{ number_format($product->original_price, 0, ',', '.') }}</span>
                                        <span class="discount-percent">-{{ $product->discount_percent }}%</span>
                                    </div>
                                </div>
                                <button class="add-to-cart-btn"
                                    onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}); event.stopPropagation()">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <script>
        // ========== DASHBOARD JAVASCRIPT ==========
        // Data hero slides dari controller
        const heroSlides = @json($heroSlides ?? []);

        // Categories data
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

        // Default images untuk fallback
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

        // ========== FUNGSI UTAMA ==========

        // Hero Slideshow
        function initializeHeroSlideshow() {
            const heroBanner = document.getElementById('heroBanner');
            const heroDots = document.getElementById('heroDots');

            // Jika tidak ada hero slides, gunakan default
            const slidesToUse = heroSlides.length > 0 ? heroSlides : [{
                image: 'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                tagline: 'Reducing Food Waste, One Bite at a Time',
                title: 'Welcome to LastBite',
                subtitle: 'Fresh Food, Lower Prices',
                description: 'Save money while saving the planet from food waste'
            }];

            // Create slides
            slidesToUse.forEach((slide, index) => {
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
                goToSlide((currentSlide + 1) % slidesToUse.length);
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
            const slidesToUse = heroSlides.length > 0 ? heroSlides : [{
                image: 'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
                tagline: 'Reducing Food Waste, One Bite at a Time',
                title: 'Welcome to LastBite',
                subtitle: 'Fresh Food, Lower Prices',
                description: 'Save money while saving the planet from food waste'
            }];

            const slide = slidesToUse[index];
            const heroContent = document.querySelector('.hero-content');

            if (heroContent) {
                heroContent.innerHTML = `
                <div class="hero-tagline">${slide.tagline}</div>
                <h1 class="hero-title">${slide.title}</h1>
                <div class="hero-subtitle">${slide.subtitle}</div>
                <p class="hero-description">${slide.description}</p>
                <a href="#flash-sale" class="hero-cta">Shop Now</a>
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

        function filterByCategory(category) {
            showNotification(`Filtering by ${categoryNames[category] || category}`, 'info');
            document.getElementById('recommended-foods').scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Flash Sale Swiper
        function initializeFlashSaleSwiper() {
            if (flashSaleSwiper) {
                flashSaleSwiper.destroy();
            }

            const productCount = document.querySelectorAll('#flashSaleProducts .swiper-slide').length;

            // Only initialize swiper if there are multiple products
            if (productCount > 1) {
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

                // Create dots for flash sale
                createFlashSaleDots(productCount);
            } else {
                // Hide navigation if only 1 product
                document.querySelector('.swiper-button-next').style.display = 'none';
                document.querySelector('.swiper-button-prev').style.display = 'none';
            }
        }

        function createFlashSaleDots(numSlides) {
            const dotsContainer = document.getElementById('flashSaleDots');
            dotsContainer.innerHTML = '';

            for (let i = 0; i < numSlides; i++) {
                const dot = document.createElement('div');
                dot.className = `flash-sale-dot ${i === 0 ? 'active' : ''}`;
                dot.dataset.index = i;
                dot.addEventListener('click', () => {
                    if (flashSaleSwiper) {
                        flashSaleSwiper.slideTo(i);
                    }
                });
                dotsContainer.appendChild(dot);
            }
        }

        // Countdown Timer
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

        // Notification function
        function showNotification(message, type = 'success') {
            // Remove existing notification
            const existingNotification = document.querySelector('.notification');
            if (existingNotification) {
                existingNotification.remove();
            }

            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <span>${message}</span>
        `;

            // Add to body
            document.body.appendChild(notification);

            // Show notification
            setTimeout(() => notification.classList.add('show'), 100);

            // Remove after 3 seconds
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 400);
            }, 3000);
        }

        // Initialize Dashboard
        function initializeDashboard() {
            initializeHeroSlideshow();
            renderCategories();
            initializeFlashSaleSwiper();
            updateCountdownTimer();
            updateCartCount();

            console.log('Dashboard initialized successfully');
            console.log('Flash sale products:', document.querySelectorAll('#flashSaleProducts .swiper-slide').length);
            console.log('Recommended products:', document.querySelectorAll('#recommendedGrid .product-card').length);
        }

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
