{{-- resources/views/profile/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LastBite - My Profile</title>

    <!-- Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- Page CSS (jangan sentuh buyer-layout.css, ini file khusus halaman profile) --}}
    @vite(['resources/css/profile.css', 'resources/js/profile.js'])
</head>

<body>
    <!-- ========== HEADER (masih pakai struktur kamu) ========== -->
    <div class="navbar-container" id="navbarContainer">
        <a href="{{ route('dashboard') }}" class="nav-logo-link">
            <img class="logo" src="{{ asset('images/LOGO LASTBITE.png') }}" alt="Last Bite" />
        </a>

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
                <li><a class="dropdown-item" href="#"><i class="fas fa-bread-slice"></i>Bakery & Bread</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-wine-bottle"></i>Dairy & Beverages</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-apple-alt"></i>Fruits & Vegetables</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-drumstick-bite"></i>Meat & Fish</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-egg"></i>Eggs & Dairy Products</a></li>
            </ul>
        </div>

        <div class="search-container">
            <input type="text" class="search-input" placeholder="Search for food items..." id="searchInput" />
            <div class="search-icon-container" onclick="performSearch && performSearch()">
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>

        <a href="{{ route('cart.index') }}" class="cart-btn">
            <div class="cart-text">Cart</div>
            <div class="cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-badge" id="cartCount">0</span>
            </div>
        </a>

        <div class="nav-item dropdown">
            <button class="profile-btn" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile-avatar" id="navbarProfileAvatar">
                    @php
                        $user = auth()->user();
                        if ($user && $user->profile_photo) {
                            $avatarUrl = asset('storage/profile-photos/' . $user->profile_photo) . '?t=' . time();
                            echo '<img src="' . $avatarUrl . '" alt="Profile">';
                        } else {
                            $initial = $user ? strtoupper(substr($user->name, 0, 1)) : 'G';
                            echo '<div class="profile-avatar-fallback">' . $initial . '</div>';
                        }
                    @endphp
                </div>
                <div class="profile-text">Profile</div>
            </button>

            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user-circle"></i>My
                        Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('profile.orders') }}"><i class="fas fa-history"></i>Order
                        History</a></li>
                <li><a class="dropdown-item" href="{{ route('favorites') }}"><i class="fas fa-heart"></i>Favorites</a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger dropdown-logout-btn">
                            <i class="fas fa-sign-out-alt"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- ========== PAGE WRAP ========== -->
    <main class="page-wrap">
        <div class="profile-layout">
            <!-- Left Card -->
            <aside class="user-info-card">
                <div class="user-avatar-large" id="profileAvatar" onclick="triggerPhotoUpload()">
                    @if ($user->profile_photo)
                        <img src="{{ asset('storage/profile-photos/' . $user->profile_photo) }}" alt="Profile Photo"
                            id="avatarImage">
                    @else
                        <div id="avatarInitial" class="avatar-initial">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    @endif
                    <div class="avatar-overlay">
                        <i class="fas fa-camera"></i>
                    </div>
                </div>

                <input type="file" id="profilePhotoInput" accept="image/*" style="display:none;"
                    onchange="uploadProfilePhoto(this)">

                <h2 class="user-name" id="userName">{{ $user->name }}</h2>
                <div class="user-title">
                    @if ($user->role == 'seller')
                        Seller @LastBite
                    @else
                        Premium Buyer @LastBite
                    @endif
                </div>

                <div class="personal-id">
                    <div class="id-label">User ID</div>
                    <div class="id-value" id="personalId">LB-{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</div>

                    <div class="id-actions">
                        <a href="#" class="id-link" onclick="triggerPhotoUpload(); return false;">
                            <i class="fas fa-camera"></i> Change Photo
                        </a>

                        @if ($user->profile_photo)
                            <a href="#" class="id-link danger" onclick="deleteProfilePhoto(); return false;">
                                <i class="fas fa-trash"></i> Remove Photo
                            </a>
                        @endif
                    </div>
                </div>
            </aside>

            <!-- Right Content -->
            <section class="profile-content">
                {{-- Alerts --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif

                <!-- Header -->
                <div class="profile-header">
                    <div>
                        <h1 class="profile-title">My Account</h1>
                        <p class="profile-subtitle">Kelola profil dan lihat riwayat pesananmu.</p>
                    </div>
                    <button class="edit-profile-btn" id="editProfileBtn" data-bs-toggle="modal"
                        data-bs-target="#editProfileModal">
                        <i class="fas fa-edit"></i> Edit Profile
                    </button>
                </div>

                <!-- Tabs -->
                <div class="profile-tabs" role="tablist" aria-label="Profile tabs">
                    <button class="tab-btn is-active" type="button" data-tab="tab-profile">
                        <i class="fas fa-user"></i> Profile
                    </button>
                    <button class="tab-btn" type="button" data-tab="tab-orders">
                        <i class="fas fa-receipt"></i> Orders
                        <span class="tab-pill">{{ $ordersCount ?? ($orders?->count() ?? 0) }}</span>
                    </button>
                </div>

                <!-- TAB: PROFILE -->
                <div class="tab-panel is-active" id="tab-profile">
                    <div class="profile-info-grid">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="info-section">
                                    <span class="section-label">EMAIL</span>
                                    <div class="info-value" id="emailValue">{{ $user->email ?? 'guest@example.com' }}
                                    </div>
                                </div>

                                <div class="info-section">
                                    <span class="section-label">ROLE</span>
                                    <div class="info-value">
                                        @if ($user->role == 'seller')
                                            <span class="badge bg-warning">Penjual</span>
                                        @else
                                            <span class="badge bg-primary">Pembeli</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="info-section">
                                    <span class="section-label">REGISTRATION DATE</span>
                                    <div class="info-value" id="registrationValue">
                                        {{ $user->created_at?->format('d F Y') ?? date('d F Y') }}</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-section">
                                    <span class="section-label">PHONE</span>
                                    <div class="info-value" id="phoneValue">{{ $user->phone ?? '-' }}</div>
                                </div>

                                <div class="info-section">
                                    <span class="section-label">ADDRESS</span>
                                    <div class="info-value" id="addressValue">{{ $user->address ?? '-' }}</div>
                                </div>

                                <div class="info-section">
                                    <span class="section-label">PASSWORD</span>
                                    <div class="info-value password">••••••••••</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="device-management">
                        <div class="device-info">
                            <div class="device-status">Currently logged in on this device</div>
                            <div class="device-count">Last active: Just now</div>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="signout-btn">
                                <i class="fas fa-sign-out-alt"></i> Sign Out
                            </button>
                        </form>
                    </div>

                    <!-- Recent Orders (DB based) -->
                    <div class="orders-section">
                        <div class="orders-header">
                            <h2 class="section-subtitle">Recent Orders</h2>
                            <button class="view-all-btn" type="button" data-jump-tab="tab-orders">
                                <i class="fas fa-list"></i> View All
                            </button>
                        </div>

                        @if (($recentOrders ?? collect())->count() > 0)
                            <div class="orders-grid">
                                @foreach ($recentOrders as $order)
                                    @php
                                        $status = $order->status ?? 'pending';
                                        $items = $order->items ?? collect();
                                        $itemNames = $items->take(2)->pluck('product_name')->filter()->implode(', ');
                                        $moreCount = max(0, $items->count() - 2);
                                    @endphp
                                    <div class="order-card">
                                        <div class="order-header">
                                            <div class="order-id">
                                                #{{ $order->order_number ?? $order->id }}
                                            </div>
                                            <div class="order-status status-{{ $status }}">
                                                {{ ucfirst($status) }}
                                            </div>
                                        </div>

                                        <div class="order-details">
                                            {{ $itemNames ?: 'Various items' }}
                                            @if ($moreCount > 0)
                                                <span class="muted">and {{ $moreCount }} more</span>
                                            @endif
                                        </div>

                                        <div class="order-total">
                                            <span>Total</span>
                                            <span class="total-amount">
                                                Rp{{ number_format((int) ($order->total_amount ?? 0), 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <div class="order-meta">
                                            <i class="far fa-clock"></i>
                                            <span>{{ optional($order->created_at)->format('d M Y, H:i') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-shopping-bag"></i></div>
                                <h4>No orders yet</h4>
                                <p>You haven't placed any orders yet.</p>
                                <a href="{{ route('dashboard') }}" class="btn-start-shopping">
                                    <i class="fas fa-store"></i> Start Shopping
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Help Center -->
                    <div class="help-section">
                        <h2 class="help-title"><i class="fas fa-question-circle"></i> Help Center</h2>
                        <div class="help-grid">
                            <div class="help-item" onclick="showHelp('edit-profile')">
                                <div class="help-question">How to edit my profile information?</div>
                                <div class="help-answer">Klik tombol “Edit Profile” untuk memperbarui data.</div>
                            </div>
                            <div class="help-item" onclick="showHelp('track-order')">
                                <div class="help-question">How to track my order?</div>
                                <div class="help-answer">Buka tab “Orders” untuk melihat semua riwayat pesanan.</div>
                            </div>
                            <div class="help-item" onclick="showHelp('change-password')">
                                <div class="help-question">How to change password?</div>
                                <div class="help-answer">Di modal Edit Profile, expand bagian Change Password.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB: ORDERS (DB based full list) -->
                <div class="tab-panel" id="tab-orders">
                    <div class="orders-page-head">
                        <div>
                            <h2 class="section-subtitle">Order History</h2>
                            <p class="muted">Semua pesanan kamu dari database LastBite.</p>
                        </div>
                        <a href="{{ route('dashboard') }}" class="ghost-btn">
                            <i class="fas fa-store"></i> Browse Products
                        </a>
                    </div>

                    @if (($orders ?? collect())->count() > 0)
                        <div class="order-history-list">
                            @foreach ($orders as $order)
                                @php
                                    $status = $order->status ?? 'pending';
                                @endphp
                                <div class="history-card">
                                    <div class="history-head">
                                        <div class="history-id">
                                            Order #{{ $order->order_number ?? $order->id }}
                                            <span class="dot">•</span>
                                            <span
                                                class="muted">{{ optional($order->created_at)->format('d M Y, H:i') }}</span>
                                        </div>
                                        <span
                                            class="order-status status-{{ $status }}">{{ ucfirst($status) }}</span>
                                    </div>

                                    <div class="history-items">
                                        @foreach ($order->items ?? collect() as $item)
                                            <div class="history-item">
                                                <div class="item-left">
                                                    <span class="item-name">{{ $item->product_name ?? 'Item' }}</span>
                                                    <span class="item-qty">x{{ (int) ($item->quantity ?? 1) }}</span>
                                                </div>
                                                <div class="item-right">
                                                    Rp{{ number_format((int) (($item->price ?? 0) * ($item->quantity ?? 1)), 0, ',', '.') }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="history-foot">
                                        <span class="muted">Total</span>
                                        <span class="total-amount">
                                            Rp{{ number_format((int) ($order->total_amount ?? 0), 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-receipt"></i></div>
                            <h4>No Orders Yet</h4>
                            <p>You haven't placed any orders yet.</p>
                            <a href="{{ route('dashboard') }}" class="btn-start-shopping">
                                <i class="fas fa-store"></i> Browse Products
                            </a>
                        </div>
                    @endif
                </div>

            </section>
        </div>
    </main>

    <!-- ========== EDIT PROFILE MODAL (struktur kamu dipertahankan, rapih sedikit) ========== -->
    <div class="modal fade edit-modal" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">
                        <i class="fas fa-user-edit"></i> Edit Profile Information
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" id="editProfileForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label"><i class="fas fa-camera"></i> Profile Photo</label>

                                <div class="d-flex align-items-center gap-3 flex-wrap">
                                    <div class="avatar-preview-wrap">
                                        <div class="avatar-preview">
                                            @if ($user->profile_photo)
                                                <img id="photoPreview"
                                                    src="{{ asset('storage/profile-photos/' . $user->profile_photo) }}"
                                                    alt="preview">
                                            @else
                                                <div id="photoPreview" class="avatar-preview-fallback">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex-grow-1">
                                        <input type="file" class="form-control" id="profile_photo"
                                            name="profile_photo" accept="image/*" onchange="previewPhoto(event)">
                                        <div class="form-text">JPEG/PNG/JPG/GIF, max 2MB.</div>

                                        @if ($user->profile_photo)
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="remove_photo"
                                                    name="remove_photo" value="1">
                                                <label class="form-check-label text-danger" for="remove_photo">Hapus
                                                    foto profil</label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4 g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label"><i class="fas fa-user"></i> Full
                                    Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email
                                    Address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $user->email) }}" required>
                                <div class="form-text">We'll send notifications to this email</div>
                            </div>
                        </div>

                        <div class="row mb-4 g-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label"><i class="fas fa-phone"></i> Phone
                                    Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone', $user->phone ?? '') }}">
                                <div class="form-text">For delivery updates</div>
                            </div>
                            <div class="col-md-6">
                                <label for="address" class="form-label"><i class="fas fa-map-marker-alt"></i>
                                    Address</label>
                                <textarea class="form-control" id="address" name="address" rows="2">{{ old('address', $user->address ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0"><i class="fas fa-key"></i> Change Password</label>
                                <button type="button" class="btn btn-sm btn-outline-primary"
                                    onclick="togglePasswordSection()">
                                    Change Password
                                </button>
                            </div>

                            <div id="passwordSection" style="display:none;">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control" id="current_password"
                                                name="current_password">
                                            <button type="button" class="password-toggle"
                                                onclick="togglePasswordVisibility('current_password')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control" id="new_password"
                                                name="new_password">
                                            <button type="button" class="password-toggle"
                                                onclick="togglePasswordVisibility('new_password')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="form-text">Min 8 characters with letters & numbers</div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="new_password_confirmation" class="form-label">Confirm New
                                            Password</label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control"
                                                id="new_password_confirmation" name="new_password_confirmation">
                                            <button type="button" class="password-toggle"
                                                onclick="togglePasswordVisibility('new_password_confirmation')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Data untuk JS --}}
    <script>
        window.__PROFILE__ = {
            csrfToken: "{{ csrf_token() }}",
            routes: {
                updateProfile: "{{ route('profile.update') }}",
                deletePhoto: "{{ route('profile.delete-photo') }}",
            },
            user: {
                name: @json($user->name),
                initial: @json(strtoupper(substr($user->name, 0, 1))),
                hasPhoto: @json((bool) $user->profile_photo),
                currentPhotoUrl: @json($user->profile_photo ? asset('storage/profile-photos/' . $user->profile_photo) : null),
            }
        };
    </script>
</body>

</html>
