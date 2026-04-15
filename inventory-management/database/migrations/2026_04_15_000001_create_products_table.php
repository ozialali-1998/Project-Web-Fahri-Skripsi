<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table): void {
            $table->id();
            $table->string('sku', 64)->unique();
            $table->string('name');
            $table->string('category', 100)->nullable();
            $table->string('unit', 20)->default('pcs');
            $table->text('description')->nullable();
            $table->decimal('purchase_price', 14, 2)->default(0);
            $table->decimal('selling_price', 14, 2)->default(0);
            $table->unsignedBigInteger('stock')->default(0);
            $table->unsignedInteger('minimum_stock')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['name', 'category'], 'products_name_category_idx');
            $table->index('is_active', 'products_active_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
