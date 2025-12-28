@extends('layouts.app')

@section('content')
<div class="container" style="padding:24px">
  <h1>Store Profile</h1>
  <p>Halaman ini untuk edit identitas toko.</p>

  <div style="margin-top:16px">
    <a href="{{ route('seller.dashboard') }}">← Kembali ke Seller Dashboard</a>
  </div>

  <hr style="margin:20px 0">

  <form>
    <div style="margin-bottom:10px">
      <label>Nama Toko</label><br>
      <input type="text" value="Toko tata" style="width:300px">
    </div>

    <div style="margin-bottom:10px">
      <label>Alamat</label><br>
      <input type="text" value="Alamat belum diisi" style="width:500px">
    </div>

    <div style="margin-bottom:10px">
      <label>Jam Operasional</label><br>
      <input type="text" value="08:00 - 22:00" style="width:200px">
    </div>

    <button type="button">Simpan (dummy)</button>
  </form>
</div>
@endsection
