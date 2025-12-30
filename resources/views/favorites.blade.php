@extends('layouts.buyer')

@section('content')
    <style>
        /* ========== ROOT VARIABLES ========== */
        :root {
            --primary-color: #3F2305;
            --primary-light: #6E3F0C;
            --primary-dark: #2A1703;
            --accent-color: #FF9F1C;
            --danger-color: #FF4757;
            --success-color: #2ECC71;
            --text-dark: #2C2C2C;
            --text-light: #7A7A7A;
            --bg-light: #F9F5F0;
            --white: #FFFFFF;
            --shadow-light: 0 4px 20px rgba(63, 35, 5, 0.08);
            --shadow-medium: 0 6px 25px rgba(63, 35, 5, 0.12);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ========== RESET & BASE ========== */
        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg-light);
            color: var(--text-dark);
            min-height: 100vh;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ========== FAVORITES LAYOUT ========== */
        .favorites-layout {
            display: flex;
            gap: 40px;
            margin: 40px auto;
            max-width: 1400px;
            padding: 0 20px;
        }

        /* Favorites Sidebar */
        .favorites-sidebar {
            width: 300px;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow-medium);
            position: sticky;
            top: 120px;
            height: fit-content;
        }

        .favorites-icon-large {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 25px;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .favorites-title {
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
        }

        .favorites-subtitle {
            font-size: 14px;
            opacity: 0.9;
            text-align: center;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .favorites-stats {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .stat-item:last-child {
            margin-bottom: 0;
        }

        .stat-value {
            font-weight: 600;
            color: var(--accent-color);
        }

        .empty-favorites {
            text-align: center;
            padding: 40px 20px;
        }

        .empty-favorites-icon {
            font-size: 60px;
            color: rgba(255, 255, 255, 0.3);
            margin-bottom: 20px;
        }

        .empty-favorites-text {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 20px;
        }

        .browse-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
        }

        .browse-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }

        /* Favorites Content */
        .favorites-content {
            flex: 1;
            min-width: 0;
        }

        .favorites-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .favorites-main-title {
            font-size: 36px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }

        .filters-section {
            background: var(--white);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: var(--shadow-light);
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-btn {
            background: var(--bg-light);
            border: 1px solid rgba(63, 35, 5, 0.1);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            color: var(--text-dark);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .filter-btn:hover {
            background: var(--primary-light);
            color: white;
        }

        .clear-favorites-btn {
            background: var(--white);
            color: var(--danger-color);
            border: 2px solid var(--danger-color);
            padding: 12px 24px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
            margin-left: auto;
        }

        .clear-favorites-btn:hover {
            background: var(--danger-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 71, 87, 0.2);
        }

        /* Favorites Grid */
        .favorites-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .favorite-card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-light);
            transition: var(--transition);
            position: relative;
            border: 1px solid rgba(63, 35, 5, 0.08);
        }

        .favorite-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
            border-color: var(--primary-color);
        }

        .favorite-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--danger-color);
            color: var(--white);
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 700;
            z-index: 2;
        }

        .favorite-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: linear-gradient(135deg, #f9f5f0, #e8dfd3);
        }

        .favorite-content {
            padding: 20px;
        }

        .favorite-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .favorite-name {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 5px;
            flex: 1;
        }

        .favorite-category {
            font-size: 12px;
            color: var(--text-light);
            background: rgba(63, 35, 5, 0.05);
            padding: 2px 8px;
            border-radius: 10px;
            display: inline-block;
            margin-bottom: 10px;
        }

        .favorite-price {
            font-size: 22px;
            font-weight: 700;
            color: var(--accent-color);
            margin-bottom: 10px;
        }

        .favorite-description {
            font-size: 13px;
            color: var(--text-dark);
            line-height: 1.5;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .favorite-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: var(--text-light);
            margin-bottom: 15px;
        }

        .favorite-distance {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .favorite-expiry {
            color: var(--danger-color);
            font-weight: 600;
        }

        .favorite-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid rgba(63, 35, 5, 0.1);
        }

        .add-to-cart-btn {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .add-to-cart-btn:hover {
            background: var(--primary-dark);
            transform: scale(1.05);
        }

        .remove-favorite-btn {
            background: none;
            border: none;
            color: var(--danger-color);
            cursor: pointer;
            font-size: 16px;
            transition: var(--transition);
            padding: 8px;
            border-radius: 50%;
        }

        .remove-favorite-btn:hover {
            background: rgba(255, 71, 87, 0.1);
            transform: scale(1.1);
        }

        /* Empty State */
        .empty-favorites-main {
            text-align: center;
            padding: 60px 20px;
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow-light);
        }

        .empty-favorites-main-icon {
            font-size: 80px;
            color: var(--text-light);
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-favorites-main-title {
            font-size: 24px;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .empty-favorites-main-text {
            color: var(--text-light);
            margin-bottom: 30px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .start-shopping-btn {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 14px 32px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            text-decoration: none;
        }

        .start-shopping-btn:hover {
            background: var(--primary-dark);
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(63, 35, 5, 0.2);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .favorites-layout {
                flex-direction: column;
            }

            .favorites-sidebar {
                width: 100%;
                position: static;
                margin-bottom: 30px;
            }
        }

        @media (max-width: 768px) {
            .favorites-header {
                flex-direction: column;
                gap: 20px;
                align-items: flex-start;
            }

            .clear-favorites-btn {
                width: 100%;
                justify-content: center;
            }

            .filters-section {
                flex-direction: column;
                align-items: flex-start;
            }

            .favorites-grid {
                grid-template-columns: 1fr;
            }

            .favorite-card {
                max-width: 400px;
                margin: 0 auto;
            }
        }
    </style>
    </head>

    <body>
        <!-- ========== FAVORITES CONTENT ========== -->
        <div class="favorites-layout">
            <!-- Favorites Sidebar -->
            <div class="favorites-sidebar">
                <div class="favorites-icon-large">
                    <i class="fas fa-heart"></i>
                </div>

                <h2 class="favorites-title">My Favorites</h2>
                <div class="favorites-subtitle">Foods you love at amazing prices</div>

                <div class="favorites-stats" id="favoritesStats">
                    <!-- Stats will be populated by JavaScript -->
                </div>
            </div>

            <!-- Main Favorites Content -->
            <div class="favorites-content">
                <!-- Header -->
                <div class="favorites-header">
                    <h1 class="favorites-main-title">Favorite Items</h1>
                    <button class="clear-favorites-btn" id="clearAllFavoritesBtn">
                        <i class="fas fa-trash"></i>
                        Clear All Favorites
                    </button>
                </div>

                <!-- Filters -->
                <div class="filters-section">
                    <button class="filter-btn active" onclick="filterFavorites('all')">
                        <i class="fas fa-list"></i>
                        All Items
                    </button>
                    <button class="filter-btn" onclick="filterFavorites('discount')">
                        <i class="fas fa-percentage"></i>
                        Discounted
                    </button>
                    <button class="filter-btn" onclick="filterFavorites('expiring')">
                        <i class="fas fa-clock"></i>
                        Expiring Soon
                    </button>
                    <button class="filter-btn" onclick="filterFavorites('nearby')">
                        <i class="fas fa-map-marker-alt"></i>
                        Nearby
                    </button>
                </div>

                <!-- Favorites Grid -->
                <div class="favorites-grid" id="favoritesGrid">
                    <!-- Favorite items will be loaded here -->
                </div>

                <!-- Empty State -->
                <div class="empty-favorites-main" id="emptyFavoritesState" style="display: none;">
                    <div class="empty-favorites-main-icon">
                        <i class="fas fa-heart-broken"></i>
                    </div>
                    <h3 class="empty-favorites-main-title">No favorites yet</h3>
                    <p class="empty-favorites-main-text">
                        You haven't added any items to your favorites. Start exploring amazing deals on food that's close to
                        expiry but still perfectly good to eat!
                    </p>
                    <a href="{{ route('dashboard') }}" class="start-shopping-btn">
                        <i class="fas fa-store"></i>
                        Start Shopping
                    </a>
                </div>
            </div>
        </div>

        <!-- ========== JAVASCRIPT ========== -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // CSRF Token
            const csrfToken = "{{ csrf_token() }}";
            const user = @json(auth()->user());

            // Initialize
            document.addEventListener('DOMContentLoaded', function() {
                loadFavorites();
                updateFavoritesStats();
            });

            // Load favorites from localStorage
            function loadFavorites() {
                const favoritesGrid = document.getElementById('favoritesGrid');
                const emptyState = document.getElementById('emptyFavoritesState');

                // Get favorites from localStorage
                let favorites = JSON.parse(localStorage.getItem('lastbite_favorites')) || [];

                if (favorites.length === 0) {
                    favoritesGrid.innerHTML = '';
                    emptyState.style.display = 'block';
                    return;
                }

                emptyState.style.display = 'none';

                // Sort by added date (newest first)
                favorites.sort((a, b) => new Date(b.addedAt) - new Date(a.addedAt));

                // Render favorites
                favoritesGrid.innerHTML = favorites.map(product => `
                <div class="favorite-card" data-id="${product.id}" data-category="${product.category}" data-price="${product.price}">
                    ${product.discount ? `<span class="favorite-badge">${product.discount}% OFF</span>` : ''}

                    <img src="${product.image || 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=400&h=250&fit=crop'}"
                         alt="${product.name}" class="favorite-image">

                    <div class="favorite-content">
                        <div class="favorite-header">
                            <div>
                                <h3 class="favorite-name">${product.name}</h3>
                                <span class="favorite-category">${product.category}</span>
                            </div>
                        </div>

                        <div class="favorite-price">
                            Rp${product.discountedPrice ? product.discountedPrice.toLocaleString('id-ID') : product.price.toLocaleString('id-ID')}
                            ${product.discount ? `<span style="font-size: 14px; color: var(--text-light); text-decoration: line-through; margin-left: 8px;">
                                                    Rp${product.price.toLocaleString('id-ID')}
                                                </span>` : ''}
                        </div>

                        <p class="favorite-description">${product.description || 'Delicious food item at a great price to reduce food waste.'}</p>

                        <div class="favorite-details">
                            <div class="favorite-distance">
                                <i class="fas fa-map-marker-alt"></i>
                                ${product.distance || '2.5'} km away
                            </div>
                            <div class="favorite-expiry">
                                <i class="fas fa-clock"></i>
                                Expires in ${product.expiry || '2'} days
                            </div>
                        </div>

                        <div class="favorite-actions">
                            <button class="add-to-cart-btn" onclick="addToCart(${product.id})">
                                <i class="fas fa-cart-plus"></i>
                                Add to Cart
                            </button>
                            <button class="remove-favorite-btn" onclick="removeFromFavorites(${product.id})">
                                <i class="fas fa-heart-broken"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
            }

            // Update favorites statistics
            function updateFavoritesStats() {
                const statsContainer = document.getElementById('favoritesStats');
                let favorites = JSON.parse(localStorage.getItem('lastbite_favorites')) || [];

                if (favorites.length === 0) {
                    statsContainer.innerHTML = `
                    <div class="empty-favorites">
                        <div class="empty-favorites-icon">
                            <i class="fas fa-heart-broken"></i>
                        </div>
                        <p class="empty-favorites-text">No favorites yet</p>
                        <a href="{{ route('dashboard') }}" class="browse-btn">
                            <i class="fas fa-store"></i>
                            Browse Items
                        </a>
                    </div>
                `;
                    return;
                }

                // Calculate stats
                const totalItems = favorites.length;
                const totalValue = favorites.reduce((sum, product) => sum + (product.discountedPrice || product.price), 0);
                const discountedItems = favorites.filter(p => p.discount).length;
                const expiringSoon = favorites.filter(p => parseInt(p.expiry) <= 2).length;

                statsContainer.innerHTML = `
                <div class="stat-item">
                    <span>Total Items:</span>
                    <span class="stat-value">${totalItems}</span>
                </div>
                <div class="stat-item">
                    <span>Total Value:</span>
                    <span class="stat-value">Rp${totalValue.toLocaleString('id-ID')}</span>
                </div>
                <div class="stat-item">
                    <span>Discounted:</span>
                    <span class="stat-value">${discountedItems} items</span>
                </div>
                <div class="stat-item">
                    <span>Expiring Soon:</span>
                    <span class="stat-value">${expiringSoon} items</span>
                </div>
            `;
            }

            // Filter favorites
            function filterFavorites(filterType) {
                const filterBtns = document.querySelectorAll('.filter-btn');
                filterBtns.forEach(btn => btn.classList.remove('active'));
                event.target.classList.add('active');

                let favorites = JSON.parse(localStorage.getItem('lastbite_favorites')) || [];

                switch (filterType) {
                    case 'discount':
                        favorites = favorites.filter(p => p.discount);
                        break;
                    case 'expiring':
                        favorites = favorites.filter(p => parseInt(p.expiry) <= 2);
                        break;
                    case 'nearby':
                        favorites = favorites.filter(p => parseFloat(p.distance) <= 5);
                        break;
                    default:
                        // Show all
                }

                // Re-render filtered favorites
                const favoritesGrid = document.getElementById('favoritesGrid');
                if (favorites.length === 0) {
                    favoritesGrid.innerHTML = '';
                    document.getElementById('emptyFavoritesState').style.display = 'block';
                } else {
                    loadFavorites(); // Reload with filtered items
                }
            }

            // Remove from favorites
            function removeFromFavorites(productId) {
                let favorites = JSON.parse(localStorage.getItem('lastbite_favorites')) || [];
                favorites = favorites.filter(p => p.id !== productId);
                localStorage.setItem('lastbite_favorites', JSON.stringify(favorites));

                // Update UI
                loadFavorites();
                updateFavoritesStats();
                showNotification('Item removed from favorites', 'success');

                // Dispatch event to update other pages
                window.dispatchEvent(new CustomEvent('favoritesUpdated'));
            }

            // Clear all favorites
            document.getElementById('clearAllFavoritesBtn').addEventListener('click', function() {
                if (confirm('Are you sure you want to remove all items from favorites?')) {
                    localStorage.removeItem('lastbite_favorites');
                    loadFavorites();
                    updateFavoritesStats();
                    showNotification('All favorites cleared', 'success');
                    window.dispatchEvent(new CustomEvent('favoritesUpdated'));
                }
            });

            // Add to cart function
            function addToCart(productId) {
                let favorites = JSON.parse(localStorage.getItem('lastbite_favorites')) || [];
                const product = favorites.find(p => p.id === productId);

                if (!product) return;

                // Add to cart logic
                let cart = JSON.parse(localStorage.getItem('lastbite_cart')) || [];
                const existingItem = cart.find(item => item.id === productId);

                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        ...product,
                        quantity: 1
                    });
                }

                localStorage.setItem('lastbite_cart', JSON.stringify(cart));
                showNotification('Added to cart!', 'success');

                // Update cart count
                updateCartCount();
            }

            // Notification function
            function showNotification(message, type = 'success') {
                const notification = document.createElement('div');
                notification.className = `notification show notification-${type}`;
                notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <span>${message}</span>
            `;

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.classList.remove('show');
                    setTimeout(() => notification.remove(), 400);
                }, 3000);
            }

            // Update cart count
            function updateCartCount() {
                const cart = JSON.parse(localStorage.getItem('lastbite_cart')) || [];
                const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
                const cartCount = document.getElementById('cartCount');
                if (cartCount) {
                    cartCount.textContent = totalItems;
                }
            }

            // Initial cart count update
            updateCartCount();
        </script>
    @endsection
