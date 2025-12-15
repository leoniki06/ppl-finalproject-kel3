@extends('layouts.app')

@section('content')
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
                                                onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ addslashes($product->image_url) }}', '{{ addslashes($product->brand) }}', '{{ addslashes($product->category) }}', {{ $product->rating }}, {{ $product->rating_count }}); event.stopPropagation()">
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
                @if (isset($recommendedProducts) && count($recommendedProducts) > 0)
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
                                        onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ addslashes($product->image_url) }}', '{{ addslashes($product->brand) }}', '{{ addslashes($product->category) }}', {{ $product->rating }}, {{ $product->rating_count }}); event.stopPropagation()">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Fallback jika tidak ada recommended products -->
                    <div class="product-card">
                        <span class="recommended-badge">Recommended</span>
                        <div class="product-image-container">
                            <img src="https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                                alt="No Products" class="product-image">
                        </div>
                        <div class="product-info">
                            <div class="product-brand">
                                <i class="fas fa-store"></i>
                                LastBite
                            </div>
                            <h3 class="product-name">More Recommended Products Coming Soon!</h3>
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
                @endif
            </div>
        </div>
    </section>

    <script>
        // ========== DASHBOARD JAVASCRIPT ==========
        // Data hero slides dari controller
        const heroSlides = @json($heroSlides ?? []);

        // Data produk dummy langsung di JavaScript
        const dummyProducts = {
            flashSale: [{
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
                    is_flash_sale: true
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
                    is_flash_sale: true
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
                    is_flash_sale: true
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
                    is_flash_sale: true
                }
            ],
            recommended: [{
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
                    is_flash_sale: false
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
                    is_flash_sale: false
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
                    is_flash_sale: false
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
                    is_flash_sale: false
                },
                {
                    id: 9,
                    name: 'Salmon Fillet (250g)',
                    brand: 'Ocean Fresh',
                    category: 'meat',
                    price: 55000,
                    original_price: 75000,
                    discount_percent: 27,
                    rating: 4.9,
                    rating_count: 189,
                    image_url: 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    is_flash_sale: false
                },
                {
                    id: 10,
                    name: 'Mixed Berries (500g)',
                    brand: 'Berry Best',
                    category: 'fruits',
                    price: 45000,
                    original_price: 60000,
                    discount_percent: 25,
                    rating: 4.8,
                    rating_count: 123,
                    image_url: 'https://images.unsplash.com/photo-1488459716781-31db52582fe9?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    is_flash_sale: false
                },
                {
                    id: 11,
                    name: 'Cheddar Cheese Block (200g)',
                    brand: 'Kraft',
                    category: 'dairy',
                    price: 38000,
                    original_price: 52000,
                    discount_percent: 27,
                    rating: 4.5,
                    rating_count: 87,
                    image_url: 'https://images.unsplash.com/photo-1552767059-ce182ead6c1b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    is_flash_sale: false
                },
                {
                    id: 12,
                    name: 'Whole Chicken (1.5kg)',
                    brand: 'Farm Fresh',
                    category: 'meat',
                    price: 75000,
                    original_price: 95000,
                    discount_percent: 21,
                    rating: 4.7,
                    rating_count: 112,
                    image_url: 'https://images.unsplash.com/photo-1602476524182-2cf6586b1021?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                    is_flash_sale: false
                }
            ]
        };

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

        // Render Flash Sale Products
        function renderFlashSaleProducts() {
            const flashSaleContainer = document.getElementById('flashSaleProducts');

            // Clear existing content
            flashSaleContainer.innerHTML = '';

            // Add dummy products
            dummyProducts.flashSale.forEach(product => {
                const productHTML = `
                <div class="swiper-slide">
                    <div class="product-card" onclick="viewProductDetail(${product.id})">
                        <span class="flash-badge">Flash Sale</span>
                        <div class="product-image-container">
                            <img src="${product.image_url}" alt="${product.name}" class="product-image">
                        </div>
                        <div class="product-info">
                            <div class="product-brand">
                                <i class="fas fa-store"></i>
                                ${product.brand}
                            </div>
                            <h3 class="product-name">${product.name}</h3>
                            <span class="product-category">${product.category.charAt(0).toUpperCase() + product.category.slice(1)}</span>
                            <div class="product-rating">
                                <div class="stars">
                                    ${generateStars(product.rating)}
                                </div>
                                <span class="rating-count">(${product.rating_count})</span>
                            </div>
                            <div class="product-price">
                                <div class="price-container">
                                    <span class="current-price">Rp${formatPrice(product.price)}</span>
                                    <div>
                                        <span class="original-price">Rp${formatPrice(product.original_price)}</span>
                                        <span class="discount-percent">-${product.discount_percent}%</span>
                                    </div>
                                </div>
                                <button class="add-to-cart-btn"
                                    onclick="addToCart(${product.id}, '${product.name.replace(/'/g, "\\'")}', ${product.price}, '${product.image_url.replace(/'/g, "\\'")}', '${product.brand.replace(/'/g, "\\'")}', '${product.category.replace(/'/g, "\\'")}', ${product.rating}, ${product.rating_count}); event.stopPropagation()">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
                flashSaleContainer.innerHTML += productHTML;
            });
        }

        // Render Recommended Products
        function renderRecommendedProducts() {
            const recommendedGrid = document.getElementById('recommendedGrid');

            // Clear existing content
            recommendedGrid.innerHTML = '';

            // Add dummy products
            dummyProducts.recommended.forEach(product => {
                const productHTML = `
                <div class="product-card" onclick="viewProductDetail(${product.id})">
                    ${product.is_flash_sale ?
                        '<span class="flash-badge">Flash Sale</span>' :
                        '<span class="recommended-badge">Recommended</span>'}
                    <div class="product-image-container">
                        <img src="${product.image_url}" alt="${product.name}" class="product-image">
                    </div>
                    <div class="product-info">
                        <div class="product-brand">
                            <i class="fas fa-store"></i>
                            ${product.brand}
                        </div>
                        <h3 class="product-name">${product.name}</h3>
                        <span class="product-category">${product.category.charAt(0).toUpperCase() + product.category.slice(1)}</span>
                        <div class="product-rating">
                            <div class="stars">
                                ${generateStars(product.rating)}
                            </div>
                            <span class="rating-count">(${product.rating_count})</span>
                        </div>
                        <div class="product-price">
                            <div class="price-container">
                                <span class="current-price">Rp${formatPrice(product.price)}</span>
                                <div>
                                    <span class="original-price">Rp${formatPrice(product.original_price)}</span>
                                    <span class="discount-percent">-${product.discount_percent}%</span>
                                </div>
                            </div>
                            <button class="add-to-cart-btn"
                                onclick="addToCart(${product.id}, '${product.name.replace(/'/g, "\\'")}', ${product.price}, '${product.image_url.replace(/'/g, "\\'")}', '${product.brand.replace(/'/g, "\\'")}', '${product.category.replace(/'/g, "\\'")}', ${product.rating}, ${product.rating_count}); event.stopPropagation()">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
                recommendedGrid.innerHTML += productHTML;
            });
        }

        // View Product Detail
        function viewProductDetail(productId) {
            // Redirect to product detail page
            window.location.href = `/product/${productId}`;
        }

        // Helper function to generate stars
        function generateStars(rating) {
            let starsHTML = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= Math.floor(rating)) {
                    starsHTML += '<i class="fas fa-star"></i>';
                } else if (i - 0.5 <= rating) {
                    starsHTML += '<i class="fas fa-star-half-alt"></i>';
                } else {
                    starsHTML += '<i class="far fa-star"></i>';
                }
            }
            return starsHTML;
        }

        // Helper function to format price
        function formatPrice(price) {
            return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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

        function addToCart(productId, productName, price, image_url, brand, category, rating, rating_count) {
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
                        image_url: image_url,
                        brand: brand,
                        category: category,
                        rating: rating,
                        rating_count: rating_count,
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

            const productCount = dummyProducts.flashSale.length;

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

            // Only render dummy products if no server-side products exist
            if (!document.getElementById('flashSaleProducts').innerHTML.trim()) {
                renderFlashSaleProducts();
            }

            if (!document.getElementById('recommendedGrid').innerHTML.trim() ||
                document.getElementById('recommendedGrid').innerHTML.includes('Coming Soon')) {
                renderRecommendedProducts();
            }

            initializeFlashSaleSwiper();
            updateCountdownTimer();
            updateCartCount();

            console.log('Dashboard initialized successfully');
        }

        // Initialize when DOM is loaded
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeDashboard);
        } else {
            initializeDashboard();
        }
    </script>
@endsection
