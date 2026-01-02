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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('owner_type', ['platform', 'seller'])->default('platform');
            $table->foreignUuid('seller_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('code')->unique();
            $table->enum('discount_type', ['percentage', 'fixed']);
            $table->unsignedBigInteger('discount_value');
            $table->unsignedInteger('max_usage')->default(0);
            $table->unsignedInteger('used_count')->default(0);
            $table->unsignedInteger('max_usage_per_user')->nullable();
            $table->unsignedBigInteger('min_purchase')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('applies_to', ['all', 'selected'])->default('all');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->index(['owner_type', 'seller_id']);
            $table->index(['status', 'start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
