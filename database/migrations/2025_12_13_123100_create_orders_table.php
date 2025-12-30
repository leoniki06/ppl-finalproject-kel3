<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_amount', 12, 2);
            $table->string('status')->default('pending'); // pending, processing, completed, cancelled
            $table->text('shipping_address');
            $table->string('payment_method')->default('cash'); // cash, credit_card, transfer
            $table->string('payment_status')->default('unpaid'); // unpaid, paid, refunded
            $table->timestamps();

            $table->index('order_number');
            $table->index('user_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
