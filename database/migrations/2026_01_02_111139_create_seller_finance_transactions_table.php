<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seller_finance_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('finance_account_id')
                  ->constrained('seller_finance_accounts')
                  ->cascadeOnDelete();

            // tipe transaksi: sale, payout, paylater, adjustment, refund
            $table->enum('type', ['sale', 'payout', 'paylater', 'adjustment', 'refund'])->index();

            $table->string('reference')->index(); // ORD-xxx / WD-xxx / PL-xxx
            $table->bigInteger('amount');         // nominal
            $table->enum('direction', ['in', 'out'])->index(); // in = masuk, out = keluar

            $table->enum('status', ['pending', 'success', 'failed'])->default('success');

            // optional relations ke order / payout
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('payout_id')->nullable();

            $table->text('description')->nullable();
            $table->timestamp('transacted_at')->nullable(); // waktu transaksi

            $table->timestamps();

            $table->index(['user_id', 'type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_finance_transactions');
    }
};
