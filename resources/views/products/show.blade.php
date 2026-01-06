@extends('layouts.buyer')

@section('content')
    <style>
        /* ========== PRODUCT DETAIL STYLES (Dashboard Style) ========== */
        .product-detail-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .breadcrumb {
            color: var(--text-light);
            font-size: 14px;
            margin-bottom: 25px;
            padding: 10px 0;
        }

        .breadcrumb a {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb a:hover {
            color: var(--accent-color);
        }

        /* Product Grid Layout */
        .product-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 60px;
        }

        @media (max-width: 992px) {
            .product-detail-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        }

        /* Product Images - Minimalis */
        .product-image-section {
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .main-product-image {
            width: 100%;
            height: 400px;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 15px;
            box-shadow: var(--shadow-light);
            position: relative;
        }

        .main-product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .main-product-image:hover img {
            transform: scale(1.05);
        }

        .image-badge {
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

        .expiry-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--warning-color, #FF9F1C);
            color: var(--white);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            z-index: 2;
        }

        .thumbnail-list {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 10px 5px;
        }

        .thumbnail {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .thumbnail.active {
            border-color: var(--accent-color);
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Stock Info - Simple */
        .stock-info {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: var(--white);
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 15px;
            box-shadow: var(--shadow-light);
        }

        .stock-info.in-stock {
            color: var(--success-color);
            border: 2px solid var(--success-color);
        }

        .stock-info.low-stock {
            color: var(--danger-color);
            border: 2px solid var(--danger-color);
        }

        .stock-info i {
            font-size: 16px;
        }

        /* Product Info - Clean Layout */
        .product-info-section {
            padding: 10px 0;
        }

        .product-brand {
            color: var(--text-light);
            font-size: 14px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .product-brand i {
            color: var(--primary-color);
        }

        .product-title {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 15px;
            line-height: 1.3;
        }

        /* Description Section - Dipindahkan ke bawah title */
        .description-section {
            margin: 20px 0;
            background: var(--white);
            padding: 20px;
            border-radius: 12px;
            box-shadow: var(--shadow-light);
        }

        .description-content {
            font-size: 15px;
            line-height: 1.6;
            color: var(--text-dark);
        }

        /* Rating - SIMPLE TANPA GRAFIK */
        .rating-simple {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 15px 0;
            padding: 15px;
            background: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow-light);
        }

        .rating-number-simple {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .rating-stars-simple {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .stars-simple {
            color: #FFC107;
            font-size: 18px;
        }

        .rating-count-simple {
            font-size: 14px;
            color: var(--text-light);
        }

        /* Category Badge */
        .category-badge {
            display: inline-block;
            background: rgba(63, 35, 5, 0.08);
            color: var(--primary-color);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* Price Section - RATA KIRI & WARNA GELAP */
        .price-section {
            background: var(--white);
            padding: 25px;
            border-radius: 12px;
            margin: 20px 0;
            box-shadow: var(--shadow-light);
            border: 2px solid var(--accent-color);
        }

        /* Semua elemen harga rata kiri */
        .price-display {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 10px;
        }

        .current-price {
            font-size: 42px;
            font-weight: 800;
            color: var(--danger-color);
            line-height: 1;
        }

        .price-comparison {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .original-price {
            font-size: 20px;
            color: var(--text-dark);
            text-decoration: line-through;
            opacity: 0.7;
        }

        .discount-badge {
            background: var(--success-color);
            color: var(--white);
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 700;
        }

        .price-note {
            font-size: 16px;
            color: var(--text-dark);
            margin-top: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .price-note i {
            color: var(--success-color);
            font-size: 18px;
        }

        /* Action Buttons - DINAIKKAN */
        .action-buttons {
            display: flex;
            gap: 15px;
            margin: 20px 0 30px 0;
        }

        @media (max-width: 576px) {
            .action-buttons {
                flex-direction: column;
            }
        }

        .action-btn {
            flex: 1;
            padding: 16px 24px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-buy {
            background: var(--primary-color);
            color: var(--white);
            box-shadow: 0 4px 15px rgba(63, 35, 5, 0.2);
        }

        .btn-buy:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(63, 35, 5, 0.3);
        }

        .btn-cart {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-cart:hover {
            background: var(--primary-color);
            color: var(--white);
            transform: translateY(-2px);
        }

        /* Benefits - DINAIKKAN */
        .benefits-section {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            box-shadow: var(--shadow-light);
            margin: 0 0 30px 0;
        }

        .benefits-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .benefits-title i {
            color: var(--accent-color);
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        @media (max-width: 768px) {
            .benefits-grid {
                grid-template-columns: 1fr;
            }
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: rgba(63, 35, 5, 0.02);
            border-radius: 10px;
            transition: var(--transition);
        }

        .benefit-item:hover {
            background: rgba(63, 35, 5, 0.05);
            transform: translateX(5px);
        }

        .benefit-icon {
            width: 48px;
            height: 48px;
            background: var(--primary-color);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 20px;
            flex-shrink: 0;
        }

        .benefit-text h4 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--text-dark);
        }

        .benefit-text p {
            font-size: 13px;
            color: var(--text-light);
            line-height: 1.5;
        }

        /* Positive Impact Section - WARNA COKLAT TEMA */
        .positive-impact-section {
            background: linear-gradient(135deg, #B17457, #8B5A3A);
            padding: 40px;
            border-radius: 20px;
            margin: 0 0 30px 0;
            box-shadow: 0 10px 30px rgba(177, 116, 87, 0.3);
            position: relative;
            overflow: hidden;
        }

        .positive-impact-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.1;
        }

        .impact-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        .impact-title {
            font-size: 28px;
            font-weight: 700;
            color: #FAF7F0;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .impact-title i {
            font-size: 32px;
            color: #FF9F1C;
        }

        .impact-subtitle {
            font-size: 16px;
            color: #D8D2C2;
            max-width: 600px;
            margin: 0 auto;
            font-weight: 500;
        }

        .impact-stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 768px) {
            .impact-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .impact-stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .impact-stat-item {
            background: rgba(250, 247, 240, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(216, 210, 194, 0.3);
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            transition: var(--transition);
        }

        .impact-stat-item:hover {
            background: rgba(250, 247, 240, 0.25);
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .impact-stat-icon {
            width: 60px;
            height: 60px;
            background: rgba(216, 210, 194, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 2px solid rgba(216, 210, 194, 0.4);
        }

        .impact-stat-icon i {
            font-size: 24px;
            color: #FAF7F0;
        }

        .impact-stat-value {
            font-size: 32px;
            font-weight: 800;
            color: #FAF7F0;
            margin-bottom: 8px;
            font-family: 'Poppins', sans-serif;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .impact-stat-label {
            font-size: 14px;
            color: #D8D2C2;
            font-weight: 600;
            line-height: 1.4;
        }

        .impact-footer-text {
            text-align: center;
            margin-top: 30px;
            color: #FAF7F0;
            font-size: 16px;
            font-weight: 600;
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .impact-footer-text i {
            color: #FF9F1C;
        }

        /* Recommended Products - Same as Dashboard */
        .recommendations-section {
            margin-top: 60px;
            padding-top: 40px;
            border-top: 2px solid rgba(63, 35, 5, 0.1);
        }

        .section-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 35px;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 80px;
            height: 3px;
            background: var(--accent-color);
            border-radius: 2px;
        }

        .recommendations-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-top: 30px;
        }

        @media (max-width: 1200px) {
            .recommendations-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .recommendations-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .recommendations-grid {
                grid-template-columns: 1fr;
                max-width: 400px;
                margin-left: auto;
                margin-right: auto;
            }
        }

        /* Product Card (Same as Dashboard) */
        .product-card {
            width: 100%;
            background: var(--white);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow-light);
            transition: var(--transition);
            position: relative;
            display: flex;
            flex-direction: column;
            cursor: pointer;
            height: 100%;
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

        .product-info {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            text-align: left;
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

        .current-price-sm {
            font-size: 20px;
            font-weight: 700;
            color: var(--danger-color);
        }

        .original-price-sm {
            font-size: 14px;
            color: var(--text-dark);
            text-decoration: line-through;
            opacity: 0.7;
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

        /* Responsive */
        @media (max-width: 768px) {
            .product-detail-container {
                padding: 0 15px;
            }

            .product-title {
                font-size: 28px;
            }

            .current-price {
                font-size: 36px;
            }

            .main-product-image {
                height: 350px;
            }

            .impact-title {
                font-size: 24px;
            }

            .impact-stat-value {
                font-size: 28px;
            }
        }

        @media (max-width: 576px) {
            .product-title {
                font-size: 24px;
            }

            .current-price {
                font-size: 32px;
            }

            .main-product-image {
                height: 280px;
            }

            .impact-title {
                font-size: 20px;
            }

            .impact-stat-value {
                font-size: 24px;
            }
        }
    </style>

    <div class="product-detail-container">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Home</a> /
            <a href="#">{{ ucfirst($product->category) }}</a> /
            <span>{{ Str::limit($product->name, 30) }}</span>
        </div>

        <!-- Product Detail Grid -->
        <div class="product-detail-grid">
            <!-- Product Images -->
            <div class="product-image-section">
                <div class="main-product-image">
                    @if ($product->is_flash_sale)
                        <span class="image-badge">Flash Sale</span>
                    @elseif($product->discount_percent > 0)
                        <span class="image-badge">Save {{ $product->discount_percent }}%</span>
                    @endif

                    @if ($product->expiry_date)
                        <span class="expiry-badge">Exp: {{ $product->expiry_date->format('d/m') }}</span>
                    @endif

                    <img id="mainImage" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                </div>

                <!-- Thumbnails -->
                <div class="thumbnail-list">
                    <!-- Main image as first thumbnail -->
                    <div class="thumbnail active" onclick="changeImage('{{ $product->image_url }}', this)">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    </div>

                    <!-- Additional thumbnails if available -->
                    @if (isset($product->images) && count($product->images) > 0)
                        @foreach ($product->images as $index => $image)
                            <div class="thumbnail" onclick="changeImage('{{ $image }}', this)">
                                <img src="{{ $image }}" alt="Image {{ $index + 1 }}">
                            </div>
                        @endforeach
                    @else
                        <!-- Generate some extra thumbnails from main image -->
                        @for ($i = 1; $i <= 3; $i++)
                            <div class="thumbnail" onclick="changeImage('{{ $product->image_url }}', this)">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }} {{ $i }}">
                            </div>
                        @endfor
                    @endif
                </div>

                <!-- Stock Info -->
                <div class="stock-info {{ $product->stock > 10 ? 'in-stock' : 'low-stock' }}">
                    <i class="fas fa-{{ $product->stock > 10 ? 'check-circle' : 'exclamation-triangle' }}"></i>
                    @if ($product->stock > 20)
                        <span>In Stock: {{ $product->stock }} units</span>
                    @elseif($product->stock > 10)
                        <span>Limited: {{ $product->stock }} units left</span>
                    @else
                        <span>Low Stock: {{ $product->stock }} units left</span>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="product-info-section">
                <!-- Brand -->
                <div class="product-brand">
                    <i class="fas fa-store"></i>
                    Brand: <strong>{{ $product->brand }}</strong>
                </div>

                <!-- Product Title -->
                <h1 class="product-title">{{ $product->name }}</h1>

                <!-- Category Badge -->
                <div class="category-badge">{{ ucfirst($product->category) }}</div>

                <!-- Description (Dibawah nama produk sesuai permintaan) -->
                <div class="description-section">
                    <div class="description-content">
                        {{ $product->description }}
                    </div>
                </div>

                <!-- Rating SIMPLE (Dibawah deskripsi sesuai permintaan) -->
                <div class="rating-simple">
                    <div class="rating-number-simple">{{ number_format($product->rating, 1) }}</div>
                    <div class="rating-stars-simple">
                        <div class="stars-simple">
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
                        <span class="rating-count-simple">{{ number_format($product->rating_count) }} reviews</span>
                    </div>
                </div>

                <!-- Price Section - RATA KIRI & WARNA GELAP -->
                <div class="price-section">
                    <div class="price-display">
                        <span class="current-price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                        <div class="price-comparison">
                            <span
                                class="original-price">Rp{{ number_format($product->original_price, 0, ',', '.') }}</span>
                            <span class="discount-badge">-{{ $product->discount_percent }}%</span>
                        </div>
                    </div>
                    <div class="price-note">
                        <i class="fas fa-piggy-bank"></i>
                        Save Rp{{ number_format($product->original_price - $product->price, 0, ',', '.') }} compared to
                        retail price
                    </div>
                </div>

                <!-- Action Buttons (DINAIKKAN: setelah harga) -->
                <div class="action-buttons">
                    <button class="action-btn btn-buy" onclick="buyNow({{ $product->id }})">
                        <i class="fas fa-bolt"></i>
                        Buy Now
                    </button>
                    <button class="action-btn btn-cart"
                        onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})">
                        <i class="fas fa-shopping-cart"></i>
                        Add to Cart
                    </button>
                </div>

                <!-- Benefits (DINAIKKAN: setelah button) -->
                <div class="benefits-section">
                    <h3 class="benefits-title">
                        <i class="fas fa-gift"></i>
                        Why Shop With Us
                    </h3>
                    <div class="benefits-grid">
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="benefit-text">
                                <h4>Fast Delivery</h4>
                                <p>Same-day delivery available</p>
                            </div>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="benefit-text">
                                <h4>Quality Guarantee</h4>
                                <p>Fresh and safe products</p>
                            </div>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-recycle"></i>
                            </div>
                            <div class="benefit-text">
                                <h4>Eco Friendly</h4>
                                <p>Reduce food waste</p>
                            </div>
                        </div>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-percent"></i>
                            </div>
                            <div class="benefit-text">
                                <h4>Best Prices</h4>
                                <p>Up to 70% off retail price</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Positive Impact Section (SETELAH Benefits) -->
                <div class="positive-impact-section">
                    <div class="impact-header">
                        <h2 class="impact-title">
                            <i class="fas fa-leaf"></i>
                            Positive Impact of Your Purchase
                        </h2>
                        <p class="impact-subtitle">
                            Every purchase contributes to reducing food waste and saving our planet
                        </p>
                    </div>

                    <div class="impact-stats-grid">
                        <div class="impact-stat-item">
                            <div class="impact-stat-icon">
                                <i class="fas fa-cloud"></i>
                            </div>
                            <div class="impact-stat-value">{{ $impact['co2_saved'] ?? '12.5' }} kg</div>
                            <div class="impact-stat-label">CO₂ Emissions Prevented</div>
                        </div>

                        <div class="impact-stat-item">
                            <div class="impact-stat-icon">
                                <i class="fas fa-tint"></i>
                            </div>
                            <div class="impact-stat-value">{{ $impact['water_saved'] ?? '380' }} L</div>
                            <div class="impact-stat-label">Water Saved</div>
                        </div>

                        <div class="impact-stat-item">
                            <div class="impact-stat-icon">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <div class="impact-stat-value">{{ $impact['food_saved'] ?? '2.5' }} kg</div>
                            <div class="impact-stat-label">Food Waste Reduced</div>
                        </div>
                    </div>

                    <p class="impact-footer-text">
                        <i class="fas fa-heart"></i> Thank you for being part of the solution!
                    </p>
                </div>

            </div>
        </div>

        <!-- Recommended Products -->
        @if ($recommendedProducts && $recommendedProducts->count() > 0)
            <div class="recommendations-section">
                <h3 class="section-title">You May Also Like</h3>
                <div class="recommendations-grid">
                    @foreach ($recommendedProducts as $product)
                        @php
                            // Pastikan kita mengakses sebagai object
                            $productId = is_object($product) ? $product->id : $product['id'];
                            $productName = is_object($product) ? $product->name : $product['name'];
                            $productPrice = is_object($product) ? $product->price : $product['price'];
                            $productOriginalPrice = is_object($product)
                                ? $product->original_price
                                : $product['original_price'];
                            $productDiscountPercent = is_object($product)
                                ? $product->discount_percent
                                : $product['discount_percent'];
                            $productCategory = is_object($product) ? $product->category : $product['category'];
                            $productBrand = is_object($product) ? $product->brand : $product['brand'];
                            $productImageUrl = is_object($product) ? $product->image_url : $product['image_url'];
                            $productRating = is_object($product) ? $product->rating : $product['rating'];
                            $productRatingCount = is_object($product)
                                ? $product->rating_count
                                : $product['rating_count'];
                            $productIsFlashSale = is_object($product)
                                ? $product->is_flash_sale
                                : $product['is_flash_sale'];
                        @endphp

                        <div class="product-card"
                            onclick="window.location.href='{{ route('product.show', $productId) }}'">
                            @if ($productIsFlashSale || $productDiscountPercent >= 20)
                                <span class="flash-badge">Flash Sale</span>
                            @elseif($productDiscountPercent > 0)
                                <span class="recommended-badge">Save {{ $productDiscountPercent }}%</span>
                            @endif

                            <div class="product-image-container">
                                <img src="{{ $productImageUrl }}" alt="{{ $productName }}" class="product-image">
                            </div>

                            <div class="product-info">
                                <h3 class="product-name">{{ Str::limit($productName, 40) }}</h3>
                                <span class="product-category">{{ ucfirst($productCategory) }}</span>

                                <div class="product-rating">
                                    <div class="stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($productRating))
                                                <i class="fas fa-star"></i>
                                            @elseif($i - 0.5 <= $productRating)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="rating-count">({{ number_format($productRatingCount) }})</span>
                                </div>

                                <div class="product-price">
                                    <div class="price-container">
                                        <span
                                            class="current-price-sm">Rp{{ number_format($productPrice, 0, ',', '.') }}</span>
                                        @if ($productOriginalPrice > $productPrice)
                                            <span
                                                class="original-price-sm">Rp{{ number_format($productOriginalPrice, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                    <button class="add-to-cart-btn"
                                        onclick="addToCart({{ $productId }}, '{{ addslashes($productName) }}', {{ $productPrice }}); event.stopPropagation()">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <script>
            // Image Gallery Function
            function changeImage(imageUrl, element) {
                // Update main image
                document.getElementById('mainImage').src = imageUrl;

                // Update active thumbnail
                document.querySelectorAll('.thumbnail').forEach(thumb => {
                    thumb.classList.remove('active');
                });
                element.classList.add('active');
            }

            // Add to Cart Function
            function addToCart(productId, productName, price) {
                // Dapatkan data produk dari elemen yang ada di halaman
                const product = @json($product); // Data dari controller

                // Panggil fungsi global addToCart dengan data lengkap
                window.addToCart(
                    productId,
                    productName,
                    price,
                    product.image_url,
                    product.brand,
                    product.category,
                    product.rating,
                    product.rating_count
                );
            }

            // Buy Now Function
            function buyNow(productId) {
                const product = @json($product);

                // Panggil addToCart dengan parameter lengkap
                window.addToCart(
                    productId,
                    product.name,
                    product.price,
                    product.image_url,
                    product.brand,
                    product.category,
                    product.rating,
                    product.rating_count
                );

                // Redirect to cart page
                setTimeout(() => {
                    window.location.href = '{{ route('cart.index') ?? '/cart' }}';
                }, 500);

                // Update Cart Count
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

                // Show Notification
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

                // Initialize on page load
                document.addEventListener('DOMContentLoaded', function() {
                    updateCartCount();
                });
                // Initialize on page load
                document.addEventListener('DOMContentLoaded', function() {
                    updateCartCount();

                    // JANGAN lupa panggil fungsi navbar jika ada
                    if (typeof initializeNavbar === 'function') {
                        initializeNavbar();
                    }
                });

                // Pastikan tidak ada konflik dengan event navbar
                // Event delegation untuk mencegah konflik
                document.body.addEventListener('click', function(e) {
                    // Jika klik pada elemen product detail, biarkan handler product yang menangani
                    if (e.target.closest('.product-detail-grid') ||
                        e.target.closest('.recommendations-section')) {
                        return;
                    }

                    // Biarkan navbar handler menangani klik navbar
                }, true);

                // ========== FAVORITE FUNCTIONALITY ==========

                // Toggle favorite status
                // Fungsi toggleFavorite yang terintegrasi dengan backend
                async function toggleFavorite(productId) {
                    try {
                        const response = await fetch('/favorites/toggle', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ||
                                    csrfToken
                            },
                            body: JSON.stringify({
                                product_id: productId
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            // Update localStorage untuk konsistensi
                            let favorites = JSON.parse(localStorage.getItem('lastbite_favorites')) || [];

                            if (data.is_favorite) {
                                // Tambah ke localStorage
                                const product = await getProductDetailsFromAPI(productId);
                                if (product) {
                                    product.addedAt = new Date().toISOString();
                                    favorites.push(product);
                                }
                            } else {
                                // Hapus dari localStorage
                                favorites = favorites.filter(p => p.id !== productId);
                            }

                            localStorage.setItem('lastbite_favorites', JSON.stringify(favorites));

                            // Update UI
                            updateFavoriteButtons();
                            showNotification(data.message, 'success');

                            // Dispatch event untuk sinkronisasi
                            window.dispatchEvent(new CustomEvent('favoritesUpdated'));
                        }
                    } catch (error) {
                        console.error('Error toggling favorite:', error);
                        // Fallback ke localStorage jika API gagal
                        toggleFavoriteLocal(productId);
                    }
                }

                // Fungsi fallback menggunakan localStorage
                function toggleFavoriteLocal(productId) {
                    let favorites = JSON.parse(localStorage.getItem('lastbite_favorites')) || [];
                    const existingIndex = favorites.findIndex(p => p.id === productId);

                    if (existingIndex > -1) {
                        // Remove from favorites
                        favorites.splice(existingIndex, 1);
                        showNotification('Removed from favorites', 'info');
                    } else {
                        // Add to favorites
                        const product = getProductDetails(productId);
                        if (product) {
                            product.addedAt = new Date().toISOString();
                            favorites.push(product);
                            showNotification('Added to favorites!', 'success');
                        }
                    }

                    localStorage.setItem('lastbite_favorites', JSON.stringify(favorites));
                    updateFavoriteButtons();
                    window.dispatchEvent(new CustomEvent('favoritesUpdated'));
                }

                // Get product details (implement based on your data structure)
                function getProductDetails(productId) {
                    // This should fetch product details from your data
                    // For now, returning a sample object
                    return {
                        id: productId,
                        name: 'Sample Product',
                        price: 25000,
                        discountedPrice: 20000,
                        discount: 20,
                        category: 'Bakery',
                        description: 'Delicious food item',
                        image: 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w-400',
                        distance: 2.5,
                        expiry: 2
                    };
                }

                // Initialize favorite buttons
                document.addEventListener('DOMContentLoaded', function() {
                    updateFavoriteButtons();

                    // Listen for favorites updates from other pages
                    window.addEventListener('favoritesUpdated', updateFavoriteButtons);
                });
        </script>
    @endsection
