@extends('layouts.app')

@section('content')
    <style>
        /* ========== ORDERS PAGE STYLES ========== */
        .orders-container {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
            padding: 0;
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

        .orders-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .orders-title {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .orders-count {
            background: var(--primary-color);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        /* Orders Filter */
        .orders-filter {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 10px 20px;
            border: 2px solid rgba(63, 35, 5, 0.1);
            background: white;
            border-radius: 30px;
            font-weight: 500;
            color: var(--text-dark);
            cursor: pointer;
            transition: var(--transition);
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        /* Orders List */
        .orders-list {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            box-shadow: var(--shadow-light);
        }

        .order-card {
            border: 1px solid rgba(63, 35, 5, 0.1);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            transition: var(--transition);
        }

        .order-card:hover {
            box-shadow: var(--shadow-light);
            border-color: var(--primary-color);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(63, 35, 5, 0.1);
        }

        .order-id {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 18px;
        }

        .order-date {
            color: var(--text-light);
            font-size: 14px;
        }

        .order-status {
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-completed {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .status-processing {
            background: rgba(0, 123, 255, 0.1);
            color: #007bff;
        }

        .status-cancelled {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        /* Order Items */
        .order-items {
            margin-bottom: 20px;
        }

        .order-item {
            display: flex;
            align-items: center;
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

        /* Order Summary */
        .order-summary {
            background: var(--bg-light);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid rgba(63, 35, 5, 0.1);
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-color);
        }

        /* Order Actions */
        .order-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(63, 35, 5, 0.1);
        }

        .order-btn {
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            border: none;
        }

        .btn-reorder {
            background: var(--primary-color);
            color: white;
        }

        .btn-reorder:hover {
            background: var(--primary-dark);
        }

        .btn-review {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-review:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Empty State */
        .empty-orders {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 64px;
            color: var(--text-light);
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-title {
            font-size: 24px;
            color: var(--text-dark);
            margin-bottom: 15px;
        }

        .empty-text {
            color: var(--text-light);
            margin-bottom: 30px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-start-shopping {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 14px 32px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-start-shopping:hover {
            background: var(--primary-dark);
            color: white;
            text-decoration: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .orders-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .order-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .order-actions {
                flex-direction: column;
            }

            .order-btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    <div class="orders-container">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Home</a> /
            <a href="{{ route('profile') }}">Profile</a> /
            <span>Order History</span>
        </div>

        <!-- Orders Header -->
        <div class="orders-header">
            <h1 class="orders-title">
                <i class="fas fa-history"></i>
                Order History
                <span class="orders-count" id="ordersCount">0 orders</span>
            </h1>
        </div>

        <!-- Orders Filter -->
        <div class="orders-filter">
            <button class="filter-btn active" data-filter="all">All Orders</button>
            <button class="filter-btn" data-filter="completed">Completed</button>
            <button class="filter-btn" data-filter="pending">Pending</button>
            <button class="filter-btn" data-filter="processing">Processing</button>
            <button class="filter-btn" data-filter="cancelled">Cancelled</button>
        </div>

        <!-- Orders List -->
        <div class="orders-list" id="ordersList">
            <!-- Orders will be loaded via JavaScript -->
            <div class="empty-orders" id="emptyOrders">
                <i class="fas fa-shopping-bag empty-icon"></i>
                <h3 class="empty-title">No orders yet</h3>
                <p class="empty-text">You haven't placed any orders yet. Start shopping to find amazing deals!</p>
                <a href="{{ route('dashboard') }}" class="btn-start-shopping">
                    <i class="fas fa-store"></i>
                    Start Shopping
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadOrders();
            setupFilterButtons();
        });

        function loadOrders() {
            let orders = [];
            try {
                const savedOrders = localStorage.getItem('lastbite_order_history');
                if (savedOrders) {
                    orders = JSON.parse(savedOrders);
                }
            } catch (error) {
                console.error('Error loading orders:', error);
            }

            displayOrders(orders);
        }

        function displayOrders(orders) {
            const ordersList = document.getElementById('ordersList');
            const emptyOrders = document.getElementById('emptyOrders');
            const ordersCount = document.getElementById('ordersCount');

            // Update count
            ordersCount.textContent = `${orders.length} order${orders.length !== 1 ? 's' : ''}`;

            // Clear existing orders
            ordersList.innerHTML = '';
            ordersList.appendChild(emptyOrders);

            if (orders.length === 0) {
                emptyOrders.style.display = 'block';
                return;
            }

            emptyOrders.style.display = 'none';

            // Sort by date (newest first)
            orders.sort((a, b) => new Date(b.timestamp || b.created_at) - new Date(a.timestamp || a.created_at));

            // Display each order
            orders.forEach(order => {
                const orderCard = createOrderCard(order);
                ordersList.appendChild(orderCard);
            });
        }

        function createOrderCard(order) {
            const card = document.createElement('div');
            card.className = 'order-card';

            const orderId = order.orderId || order.order_number || `LB-${Date.now()}`;
            const status = order.status || 'completed';
            const timestamp = order.timestamp ? new Date(order.timestamp) : new Date();
            const items = order.items || [];
            const totals = order.totals || {
                total: order.total_amount || 0
            };
            const address = order.address || order.delivery_address || 'Not specified';

            const formattedDate = timestamp.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            const formattedTime = timestamp.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });

            // Create items HTML
            let itemsHTML = '';
            items.forEach(item => {
                const itemImage = item.image_url || item.image ||
                    'https://images.unsplash.com/photo-1509440159596-0249088772ff?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80';
                const itemTotal = item.price * (item.quantity || 1);

                itemsHTML += `
                    <div class="order-item">
                        <div class="order-item-image">
                            <img src="${itemImage}" alt="${item.name}">
                        </div>
                        <div class="order-item-details">
                            <div class="order-item-name">${item.name}</div>
                            <div class="order-item-quantity">Quantity: ${item.quantity || 1}</div>
                        </div>
                        <div class="order-item-price">Rp${itemTotal.toLocaleString('id-ID')}</div>
                    </div>
                `;
            });

            card.innerHTML = `
                <div class="order-header">
                    <div>
                        <div class="order-id">#${orderId}</div>
                        <div class="order-date">${formattedDate} • ${formattedTime}</div>
                    </div>
                    <div class="order-status status-${status}">
                        ${status.charAt(0).toUpperCase() + status.slice(1)}
                    </div>
                </div>

                <div class="order-items">
                    ${itemsHTML}
                </div>

                <div class="order-summary">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>Rp${totals.subtotal ? totals.subtotal.toLocaleString('id-ID') : '0'}</span>
                    </div>
                    <div class="summary-row">
                        <span>Delivery:</span>
                        <span>Rp${totals.delivery ? totals.delivery.toLocaleString('id-ID') : '0'}</span>
                    </div>
                    <div class="summary-row">
                        <span>Service Fee:</span>
                        <span>Rp${totals.service ? totals.service.toLocaleString('id-ID') : '0'}</span>
                    </div>
                    ${totals.discount > 0 ? `
                        <div class="summary-row">
                            <span>Discount:</span>
                            <span class="text-success">-Rp${totals.discount.toLocaleString('id-ID')}</span>
                        </div>
                        ` : ''}
                    <div class="summary-total">
                        <span>Total:</span>
                        <span>Rp${totals.total.toLocaleString('id-ID')}</span>
                    </div>
                </div>

                <div class="order-actions">
                    <button class="order-btn btn-reorder" onclick="reorder('${orderId}')">
                        <i class="fas fa-redo"></i> Reorder
                    </button>
                    <button class="order-btn btn-review" onclick="writeReview('${orderId}')">
                        <i class="fas fa-star"></i> Write Review
                    </button>
                </div>
            `;

            return card;
        }

        function setupFilterButtons() {
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons
                    document.querySelectorAll('.filter-btn').forEach(b => {
                        b.classList.remove('active');
                    });

                    // Add active class to clicked button
                    this.classList.add('active');

                    // Filter orders
                    const filter = this.dataset.filter;
                    filterOrders(filter);
                });
            });
        }

        function filterOrders(filter) {
            let orders = [];
            try {
                const savedOrders = localStorage.getItem('lastbite_order_history');
                if (savedOrders) {
                    orders = JSON.parse(savedOrders);
                }
            } catch (error) {
                console.error('Error loading orders:', error);
            }

            if (filter === 'all') {
                displayOrders(orders);
            } else {
                const filteredOrders = orders.filter(order =>
                    (order.status || 'completed').toLowerCase() === filter.toLowerCase()
                );
                displayOrders(filteredOrders);
            }
        }

        function reorder(orderId) {
            // Find the order
            let orders = [];
            try {
                const savedOrders = localStorage.getItem('lastbite_order_history');
                if (savedOrders) {
                    orders = JSON.parse(savedOrders);
                }
            } catch (error) {
                console.error('Error loading orders:', error);
            }

            const order = orders.find(o =>
                (o.orderId || o.order_number) === orderId
            );

            if (order && order.items) {
                // Add all items to cart
                order.items.forEach(item => {
                    // Simulate adding to cart
                    console.log('Adding to cart:', item);
                });

                Swal.fire({
                    title: 'Reorder?',
                    text: `Add ${order.items.length} items to cart?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Add to Cart',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to cart
                        window.location.href = '{{ route('cart.index') }}';
                    }
                });
            }
        }

        function writeReview(orderId) {
            Swal.fire({
                title: 'Write Review',
                html: `
                    <div style="text-align: left;">
                        <p>Review for Order #${orderId}</p>
                        <div style="margin: 20px 0;">
                            <div style="font-size: 24px; color: #ffc107; cursor: pointer; text-align: center;">
                                <span class="star" data-rating="1">★</span>
                                <span class="star" data-rating="2">★</span>
                                <span class="star" data-rating="3">★</span>
                                <span class="star" data-rating="4">★</span>
                                <span class="star" data-rating="5">★</span>
                            </div>
                        </div>
                        <textarea id="reviewText" class="swal2-textarea" placeholder="Share your experience..." rows="4"></textarea>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Submit Review',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    const rating = document.querySelector('.star.active')?.dataset.rating || 0;
                    const review = document.getElementById('reviewText').value.trim();

                    if (rating === 0) {
                        Swal.showValidationMessage('Please select a rating');
                        return false;
                    }

                    if (!review) {
                        Swal.showValidationMessage('Please write a review');
                        return false;
                    }

                    return {
                        rating,
                        review
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Thank You!', 'Your review has been submitted.', 'success');
                }
            });

            // Star rating functionality
            setTimeout(() => {
                document.querySelectorAll('.star').forEach(star => {
                    star.addEventListener('click', function() {
                        const rating = parseInt(this.dataset.rating);

                        // Remove active class from all stars
                        document.querySelectorAll('.star').forEach(s => {
                            s.classList.remove('active');
                        });

                        // Add active class to clicked star and all previous stars
                        document.querySelectorAll('.star').forEach(s => {
                            if (parseInt(s.dataset.rating) <= rating) {
                                s.classList.add('active');
                            }
                        });
                    });
                });
            }, 100);
        }
    </script>
@endsection
