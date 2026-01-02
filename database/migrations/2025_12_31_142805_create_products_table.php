<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('seller_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('name');

            // ✅ slug per seller & global slug
            $table->string('slug');                 // unik per seller
            $table->string('global_slug')->unique(); // unik global (untuk URL umum)

            $table->unsignedBigInteger('price');
            $table->unsignedInteger('stock')->default(0);
            $table->text('description')->nullable();
            $table->string('thumbnail');
            $table->unsignedBigInteger('sale_price')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();

            // index
            $table->index(['seller_id', 'status']);
            $table->unique(['seller_id', 'slug']); // ✅ penting
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
