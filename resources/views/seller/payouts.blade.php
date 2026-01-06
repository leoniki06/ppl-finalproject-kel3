@extends('layouts.seller')

@section('page_title','Finance')
@section('page_subtitle','Monitor balance, payouts, and sales transactions in one integrated dashboard.')

@push('styles')
<style>
  .finWrap{ display:grid; gap:16px; }
  .finTop{
    display:flex; align-items:flex-start; justify-content:space-between; gap:12px;
    margin-bottom:4px;
  }
  .finTitle{ display:flex; flex-direction:column; gap:6px; }
  .finTitle h2{
    margin:0;
    font-size:22px;
    font-weight:1000;
    letter-spacing:-.02em;
  }
  .finTitle p{
    margin:0;
    color: rgba(100,116,139,.9);
    font-weight:700;
    line-height:1.5;
  }

  .finGrid{
    display:grid;
    grid-template-columns: 1.35fr .95fr;
    gap:16px;
    align-items:start;
  }

  .kpiRow{
    display:grid;
    grid-template-columns: 1.15fr .95fr .95fr;
    gap:12px;
  }

  .cardPad{ padding:16px; }
  .soft{
    background: rgba(255,255,255,.85);
    border:1px solid rgba(15,23,42,.10);
    border-radius: 22px;
    box-shadow: 0 18px 50px rgba(15,23,42,.08);
    backdrop-filter: blur(10px);
  }

  .label{
    font-size:12px;
    letter-spacing:.10em;
    text-transform:uppercase;
    color: rgba(100,116,139,.95);
    font-weight:900;
  }

  .money{
    font-size:28px;
    font-weight:1000;
    letter-spacing:-.03em;
    margin:8px 0 0;
  }

  .rowBetween{ display:flex; align-items:center; justify-content:space-between; gap:10px; }
  .meta{
    margin-top:10px;
    color: rgba(100,116,139,.9);
    font-weight:700;
    font-size:13px;
    line-height:1.45;
  }

  .pill{
    padding:6px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:900;
    border:1px solid rgba(15,23,42,.10);
    background: rgba(255,255,255,.9);
    color: rgba(15,23,42,.85);
    white-space:nowrap;
  }
  .pill.good{
    background: rgba(16,185,129,.12);
    border-color: rgba(16,185,129,.22);
    color:#0f766e;
  }
  .pill.warn{
    background: rgba(245,158,11,.12);
    border-color: rgba(245,158,11,.22);
    color:#92400e;
  }

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
  }
  .btnGhost:hover{ transform: translateY(-1px); box-shadow: 0 14px 28px rgba(15,23,42,.08); }

  .sectionHead{
    display:flex; align-items:center; justify-content:space-between; gap:10px;
    padding:14px 16px;
    border-bottom:1px solid rgba(15,23,42,.08);
    background: rgba(255,255,255,.70);
  }
  .sectionHead h3{ margin:0; font-size:14px; font-weight:1000; letter-spacing:-.01em; }
  .sectionBody{ padding:14px 16px; }

  .table{
    width:100%;
    border-collapse:separate;
    border-spacing:0 10px;
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
  .muted{ color: rgba(100,116,139,.9); font-weight:800; }

  .status{
    padding:6px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:1000;
    display:inline-flex;
    align-items:center;
    gap:8px;
    border:1px solid rgba(15,23,42,.10);
    background: rgba(255,255,255,.92);
  }
  .status.success{ background: rgba(16,185,129,.12); border-color: rgba(16,185,129,.22); color:#0f766e; }
  .status.pending{ background: rgba(245,158,11,.12); border-color: rgba(245,158,11,.22); color:#92400e; }
  .status.failed{ background: rgba(239,68,68,.12); border-color: rgba(239,68,68,.22); color:#991b1b; }

  .status i.fa-spinner{ animation: spin 1s linear infinite; }
  @keyframes spin { 100%{ transform: rotate(360deg); } }

  .miniCard{
    padding:14px;
    border-radius:22px;
    border:1px solid rgba(15,23,42,.10);
    background: rgba(255,255,255,.78);
  }
  .miniCard h4{
    margin:0 0 6px;
    font-size:13px;
    font-weight:1000;
    letter-spacing:-.01em;
  }
  .miniCard p{
    margin:0;
    font-size:13px;
    line-height:1.5;
    color: rgba(100,116,139,.9);
    font-weight:700;
  }

  @media (max-width: 1100px){
    .finGrid{ grid-template-columns:1fr; }
    .kpiRow{ grid-template-columns:1fr; }
  }
</style>
@endpush

@section('content')

@php
  $balanceAvailable = $availableBalance ?? 0;
  $balancePending   = $pendingBalance ?? 0;
  $nextPayoutCalc   = $nextPayout ?? 0;

  $fmt = fn($n) => 'Rp'.number_format((float)$n,0,',','.');

  $statusMap = [
    'pending'    => ['cls'=>'pending','txt'=>'Pending','ic'=>'fa-clock'],
    'processing' => ['cls'=>'pending','txt'=>'Processing','ic'=>'fa-spinner'],
    'shipped'    => ['cls'=>'success','txt'=>'Shipped','ic'=>'fa-truck-fast'],
    'completed'  => ['cls'=>'success','txt'=>'Completed','ic'=>'fa-circle-check'],
    'cancelled'  => ['cls'=>'failed','txt'=>'Cancelled','ic'=>'fa-circle-xmark'],
    'failed'     => ['cls'=>'failed','txt'=>'Failed','ic'=>'fa-circle-xmark'],
  ];
@endphp

<div class="finWrap">

  <div class="finTop">
    <div class="finTitle">
      <h2>Finance</h2>
      <p>See your store balance, track sales transactions, and withdraw earnings anytime.</p>
    </div>

    <div class="rowBetween" style="gap:10px; flex-wrap:wrap; justify-content:flex-end;">
      <button class="btnGhost" type="button" onclick="LB.open('bankAccountModal')">
        <i class="fa-solid fa-building-columns"></i>
        Personal Account
      </button>

      <button class="btnPrimary" type="button" onclick="LB.open('withdrawModal')">
        <i class="fa-solid fa-arrow-up-right-from-square"></i>
        Withdraw Funds
      </button>
    </div>
  </div>

  <div class="finGrid">

    <div style="display:grid; gap:16px;">

      <div class="kpiRow">
        <div class="soft cardPad">
          <div class="rowBetween">
            <div class="label">Available Balance</div>
            <span class="pill good"><i class="fa-solid fa-circle-check"></i> Ready</span>
          </div>
          <div class="money">{{ $fmt($balanceAvailable) }}</div>
          <div class="meta">This balance can be withdrawn to your personal account.</div>
        </div>

        <div class="soft cardPad">
          <div class="rowBetween">
            <div class="label">Pending</div>
            <span class="pill warn"><i class="fa-solid fa-clock"></i> Settlement</span>
          </div>
          <div class="money">{{ $fmt($balancePending) }}</div>
          <div class="meta">Funds waiting for settlement (usually 1–2 days).</div>
        </div>

        <div class="soft cardPad">
          <div class="rowBetween">
            <div class="label">Next Payout</div>
            <span class="pill"><i class="fa-solid fa-calendar-day"></i> Weekly</span>
          </div>
          <div class="money">{{ $fmt($nextPayoutCalc) }}</div>
          <div class="meta">Estimated if you withdraw in one request.</div>
        </div>
      </div>

      <div class="soft">
        <div class="sectionHead">
          <h3>Transaction History</h3>
          <span class="pill"><i class="fa-solid fa-filter"></i> All Activity</span>
        </div>

        <div class="sectionBody">
          <table class="table">
            <thead>
              <tr>
                <th>Type</th>
                <th>Reference</th>
                <th>Date</th>
                <th style="text-align:right;">Amount</th>
                <th style="text-align:right;">Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($transactions as $t)
                @php
                  $key = strtolower((string)($t->status ?? 'pending'));
                  $m = $statusMap[$key] ?? ['cls'=>'pending','txt'=>ucfirst($key),'ic'=>'fa-circle-question'];
                @endphp
                <tr class="tr">
                  <td>Sale</td>
                  <td class="muted">{{ $t->order_number }}</td>
                  <td class="muted">{{ optional($t->created_at)->format('d M Y') }}</td>
                  <td style="text-align:right;">{{ $fmt($t->total_amount) }}</td>
                  <td style="text-align:right;">
                    <span class="status {{ $m['cls'] }}">
                      <i class="fa-solid {{ $m['ic'] }}"></i> {{ $m['txt'] }}
                    </span>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="muted" style="padding:12px;">Belum ada transaksi.</td>
                </tr>
              @endforelse
            </tbody>
          </table>

          <div class="meta" style="margin-top:8px;">
            Tip: Items in <b>Pending</b> will move into <b>Available Balance</b> once settled.
          </div>
        </div>
      </div>

    </div>

    <div style="display:grid; gap:16px;">
      <div class="soft">
        <div class="sectionHead">
          <h3>Personal Account</h3>
          <button class="btnGhost" type="button" onclick="LB.open('bankAccountModal')" style="height:36px;">
            <i class="fa-solid fa-pen"></i> Edit
          </button>
        </div>
        <div class="sectionBody">
          <div class="miniCard">
            <h4>BCA • **** 1029</h4>
            <p>Account holder: <b style="color:rgba(15,23,42,.92)">Tata Julista</b></p>
            <p style="margin-top:8px;">Withdrawals will be sent to this account.</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="ov" id="withdrawModal">
  <div class="modal">
    <div class="mHead">
      <h4>Withdraw Funds</h4>
      <button class="x" type="button" onclick="LB.close('withdrawModal')"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <div class="mBody">
      <div class="meta" style="margin-top:0">
        Available balance: <b style="color:rgba(15,23,42,.92)">{{ $fmt($balanceAvailable) }}</b>
      </div>

      <div class="mActs">
        <button class="btnGhost" type="button" onclick="LB.close('withdrawModal')">Cancel</button>

        <form action="{{ route('seller.payouts.withdraw') }}" method="POST" style="margin:0">
          @csrf
          <button class="btnPrimary" type="submit">
            <i class="fa-solid fa-paper-plane"></i>
            Submit Withdrawal (Dummy)
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="ov" id="bankAccountModal">
  <div class="modal">
    <div class="mHead">
      <h4>Personal Account</h4>
      <button class="x" type="button" onclick="LB.close('bankAccountModal')"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <div class="mBody">
      <div class="meta" style="margin-top:0">
        Update your bank account for withdrawals. (Dummy version)
      </div>

      <div class="mActs">
        <button class="btnGhost" type="button" onclick="LB.close('bankAccountModal')">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection
