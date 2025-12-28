@extends('layouts.app')

@section('content')
<div class="container" style="padding:24px; max-width:900px">

  <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
    <div>
      <h1 style="margin:0">Add Product</h1>
      <p style="margin:6px 0 0; color:#666">Tambah produk baru (dummy dulu, belum ke database).</p>
    </div>
    <div style="display:flex; gap:10px; align-items:center;">
      <a href="{{ route('seller.products.index') }}" style="text-decoration:none">← Back</a>
    </div>
  </div>

  @if(session('success'))
    <div style="margin-top:14px; padding:12px; border:1px solid #cce5ff; background:#eaf4ff; border-radius:12px;">
      {{ session('success') }}
    </div>
  @endif

  <div style="margin-top:16px; border:1px solid #eee; border-radius:14px; padding:16px;">
    <form method="POST" action="{{ route('seller.products.store') }}">
      @csrf

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
        <div>
          <label style="font-weight:600;">Name</label>
          <input name="name" required placeholder="Contoh: Nasi Goreng"
                 style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
        </div>

        <div>
          <label style="font-weight:600;">Category</label>
          <input name="category" placeholder="Contoh: rice, drink, snack"
                 style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
        </div>

        <div>
          <label style="font-weight:600;">Price</label>
          <input name="price" type="number" min="0" placeholder="20000"
                 style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
        </div>

        <div>
          <label style="font-weight:600;">Stock</label>
          <input name="stock" type="number" min="0" placeholder="10"
                 style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
        </div>
      </div>

      <div style="margin-top:12px;">
        <label style="font-weight:600;">Description</label>
        <textarea name="description" rows="4" placeholder="Deskripsi produk..."
                  style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;"></textarea>
      </div>

      <div style="margin-top:12px;">
        <label style="font-weight:600;">Image URL</label>
        <input name="image_url" placeholder="https://..."
               style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
      </div>

      <div style="margin-top:14px; display:flex; gap:10px; justify-content:flex-end;">
        <a href="{{ route('seller.products.index') }}"
           style="padding:10px 14px; border:1px solid #ddd; border-radius:10px; text-decoration:none; background:#fff;">
          Cancel
        </a>
        <button type="submit"
                style="padding:10px 14px; background:#111; color:#fff; border-radius:10px; border:none; cursor:pointer;">
          Save (Dummy)
        </button>
      </div>

      <p style="margin-top:10px; color:#777; font-size:12px;">
        * Form ini dummy. Submit akan redirect balik dengan pesan sukses (dummy).
      </p>
    </form>
  </div>
</div>
@endsection
