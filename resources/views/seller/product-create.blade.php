@extends('layouts.seller')

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
    <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
        @csrf

        <input name="name" required>
        <input name="brand" required>
        <input name="category" required>

        <textarea name="description" required></textarea>

        <input name="price" type="number" required>
        <input name="original_price" type="number" required>
        <input name="discount_percent" type="number" min="0" max="100">

        <input name="stock" type="number" min="0" required>
        <input name="expiry_date" type="date" required>

        <input name="image" type="file" accept="image/*" required>

        <button type="submit">Save</button>
      </form>

  </div>
</div>
@endsection
