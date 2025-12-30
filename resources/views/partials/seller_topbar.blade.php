<style>
    .topbar{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap: 12px;
        margin-bottom: 14px;
    }
    .hello{
        display:flex;
        flex-direction:column;
        gap:4px;
        min-width:0;
    }
    .hello h1{
        margin:0;
        font-size: 24px;
        font-weight: 900;
        letter-spacing:-.02em;
        line-height: 1.15;
    }
    .hello p{
        margin:0;
        color: var(--muted);
        font-weight: 700;
        line-height: 1.55;
        font-size: 13.5px;
        max-width: 820px;
    }

    .actions{
        display:flex;
        align-items:center;
        gap: 10px;
        flex-wrap: wrap;
        justify-content:flex-end;
        min-width: 360px;
    }

    .search{
        flex: 1;
        min-width: 260px;
        height: 44px;
        border-radius: 999px;
        border: 1px solid var(--line);
        background: rgba(255,255,255,.82);
        display:flex;
        align-items:center;
        gap: 10px;
        padding: 0 14px;
        box-shadow: var(--shadow-xs);
    }
    .search i{ color: var(--muted2); }
    .search input{
        border:none;
        outline:none;
        width:100%;
        background: transparent;
        color: var(--text);
        font-weight: 700;
        font-size: 13.5px;
    }

    .mini{
        width: 44px; height: 44px;
        border-radius: 999px;
        border: 1px solid var(--line);
        background: rgba(255,255,255,.82);
        display:flex; align-items:center; justify-content:center;
        box-shadow: var(--shadow-xs);
        cursor:pointer;
        transition: all var(--t);
        color: var(--muted);
    }
    .mini:hover{ transform: translateY(-1px); box-shadow: var(--shadow-sm); color: var(--text); }

    .avatar{
        width: 44px; height:44px;
        border-radius: 999px;
        border: 2px solid rgba(22,163,74,.18);
        background: linear-gradient(180deg, rgba(22,163,74,.18), rgba(255,255,255,.8));
        display:flex; align-items:center; justify-content:center;
        font-weight: 900;
        color: var(--green);
        box-shadow: var(--shadow-xs);
    }

    @media (max-width: 980px){
        .topbar{ flex-direction:column; align-items:stretch; }
        .actions{ min-width:0; justify-content:stretch; }
        .search{ min-width:0; }
    }
</style>

<div class="topbar">
    <div class="hello">
        <h1>@yield('page_title', 'Overview')</h1>
        <p>@yield('page_subtitle', 'Monitor performa toko, kelola pesanan, dan optimalkan penjualan dari satu dashboard.')</p>
    </div>

    <div class="actions">
        <div class="search">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Search anything here... (UI saja)">
        </div>

        <button class="mini" type="button" title="Notifications">
            <i class="fa-regular fa-bell"></i>
        </button>
        <div class="avatar" title="Profile">LB</div>
    </div>
</div>
