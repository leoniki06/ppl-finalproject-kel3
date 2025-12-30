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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('stock');

            // Tambah kolom lain yang mungkin belum ada
            if (!Schema::hasColumn('products', 'discount_percent')) {
                $table->integer('discount_percent')->default(0)->after('original_price');
            }

            if (!Schema::hasColumn('products', 'brand')) {
                $table->string('brand', 100)->nullable()->after('category');
            }

            if (!Schema::hasColumn('products', 'image_url')) {
                $table->string('image_url')->nullable()->after('brand');
            }

            if (!Schema::hasColumn('products', 'is_flash_sale')) {
                $table->boolean('is_flash_sale')->default(false)->after('is_active');
            }

            if (!Schema::hasColumn('products', 'rating')) {
                $table->decimal('rating', 2, 1)->default(0)->after('is_flash_sale');
            }

            if (!Schema::hasColumn('products', 'rating_count')) {
                $table->integer('rating_count')->default(0)->after('rating');
            }

            if (!Schema::hasColumn('products', 'expiry_date')) {
                $table->date('expiry_date')->nullable()->after('rating_count');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Hapus kolom jika ingin rollback
            $table->dropColumn([
                'is_active',
                'discount_percent',
                'brand',
                'image_url',
                'is_flash_sale',
                'rating',
                'rating_count',
                'expiry_date'
            ]);
        });
    }
};
