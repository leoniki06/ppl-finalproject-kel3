<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seller_finance_accounts', function (Blueprint $table) {
            $table->id();

            // relasi user seller
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // rekening pribadi
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_holder')->nullable();

            // snapshot saldo (opsional, bisa juga dihitung dari ledger)
            $table->bigInteger('available_balance')->default(0); // siap tarik
            $table->bigInteger('pending_balance')->default(0);   // menunggu settle

            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_finance_accounts');
    }
};
