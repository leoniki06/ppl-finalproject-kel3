<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seller_paylater_accounts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->bigInteger('limit_amount')->default(0);
            $table->bigInteger('used_amount')->default(0);

            $table->enum('status', ['inactive', 'active', 'blocked'])->default('inactive');
            $table->timestamp('activated_at')->nullable();

            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_paylater_accounts');
    }
};
