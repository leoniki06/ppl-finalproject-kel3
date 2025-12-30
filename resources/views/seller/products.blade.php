@extends('layouts.seller')

@section('content')
<div class="container" style="padding:24px; max-width:1100px">

  @if(session('success'))
    <div style="margin-bottom:14px; padding:12px 14px; background:#e7f7ee; border:1px solid #c9efd7; border-radius:12px;">
      ✅ {{ session('success') }}
    </div>
  @endif

  @if($errors->any())
    <div style="margin-bottom:14px; padding:12px 14px; background:#fee; border:1px solid #f5c2c7; border-radius:12px;">
      <b>Terjadi error:</b>
      <ul style="margin:8px 0 0;">
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
    <div>
      <h1 style="margin:0">Manage Products</h1>
      <p style="margin:6px 0 0; color:#666">Tambah, edit, dan atur stok produk toko kamu.</p>
    </div>
    <div style="display:flex; gap:10px; align-items:center;">
      <a href="{{ route('seller.dashboard') }}" style="text-decoration:none">← Dashboard</a>
      <a href="{{ route('seller.products.create') }}"
         style="padding:10px 14px; background:#111; color:#fff; border-radius:10px; text-decoration:none;">
        + Add Product
      </a>
    </div>
  </div>

  <<form method="GET" action="{{ route('seller.products.index') }}" style="display:flex; gap:12px;">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search product..." class="ctl" style="flex:1;">
    <select name="sort" class="ctl" style="width:160px;">
        <option value="latest" @selected(request('sort')==='latest')>Latest</option>
        <option value="name_asc" @selected(request('sort')==='name_asc')>Name A-Z</option>
        <option value="name_desc" @selected(request('sort')==='name_desc')>Name Z-A</option>
        <option value="price_asc" @selected(request('sort')==='price_asc')>Price Low-High</option>
        <option value="price_desc" @selected(request('sort')==='price_desc')>Price High-Low</option>
    </select>
    <button class="btn2 btnSm" type="submit">Apply</button>
</form>


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
                <div style="width:42px; height:42px; border-radius:10px; background:#f2f2f2; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                  @if($p->image_url)
                  <img src="{{ asset('storage/'.$p->image_url) }}"
                  alt="{{ $p->name }}"
                  style="width:42px; height:42px; object-fit:cover;">

                  @else
                    🍽️
                  @endif
                </div>
                <div>
                  <div style="font-weight:600;">{{ $p->name }}</div>
                  <div style="font-size:12px; color:#777;">ID: #{{ $p->id }} • {{ $p->category }}</div>
                </div>
              </div>
            </td>

            <td style="padding:12px;">Rp {{ number_format($p->price, 0, ',', '.') }}</td>

            <td style="padding:12px;">
              @if($p->stock <= 0)
                <span style="padding:4px 10px; border-radius:999px; background:#fee; color:#a00; font-size:12px;">Out of stock</span>
              @elseif($p->stock < 5)
                <span style="padding:4px 10px; border-radius:999px; background:#fff3cd; color:#8a6d3b; font-size:12px;">Low ({{ $p->stock }})</span>
              @else
                <span style="padding:4px 10px; border-radius:999px; background:#e7f7ee; color:#1a7f37; font-size:12px;">{{ $p->stock }}</span>
              @endif
            </td>

            <td style="padding:12px;">
              {{-- sementara status pakai is_flash_sale --}}
              @if(($p->is_flash_sale ?? false))
                <span style="padding:4px 10px; border-radius:999px; background:#e7f7ee; color:#1a7f37; font-size:12px;">Active</span>
              @else
                <span style="padding:4px 10px; border-radius:999px; background:#eee; color:#444; font-size:12px;">Inactive</span>
              @endif
            </td>

            <td style="padding:12px;">
                <div style="display:flex; gap:10px; align-items:center;">
                    <a class="btn2 btnSm" href="{{ route('seller.products.edit', $p->id) }}">
                        Edit
                    </a>

                    <form method="POST" action="{{ route('seller.products.destroy', $p->id) }}"
                          onsubmit="return confirm('Yakin mau hapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn2 btnSm" type="submit" style="border-color: rgba(239,68,68,.22); color:#991B1B;">
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

  </div>
</div>
@endsection
