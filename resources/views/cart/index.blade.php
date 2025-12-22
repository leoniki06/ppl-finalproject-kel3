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
            cursor: pointer;
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

        /* ========== MODAL STYLES ========== */
        .payment-modal .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: var(--shadow-medium);
            overflow: hidden;
        }

        .payment-modal .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            padding: 25px 30px;
            border-bottom: none;
            border-radius: 20px 20px 0 0;
        }

        .payment-modal .modal-title {
            font-weight: 600;
            font-size: 22px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .payment-modal .modal-body {
            padding: 30px;
        }

        .payment-method-container {
            margin-bottom: 30px;
        }

        .payment-method-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .payment-methods {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .payment-method {
            border: 2px solid rgba(63, 35, 5, 0.1);
            border-radius: 12px;
            padding: 20px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
        }

        .payment-method:hover {
            border-color: var(--primary-color);
            background: rgba(63, 35, 5, 0.02);
        }

        .payment-method.selected {
            border-color: var(--primary-color);
            background: rgba(63, 35, 5, 0.05);
        }

        .payment-method-radio {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .payment-method-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
            flex-shrink: 0;
        }

        .payment-method-icon.cash {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .payment-method-icon.ewallet {
            background: linear-gradient(135deg, #007bff, #6610f2);
        }

        .payment-method-icon.qris {
            background: linear-gradient(135deg, #ff6b6b, #ff8e53);
        }

        .payment-method-details {
            flex: 1;
        }

        .payment-method-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .payment-method-desc {
            font-size: 13px;
            color: var(--text-light);
        }

        .voucher-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(63, 35, 5, 0.1);
        }

        .voucher-input-group {
            display: flex;
            gap: 10px;
        }

        .voucher-input {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid rgba(63, 35, 5, 0.1);
            border-radius: 10px;
            font-size: 15px;
            transition: var(--transition);
        }

        .voucher-input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .apply-voucher-btn {
            padding: 12px 24px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .apply-voucher-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .voucher-message {
            margin-top: 10px;
            font-size: 14px;
            min-height: 20px;
        }

        .voucher-success {
            color: #28a745;
        }

        .voucher-error {
            color: #dc3545;
        }

        .payment-summary {
            background: var(--bg-light);
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        .payment-summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .payment-summary-total {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid rgba(63, 35, 5, 0.1);
            font-weight: 700;
            font-size: 18px;
            color: var(--primary-color);
        }

        /* Voucher Modal Styles */
        .voucher-modal .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: var(--shadow-medium);
        }

        .voucher-modal .modal-header {
            background: linear-gradient(135deg, #ff9f1c, #ff6b6b);
            color: white;
            padding: 25px 30px;
            border-bottom: none;
            border-radius: 20px 20px 0 0;
        }

        .voucher-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: var(--shadow-light);
            margin-bottom: 20px;
            border: 2px solid transparent;
            transition: var(--transition);
            cursor: pointer;
        }

        .voucher-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
            border-color: var(--accent-color);
        }

        .voucher-card.selected {
            border-color: var(--accent-color);
            background: rgba(255, 159, 28, 0.05);
        }

        .voucher-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .voucher-code {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            color: var(--primary-color);
            background: rgba(63, 35, 5, 0.05);
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
        }

        .voucher-discount {
            font-size: 24px;
            font-weight: 800;
            color: #28a745;
        }

        .voucher-title {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .voucher-desc {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 15px;
        }

        .voucher-validity {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-light);
        }

        /* Checkout Page Styles */
        .checkout-container {
            width: 90%;
            max-width: 800px;
            margin: 30px auto;
        }

        .checkout-steps {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            position: relative;
        }

        .checkout-steps::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 50px;
            right: 50px;
            height: 2px;
            background: rgba(63, 35, 5, 0.1);
            z-index: 1;
        }

        .checkout-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            flex: 1;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 2px solid rgba(63, 35, 5, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: 10px;
            transition: var(--transition);
        }

        .step-number.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .step-number.completed {
            background: var(--accent-color);
            color: white;
            border-color: var(--accent-color);
        }

        .step-label {
            font-size: 14px;
            color: var(--text-light);
            font-weight: 500;
        }

        .step-label.active {
            color: var(--primary-color);
            font-weight: 600;
        }

        .address-section {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            box-shadow: var(--shadow-light);
            margin-bottom: 30px;
        }

        .address-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .address-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .change-address-btn {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }

        .change-address-btn:hover {
            background: var(--primary-color);
            color: white;
        }

        .address-details {
            padding: 20px;
            background: var(--bg-light);
            border-radius: 10px;
            border-left: 4px solid var(--primary-color);
        }

        .address-name {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--text-dark);
        }

        .address-text {
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .address-phone {
            color: var(--text-dark);
            font-weight: 500;
        }

        .order-summary-section {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            box-shadow: var(--shadow-light);
        }

        .order-items {
            margin-bottom: 25px;
        }

        .order-item {
            display: flex;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(63, 35, 5, 0.05);
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .order-item-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .order-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .order-item-details {
            flex: 1;
        }

        .order-item-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .order-item-price {
            color: var(--danger-color);
            font-weight: 600;
        }

        .order-item-quantity {
            color: var(--text-light);
            font-size: 14px;
        }

        .order-summary {
            border-top: 2px solid rgba(63, 35, 5, 0.1);
            padding-top: 20px;
        }

        .order-summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .order-summary-total {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid rgba(63, 35, 5, 0.1);
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .confirm-payment-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #B17457, #8B5A3A);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .confirm-payment-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(177, 116, 87, 0.4);
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

            .payment-method {
                flex-direction: column;
                align-items: flex-start;
            }

            .voucher-input-group {
                flex-direction: column;
            }

            .checkout-steps {
                flex-wrap: wrap;
                gap: 20px;
            }

            .checkout-steps::before {
                display: none;
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

            .modal-body {
                padding: 20px;
            }
        }
    </style>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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
                        <span class="select-all-text">Select All (<span id="selectedCount">0</span>)</span>
                    </div>
                </div>

                <!-- Cart Items Container -->
                <div class="cart-items-container" id="cartItemsContainer">
                    <!-- Cart items will be rendered here by JavaScript -->
                </div>
            </div>

            <!-- Right Column - Cart Summary -->
            <div class="cart-summary-container">
                <div class="cart-summary">
                    <h3 class="summary-title">Your Shopping Cart</h3>

                    <div class="summary-row">
                        <span class="summary-label">Subtotal (<span id="subtotalItems">0</span> item<span
                                id="subtotalPlural">s</span>)</span>
                        <span class="summary-value" id="subtotal">Rp0</span>
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
                        <span class="total-value" id="total">Rp0</span>
                    </div>

                    <div class="summary-buttons">
                        <button class="summary-btn btn-payment" id="paymentMethodBtn" data-bs-toggle="modal"
                            data-bs-target="#paymentModal">
                            <i class="fas fa-credit-card"></i>
                            Payment Method
                        </button>

                        <button class="summary-btn btn-voucher" id="voucherDiscountBtn" data-bs-toggle="modal"
                            data-bs-target="#voucherModal">
                            <i class="fas fa-ticket-alt"></i>
                            Voucher Discount
                        </button>
                    </div>
                </div>

                <div class="checkout-section">
                    <button class="btn-checkout" id="checkoutBtn">
                        <i class="fas fa-shopping-bag"></i>
                        Check Out (<span id="checkoutCount">0</span>)
                    </button>
                </div>
            </div>
        </div>

        <!-- Recommended Products -->
        <div class="recommendations-section">
            <div class="recommendations-header">
                <h3 class="section-title">Recommended for You</h3>
                <a href="{{ route('dashboard') }}" class="see-more-link">
                    See more <i class="fas fa-chevron-down"></i>
                </a>
            </div>

            @if ($recommendedProducts && $recommendedProducts->count() > 0)
                <div class="recommendations-grid">
                    @foreach ($recommendedProducts as $recProduct)
                        <div class="product-card"
                            onclick="window.location.href='{{ route('product.show', $recProduct->id) }}'">
                            @if ($recProduct->is_flash_sale || $recProduct->discount_percent >= 20)
                                <span class="flash-badge">Flash Sale</span>
                            @elseif($recProduct->discount_percent > 0)
                                <span class="recommended-badge">Save {{ $recProduct->discount_percent }}%</span>
                            @endif

                            <div class="product-image-container">
                                <img src="{{ $recProduct->image_url }}" alt="{{ $recProduct->name }}" class="product-image">
                            </div>

                            <div class="product-info">
                                <h3 class="product-name">{{ Str::limit($recProduct->name, 40) }}</h3>
                                <span class="product-category">{{ ucfirst($recProduct->category) }}</span>

                                <div class="product-rating">
                                    <div class="stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($recProduct->rating))
                                                <i class="fas fa-star"></i>
                                            @elseif($i - 0.5 <= $recProduct->rating)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="rating-count">({{ number_format($recProduct->rating_count) }})</span>
                                </div>

                                <div class="product-price">
                                    <div class="price-container">
                                        <span
                                            class="current-price-sm">Rp{{ number_format($recProduct->price, 0, ',', '.') }}</span>
                                        @if ($recProduct->original_price > $recProduct->price)
                                            <span
                                                class="original-price-sm">Rp{{ number_format($recProduct->original_price, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                    <button class="add-to-cart-btn"
                                        onclick="addToCartFromRecommended(event, {{ $recProduct->id }}, '{{ addslashes($recProduct->name) }}', {{ $recProduct->price }}, '{{ addslashes($recProduct->image_url) }}', '{{ addslashes($recProduct->brand) }}', '{{ addslashes($recProduct->category) }}', {{ $recProduct->rating }}, {{ $recProduct->rating_count }}, '{{ addslashes($recProduct->description ?? '') }}');">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 40px; background: #f8f9fa; border-radius: 15px;">
                    <i class="fas fa-box-open" style="font-size: 48px; color: #ccc; margin-bottom: 15px;"></i>
                    <h4 style="color: #666; margin-bottom: 10px;">No products available</h4>
                    <p style="color: #999;">Please add products to the database first.</p>
                    <a href="{{ route('dashboard') }}"
                        style="display: inline-block; margin-top: 20px; padding: 12px 24px; background: var(--primary-color); color: white; border-radius: 25px; text-decoration: none;">
                        Go to Dashboard
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Payment Method Modal -->
    <div class="modal fade payment-modal" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">
                        <i class="fas fa-credit-card"></i>
                        Select Payment Method
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="payment-method-container">
                        <h4 class="payment-method-title">Choose your payment method</h4>
                        <div class="payment-methods">
                            <div class="payment-method" data-method="cash">
                                <div class="payment-method-icon cash">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div class="payment-method-details">
                                    <div class="payment-method-name">Cash on Delivery</div>
                                    <div class="payment-method-desc">Pay with cash when you receive your order</div>
                                </div>
                                <input type="radio" name="paymentMethod" class="payment-method-radio" value="cash">
                            </div>

                            <div class="payment-method" data-method="e-wallet">
                                <div class="payment-method-icon ewallet">
                                    <i class="fas fa-wallet"></i>
                                </div>
                                <div class="payment-method-details">
                                    <div class="payment-method-name">E-Wallet</div>
                                    <div class="payment-method-desc">Pay with GoPay, OVO, DANA, or ShopeePay</div>
                                </div>
                                <input type="radio" name="paymentMethod" class="payment-method-radio"
                                    value="e-wallet">
                            </div>

                            <div class="payment-method" data-method="qris">
                                <div class="payment-method-icon qris">
                                    <i class="fas fa-qrcode"></i>
                                </div>
                                <div class="payment-method-details">
                                    <div class="payment-method-name">QRIS</div>
                                    <div class="payment-method-desc">Scan QR code to pay with any mobile banking app
                                    </div>
                                </div>
                                <input type="radio" name="paymentMethod" class="payment-method-radio" value="qris">
                            </div>
                        </div>
                    </div>

                    <div class="voucher-section">
                        <h4 class="payment-method-title">Apply Voucher</h4>
                        <div class="voucher-input-group">
                            <input type="text" class="voucher-input" id="voucherCodeInput"
                                placeholder="Enter voucher code">
                            <button class="apply-voucher-btn" id="applyVoucherBtn">Apply</button>
                        </div>
                        <div class="voucher-message" id="voucherMessage"></div>
                    </div>

                    <div class="payment-summary">
                        <h4 class="payment-method-title">Order Summary</h4>
                        <div class="payment-summary-row">
                            <span>Subtotal:</span>
                            <span id="modalSubtotal">Rp0</span>
                        </div>
                        <div class="payment-summary-row">
                            <span>Delivery:</span>
                            <span id="modalDelivery">Rp0</span>
                        </div>
                        <div class="payment-summary-row">
                            <span>Service Fee:</span>
                            <span id="modalService">Rp0</span>
                        </div>
                        <div class="payment-summary-row">
                            <span>Discount:</span>
                            <span id="modalDiscount" class="text-success">-Rp0</span>
                        </div>
                        <div class="payment-summary-total">
                            <span>Total:</span>
                            <span id="modalTotal">Rp0</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmPaymentMethodBtn">Confirm Payment
                        Method</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Voucher Modal -->
    <div class="modal fade voucher-modal" id="voucherModal" tabindex="-1" aria-labelledby="voucherModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="voucherModalLabel">
                        <i class="fas fa-ticket-alt"></i>
                        Available Vouchers
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-4">Select a voucher to apply to your order</p>

                    <div class="voucher-card" data-code="LASTBITE10" data-discount="10">
                        <div class="voucher-header">
                            <span class="voucher-code">LASTBITE10</span>
                            <span class="voucher-discount">10% OFF</span>
                        </div>
                        <div class="voucher-title">First Order Discount</div>
                        <div class="voucher-desc">Get 10% off on your first purchase at LastBite</div>
                        <div class="voucher-validity">
                            <i class="far fa-calendar-alt"></i>
                            <span>Valid until: 31 December 2024</span>
                        </div>
                    </div>

                    <div class="voucher-card" data-code="FOODSAVER20" data-discount="20">
                        <div class="voucher-header">
                            <span class="voucher-code">FOODSAVER20</span>
                            <span class="voucher-discount">20% OFF</span>
                        </div>
                        <div class="voucher-title">Food Saver Special</div>
                        <div class="voucher-desc">Save 20% on all food items near expiry date</div>
                        <div class="voucher-validity">
                            <i class="far fa-calendar-alt"></i>
                            <span>Valid until: 31 December 2024</span>
                        </div>
                    </div>

                    <div class="voucher-card" data-code="FLASH15" data-discount="15">
                        <div class="voucher-header">
                            <span class="voucher-code">FLASH15</span>
                            <span class="voucher-discount">15% OFF</span>
                        </div>
                        <div class="voucher-title">Flash Sale Discount</div>
                        <div class="voucher-desc">Extra 15% off on all flash sale items</div>
                        <div class="voucher-validity">
                            <i class="far fa-calendar-alt"></i>
                            <span>Valid until: 31 December 2024</span>
                        </div>
                    </div>

                    <div class="voucher-card" data-code="FREESHIP" data-discount-type="delivery">
                        <div class="voucher-header">
                            <span class="voucher-code">FREESHIP</span>
                            <span class="voucher-discount" style="color: #ff6b6b;">FREE SHIPPING</span>
                        </div>
                        <div class="voucher-title">Free Delivery</div>
                        <div class="voucher-desc">Free delivery on orders above Rp 50.000</div>
                        <div class="voucher-validity">
                            <i class="far fa-calendar-alt"></i>
                            <span>Valid until: 31 December 2024</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="applySelectedVoucherBtn">Apply Selected
                        Voucher</button>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script>
        // ========== CART SYSTEM - FIXED ==========
        // PERBAIKAN UTAMA:
        // 1. Struktur data sama dengan detail produk (menggunakan image_url, bukan image)
        // 2. Recommended products menggunakan addslashes() yang benar
        // 3. Gambar produk sekarang sinkron 100%

        let cartItems = [];
        let selectedPaymentMethod = null;
        let appliedVoucher = null;
        let deliveryFee = 10000; // Default delivery fee
        let serviceFee = 2000; // Default service fee

        // Initialize cart dari data server
        function initializeCart() {
            try {
                @if (Auth::check() && isset($cartItems) && count($cartItems) > 0)
                    // PERBAIKAN: Data dari server sudah dalam format yang benar
                    cartItems = @json($cartItems);
                    console.log('Cart loaded from server:', cartItems.length, 'items');
                @else
                    // Guest user: ambil dari localStorage
                    const savedCart = localStorage.getItem('lastbite_cart');
                    if (savedCart) {
                        cartItems = JSON.parse(savedCart);
                        console.log('Cart loaded from localStorage:', cartItems.length, 'items');
                    } else {
                        cartItems = [];
                    }
                @endif
            } catch (error) {
                console.error('Error loading cart:', error);
                cartItems = [];
            }

            renderCartItems();
            updateAllUI();
            loadPaymentMethodFromStorage();
            loadVoucherFromStorage();
        }

        // Render cart items
        function renderCartItems() {
            const container = document.getElementById('cartItemsContainer');
            if (!container) return;

            container.innerHTML = '';

            if (cartItems.length === 0) {
                container.innerHTML = `
                <div class="empty-cart" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 60px 20px; text-align: center;">
                    <i class="fas fa-shopping-cart" style="font-size: 64px; color: var(--text-light); margin-bottom: 20px; opacity: 0.5;"></i>
                    <h3 style="font-size: 24px; color: var(--text-dark); margin-bottom: 15px;">Your cart is empty</h3>
                    <p style="color: var(--text-light); margin-bottom: 30px; max-width: 400px;">Looks like you haven't added any items to your cart yet. Start shopping to find amazing deals!</p>
                    <a href="{{ route('dashboard') }}" class="btn-start-shopping" style="background: var(--primary-color); color: var(--white); border: none; padding: 14px 32px; border-radius: 30px; font-weight: 600; font-size: 16px; cursor: pointer; transition: var(--transition); display: flex; align-items: center; gap: 10px; text-decoration: none;">
                        <i class="fas fa-store"></i>
                        Start Shopping
                    </a>
                </div>
            `;
            } else {
                cartItems.forEach(item => {
                    const cartItemElement = createCartItemElement(item);
                    container.appendChild(cartItemElement);
                });

                attachCartItemEventListeners();
            }
        }

        // Create cart item element - PERBAIKAN: gunakan image_url seperti di detail produk
        function createCartItemElement(item) {
            const cartItem = document.createElement('div');
            cartItem.className = 'cart-item';
            cartItem.id = `cartItem-${item.id}`;
            cartItem.dataset.itemId = item.id;

            const itemTotalPrice = item.price * item.quantity;

            // PERBAIKAN KRUSIAL: Gunakan image_url (bukan image) seperti di detail produk
            const itemImage = item.image_url || item.image ||
                'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80';

            cartItem.innerHTML = `
            <div class="cart-item-checkbox ${item.selected ? 'selected' : ''}"
                 data-item-id="${item.id}">
                <i class="fas fa-check"></i>
            </div>

            <div class="cart-item-image">
                <img src="${itemImage}" alt="${item.name}">
            </div>

            <div class="cart-item-details">
                <div class="cart-item-brand">${item.brand || 'LastBite'}</div>
                <h3 class="cart-item-name">${item.name}</h3>
                <p class="cart-item-desc">
                    ${item.description || 'Fresh product with great quality and best price.'}
                </p>

                <div class="cart-item-meta">
                    <span><i class="fas fa-tag"></i> ${item.category || 'Food'}</span>
                    <span><i class="fas fa-clock"></i> Exp: ${item.expiry_date || 'Soon'}</span>
                    <span><i class="fas fa-star"></i> ${item.rating || '4.5'} (${item.rating_count || '10'} reviews)</span>
                </div>

                <div class="cart-item-actions">
                    <div class="quantity-control">
                        <button class="quantity-btn minus" data-item-id="${item.id}">-</button>
                        <span class="quantity-value" id="quantity-${item.id}">${item.quantity}</span>
                        <button class="quantity-btn plus" data-item-id="${item.id}">+</button>
                    </div>

                    <div class="cart-item-price" id="price-${item.id}">Rp${itemTotalPrice.toLocaleString('id-ID')}</div>

                    <button class="remove-item-btn" data-item-id="${item.id}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;

            return cartItem;
        }

        // Attach event listeners to cart items
        function attachCartItemEventListeners() {
            document.querySelectorAll('.cart-item-checkbox').forEach(checkbox => {
                checkbox.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const itemId = parseInt(this.dataset.itemId);
                    toggleItemSelection(itemId);
                });
            });

            document.querySelectorAll('.quantity-btn.minus').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const itemId = parseInt(this.dataset.itemId);
                    handleQuantityChange(itemId, 'minus');
                });
            });

            document.querySelectorAll('.quantity-btn.plus').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const itemId = parseInt(this.dataset.itemId);
                    handleQuantityChange(itemId, 'plus');
                });
            });

            document.querySelectorAll('.remove-item-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const itemId = parseInt(this.dataset.itemId);
                    removeItem(itemId);
                });
            });
        }

        // Toggle item selection
        function toggleItemSelection(itemId) {
            const itemIndex = cartItems.findIndex(item => item.id === itemId);
            if (itemIndex !== -1) {
                cartItems[itemIndex].selected = !cartItems[itemIndex].selected;
                saveCartToStorage();
                updateCartItemCheckbox(itemId, cartItems[itemIndex].selected);
                updateAllUI();
            }
        }

        // Update individual checkbox
        function updateCartItemCheckbox(itemId, selected) {
            const checkbox = document.querySelector(`.cart-item-checkbox[data-item-id="${itemId}"]`);
            if (checkbox) {
                if (selected) {
                    checkbox.classList.add('selected');
                } else {
                    checkbox.classList.remove('selected');
                }
            }
        }

        // Select all functionality
        document.getElementById('selectAll')?.addEventListener('click', function() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const isCurrentlySelected = selectAllCheckbox.classList.contains('selected');
            const newState = !isCurrentlySelected;

            if (newState) {
                selectAllCheckbox.classList.add('selected');
            } else {
                selectAllCheckbox.classList.remove('selected');
            }

            cartItems.forEach(item => {
                item.selected = newState;
            });

            saveCartToStorage();
            renderCartItems();
            updateAllUI();
        });

        // Handle quantity change
        function handleQuantityChange(itemId, action) {
            const itemIndex = cartItems.findIndex(item => item.id === itemId);
            if (itemIndex === -1) return;

            if (action === 'plus') {
                cartItems[itemIndex].quantity += 1;
            } else if (action === 'minus') {
                if (cartItems[itemIndex].quantity > 1) {
                    cartItems[itemIndex].quantity -= 1;
                } else {
                    if (confirm('Remove this item from cart?')) {
                        removeItem(itemId);
                    }
                    return;
                }
            }

            saveCartToStorage();
            updateQuantityDisplay(itemId, cartItems[itemIndex].quantity);
            updateAllUI();
        }

        // Update quantity display
        function updateQuantityDisplay(itemId, quantity) {
            const quantityElement = document.getElementById(`quantity-${itemId}`);
            const priceElement = document.getElementById(`price-${itemId}`);
            const item = cartItems.find(item => item.id === itemId);

            if (quantityElement && item) {
                quantityElement.textContent = quantity;
                if (priceElement) {
                    const totalPrice = item.price * quantity;
                    priceElement.textContent = `Rp${totalPrice.toLocaleString('id-ID')}`;
                }
            }
        }

        // Remove item from cart
        function removeItem(itemId) {
            const itemIndex = cartItems.findIndex(item => item.id === itemId);
            if (itemIndex !== -1) {
                cartItems.splice(itemIndex, 1);
                saveCartToStorage();
                renderCartItems();
                updateAllUI();
                showNotification('Item removed from cart', 'info');
            }
        }

        // PERBAIKAN: Add to cart from recommended - SIMPAN image_url dengan benar
        function addToCartFromRecommended(event, productId, productName, productPrice, productImageUrl, productBrand,
            productCategory, productRating, productRatingCount, productDescription) {
            event.stopPropagation();

            const existingItemIndex = cartItems.findIndex(item => item.id === productId);

            if (existingItemIndex !== -1) {
                cartItems[existingItemIndex].quantity += 1;
                cartItems[existingItemIndex].selected = true;
            } else {
                // PERBAIKAN KRUSIAL: Simpan sebagai image_url (bukan image)
                const newItem = {
                    id: productId,
                    name: productName,
                    price: productPrice,
                    quantity: 1,
                    selected: true,
                    image_url: productImageUrl, // PENTING: image_url seperti di detail produk
                    brand: productBrand || 'LastBite',
                    category: productCategory || 'Product',
                    expiry_date: 'Soon',
                    rating: productRating || 4.5,
                    rating_count: productRatingCount || 10,
                    description: productDescription || 'Fresh product with great quality and best price.'
                };
                cartItems.push(newItem);
            }

            saveCartToStorage();
            renderCartItems();
            updateAllUI();
            showNotification(`${productName} added to cart!`, 'success');

            const button = event.target.closest('.add-to-cart-btn') || event.target;
            button.style.transform = 'scale(1.2) rotate(360deg)';
            button.style.backgroundColor = 'var(--success-color)';
            setTimeout(() => {
                button.style.transform = '';
                button.style.backgroundColor = '';
            }, 500);
        }

        // Save cart to localStorage
        function saveCartToStorage() {
            try {
                localStorage.setItem('lastbite_cart', JSON.stringify(cartItems));
            } catch (error) {
                console.error('Error saving cart:', error);
            }
        }

        // ========== PAYMENT METHOD FUNCTIONS ==========
        function loadPaymentMethodFromStorage() {
            const savedPaymentMethod = localStorage.getItem('lastbite_payment_method');
            if (savedPaymentMethod) {
                selectedPaymentMethod = savedPaymentMethod;
                updatePaymentMethodUI();
            }
        }

        function loadVoucherFromStorage() {
            const savedVoucher = localStorage.getItem('lastbite_voucher');
            if (savedVoucher) {
                appliedVoucher = JSON.parse(savedVoucher);
                updateVoucherUI();
            }
        }

        function savePaymentMethodToStorage() {
            localStorage.setItem('lastbite_payment_method', selectedPaymentMethod);
        }

        function saveVoucherToStorage() {
            localStorage.setItem('lastbite_voucher', JSON.stringify(appliedVoucher));
        }

        function updatePaymentMethodUI() {
            // Update payment method selection in modal
            document.querySelectorAll('.payment-method').forEach(method => {
                method.classList.remove('selected');
            });

            if (selectedPaymentMethod) {
                const selectedMethod = document.querySelector(`.payment-method[data-method="${selectedPaymentMethod}"]`);
                if (selectedMethod) {
                    selectedMethod.classList.add('selected');
                    const radio = selectedMethod.querySelector('.payment-method-radio');
                    if (radio) radio.checked = true;
                }
            }
        }

        function updateVoucherUI() {
            const voucherMessage = document.getElementById('voucherMessage');
            if (appliedVoucher) {
                voucherMessage.textContent =
                    `Voucher "${appliedVoucher.code}" applied! ${appliedVoucher.discount}% discount.`;
                voucherMessage.className = 'voucher-message voucher-success';
            } else {
                voucherMessage.textContent = '';
                voucherMessage.className = 'voucher-message';
            }
            updateAllUI();
        }

        // Calculate total with discount
        // Calculate total with discount - PERBAIKAN: Default 0 jika tidak ada item terpilih
        function calculateTotalWithDiscount() {
            let subtotal = 0;
            let totalItems = 0;

            // Hitung hanya item yang dipilih
            const selectedItems = cartItems.filter(item => item.selected);

            selectedItems.forEach(item => {
                subtotal += item.price * item.quantity;
                totalItems += item.quantity;
            });

            // PERBAIKAN: Delivery dan service fee hanya jika ada item yang dipilih
            let discount = 0;
            let finalDeliveryFee = selectedItems.length > 0 ? deliveryFee : 0; // 0 jika tidak ada item
            let finalServiceFee = selectedItems.length > 0 ? serviceFee : 0; // 0 jika tidak ada item

            if (appliedVoucher && selectedItems.length > 0) {
                if (appliedVoucher.discountType === 'delivery') {
                    finalDeliveryFee = 0;
                } else {
                    discount = (subtotal * appliedVoucher.discount) / 100;
                }
            }

            const total = selectedItems.length > 0 ? (subtotal + finalDeliveryFee + finalServiceFee - discount) : 0;

            return {
                subtotal,
                totalItems,
                delivery: finalDeliveryFee,
                service: finalServiceFee,
                discount,
                total
            };
        }

        // Update all UI - PERBAIKAN: Tampilkan 0 jika tidak ada item
        function updateAllUI() {
            const selectedItems = cartItems.filter(item => item.selected);
            const selectedCount = selectedItems.length;
            const totalItems = selectedItems.reduce((total, item) => total + item.quantity, 0);

            // Update selected count
            document.getElementById('selectedCount').textContent = selectedCount;
            document.getElementById('subtotalItems').textContent = totalItems;
            document.getElementById('subtotalPlural').textContent = totalItems !== 1 ? 's' : '';
            document.getElementById('checkoutCount').textContent = totalItems;

            // Update totals - PERBAIKAN: Tampilkan 0 jika tidak ada item terpilih
            const totals = calculateTotalWithDiscount();

            // Format dengan currency formatter
            const formatCurrency = (amount) => {
                return amount > 0 ? `Rp${amount.toLocaleString('id-ID')}` : 'Rp0';
            };

            document.getElementById('subtotal').textContent = formatCurrency(totals.subtotal);
            document.getElementById('delivery').textContent = formatCurrency(totals.delivery);
            document.getElementById('service').textContent = formatCurrency(totals.service);
            document.getElementById('total').textContent = formatCurrency(totals.total);

            // Update modal totals
            document.getElementById('modalSubtotal').textContent = formatCurrency(totals.subtotal);
            document.getElementById('modalDelivery').textContent = formatCurrency(totals.delivery);
            document.getElementById('modalService').textContent = formatCurrency(totals.service);
            document.getElementById('modalDiscount').textContent = totals.discount > 0 ?
                `-Rp${totals.discount.toLocaleString('id-ID')}` : `-Rp0`;
            document.getElementById('modalTotal').textContent = formatCurrency(totals.total);

            // Update select all checkbox
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            if (cartItems.length > 0 && selectedCount === cartItems.length) {
                selectAllCheckbox.classList.add('selected');
            } else if (selectedCount > 0) {
                selectAllCheckbox.classList.add('selected');
            } else {
                selectAllCheckbox.classList.remove('selected');
            }

            return totals;
        }

        // Juga update di bagian initializeCart untuk reset ke 0
        function initializeCart() {
            try {
                @if (Auth::check() && isset($cartItems) && count($cartItems) > 0)
                    cartItems = @json($cartItems);
                    console.log('Cart loaded from server:', cartItems.length, 'items');
                @else
                    const savedCart = localStorage.getItem('lastbite_cart');
                    if (savedCart) {
                        cartItems = JSON.parse(savedCart);
                        console.log('Cart loaded from localStorage:', cartItems.length, 'items');
                    } else {
                        cartItems = [];
                    }
                @endif
            } catch (error) {
                console.error('Error loading cart:', error);
                cartItems = [];
            }

            renderCartItems();
            updateAllUI();
            loadPaymentMethodFromStorage();
            loadVoucherFromStorage();

            // PERBAIKAN: Reset semua total ke 0 saat pertama kali load
            resetTotalsToZero();
        }

        // Fungsi baru untuk reset total ke 0
        function resetTotalsToZero() {
            const formatZero = () => 'Rp0';

            document.getElementById('subtotal').textContent = formatZero();
            document.getElementById('delivery').textContent = formatZero();
            document.getElementById('service').textContent = formatZero();
            document.getElementById('total').textContent = formatZero();
            document.getElementById('modalSubtotal').textContent = formatZero();
            document.getElementById('modalDelivery').textContent = formatZero();
            document.getElementById('modalService').textContent = formatZero();
            document.getElementById('modalDiscount').textContent = '-Rp0';
            document.getElementById('modalTotal').textContent = formatZero();
        }

        // Update all UI
        function updateAllUI() {
            const selectedItems = cartItems.filter(item => item.selected);
            const selectedCount = selectedItems.length;
            const totalItems = selectedItems.reduce((total, item) => total + item.quantity, 0);

            // Update selected count
            document.getElementById('selectedCount').textContent = selectedCount;
            document.getElementById('subtotalItems').textContent = totalItems;
            document.getElementById('subtotalPlural').textContent = totalItems !== 1 ? 's' : '';
            document.getElementById('checkoutCount').textContent = totalItems;

            // Update totals
            const totals = calculateTotalWithDiscount();
            document.getElementById('subtotal').textContent = `Rp${totals.subtotal.toLocaleString('id-ID')}`;
            document.getElementById('delivery').textContent = `Rp${totals.delivery.toLocaleString('id-ID')}`;
            document.getElementById('service').textContent = `Rp${totals.service.toLocaleString('id-ID')}`;
            document.getElementById('total').textContent = `Rp${totals.total.toLocaleString('id-ID')}`;

            // Update modal totals
            document.getElementById('modalSubtotal').textContent = `Rp${totals.subtotal.toLocaleString('id-ID')}`;
            document.getElementById('modalDelivery').textContent = `Rp${totals.delivery.toLocaleString('id-ID')}`;
            document.getElementById('modalService').textContent = `Rp${totals.service.toLocaleString('id-ID')}`;
            document.getElementById('modalDiscount').textContent = totals.discount > 0 ?
                `-Rp${totals.discount.toLocaleString('id-ID')}` : `-Rp0`;
            document.getElementById('modalTotal').textContent = `Rp${totals.total.toLocaleString('id-ID')}`;

            // Update select all checkbox
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            if (cartItems.length > 0 && selectedCount === cartItems.length) {
                selectAllCheckbox.classList.add('selected');
            } else if (selectedCount > 0) {
                selectAllCheckbox.classList.add('selected');
            } else {
                selectAllCheckbox.classList.remove('selected');
            }

            return totals;
        }

        // Show notification
        function showNotification(message, type = 'success') {
            const existingNotification = document.querySelector('.cart-notification');
            if (existingNotification) {
                existingNotification.remove();
            }

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

            setTimeout(() => notification.classList.add('show'), 100);

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
        if (!document.querySelector('#cart-notification-style')) {
            const style = document.createElement('style');
            style.id = 'cart-notification-style';
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
            .cart-notification .notification-content.info {
                border-left: 4px solid var(--info-color);
                color: var(--text-dark);
            }
            .cart-notification .notification-content.info i {
                color: var(--info-color);
            }
        `;
            document.head.appendChild(style);
        }

        // ========== PAYMENT MODAL FUNCTIONALITY ==========
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Cart page initialized');
            initializeCart();

            // Payment method selection
            document.querySelectorAll('.payment-method').forEach(method => {
                method.addEventListener('click', function() {
                    const methodValue = this.dataset.method;
                    selectedPaymentMethod = methodValue;

                    // Update UI
                    document.querySelectorAll('.payment-method').forEach(m => {
                        m.classList.remove('selected');
                    });
                    this.classList.add('selected');

                    // Update radio button
                    const radio = this.querySelector('.payment-method-radio');
                    if (radio) radio.checked = true;

                    savePaymentMethodToStorage();
                });
            });

            // Apply voucher button
            document.getElementById('applyVoucherBtn')?.addEventListener('click', applyVoucher);

            // Apply voucher from input
            document.getElementById('voucherCodeInput')?.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    applyVoucher();
                }
            });

            // Voucher selection in voucher modal
            document.querySelectorAll('.voucher-card').forEach(voucher => {
                voucher.addEventListener('click', function() {
                    // Remove selection from all vouchers
                    document.querySelectorAll('.voucher-card').forEach(v => {
                        v.classList.remove('selected');
                    });
                    // Add selection to clicked voucher
                    this.classList.add('selected');
                });
            });

            // Apply selected voucher
            document.getElementById('applySelectedVoucherBtn')?.addEventListener('click', function() {
                const selectedVoucher = document.querySelector('.voucher-card.selected');
                if (selectedVoucher) {
                    const voucherCode = selectedVoucher.dataset.code;
                    const discount = selectedVoucher.dataset.discount;
                    const discountType = selectedVoucher.dataset.discountType || 'percentage';

                    appliedVoucher = {
                        code: voucherCode,
                        discount: parseInt(discount),
                        discountType: discountType
                    };

                    saveVoucherToStorage();
                    updateVoucherUI();

                    // Close modal
                    const voucherModal = bootstrap.Modal.getInstance(document.getElementById(
                        'voucherModal'));
                    voucherModal.hide();

                    // Update payment modal
                    updateAllUI();

                    showNotification(`Voucher "${voucherCode}" applied successfully!`, 'success');
                } else {
                    showNotification('Please select a voucher first', 'warning');
                }
            });

            // Confirm payment method
            document.getElementById('confirmPaymentMethodBtn')?.addEventListener('click', function() {
                if (!selectedPaymentMethod) {
                    showNotification('Please select a payment method', 'warning');
                    return;
                }

                const paymentModal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
                paymentModal.hide();

                showNotification('Payment method selected successfully!', 'success');
            });

            // Checkout button
            document.getElementById('checkoutBtn')?.addEventListener('click', function() {
                const selectedItems = cartItems.filter(item => item.selected);

                if (selectedItems.length === 0) {
                    showNotification('Please select at least one item to checkout', 'warning');
                    return;
                }

                if (!selectedPaymentMethod) {
                    showNotification('Please select a payment method first', 'warning');
                    // Show payment modal
                    const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
                    paymentModal.show();
                    return;
                }

                // Redirect to checkout page
                proceedToCheckout();
            });
        });

        // Apply voucher function
        function applyVoucher() {
            const voucherCode = document.getElementById('voucherCodeInput').value.trim();
            const voucherMessage = document.getElementById('voucherMessage');

            if (!voucherCode) {
                voucherMessage.textContent = 'Please enter a voucher code';
                voucherMessage.className = 'voucher-message voucher-error';
                return;
            }

            // Simulate voucher validation
            const validVouchers = {
                'LASTBITE10': {
                    discount: 10,
                    type: 'percentage',
                    message: '10% discount applied!'
                },
                'FOODSAVER20': {
                    discount: 20,
                    type: 'percentage',
                    message: '20% discount applied!'
                },
                'FLASH15': {
                    discount: 15,
                    type: 'percentage',
                    message: '15% discount applied!'
                },
                'FREESHIP': {
                    discount: 100,
                    type: 'delivery',
                    message: 'Free shipping applied!'
                }
            };

            if (validVouchers[voucherCode]) {
                const voucher = validVouchers[voucherCode];
                appliedVoucher = {
                    code: voucherCode,
                    discount: voucher.discount,
                    discountType: voucher.type
                };

                saveVoucherToStorage();
                updateVoucherUI();

                voucherMessage.textContent = voucher.message;
                voucherMessage.className = 'voucher-message voucher-success';
                document.getElementById('voucherCodeInput').value = '';

                showNotification(voucher.message, 'success');
            } else {
                voucherMessage.textContent = 'Invalid voucher code';
                voucherMessage.className = 'voucher-message voucher-error';
            }
        }

        // Remove voucher
        function removeVoucher() {
            appliedVoucher = null;
            localStorage.removeItem('lastbite_voucher');
            updateVoucherUI();
            showNotification('Voucher removed', 'info');
        }

        // Proceed to checkout
        function proceedToCheckout() {
            const selectedItems = cartItems.filter(item => item.selected);
            const totals = calculateTotalWithDiscount();

            // Store checkout data in localStorage
            const checkoutData = {
                items: selectedItems,
                paymentMethod: selectedPaymentMethod,
                voucher: appliedVoucher,
                totals: totals,
                timestamp: new Date().toISOString()
            };

            localStorage.setItem('lastbite_checkout_data', JSON.stringify(checkoutData));

            // Redirect to checkout page
            window.location.href = '{{ route('checkout.index') }}';
        }

        // Show payment success with SweetAlert
        function showPaymentSuccess(orderData) {
            Swal.fire({
                title: 'Payment Successful!',
                html: `
                    <div style="text-align: left;">
                        <p><strong>Order ID:</strong> ${orderData.orderId}</p>
                        <p><strong>Payment Method:</strong> ${orderData.paymentMethod}</p>
                        <p><strong>Total Amount:</strong> Rp${orderData.total.toLocaleString('id-ID')}</p>
                        <p><strong>Delivery Address:</strong> ${orderData.address}</p>
                    </div>
                `,
                icon: 'success',
                confirmButtonText: 'View Order History',
                showCancelButton: true,
                cancelButtonText: 'Continue Shopping',
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('profile.orders') }}';
                } else {
                    window.location.href = '{{ route('dashboard') }}';
                }
            });
        }

        // ========== FAVORITE FUNCTIONALITY ==========

        // Toggle favorite status
        // Fungsi toggleFavorite yang terintegrasi dengan backend
        async function toggleFavorite(productId) {
            try {
                const response = await fetch('/favorites/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || csrfToken
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
