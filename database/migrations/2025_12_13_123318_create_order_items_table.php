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
        // PERBAIKAN: Cek dulu apakah tabel sudah ada
        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
                $table->integer('quantity');
                $table->decimal('price', 10, 2);
                $table->json('attributes')->nullable();
                $table->timestamps();

                $table->index('order_id');
                $table->index('product_id');

                // PERBAIKAN: Pastikan foreign key constraint dengan nama tabel yang benar
                // $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
                // $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            });

            echo "Tabel 'order_items' berhasil dibuat.\n";
        } else {
            echo "Tabel 'order_items' sudah ada. Migration dilewati.\n";
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
