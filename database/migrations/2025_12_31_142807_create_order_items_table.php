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
        Schema::create('order_items', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->foreignUuid('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            // ✅ supaya produk bisa dihapus tapi order_items tetap ada
            $table->uuid('product_id')->nullable();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->nullOnDelete();

            $table->foreignUuid('seller_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->unsignedInteger('qty');
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('subtotal');

            $table->timestamps();

            $table->index('order_id');
            $table->index('seller_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
