<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title','Seller • LastBite')</title>

    {{-- FontAwesome (kalau kamu pakai icon) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <style>
        :root{
            --bg: #f6f7fb;
            --surface: rgba(255,255,255,.85);
            --border: rgba(15,23,42,.12);
            --text: rgba(15,23,42,.92);
            --muted: rgba(100,116,139,.85);

            --r-xl: 22px;
            --r-lg: 18px;

            --shadow: 0 18px 50px rgba(15,23,42,.08);
        }

        *{ box-sizing:border-box; }
        body{
            margin:0;
            font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            background: linear-gradient(120deg,#f7efe6,#eaf7f0,#f4f6ff);
            color: var(--text);
        }

        /* ====== Layout wrapper ====== */
        .wrap{
            display:flex;
            min-height:100vh;
        }

        /* ====== Sidebar ====== */
        .sidebar{
            width: 280px;
            padding: 18px;
            border-right: 1px solid rgba(15,23,42,.08);
            background: rgba(255,255,255,.65);
            backdrop-filter: blur(10px);
        }
        .brand{
            display:flex;
            align-items:center;
            gap:12px;
            padding:12px;
            border-radius:18px;
            border:1px solid rgba(15,23,42,.10);
            background: rgba(255,255,255,.8);
            box-shadow: 0 12px 28px rgba(15,23,42,.06);
        }
        .brandLogo{
            width:44px;height:44px;border-radius:16px;
            display:flex;align-items:center;justify-content:center;
            background: rgba(16,185,129,.12);
            border:1px solid rgba(16,185,129,.25);
            color:#0f766e;
            font-weight:900;
        }
        .brandTitle{ font-weight:900; line-height:1.1; }
        .brandSub{ font-size:12px; color:var(--muted); margin-top:2px; font-weight:700; }

        .navTitle{
            margin:18px 10px 8px;
            font-size:11px;
            letter-spacing:.16em;
            color: rgba(100,116,139,.9);
            font-weight:900;
        }

        .nav{
            display:grid;
            gap:10px;
        }
        .nav a{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            padding:12px 12px;
            border-radius:18px;
            text-decoration:none;
            color: rgba(15,23,42,.85);
            border:1px solid rgba(15,23,42,.08);
            background: rgba(255,255,255,.72);
            transition:.15s ease;
        }
        .nav a:hover{
            transform: translateY(-1px);
            box-shadow: 0 14px 30px rgba(15,23,42,.08);
            border-color: rgba(15,23,42,.12);
        }
        .nav .left{
            display:flex;align-items:center;gap:12px;
            font-weight:900;
        }
        .ico{
            width:42px;height:42px;border-radius:16px;
            display:flex;align-items:center;justify-content:center;
            border:1px solid rgba(15,23,42,.10);
            background: rgba(255,255,255,.9);
        }
        .badge{
            min-width:28px;
            padding:6px 10px;
            border-radius:999px;
            background: rgba(16,185,129,.12);
            border:1px solid rgba(16,185,129,.22);
            color:#0f766e;
            font-size:12px;
            font-weight:900;
            text-align:center;
        }

        .tips{
            margin-top:18px;
            padding:14px;
            border-radius:22px;
            border:1px solid rgba(15,23,42,.10);
            background: rgba(255,255,255,.75);
        }
        .tips h4{
            margin:0 0 8px;
            font-size:13px;
            font-weight:900;
        }
        .tips p{
            margin:0;
            color:var(--muted);
            font-size:13px;
            line-height:1.5;
            font-weight:700;
        }

        /* ====== Main content ====== */
        .main{
            flex:1;
            padding: 20px 22px;
        }
        .topbar{
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:12px;
            margin-bottom: 16px;
        }
        .pageTitle{
            margin:0;
            font-size:26px;
            font-weight:1000;
            letter-spacing:-.02em;
        }
        .pageSub{
            margin:8px 0 0;
            color: var(--muted);
            font-weight:700;
            line-height:1.55;
            max-width: 900px;
        }

        /* Utility components */
        .card{
            border-radius: var(--r-xl);
            border:1px solid var(--border);
            background: rgba(255,255,255,.80);
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
            overflow:hidden;
        }

        .btn2{
            height: 42px;
            padding: 0 14px;
            border-radius: 999px;
            border: 1px solid rgba(15,23,42,.10);
            background: rgba(255,255,255,.9);
            color: rgba(15,23,42,.92);
            font-weight: 900;
            cursor: pointer;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:10px;
            text-decoration:none;
            transition: .15s ease;
        }
        .btn2:hover{
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(15,23,42,.08);
            border-color: rgba(15,23,42,.14);
        }
        .btn2.primary{
            border:0;
            background: linear-gradient(135deg,#d7ff1e,#b8ff36);
            box-shadow: 0 18px 44px rgba(215,255,30,.22);
        }
        .btnSm{ height: 36px; padding:0 12px; font-size:12px; }

        .ctl{
            height:42px;
            padding:0 12px;
            border-radius:14px;
            border:1px solid rgba(15,23,42,.14);
            background: rgba(255,255,255,.95);
            outline:none;
            font-weight:700;
        }
        .ctl:focus{
            border-color: rgba(215,255,30,.8);
            box-shadow: 0 0 0 4px rgba(215,255,30,.18);
        }

        /* ====== MODAL (OV + MODAL) ====== */
        .ov{
            position:fixed;
            inset:0;
            background: rgba(15,23,42,.42);
            display:none;
            align-items:center;
            justify-content:center;
            padding:20px;
            z-index:9999;
            backdrop-filter: blur(4px);
        }
        .ov.show{ display:flex; }

        .modal{
            width: min(760px, 100%);
            background: rgba(255,255,255,.95);
            border-radius: 22px;
            border: 1px solid rgba(15,23,42,.12);
            box-shadow: 0 26px 80px rgba(15,23,42,.14);
            overflow:hidden;
        }
        .mHead{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            padding:14px 16px;
            border-bottom: 1px solid rgba(15,23,42,.10);
            background: rgba(255,255,255,.9);
        }
        .mHead h4{
            margin:0;
            font-weight: 1000;
            letter-spacing: -.01em;
        }
        .x{
            width:40px;height:40px;
            border-radius:999px;
            border:1px solid rgba(15,23,42,.12);
            background: rgba(255,255,255,.92);
            cursor:pointer;
            display:flex;
            align-items:center;
            justify-content:center;
            transition:.15s ease;
        }
        .x:hover{
            transform: rotate(90deg);
            box-shadow: 0 14px 28px rgba(15,23,42,.10);
        }
        .mBody{ padding:16px; }
        .mActs{
            display:flex;
            justify-content:flex-end;
            gap:10px;
            margin-top:14px;
        }
        .fg{ display:flex; flex-direction:column; gap:6px; }
        .fg label{
            font-size:12px;
            letter-spacing:.10em;
            text-transform:uppercase;
            color: rgba(100,116,139,.95);
            font-weight: 900;
        }
        textarea.ctl{
            height:auto;
            padding:10px 12px;
            min-height: 110px;
            line-height:1.5;
        }

        /* responsive */
        @media (max-width: 980px){
            .sidebar{ display:none; }
            .main{ padding:16px; }
        }

    </style>

    {{-- styles dari page --}}
    @stack('styles')
</head>

<body>
<div class="wrap">

    {{-- ===== Sidebar ===== --}}
    <aside class="sidebar">
        <div class="brand">
            <div class="brandLogo"><i class="fa-solid fa-leaf"></i></div>
            <div>
                <div class="brandTitle">LastBite Admin</div>
                <div class="brandSub">Operational Dashboard</div>
            </div>
        </div>

        <div class="navTitle">MAIN</div>
        <div class="nav">
            <a href="{{ route('seller.dashboard') }}">
                <div class="left">
                    <div class="ico"><i class="fa-solid fa-border-all"></i></div>
                    Overview
                </div>
            </a>

            <a href="{{ route('seller.orders.index') }}">
                <div class="left">
                    <div class="ico"><i class="fa-solid fa-receipt"></i></div>
                    Orders
                </div>
                <span class="badge">@yield('nav_orders_count', 0)</span>
            </a>

            <a href="{{ route('seller.products.index') }}">
                <div class="left">
                    <div class="ico"><i class="fa-solid fa-box"></i></div>
                    Products
                </div>
                <span class="badge">@yield('nav_products_count', 0)</span>
            </a>

            <a href="#help">
                <div class="left">
                    <div class="ico"><i class="fa-solid fa-circle-question"></i></div>
                    Help
                </div>
                <span class="badge">FAQ</span>
            </a>
        </div>

        <div class="navTitle">SUPPORT</div>
        <div class="nav">
            <a href="#">
                <div class="left">
                    <div class="ico"><i class="fa-solid fa-gear"></i></div>
                    Settings
                </div>
            </a>
            <a href="{{ route('profile') }}">
                <div class="left">
                    <div class="ico"><i class="fa-solid fa-user"></i></div>
                    Profile
                </div>
            </a>
        </div>

        <div class="tips">
            <h4>⚡ Tips hari ini</h4>
            <p>Prioritaskan item near-expiry untuk <b>FLASH</b> agar rotasi stok sehat & minim food waste.</p>
        </div>
    </aside>

    {{-- ===== Main ===== --}}
    <main class="main">

        <div class="topbar">
            <div>
                <h1 class="pageTitle">@yield('page_title','Dashboard')</h1>
                <p class="pageSub">@yield('page_subtitle','')</p>
            </div>
            <div>
                {{-- optional slot action di kanan --}}
                @yield('page_actions')
            </div>
        </div>

        {{-- content --}}
        @yield('content')

    </main>
</div>

{{-- scripts dari page --}}
@stack('scripts')

{{-- ===== Global Modal Helper (LB) ===== --}}
<script>
    window.LB = {
      open(id){
        const el = document.getElementById(id);
        if(!el) return;
        el.classList.add('show');
        document.body.style.overflow = 'hidden';
      },
      close(id){
        const el = document.getElementById(id);
        if(!el) return;
        el.classList.remove('show');
        document.body.style.overflow = '';
        if(id === 'addProduct'){
          const f = document.getElementById('addProductForm');
          if(f) f.reset();
        }
      }
    };
    document.addEventListener('click', (e)=>{
      document.querySelectorAll('.ov.show').forEach(ov=>{
        if(e.target === ov) LB.close(ov.id);
      });
    });
    document.addEventListener('keydown', (e)=>{
      if(e.key === 'Escape'){
        document.querySelectorAll('.ov.show').forEach(ov => LB.close(ov.id));
      }
    });
    </script>


</body>
</html>
