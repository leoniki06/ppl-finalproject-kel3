<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2)->default(0);
            $table->json('attributes')->nullable(); // Untuk warna, ukuran, dll
            $table->timestamps();

            // Composite unique constraint untuk mencegah duplikasi
            $table->unique(['user_id', 'product_id']);

            // Index untuk performa query
            $table->index('user_id');
            $table->index('product_id');
        });

        // Jika ingin membuat cart untuk guest users juga
        Schema::create('cart_sessions', function (Blueprint $table) {
            $table->string('session_id', 191)->primary();
            $table->json('cart_data');
            $table->timestamp('last_activity')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_sessions');
        Schema::dropIfExists('carts');
    }
};
