@extends('layouts.buyer')

@section('content')

    @php
        use Illuminate\Support\Str;

        $resolveImage = function ($url) {
            $url = (string) $url;
            if ($url === '') {
                return 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=500&q=80';
            }
            if (Str::startsWith($url, ['http://', 'https://'])) {
                return $url;
            }
            if (Str::startsWith($url, 'storage/')) {
                return asset($url);
            }
            return asset('storage/' . ltrim($url, '/'));
        };
    @endphp

    {{-- Pastikan CSRF meta ada (cart.js juga coba baca ini). Kalau layout sudah ada, ini tetap aman --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS (harus sebelum cart.js) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    {{-- INJECT CONFIG DULU, BARU @vite --}}
    <script>
        window.CART_CFG = {
            // endpoints
            summaryUrl: @json(route('cart.summary')),
            addUrl: @json(route('cart.add')),
            updateUrl: @json(route('cart.update')),
            removeUrl: @json(route('cart.remove')),
            checkoutUrl: @json(route('checkout.index')),
            dashboardUrl: @json(route('dashboard')),

            // auth + csrf
            isAuth: @json(Auth::check()),
            csrf: @json(csrf_token()),

            // optional: initial items dari server (kalau controller ngirim)
            initialItems: @json($cartItems ?? []),

            // fees
            deliveryFee: 10000,
            serviceFee: 2000,
        };

        /**
         * ✅ BRIDGE UNTUK cart.js KAMU
         * cart.js yang kamu kirim tidak membaca CART_CFG,
         * dia membaca variabel __XXX__ ini.
         * Jadi kita map biar tombol qty/remove berfungsi tanpa ubah CSS/class.
         */
        window.__CSRF__ = window.CART_CFG.csrf;
        window.__IS_AUTH__ = window.CART_CFG.isAuth;

        window.__CART_SUMMARY_URL__ = window.CART_CFG.summaryUrl;
        window.__CART_ADD_URL__ = window.CART_CFG.addUrl;
        window.__CART_UPDATE_URL__ = window.CART_CFG.updateUrl;
        window.__CART_REMOVE_URL__ = window.CART_CFG.removeUrl;

        window.__CHECKOUT_URL__ = window.CART_CFG.checkoutUrl;
        window.__DASHBOARD_URL__ = window.CART_CFG.dashboardUrl;

        // fallback items kalau summary gagal
        window.__CART_ITEMS__ = window.CART_CFG.initialItems;
    </script>

    @vite(['resources/css/cart.css', 'resources/js/cart.js'])

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
                    <!-- rendered by JS -->
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
                        @php
                            // amanin nilai-nilai yang sering null
                            $recId = (int) ($recProduct->id ?? 0);
                            $recName = (string) ($recProduct->name ?? '');
                            $recCategory = (string) ($recProduct->category ?? '');
                            $recPrice = (int) ($recProduct->price ?? 0);
                            $recOriginal = (int) ($recProduct->original_price ?? $recPrice);
                            $recDiscount = (int) ($recProduct->discount_percent ?? 0);
                            $recFlash = (bool) ($recProduct->is_flash_sale ?? false);
                            $recRating = (float) ($recProduct->rating ?? 4.5);
                            $recRatingCount = (int) ($recProduct->rating_count ?? 10);
                            $recImg = $resolveImage($recProduct->image_url ?? '');
                        @endphp

                        <div class="product-card js-product-card" data-href="{{ route('product.show', $recId) }}"
                            role="link" tabindex="0" aria-label="Open product: {{ $recName }}">

                            @if ($recFlash || $recDiscount >= 20)
                                <span class="flash-badge">Flash Sale</span>
                            @elseif($recDiscount > 0)
                                <span class="recommended-badge">Save {{ $recDiscount }}%</span>
                            @endif

                            <div class="product-image-container">
                                <img src="{{ $recImg }}" alt="{{ $recName }}" class="product-image"
                                    loading="lazy">
                            </div>

                            <div class="product-info">
                                <h3 class="product-name">{{ \Illuminate\Support\Str::limit($recName, 40) }}</h3>
                                <span
                                    class="product-category">{{ $recCategory !== '' ? ucfirst($recCategory) : 'Product' }}</span>

                                <div class="product-rating">
                                    <div class="stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($recRating))
                                                <i class="fas fa-star"></i>
                                            @elseif($i - 0.5 <= $recRating)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="rating-count">({{ number_format($recRatingCount) }})</span>
                                </div>

                                <div class="product-price">
                                    <div class="price-container">
                                        <span class="current-price-sm">Rp{{ number_format($recPrice, 0, ',', '.') }}</span>

                                        @if ($recOriginal > $recPrice)
                                            <span
                                                class="original-price-sm">Rp{{ number_format($recOriginal, 0, ',', '.') }}</span>
                                        @endif
                                    </div>

                                    {{-- IMPORTANT: data-action dipakai JS untuk deteksi klik add-to-cart --}}
                                    <button type="button" class="add-to-cart-btn" data-action="add-to-cart"
                                        data-product-id="{{ $recId }}" data-product-name="{{ $recName }}"
                                        aria-label="Add to cart"
                                        style="position:relative; z-index:50; pointer-events:auto;">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-reco">
                    <i class="fas fa-box-open"></i>
                    <h4>No products available</h4>
                    <p>Please add products to the database first.</p>
                    <a href="{{ route('dashboard') }}" class="empty-reco-btn">Go to Dashboard</a>
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
                                    <div class="payment-method-desc">Scan QR code to pay with any mobile banking app</div>
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
                        <div class="payment-summary-row"><span>Subtotal:</span><span id="modalSubtotal">Rp0</span></div>
                        <div class="payment-summary-row"><span>Delivery:</span><span id="modalDelivery">Rp0</span></div>
                        <div class="payment-summary-row"><span>Service Fee:</span><span id="modalService">Rp0</span></div>
                        <div class="payment-summary-row"><span>Discount:</span><span id="modalDiscount"
                                class="text-success">-Rp0</span></div>
                        <div class="payment-summary-total"><span>Total:</span><span id="modalTotal">Rp0</span></div>
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
                        <div class="voucher-validity"><i class="far fa-calendar-alt"></i><span>Valid until: 31 December
                                2024</span></div>
                    </div>

                    <div class="voucher-card" data-code="FOODSAVER20" data-discount="20">
                        <div class="voucher-header">
                            <span class="voucher-code">FOODSAVER20</span>
                            <span class="voucher-discount">20% OFF</span>
                        </div>
                        <div class="voucher-title">Food Saver Special</div>
                        <div class="voucher-desc">Save 20% on all food items near expiry date</div>
                        <div class="voucher-validity"><i class="far fa-calendar-alt"></i><span>Valid until: 31 December
                                2024</span></div>
                    </div>

                    <div class="voucher-card" data-code="FLASH15" data-discount="15">
                        <div class="voucher-header">
                            <span class="voucher-code">FLASH15</span>
                            <span class="voucher-discount">15% OFF</span>
                        </div>
                        <div class="voucher-title">Flash Sale Discount</div>
                        <div class="voucher-desc">Extra 15% off on all flash sale items</div>
                        <div class="voucher-validity"><i class="far fa-calendar-alt"></i><span>Valid until: 31 December
                                2024</span></div>
                    </div>

                    <div class="voucher-card" data-code="FREESHIP" data-discount-type="delivery">
                        <div class="voucher-header">
                            <span class="voucher-code">FREESHIP</span>
                            <span class="voucher-discount" style="color:#ff6b6b;">FREE SHIPPING</span>
                        </div>
                        <div class="voucher-title">Free Delivery</div>
                        <div class="voucher-desc">Free delivery on orders above Rp 50.000</div>
                        <div class="voucher-validity"><i class="far fa-calendar-alt"></i><span>Valid until: 31 December
                                2024</span></div>
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
@endsection
