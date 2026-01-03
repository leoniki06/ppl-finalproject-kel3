<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SellerFinanceAccount;
use App\Models\SellerFinanceTransaction;
use App\Models\SellerPaylaterAccount;
use App\Models\SellerPayout;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SellerPayoutController extends Controller
{
    public function index()
    {
        $sellerId = auth()->id();

        // 1) Ensure finance account exists
        $account = SellerFinanceAccount::firstOrCreate(
            ['user_id' => $sellerId],
            ['available_balance' => 0, 'pending_balance' => 0, 'is_active' => true]
        );

        // 2) Ensure paylater account exists
        $paylater = SellerPaylaterAccount::firstOrCreate(
            ['user_id' => $sellerId],
            ['limit_amount' => 0, 'used_amount' => 0, 'status' => 'inactive']
        );

        // 3) Sync orders -> finance ledger (sale)
        $paidOrders = Order::where('seller_id', $sellerId)
            ->where('payment_status', 'paid')
            ->get();

        foreach ($paidOrders as $o) {
            $exists = SellerFinanceTransaction::where('finance_account_id', $account->id)
                ->where('type', 'sale')
                ->where('reference', $o->order_number)
                ->exists();

            if (!$exists) {
                SellerFinanceTransaction::create([
                    'user_id' => $sellerId,
                    'finance_account_id' => $account->id,
                    'type' => 'sale',
                    'reference' => $o->order_number,
                    'amount' => (int) $o->total_amount,
                    'direction' => 'in',
                    'status' => $o->status === 'completed' ? 'success' : 'pending',
                    'order_id' => $o->id,
                    'description' => 'Sale transaction from order',
                    'transacted_at' => $o->created_at,
                ]);
            }
        }

        // 4) Calculate balances from ledger
        $availableIn = SellerFinanceTransaction::where('finance_account_id', $account->id)
            ->where('type', 'sale')
            ->where('status', 'success')
            ->where('direction', 'in')
            ->sum('amount');

        $pendingIn = SellerFinanceTransaction::where('finance_account_id', $account->id)
            ->where('type', 'sale')
            ->where('status', 'pending')
            ->where('direction', 'in')
            ->sum('amount');

        $payoutOutSuccess = SellerFinanceTransaction::where('finance_account_id', $account->id)
            ->where('type', 'payout')
            ->where('status', 'success')
            ->where('direction', 'out')
            ->sum('amount');

        $balanceAvailable = max($availableIn - $payoutOutSuccess, 0);
        $balancePending = (int) $pendingIn;

        // 5) Update snapshot (optional)
        $account->update([
            'available_balance' => $balanceAvailable,
            'pending_balance' => $balancePending,
        ]);

        // 6) Transaction history
        $transactions = SellerFinanceTransaction::where('finance_account_id', $account->id)
            ->orderByDesc('transacted_at')
            ->limit(20)
            ->get();

        return view('seller.payouts.index', [
            'account' => $account,
            'paylater' => $paylater,
            'balanceAvailable' => $balanceAvailable,
            'balancePending' => $balancePending,
            'transactions' => $transactions,
        ]);
    }

    public function withdraw(Request $request)
    {
        $sellerId = auth()->id();

        $request->validate([
            'amount' => 'required|numeric|min:50000',
        ]);

        $account = SellerFinanceAccount::where('user_id', $sellerId)->firstOrFail();

        // Recalculate available (avoid trusting UI)
        $availableIn = SellerFinanceTransaction::where('finance_account_id', $account->id)
            ->where('type', 'sale')->where('status', 'success')->where('direction', 'in')
            ->sum('amount');

        $payoutOutSuccess = SellerFinanceTransaction::where('finance_account_id', $account->id)
            ->where('type', 'payout')->where('status', 'success')->where('direction', 'out')
            ->sum('amount');

        $balanceAvailable = max($availableIn - $payoutOutSuccess, 0);

        if ((int)$request->amount > $balanceAvailable) {
            return back()->with('error', 'Saldo tidak cukup untuk withdraw.');
        }

        // Create payout
        $reference = 'WD-' . now()->format('ymd') . '-' . strtoupper(Str::random(6));

        $payout = SellerPayout::create([
            'user_id' => $sellerId,
            'finance_account_id' => $account->id,
            'reference' => $reference,
            'amount' => (int) $request->amount,
            'status' => 'pending',
            'bank_name' => $account->bank_name,
            'account_number' => $account->account_number,
            'account_holder' => $account->account_holder,
            'note' => $request->input('note'),
        ]);

        // Create ledger transaction (payout out)
        SellerFinanceTransaction::create([
            'user_id' => $sellerId,
            'finance_account_id' => $account->id,
            'type' => 'payout',
            'reference' => $reference,
            'amount' => (int) $request->amount,
            'direction' => 'out',
            'status' => 'pending',
            'payout_id' => $payout->id,
            'description' => 'Withdrawal request',
            'transacted_at' => now(),
        ]);

        return back()->with('success', 'Permintaan withdraw berhasil dikirim.');
    }
}
