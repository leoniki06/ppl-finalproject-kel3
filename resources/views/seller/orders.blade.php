@extends('layouts.app')

@section('content')
<div class="container" style="padding:24px">
  <h1>Manage Orders</h1>
  <p>Halaman ini untuk lihat dan proses pesanan.</p>

  <div style="margin-top:16px">
    <a href="{{ route('seller.dashboard') }}">← Kembali ke Seller Dashboard</a>
  </div>

  <hr style="margin:20px 0">

  <h3>Pesanan (dummy)</h3>
  <table border="1" cellpadding="8" cellspacing="0">
    <tr><th>ID</th><th>Customer</th><th>Status</th><th>Total</th></tr>
    <tr><td>1</td><td>Budi</td><td>pending</td><td>125000</td></tr>
    <tr><td>2</td><td>Siti</td><td>processing</td><td>89000</td></tr>
  </table>
</div>
@endsection
