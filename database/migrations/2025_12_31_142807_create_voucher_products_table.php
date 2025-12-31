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
        Schema::create('voucher_products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('voucher_id')
                ->constrained('vouchers')
                ->cascadeOnDelete();
            $table->foreignUuid('product_id')
                ->constrained('products')
                ->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['voucher_id', 'product_id']);
            $table->index(['voucher_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_products');
    }
};
