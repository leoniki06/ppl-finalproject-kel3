@extends('layouts.seller')

@section('title', 'Add Product • LastBite')
@section('page_title', 'Add Product')
@section('page_subtitle', 'Tambah produk baru ke toko kamu.')

@section('content')
<div class="card" style="padding:18px; max-width:900px;">

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

  <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
    @csrf

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
      <div>
        <label style="font-weight:700;">Name</label>
        <input name="name" value="{{ old('name') }}" required
               style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
      </div>

      <div>
        <label style="font-weight:700;">Brand / Nama Toko</label>
        <input name="brand" value="{{ old('brand') }}" required
               style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
      </div>

      <div>
        <label style="font-weight:700;">Category</label>
        <input name="category" value="{{ old('category') }}" required placeholder="bakery / drink / snack"
               style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
      </div>

      <div>
        <label style="font-weight:700;">Stock</label>
        <input name="stock" type="number" min="0" value="{{ old('stock', 0) }}" required
               style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
      </div>

      <div>
        <label style="font-weight:700;">Price</label>
        <input name="price" type="number" min="0" step="1000" value="{{ old('price') }}" required
               style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
      </div>

      <div>
        <label style="font-weight:700;">Original Price</label>
        <input name="original_price" type="number" min="0" step="1000" value="{{ old('original_price') }}" required
               style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
      </div>

      <div>
        <label style="font-weight:700;">Discount Percent (optional)</label>
        <input name="discount_percent" type="number" min="0" max="100" value="{{ old('discount_percent', 0) }}"
               style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
      </div>

      <div>
        <label style="font-weight:700;">Expiry Date</label>
        <input name="expiry_date" type="date" value="{{ old('expiry_date') }}" required
               style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
      </div>
    </div>

    <div style="margin-top:12px;">
      <label style="font-weight:700;">Description</label>
      <textarea name="description" rows="4" required
                style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">{{ old('description') }}</textarea>
    </div>

    <div style="margin-top:12px;">
      <label style="font-weight:700;">Image (upload)</label>
      <input name="image" type="file" accept="image/*" required
             style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
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

    <div style="margin-top:16px; display:flex; gap:10px; justify-content:flex-end;">
      <a href="{{ route('seller.products.index') }}"
         class="btn2" style="text-decoration:none;">
        Cancel
      </a>

      <button type="submit" class="btn2 primary">
        Save
      </button>
    </div>

  </form>
</div>
@endsection
