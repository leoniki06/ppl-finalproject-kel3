// database/migrations/[timestamp]_create_products_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand'); // Nama resto/penjual
            $table->text('description');
            $table->string('image_url');
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2);
            $table->string('category'); // bakery, dairy, fruits, meat
            $table->float('rating')->default(4.5);
            $table->integer('rating_count')->default(0);
            $table->integer('discount_percent')->default(0);
            $table->date('expiry_date'); // Tanggal kadaluarsa
            $table->integer('stock')->default(0);
            $table->boolean('is_flash_sale')->default(false);
            $table->boolean('is_recommended')->default(false);
            $table->foreignId('seller_id')->constrained('users'); // Hanya user dengan role penjual
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
