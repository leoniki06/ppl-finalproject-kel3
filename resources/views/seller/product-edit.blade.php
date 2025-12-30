@extends('layouts.seller')

@section('content')
<div class="container" style="padding:24px; max-width:900px">

  <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
    <div>
      <h1 style="margin:0">Edit Product</h1>
      <p style="margin:6px 0 0; color:#666">Edit produk ID: <b>#{{ $id }}</b> (dummy dulu).</p>
    </div>
    <div style="display:flex; gap:10px; align-items:center;">
      <a href="{{ route('seller.products.index') }}" style="text-decoration:none">← Back</a>
    </div>
  </div>

  @if(session('success'))
    <div style="margin-top:14px; padding:12px; border:1px solid #d4edda; background:#eaf7ee; border-radius:12px;">
      {{ session('success') }}
    </div>
  @endif

  @php
    // Dummy contoh isi (nanti diganti DB)
    $p = [
      'name' => 'Dummy Product '.$id,
      'category' => 'snack',
      'price' => 15000,
      'stock' => 5,
      'description' => 'Ini deskripsi dummy.',
      'image_url' => '',
    ];
  @endphp

  <div style="margin-top:16px; border:1px solid #eee; border-radius:14px; padding:16px;">
    <form method="POST" action="{{ route('seller.products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input name="name" value="{{ old('name', $product->name) }}" required>
        <input name="brand" value="{{ old('brand', $product->brand) }}" required>
        <input name="category" value="{{ old('category', $product->category) }}" required>

        <textarea name="description" required>{{ old('description', $product->description) }}</textarea>

        <input name="price" type="number" value="{{ old('price', $product->price) }}" required>
        <input name="original_price" type="number" value="{{ old('original_price', $product->original_price) }}" required>
        <input name="discount_percent" type="number" min="0" max="100" value="{{ old('discount_percent', $product->discount_percent) }}">

        <input name="stock" type="number" min="0" value="{{ old('stock', $product->stock) }}" required>
        <input name="expiry_date" type="date" value="{{ old('expiry_date', $product->expiry_date?->format('Y-m-d')) }}" required>

        <input name="image" type="file" accept="image/*"> {{-- optional --}}

        <button type="submit">Update</button>
      </form>

  </div>
</div>
@endsection
