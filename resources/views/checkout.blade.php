@extends('layouts.buyer')

@section('content')
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS (harus sebelum checkout.js) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script>
        window.CHECKOUT_CFG = {
            cartSummaryUrl: @json(route('cart.summary')),
            cartIndexUrl: @json(route('cart.index')),
            dashboardUrl: @json(route('dashboard')),
            deliveryFee: 10000,
            serviceFee: 2000,
        };
    </script>

    @vite(['resources/css/checkout.css', 'resources/js/checkout.js'])

    <div class="checkout-container">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Home</a> /
            <a href="{{ route('cart.index') }}">Cart</a> /
            <span>Checkout</span>
        </div>

        <!-- Checkout Steps -->
        <div class="checkout-steps">
            <div class="checkout-step">
                <div class="step-number completed">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="step-label completed">Cart</div>
            </div>
            <div class="checkout-step">
                <div class="step-number active">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <div class="step-label active">Shipping & Payment</div>
            </div>
            <div class="checkout-step">
                <div class="step-number">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="step-label">Confirmation</div>
            </div>
        </div>

        <!-- Checkout Layout -->
        <div class="checkout-layout">
            <!-- Left Column - Shipping & Payment -->
            <div class="checkout-left-column">
                <!-- Address Section -->
                <div class="address-section">
                    <div class="address-header">
                        <h2 class="address-title">
                            <i class="fas fa-map-marker-alt"></i>
                            Delivery Address
                        </h2>
                        <button class="change-address-btn" id="changeAddressBtn">
                            <i class="fas fa-edit"></i>
                            Change Address
                        </button>
                    </div>
                    <div class="address-details">
                        @php
                            $user = auth()->user();
                            $defaultAddress = $user->address ?? 'Not set';
                            $defaultPhone = $user->phone ?? 'Not set';
                        @endphp
                        <div class="address-name">{{ $user->name }}</div>
                        <div class="address-text">{{ $defaultAddress }}</div>
                        <div class="address-phone">{{ $defaultPhone }}</div>
                    </div>
                </div>

                <!-- Payment Method Section -->
                <div class="payment-method-section">
                    <div class="payment-method-header">
                        <h2 class="payment-method-title">
                            <i class="fas fa-credit-card"></i>
                            Payment Method
                        </h2>
                        <button class="change-payment-btn" id="changePaymentBtn">
                            <i class="fas fa-edit"></i>
                            Change Payment
                        </button>
                    </div>
                    <div class="payment-method-display" id="paymentMethodDisplay">
                        <!-- Payment method will be dynamically loaded -->
                    </div>
                </div>

                <!-- Delivery Instructions -->
                <div class="delivery-instructions">
                    <h3 class="instructions-title">
                        <i class="fas fa-clipboard-list"></i>
                        Delivery Instructions (Optional)
                    </h3>
                    <textarea class="instructions-textarea" id="deliveryInstructions"
                        placeholder="Add any special delivery instructions here..."></textarea>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="order-summary-section">
                <h3 class="summary-title">Order Summary</h3>

                <!-- Order Items -->
                <div class="order-items" id="orderItemsContainer">
                    <!-- Order items will be dynamically loaded -->
                </div>

                <!-- Voucher Applied -->
                <div class="voucher-applied" id="voucherApplied" style="display: none;">
                    <div>
                        <span class="voucher-code" id="voucherCodeText"></span>
                        <span class="voucher-discount" id="voucherDiscountText"></span>
                    </div>
                    <button class="remove-voucher" id="removeVoucherBtn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Order Summary -->
                <div class="order-summary">
                    <div class="order-summary-row">
                        <span>Subtotal:</span>
                        <span id="summarySubtotal">Rp0</span>
                    </div>
                    <div class="order-summary-row">
                        <span>Delivery Fee:</span>
                        <span id="summaryDelivery">Rp0</span>
                    </div>
                    <div class="order-summary-row">
                        <span>Service Fee:</span>
                        <span id="summaryService">Rp0</span>
                    </div>
                    <div class="order-summary-row">
                        <span>Discount:</span>
                        <span id="summaryDiscount" class="text-success">-Rp0</span>
                    </div>
                    <div class="order-summary-total">
                        <span>Total:</span>
                        <span id="summaryTotal">Rp0</span>
                    </div>
                </div>

                <!-- Confirm Payment Button -->
                <button class="confirm-payment-btn" id="confirmPaymentBtn">
                    <i class="fas fa-lock"></i>
                    Confirm & Pay Now
                </button>
            </div>
        </div>
    </div>
@endsection
