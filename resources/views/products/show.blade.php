@extends('layouts.buyer')

@section('content')
    @php
        use Illuminate\Support\Str;
    @endphp

    {{-- Page-only assets (JANGAN sentuh buyer-layout.css) --}}
    @vite(['resources/css/product-detail.css', 'resources/js/product-detail.js'])

    <div class="product-detail-container">

        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Home</a> /
            <a href="#">{{ ucfirst($product->category) }}</a> /
            <span>{{ Str::limit($product->name, 30) }}</span>
        </div>

        <!-- Product Detail Grid -->
        <div class="product-detail-grid">

            <!-- Product Images (HANYA 1 GAMBAR BESAR, TANPA PREVIEW THUMBNAIL) -->
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

                    <img id="mainImage" class="main-product-img" src="{{ $product->image_full_url }}" alt="{{ $product->name }}"
                        loading="eager"
                        onerror="this.dataset.fallback=1; this.src='https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=1200&q=80';">
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

                <!-- Title -->
                <h1 class="product-title">{{ $product->name }}</h1>

                <!-- Category Badge -->
                <div class="category-badge">{{ ucfirst($product->category) }}</div>

                <!-- Description -->
                <div class="description-section">
                    <div class="description-content">
                        {{ $product->description }}
                    </div>
                </div>

                <!-- Rating SIMPLE -->
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

                <!-- Price Section -->
                <div class="price-section">
                    <div class="price-display">
                        <span class="current-price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>

                        <div class="price-comparison">
                            <span class="original-price">
                                Rp{{ number_format($product->original_price, 0, ',', '.') }}
                            </span>
                            <span class="discount-badge">-{{ $product->discount_percent }}%</span>
                        </div>
                    </div>

                    <div class="price-note">
                        <i class="fas fa-piggy-bank"></i>
                        Save Rp{{ number_format($product->original_price - $product->price, 0, ',', '.') }}
                        compared to retail price
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button class="action-btn btn-buy" data-buy-now="{{ $product->id }}">
                        <i class="fas fa-bolt"></i>
                        Buy Now
                    </button>

                    <button class="action-btn btn-cart" data-add-to-cart="{{ $product->id }}"
                        data-product-name="{{ $product->name }}" data-product-price="{{ $product->price }}">
                        <i class="fas fa-shopping-cart"></i>
                        Add to Cart
                    </button>
                </div>

                <!-- Benefits -->
                <div class="benefits-section">
                    <h3 class="benefits-title">
                        <i class="fas fa-gift"></i>
                        Why Shop With Us
                    </h3>

                    <div class="benefits-grid">
                        <div class="benefit-item">
                            <div class="benefit-icon"><i class="fas fa-truck"></i></div>
                            <div class="benefit-text">
                                <h4>Fast Delivery</h4>
                                <p>Same-day delivery available</p>
                            </div>
                        </div>

                        <div class="benefit-item">
                            <div class="benefit-icon"><i class="fas fa-shield-alt"></i></div>
                            <div class="benefit-text">
                                <h4>Quality Guarantee</h4>
                                <p>Fresh and safe products</p>
                            </div>
                        </div>

                        <div class="benefit-item">
                            <div class="benefit-icon"><i class="fas fa-recycle"></i></div>
                            <div class="benefit-text">
                                <h4>Eco Friendly</h4>
                                <p>Reduce food waste</p>
                            </div>
                        </div>

                        <div class="benefit-item">
                            <div class="benefit-icon"><i class="fas fa-percent"></i></div>
                            <div class="benefit-text">
                                <h4>Best Prices</h4>
                                <p>Up to 70% off retail price</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Positive Impact -->
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
                            <div class="impact-stat-icon"><i class="fas fa-cloud"></i></div>
                            <div class="impact-stat-value">{{ $impact['co2_saved'] ?? '12.5' }} kg</div>
                            <div class="impact-stat-label">CO₂ Emissions Prevented</div>
                        </div>

                        <div class="impact-stat-item">
                            <div class="impact-stat-icon"><i class="fas fa-tint"></i></div>
                            <div class="impact-stat-value">{{ $impact['water_saved'] ?? '380' }} L</div>
                            <div class="impact-stat-label">Water Saved</div>
                        </div>

                        <div class="impact-stat-item">
                            <div class="impact-stat-icon"><i class="fas fa-utensils"></i></div>
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
                    @foreach ($recommendedProducts as $p)
                        @php
                            $productId = is_object($p) ? $p->id : $p['id'];
                            $productName = is_object($p) ? $p->name : $p['name'];
                            $productPrice = is_object($p) ? $p->price : $p['price'];
                            $productOriginalPrice = is_object($p) ? $p->original_price : $p['original_price'];
                            $productDiscountPercent = is_object($p) ? $p->discount_percent : $p['discount_percent'];
                            $productCategory = is_object($p) ? $p->category : $p['category'];
                            $productImageUrl = is_object($p) ? $p->image_full_url : $p['image_full_url'];
                            $productRating = is_object($p) ? $p->rating : $p['rating'];
                            $productRatingCount = is_object($p) ? $p->rating_count : $p['rating_count'];
                            $productIsFlashSale = is_object($p) ? $p->is_flash_sale : $p['is_flash_sale'];
                        @endphp

                        <div class="product-card" onclick="window.location.href='{{ route('product.show', $productId) }}'">
                            @if ($productIsFlashSale || $productDiscountPercent >= 20)
                                <span class="flash-badge">Flash Sale</span>
                            @elseif($productDiscountPercent > 0)
                                <span class="recommended-badge">Save {{ $productDiscountPercent }}%</span>
                            @endif

                            <div class="product-image-container">
                                <img src="{{ $productImageUrl }}" alt="{{ $productName }}" class="product-image"
                                    loading="lazy"
                                    onerror="this.dataset.fallback=1; this.src='https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=900&q=80';">
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
                                        onclick="window.LastBiteProductDetail.addToCartFromCard(event, {{ $productId }}, '{{ addslashes($productName) }}', {{ $productPrice }})"
                                        aria-label="Add to cart" type="button">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    {{-- Data untuk JS page ini (tidak ubah struktur data / logika) --}}
    <script>
        window.__LASTBITE_PRODUCT__ = @json($product);
        window.__LASTBITE_CART_REDIRECT__ = "{{ route('cart.index') ?? '/cart' }}";
    </script>
@endsection
