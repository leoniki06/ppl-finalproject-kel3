<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seller_payouts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('finance_account_id')
                  ->constrained('seller_finance_accounts')
                  ->cascadeOnDelete();

            $table->string('reference')->unique(); // WD-xxxx
            $table->bigInteger('amount');

            // status withdraw
            $table->enum('status', ['pending', 'processing', 'success', 'failed'])->default('pending');

            // tujuan transfer (snapshot)
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_holder')->nullable();

            // catatan & admin response
            $table->text('note')->nullable();
            $table->text('admin_note')->nullable();

            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_payouts');
    }
};
