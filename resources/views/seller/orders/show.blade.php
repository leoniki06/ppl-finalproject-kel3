@extends('layouts.seller')

@section('title','Order Detail • LastBite')
@section('page_title','Order Detail')
@section('page_subtitle','Lihat detail pesanan, update status, dan konfirmasi pembayaran COD.')

@push('styles')
<style>
  .odWrap{ display:grid; gap:16px; }
  .odGrid{
    display:grid;
    grid-template-columns: 1.25fr .75fr;
    gap:16px;
    align-items:start;
  }
  .cardPad{ padding:18px; }
  .soft{
    background: rgba(255,255,255,.86);
    border:1px solid rgba(15,23,42,.10);
    border-radius: 22px;
    box-shadow: 0 18px 50px rgba(15,23,42,.08);
    backdrop-filter: blur(10px);
  }
  .headRow{ display:flex; align-items:flex-start; justify-content:space-between; gap:12px; flex-wrap:wrap; }
  .titleBox h2{ margin:0; font-size:18px; font-weight:1000; letter-spacing:-.02em; }
  .titleBox p{ margin:6px 0 0; color:rgba(100,116,139,.9); font-weight:800; font-size:13px; line-height:1.5; }
  .pill{
    padding:6px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:1000;
    border:1px solid rgba(15,23,42,.10);
    background: rgba(255,255,255,.90);
    color: rgba(15,23,42,.85);
    white-space:nowrap;
    display:inline-flex;
    align-items:center;
    gap:8px;
  }
  .pill.pending{ background: rgba(245,158,11,.12); border-color: rgba(245,158,11,.22); color:#92400e; }
  .pill.processing{ background: rgba(59,130,246,.12); border-color: rgba(59,130,246,.22); color:#1d4ed8; }
  .pill.shipped{ background: rgba(99,102,241,.12); border-color: rgba(99,102,241,.22); color:#4338ca; }
  .pill.completed{ background: rgba(16,185,129,.12); border-color: rgba(16,185,129,.22); color:#0f766e; }
  .pill.cancelled{ background: rgba(239,68,68,.12); border-color: rgba(239,68,68,.22); color:#991b1b; }
  .pill.unpaid{ background: rgba(239,68,68,.12); border-color: rgba(239,68,68,.22); color:#991b1b; }
  .pill.paid{ background: rgba(16,185,129,.12); border-color: rgba(16,185,129,.22); color:#0f766e; }

  .infoGrid{
    display:grid;
    grid-template-columns: repeat(2, 1fr);
    gap:12px;
    margin-top:14px;
  }
  .infoBox{
    padding:14px;
    border-radius:18px;
    border:1px solid rgba(15,23,42,.10);
    background: rgba(255,255,255,.78);
  }
  .label{
    font-size:11px;
    letter-spacing:.10em;
    text-transform:uppercase;
    color: rgba(100,116,139,.95);
    font-weight:900;
  }
  .val{
    margin-top:6px;
    font-weight:1000;
    color: rgba(15,23,42,.92);
    line-height:1.3;
  }
  .muted{ color: rgba(100,116,139,.9); font-weight:800; }

  .table{
    width:100%;
    border-collapse:separate;
    border-spacing:0 10px;
    margin-top:14px;
  }
  .tr{
    background: rgba(255,255,255,.78);
    border:1px solid rgba(15,23,42,.10);
    border-radius:16px;
  }
  .table td, .table th{
    padding:12px 12px;
    font-weight:800;
    font-size:13px;
    color: rgba(15,23,42,.88);
  }
  .table th{
    font-size:12px;
    letter-spacing:.10em;
    text-transform:uppercase;
    color: rgba(100,116,139,.9);
    font-weight:900;
  }

  .btnRow{ display:flex; gap:10px; flex-wrap:wrap; }
  .btnPrimary{
    height:42px;
    padding:0 14px;
    border-radius:999px;
    border:0;
    cursor:pointer;
    font-weight:1000;
    display:inline-flex;
    align-items:center;
    gap:10px;
    color: rgba(15,23,42,.92);
    background: linear-gradient(135deg,#d7ff1e,#b8ff36);
    box-shadow: 0 18px 44px rgba(215,255,30,.22);
    transition:.15s ease;
    text-decoration:none;
  }
  .btnPrimary:hover{ transform: translateY(-1px); box-shadow: 0 22px 54px rgba(215,255,30,.28); }
  .btnGhost{
    height:42px;
    padding:0 14px;
    border-radius:999px;
    border:1px solid rgba(15,23,42,.12);
    background: rgba(255,255,255,.92);
    cursor:pointer;
    font-weight:900;
    display:inline-flex;
    align-items:center;
    gap:10px;
    color: rgba(15,23,42,.92);
    transition:.15s ease;
    text-decoration:none;
  }
  .btnGhost:hover{ transform: translateY(-1px); box-shadow: 0 14px 28px rgba(15,23,42,.08); }
  .btnDanger{
    height:42px;
    padding:0 14px;
    border-radius:999px;
    border:1px solid rgba(239,68,68,.25);
    background: rgba(239,68,68,.10);
    cursor:pointer;
    font-weight:1000;
    display:inline-flex;
    align-items:center;
    gap:10px;
    color: #991b1b;
    transition:.15s ease;
  }
  .btnDanger:hover{ transform: translateY(-1px); box-shadow: 0 14px 28px rgba(239,68,68,.14); }

  .sectionHead{
    display:flex; align-items:center; justify-content:space-between; gap:10px;
    padding:14px 16px;
    border-bottom:1px solid rgba(15,23,42,.08);
    background: rgba(255,255,255,.70);
    border-top-left-radius:22px;
    border-top-right-radius:22px;
  }
  .sectionHead h3{ margin:0; font-size:14px; font-weight:1000; letter-spacing:-.01em; }
  .sectionBody{ padding:14px 16px; }

  .steps{ display:grid; gap:10px; margin-top:12px; }
  .step{
    padding:12px 12px;
    border-radius:16px;
    border:1px solid rgba(15,23,42,.10);
    background: rgba(255,255,255,.78);
    display:flex;
    align-items:flex-start;
    gap:12px;
  }
  .dot{
    width:34px;
    height:34px;
    border-radius:999px;
    display:flex;
    align-items:center;
    justify-content:center;
    border:1px solid rgba(15,23,42,.10);
    background: rgba(255,255,255,.9);
    font-weight:1000;
    color: rgba(15,23,42,.85);
    flex:0 0 auto;
  }
  .step b{ font-weight:1000; color: rgba(15,23,42,.92); }
  .step p{ margin:4px 0 0; color: rgba(100,116,139,.9); font-weight:800; line-height:1.45; font-size:13px; }

  @media(max-width:1100px){
    .odGrid{ grid-template-columns:1fr; }
    .infoGrid{ grid-template-columns:1fr; }
  }
</style>
@endpush

@section('content')

@php
  $fmt = fn($n) => 'Rp'.number_format((float)$n,0,',','.');

  $status = $order->status ?? 'pending';
  $pay = $order->payment_status ?? 'unpaid';

  $statusMap = [
    'pending' => ['Pending','fa-clock','pending'],
    'processing' => ['Processing','fa-gears','processing'],
    'shipped' => ['Shipped','fa-truck-fast','shipped'],
    'completed' => ['Completed','fa-circle-check','completed'],
    'cancelled' => ['Cancelled','fa-circle-xmark','cancelled'],
  ];
  $payMap = [
    'unpaid' => ['UNPAID','fa-circle-xmark','unpaid'],
    'paid' => ['PAID','fa-circle-check','paid'],
    'refunded' => ['REFUNDED','fa-rotate-left',''],
  ];

  $sBadge = $statusMap[$status] ?? [ucfirst($status),'fa-circle-info',''];
  $pBadge = $payMap[$pay] ?? [strtoupper($pay),'fa-circle-info',''];

  $customerName = $order->user->name ?? 'Customer';
  $itemsCount = $order->items_count ?? ($order->items?->count() ?? 0);
@endphp

<div class="odWrap">

  <div class="soft cardPad">
    <div class="headRow">
      <div class="titleBox">
        <h2>Order #{{ $order->order_number }}</h2>
        <p>
          Dibuat: <b style="color:rgba(15,23,42,.92)">{{ optional($order->created_at)->format('d M Y, H:i') }}</b>
          • Customer: <b style="color:rgba(15,23,42,.92)">{{ $customerName }}</b>
        </p>
      </div>

      <div class="btnRow">
        <span class="pill {{ $sBadge[2] }}"><i class="fa-solid {{ $sBadge[1] }}"></i> {{ $sBadge[0] }}</span>
        <span class="pill {{ $pBadge[2] }}"><i class="fa-solid {{ $pBadge[1] }}"></i> {{ $pBadge[0] }}</span>
        <a class="btnGhost" href="{{ route('seller.orders.index') }}"><i class="fa-solid fa-arrow-left"></i> Back</a>
      </div>
    </div>

    <div class="infoGrid">
      <div class="infoBox">
        <div class="label">Total Payment</div>
        <div class="val">{{ $fmt($order->total_amount) }}</div>
        <div class="muted" style="margin-top:6px;">{{ $itemsCount }} item</div>
      </div>

      <div class="infoBox">
        <div class="label">Order ID</div>
        <div class="val">#{{ $order->id }}</div>
        <div class="muted" style="margin-top:6px;">Seller ID: {{ $order->seller_id }}</div>
      </div>

      <div class="infoBox">
        <div class="label">Payment Method</div>
        <div class="val">{{ strtoupper($order->payment_method ?? 'COD') }}</div>
        <div class="muted" style="margin-top:6px;">
          @if($order->payment_method === 'cod' || $order->payment_method === null)
            Cash on Delivery
          @else
            Online Payment
          @endif
        </div>
      </div>

      <div class="infoBox">
        <div class="label">Paid At</div>
        <div class="val">{{ $order->paid_at ? \Carbon\Carbon::parse($order->paid_at)->format('d M Y, H:i') : '-' }}</div>
        <div class="muted" style="margin-top:6px;">(Jika COD, diisi setelah konfirmasi)</div>
      </div>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th>Product</th>
          <th style="text-align:right;">Price</th>
          <th style="text-align:center;">Qty</th>
          <th style="text-align:right;">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @forelse($order->items as $it)
          @php
            $p = $it->product;
            $name = $p->name ?? 'Produk';
            $price = $it->price ?? ($p->price ?? 0);
            $qty = $it->quantity ?? 1;
            $sub = $price * $qty;
          @endphp
          <tr class="tr">
            <td>
              <div style="font-weight:1000;">{{ $name }}</div>
              <div class="muted" style="font-size:12px; margin-top:4px;">
                {{ $p->category ?? '-' }}
              </div>
            </td>
            <td style="text-align:right;">{{ $fmt($price) }}</td>
            <td style="text-align:center;">{{ $qty }}</td>
            <td style="text-align:right;">{{ $fmt($sub) }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="muted" style="padding:14px;">Tidak ada item.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div style="margin-top:14px; display:flex; justify-content:flex-end;">
      <div style="min-width:260px; padding:14px; border-radius:18px; border:1px solid rgba(15,23,42,.10); background:rgba(255,255,255,.78);">
        <div class="label">Grand Total</div>
        <div style="margin-top:8px; font-size:22px; font-weight:1000; letter-spacing:-.02em;">
          {{ $fmt($order->total_amount) }}
        </div>
      </div>
    </div>
  </div>

  <div class="odGrid">

    <div class="soft">
      <div class="sectionHead">
        <h3>Status Timeline</h3>
        <span class="pill"><i class="fa-solid fa-signal"></i> Live</span>
      </div>

      <div class="sectionBody">
        <div class="steps">
          <div class="step">
            <div class="dot">1</div>
            <div>
              <b>Pending</b>
              <p>Pesanan masuk & menunggu diproses.</p>
              <p class="muted" style="margin-top:6px;">{{ $order->created_at ? $order->created_at->format('d M Y, H:i') : '-' }}</p>
            </div>
          </div>

          <div class="step">
            <div class="dot">2</div>
            <div>
              <b>Processing</b>
              <p>Seller mulai menyiapkan pesanan.</p>
              <p class="muted" style="margin-top:6px;">{{ $order->processed_at ? \Carbon\Carbon::parse($order->processed_at)->format('d M Y, H:i') : '-' }}</p>
            </div>
          </div>

          <div class="step">
            <div class="dot">3</div>
            <div>
              <b>Shipped</b>
              <p>Pesanan sudah dikirim / diantar.</p>
              <p class="muted" style="margin-top:6px;">{{ $order->shipped_at ? \Carbon\Carbon::parse($order->shipped_at)->format('d M Y, H:i') : '-' }}</p>
            </div>
          </div>

          <div class="step">
            <div class="dot">4</div>
            <div>
              <b>Completed</b>
              <p>Pesanan selesai diterima customer.</p>
              <p class="muted" style="margin-top:6px;">{{ $order->completed_at ? \Carbon\Carbon::parse($order->completed_at)->format('d M Y, H:i') : '-' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="soft">
      <div class="sectionHead">
        <h3>Actions</h3>
        <span class="pill"><i class="fa-solid fa-bolt"></i> Quick</span>
      </div>

      <div class="sectionBody" style="display:grid; gap:12px;">
        <div class="btnRow">

          @if($status === 'pending')
            <form method="POST" action="{{ route('seller.orders.updateStatus', $order->id) }}" style="margin:0;">
              @csrf
              @method('PATCH')
              <input type="hidden" name="status" value="processing">
              <button class="btnPrimary" type="submit"><i class="fa-solid fa-gears"></i> Set Processing</button>
            </form>
          @endif

          @if($status === 'processing')
            <form method="POST" action="{{ route('seller.orders.updateStatus', $order->id) }}" style="margin:0;">
              @csrf
              @method('PATCH')
              <input type="hidden" name="status" value="shipped">
              <button class="btnPrimary" type="submit"><i class="fa-solid fa-truck-fast"></i> Set Shipped</button>
            </form>
          @endif

          @if($status === 'shipped')
            <form method="POST" action="{{ route('seller.orders.updateStatus', $order->id) }}" style="margin:0;">
              @csrf
              @method('PATCH')
              <input type="hidden" name="status" value="completed">
              <button class="btnPrimary" type="submit"><i class="fa-solid fa-circle-check"></i> Set Completed</button>
            </form>
          @endif

          @if($pay === 'unpaid')
            @if(Route::has('seller.orders.markPaid'))
              <form method="POST" action="{{ route('seller.orders.markPaid', $order->id) }}" style="margin:0;">
                @csrf
                <button class="btnGhost" type="submit">
                  <i class="fa-solid fa-money-bill-wave"></i> Konfirmasi COD (Paid)
                </button>
              </form>
            @else
              <div class="muted" style="font-size:13px; font-weight:900;">
                Route COD belum dibuat (seller.orders.markPaid).
              </div>
            @endif
          @endif

          @if($status !== 'cancelled' && $status !== 'completed')
            <form method="POST" action="{{ route('seller.orders.updateStatus', $order->id) }}" style="margin:0;">
              @csrf
              @method('PATCH')
              <input type="hidden" name="status" value="cancelled">
              <button class="btnDanger" type="submit"><i class="fa-solid fa-xmark"></i> Cancel</button>
            </form>
          @endif

        </div>

        <div class="muted" style="font-size:13px; font-weight:900; line-height:1.6;">
          Jika pesanan <b>COD</b> dan uang sudah diterima, klik <b>Konfirmasi COD</b> agar payment berubah jadi <b>PAID</b>.
        </div>

        <div style="height:1px; background:rgba(15,23,42,.08); margin:4px 0;"></div>

        <div class="muted" style="font-size:13px; font-weight:900; line-height:1.6;">
          Urutan normal:
          <b>Pending → Processing → Shipped → Completed</b>.
        </div>

      </div>
    </div>

  </div>

</div>
@endsection
