<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'LastBite - Reducing Food Waste')</title>

    <!-- Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Your compiled app -->
    @vite(['resources/css/buyer-layout.css', 'resources/js/buyer-layout.js'])

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    @stack('styles')
</head>

<body>
    <!-- ========== HEADER/NAVBAR SECTION ========== -->
    <div class="navbar-container" id="navbarContainer">
        <!-- Logo - Redirect to Dashboard -->
        <a href="{{ route('dashboard') }}" class="navbar-logo">
            <img class="logo" src="{{ asset('images/LOGO LASTBITE.png') }}" alt="LastBite" />
        </a>

        <!-- ========== SEARCH COMPONENT ========== -->
        <div class="search-wrapper">
            <!-- Search Input -->
            <div class="search-container" id="searchContainer">
                <div class="search-input-wrapper">
                    <i class="fas fa-search search-icon-left"></i>
                    <input type="text" class="search-input" placeholder="Search for food items..." id="searchInput"
                        autocomplete="off" />
                </div>

                <div class="search-actions">
                    <!-- Filter Button -->
                    <button type="button" class="search-action-btn filter-btn" id="filterBtn" onclick="toggleFilter()">
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
                        <span id="searchTitle">Search</span>
                    </div>
                    <button class="search-clear-btn" onclick="clearAll()">Clear All</button>
                </div>

                <!-- Content -->
                <div class="search-content" id="searchContent">
                    <!-- History Section (shown by default) -->
                    <div class="search-history" id="historySection">
                        <div class="history-title">
                            <span>Recent Searches</span>
                            <button class="clear-history-btn" onclick="clearHistory()">Clear All</button>
                        </div>
                        <div class="history-list" id="historyList">
                            <!-- History items will be dynamically added here -->
                        </div>
                    </div>

                    <!-- Filter Section (hidden by default) -->
                    <div class="filter-section" id="filterSection" style="display: none;">
                        <div class="filter-title">
                            <i class="fas fa-sliders-h"></i>
                            Search Filters
                        </div>

                        <!-- Price Filter -->
                        <div class="filter-group">
                            <div class="filter-group-header">
                                <div class="filter-group-label">
                                    <i class="fas fa-tag"></i>
                                    Price Range
                                </div>
                                <div class="filter-group-value" id="priceValue">Rp 0 - 50,000</div>
                            </div>
                            <div class="price-filter">
                                <div class="price-inputs">
                                    <div class="price-input-group">
                                        <label>Min Price</label>
                                        <input type="number" class="price-input" id="minPriceInput" placeholder="0"
                                            min="0" max="100000" step="1000"
                                            onchange="updatePriceFromInput()">
                                    </div>
                                    <div class="price-separator">-</div>
                                    <div class="price-input-group">
                                        <label>Max Price</label>
                                        <input type="number" class="price-input" id="maxPriceInput" placeholder="50000"
                                            min="0" max="100000" step="1000"
                                            onchange="updatePriceFromInput()">
                                    </div>
                                </div>
                                <input type="range" class="price-slider" id="priceSlider" min="0"
                                    max="100000" step="1000" value="50000" oninput="updatePriceFromSlider()">
                                <div class="price-labels">
                                    <span>Rp 0</span>
                                    <span>Rp 25k</span>
                                    <span>Rp 50k</span>
                                    <span>Rp 75k</span>
                                    <span>Rp 100k</span>
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
                                <div class="filter-group-value" id="ratingValue">All</div>
                            </div>

                            <div class="rating-options">
                                {{-- FIX: All Ratings should be null --}}
                                <div class="rating-option" onclick="selectRating(null)">
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-label">All Ratings</span>
                                </div>

                                <div class="rating-option" onclick="selectRating(4)">
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <span class="rating-label">4.0 & above</span>
                                </div>

                                <div class="rating-option" onclick="selectRating(3)">
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <span class="rating-label">3.0 & above</span>
                                </div>
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div class="filter-group">
                            <div class="filter-group-header">
                                <div class="filter-group-label">
                                    <i class="fas fa-utensils"></i>
                                    Category
                                </div>
                                <div class="filter-group-value" id="categoryValue">All</div>
                            </div>
                            <div class="category-options">
                                <div class="category-chip" data-key="bakery" onclick="toggleCategory('bakery')">
                                    <span>Bread & Bakery</span>
                                </div>
                                <div class="category-chip" data-key="dairy" onclick="toggleCategory('dairy')">
                                    <span>Dairy Products</span>
                                </div>
                                <div class="category-chip" data-key="fruits" onclick="toggleCategory('fruits')">
                                    <span>Fruits & Vegetables</span>
                                </div>
                                <div class="category-chip" data-key="meat" onclick="toggleCategory('meat')">
                                    <span>Meat & Fish</span>
                                </div>
                                <div class="category-chip" data-key="ready" onclick="toggleCategory('ready')">
                                    <span>Ready to Eat</span>
                                </div>
                            </div>
                        </div>

                        <!-- Active Filters -->
                        <div class="active-filters" id="activeFilters">
                            <!-- Active filter tags will be added here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========== ACTION BUTTONS ========== -->
        <div class="nav-actions">
            <!-- Cart Button -->
            <a href="{{ route('cart.index') }}" class="cart-link">
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
                    <li><a class="dropdown-item" href="{{ route('profile.orders') }}"><i
                                class="fas fa-history"></i>Order History</a></li>
                    <li><a class="dropdown-item" href="{{ route('favorites') }}"><i
                                class="fas fa-heart"></i>Favorites</a></li>
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

    <!-- ========== SEARCH RESULTS CONTAINER ========== -->
    <div class="search-results-container" id="searchResultsContainer">
        <div class="search-results-header">
            <div>
                <span class="results-title">Search Results</span>
                <span class="results-count" id="resultsCount">(0 items)</span>
                <div class="results-summary" id="resultsSummary">No filters applied</div>
            </div>
            <button class="close-results-btn" onclick="closeResults()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="search-results-grid" id="searchResultsGrid">
            <!-- Search results will be dynamically added here -->
        </div>
    </div>

    <!-- ========== MAIN CONTENT ========== -->
    <main>
        @yield('content')
    </main>

    <!-- ========== NOTIFICATION ========== -->
    <div class="notification" id="notification">
        <i class="fas fa-check-circle"></i>
        <span id="notificationMessage">Product added to cart!</span>
    </div>

    <!-- ========== FOOTER SECTION ========== -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <!-- Column 1: Brand & Social -->
                <div class="footer-column">
                    <div class="footer-brand">
                        <img src="{{ asset('images/LOGO LASTBITE.png') }}" alt="LastBite Logo" class="footer-logo">
                        <p class="footer-description">
                            LastBite is your trusted platform to reduce food waste and save money.
                            We connect you with quality food at amazing prices before it goes to waste.
                        </p>
                    </div>
                    <div class="footer-social">
                        <a href="https://facebook.com" target="_blank" class="social-icon" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://instagram.com" target="_blank" class="social-icon" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://twitter.com" target="_blank" class="social-icon" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://linkedin.com" target="_blank" class="social-icon" title="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://youtube.com" target="_blank" class="social-icon" title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div class="footer-column">
                    <h3 class="footer-title">Quick Links</h3>
                    <div class="footer-links">
                        <a href="{{ route('dashboard') }}" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            Home
                        </a>
                        <a href="#" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            About Us
                        </a>
                        <a href="#" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            How It Works
                        </a>
                        <a href="{{ route('cart.index') }}" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            Shopping Cart
                        </a>
                        <a href="{{ route('favorites') }}" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            Favorites
                        </a>
                    </div>
                </div>

                <!-- Column 3: Support -->
                <div class="footer-column">
                    <h3 class="footer-title">Support</h3>
                    <div class="footer-links">
                        <a href="#" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            Help Center
                        </a>
                        <a href="#" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            FAQs
                        </a>
                        <a href="#" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            Terms & Conditions
                        </a>
                        <a href="#" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            Privacy Policy
                        </a>
                        <a href="#" class="footer-link">
                            <i class="fas fa-chevron-right"></i>
                            Contact Us
                        </a>
                    </div>
                </div>

                <!-- Column 4: Contact Info -->
                <div class="footer-column">
                    <h3 class="footer-title">Contact Us</h3>
                    <div class="footer-contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-text">
                            <strong>Address</strong>
                            Jl. Raya Darmo No. 123<br>
                            Surabaya, East Java 60241
                        </div>
                    </div>
                    <div class="footer-contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="contact-text">
                            <strong>Phone</strong>
                            +62 812-3456-7890
                        </div>
                    </div>
                    <div class="footer-contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-text">
                            <strong>Email</strong>
                            support@lastbite.com
                        </div>
                    </div>
                </div>

                <!-- Column 5: Newsletter & Apps -->
                <div class="footer-column">
                    <h3 class="footer-title">Stay Updated</h3>
                    <div class="footer-newsletter">
                        <p class="newsletter-text">
                            Subscribe to our newsletter for special offers and updates!
                        </p>
                        <form class="newsletter-form" onsubmit="handleNewsletterSubmit(event)">
                            <input type="email" class="newsletter-input" placeholder="Your email address"
                                id="newsletterEmail" required>
                            <button type="submit" class="newsletter-btn">
                                Subscribe
                            </button>
                        </form>
                    </div>

                    <h4 class="footer-title" style="margin-top: 25px;">Download App</h4>
                    <div class="footer-apps">
                        <a href="#" class="app-button">
                            <i class="fab fa-apple app-icon"></i>
                            <div class="app-text">
                                <small>Download on the</small>
                                <strong>App Store</strong>
                            </div>
                        </a>
                        <a href="#" class="app-button">
                            <i class="fab fa-google-play app-icon"></i>
                            <div class="app-text">
                                <small>Get it on</small>
                                <strong>Google Play</strong>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="footer-copyright">
                    &copy; 2024 <a href="{{ route('dashboard') }}">LastBite</a>. All rights reserved.
                    Made with <i class="fas fa-heart" style="color: var(--danger-color);"></i> to reduce food waste.
                </div>

                <div class="footer-bottom-links">
                    <a href="#" class="footer-bottom-link">Privacy Policy</a>
                    <a href="#" class="footer-bottom-link">Terms of Service</a>
                    <a href="#" class="footer-bottom-link">Cookie Policy</a>
                    <a href="#" class="footer-bottom-link">Sitemap</a>
                </div>

                <div class="footer-payment">
                    <span style="color: rgba(255, 255, 255, 0.7); font-size: 13px; margin-right: 10px;">
                        We Accept:
                    </span>
                    <div class="payment-icon" title="Visa">
                        <i class="fab fa-cc-visa"></i>
                    </div>
                    <div class="payment-icon" title="Mastercard">
                        <i class="fab fa-cc-mastercard"></i>
                    </div>
                    <div class="payment-icon" title="PayPal">
                        <i class="fab fa-cc-paypal"></i>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop" onclick="scrollToTop()">
        <i class="fas fa-chevron-up"></i>
    </button>

    @stack('scripts')
</body>

</html>
