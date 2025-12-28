@extends('layouts.app')

@section('content')
<div class="container" style="padding:24px">
  <h1>Payouts</h1>
  <p>Halaman ini untuk riwayat pencairan dana.</p>

  <div style="margin-top:16px">
    <a href="{{ route('seller.dashboard') }}">← Kembali ke Seller Dashboard</a>
  </div>

  <hr style="margin:20px 0">

  <h3>Riwayat (dummy)</h3>
  <ul>
    <li>23 Dec 2025 - Rp 500.000 - SUCCESS</li>
    <li>20 Dec 2025 - Rp 250.000 - SUCCESS</li>
  </ul>
</div>
@endsection
