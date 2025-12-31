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
         Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('buyer_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('order_code')->unique();
            $table->unsignedBigInteger('total_amount');
            $table->unsignedBigInteger('discount_amount')->nullable();
            $table->foreignUuid('voucher_id')->nullable()
                ->constrained('vouchers')
                ->nullOnDelete();
            $table->enum('status', [
                'pending_payment', 'paid', 'shipped', 'completed', 'canceled', 'expired'
            ])->default('pending_payment');
            $table->text('address');
            $table->string('phone', 30);
            $table->text('note')->nullable();
            $table->timestamps();
            $table->index(['buyer_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
