<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('processed_at')->nullable()->after('updated_at');
            $table->timestamp('shipped_at')->nullable()->after('processed_at');
            $table->timestamp('completed_at')->nullable()->after('shipped_at');
            $table->timestamp('paid_at')->nullable()->after('completed_at');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['processed_at','shipped_at','completed_at','paid_at']);
        });
    }
};
