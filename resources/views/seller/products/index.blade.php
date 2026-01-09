@extends('layouts.seller')

@section('title', 'Products • LastBite')
@section('page_title', 'Products')
@section('page_subtitle', 'Tambah, edit, hapus, cari, dan toggle status produk.')

@section('content')
    <div class="card" style="padding:18px;">

        {{-- ALERT --}}
        @if (session('success'))
            <div
                style="margin-bottom:14px; padding:12px 14px; background:#e7f7ee; border:1px solid #c9efd7; border-radius:12px;">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div
                style="margin-bottom:14px; padding:12px 14px; background:#fee; border:1px solid #f5c2c7; border-radius:12px;">
                <b>Terjadi error:</b>
                <ul style="margin:8px 0 0;">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- HEADER --}}
        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
            <div>
                <h3 style="margin:0 0 6px; font-weight:900;">Manage Products</h3>
                <p style="margin:0; color:var(--muted); font-weight:700; line-height:1.6;">
                    Tambah, edit, dan atur stok produk toko kamu.
                </p>
            </div>

            <div style="display:flex; gap:10px; align-items:center;">
                <a href="{{ route('seller.products.create') }}" class="btn2">
                    Open Create Page
                </a>

                <button type="button" class="btn2 primary" onclick="LB.open('addProductModal')">
                    + Add Product
                </button>
            </div>
        </div>

        {{-- SEARCH + SORT --}}
        <form method="GET" action="{{ route('seller.products.index') }}"
            style="display:flex; gap:12px; margin-top:16px; flex-wrap:wrap;">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search product..." class="ctl"
                style="flex:1; min-width:220px;">

            <select name="sort" class="ctl" style="width:180px;">
                <option value="latest" @selected(request('sort', 'latest') === 'latest')>Latest</option>
                <option value="name_asc" @selected(request('sort') === 'name_asc')>Name A-Z</option>
                <option value="name_desc" @selected(request('sort') === 'name_desc')>Name Z-A</option>
                <option value="price_asc" @selected(request('sort') === 'price_asc')>Price Low-High</option>
                <option value="price_desc" @selected(request('sort') === 'price_desc')>Price High-Low</option>
            </select>

            <button class="btn2 btnSm" type="submit">Apply</button>
        </form>

        {{-- TABLE --}}
        <div style="margin-top:18px; overflow:auto; border:1px solid #eee; border-radius:14px;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#fafafa">
                        <th style="text-align:left; padding:12px; border-bottom:1px solid #eee;">Product</th>
                        <th style="text-align:left; padding:12px; border-bottom:1px solid #eee;">Price</th>
                        <th style="text-align:left; padding:12px; border-bottom:1px solid #eee;">Stock</th>
                        <th style="text-align:left; padding:12px; border-bottom:1px solid #eee;">Status</th>
                        <th style="text-align:left; padding:12px; border-bottom:1px solid #eee;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $p)
                        <tr style="border-bottom:1px solid #f0f0f0">
                            <td style="padding:12px;">
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <div
                                        style="width:42px; height:42px; border-radius:10px; background:#f2f2f2; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                                        @if ($p->image_url)
                                            <img src="{{ asset('storage/' . $p->image_url) }}" alt=""
                                                style="width:42px; height:42px; object-fit:cover;">
                                        @else
                                            🍽️
                                        @endif
                                    </div>
                                    <div>
                                        <div style="font-weight:700;">{{ $p->name }}</div>
                                        <div style="font-size:12px; color:#777;">ID: #{{ $p->id }} •
                                            {{ $p->category }}</div>
                                    </div>
                                </div>
                            </td>

                            <td style="padding:12px;">Rp {{ number_format($p->price, 0, ',', '.') }}</td>

                            <td style="padding:12px;">
                                @if ($p->stock <= 0)
                                    <span
                                        style="padding:4px 10px; border-radius:999px; background:#fee; color:#a00; font-size:12px;">Out
                                        of stock</span>
                                @elseif($p->stock < 5)
                                    <span
                                        style="padding:4px 10px; border-radius:999px; background:#fff3cd; color:#8a6d3b; font-size:12px;">Low
                                        ({{ $p->stock }})</span>
                                @else
                                    <span
                                        style="padding:4px 10px; border-radius:999px; background:#e7f7ee; color:#1a7f37; font-size:12px;">{{ $p->stock }}</span>
                                @endif
                            </td>

                            <td style="padding:12px;">
                                @if ($p->is_active ?? true)
                                    <span
                                        style="padding:4px 10px; border-radius:999px; background:#e7f7ee; color:#1a7f37; font-size:12px;">Active</span>
                                @else
                                    <span
                                        style="padding:4px 10px; border-radius:999px; background:#eee; color:#444; font-size:12px;">Inactive</span>
                                @endif
                            </td>

                            <td style="padding:12px;">
                                <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                                    <a class="btn2 btnSm" href="{{ route('seller.products.edit', $p->id) }}">Edit</a>

                                    <form method="POST" action="{{ route('seller.products.destroy', $p->id) }}"
                                        onsubmit="return confirm('Yakin mau hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn2 btnSm" type="submit"
                                            style="border-color: rgba(239,68,68,.22); color:#991B1B;">
                                            Delete
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('seller.products.toggleStatus', $p->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn2 btnSm" type="submit">
                                            Toggle Status
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding:14px; color:#777;">Belum ada produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:14px;">
            {{ $products->links() }}
        </div>
    </div>

    {{-- ================= MODAL ADD PRODUCT ================= --}}
    <div class="ov" id="addProductModal" role="dialog" aria-modal="true">
        <div class="modal">
            <div class="mHead">
                <h4 style="margin:0; font-weight:900;">+ Add Product</h4>
                <button class="x" type="button" onclick="LB.close('addProductModal')" aria-label="Tutup">✕</button>
            </div>

            <div class="mBody">
                <form id="addProductForm" method="POST" action="{{ route('seller.products.store') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <div class="fg">
                            <label>Name</label>
                            <input class="ctl" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="fg">
                            <label>Brand / Nama Toko</label>
                            <input class="ctl" name="brand" value="{{ old('brand') }}" required>
                        </div>

                        <div class="fg">
                            <label>Category</label>
                            <input class="ctl" name="category" value="{{ old('category') }}" required
                                placeholder="bakery / drink / snack">
                        </div>

                        <div class="fg">
                            <label>Stock</label>
                            <input class="ctl" name="stock" type="number" min="0"
                                value="{{ old('stock', 0) }}" required>
                        </div>

                        <div class="fg">
                            <label>Price</label>
                            <input class="ctl" name="price" type="number" min="0" step="1000"
                                value="{{ old('price') }}" required>
                        </div>

                        <div class="fg">
                            <label>Original Price</label>
                            <input class="ctl" name="original_price" type="number" min="0" step="1000"
                                value="{{ old('original_price') }}" required>
                        </div>

                        <div class="fg">
                            <label>Discount Percent (optional)</label>
                            <input class="ctl" name="discount_percent" type="number" min="0" max="100"
                                value="{{ old('discount_percent', 0) }}">
                        </div>

                        <div class="fg">
                            <label>Expiry Date</label>
                            <input class="ctl" name="expiry_date" type="date" value="{{ old('expiry_date') }}"
                                required>
                        </div>
                    </div>

                    <div class="fg" style="margin-top:12px;">
                        <label>Description</label>
                        <textarea class="ctl" name="description" rows="4" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="fg" style="margin-top:12px;">
                        <label>Image (upload)</label>
                        <input class="ctl" name="image" type="file" accept="image/*" required>
                        <small style="color:#777;">* maksimal 2MB</small>
                    </div>

                    <div style="margin-top:12px; display:flex; gap:14px; flex-wrap:wrap;">
                        <label style="display:flex; gap:8px; align-items:center;">
                            <input type="checkbox" name="is_flash_sale" value="1" @checked(old('is_flash_sale'))>
                            Flash Sale
                        </label>

                        <label style="display:flex; gap:8px; align-items:center;">
                            <input type="checkbox" name="is_recommended" value="1" @checked(old('is_recommended'))>
                            Recommended
                        </label>
                    </div>

                    <div class="mActs">
                        <button type="button" class="btn2" onclick="LB.close('addProductModal')">Cancel</button>
                        <button type="submit" class="btn2 primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.LB = window.LB || {};

        LB.open = function(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        LB.close = function(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.remove('show');
            document.body.style.overflow = '';
            if (id === 'addProductModal') {
                const f = document.getElementById('addProductForm');
                if (f) f.reset();
            }
        }

        document.addEventListener('click', (e) => {
            document.querySelectorAll('.ov.show').forEach(ov => {
                if (e.target === ov) LB.close(ov.id);
            });
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.ov.show').forEach(ov => LB.close(ov.id));
            }
        });

        // ✅ kalau ada validation error (redirect balik ke index), buka modal biar user lihat errornya
        @if ($errors->any())
            LB.open('addProductModal');
        @endif
    </script>
@endpush
