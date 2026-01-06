@extends('layouts.seller')

@section('title','Orders • LastBite')
@section('page_title','Orders')
@section('page_subtitle','Lihat dan proses pesanan dari customer.')

@section('content')
<div class="card" style="padding:18px;">

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

  <form method="GET" action="{{ route('seller.orders.index') }}"
        style="display:flex; gap:12px; margin-top:4px; flex-wrap:wrap;">

    <input type="text" name="q" value="{{ request('q') }}"
           placeholder="Cari order number / nama customer..."
           class="ctl" style="flex:1; min-width:240px;">

    <select name="status" class="ctl" style="width:180px;">
      <option value="">All Status</option>
      <option value="pending" @selected(request('status')==='pending')>Pending</option>
      <option value="processing" @selected(request('status')==='processing')>Processing</option>
      <option value="shipped" @selected(request('status')==='shipped')>Shipped</option>
      <option value="completed" @selected(request('status')==='completed')>Completed</option>
      <option value="cancelled" @selected(request('status')==='cancelled')>Cancelled</option>
    </select>

    <select name="pay" class="ctl" style="width:180px;">
      <option value="">All Payment</option>
      <option value="unpaid" @selected(request('pay')==='unpaid')>Unpaid</option>
      <option value="paid" @selected(request('pay')==='paid')>Paid</option>
      <option value="refunded" @selected(request('pay')==='refunded')>Refunded</option>
    </select>

    <select name="sort" class="ctl" style="width:180px;">
      <option value="latest" @selected(request('sort')==='latest')>Latest</option>
      <option value="oldest" @selected(request('sort')==='oldest')>Oldest</option>
      <option value="total_desc" @selected(request('sort')==='total_desc')>Total High-Low</option>
      <option value="total_asc" @selected(request('sort')==='total_asc')>Total Low-High</option>
    </select>

    <button class="btn2 btnSm" type="submit">Apply</button>
  </form>

  <div style="margin-top:18px; overflow:auto; border:1px solid #eee; border-radius:14px;">
    <table style="width:100%; border-collapse:collapse;">
      <thead>
        <tr style="background:#fafafa">
          <th style="text-align:left; padding:12px; border-bottom:1px solid #eee;">Order</th>
          <th style="text-align:left; padding:12px; border-bottom:1px solid #eee;">Customer</th>
          <th style="text-align:left; padding:12px; border-bottom:1px solid #eee;">Total</th>
          <th style="text-align:left; padding:12px; border-bottom:1px solid #eee;">Status</th>
          <th style="text-align:left; padding:12px; border-bottom:1px solid #eee;">Payment</th>
          <th style="text-align:left; padding:12px; border-bottom:1px solid #eee;">Actions</th>
        </tr>
      </thead>

      <tbody>
        @forelse($orders as $o)
          @php
            $s  = $o->status ?? 'pending';
            $ps = $o->payment_status ?? 'unpaid';

            $statusBadge = [
              'pending' => ['#fff3cd','#8a6d3b','Pending'],
              'processing' => ['#eaf4ff','#2457d6','Processing'],
              'shipped' => ['#eef2ff','#4338ca','Shipped'],
              'completed' => ['#e7f7ee','#1a7f37','Completed'],
              'cancelled' => ['#fee','#a00','Cancelled'],
            ][$s] ?? ['#eee','#444', ucfirst($s)];

            $payBadge = [
              'unpaid' => ['#fee','#a00','UNPAID'],
              'paid' => ['#e7f7ee','#1a7f37','PAID'],
              'refunded' => ['#eee','#444','REFUNDED'],
            ][$ps] ?? ['#eee','#444', strtoupper($ps)];
          @endphp

          <tr style="border-bottom:1px solid #f0f0f0">
            <td style="padding:12px;">
              <div style="font-weight:900;">#{{ $o->order_number }}</div>
              <div style="font-size:12px; color:#777;">
                {{ optional($o->created_at)->format('d M Y, H:i') }}
              </div>
            </td>

            <td style="padding:12px;">
              <div style="font-weight:700;">{{ $o->user->name ?? 'Customer' }}</div>
              <div style="font-size:12px; color:#777;">User ID: {{ $o->user_id }}</div>
            </td>

            <td style="padding:12px; font-weight:800;">
              Rp {{ number_format($o->total_amount, 0, ',', '.') }}
            </td>

            <td style="padding:12px;">
              <span style="padding:4px 10px; border-radius:999px; background:{{ $statusBadge[0] }}; color:{{ $statusBadge[1] }}; font-size:12px; font-weight:900;">
                {{ $statusBadge[2] }}
              </span>
            </td>

            <td style="padding:12px;">
              <span style="padding:4px 10px; border-radius:999px; background:{{ $payBadge[0] }}; color:{{ $payBadge[1] }}; font-size:12px; font-weight:900;">
                {{ $payBadge[2] }}
              </span>
            </td>

            <td style="padding:12px;">
              <div style="display:flex; gap:10px; flex-wrap:wrap;">

                @if(Route::has('seller.orders.show'))
                  <a class="btn2 btnSm" href="{{ route('seller.orders.show', $o->id) }}">Detail</a>
                @endif

                @if(Route::has('seller.orders.updateStatus'))
                  @if($s === 'pending')
                    <form method="POST" action="{{ route('seller.orders.updateStatus', $o->id) }}">
                      @csrf
                      @method('PATCH')
                      <input type="hidden" name="status" value="processing">
                      <button class="btn2 btnSm" type="submit">Set Processing</button>
                    </form>
                  @elseif($s === 'processing')
                    <form method="POST" action="{{ route('seller.orders.updateStatus', $o->id) }}">
                      @csrf
                      @method('PATCH')
                      <input type="hidden" name="status" value="shipped">
                      <button class="btn2 btnSm" type="submit">Set Shipped</button>
                    </form>
                  @elseif($s === 'shipped')
                    <form method="POST" action="{{ route('seller.orders.updateStatus', $o->id) }}">
                      @csrf
                      @method('PATCH')
                      <input type="hidden" name="status" value="completed">
                      <button class="btn2 btnSm" type="submit">Set Completed</button>
                    </form>
                  @endif
                @endif

              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" style="padding:14px; color:#777;">Belum ada pesanan.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top:14px;">
    {{ $orders->links() }}
  </div>

</div>
@endsection
