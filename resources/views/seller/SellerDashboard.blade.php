@extends('layouts.app')

@section('content')
    <!-- =========================================== -->
    <!-- SELLER DASHBOARD SECTION (Consistent UI) -->
    <!-- =========================================== -->
    <style>
        /* ========== DASHBOARD LAYOUT (SAME APPROACH) ========== */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .content-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .section-container {
            margin-bottom: 60px;
        }

        /* Scroll padding for navbar */
        #seller-store-info,
        #seller-stats,
        #seller-order-status,
        #seller-recent-orders,
        #seller-quick-actions {
            scroll-margin-top: 120px;
        }

        /* ========== HERO BANNER (SAME STRUCTURE) ========== */
        .hero-section {
            margin: 30px auto 20px;
            max-width: 1400px;
            width: 100%;
            padding: 0 40px;
        }

        .hero-banner {
            position: relative;
            width: 100%;
            height: 450px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-medium);
        }

        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            background-size: cover;
            background-position: center;
        }

        .hero-slide.active {
            opacity: 1;
        }

        .hero-slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to right, rgba(63, 35, 5, 0.85), rgba(63, 35, 5, 0.6));
        }

        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: var(--white);
            z-index: 2;
            width: 90%;
            max-width: 900px;
        }

        .hero-tagline {
            font-size: 16px;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 15px;
            opacity: 0.9;
            color: var(--accent-color);
        }

        .hero-title {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 15px;
            line-height: 1.1;
            text-transform: uppercase;
            letter-spacing: -0.5px;
        }

        .hero-subtitle {
            font-size: 30px;
            font-weight: 600;
            color: var(--accent-color);
            margin-bottom: 18px;
        }

        .hero-description {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 30px;
            opacity: 0.9;
            font-weight: 400;
        }

        .hero-cta {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--accent-color);
            color: var(--primary-color);
            padding: 14px 35px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            border: 2px solid transparent;
            font-size: 16px;
        }

        .hero-cta:hover {
            background: transparent;
            color: var(--accent-color);
            border-color: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 159, 28, 0.3);
        }

        .hero-dots {
            position: relative;
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
            padding-bottom: 20px;
        }

        .hero-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: rgba(63, 35, 5, 0.2);
            cursor: pointer;
            transition: var(--transition);
        }

        .hero-dot.active {
            background: var(--accent-color);
            transform: scale(1.3);
            box-shadow: 0 0 0 3px rgba(255, 159, 28, 0.2);
        }

        /* ========== SECTION HEADER (SAME) ========== */
        .section-header-container {
            max-width: 1200px;
            margin: 0 auto 35px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(63, 35, 5, 0.1);
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .section-title h2 {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }

        .star-icon {
            color: #FF9F1C;
            font-size: 32px;
        }

        .flash-icon {
            color: var(--danger-color);
            font-size: 32px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .see-more-btn {
            background: var(--white);
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 12px 28px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 15px;
            white-space: nowrap;
        }

        .see-more-btn:hover {
            background: var(--primary-color);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(63, 35, 5, 0.2);
        }

        /* ========== MODERN CARD BASE (DERIVED FROM product-card) ========== */
        .modern-card {
            width: 100%;
            background: var(--white);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow-light);
            transition: var(--transition);
            position: relative;
            display: flex;
            flex-direction: column;
            margin: 0 auto;
        }

        .modern-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-medium);
        }

        .card-body {
            padding: 20px;
        }

        /* ========== BADGES (SAME FEEL AS flash-badge/recommended-badge) ========== */
        .pill-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--white);
            white-space: nowrap;
        }

        .badge-success { background: var(--success-color); }
        .badge-danger { background: var(--danger-color); }
        .badge-warning { background: var(--warning-color); }
        .badge-primary { background: var(--primary-color); }
        .badge-info { background: #17a2b8; }

        .mini-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--white);
        }

        /* ========== STORE INFO CARD ========== */
        .store-info-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 24px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .store-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .store-title h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            color: var(--primary-color);
        }

        .store-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 10px;
            color: var(--text-light);
            font-size: 13px;
            font-weight: 600;
        }

        .store-meta .meta-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(63, 35, 5, 0.06);
            color: var(--primary-color);
            padding: 8px 12px;
            border-radius: 12px;
        }

        .store-health {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .health-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 12px;
            background: rgba(63, 35, 5, 0.06);
        }

        .health-label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 14px;
        }

        .health-desc {
            font-size: 13px;
            color: var(--text-light);
            font-weight: 600;
            margin-top: 6px;
        }

        .health-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            flex-shrink: 0;
        }

        .health-good { background: var(--success-color); }
        .health-warning { background: var(--warning-color); }
        .health-danger { background: var(--danger-color); }

        /* ========== STATS CARDS (AC#1) ========== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .stats-card {
            cursor: default;
        }

        .stats-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .stats-title {
            font-size: 14px;
            font-weight: 800;
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }

        .stats-number {
            font-size: 38px;
            font-weight: 900;
            color: var(--text-dark);
            line-height: 1;
            margin: 8px 0 6px;
        }

        .stats-subtitle {
            font-size: 13px;
            color: var(--text-light);
            font-weight: 600;
            margin: 0;
        }

        .stats-icon {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: rgba(255, 159, 28, 0.18);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        /* ========== ORDER STATUS (AC#2) ========== */
        .status-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .status-card {
            cursor: pointer;
        }

        .status-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
        }

        .status-name {
            font-size: 16px;
            font-weight: 800;
            color: var(--primary-color);
            margin: 0 0 10px;
        }

        .status-count {
            font-size: 28px;
            font-weight: 900;
            color: var(--text-dark);
            margin: 0;
            line-height: 1.1;
        }

        .status-cta {
            margin-top: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--white);
            color: var(--primary-color);
            border: 2px solid rgba(63, 35, 5, 0.2);
            padding: 9px 14px;
            border-radius: 22px;
            font-weight: 700;
            text-decoration: none;
            transition: var(--transition);
            font-size: 13px;
            white-space: nowrap;
        }

        .status-cta:hover {
            background: var(--primary-color);
            color: var(--white);
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(63, 35, 5, 0.18);
        }

        .filter-indicator {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(63, 35, 5, 0.06);
            border: 2px dashed rgba(63, 35, 5, 0.18);
            padding: 10px 14px;
            border-radius: 14px;
            color: var(--primary-color);
            font-weight: 800;
            font-size: 13px;
            margin-top: 15px;
        }

        /* ========== RECENT ORDERS TABLE (AC#2) ========== */
        .recent-orders-card {
            max-width: 1200px;
            margin: 0 auto;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .orders-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 780px;
        }

        .orders-table th,
        .orders-table td {
            padding: 14px 16px;
            text-align: left;
            font-size: 14px;
        }

        .orders-table th {
            background: rgba(63, 35, 5, 0.06);
            color: var(--primary-color);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 12px;
            border-bottom: 2px solid rgba(63, 35, 5, 0.08);
        }

        .orders-table tr {
            background: var(--white);
            transition: var(--transition);
            cursor: pointer;
        }

        .orders-table tr:hover {
            background: rgba(255, 159, 28, 0.06);
        }

        .orders-table td {
            color: var(--text-dark);
            font-weight: 600;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        }

        .order-id {
            color: var(--primary-color);
            font-weight: 900;
        }

        .order-total {
            font-weight: 900;
        }

        .order-date {
            color: var(--text-light);
            font-weight: 700;
            font-size: 13px;
        }

        .row-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 10px 14px;
            border-radius: 22px;
            font-weight: 800;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            font-size: 13px;
        }

        .row-action:hover {
            background: var(--accent-color);
            transform: scale(1.03);
            box-shadow: 0 6px 15px rgba(63, 35, 5, 0.18);
        }

        /* ========== QUICK ACTIONS (AC#3) ========== */
        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .quick-action-card {
            text-decoration: none;
            cursor: pointer;
        }

        .quick-action-top {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .quick-action-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: rgba(63, 35, 5, 0.06);
            color: var(--primary-color);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            transition: var(--transition);
            border: 2px solid transparent;
        }

        .quick-action-card:hover .quick-action-icon {
            background: var(--primary-color);
            color: var(--white);
            border-color: var(--accent-color);
        }

        .quick-action-title {
            font-size: 16px;
            font-weight: 900;
            color: var(--text-dark);
            margin: 0;
        }

        .quick-action-desc {
            font-size: 13px;
            color: var(--text-light);
            font-weight: 600;
            margin: 0;
            line-height: 1.45;
        }

        .quick-action-cta {
            margin-top: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--white);
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 10px 18px;
            border-radius: 24px;
            font-weight: 800;
            transition: var(--transition);
            font-size: 13px;
        }

        .quick-action-card:hover .quick-action-cta {
            background: var(--primary-color);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(63, 35, 5, 0.18);
        }

        /* ========== NOTIFICATION (SAME PATTERN) ========== */
        .notification {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--primary-color);
            color: var(--white);
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: var(--shadow-medium);
            z-index: 9999;
            transform: translateX(120%);
            transition: transform 0.4s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            max-width: 350px;
        }

        .notification.show { transform: translateX(0); }
        .notification-success { background: #28a745; }
        .notification-error { background: #dc3545; }
        .notification-info { background: #17a2b8; }
        .notification-warning { background: #ffc107; color: #3f2305; }

        /* ========== RESPONSIVE (SAME BREAKPOINTS) ========== */
        @media (max-width: 1200px) {
            .hero-title { font-size: 42px; }
            .hero-subtitle { font-size: 26px; }
            .hero-banner { height: 400px; }

            .status-grid { grid-template-columns: repeat(4, 1fr); }
            .quick-actions-grid { grid-template-columns: repeat(4, 1fr); }
        }

        @media (max-width: 1024px) {
            .hero-title { font-size: 36px; }
            .hero-subtitle { font-size: 24px; }
            .hero-banner { height: 350px; }

            .store-info-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .status-grid { grid-template-columns: repeat(2, 1fr); }
            .quick-actions-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .hero-section { padding: 0 15px; }
            .section-header-container { padding: 0 15px; }
            .hero-title { font-size: 32px; }
            .hero-subtitle { font-size: 22px; }
            .hero-banner { height: 300px; }
            .hero-cta { padding: 12px 28px; font-size: 15px; }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .stats-grid { grid-template-columns: 1fr; }
            .status-grid { grid-template-columns: 1fr; }
            .quick-actions-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 576px) {
            .hero-section { padding: 0 10px; }
            .hero-title { font-size: 28px; }
            .hero-subtitle { font-size: 20px; }
            .hero-banner { height: 250px; }
            .hero-cta { padding: 10px 24px; font-size: 14px; }

            .stats-number { font-size: 34px; }
            .status-count { font-size: 26px; }
        }
    </style>

    <!-- ========== HERO BANNER ========== -->
    <section class="hero-section">
        <div class="hero-banner" id="heroBanner">
            <!-- Slides will be added by JavaScript -->
        </div>
        <div class="hero-dots" id="heroDots">
            <!-- Dots will be added by JavaScript -->
        </div>
    </section>

    <!-- ========== STORE INFORMATION (WAJIB) ========== -->
    <section class="section-container" id="seller-store-info">
        <div class="section-header-container">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-store star-icon"></i>
                    <h2>Informasi Toko</h2>
                </div>
                <a href="{{ route('seller.store.profile') }}" class="see-more-btn">
                    Edit Profil Toko
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="content-container">
            <div class="store-info-grid">
                <!-- Main Store Card -->
                <div class="modern-card">
                    <div class="card-body">
                        <div class="store-title">
                            <i class="fas fa-shop"></i>
                            <h3>{{ $storeData['name'] ?? 'Toko Saya' }}</h3>

                            @php
                                $isOpen = (bool) ($storeData['is_open'] ?? false);
                            @endphp

                            <span class="pill-badge {{ $isOpen ? 'badge-success' : 'badge-danger' }}">
                                <i class="fas {{ $isOpen ? 'fa-door-open' : 'fa-door-closed' }}"></i>
                                {{ $isOpen ? 'Open' : 'Closed' }}
                            </span>
                        </div>

                        <div style="margin-top: 10px;">
                            <span class="mini-badge badge-info">
                                <i class="fas fa-star"></i>
                                Rating {{ number_format((float) ($storeData['rating'] ?? 0), 1) }}
                            </span>
                        </div>

                        <div class="store-meta">
                            <div class="meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $storeData['address'] ?? 'Alamat belum diatur' }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-clock"></i>
                                <span>Jam hari ini: {{ $storeData
                                ['today_hours'] ?? '-' }}</span>
                            </div>
                        </div>

                        <div style="margin-top: 16px;">
                            <a href="#seller-quick-actions" class="hero-cta" style="padding: 12px 26px; font-size: 14px;">
                                <i class="fas fa-bolt"></i>
                                Aksi Cepat Penjual
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Store Health Card -->
                @php
                    $healthLevel = $storeHealth['level'] ?? 'good';
                    $healthLabel = $storeHealth['label'] ?? 'No issues';

                    $healthClass = $healthLevel === 'danger' ? 'health-danger' : ($healthLevel === 'warning' ? 'health-warning' : 'health-good');
                    $healthBadge = $healthLevel === 'danger' ? 'badge-danger' : ($healthLevel === 'warning' ? 'badge-warning' : 'badge-success');
                    $healthIcon = $healthLevel === 'danger' ? 'fa-triangle-exclamation' : ($healthLevel === 'warning' ? 'fa-chart-line' : 'fa-circle-check');
                @endphp

                <div class="modern-card">
                    <div class="card-body store-health">
                        <div class="health-row">
                            <div class="health-label">
                                <span class="health-icon {{ $healthClass }}">
                                    <i class="fas {{ $healthIcon }}"></i>
                                </span>
                                Kondisi Toko Hari Ini
                            </div>

                            <span class="pill-badge {{ $healthBadge }}">
                                <i class="fas fa-heart-pulse"></i>
                                {{ $healthLabel }}
                            </span>
                        </div>

                        <div class="health-desc">
                            Pantau performa toko kamu setiap hari. Klik status pesanan untuk filter cepat, dan cek pesanan terbaru agar tidak terlewat.
                        </div>

                        <div style="margin-top: 10px;">
                            <a href="{{ route('seller.orders.index') }}" class="see-more-btn" style="padding: 10px 20px; font-size: 14px;">
                                Lihat Semua Pesanan
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========== STATS (AC#1) ========== -->
    <section class="section-container" id="seller-stats">
        <div class="section-header-container">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-chart-simple star-icon"></i>
                    <h2>Ringkasan Pesanan</h2>
                </div>
            </div>
        </div>

        <div class="content-container">
            <div class="stats-grid">
                <div class="modern-card stats-card">
                    <div class="card-body">
                        <div class="stats-top">
                            <h3 class="stats-title">Total Orders Today</h3>
                            <div class="stats-icon"><i class="fas fa-calendar-day"></i></div>
                        </div>
                        <div class="stats-number">{{ (int) ($stats['today'] ?? 0) }}</div>
                        <p class="stats-subtitle">Pesanan yang masuk hari ini</p>
                    </div>
                </div>

                <div class="modern-card stats-card">
                    <div class="card-body">
                        <div class="stats-top">
                            <h3 class="stats-title">Total Orders This Week</h3>
                            <div class="stats-icon"><i class="fas fa-calendar-week"></i></div>
                        </div>
                        <div class="stats-number">{{ (int) ($stats['week'] ?? 0) }}</div>
                        <p class="stats-subtitle">Akumulasi pesanan minggu ini</p>
                    </div>
                </div>

                <div class="modern-card stats-card">
                    <div class="card-body">
                        <div class="stats-top">
                            <h3 class="stats-title">Total Orders This Month</h3>
                            <div class="stats-icon"><i class="fas fa-calendar-alt"></i></div>
                        </div>
                        <div class="stats-number">{{ (int) ($stats['month'] ?? 0) }}</div>
                        <p class="stats-subtitle">Akumulasi pesanan bulan ini</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== ORDER STATUS + RECENT ORDERS (AC#2) ========== -->
    <section class="section-container" id="seller-order-status">
        <div class="section-header-container">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-clipboard-list flash-icon"></i>
                    <h2>Status Pesanan</h2>
                </div>
                <a href="{{ route('seller.orders.index') }}" class="see-more-btn">
                    Kelola Pesanan
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="content-container">
            @php
                $pendingCount = (int) ($orderStatusCounts['pending'] ?? 0);
                $processingCount = (int) ($orderStatusCounts['processing'] ?? 0);
                $completedCount = (int) ($orderStatusCounts['completed'] ?? 0);
                $cancelledCount = (int) ($orderStatusCounts['cancelled'] ?? 0);
            @endphp

            <div class="status-grid">
                <div class="modern-card status-card" onclick="setStatusFilter('pending')">
                    <div class="card-body">
                        <div class="status-row">
                            <div>
                                <div class="pill-badge badge-warning">
                                    <i class="fas fa-hourglass-start"></i>
                                    Pending
                                </div>
                            </div>
                            <i class="fas fa-rotate-right" style="color: rgba(63,35,5,0.35); font-size: 18px;"></i>
                        </div>
                        <p class="status-name" style="margin-top: 14px;">Menunggu Konfirmasi</p>
                        <p class="status-count">{{ $pendingCount }}</p>
                        <a href="{{ route('seller.orders.index', ['status' => 'pending']) }}" class="status-cta"
                            onclick="event.stopPropagation();">
                            View
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="modern-card status-card" onclick="setStatusFilter('processing')">
                    <div class="card-body">
                        <div class="status-row">
                            <div>
                                <div class="pill-badge badge-primary">
                                    <i class="fas fa-gears"></i>
                                    Processing
                                </div>
                            </div>
                            <i class="fas fa-box" style="color: rgba(63,35,5,0.35); font-size: 18px;"></i>
                        </div>
                        <p class="status-name" style="margin-top: 14px;">Sedang Diproses</p>
                        <p class="status-count">{{ $processingCount }}</p>
                        <a href="{{ route('seller.orders.index', ['status' => 'processing']) }}" class="status-cta"
                            onclick="event.stopPropagation();">
                            View
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="modern-card status-card" onclick="setStatusFilter('completed')">
                    <div class="card-body">
                        <div class="status-row">
                            <div>
                                <div class="pill-badge badge-success">
                                    <i class="fas fa-circle-check"></i>
                                    Completed
                                </div>
                            </div>
                            <i class="fas fa-truck-fast" style="color: rgba(63,35,5,0.35); font-size: 18px;"></i>
                        </div>
                        <p class="status-name" style="margin-top: 14px;">Selesai / Terkirim</p>
                        <p class="status-count">{{ $completedCount }}</p>
                        <a href="{{ route('seller.orders.index', ['status' => 'completed']) }}" class="status-cta"
                            onclick="event.stopPropagation();">
                            View
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <div class="modern-card status-card" onclick="setStatusFilter('cancelled')">
                    <div class="card-body">
                        <div class="status-row">
                            <div>
                                <div class="pill-badge badge-danger">
                                    <i class="fas fa-ban"></i>
                                    Cancelled
                                </div>
                            </div>
                            <i class="fas fa-xmark" style="color: rgba(63,35,5,0.35); font-size: 20px;"></i>
                        </div>
                        <p class="status-name" style="margin-top: 14px;">Dibatalkan</p>
                        <p class="status-count">{{ $cancelledCount }}</p>
                        <a href="{{ route('seller.orders.index', ['status' => 'cancelled']) }}" class="status-cta"
                            onclick="event.stopPropagation();">
                            View
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div id="statusFilterIndicator" class="filter-indicator" style="display:none;">
                <i class="fas fa-filter"></i>
                Filter aktif: <span id="statusFilterLabel" style="font-weight: 900;"></span>
                <button class="status-cta" style="padding: 8px 12px; font-size: 12px;"
                    onclick="clearStatusFilter();">
                    Reset
                    <i class="fas fa-rotate-left"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- ========== RECENT ORDERS TABLE (5 newest) ========== -->
    <section class="section-container" id="seller-recent-orders">
        <div class="section-header-container">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-clock-rotate-left star-icon"></i>
                    <h2>Pesanan Terbaru</h2>
                </div>
                <a href="{{ route('seller.orders.index') }}" class="see-more-btn">
                    Lihat Semua
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="content-container">
            <div class="modern-card recent-orders-card" id="recentOrdersCard">
                <div class="card-body">
                    <div class="table-wrap">
                        <table class="orders-table" id="recentOrdersTable">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($recentOrders) && $recentOrders->count() > 0)
                                    @foreach($recentOrders as $order)
                                        @php
                                            $status = strtolower($order->status ?? '');
                                            $badgeClass = 'badge-info';
                                            $statusLabel = $order->status ?? 'Unknown';

                                            if ($status === 'pending') { $badgeClass = 'badge-warning'; }
                                            elseif ($status === 'processing') { $badgeClass = 'badge-primary'; }
                                            elseif ($status === 'completed' || $status === 'delivered' || $status === 'shipped') { $badgeClass = 'badge-success'; }
                                            elseif ($status === 'cancelled' || $status === 'canceled') { $badgeClass = 'badge-danger'; }

                                            $rowStatusKey = $status ?: 'unknown';
                                        @endphp

                                        <tr data-status="{{ $rowStatusKey }}"
                                            onclick="window.location.href='{{ route('seller.orders.show', $order->id) }}'">
                                            <td class="order-id">#{{ $order->id }}</td>
                                            <td>{{ $order->customer_name ?? '-' }}</td>
                                            <td class="order-total">
                                                Rp{{ number_format((float) ($order->total ?? 0), 0, ',', '.') }}
                                            </td>
                                            <td>
                                                <span class="pill-badge {{ $badgeClass }}" style="padding: 7px 14px; font-size: 11px;">
                                                    <i class="fas fa-tag"></i>
                                                    {{ ucfirst($statusLabel) }}
                                                </span>
                                            </td>
                                            <td class="order-date">
                                                {{ optional($order->created_at)->format('d M Y, H:i') ?? '-' }}
                                            </td>
                                            <td>
                                                <a href="{{ route('seller.orders.show', $order->id) }}" class="row-action"
                                                    onclick="event.stopPropagation();">
                                                    Detail
                                                    <i class="fas fa-arrow-right"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr onclick="event.preventDefault();">
                                        <td colspan="6" style="padding: 18px 16px; color: var(--text-light); font-weight: 700;">
                                            Belum ada pesanan terbaru. Coba cek lagi nanti.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SELLER QUICK ACTIONS (AC#3) ========== -->
    <section class="section-container" id="seller-quick-actions">
        <div class="section-header-container">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-bolt flash-icon"></i>
                    <h2>Seller Quick Actions</h2>
                </div>
            </div>
        </div>

        <div class="content-container">
            <div class="quick-actions-grid">
                <a href="{{ route('seller.products.index') }}" class="modern-card quick-action-card">
                    <div class="card-body">
                        <div class="quick-action-top">
                            <div class="quick-action-icon">
                                <i class="fas fa-boxes-stacked"></i>
                            </div>
                            <h3 class="quick-action-title">Manage Products</h3>
                        </div>
                        <p class="quick-action-desc">
                            Tambah, edit, dan atur stok produk. Pastikan listing kamu selalu up to date.
                        </p>
                        <span class="quick-action-cta">
                            Buka
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>

                <a href="{{ route('seller.orders.index') }}" class="modern-card quick-action-card">
                    <div class="card-body">
                        <div class="quick-action-top">
                            <div class="quick-action-icon">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <h3 class="quick-action-title">Manage Orders</h3>
                        </div>
                        <p class="quick-action-desc">
                            Proses pesanan lebih cepat, update status, dan cek detail customer.
                        </p>
                        <span class="quick-action-cta">
                            Buka
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>

                <a href="{{ route('seller.store.profile') }}" class="modern-card quick-action-card">
                    <div class="card-body">
                        <div class="quick-action-top">
                            <div class="quick-action-icon">
                                <i class="fas fa-store-alt"></i>
                            </div>
                            <h3 class="quick-action-title">Store Profile</h3>
                        </div>
                        <p class="quick-action-desc">
                            Atur identitas toko, jam operasional, alamat, dan informasi penting lainnya.
                        </p>
                        <span class="quick-action-cta">
                            Buka
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>

                <a href="{{ route('seller.payouts.index') }}" class="modern-card quick-action-card">
                    <div class="card-body">
                        <div class="quick-action-top">
                            <div class="quick-action-icon">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <h3 class="quick-action-title">Payouts</h3>
                        </div>
                        <p class="quick-action-desc">
                            Lihat transaksi, histori payout, dan status penarikan dana secara ringkas.
                        </p>
                        <span class="quick-action-cta">
                            Buka
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <script>
        // ========== SELLER DASHBOARD JAVASCRIPT (LIGHT) ==========
        // Hero slides dari controller (opsional), fallback default
        const heroSlides = @json($heroSlides ?? []);

        let currentSlide = 0;

        function initializeHeroSlideshow() {
            const heroBanner = document.getElementById('heroBanner');
            const heroDots = document.getElementById('heroDots');

            const slidesToUse = heroSlides.length > 0 ? heroSlides : [{
                image: 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=1920&q=80',
                tagline: 'Dashboard Penjual',
                title: 'Kelola Toko Lebih Cepat',
                subtitle: 'Pesanan • Produk • Payout',
                description: 'Pantau performa harian, cek pesanan terbaru, dan lakukan aksi cepat tanpa ribet.'
            }];

            // Create slides + dots
            slidesToUse.forEach((slide, index) => {
                const slideDiv = document.createElement('div');
                slideDiv.className = `hero-slide ${index === 0 ? 'active' : ''}`;
                slideDiv.style.backgroundImage = `url('${slide.image}')`;
                heroBanner.appendChild(slideDiv);

                const dot = document.createElement('div');
                dot.className = `hero-dot ${index === 0 ? 'active' : ''}`;
                dot.dataset.index = index;
                dot.addEventListener('click', () => goToSlide(index));
                heroDots.appendChild(dot);
            });

            // Hero content
            const heroContent = document.createElement('div');
            heroContent.className = 'hero-content';
            heroBanner.appendChild(heroContent);

            updateHeroContent(0);

            setInterval(() => {
                goToSlide((currentSlide + 1) % slidesToUse.length);
            }, 5000);
        }

        function goToSlide(index) {
            const slides = document.querySelectorAll('.hero-slide');
            const dots = document.querySelectorAll('.hero-dot');

            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            slides[index].classList.add('active');
            dots[index].classList.add('active');

            currentSlide = index;
            updateHeroContent(index);
        }

        function updateHeroContent(index) {
            const slidesToUse = heroSlides.length > 0 ? heroSlides : [{
                image: 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=1920&q=80',
                tagline: 'Dashboard Penjual',
                title: 'Kelola Toko Lebih Cepat',
                subtitle: 'Pesanan • Produk • Payout',
                description: 'Pantau performa harian, cek pesanan terbaru, dan lakukan aksi cepat tanpa ribet.'
            }];

            const slide = slidesToUse[index];
            const heroContent = document.querySelector('.hero-content');

            if (heroContent) {
                heroContent.innerHTML = `
                    <div class="hero-tagline">${slide.tagline}</div>
                    <h1 class="hero-title">${slide.title}</h1>
                    <div class="hero-subtitle">${slide.subtitle}</div>
                    <p class="hero-description">${slide.description}</p>
                    <a href="#seller-recent-orders" class="hero-cta">
                        <i class="fas fa-receipt"></i>
                        Lihat Pesanan Terbaru
                    </a>
                `;
            }
        }

        // Notification function (same pattern)
        function showNotification(message, type = 'success') {
            const existingNotification = document.querySelector('.notification');
            if (existingNotification) existingNotification.remove();

            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            const icon =
                type === 'success' ? 'check-circle' :
                type === 'error' ? 'exclamation-circle' :
                type === 'warning' ? 'triangle-exclamation' :
                'info-circle';

            notification.innerHTML = `
                <i class="fas fa-${icon}"></i>
                <span>${message}</span>
            `;

            document.body.appendChild(notification);

            setTimeout(() => notification.classList.add('show'), 100);
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 400);
            }, 3000);
        }

        // Optional status filter (no API)
        const statusLabelMap = {
            pending: 'Pending',
            processing: 'Processing',
            completed: 'Completed',
            cancelled: 'Cancelled'
        };

        function setStatusFilter(statusKey) {
            const indicator = document.getElementById('statusFilterIndicator');
            const labelEl = document.getElementById('statusFilterLabel');
            const table = document.getElementById('recentOrdersTable');

            if (!table) return;

            // show indicator
            labelEl.textContent = statusLabelMap[statusKey] || statusKey;
            indicator.style.display = 'inline-flex';

            // filter rows
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const rowStatus = (row.getAttribute('data-status') || '').toLowerCase();
                // allow unknown row / empty placeholder row
                if (!rowStatus || row.querySelector('td[colspan]')) return;

                row.style.display = (rowStatus === statusKey) ? '' : 'none';
            });

            // scroll to table
            const target = document.getElementById('seller-recent-orders');
            if (target) target.scrollIntoView({ behavior: 'smooth' });

            // small toast
            showNotification(`Filter status: ${statusLabelMap[statusKey] || statusKey}`, 'info');
        }

        function clearStatusFilter() {
            const indicator = document.getElementById('statusFilterIndicator');
            const table = document.getElementById('recentOrdersTable');
            if (!table) return;

            indicator.style.display = 'none';

            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => row.style.display = '');

            showNotification('Filter direset', 'success');
        }

        // Init
        function initializeSellerDashboard() {
            initializeHeroSlideshow();
            console.log('Seller dashboard initialized');
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeSellerDashboard);
        } else {
            initializeSellerDashboard();
        }
    </script>
@endsection
