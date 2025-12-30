@extends('layouts.buyer')

@section('content')
    <style>
        /* ========== CHECKOUT PAGE STYLES ========== */
        .checkout-container {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
            padding: 0;
        }

        @media (max-width: 768px) {
            .checkout-container {
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

        /* Checkout Steps */
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

        /* Checkout Layout */
        .checkout-layout {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 30px;
        }

        @media (max-width: 992px) {
            .checkout-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Address Section */
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

        /* Payment Method Section */
        .payment-method-section {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            box-shadow: var(--shadow-light);
        }

        .payment-method-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .payment-method-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .change-payment-btn {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }

        .change-payment-btn:hover {
            background: var(--primary-color);
            color: white;
        }

        .payment-method-display {
            padding: 20px;
            background: var(--bg-light);
            border-radius: 10px;
            border-left: 4px solid var(--primary-color);
            display: flex;
            align-items: center;
            gap: 15px;
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

        .payment-method-info {
            flex: 1;
        }

        .payment-method-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .payment-method-desc {
            font-size: 14px;
            color: var(--text-light);
        }

        /* Order Summary */
        .order-summary-section {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            box-shadow: var(--shadow-light);
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .summary-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(63, 35, 5, 0.1);
        }

        .order-items {
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 20px;
            padding-right: 10px;
        }

        .order-items::-webkit-scrollbar {
            width: 5px;
        }

        .order-items::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .order-items::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
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
            font-size: 14px;
        }

        .order-item-quantity {
            color: var(--text-light);
            font-size: 13px;
        }

        .order-item-price {
            color: var(--danger-color);
            font-weight: 600;
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
            font-size: 15px;
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

        .voucher-applied {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(40, 167, 69, 0.1);
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .voucher-code {
            font-weight: 600;
            color: #28a745;
        }

        .voucher-discount {
            font-weight: 600;
            color: #28a745;
        }

        .remove-voucher {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            font-size: 12px;
        }

        /* Confirm Payment Button */
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

        /* Delivery Instructions */
        .delivery-instructions {
            margin-top: 30px;
        }

        .instructions-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .instructions-textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid rgba(63, 35, 5, 0.1);
            border-radius: 10px;
            font-size: 14px;
            resize: vertical;
            min-height: 100px;
            transition: var(--transition);
        }

        .instructions-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .checkout-steps {
                flex-wrap: wrap;
                gap: 20px;
            }

            .checkout-steps::before {
                display: none;
            }

            .address-header,
            .payment-method-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .change-address-btn,
            .change-payment-btn {
                width: 100%;
                text-align: center;
            }

            .payment-method-display {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            /* Add to checkout.blade.php styles */
            @keyframes slideInUp {
                from {
                    transform: translateY(50px);
                    opacity: 0;
                }

                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            .animated-popup {
                animation: slideInUp 0.5s ease !important;
            }

            .swal-title-custom {
                font-family: 'Poppins', sans-serif !important;
                color: var(--primary-color) !important;
            }

            .swal-confirm-button {
                background: linear-gradient(135deg, var(--primary-color), var(--primary-light)) !important;
                border-radius: 30px !important;
                padding: 12px 30px !important;
                font-weight: 600 !important;
                transition: all 0.3s ease !important;
            }

            .swal-confirm-button:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 5px 15px rgba(63, 35, 5, 0.3) !important;
            }

            .swal-cancel-button {
                border-radius: 30px !important;
                padding: 12px 30px !important;
                font-weight: 600 !important;
            }

        }
    </style>

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script>
        // ========== CHECKOUT SYSTEM ==========
        document.addEventListener('DOMContentLoaded', function() {
            let checkoutData = null;
            let deliveryFee = 10000;
            let serviceFee = 2000;

            // Load checkout data from localStorage
            function loadCheckoutData() {
                const savedData = localStorage.getItem('lastbite_checkout_data');
                if (savedData) {
                    checkoutData = JSON.parse(savedData);
                    renderCheckoutData();
                } else {
                    // Redirect back to cart if no checkout data
                    Swal.fire({
                        title: 'No Items Selected',
                        text: 'Please add items to your cart first.',
                        icon: 'warning',
                        confirmButtonText: 'Go to Cart'
                    }).then(() => {
                        window.location.href = '{{ route('cart.index') }}';
                    });
                }
            }

            // Render checkout data
            function renderCheckoutData() {
                if (!checkoutData) return;

                // Render order items
                renderOrderItems();

                // Render payment method
                renderPaymentMethod();

                // Render voucher
                renderVoucher();

                // Calculate and display totals
                updateTotals();
            }

            // Render order items
            function renderOrderItems() {
                const container = document.getElementById('orderItemsContainer');
                if (!container || !checkoutData || !checkoutData.items) return;

                container.innerHTML = '';
                checkoutData.items.forEach(item => {
                    const itemElement = document.createElement('div');
                    itemElement.className = 'order-item';

                    const itemImage = item.image_url || item.image ||
                        'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80';

                    itemElement.innerHTML = `
                    <div class="order-item-image">
                        <img src="${itemImage}" alt="${item.name}">
                    </div>
                    <div class="order-item-details">
                        <div class="order-item-name">${item.name}</div>
                        <div class="order-item-quantity">Quantity: ${item.quantity}</div>
                    </div>
                    <div class="order-item-price">Rp${(item.price * item.quantity).toLocaleString('id-ID')}</div>
                `;

                    container.appendChild(itemElement);
                });
            }

            // Render payment method
            function renderPaymentMethod() {
                const container = document.getElementById('paymentMethodDisplay');
                if (!container || !checkoutData || !checkoutData.paymentMethod) return;

                const paymentMethods = {
                    'cash': {
                        name: 'Cash on Delivery',
                        desc: 'Pay with cash when you receive your order',
                        icon: 'fas fa-money-bill-wave',
                        colorClass: 'cash'
                    },
                    'e-wallet': {
                        name: 'E-Wallet',
                        desc: 'Pay with GoPay, OVO, DANA, or ShopeePay',
                        icon: 'fas fa-wallet',
                        colorClass: 'ewallet'
                    },
                    'qris': {
                        name: 'QRIS',
                        desc: 'Scan QR code to pay with any mobile banking app',
                        icon: 'fas fa-qrcode',
                        colorClass: 'qris'
                    }
                };

                const method = paymentMethods[checkoutData.paymentMethod] || paymentMethods.cash;

                container.innerHTML = `
                <div class="payment-method-icon ${method.colorClass}">
                    <i class="${method.icon}"></i>
                </div>
                <div class="payment-method-info">
                    <div class="payment-method-name">${method.name}</div>
                    <div class="payment-method-desc">${method.desc}</div>
                </div>
            `;
            }

            // Render voucher
            function renderVoucher() {
                const voucherApplied = document.getElementById('voucherApplied');
                const voucherCodeText = document.getElementById('voucherCodeText');
                const voucherDiscountText = document.getElementById('voucherDiscountText');

                if (checkoutData && checkoutData.voucher) {
                    const voucher = checkoutData.voucher;
                    voucherApplied.style.display = 'flex';
                    voucherCodeText.textContent = voucher.code;

                    if (voucher.discountType === 'delivery') {
                        voucherDiscountText.textContent = 'Free Shipping';
                    } else {
                        voucherDiscountText.textContent = `${voucher.discount}% OFF`;
                    }
                } else {
                    voucherApplied.style.display = 'none';
                }
            }

            // Calculate and update totals
            function updateTotals() {
                if (!checkoutData || !checkoutData.totals) return;

                const totals = checkoutData.totals;

                document.getElementById('summarySubtotal').textContent =
                    `Rp${totals.subtotal.toLocaleString('id-ID')}`;
                document.getElementById('summaryDelivery').textContent =
                    `Rp${totals.delivery.toLocaleString('id-ID')}`;
                document.getElementById('summaryService').textContent =
                    `Rp${totals.service.toLocaleString('id-ID')}`;
                document.getElementById('summaryDiscount').textContent = totals.discount > 0 ?
                    `-Rp${totals.discount.toLocaleString('id-ID')}` : `-Rp0`;
                document.getElementById('summaryTotal').textContent = `Rp${totals.total.toLocaleString('id-ID')}`;
            }

            // Change address button
            document.getElementById('changeAddressBtn')?.addEventListener('click', function() {
                Swal.fire({
                    title: 'Change Delivery Address',
                    html: `
                        <div class="text-left">
                            <p>Current address: <strong>{{ $defaultAddress }}</strong></p>
                            <textarea id="newAddress" class="swal2-textarea" placeholder="Enter new delivery address..." rows="3"></textarea>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Update Address',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const newAddress = document.getElementById('newAddress').value.trim();
                        if (!newAddress) {
                            Swal.showValidationMessage('Please enter a valid address');
                            return false;
                        }
                        return newAddress;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Update address display
                        const addressDetails = document.querySelector(
                            '.address-details .address-text');
                        if (addressDetails) {
                            addressDetails.textContent = result.value;
                        }
                        Swal.fire('Success!', 'Delivery address updated.', 'success');
                    }
                });
            });

            // Change payment button
            document.getElementById('changePaymentBtn')?.addEventListener('click', function() {
                Swal.fire({
                    title: 'Change Payment Method',
                    input: 'select',
                    inputOptions: {
                        'cash': 'Cash on Delivery',
                        'e-wallet': 'E-Wallet',
                        'qris': 'QRIS'
                    },
                    inputValue: checkoutData.paymentMethod || 'cash',
                    showCancelButton: true,
                    confirmButtonText: 'Update Payment',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        checkoutData.paymentMethod = result.value;
                        localStorage.setItem('lastbite_checkout_data', JSON.stringify(
                            checkoutData));
                        renderPaymentMethod();
                        Swal.fire('Success!', 'Payment method updated.', 'success');
                    }
                });
            });

            // Remove voucher button
            document.getElementById('removeVoucherBtn')?.addEventListener('click', function() {
                if (checkoutData && checkoutData.voucher) {
                    checkoutData.voucher = null;
                    // Recalculate totals without voucher
                    const subtotal = checkoutData.totals.subtotal;
                    const total = subtotal + deliveryFee + serviceFee;
                    checkoutData.totals = {
                        ...checkoutData.totals,
                        discount: 0,
                        delivery: deliveryFee,
                        total: total
                    };

                    localStorage.setItem('lastbite_checkout_data', JSON.stringify(checkoutData));
                    renderVoucher();
                    updateTotals();
                    Swal.fire('Voucher Removed!', 'Voucher has been removed from your order.', 'success');
                }
            });

            // Confirm payment button
            document.getElementById('confirmPaymentBtn')?.addEventListener('click', function() {
                const btn = this;
                const originalText = btn.innerHTML;

                // Show loading
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing Payment...';
                btn.disabled = true;

                // Simulate payment processing
                setTimeout(() => {
                    // Generate order ID
                    const orderId = 'LB-' + Date.now() + '-' + Math.floor(Math.random() * 1000);

                    // Prepare order data for order history
                    const orderData = {
                        orderId: orderId,
                        items: checkoutData.items,
                        paymentMethod: checkoutData.paymentMethod,
                        voucher: checkoutData.voucher,
                        totals: checkoutData.totals,
                        address: document.querySelector('.address-details .address-text')
                            .textContent,
                        instructions: document.getElementById('deliveryInstructions').value
                            .trim(),
                        timestamp: new Date().toISOString(),
                        status: 'completed'
                    };

                    // Save to order history
                    saveOrderToHistory(orderData);

                    // Clear cart and checkout data
                    localStorage.removeItem('lastbite_cart');
                    localStorage.removeItem('lastbite_checkout_data');
                    localStorage.removeItem('lastbite_payment_method');
                    localStorage.removeItem('lastbite_voucher');

                    // Reset button
                    btn.innerHTML = originalText;
                    btn.disabled = false;

                    // Show success message
                    showPaymentSuccess(orderData);
                }, 2000);
            });

            // Save order to history
            function saveOrderToHistory(orderData) {
                // Get existing orders or initialize empty array
                let orders = JSON.parse(localStorage.getItem('lastbite_order_history') || '[]');

                // Add new order
                orders.unshift(orderData);

                // Keep only last 50 orders
                if (orders.length > 50) {
                    orders = orders.slice(0, 50);
                }

                // Save back to localStorage
                localStorage.setItem('lastbite_order_history', JSON.stringify(orders));

                // Also send to server if user is logged in
                if ('{{ Auth::check() }}' === '1') {
                    sendOrderToServer(orderData);
                }
            }

            // Send order to server
            function sendOrderToServer(orderData) {
                fetch('{{ route('orders.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(orderData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Order saved to server:', data);
                    })
                    .catch(error => {
                        console.error('Error saving order to server:', error);
                    });
            }

            // Show payment success with SweetAlert
            // Show payment success with SweetAlert - VERSI ESTETIK
            function showPaymentSuccess(orderData) {
                // Animation styling
                const style = document.createElement('style');
                style.textContent = `
        @keyframes confettiRain {
            0% { transform: translateY(-100px) rotate(0deg); opacity: 1; }
            100% { transform: translateY(100vh) rotate(360deg); opacity: 0; }
        }
        .confetti {
            position: fixed;
            width: 10px;
            height: 20px;
            background: var(--confetti-color);
            top: -20px;
            opacity: 0;
            animation: confettiRain 2s linear forwards;
            z-index: 99999;
        }
    `;
                document.head.appendChild(style);

                // Create confetti effect
                function createConfetti() {
                    const colors = ['#FF9F1C', '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7'];
                    for (let i = 0; i < 100; i++) {
                        setTimeout(() => {
                            const confetti = document.createElement('div');
                            confetti.className = 'confetti';
                            confetti.style.left = Math.random() * 100 + 'vw';
                            confetti.style.animationDelay = Math.random() * 0.5 + 's';
                            confetti.style.setProperty('--confetti-color', colors[Math.floor(Math.random() *
                                colors.length)]);
                            confetti.style.transform = `rotate(${Math.random() * 360}deg)`;
                            document.body.appendChild(confetti);

                            // Remove after animation
                            setTimeout(() => confetti.remove(), 2000);
                        }, i * 20);
                    }
                }

                // Create success sound effect
                function playSuccessSound() {
                    try {
                        const audioContext = new(window.AudioContext || window.webkitAudioContext)();
                        const oscillator = audioContext.createOscillator();
                        const gainNode = audioContext.createGain();

                        oscillator.connect(gainNode);
                        gainNode.connect(audioContext.destination);

                        oscillator.frequency.setValueAtTime(523.25, audioContext.currentTime); // C5
                        oscillator.frequency.setValueAtTime(659.25, audioContext.currentTime + 0.1); // E5
                        oscillator.frequency.setValueAtTime(783.99, audioContext.currentTime + 0.2); // G5

                        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);

                        oscillator.start();
                        oscillator.stop(audioContext.currentTime + 0.5);
                    } catch (e) {
                        console.log('Audio not supported');
                    }
                }

                // Play effects
                createConfetti();
                playSuccessSound();

                // SweetAlert dengan styling custom
                Swal.fire({
                    title: '<div style="font-size: 2.5rem;">🎉 Payment Successful!</div>',
                    html: `
            <div style="text-align: center;">
                <div style="margin: 20px 0;">
                    <i class="fas fa-check-circle" style="font-size: 80px; color: #28a745; margin-bottom: 20px;"></i>
                </div>

                <div style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); padding: 20px; border-radius: 15px; margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span style="font-weight: 600; color: var(--primary-color);">Order ID:</span>
                        <span style="font-family: 'Courier New', monospace; font-weight: 700;">${orderData.orderId}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span style="font-weight: 600; color: var(--primary-color);">Date:</span>
                        <span>${new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span style="font-weight: 600; color: var(--primary-color);">Payment:</span>
                        <span>${getPaymentMethodName(orderData.paymentMethod)}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-weight: 600; color: var(--primary-color);">Total:</span>
                        <span style="font-size: 1.2rem; font-weight: 700; color: #28a745;">Rp${orderData.totals.total.toLocaleString('id-ID')}</span>
                    </div>
                </div>

                <div style="background: #e8f5e9; padding: 15px; border-radius: 10px; margin-bottom: 20px; border-left: 4px solid #4CAF50;">
                    <p style="margin: 0; color: #2e7d32;">
                        <i class="fas fa-info-circle"></i>
                        Your order will be delivered within 1-2 hours. You'll receive a confirmation email shortly.
                    </p>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <div style="flex: 1; text-align: center; padding: 10px; background: #f0f0f0; border-radius: 8px;">
                        <i class="fas fa-box" style="color: var(--primary-color); margin-bottom: 5px;"></i>
                        <div style="font-size: 0.9rem; color: #666;">Package Prepared</div>
                    </div>
                    <div style="flex: 1; text-align: center; padding: 10px; background: #f0f0f0; border-radius: 8px;">
                        <i class="fas fa-shipping-fast" style="color: var(--primary-color); margin-bottom: 5px;"></i>
                        <div style="font-size: 0.9rem; color: #666;">On The Way</div>
                    </div>
                    <div style="flex: 1; text-align: center; padding: 10px; background: #f0f0f0; border-radius: 8px;">
                        <i class="fas fa-home" style="color: var(--primary-color); margin-bottom: 5px;"></i>
                        <div style="font-size: 0.9rem; color: #666;">Delivered</div>
                    </div>
                </div>
            </div>
        `,
                    width: 600,
                    padding: '2rem',
                    background: 'linear-gradient(135deg, #ffffff 0%, #f9f9f9 100%)',
                    backdrop: `
            rgba(0, 0, 0, 0.4)
            url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ff9f1c' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E")
        `,
                    showConfirmButton: true,
                    confirmButtonText: '<i class="fas fa-history"></i> View Order History',
                    showCancelButton: true,
                    cancelButtonText: '<i class="fas fa-shopping-cart"></i> Continue Shopping',
                    confirmButtonColor: '#3F2305',
                    cancelButtonColor: '#6c757d',
                    buttonsStyling: true,
                    customClass: {
                        popup: 'animated-popup',
                        title: 'swal-title-custom',
                        confirmButton: 'swal-confirm-button',
                        cancelButton: 'swal-cancel-button'
                    },
                    timer: 10000,
                    timerProgressBar: true,
                    didOpen: () => {
                        // Add custom animation
                        const popup = Swal.getPopup();
                        popup.style.animation = 'slideInUp 0.5s ease';
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to order history
                        window.location.href = '/profile#orders';
                    } else {
                        // Redirect to dashboard
                        window.location.href = '{{ route('dashboard') }}';
                    }
                });
            }

            // Helper function to get payment method name
            function getPaymentMethodName(method) {
                const methods = {
                    'cash': 'Cash on Delivery',
                    'e-wallet': 'E-Wallet',
                    'qris': 'QRIS'
                };
                return methods[method] || method;
            }

            // Initialize checkout
            loadCheckoutData();
        });
    </script>
@endsection
