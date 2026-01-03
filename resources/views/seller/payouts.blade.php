@extends('layouts.seller')

@section('page_title','Finance')
@section('page_subtitle','Monitor balance, payouts, and sales transactions in one integrated dashboard.')

@push('styles')
<style>
  /* ========= FINANCE PAGE ========= */
  .finWrap{ display:grid; gap:16px; }
  .finTop{
    display:flex; align-items:flex-start; justify-content:space-between; gap:12px;
    margin-bottom:4px;
  }
  .finTitle{
    display:flex; flex-direction:column; gap:6px;
  }
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
  .miniRow{ display:grid; gap:12px; }

  .splitLine{
    height:1px; background: rgba(15,23,42,.08); margin:12px 0;
  }

  /* responsive */
  @media (max-width: 1100px){
    .finGrid{ grid-template-columns:1fr; }
    .kpiRow{ grid-template-columns:1fr; }
  }
</style>
@endpush

@section('content')

@php
  // ====== DUMMY DATA (sementara). Nanti diganti dari controller ======
  $balanceAvailable = 350000;    // saldo siap tarik
  $balancePending   = 125000;    // saldo menunggu (mis: belum settle)
  $paylaterLimit    = 500000;    // limit paylater
  $paylaterUsed     = 150000;    // terpakai

  $bankName = 'BCA';
  $bankHolder = 'Tata Julista';
  $bankMasked = '**** 1029';

  $transactions = [
    ['type'=>'Sale', 'ref'=>'ORD-1203', 'date'=>'02 Jan 2026', 'amount'=>120000, 'status'=>'success'],
    ['type'=>'Sale', 'ref'=>'ORD-1198', 'date'=>'01 Jan 2026', 'amount'=>85000,  'status'=>'success'],
    ['type'=>'Payout', 'ref'=>'WD-2201', 'date'=>'23 Dec 2025', 'amount'=>500000, 'status'=>'success'],
    ['type'=>'Payout', 'ref'=>'WD-2194', 'date'=>'20 Dec 2025', 'amount'=>250000, 'status'=>'success'],
    ['type'=>'Sale', 'ref'=>'ORD-1182', 'date'=>'18 Dec 2025', 'amount'=>65000,  'status'=>'pending'],
  ];

  $fmt = fn($n) => 'Rp'.number_format($n,0,',','.');
  $paylaterLeft = max($paylaterLimit - $paylaterUsed, 0);
@endphp

<div class="finWrap">

  {{-- ====== Top: CTA utama ====== --}}
  <div class="finTop">
    <div class="finTitle">
      <h2>Finance</h2>
      <p>See your store balance, track sales transactions, manage paylater, and withdraw earnings anytime.</p>
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

  {{-- ====== GRID 2 kolom ====== --}}
  <div class="finGrid">

    {{-- ====== LEFT: Balance + Transactions ====== --}}
    <div style="display:grid; gap:16px;">

      {{-- KPI Row --}}
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
            <span class="pill warn"><i class="fa-solid fa-clock"></i> Processing</span>
          </div>
          <div class="money">{{ $fmt($balancePending) }}</div>
          <div class="meta">Funds waiting for settlement (usually 1–2 days).</div>
        </div>

        <div class="soft cardPad">
          <div class="rowBetween">
            <div class="label">Next Payout</div>
            <span class="pill"><i class="fa-solid fa-calendar-day"></i> Weekly</span>
          </div>
          <div class="money">{{ $fmt( (int)($balanceAvailable * 0.6) ) }}</div>
          <div class="meta">Estimated if you withdraw in one request.</div>
        </div>
      </div>

      {{-- Transaction History --}}
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
              @foreach($transactions as $t)
                <tr class="tr">
                  <td>{{ $t['type'] }}</td>
                  <td class="muted">{{ $t['ref'] }}</td>
                  <td class="muted">{{ $t['date'] }}</td>
                  <td style="text-align:right;">{{ $fmt($t['amount']) }}</td>
                  <td style="text-align:right;">
                    @php
                      $cls = $t['status']==='success' ? 'success' : ($t['status']==='pending' ? 'pending' : 'failed');
                      $txt = $t['status']==='success' ? 'Success' : ($t['status']==='pending' ? 'Pending' : 'Failed');
                      $ic  = $t['status']==='success' ? 'fa-circle-check' : ($t['status']==='pending' ? 'fa-clock' : 'fa-circle-xmark');
                    @endphp
                    <span class="status {{ $cls }}">
                      <i class="fa-solid {{ $ic }}"></i> {{ $txt }}
                    </span>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          <div class="meta" style="margin-top:8px;">
            Tip: Keep an eye on <b>Pending</b> items—once settled, they move to <b>Available Balance</b>.
          </div>
        </div>
      </div>

    </div>

    {{-- ====== RIGHT: Paylater + Bank Account + Quick Actions ====== --}}
    <div style="display:grid; gap:16px;">

      {{-- Paylater --}}
      <div class="soft">
        <div class="sectionHead">
          <h3>PayLater</h3>
          <span class="pill"><i class="fa-solid fa-credit-card"></i> Active</span>
        </div>
        <div class="sectionBody">
          <div class="miniCard">
            <div class="rowBetween">
              <div>
                <div class="label">Limit</div>
                <div style="font-weight:1000; font-size:18px; margin-top:6px;">{{ $fmt($paylaterLimit) }}</div>
              </div>
              <div style="text-align:right;">
                <div class="label">Remaining</div>
                <div style="font-weight:1000; font-size:18px; margin-top:6px;">{{ $fmt($paylaterLeft) }}</div>
              </div>
            </div>
            <div class="splitLine"></div>
            <div class="rowBetween">
              <div class="muted">Used</div>
              <div style="font-weight:1000;">{{ $fmt($paylaterUsed) }}</div>
            </div>
            <div class="meta" style="margin-top:10px;">
              Use PayLater to keep stock moving while waiting for settlements.
            </div>
          </div>

          <div style="display:flex; gap:10px; margin-top:12px; flex-wrap:wrap;">
            <button class="btnGhost" type="button">
              <i class="fa-solid fa-file-invoice-dollar"></i>
              View Bills
            </button>
            <button class="btnGhost" type="button">
              <i class="fa-solid fa-circle-info"></i>
              Learn More
            </button>
          </div>
        </div>
      </div>

      {{-- Personal Account --}}
      <div class="soft">
        <div class="sectionHead">
          <h3>Personal Account</h3>
          <button class="btnGhost" type="button" onclick="LB.open('bankAccountModal')" style="height:36px;">
            <i class="fa-solid fa-pen"></i> Edit
          </button>
        </div>
        <div class="sectionBody">
          <div class="miniRow">
            <div class="miniCard">
              <h4>{{ $bankName }} • {{ $bankMasked }}</h4>
              <p>Account holder: <b style="color:rgba(15,23,42,.92)">{{ $bankHolder }}</b></p>
              <p style="margin-top:8px;">Withdrawals will be sent to this account.</p>
            </div>

            <div class="miniCard">
              <h4>Quick rules</h4>
              <p>• Minimum withdrawal: <b style="color:rgba(15,23,42,.92)">{{ $fmt(50000) }}</b></p>
              <p>• Processing time: <b style="color:rgba(15,23,42,.92)">1–2 business days</b></p>
              <p>• Fee: <b style="color:rgba(15,23,42,.92)">Free</b> (promo)</p>
            </div>
          </div>
        </div>
      </div>

      {{-- Quick Actions --}}
      <div class="soft">
        <div class="sectionHead">
          <h3>Quick Actions</h3>
          <span class="pill"><i class="fa-solid fa-bolt"></i> Fast</span>
        </div>
        <div class="sectionBody" style="display:flex; gap:10px; flex-wrap:wrap;">
          <button class="btnPrimary" type="button" onclick="LB.open('withdrawModal')">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            Withdraw Funds
          </button>
          <button class="btnGhost" type="button">
            <i class="fa-solid fa-receipt"></i>
            Export Transactions
          </button>
        </div>
      </div>

    </div>

  </div>
</div>

{{-- ===================== MODAL: WITHDRAW ===================== --}}
<div class="ov" id="withdrawModal">
  <div class="modal">
    <div class="mHead">
      <h4>Withdraw Funds</h4>
      <button class="x" type="button" onclick="LB.close('withdrawModal')"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <div class="mBody">
      <div class="meta" style="margin-top:0">
        Available balance: <b style="color:rgba(15,23,42,.92)">{{ $fmt($balanceAvailable) }}</b> •
        Sent to: <b style="color:rgba(15,23,42,.92)">{{ $bankName }} {{ $bankMasked }}</b>
      </div>

      <div style="display:grid; gap:12px; margin-top:12px;">
        <div class="fg">
          <label>Amount</label>
          <input class="ctl" type="number" name="amount" placeholder="e.g. 100000" min="50000" max="{{ $balanceAvailable }}">
          <div class="meta" style="margin-top:6px;">Minimum {{ $fmt(50000) }}. Processing 1–2 business days.</div>
        </div>

        <div class="fg">
          <label>Note (optional)</label>
          <textarea class="ctl" placeholder="e.g. Weekly payout"></textarea>
        </div>
      </div>

      <div class="mActs">
        <button class="btnGhost" type="button" onclick="LB.close('withdrawModal')">Cancel</button>

        {{-- arahkan ke route withdraw kamu --}}
        <form action="{{ route('seller.payouts.withdraw') }}" method="POST" style="margin:0">
          @csrf
          <input type="hidden" name="amount" value="100000" id="withdrawAmountHidden">
          <button class="btnPrimary" type="submit">
            <i class="fa-solid fa-paper-plane"></i>
            Submit Withdrawal
          </button>
        </form>
      </div>

      <div class="meta" style="margin-top:10px;">
        By submitting, you confirm this payout will be sent to your personal account details.
      </div>
    </div>
  </div>
</div>

{{-- ===================== MODAL: BANK ACCOUNT ===================== --}}
<div class="ov" id="bankAccountModal">
  <div class="modal">
    <div class="mHead">
      <h4>Personal Account</h4>
      <button class="x" type="button" onclick="LB.close('bankAccountModal')"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <div class="mBody">
      <div class="meta" style="margin-top:0">
        Update your bank account for withdrawals.
      </div>

      <div style="display:grid; gap:12px; margin-top:12px;">
        <div class="fg">
          <label>Bank Name</label>
          <input class="ctl" type="text" placeholder="e.g. BCA" value="{{ $bankName }}">
        </div>

        <div class="fg">
          <label>Account Number</label>
          <input class="ctl" type="text" placeholder="e.g. 1029xxxxxx" value="{{ $bankMasked }}">
        </div>

        <div class="fg">
          <label>Account Holder</label>
          <input class="ctl" type="text" placeholder="Full name" value="{{ $bankHolder }}">
        </div>
      </div>

      <div class="mActs">
        <button class="btnGhost" type="button" onclick="LB.close('bankAccountModal')">Close</button>
        <button class="btnPrimary" type="button" onclick="LB.close('bankAccountModal')">
          <i class="fa-solid fa-floppy-disk"></i>
          Save Changes
        </button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  // Sinkronisasi input amount ke hidden input pada form withdraw (biar route kamu tetap kepakai)
  document.addEventListener('input', (e)=>{
    if(e.target && e.target.name === 'amount'){
      const hidden = document.getElementById('withdrawAmountHidden');
      if(hidden) hidden.value = e.target.value || '';
    }
  });
</script>
@endpush

@endsection
