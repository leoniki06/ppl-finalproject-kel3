<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seller_paylater_bills', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('paylater_account_id')
                  ->constrained('seller_paylater_accounts')
                  ->cascadeOnDelete();

            $table->string('reference')->unique(); // PLB-xxx
            $table->bigInteger('amount');
            $table->date('due_date');

            $table->enum('status', ['unpaid', 'paid', 'overdue'])->default('unpaid');
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status', 'due_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_paylater_bills');
    }
};
