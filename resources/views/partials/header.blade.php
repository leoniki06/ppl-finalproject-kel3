<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Last Bite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f8f9fa;
            padding: 20px;
        }

        .navbar-container {
            width: 90%;
            max-width: 1500px;
            justify-content: space-between;
            align-items: center;
            display: flex;
            background: white;
            padding: 12px 35px;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 20px;
            z-index: 1000;
            margin: 20px auto;
        }

        /* LOGO */
        .logo {
            width: 90px;
            height: 71.10px;
            object-fit: contain;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        /* CATALOG BUTTON */
        .catalog-btn {
            width: 115.78px;
            height: 34.73px;
            padding-left: 6.91px;
            padding-right: 6.91px;
            border-radius: 37.32px;
            justify-content: center;
            align-items: center;
            gap: 1.62px;
            display: flex;
            background: white;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .catalog-btn:hover {
            background: #f8f9fa;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .catalog-text {
            color: rgba(44, 44, 44, 0.93);
            font-size: 21.63px;
            font-family: 'Figtree';
            font-weight: 600;
            word-wrap: break-word;
        }

        .catalog-icon {
            width: 22.54px;
            height: 22.54px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(44, 44, 44, 0.93);
        }

        /* SEARCH BAR */
        .search-container {
            width: 376px;
            height: 46px;
            padding-left: 15.44px;
            padding-right: 15.44px;
            background: #6E3F0C;
            border-radius: 77px;
            justify-content: space-between;
            align-items: center;
            display: flex;
            transition: all 0.3s ease;
            position: relative;
        }

        .search-container:focus-within {
            background: #ffffff;
            outline: 2px solid #6E3F0C;
            box-shadow: 0 0 0 3px rgba(110, 63, 12, 0.2);
        }

        .search-input {
            text-align: right;
            color: #DADADA;
            font-size: 18.52px;
            font-family: 'Figtree';
            font-weight: 600;
            word-wrap: break-word;
            background: transparent;
            border: none;
            outline: none;
            flex: 1;
            padding: 0 10px;
        }

        .search-input::placeholder {
            color: #DADADA;
        }

        .search-container:focus-within .search-input {
            color: #6E3F0C;
            text-align: left;
        }

        .search-container:focus-within .search-input::placeholder {
            color: rgba(110, 63, 12, 0.6);
        }

        .search-icon {
            width: 16.98px;
            height: 16.98px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #DADADA;
            cursor: pointer;
        }

        .search-container:focus-within .search-icon {
            color: #6E3F0C;
        }

        /* CART BUTTON */
        .cart-btn {
            width: 104px;
            height: 46px;
            padding-left: 6.91px;
            padding-right: 6.91px;
            border-radius: 37.32px;
            outline: 2px #3F2305 solid;
            outline-offset: -2px;
            justify-content: center;
            align-items: center;
            gap: 1.62px;
            display: flex;
            background: white;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .cart-btn:hover {
            background: #f8f9fa;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(63, 35, 5, 0.1);
        }

        .cart-text {
            color: rgba(44, 44, 44, 0.93);
            font-size: 21.63px;
            font-family: 'Figtree';
            font-weight: 600;
            word-wrap: break-word;
        }

        .cart-icon {
            width: 33.51px;
            height: 33.51px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(44, 44, 44, 0.93);
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-family: 'Figtree';
        }

        /* PROFILE BUTTON */
        .profile-btn {
            width: 114px;
            height: 35px;
            padding-left: 6.91px;
            padding-right: 6.91px;
            border-radius: 37.32px;
            justify-content: center;
            align-items: center;
            gap: 7px;
            display: flex;
            background: white;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .profile-btn:hover {
            background: #f8f9fa;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-avatar {
            width: 34.22px;
            height: 34.22px;
            background: #D9D9D9;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .profile-avatar i {
            color: #6c757d;
            font-size: 16px;
        }

        .profile-text {
            color: rgba(44, 44, 44, 0.93);
            font-size: 21.63px;
            font-family: 'Figtree';
            font-weight: 600;
            word-wrap: break-word;
        }

        /* DROPDOWN MENUS */
        .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            padding: 0.5rem;
            min-width: 250px;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 0.7rem 1rem;
            margin: 0.1rem 0;
            transition: all 0.3s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dropdown-item:hover {
            background: #667eea;
            color: white;
            transform: translateX(5px);
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
        }

        .dropdown-header {
            font-weight: 600;
            color: #6c757d;
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
        }

        /* RESPONSIVE */
        @media (max-width: 1300px) {
            .navbar-container {
                width: 100%;
                padding: 12px 20px;
            }

            .search-container {
                width: 300px;
            }
        }

        @media (max-width: 768px) {
            .navbar-container {
                flex-wrap: wrap;
                gap: 10px;
                padding: 10px;
            }

            .search-container {
                width: 100%;
                order: 2;
            }

            .catalog-btn,
            .cart-btn,
            .profile-btn {
                flex: 1;
                min-width: auto;
            }
        }
    </style>
</head>

<body>
    <div class="navbar-container">
        <!-- LOGO -->
        <img class="logo" src="{{ asset('images/LOGO%20LASTBITE.png') }}" alt="Last Bite" onclick="scrollToTop()" />

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
                    <h6 class="dropdown-header">Kategori Makanan</h6>
                </li>
                <li><a class="dropdown-item" href="#" onclick="selectCategory('roti-bakery')"><i
                            class="fas fa-bread-slice"></i>Roti & Bakery</a></li>
                <li><a class="dropdown-item" href="#" onclick="selectCategory('susu-minuman')"><i
                            class="fas fa-wine-bottle"></i>Susu & Minuman</a></li>
                <li><a class="dropdown-item" href="#" onclick="selectCategory('buah-sayuran')"><i
                            class="fas fa-apple-alt"></i>Buah & Sayuran</a></li>
                <li><a class="dropdown-item" href="#" onclick="selectCategory('daging-ikan')"><i
                            class="fas fa-drumstick-bite"></i>Daging & Ikan</a></li>
                <li><a class="dropdown-item" href="#" onclick="selectCategory('telur-susu')"><i
                            class="fas fa-egg"></i>Telur & Produk Susu</a></li>
                <li><a class="dropdown-item" href="#" onclick="selectCategory('snack-camilan')"><i
                            class="fas fa-cookie"></i>Snack & Camilan</a></li>
                <li><a class="dropdown-item" href="#" onclick="selectCategory('frozen-food')"><i
                            class="fas fa-ice-cream"></i>Frozen Food</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#" onclick="selectCategory('all')"><i
                            class="fas fa-list"></i>Lihat Semua Kategori</a></li>
            </ul>
        </div>

        <!-- SEARCH BAR -->
        <div class="search-container">
            <input type="text" class="search-input" placeholder="Search" id="searchInput" />
            <div class="search-icon" onclick="performSearch()">
                <i class="fas fa-search"></i>
            </div>
        </div>

        <!-- CART BUTTON -->
        <button class="cart-btn" onclick="openCart()">
            <div class="cart-text">Cart</div>
            <div class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-badge" id="cartCount">0</span>
            </div>
        </button>

        <!-- PROFILE DROPDOWN -->
        <div class="nav-item dropdown">
            <button class="profile-btn" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="profile-text">Profile</div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i>My Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-history"></i>Order History</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i>Settings</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-danger" href="#" onclick="logout()"><i
                            class="fas fa-sign-out-alt"></i>Logout</a></li>
            </ul>
        </div>
    </div>

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

        // ====================
        // CATEGORY FUNCTIONALITY
        // ====================
        function selectCategory(category) {
            const categories = {
                'roti-bakery': 'Roti & Bakery',
                'susu-minuman': 'Susu & Minuman',
                'buah-sayuran': 'Buah & Sayuran',
                'daging-ikan': 'Daging & Ikan',
                'telur-susu': 'Telur & Produk Susu',
                'snack-camilan': 'Snack & Camilan',
                'frozen-food': 'Frozen Food',
                'all': 'Semua Kategori'
            };

            const categoryName = categories[category] || category;

            // Store selected category in session storage
            sessionStorage.setItem('selectedCategory', category);

            // Show feedback
            showNotification(`Membuka kategori: ${categoryName}`);

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
                showNotification(`Mencari: ${query}`);

                // Perform search (to be implemented)
                console.log(`Searching for: ${query}`);

                // Clear input
                document.getElementById('searchInput').value = '';
            } else {
                showNotification('Masukkan kata kunci pencarian', 'warning');
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
            showNotification('Membuka keranjang belanja');

            // Navigate to cart page (to be implemented)
            console.log('Opening cart page');
        }

        function updateCartCount() {
            try {
                const cart = JSON.parse(localStorage.getItem('lastbite_cart') || '[]');
                const totalItems = cart.reduce((total, item) => total + (item.quantity || 1), 0);
                document.getElementById('cartCount').textContent = totalItems;
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
                showNotification(`${productName} ditambahkan ke keranjang!`, 'success');

            } catch (error) {
                console.error('Error adding to cart:', error);
                showNotification('Gagal menambahkan ke keranjang', 'error');
            }
        }

        // ====================
        // PROFILE FUNCTIONALITY
        // ====================
        function logout() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                // Clear storage
                localStorage.removeItem('lastbite_cart');
                sessionStorage.clear();

                showNotification('Berhasil logout', 'success');

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
            // Create a simple notification
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'error' ? '#dc3545' : type === 'success' ? '#28a745' : '#007bff'};
                color: white;
                padding: 12px 20px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 9999;
                font-family: 'Figtree', sans-serif;
                font-weight: 500;
            `;
            notification.textContent = message;

            document.body.appendChild(notification);

            // Remove after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // ====================
        // INITIALIZATION
        // ====================
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();

            // Test function - bisa dihapus nanti
            window.demoAddToCart = function() {
                addToCart(1, 'Rot1 Sisir', 'Rp20k');
            };

            console.log('Last Bite Navbar initialized');
        });
    </script>
</body>

</html>
