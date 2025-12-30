{{-- seller-products.blade.php --}}
@extends('layouts.seller')

@section('title', 'LastBite • Produk')

@php
    $productsList = $products ?? collect();

    $storeName = $storeData['name'] ?? 'Toko LastBite';
    $totalProducts = $productsList->count();
    $activeProducts = $productsList->where('is_active', true)->count();
    $flashCount = $productsList->where('is_flash', true)->count();
    $lowStock = $productsList->filter(fn($p) => (int)($p->stock ?? 0) <= 5)->count();

    $hour = (int) now()->format('H');
    $greet = $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 19 ? 'Selamat sore' : 'Selamat malam'));
    $today = now()->translatedFormat('l, d F Y');
@endphp

@section('nav_products_count', $totalProducts)

@push('styles')
<style>
/* ====== base (match sellerdashboard vibe) ====== */
:root{
  --font-primary:'Inter',-apple-system,BlinkMacSystemFont,sans-serif;
  --font-accent:'Poppins',-apple-system,BlinkMacSystemFont,sans-serif;

  --surface: rgba(255,255,255,.78);
  --surface-2: rgba(255,255,255,.86);
  --border: rgba(15,23,42,.10);

  --text: rgba(15,23,42,.92);
  --muted: rgba(51,65,85,.72);

  --accent:#D7FF1E;
  --accent-2:#B8FF36;

  --r-xl:26px;
  --r-lg:22px;
  --r-md:18px;

  --shadow-sm:0 10px 24px rgba(15,23,42,.06);
  --shadow-md:0 18px 50px rgba(15,23,42,.08);
  --shadow-lg:0 26px 80px rgba(15,23,42,.10);

  --gap-1:10px; --gap-2:14px; --gap-3:18px; --gap-4:22px; --gap-5:30px;

  --fs-xs:12px; --fs-sm:13px; --fs-base:14px; --fs-lg:18px; --fs-xl:22px; --fs-2xl:28px;

  --fw-regular:400; --fw-medium:520; --fw-semibold:650; --fw-bold:750; --fw-black:850;
}

.pageWrap{ position:relative; padding-bottom:10px; }
.pageBg{
  position:absolute; inset:-20px -20px auto -20px; height:460px; border-radius:42px;
  background:
    radial-gradient(900px 340px at 18% 18%, rgba(215,255,30,.55), transparent 58%),
    radial-gradient(900px 340px at 82% 26%, rgba(56,189,248,.20), transparent 60%),
    radial-gradient(900px 340px at 72% 92%, rgba(167,139,250,.16), transparent 62%),
    linear-gradient(180deg, rgba(255,255,255,.70), transparent 70%);
  pointer-events:none; z-index:0;
}
.page{ position:relative; z-index:1; display:flex; flex-direction:column; gap:var(--gap-5); font-family:var(--font-primary); min-width:0; }

.card{
  border-radius:var(--r-xl);
  border:1px solid var(--border);
  background:var(--surface);
  box-shadow:var(--shadow-md);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  overflow:hidden;
  min-width:0;
}

/* ====== hero ====== */
.hero{
  padding:22px 24px;
  display:flex; justify-content:space-between; align-items:flex-start;
  gap: var(--gap-4); flex-wrap:wrap;
  background:
    linear-gradient(180deg, rgba(255,255,255,.72), rgba(255,255,255,.60)),
    radial-gradient(860px 300px at 26% 18%, rgba(215,255,30,.34), transparent 60%),
    radial-gradient(860px 300px at 86% 28%, rgba(56,189,248,.14), transparent 62%);
}
.hTitle{
  margin:0;
  font-family:var(--font-accent);
  font-size:var(--fs-2xl);
  line-height:1.12;
  letter-spacing:-.02em;
  color:var(--text);
  font-weight:var(--fw-black);
}
.hTitle span{ font-weight:var(--fw-bold); }
.hSub{
  margin:10px 0 0;
  font-size:var(--fs-base);
  line-height:1.65;
  color:var(--muted);
  font-weight:var(--fw-regular);
  max-width:900px;
}
.metaRow{ margin-top:16px; display:flex; gap:var(--gap-2); flex-wrap:wrap; }
.pillMini{
  display:inline-flex; align-items:center; gap:10px;
  padding:10px 12px; border-radius:999px;
  border:1px solid rgba(15,23,42,.10);
  background:rgba(255,255,255,.82);
  box-shadow:0 10px 18px rgba(15,23,42,.05);
  color:rgba(15,23,42,.82);
  font-size:var(--fs-sm);
  font-weight:var(--fw-medium);
  white-space:nowrap;
}
.pillMini b{ font-family:var(--font-accent); font-weight:var(--fw-black); color:var(--text); letter-spacing:-.01em; }

.heroActions{ display:flex; gap:12px; flex-wrap:wrap; align-items:center; }

.btn2{
  height:44px;
  padding:0 16px;
  border-radius:999px;
  border:1px solid rgba(15,23,42,.10);
  background:rgba(255,255,255,.86);
  color:rgba(15,23,42,.92);
  font-weight:var(--fw-semibold);
  cursor:pointer;
  display:inline-flex; align-items:center; justify-content:center;
  gap:10px;
  text-decoration:none;
  box-shadow:0 12px 24px rgba(15,23,42,.06);
  transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease, background .18s ease;
  font-family:var(--font-primary);
  font-size:var(--fs-sm);
  letter-spacing:-.01em;
  user-select:none;
}
.btn2:hover{ transform:translateY(-2px); box-shadow:0 16px 36px rgba(15,23,42,.09); border-color:rgba(15,23,42,.14); background:rgba(255,255,255,.94); }
.btn2.primary{
  border:0;
  background:
    radial-gradient(280px 120px at 30% 40%, rgba(255,255,255,.35), transparent 60%),
    linear-gradient(135deg, var(--accent), var(--accent-2));
  color:rgba(15,23,42,.92);
  box-shadow:0 18px 44px rgba(215,255,30,.24);
  font-weight:var(--fw-black);
}
.btn2.primary:hover{ box-shadow:0 22px 60px rgba(215,255,30,.30); }
.btnSm{ height:36px; padding:0 12px; font-size:var(--fs-xs); }

.btnDanger{
  border:1px solid rgba(239,68,68,.22);
  background:rgba(239,68,68,.10);
  color:#991B1B;
  box-shadow:0 12px 24px rgba(239,68,68,.10);
}
.btnDanger:hover{ background:rgba(239,68,68,.14); border-color:rgba(239,68,68,.28); }

/* ====== toolbar ====== */
.toolbar{
  padding:16px 18px;
  display:flex; gap: var(--gap-2);
  align-items:center; justify-content:space-between;
  flex-wrap:wrap;
  border-bottom:1px solid rgba(15,23,42,.10);
  background: rgba(255,255,255,.55);
}
.searchWrap{
  flex:1; min-width: 260px;
  display:flex; align-items:center; gap:10px;
  padding:10px 12px;
  border-radius:999px;
  border:1px solid rgba(15,23,42,.12);
  background: rgba(255,255,255,.92);
  box-shadow:0 10px 20px rgba(15,23,42,.05);
}
.searchWrap i{ opacity:.65; }
.searchWrap input{
  border:0; outline:0; background:transparent;
  width:100%;
  font-family:var(--font-primary);
  font-size:var(--fs-sm);
  color:var(--text);
}
.select{
  height:44px; border-radius:999px;
  border:1px solid rgba(15,23,42,.12);
  padding:0 14px;
  background: rgba(255,255,255,.92);
  box-shadow:0 10px 20px rgba(15,23,42,.05);
  font-family: var(--font-primary);
  font-size: var(--fs-sm);
  color: rgba(15,23,42,.88);
}

/* ====== table shell ====== */
.tableWrap{
  padding: 16px 18px 18px;
}
.tableShell{
  border-radius: var(--r-xl);
  border:1px solid rgba(15,23,42,.10);
  background: rgba(255,255,255,.70);
  box-shadow: var(--shadow-sm);
  overflow: hidden;
}
.tableHeader{
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap: var(--gap-2);
  padding: 14px 14px;
  background: rgba(255,255,255,.82);
  border-bottom:1px solid rgba(15,23,42,.10);
}
.tableHeader h2{
  margin:0;
  font-family: var(--font-accent);
  font-size: var(--fs-xl);
  font-weight: var(--fw-black);
  letter-spacing:-.01em;
  color: var(--text);
}
.tableHeader p{
  margin:6px 0 0;
  font-size: var(--fs-sm);
  color: var(--muted);
  line-height: 1.5;
}
.tableRight{ display:flex; gap:10px; flex-wrap:wrap; align-items:center; }

.tableScroll{
  overflow:auto;
  max-height: 520px; /* feel like “Live Orders” panel */
}
table{
  width:100%;
  border-collapse:separate;
  border-spacing:0;
  min-width: 980px; /* keeps the table vibe */
}
thead th{
  position: sticky;
  top: 0;
  z-index: 2;
  background: rgba(255,255,255,.92);
  border-bottom:1px solid rgba(15,23,42,.10);
  font-size: 11px;
  letter-spacing:.10em;
  text-transform: uppercase;
  color: rgba(100,116,139,.92);
  font-weight: var(--fw-black);
  padding: 12px 14px;
  text-align:left;
  white-space:nowrap;
}
tbody td{
  padding: 14px 14px;
  border-bottom:1px solid rgba(15,23,42,.08);
  color: rgba(15,23,42,.86);
  font-size: var(--fs-sm);
  vertical-align: middle;
}
tbody tr{
  background: rgba(255,255,255,.78);
  transition: transform .16s ease, box-shadow .16s ease, background .16s ease;
}
tbody tr:hover{
  background: rgba(255,255,255,.92);
}
.cellProduct{
  display:flex; gap:12px; align-items:center; min-width: 280px;
}
.thumb{
  width:44px; height:44px;
  border-radius: 14px;
  border:1px solid rgba(15,23,42,.10);
  background: rgba(15,23,42,.04);
  overflow:hidden;
  display:flex; align-items:center; justify-content:center;
  box-shadow:0 10px 20px rgba(15,23,42,.05);
  flex:0 0 auto;
}
.thumb img{ width:100%; height:100%; object-fit:cover; display:block; }
.pName{
  margin:0;
  font-family: var(--font-accent);
  font-weight: var(--fw-black);
  color: var(--text);
  letter-spacing:-.01em;
  font-size: var(--fs-base);
  line-height: 1.2;
}
.pSub{
  margin:6px 0 0;
  color: rgba(100,116,139,.88);
  font-size: var(--fs-xs);
  font-weight: var(--fw-medium);
  display:flex;
  gap: 10px;
  flex-wrap:wrap;
}
.badge{
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding: 8px 10px;
  border-radius: 999px;
  font-size: 10px;
  font-weight: var(--fw-black);
  letter-spacing:.10em;
  text-transform: uppercase;
  border:1px solid rgba(15,23,42,.10);
  background: rgba(255,255,255,.86);
  color: rgba(15,23,42,.78);
  white-space:nowrap;
  font-family: var(--font-accent);
}
.badge.flash{ background: rgba(245,158,11,.12); border-color: rgba(245,158,11,.20); color:#92400E; }
.badge.active{ background: rgba(16,185,129,.12); border-color: rgba(16,185,129,.20); color:#0F766E; }
.badge.inactive{ background: rgba(100,116,139,.10); border-color: rgba(100,116,139,.18); color: rgba(15,23,42,.76); }

.price{
  font-family: var(--font-accent);
  font-weight: var(--fw-black);
  color: rgba(15,23,42,.92);
}
.stockLow{ color:#991B1B; font-weight: var(--fw-black); }
.stockOk{ color: rgba(15,23,42,.78); font-weight: var(--fw-semibold); }

/* ACTIONS: Update + Delete side-by-side */
.actions{
  display:flex;
  gap: 10px;
  align-items:center;
  justify-content:flex-end;
  flex-wrap: nowrap;
}
.actions form{ margin:0; }
.actions .btn2{ height:36px; padding:0 12px; font-size: 12px; }
.actions .btn2 i{ opacity:.9; }

.hintEmpty{
  padding: 18px;
  color: rgba(51,65,85,.78);
  background: rgba(255,255,255,.80);
}
.hintEmpty b{ color: var(--text); font-weight: var(--fw-black); font-family: var(--font-accent); }

/* Responsive */
@media (max-width: 768px){
  .heroActions .btn2{ width:100%; }
  .tableScroll{ max-height: 460px; }
}
</style>
@endpush

@section('content')
<div class="pageWrap">
  <div class="pageBg"></div>

  <div class="page">

    {{-- HERO --}}
    <div class="card hero">
      <div style="min-width:0">
        <h1 class="hTitle">{{ $greet }}, <span>{{ $storeName }}</span></h1>
        <p class="hSub">
          {{ $today }} • Kelola katalog dengan cepat: update harga, stok, dan pastikan item <b>FLASH</b> tampil optimal.
        </p>

        <div class="metaRow">
          <div class="pillMini"><i class="fa-solid fa-box"></i> Total <b>{{ $totalProducts }}</b></div>
          <div class="pillMini"><i class="fa-solid fa-circle-check"></i> Aktif <b>{{ $activeProducts }}</b></div>
          <div class="pillMini"><i class="fa-solid fa-bolt"></i> Flash <b>{{ $flashCount }}</b></div>
          <div class="pillMini"><i class="fa-solid fa-triangle-exclamation"></i> Stok menipis <b>{{ $lowStock }}</b></div>
        </div>
      </div>

      <div class="heroActions">
        <a class="btn2 primary" href="{{ route('seller.products.create') }}">
          <i class="fa-solid fa-plus"></i> Tambah Produk
        </a>
        <a class="btn2" href="{{ route('seller.dashboard') }}">
          <i class="fa-solid fa-gauge-high"></i> Dashboard
        </a>
      </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="card">

      {{-- Toolbar --}}
      <div class="toolbar">
        <div class="searchWrap">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="text" placeholder="Cari produk (nama/kategori/SKU)…" oninput="LBP.filter(this.value)">
        </div>

        <select class="select" onchange="LBP.filterStatus(this.value)" aria-label="Filter status">
          <option value="all">Semua Status</option>
          <option value="active">Aktif</option>
          <option value="inactive">Nonaktif</option>
          <option value="flash">Flash</option>
          <option value="low">Stok menipis</option>
        </select>

        <select class="select" onchange="LBP.sort(this.value)" aria-label="Urutkan">
          <option value="new">Urutkan: Terbaru</option>
          <option value="price_desc">Harga tertinggi</option>
          <option value="price_asc">Harga terendah</option>
          <option value="stock_asc">Stok menipis</option>
        </select>

        <button class="btn2 btnSm" type="button"
          onclick="LBP.toast('Info', 'Filter/sort ini UI-only. Sambungkan ke backend kalau perlu server-side.', 'fa-circle-info')">
          <i class="fa-solid fa-sparkles"></i> Info
        </button>
      </div>

      <div class="tableWrap">
        <div class="tableShell">
          <div class="tableHeader">
            <div>
              <h2>Produk Seller</h2>
              <p>{{ $totalProducts }} item • Update & delete langsung dari tabel</p>
            </div>
            <div class="tableRight">
              <a class="btn2 btnSm primary" href="{{ route('seller.products.create') }}">
                <i class="fa-solid fa-plus"></i> Tambah
              </a>
              <a class="btn2 btnSm" href="#"
                 onclick="event.preventDefault(); LBP.toast('Export', 'UI-only: sambungkan ke fitur export bila ada.', 'fa-file-export')">
                <i class="fa-solid fa-file-export"></i> Export
              </a>
            </div>
          </div>

          @if($productsList->count() > 0)
            <div class="tableScroll">
              <table id="productsTable">
                <thead>
                  <tr>
                    <th style="width:340px">Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th style="text-align:right; width:220px">Action</th>
                  </tr>
                </thead>
                <tbody id="productsBody">
                  @foreach($productsList as $p)
                    @php
                      $name = $p->name ?? 'Produk';
                      $category = $p->category ?? 'Kategori';
                      $price = (float)($p->price ?? 0);
                      $stock = (int)($p->stock ?? 0);

                      $isActive = (bool)($p->is_active ?? true);
                      $isFlash = (bool)($p->is_flash ?? false);

                      $sku = $p->sku ?? ('PRD-'.$p->id);
                      $thumb = $p->photo_url ?? null;

                      $statusKey = $isFlash ? 'flash' : ($isActive ? 'active' : 'inactive');
                      $stockKey = $stock <= 5 ? 'low' : 'ok';
                    @endphp
                    <tr
                      data-name="{{ strtolower($name.' '.$category.' '.$sku) }}"
                      data-status="{{ $statusKey }}"
                      data-stockkey="{{ $stockKey }}"
                      data-price="{{ $price }}"
                      data-stock="{{ $stock }}"
                    >
                      <td>
                        <div class="cellProduct">
                          <div class="thumb">
                            @if($thumb)
                              <img src="{{ $thumb }}" alt="{{ $name }}">
                            @else
                              <i class="fa-solid fa-image" style="opacity:.45"></i>
                            @endif
                          </div>
                          <div style="min-width:0">
                            <p class="pName">{{ $name }}</p>
                            <div class="pSub">
                              <span><i class="fa-solid fa-barcode"></i> {{ $sku }}</span>
                              @if($isFlash)
                                <span class="badge flash"><i class="fa-solid fa-bolt"></i> Flash</span>
                              @endif
                            </div>
                          </div>
                        </div>
                      </td>

                      <td>{{ $category }}</td>

                      <td class="price">Rp{{ number_format($price,0,',','.') }}</td>

                      <td>
                        <span class="{{ $stock <= 5 ? 'stockLow' : 'stockOk' }}">
                          {{ $stock <= 5 ? 'Menipis' : 'Aman' }}
                        </span>
                        <span style="color:rgba(100,116,139,.88); font-weight:600"> • {{ $stock }}</span>
                      </td>

                      <td>
                        @if($isActive)
                          <span class="badge active"><i class="fa-solid fa-circle"></i> Aktif</span>
                        @else
                          <span class="badge inactive"><i class="fa-solid fa-circle"></i> Nonaktif</span>
                        @endif
                      </td>

                      <td style="text-align:right">
                        <div class="actions">
                          <a class="btn2 btnSm primary" href="{{ route('seller.products.edit', $p->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i> Update
                          </a>

                          <form action="{{ route('seller.products.destroy', $p->id) }}" method="POST"
                                onsubmit="return LBP.confirmDelete('{{ addslashes($name) }}')">
                            @csrf
                            @method('DELETE')
                            <button class="btn2 btnSm btnDanger" type="submit">
                              <i class="fa-solid fa-trash"></i> Delete
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="hintEmpty">
              <b>Belum ada produk.</b> Klik tombol <b>Tambah</b> untuk mulai mengisi katalog.
            </div>
          @endif

        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script>
window.LBP = {
  toast(title, msg, icon='fa-circle-info'){
    const old = document.querySelector('.toast');
    if(old) old.remove();

    const t = document.createElement('div');
    t.className = 'toast';
    t.innerHTML = `
      <div style="position:fixed; right:20px; bottom:20px; width:min(420px, calc(100vw - 40px));
        background:rgba(255,255,255,.94); border:1px solid rgba(15,23,42,.12); border-radius:26px;
        box-shadow:0 26px 80px rgba(15,23,42,.10); padding:14px; display:flex; gap:12px; z-index:10000;
        backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
        <div style="width:44px;height:44px;border-radius:16px;display:flex;align-items:center;justify-content:center;
          background:radial-gradient(120px 50px at 30% 30%, rgba(215,255,30,.50), transparent 60%), rgba(15,23,42,.04);
          border:1px solid rgba(15,23,42,.10); color:rgba(15,23,42,.78); flex:0 0 auto;">
          <i class="fa-solid ${icon}"></i>
        </div>
        <div style="min-width:0">
          <p style="margin:0; font-family:'Poppins',sans-serif; font-weight:850; font-size:14px; color:rgba(15,23,42,.92); letter-spacing:-.01em;">${title}</p>
          <p style="margin:6px 0 0; color:rgba(100,116,139,.86); font-size:13px; line-height:1.45;">${msg}</p>
        </div>
        <button type="button" aria-label="Tutup"
          style="margin-left:auto;width:38px;height:38px;border-radius:999px;border:1px solid rgba(15,23,42,.12);
          background:rgba(255,255,255,.92); cursor:pointer; display:flex;align-items:center;justify-content:center;
          box-shadow:0 10px 20px rgba(15,23,42,.06);">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
    `;
    const box = t.firstElementChild;
    box.querySelector('button').onclick = () => t.remove();
    document.body.appendChild(t);
    setTimeout(()=>{ if(t && t.parentNode) t.remove(); }, 4500);
  },

  confirmDelete(name){
    return confirm(`Hapus produk "${name}"? Tindakan ini tidak bisa dibatalkan.`);
  },

  filter(q){
    const tbody = document.getElementById('productsBody');
    if(!tbody) return;
    const query = (q || '').toLowerCase().trim();
    tbody.querySelectorAll('tr').forEach(tr=>{
      const hay = (tr.dataset.name || '');
      tr.style.display = hay.includes(query) ? '' : 'none';
    });
  },

  filterStatus(val){
    const tbody = document.getElementById('productsBody');
    if(!tbody) return;
    tbody.querySelectorAll('tr').forEach(tr=>{
      const s = tr.dataset.status;
      const sk = tr.dataset.stockkey;
      if(val === 'all') tr.style.display = '';
      else if(val === 'low') tr.style.display = (sk === 'low') ? '' : 'none';
      else tr.style.display = (s === val) ? '' : 'none';
    });
  },

  sort(mode){
    const tbody = document.getElementById('productsBody');
    if(!tbody) return;

    const rows = Array.from(tbody.querySelectorAll('tr'));
    const num = (tr, key) => Number(tr.dataset[key] || 0);

    rows.sort((a,b)=>{
      if(mode === 'price_desc') return num(b,'price') - num(a,'price');
      if(mode === 'price_asc') return num(a,'price') - num(b,'price');
      if(mode === 'stock_asc') return num(a,'stock') - num(b,'stock');
      return 0; // "new" = keep as is (UI-only)
    });

    rows.forEach(r => tbody.appendChild(r));
  }
};
</script>
@endpush
