@extends('layouts.app')

@section('content')
    <!-- Flash Sale Section -->
    <section class="flash-sale-section">
        <div class="container">
            <h2 class="text-center mb-4">Flash Sale</h2>
            <div class="row">
                @foreach ($flashSaleProducts as $index => $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="product-card p-3">
                            <h5 class="product-name">{{ $product['name'] }}</h5>
                            <p class="store-name text-muted mb-1">{{ $product['store'] }}</p>

                            <!-- Star Rating -->
                            <div class="star-rating mb-2">
                                @for ($i = 0; $i < $product['rating']; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                                <span class="text-muted">({{ $product['review_count'] }})</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price fw-bold text-primary">{{ $product['price'] }}</span>
                                <button class="btn btn-primary btn-sm">
                                    Add to Cart {{ $product['cart_count'] }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
