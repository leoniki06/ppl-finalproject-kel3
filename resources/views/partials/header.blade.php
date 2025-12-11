<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Last Bite - Reducing Food Waste</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Mengganti Figtree dengan Poppins untuk tampilan yang lebih profesional -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3F2305;
            --primary-light: #6E3F0C;
            --primary-dark: #2A1703;
            --accent-color: #FF9F1C;
            --text-dark: #2C2C2C;
            --text-light: #7A7A7A;
            --bg-light: #F9F5F0;
            --white: #FFFFFF;
            --shadow-light: 0 4px 20px rgba(63, 35, 5, 0.08);
            --shadow-medium: 0 6px 25px rgba(63, 35, 5, 0.12);
            --border-radius: 12px;
            --transition: all 0.3s ease;
        }

        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg-light);
            padding: 20px;
        }

        .navbar-container {
            width: 90%;
            max-width: 1500px;
            justify-content: space-between;
            align-items: center;
            display: flex;
            background: var(--white);
            padding: 15px 40px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-medium);
            position: sticky;
            top: 20px;
            z-index: 1000;
            margin: 20px auto;
            transition: var(--transition);
        }

        /* LOGO */
        .logo {
            width: 100px;
            height: auto;
            object-fit: contain;
            cursor: pointer;
            transition: var(--transition);
            filter: drop-shadow(0 2px 4px rgba(63, 35, 5, 0.1));
        }

        .logo:hover {
            transform: scale(1.05);
        }

        /* CATALOG BUTTON */
        .catalog-btn {
            min-width: 130px;
            height: 44px;
            padding: 0 18px;
            border-radius: 30px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            display: flex;
            background: var(--white);
            border: 1.5px solid var(--primary-color);
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .catalog-btn:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(63, 35, 5, 0.15);
        }

        .catalog-btn:hover .catalog-text,
        .catalog-btn:hover .catalog-icon {
            color: var(--white);
        }

        .catalog-text {
            color: var(--primary-color);
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.2px;
            transition: var(--transition);
        }

        .catalog-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            transition: var(--transition);
        }

        /* SEARCH BAR */
        .search-container {
            width: 420px;
            height: 48px;
            padding-left: 20px;
            padding-right: 8px;
            background: var(--white);
            border-radius: 30px;
            justify-content: space-between;
            align-items: center;
            display: flex;
            transition: var(--transition);
            position: relative;
            border: 1.5px solid rgba(63, 35, 5, 0.15);
            box-shadow: 0 2px 8px rgba(63, 35, 5, 0.05);
        }

        .search-container:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(63, 35, 5, 0.15);
        }

        .search-input {
            color: var(--text-dark);
            font-size: 15px;
            font-weight: 500;
            background: transparent;
            border: none;
            outline: none;
            flex: 1;
            padding: 0 10px;
        }

        .search-input::placeholder {
            color: var(--text-light);
            font-weight: 400;
        }

        .search-icon-container {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .search-icon-container:hover {
            background: var(--primary-dark);
            transform: scale(1.05);
        }

        .search-icon {
            color: var(--white);
            font-size: 16px;
        }

        /* CART BUTTON */
        .cart-btn {
            min-width: 120px;
            height: 48px;
            padding: 0 20px;
            border-radius: 30px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            display: flex;
            background: var(--primary-color);
            border: none;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .cart-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(63, 35, 5, 0.2);
        }

        .cart-text {
            color: var(--white);
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .cart-icon {
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            position: relative;
        }

        .cart-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: var(--accent-color);
            color: var(--primary-dark);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* PROFILE BUTTON */
        .profile-btn {
            min-width: 130px;
            height: 48px;
            padding: 0 18px;
            border-radius: 30px;
            justify-content: center;
            align-items: center;
            gap: 12px;
            display: flex;
            background: var(--white);
            border: 1.5px solid rgba(63, 35, 5, 0.15);
            cursor: pointer;
            transition: var(--transition);
        }

        .profile-btn:hover {
            background: var(--bg-light);
            border-color: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(63, 35, 5, 0.08);
        }

        .profile-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(63, 35, 5, 0.2);
        }

        .profile-avatar i {
            color: var(--white);
            font-size: 14px;
        }

        .profile-text {
            color: var(--primary-color);
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        /* DROPDOWN MENUS */
        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: var(--shadow-medium);
            padding: 0.75rem 0;
            min-width: 260px;
            border-top: 3px solid var(--primary-color);
            margin-top: 10px;
        }

        .dropdown-header {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 0.85rem;
            padding: 0.5rem 1.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 0.75rem 1.25rem;
            margin: 0.1rem 0.75rem;
            transition: var(--transition);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-dark);
        }

        .dropdown-item:hover {
            background: rgba(63, 35, 5, 0.08);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
            color: var(--primary-light);
        }

        .dropdown-divider {
            margin: 0.5rem 1rem;
        }

        /* RESPONSIVE */
        @media (max-width: 1300px) {
            .navbar-container {
                width: 95%;
                padding: 15px 25px;
            }

            .search-container {
                width: 350px;
            }
        }

        @media (max-width: 1024px) {
            .navbar-container {
                flex-wrap: wrap;
                gap: 15px;
                padding: 15px;
            }

            .search-container {
                width: 100%;
                order: 3;
                margin-top: 10px;
            }

            .catalog-btn,
            .cart-btn,
            .profile-btn {
                flex: 1;
                min-width: auto;
            }
        }

        @media (max-width: 768px) {
            .navbar-container {
                width: 100%;
                padding: 12px 15px;
                border-radius: 10px;
            }

            .logo {
                width: 85px;
            }

            .catalog-text,
            .cart-text,
            .profile-text {
                font-size: 14px;
            }

            .dropdown-menu {
                min-width: 220px;
            }
        }

        /* Additional Professional Touches */
        .nav-item {
            position: relative;
        }

        /* Micro-interaction for buttons */
        .catalog-btn:active,
        .cart-btn:active,
        .profile-btn:active {
            transform: translateY(0);
        }

        /* Focus states for accessibility */
        button:focus {
            outline: 2px solid var(--accent-color);
            outline-offset: 2px;
        }

        /* Animation for navbar on scroll */
        .navbar-scrolled {
            padding: 12px 30px;
            box-shadow: 0 8px 30px rgba(63, 35, 5, 0.12);
        }
    </style>
</head>

<body>
    <div class="navbar-container" id="navbarContainer">
        <!-- LOGO -->
        <img class="logo" src="{{ asset('images/LOGO%20LASTBITE.png') }}" alt="Last Bite - Reducing Food Waste"
            onclick="scrollToTop()" />

        <!-- CATALOG DROPDOWN -->
        <div class="nav-item dropdown">
            <button class="catalog-btn" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="catalog-text">Catalog</div>
                <div class="catalog-icon">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <h6 class="dropdown-header">Food Categories</h6>
                </li>
                <li><a class="dropdown-item" href="#" onclick="selectCategory('roti-bakery')"><i
                            class="fas fa-bread-slice"></i>Bakery & Bread</a></li>
                <li><a class="dropdown-item" href="#" onclick="selectCategory('susu-minuman')"><i
                            class="fas fa-wine-bottle"></i>Dairy & Beverages</a></li>
                <li><a class="dropdown-item" href="#" onclick="selectCategory('buah-sayuran')"><i
                            class="fas fa-apple-alt"></i>Fruits & Vegetables</a></li>
                <li><a class="dropdown-item" href="#" onclick="selectCategory('daging-ikan')"><i
                            class="fas fa-drumstick-bite"></i>Meat & Fish</a></li>
                <li><a class="dropdown-item" href="#" onclick="selectCategory('telur-susu')"><i
                            class="fas fa-egg"></i>Eggs & Dairy Products</a></li>
                <li><a class="dropdown-item" href="#" onclick="selectCategory('snack-camilan')"><i
                            class="fas fa-cookie"></i>Snacks</a></li>
                <li><a class="dropdown-item" href="#" onclick="selectCategory('frozen-food')"><i
                            class="fas fa-ice-cream"></i>Frozen Food</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#" onclick="selectCategory('all')"><i
                            class="fas fa-list"></i>View All Categories</a></li>
            </ul>
        </div>

        <!-- SEARCH BAR -->
        <div class="search-container">
            <input type="text" class="search-input" placeholder="Search for food items..." id="searchInput" />
            <div class="search-icon-container" onclick="performSearch()">
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>

        <!-- CART BUTTON -->
        <a href="/cart" style="text-decoration: none; display: inline-block;">
            <button class="cart-btn" type="button">
                <div class="cart-text">Cart</div>
                <div class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge" id="cartCount">0</span>
                </div>
            </button>
        </a>

        <!-- PROFILE DROPDOWN -->
        <div class="nav-item dropdown">
            <button class="profile-btn" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="profile-text">Profile</div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle"></i>My Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-history"></i>Order History</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-heart"></i>Favorites</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i>Settings</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-danger" href="#" onclick="logout()"><i
                            class="fas fa-sign-out-alt"></i>Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Demo Content -->
    {{-- <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h2 style="color: var(--primary-color); font-weight: 700; margin-bottom: 20px;">LastBite Header
                    Redesign</h2>
                <p style="color: var(--text-light); line-height: 1.7; margin-bottom: 30px;">
                    I've redesigned the LastBite header with a more professional look using Poppins font and the primary
                    color #3F2305.
                    The design maintains all original functionality while improving visual hierarchy, accessibility, and
                    modern aesthetics.
                </p>

                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button class="btn" onclick="addDemoItem()"
                        style="background: var(--primary-color); color: white; padding: 10px 20px; border-radius: 30px;">
                        <i class="fas fa-plus-circle me-2"></i>Add Demo Item to Cart
                    </button>

                    <button class="btn" onclick="clearCart()"
                        style="background: var(--bg-light); color: var(--primary-color); border: 1.5px solid var(--primary-color); padding: 10px 20px; border-radius: 30px;">
                        <i class="fas fa-trash-alt me-2"></i>Clear Cart
                    </button>
                </div>

                <div class="mt-5" style="color: var(--text-light); font-size: 0.9rem;">
                    <p><strong>Key improvements:</strong> Modern color scheme, better typography, enhanced button
                        states, improved search bar, refined dropdowns, and responsive optimizations.</p>
                </div>
            </div>
        </div>
    </div> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ====================
        // NAVBAR FUNCTIONALITY
        // ====================

        // Scroll to top when logo is clicked
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbarContainer');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // ====================
        // CATEGORY FUNCTIONALITY
        // ====================
        function selectCategory(category) {
            const categories = {
                'roti-bakery': 'Bakery & Bread',
                'susu-minuman': 'Dairy & Beverages',
                'buah-sayuran': 'Fruits & Vegetables',
                'daging-ikan': 'Meat & Fish',
                'telur-susu': 'Eggs & Dairy Products',
                'snack-camilan': 'Snacks',
                'frozen-food': 'Frozen Food',
                'all': 'All Categories'
            };

            const categoryName = categories[category] || category;

            // Store selected category in session storage
            sessionStorage.setItem('selectedCategory', category);

            // Show feedback
            showNotification(`Opening category: ${categoryName}`, 'success');

            // Close dropdown
            const dropdown = bootstrap.Dropdown.getInstance(document.querySelector('.catalog-btn'));
            if (dropdown) {
                dropdown.hide();
            }

            // Navigate to category page (to be implemented)
            console.log(`Navigating to category: ${category}`);
        }

        // ====================
        // SEARCH FUNCTIONALITY
        // ====================
        function performSearch() {
            const query = document.getElementById('searchInput').value.trim();

            if (query) {
                // Store search query
                sessionStorage.setItem('searchQuery', query);

                // Show feedback
                showNotification(`Searching for: ${query}`);

                // Perform search (to be implemented)
                console.log(`Searching for: ${query}`);

                // Clear input
                document.getElementById('searchInput').value = '';
            } else {
                showNotification('Please enter a search keyword', 'warning');
                document.getElementById('searchInput').focus();
            }
        }

        // Enter key support for search
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });

        // ====================
        // CART FUNCTIONALITY
        // ====================
        function openCart() {
            // Redirect ke halaman cart
            window.location.href = "/cart";
        }

        function updateCartCount() {
            try {
                const cart = JSON.parse(localStorage.getItem('lastbite_cart') || '[]');
                const totalItems = cart.reduce((total, item) => total + (item.quantity || 1), 0);
                document.getElementById('cartCount').textContent = totalItems;

                // Add animation when cart count changes
                const badge = document.getElementById('cartCount');
                if (badage.textContent !== '0') {
                    badge.style.transform = 'scale(1.2)';
                    setTimeout(() => {
                        badge.style.transform = 'scale(1)';
                    }, 300);
                }
            } catch (error) {
                console.error('Error updating cart count:', error);
                document.getElementById('cartCount').textContent = '0';
            }
        }

        function addToCart(productId, productName, price) {
            try {
                let cart = JSON.parse(localStorage.getItem('lastbite_cart') || '[]');

                const existingItem = cart.find(item => item.id === productId);

                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        id: productId,
                        name: productName,
                        price: price,
                        quantity: 1,
                        addedAt: new Date().toISOString()
                    });
                }

                localStorage.setItem('lastbite_cart', JSON.stringify(cart));
                updateCartCount();
                showNotification(`${productName} added to cart!`, 'success');

            } catch (error) {
                console.error('Error adding to cart:', error);
                showNotification('Failed to add item to cart', 'error');
            }
        }

        // Demo function to add item to cart
        function addDemoItem() {
            const demoItems = [{
                    id: 1,
                    name: 'Artisan Bread',
                    price: '$4.99'
                },
                {
                    id: 2,
                    name: 'Organic Milk',
                    price: '$3.49'
                },
                {
                    id: 3,
                    name: 'Fresh Apples',
                    price: '$2.99'
                },
                {
                    id: 4,
                    name: 'Salmon Fillet',
                    price: '$12.99'
                }
            ];

            const randomItem = demoItems[Math.floor(Math.random() * demoItems.length)];
            addToCart(randomItem.id, randomItem.name, randomItem.price);
        }

        function clearCart() {
            if (confirm('Are you sure you want to clear your cart?')) {
                localStorage.removeItem('lastbite_cart');
                updateCartCount();
                showNotification('Cart cleared successfully', 'success');
            }
        }

        // ====================
        // PROFILE FUNCTIONALITY
        // ====================
        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                // Clear storage
                localStorage.removeItem('lastbite_cart');
                sessionStorage.clear();

                showNotification('Successfully logged out', 'success');

                // Redirect to login (to be implemented)
                setTimeout(() => {
                    console.log('Redirecting to login page');
                }, 1000);
            }
        }

        // ====================
        // UTILITY FUNCTIONS
        // ====================
        function showNotification(message, type = 'info') {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.custom-notification');
            existingNotifications.forEach(notification => notification.remove());

            // Create a simple notification
            const notification = document.createElement('div');
            notification.className = 'custom-notification';
            notification.style.cssText = `
                position: fixed;
                top: 100px;
                right: 20px;
                background: ${type === 'error' ? '#dc3545' : type === 'success' ? '#28a745' : type === 'warning' ? '#ffc107' : '#3F2305'};
                color: white;
                padding: 15px 25px;
                border-radius: 10px;
                box-shadow: 0 6px 20px rgba(0,0,0,0.15);
                z-index: 9999;
                font-family: 'Poppins', sans-serif;
                font-weight: 500;
                max-width: 350px;
                transform: translateX(120%);
                transition: transform 0.4s ease;
                display: flex;
                align-items: center;
                gap: 12px;
            `;

            // Add icon based on type
            let icon = 'info-circle';
            if (type === 'success') icon = 'check-circle';
            if (type === 'error') icon = 'exclamation-circle';
            if (type === 'warning') icon = 'exclamation-triangle';

            notification.innerHTML = `
                <i class="fas fa-${icon}" style="font-size: 18px;"></i>
                <span>${message}</span>
            `;

            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 10);

            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(120%)';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 400);
            }, 3000);
        }

        // ====================
        // INITIALIZATION
        // ====================
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            console.log('Last Bite Professional Navbar initialized');
        });
    </script>
</body>

</html>
