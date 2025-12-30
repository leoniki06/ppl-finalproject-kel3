<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'LastBite • Seller Panel')</title>

    {{-- Fonts: mirip referensi (Plus Jakarta Sans + Inter) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap"
        rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        referrerpolicy="no-referrer" />

    <style>
        :root {
            /* ===== Base ===== */
            --bg: #F7F2EA;
            /* warm latte */
            --bg-2: #FFF8F0;
            /* cream */
            --ink: #111827;
            --muted: #6B7280;
            --line: rgba(17, 24, 39, .08);

            /* ===== Cozy accents (warm + fresh) ===== */
            --g-1: #34D399;
            /* mint */
            --g-2: #16A34A;
            /* green */
            --y-1: #FBBF24;
            /* butter */
            --p-1: #F59E0B;
            /* amber */
            --r-1: #FB7185;
            /* rose */
            --b-1: #60A5FA;
            /* sky */
            --v-1: #A78BFA;
            /* lavender */

            /* ===== Semantic (dipakai dashboard) ===== */
            --primary: var(--g-2);
            --primary-2: var(--g-1);
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --purple: #7C3AED;

            /* Surfaces */
            --surface: rgba(255, 255, 255, .78);
            --surface-2: rgba(255, 255, 255, .62);

            /* Radius */
            --r-12: 12px;
            --r-16: 16px;
            --r-20: 20px;
            --r-24: 24px;

            /* Shadow (halus) */
            --sh-1: 0 10px 26px rgba(17, 24, 39, .06);
            --sh-2: 0 16px 46px rgba(17, 24, 39, .10);

            /* Typography */
            --font: 'Inter', system-ui, sans-serif;
            --accent: 'Plus Jakarta Sans', system-ui, sans-serif;

            /* Compat vars utk dashboard lama */
            --text: var(--ink);
            --shadow-sm: var(--sh-1);
            --shadow-md: var(--sh-2);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        html,
        body {
            height: 100%
        }

        body {
            font-family: var(--font);
            color: var(--ink);
            background:
                radial-gradient(900px 520px at 12% 18%, rgba(245, 158, 11, .14), transparent 60%),
                radial-gradient(900px 520px at 85% 10%, rgba(52, 211, 153, .16), transparent 55%),
                linear-gradient(180deg, var(--bg), var(--bg-2));
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* ===== APP LAYOUT ===== */
        .app-wrap {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 292px 1fr;
            gap: 0;
        }

        /* ===== SIDEBAR (COMPACT) ===== */
        .sb {
            position: sticky;
            top: 0;
            height: 100vh;
            padding: 18px 16px;
            /* lebih compact */
            border-right: 1px solid var(--line);
            background: rgba(255, 255, 255, .55);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            overflow: hidden;
            /* target: tidak scroll */
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 12px;
            border-radius: var(--r-20);
            background: rgba(255, 255, 255, .84);
            border: 1px solid var(--line);
        }

        .brand .logo {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(52, 211, 153, .22), rgba(245, 158, 11, .10));
            border: 1px solid rgba(52, 211, 153, .22);
            color: var(--g-2);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .9);
            flex: 0 0 auto;
        }

        .brand .t1 {
            font-family: var(--accent);
            font-weight: 800;
            letter-spacing: -.02em;
            line-height: 1.1;
            font-size: 14px;
        }

        .brand .t2 {
            margin-top: 2px;
            font-size: 11px;
            color: var(--muted);
            font-weight: 700;
            opacity: .95;
        }

        .sb-sec {
            margin-top: 2px;
        }

        .sb-lbl {
            padding: 6px 10px 4px;
            font-size: 10px;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: rgba(107, 114, 128, .9);
            font-weight: 900;
        }

        .sb-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding: 0 6px;
        }

        .sb-a {
            text-decoration: none;
            color: rgba(17, 24, 39, .78);
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 10px;
            /* compact */
            border-radius: 14px;
            border: 1px solid transparent;
            transition: .18s ease;
            position: relative;
        }

        .sb-a:hover {
            background: rgba(255, 255, 255, .78);
            border-color: var(--line);
            transform: translateX(2px);
        }

        .sb-a.active {
            background: linear-gradient(135deg, rgba(52, 211, 153, .18), rgba(245, 158, 11, .10));
            border-color: rgba(52, 211, 153, .22);
            color: rgba(17, 24, 39, .92);
        }

        .sb-a.active::before {
            content: "";
            position: absolute;
            left: -8px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 64%;
            border-radius: 999px;
            background: linear-gradient(180deg, var(--g-1), var(--g-2));
        }

        .sb-ico {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(17, 24, 39, .04);
            border: 1px solid rgba(17, 24, 39, .06);
            color: rgba(17, 24, 39, .72);
            flex: 0 0 auto;
        }

        .sb-a.active .sb-ico {
            background: rgba(52, 211, 153, .16);
            border-color: rgba(52, 211, 153, .20);
            color: var(--g-2);
        }

        .sb-badge {
            margin-left: auto;
            min-width: 28px;
            padding: 5px 9px;
            /* compact */
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
            color: rgba(17, 24, 39, .76);
            background: rgba(255, 255, 255, .82);
            border: 1px solid var(--line);
        }

        .sb-a.active .sb-badge {
            background: linear-gradient(135deg, var(--g-1), var(--g-2));
            border-color: transparent;
            color: #fff;
        }

        /* spacer supaya tips nempel bawah tanpa scroll */
        .sb-grow {
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
            min-height: 0;
        }

        .sb-tip {
            margin-top: auto;
            /* kunci: dorong ke bawah */
            padding: 12px;
            border-radius: var(--r-20);
            background: linear-gradient(135deg, rgba(245, 158, 11, .14), rgba(52, 211, 153, .12));
            border: 1px solid rgba(245, 158, 11, .18);
        }

        .sb-tip .h {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: var(--accent);
            font-weight: 900;
            letter-spacing: -.01em;
            font-size: 13px;
        }

        .sb-tip .h i {
            color: var(--p-1)
        }

        .sb-tip p {
            margin-top: 8px;
            font-size: 12.5px;
            color: rgba(75, 85, 99, .95);
            line-height: 1.55;
        }

        .sb-btn {
            margin-top: 10px;
            width: 100%;
            height: 40px;
            /* compact */
            border-radius: 999px;
            border: 0;
            cursor: pointer;
            font-weight: 900;
            font-family: var(--font);
            color: #fff;
            background: linear-gradient(135deg, var(--g-1), var(--g-2));
            box-shadow: 0 10px 20px rgba(22, 163, 74, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: .18s ease;
        }

        .sb-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(22, 163, 74, .20)
        }

        .sb-btn:active {
            transform: translateY(0)
        }

        /* ===== MAIN ===== */
        .main {
            min-width: 0;
            padding: 22px 24px;
        }

        :focus-visible {
            outline: none;
            box-shadow: 0 0 0 4px rgba(52, 211, 153, .20);
            border-radius: 12px;
        }

        /* Responsive */
        @media (max-width: 1100px) {
            .app-wrap {
                grid-template-columns: 276px 1fr;
            }

            .main {
                padding: 18px 18px;
            }
        }

        @media (max-width: 920px) {
            .app-wrap {
                grid-template-columns: 1fr;
            }

            .sb {
                position: relative;
                height: auto;
                overflow: visible;
            }

            .sb-tip {
                margin-top: 10px;
            }

            .main {
                padding: 16px 14px;
            }
        }

        @stack('styles')
    </style>
</head>

<body>
    <div class="app-wrap">
        {{-- SIDEBAR --}}
        <aside class="sb">
            <div class="brand">
                <div class="logo"><i class="fa-solid fa-leaf"></i></div>
                <div style="min-width:0">
                    <div class="t1">LastBite Admin</div>
                    <div class="t2">Operational Dashboard</div>
                </div>
            </div>

            <div class="sb-grow">
                <div class="sb-sec">
                    <div class="sb-lbl">Main</div>
                    <nav class="sb-nav">
                        <a href="{{ route('seller.dashboard') }}"
                            class="sb-a {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                            <span class="sb-ico"><i class="fa-solid fa-grid-2"></i></span>
                            <span style="font-weight:900">Overview</span>
                        </a>

                        <a href="{{ route('seller.orders.index') }}"
                            class="sb-a {{ request()->routeIs('seller.orders.*') ? 'active' : '' }}">
                            <span class="sb-ico"><i class="fa-solid fa-receipt"></i></span>
                            <span style="font-weight:900">Orders</span>
                            <span class="sb-badge">@yield('nav_orders_count', '—')</span>
                        </a>

                        <a href="{{ route('seller.products.index') }}"
                            class="sb-a {{ request()->routeIs('seller.products.*') ? 'active' : '' }}">
                            <span class="sb-ico"><i class="fa-solid fa-box"></i></span>
                            <span style="font-weight:900">Products</span>
                            <span class="sb-badge">@yield('nav_products_count', '—')</span>
                        </a>

                        <a href="#help" class="sb-a" id="navHelp">
                            <span class="sb-ico"><i class="fa-solid fa-circle-question"></i></span>
                            <span style="font-weight:900">Help</span>
                            <span class="sb-badge">FAQ</span>
                        </a>
                    </nav>
                </div>

                <div class="sb-sec">
                    <div class="sb-lbl">Support</div>
                    <nav class="sb-nav">
                        <a href="#" class="sb-a" onclick="return false;">
                            <span class="sb-ico"><i class="fa-solid fa-gear"></i></span>
                            <span style="font-weight:900">Settings</span>
                        </a>
                        <a href="#" class="sb-a" onclick="return false;">
                            <span class="sb-ico"><i class="fa-regular fa-user"></i></span>
                            <span style="font-weight:900">Profile</span>
                        </a>
                    </nav>
                </div>

                <div class="sb-tip">
                    <div class="h"><i class="fa-solid fa-bolt"></i> Tips hari ini</div>
                    <p>
                        Prioritaskan item near-expiry untuk <b>FLASH</b> agar rotasi stok sehat & minim food waste.
                    </p>
                    <button class="sb-btn" type="button"
                        onclick="window.dispatchEvent(new CustomEvent('LB:openComplaint'))">
                        <i class="fa-solid fa-headset"></i> Hubungi Admin
                    </button>
                </div>
            </div>
        </aside>

        {{-- MAIN --}}
        <main class="main">
            @yield('content')
        </main>
    </div>

    <script>
        (function() {
            const helpLink = document.getElementById('navHelp');

            function setHelpActive(active) {
                if (!helpLink) return;
                if (!active) {
                    helpLink.classList.remove('active');
                    return;
                }
                document.querySelectorAll('.sb-a').forEach(a => {
                    if (a !== helpLink) a.classList.remove('active');
                });
                helpLink.classList.add('active');
            }

            setHelpActive(location.hash === '#help');
            window.addEventListener('hashchange', () => setHelpActive(location.hash === '#help'));

            document.querySelectorAll('a[href^="#"]').forEach(a => {
                a.addEventListener('click', (e) => {
                    const href = a.getAttribute('href');
                    const target = document.querySelector(href);
                    if (!target) return;
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            });

            // bridge: sidebar tip button -> modal complaint (di dashboard)
            window.addEventListener('LB:openComplaint', () => {
                if (window.LB && typeof window.LB.open === 'function') {
                    window.LB.open('complaint');
                }
            });
        })();
    </script>

    @stack('scripts')
</body>

</html>
