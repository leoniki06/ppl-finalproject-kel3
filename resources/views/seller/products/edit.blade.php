@extends('layouts.seller')

@section('title','Edit Product • LastBite')
@section('page_title','Edit Product')
@section('page_subtitle','Ubah data produk kamu.')

@section('content')
<div class="card" style="padding:18px; max-width:980px;">

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

  <form method="POST" action="{{ route('seller.products.update', $product->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
      <div>
        <label style="font-weight:700;">Name</label>
        <input name="name" value="{{ old('name',$product->name) }}" required
          style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
      </div>

      <div>
        <label style="font-weight:700;">Brand / Nama Toko</label>
        <input name="brand" value="{{ old('brand',$product->brand) }}" required
          style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
      </div>

      <div>
        <label style="font-weight:700;">Category</label>
        <input name="category" value="{{ old('category',$product->category) }}" required
          style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
      </div>

      <div>
        <label style="font-weight:700;">Stock</label>
        <input name="stock" type="number" min="0" value="{{ old('stock',$product->stock) }}" required
          style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
      </div>

      <div>
        <label style="font-weight:700;">Price</label>
        <input name="price" type="number" min="0" value="{{ old('price',$product->price) }}" required
          style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
      </div>

      <div>
        <label style="font-weight:700;">Original Price</label>
        <input name="original_price" type="number" min="0" value="{{ old('original_price',$product->original_price) }}" required
          style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
      </div>

      <div>
        <label style="font-weight:700;">Discount Percent (optional)</label>
        <input name="discount_percent" type="number" min="0" max="100"
          value="{{ old('discount_percent',$product->discount_percent ?? 0) }}"
          style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
      </div>

      <div>
        <label style="font-weight:700;">Expiry Date</label>
        <input name="expiry_date" type="date" value="{{ old('expiry_date',$product->expiry_date) }}" required
          style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
      </div>
    </div>

    <div style="margin-top:12px;">
      <label style="font-weight:700;">Description</label>
      <textarea name="description" rows="4" required
        style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">{{ old('description',$product->description) }}</textarea>
    </div>

    <div style="margin-top:12px;">
      <label style="font-weight:700;">Current Image</label><br>
      @if($product->image_url)
        <img src="{{ asset('storage/'.$product->image_url) }}" style="width:120px; height:120px; object-fit:cover; border-radius:12px; border:1px solid #eee;">
      @else
        <div style="color:#777;">No image</div>
      @endif
    </div>

    <div style="margin-top:12px;">
      <label style="font-weight:700;">Replace Image (optional)</label>
      <input name="image" type="file" accept="image/*"
        style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; margin-top:6px;">
      <small style="color:#777;">* maksimal 2MB</small>
    </div>

    <div style="margin-top:12px; display:flex; gap:16px;">
      <label style="display:flex; gap:8px; align-items:center;">
        <input type="checkbox" name="is_flash_sale" value="1" @checked(old('is_flash_sale',$product->is_flash_sale))>
        Flash Sale
      </label>

      <label style="display:flex; gap:8px; align-items:center;">
        <input type="checkbox" name="is_recommended" value="1" @checked(old('is_recommended',$product->is_recommended))>
        Recommended
      </label>
    </div>

    <div style="margin-top:16px; display:flex; justify-content:flex-end; gap:10px;">
      <a href="{{ route('seller.products.index') }}" class="btn2">Cancel</a>
      <button type="submit" class="btn2 primary">Update</button>
    </div>
  </form>
</div>
@endsection
