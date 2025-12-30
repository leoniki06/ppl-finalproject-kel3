@php
  $path = request()->path();
  $is = fn($p) => request()->is($p);
@endphp

<style>
    .brand{
        display:flex;
        align-items:center;
        gap:12px;
        padding: 10px 10px 14px;
        border-bottom: 1px solid var(--line2);
        margin-bottom: 12px;
    }
    .logo{
        width: 46px; height:46px;
        border-radius: 16px;
        background: linear-gradient(180deg, var(--green2), var(--green));
        color:#fff;
        display:flex; align-items:center; justify-content:center;
        box-shadow: 0 16px 26px rgba(15,122,69,.18);
        position:relative;
        overflow:hidden;
    }
    .logo::after{
        content:'';
        position:absolute; inset:0;
        background-image: radial-gradient(rgba(255,255,255,.18) 1px, transparent 1px);
        background-size: 10px 10px;
        opacity: .16;
    }
    .bt{ font-weight: 900; letter-spacing:-.02em; }
    .bs{ color: var(--muted); font-weight: 700; font-size: 13px; margin-top:2px; }

    .navgrp{ margin-top: 12px; }
    .lbl{
        font-size: 11px;
        font-weight: 900;
        color: var(--muted2);
        letter-spacing:.14em;
        text-transform:uppercase;
        padding: 10px 10px 8px;
    }
    .nav{
        display:flex;
        flex-direction:column;
        gap: 6px;
        padding: 0 6px;
    }
    .item{
        padding: 12px 12px;
        border-radius: 16px;
        border: 1px solid transparent;
        text-decoration:none;
        display:flex;
        align-items:center;
        gap: 12px;
        color: var(--muted);
        font-weight: 800;
        transition: all var(--t);
        position:relative;
        background: transparent;
    }
    .item i{ width: 20px; text-align:center; color: var(--muted2); }
    .item:hover{
        background: rgba(255,255,255,.85);
        border-color: var(--line);
        transform: translateX(2px);
        color: var(--text);
    }
    .item.active{
        background: var(--greenSoft);
        border-color: rgba(22,163,74,.18);
        color: var(--green);
    }
    .item.active i{ color: var(--green); }
    .item.active::before{
        content:'';
        position:absolute;
        left:-10px;
        top: 12px;
        bottom:12px;
        width: 4px;
        border-radius: 999px;
        background: var(--green);
    }
    .badge{
        margin-left:auto;
        min-width: 30px;
        height: 22px;
        padding: 0 8px;
        border-radius: 999px;
        border: 1px solid var(--line);
        background: rgba(255,255,255,.78);
        color: var(--muted);
        font-size: 12px;
        font-weight: 900;
        display:flex; align-items:center; justify-content:center;
    }
    .item.active .badge{
        background: var(--green);
        border-color: transparent;
        color:#fff;
    }

    .promo{
        margin-top: 14px;
        padding: 14px;
        border-radius: 20px;
        border: 1px solid rgba(22,163,74,.16);
        background: linear-gradient(180deg, rgba(22,163,74,.16), rgba(255,255,255,.75));
        box-shadow: var(--shadow-xs);
    }
    .promo h4{
        margin:0 0 6px;
        font-size: 14px;
        font-weight: 900;
        color: var(--green);
    }
    .promo p{
        margin:0;
        color: var(--muted);
        font-weight: 700;
        line-height: 1.5;
        font-size: 13px;
    }
    .promo a{
        margin-top: 10px;
        width:100%;
    }
</style>

<div class="brand">
    <div class="logo"><i class="fa-solid fa-leaf"></i></div>
    <div>
        <div class="bt">LastBite Admin</div>
        <div class="bs">Operational Dashboard</div>
    </div>
</div>

<div class="navgrp">
    <div class="lbl">Main</div>
    <div class="nav">
        <a class="item {{ $is('seller/dashboard') ? 'active' : '' }}" href="{{ url('/seller/dashboard') }}">
            <i class="fa-solid fa-border-all"></i> Overview
        </a>

        <a class="item {{ $is('seller/orders*') ? 'active' : '' }}" href="{{ url('/seller/orders') }}">
            <i class="fa-solid fa-receipt"></i> Orders
            <span class="badge">@yield('nav_orders', '—')</span>
        </a>

        <a class="item {{ $is('seller/products*') ? 'active' : '' }}" href="{{ url('/seller/products') }}">
            <i class="fa-solid fa-box"></i> Products
            <span class="badge">@yield('nav_products', '—')</span>
        </a>

        <a class="item {{ $is('seller/help*') ? 'active' : '' }}" href="{{ url('/seller/help') }}">
            <i class="fa-solid fa-circle-question"></i> Help
            <span class="badge">FAQ</span>
        </a>
    </div>
</div>

<div class="navgrp">
    <div class="lbl">Support</div>
    <div class="nav">
        <a class="item" href="{{ url('/seller/settings') }}">
            <i class="fa-solid fa-gear"></i> Settings
        </a>
        <a class="item" href="{{ url('/seller/profile') }}">
            <i class="fa-solid fa-user"></i> Profile
        </a>
    </div>
</div>

<div class="promo">
    <h4><i class="fa-solid fa-bolt"></i> Tips hari ini</h4>
    <p>Prioritaskan item near-expiry untuk <b>FLASH</b> agar rotasi stok sehat & minim food waste.</p>
    <a class="btn btn-green" href="{{ url('/seller/help') }}"><i class="fa-solid fa-headset"></i> Hubungi Admin</a>
</div>
