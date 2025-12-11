@extends('layouts.app')

@section('content')
    <style>
        /* ========== CART PAGE STYLES (Dashboard Style) ========== */
        .cart-container {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
            padding: 0;
        }

        @media (max-width: 1300px) {
            .cart-container {
                width: 95%;
            }
        }

        @media (max-width: 768px) {
            .cart-container {
                width: 100%;
                padding: 0 15px;
            }
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

        /* Cart Layout */
        .cart-layout {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
            margin-bottom: 60px;
        }

        @media (max-width: 992px) {
            .cart-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Cart Header */
        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(63, 35, 5, 0.1);
        }

        .cart-title {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .cart-title i {
            color: var(--accent-color);
            font-size: 28px;
        }

        .select-all-container {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            user-select: none;
        }

        .select-all-checkbox {
            width: 20px;
            height: 20px;
            border: 2px solid var(--primary-color);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .select-all-checkbox.selected {
            background-color: var(--primary-color);
            color: var(--white);
        }

        .select-all-checkbox i {
            font-size: 12px;
        }

        .select-all-text {
            font-size: 14px;
            color: var(--text-dark);
            font-weight: 500;
        }

        /* Cart Items */
        .cart-items-container {
            width: 100%;
            background: var(--white);
            border-radius: 15px;
            padding: 25px;
            box-shadow: var(--shadow-light);
            margin-bottom: 30px;
        }

        .cart-item {
            display: flex;
            gap: 20px;
            padding: 25px 0;
            border-bottom: 1px solid rgba(63, 35, 5, 0.08);
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-checkbox {
            width: 20px;
            height: 20px;
            border: 2px solid var(--primary-color);
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 5px;
            transition: var(--transition);
        }

        .cart-item-checkbox.selected {
            background-color: var(--primary-color);
            color: var(--white);
        }

        .cart-item-checkbox i {
            font-size: 12px;
        }

        .cart-item-image {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .cart-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-item-details {
            flex: 1;
            min-width: 0;
        }

        .cart-item-brand {
            font-size: 12px;
            color: var(--text-light);
            margin-bottom: 5px;
        }

        .cart-item-name {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            line-height: 1.4;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .cart-item-desc {
            font-size: 13px;
            color: var(--text-light);
            line-height: 1.5;
            margin-bottom: 12px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .cart-item-meta {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 13px;
            color: var(--text-light);
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .cart-item-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }

        .cart-item-meta i {
            color: var(--accent-color);
        }

        .cart-item-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 10px;
            width: 100%;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(63, 35, 5, 0.05);
            padding: 8px 12px;
            border-radius: 8px;
        }

        .quantity-btn {
            width: 28px;
            height: 28px;
            border: none;
            background: var(--white);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 600;
            color: var(--primary-color);
        }

        .quantity-btn:hover {
            background: var(--primary-color);
            color: var(--white);
            transform: scale(1.1);
        }

        .quantity-value {
            min-width: 30px;
            text-align: center;
            font-weight: 600;
            font-size: 15px;
            color: var(--text-dark);
        }

        .cart-item-price {
            font-size: 18px;
            font-weight: 700;
            color: var(--danger-color);
            white-space: nowrap;
        }

        .remove-item-btn {
            background: transparent;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            padding: 8px;
            transition: var(--transition);
            border-radius: 6px;
            flex-shrink: 0;
        }

        .remove-item-btn:hover {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }

        /* Shopping Cart Summary */
        .cart-summary-container {
            position: sticky;
            top: 100px;
            height: fit-content;
            width: 100%;
        }

        .cart-summary {
            width: 100%;
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            box-shadow: var(--shadow-light);
            border: 2px solid var(--accent-color);
            margin-bottom: 30px;
            box-sizing: border-box;
        }

        .summary-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(63, 35, 5, 0.1);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            width: 100%;
        }

        .summary-label {
            font-size: 15px;
            color: var(--text-dark);
        }

        .summary-value {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid rgba(63, 35, 5, 0.1);
            width: 100%;
        }

        .total-label {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .total-value {
            font-size: 32px;
            font-weight: 800;
            color: var(--danger-color);
        }

        .summary-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 25px;
            width: 100%;
        }

        .summary-btn {
            width: 100%;
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
            box-sizing: border-box;
        }

        .btn-payment {
            background: var(--primary-color);
            color: var(--white);
            box-shadow: 0 4px 15px rgba(63, 35, 5, 0.2);
        }

        .btn-payment:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(63, 35, 5, 0.3);
        }

        .btn-voucher {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-voucher:hover {
            background: var(--primary-color);
            color: var(--white);
            transform: translateY(-2px);
        }

        .checkout-section {
            margin-top: 30px;
            width: 100%;
        }

        .btn-checkout {
            width: 100%;
            padding: 20px;
            background: linear-gradient(135deg, #B17457, #8B5A3A);
            color: var(--white);
            border: none;
            border-radius: 30px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            box-shadow: 0 6px 25px rgba(177, 116, 87, 0.3);
            box-sizing: border-box;
        }

        .btn-checkout:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(177, 116, 87, 0.4);
            background: linear-gradient(135deg, #8B5A3A, #B17457);
        }

        .btn-checkout i {
            font-size: 20px;
        }

        /* Recommended Products */
        .recommendations-section {
            margin-top: 60px;
            padding-top: 40px;
            border-top: 2px solid rgba(63, 35, 5, 0.1);
            width: 100%;
        }

        .recommendations-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
            width: 100%;
        }

        .section-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
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

        .see-more-link {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: var(--transition);
            padding: 8px 16px;
            border-radius: 20px;
            background: rgba(63, 35, 5, 0.05);
        }

        .see-more-link:hover {
            background: rgba(63, 35, 5, 0.1);
            transform: translateX(5px);
            color: var(--primary-dark);
        }

        .see-more-link i {
            font-size: 12px;
            transition: var(--transition);
        }

        .see-more-link:hover i {
            transform: translateX(3px);
        }

        .recommendations-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            width: 100%;
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

            .recommendations-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
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

        /* Product Card */
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
            box-sizing: border-box;
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
            .cart-container {
                width: 100%;
                padding: 0 15px;
            }

            .cart-title {
                font-size: 28px;
            }

            .cart-item {
                flex-direction: column;
                gap: 15px;
            }

            .cart-item-image {
                width: 100%;
                height: 200px;
            }

            .cart-item-actions {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }

        @media (max-width: 576px) {
            .cart-title {
                font-size: 24px;
            }

            .total-value {
                font-size: 28px;
            }

            .section-title {
                font-size: 24px;
            }
        }
    </style>

    <div class="cart-container">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Home</a> /
            <a href="{{ route('cart.index') }}">Your Cart</a>
        </div>

        <!-- Cart Layout -->
        <div class="cart-layout">
            <!-- Left Column - Cart Items -->
            <div class="cart-left-column">
                <!-- Cart Header -->
                <div class="cart-header">
                    <h1 class="cart-title">
                        <i class="fas fa-shopping-cart"></i>
                        Your Cart
                    </h1>

                    <div class="select-all-container" id="selectAll">
                        <div class="select-all-checkbox" id="selectAllCheckbox">
                            <i class="fas fa-check"></i>
                        </div>
                        <span class="select-all-text">Select All (<span id="selectedCount">1</span>)</span>
                    </div>
                </div>

                <!-- Cart Items Container -->
                <div class="cart-items-container" id="cartItemsContainer">
                    <!-- Cart Item 1 - dengan ID yang jelas -->
                    <div class="cart-item" id="cartItem-1" data-item-id="1">
                        <div class="cart-item-checkbox selected" data-item-id="1">
                            <i class="fas fa-check"></i>
                        </div>

                        <div class="cart-item-image">
                            <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Roti Sisir Cream Cheese">
                        </div>

                        <div class="cart-item-details">
                            <div class="cart-item-brand">Holland Bakery</div>
                            <h3 class="cart-item-name">ROTI SISIR CREAM CHEESE</h3>
                            <p class="cart-item-desc">
                                Roti sisir dengan isian 1 pack 4 sisir roti dengan isian cream cheese buatan holland bakery
                                dibuat dengan roti khas prancis dengan cita rasa cream cheese germany
                            </p>

                            <div class="cart-item-meta">
                                <span><i class="fas fa-tag"></i> Bakery</span>
                                <span><i class="fas fa-clock"></i> Exp: 25/12</span>
                                <span><i class="fas fa-star"></i> 4.5 (24 reviews)</span>
                            </div>

                            <div class="cart-item-actions">
                                <div class="quantity-control">
                                    <button class="quantity-btn minus" data-item-id="1" onclick="handleQuantityChange(1, 'minus')">-</button>
                                    <span class="quantity-value" id="quantity-1">1</span>
                                    <button class="quantity-btn plus" data-item-id="1" onclick="handleQuantityChange(1, 'plus')">+</button>
                                </div>

                                <div class="cart-item-price" id="price-1">Rp15,000</div>

                                <button class="remove-item-btn" data-item-id="1" onclick="removeItem(1)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Cart Summary -->
            <div class="cart-summary-container">
                <div class="cart-summary">
                    <h3 class="summary-title">Your Shopping Cart</h3>

                    <div class="summary-row">
                        <span class="summary-label">Subtotal (<span id="subtotalItems">1</span> item<span id="subtotalPlural"></span>)</span>
                        <span class="summary-value" id="subtotal">Rp15,000</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Delivery Fee</span>
                        <span class="summary-value" id="delivery">Rp0</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Service Fee</span>
                        <span class="summary-value" id="service">Rp0</span>
                    </div>

                    <div class="summary-total">
                        <span class="total-label">Total</span>
                        <span class="total-value" id="total">Rp15,000</span>
                    </div>

                    <div class="summary-buttons">
                        <button class="summary-btn btn-payment" id="paymentMethodBtn">
                            <i class="fas fa-credit-card"></i>
                            Payment Method
                        </button>

                        <button class="summary-btn btn-voucher" id="voucherDiscountBtn">
                            <i class="fas fa-ticket-alt"></i>
                            Voucher Discount
                        </button>
                    </div>
                </div>

                <div class="checkout-section">
                    <button class="btn-checkout" id="checkoutBtn">
                        <i class="fas fa-shopping-bag"></i>
                        Check Out (<span id="checkoutCount">1</span>)
                    </button>
                </div>
            </div>
        </div>

        <!-- Recommended Products -->
        <div class="recommendations-section">
            <div class="recommendations-header">
                <h3 class="section-title">Recommended for You</h3>
                <a href="#" class="see-more-link">
                    See more <i class="fas fa-chevron-down"></i>
                </a>
            </div>

            <div class="recommendations-grid">
                <!-- Recommended Product 1 -->
                <div class="product-card">
                    <span class="recommended-badge">Save 25%</span>
                    <div class="product-image-container">
                        <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                             alt="Roti Sisir Holland Bakery" class="product-image">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Roti Sisir Holland Bakery</h3>
                        <span class="product-category">Bakery</span>
                        <div class="product-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <span class="rating-count">(24)</span>
                        </div>
                        <div class="product-price">
                            <div class="price-container">
                                <span class="current-price-sm">Rp15,000</span>
                                <span class="original-price-sm">Rp20,000</span>
                            </div>
                            <button class="add-to-cart-btn" onclick="addToCartFromRecommended(101, 'Roti Sisir Holland Bakery', 15000)">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recommended Product 2 -->
                <div class="product-card">
                    <span class="flash-badge">Flash Sale</span>
                    <div class="product-image-container">
                        <img src="https://images.unsplash.com/photo-1488477181946-6428a0291777?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                             alt="Bread Loaf" class="product-image">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Whole Wheat Bread Loaf</h3>
                        <span class="product-category">Bakery</span>
                        <div class="product-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <span class="rating-count">(31)</span>
                        </div>
                        <div class="product-price">
                            <div class="price-container">
                                <span class="current-price-sm">Rp18,000</span>
                                <span class="original-price-sm">Rp25,000</span>
                            </div>
                            <button class="add-to-cart-btn" onclick="addToCartFromRecommended(102, 'Whole Wheat Bread Loaf', 18000)">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recommended Product 3 -->
                <div class="product-card">
                    <span class="recommended-badge">Save 30%</span>
                    <div class="product-image-container">
                        <img src="https://images.unsplash.com/photo-1565958011703-44f9829ba187?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                             alt="Croissant" class="product-image">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Butter Croissant Premium</h3>
                        <span class="product-category">Pastry</span>
                        <div class="product-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <span class="rating-count">(42)</span>
                        </div>
                        <div class="product-price">
                            <div class="price-container">
                                <span class="current-price-sm">Rp12,000</span>
                                <span class="original-price-sm">Rp17,000</span>
                            </div>
                            <button class="add-to-cart-btn" onclick="addToCartFromRecommended(103, 'Butter Croissant Premium', 12000)">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recommended Product 4 -->
                <div class="product-card">
                    <span class="recommended-badge">Save 20%</span>
                    <div class="product-image-container">
                        <img src="https://images.unsplash.com/photo-1558961363-fa8fdf82db35?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                             alt="Bagel" class="product-image">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Everything Bagel with Cream</h3>
                        <span class="product-category">Bagel</span>
                        <div class="product-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="rating-count">(37)</span>
                        </div>
                        <div class="product-price">
                            <div class="price-container">
                                <span class="current-price-sm">Rp14,000</span>
                                <span class="original-price-sm">Rp17,500</span>
                            </div>
                            <button class="add-to-cart-btn" onclick="addToCartFromRecommended(104, 'Everything Bagel with Cream', 14000)">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global cart data
        let cartItems = [
            {
                id: 1,
                name: "ROTI SISIR CREAM CHEESE",
                price: 15000,
                quantity: 1,
                selected: true,
                brand: "Holland Bakery",
                image: "https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80",
                category: "Bakery",
                expiry: "25/12",
                rating: "4.5 (24 reviews)"
            }
        ];

        // Update selected count text
        function updateSelectedCount() {
            const selectedItems = cartItems.filter(item => item.selected);
            const selectedCount = selectedItems.length;

            // Update "Select All" text
            document.getElementById('selectedCount').textContent = selectedCount;

            // Update subtotal items text
            const totalItems = selectedItems.reduce((total, item) => total + item.quantity, 0);
            document.getElementById('subtotalItems').textContent = totalItems;

            // Update plural "s"
            document.getElementById('subtotalPlural').textContent = totalItems > 1 ? 's' : '';

            // Update checkout count
            document.getElementById('checkoutCount').textContent = totalItems;

            // Update select all checkbox state
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            if (selectedCount > 0 && selectedCount === cartItems.length) {
                selectAllCheckbox.classList.add('selected');
            } else {
                selectAllCheckbox.classList.remove('selected');
            }

            return totalItems;
        }

        // Calculate total
        function calculateTotal() {
            let subtotal = 0;
            let totalItems = 0;

            cartItems.forEach(item => {
                if (item.selected) {
                    subtotal += item.price * item.quantity;
                    totalItems += item.quantity;
                }
            });

            // Update subtotal text
            document.getElementById('subtotal').textContent = `Rp${subtotal.toLocaleString('id-ID')}`;
            document.getElementById('total').textContent = `Rp${subtotal.toLocaleString('id-ID')}`;

            return { subtotal, totalItems };
        }

        // Update all UI elements
        function updateAllUI() {
            console.log('Updating UI...');
            console.log('Cart items:', cartItems);

            const totalItems = updateSelectedCount();
            const { subtotal } = calculateTotal();

            // Update subtotal label
            document.getElementById('subtotalItems').textContent = totalItems;
            document.getElementById('subtotalPlural').textContent = totalItems > 1 ? 's' : '';

            // Update checkout button
            document.getElementById('checkoutCount').textContent = totalItems;

            console.log('UI updated. Total items:', totalItems);
        }

        // REVISI FIX: Handle quantity change - URUT 1, 2, 3, dst
        function handleQuantityChange(itemId, action) {
            console.log(`Quantity change: Item ${itemId}, Action: ${action}`);

            const item = cartItems.find(item => item.id === itemId);
            if (!item) {
                console.error(`Item with id ${itemId} not found`);
                return;
            }

            console.log(`Before change - Quantity: ${item.quantity}`);

            if (action === 'plus') {
                // REVISI: Hanya tambah 1, tidak langsung ke 3 atau 5
                item.quantity += 1;
                console.log(`After plus - New quantity: ${item.quantity}`);
            } else if (action === 'minus') {
                if (item.quantity > 1) {
                    item.quantity -= 1;
                    console.log(`After minus - New quantity: ${item.quantity}`);
                }
            }

            // Update quantity display
            const quantityElement = document.getElementById(`quantity-${itemId}`);
            if (quantityElement) {
                quantityElement.textContent = item.quantity;
                console.log(`Updated quantity display to: ${item.quantity}`);

                // Animation
                quantityElement.style.transform = 'scale(1.2)';
                quantityElement.style.color = action === 'plus' ? 'var(--primary-color)' : 'var(--danger-color)';
                setTimeout(() => {
                    quantityElement.style.transform = '';
                    quantityElement.style.color = '';
                }, 300);
            }

            // Update price display
            const priceElement = document.getElementById(`price-${itemId}`);
            if (priceElement) {
                const newPrice = item.price * item.quantity;
                priceElement.textContent = `Rp${newPrice.toLocaleString('id-ID')}`;
                console.log(`Updated price display to: Rp${newPrice}`);
            }

            // Update UI
            updateAllUI();
        }

        // Remove item
        function removeItem(itemId) {
            if (confirm('Are you sure you want to remove this item from your cart?')) {
                const itemElement = document.getElementById(`cartItem-${itemId}`);
                if (itemElement) {
                    itemElement.style.opacity = '0';
                    itemElement.style.transform = 'translateX(-20px)';

                    setTimeout(() => {
                        itemElement.remove();
                        const itemIndex = cartItems.findIndex(item => item.id === itemId);
                        if (itemIndex !== -1) {
                            cartItems.splice(itemIndex, 1);
                        }

                        updateAllUI();
                    }, 300);
                }
            }
        }

        // Add to cart from recommended products
        function addToCartFromRecommended(productId, productName, productPrice) {
            console.log(`Adding to cart: ${productName}, ID: ${productId}, Price: ${productPrice}`);

            // Cek apakah produk sudah ada di cart
            const existingItemIndex = cartItems.findIndex(item => item.id === productId);

            if (existingItemIndex !== -1) {
                // Jika sudah ada, tambah quantity 1
                cartItems[existingItemIndex].quantity += 1;
                console.log(`Item already exists. New quantity: ${cartItems[existingItemIndex].quantity}`);

                // Update quantity di UI jika item ada di tampilan
                const quantityElement = document.getElementById(`quantity-${productId}`);
                if (quantityElement) {
                    quantityElement.textContent = cartItems[existingItemIndex].quantity;
                }

                // Update price di UI
                const priceElement = document.getElementById(`price-${productId}`);
                if (priceElement) {
                    const newPrice = cartItems[existingItemIndex].price * cartItems[existingItemIndex].quantity;
                    priceElement.textContent = `Rp${newPrice.toLocaleString('id-ID')}`;
                }
            } else {
                // Jika belum ada, tambah item baru dengan quantity 1
                const newItemId = cartItems.length > 0 ? Math.max(...cartItems.map(item => item.id)) + 1 : 2;

                // Data produk baru
                const newItem = {
                    id: productId,
                    name: productName,
                    price: productPrice,
                    quantity: 1, // SELALU DIMULAI DARI 1
                    selected: true,
                    brand: "Recommended Product",
                    image: event.target.closest('.product-card').querySelector('.product-image').src,
                    category: event.target.closest('.product-info').querySelector('.product-category').textContent,
                    expiry: "28/12",
                    rating: "4.0 (10 reviews)"
                };

                cartItems.push(newItem);
                console.log(`Added new item. Total items in cart: ${cartItems.length}`);

                // Buat elemen cart item baru
                const newCartItem = createCartItemElement(newItem);
                document.getElementById('cartItemsContainer').appendChild(newCartItem);
            }

            // Show success notification
            showNotification(`${productName} added to cart!`, 'success');

            // Update UI
            updateAllUI();

            // Button animation
            event.target.style.transform = 'scale(1.2) rotate(360deg)';
            event.target.style.backgroundColor = 'var(--success-color)';
            setTimeout(() => {
                event.target.style.transform = '';
                event.target.style.backgroundColor = '';
            }, 500);
        }

        // Function to create cart item element
        function createCartItemElement(item) {
            const cartItem = document.createElement('div');
            cartItem.className = 'cart-item';
            cartItem.id = `cartItem-${item.id}`;
            cartItem.dataset.itemId = item.id;

            cartItem.innerHTML = `
                <div class="cart-item-checkbox selected" data-item-id="${item.id}" onclick="toggleItemSelection(${item.id})">
                    <i class="fas fa-check"></i>
                </div>

                <div class="cart-item-image">
                    <img src="${item.image}" alt="${item.name}">
                </div>

                <div class="cart-item-details">
                    <div class="cart-item-brand">${item.brand}</div>
                    <h3 class="cart-item-name">${item.name}</h3>
                    <p class="cart-item-desc">
                        Produk rekomendasi berkualitas tinggi dengan harga terjangkau.
                    </p>

                    <div class="cart-item-meta">
                        <span><i class="fas fa-tag"></i> ${item.category}</span>
                        <span><i class="fas fa-clock"></i> Exp: ${item.expiry}</span>
                        <span><i class="fas fa-star"></i> ${item.rating}</span>
                    </div>

                    <div class="cart-item-actions">
                        <div class="quantity-control">
                            <button class="quantity-btn minus" data-item-id="${item.id}" onclick="handleQuantityChange(${item.id}, 'minus')">-</button>
                            <span class="quantity-value" id="quantity-${item.id}">${item.quantity}</span>
                            <button class="quantity-btn plus" data-item-id="${item.id}" onclick="handleQuantityChange(${item.id}, 'plus')">+</button>
                        </div>

                        <div class="cart-item-price" id="price-${item.id}">Rp${(item.price * item.quantity).toLocaleString('id-ID')}</div>

                        <button class="remove-item-btn" data-item-id="${item.id}" onclick="removeItem(${item.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;

            return cartItem;
        }

        // Toggle item selection
        function toggleItemSelection(itemId) {
            const item = cartItems.find(item => item.id === itemId);
            if (item) {
                item.selected = !item.selected;

                const checkbox = document.querySelector(`.cart-item-checkbox[data-item-id="${itemId}"]`);
                if (checkbox) {
                    checkbox.classList.toggle('selected');
                }

                updateAllUI();
            }
        }

        // Select all functionality
        document.getElementById('selectAll').addEventListener('click', function() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const isAllSelected = selectAllCheckbox.classList.contains('selected');
            const newState = !isAllSelected;

            // Update all checkboxes
            document.querySelectorAll('.cart-item-checkbox').forEach(checkbox => {
                if (newState) {
                    checkbox.classList.add('selected');
                } else {
                    checkbox.classList.remove('selected');
                }

                // Update cart data
                const itemId = checkbox.dataset.itemId;
                const item = cartItems.find(item => item.id == itemId);
                if (item) item.selected = newState;
            });

            // Update checkbox state
            selectAllCheckbox.classList.toggle('selected');

            // Update UI
            updateAllUI();
        });

        // Payment Method Button
        document.getElementById('paymentMethodBtn').addEventListener('click', function() {
            alert('Payment method module will be implemented later');
        });

        // Voucher Discount Button
        document.getElementById('voucherDiscountBtn').addEventListener('click', function() {
            alert('Voucher discount module will be implemented later');
        });

        // Checkout Button
        document.getElementById('checkoutBtn').addEventListener('click', function() {
            const selectedItems = cartItems.filter(item => item.selected);

            if (selectedItems.length === 0) {
                alert('Please select at least one item to checkout');
                return;
            }

            alert('Checkout successful! Your order has been placed.');
        });

        // Notification function
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = 'cart-notification';
            notification.innerHTML = `
                <div class="notification-content ${type}">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;

            notification.style.cssText = `
                position: fixed;
                top: 100px;
                right: 20px;
                z-index: 9999;
                animation: slideIn 0.3s ease;
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 300);
            }, 3000);
        }

        // Add CSS for notification animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
            .cart-notification .notification-content {
                background: var(--white);
                padding: 15px 25px;
                border-radius: 10px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.15);
                display: flex;
                align-items: center;
                gap: 12px;
                font-weight: 500;
            }
            .cart-notification .notification-content.success {
                border-left: 4px solid var(--success-color);
                color: var(--text-dark);
            }
            .cart-notification .notification-content.success i {
                color: var(--success-color);
            }
        `;
        document.head.appendChild(style);

        // "See More" link functionality
        document.querySelector('.see-more-link').addEventListener('click', function(e) {
            e.preventDefault();
            alert('See more recommended products functionality will be implemented later');
        });

        // Initialize UI
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Cart initialized');
            updateAllUI();
        });
    </script>
@endsection