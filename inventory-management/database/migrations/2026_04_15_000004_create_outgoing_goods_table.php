<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('outgoing_goods', function (Blueprint $table): void {
            $table->id();
            $table->string('reference_number', 40)->unique();
            $table->foreignId('product_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 14, 2);
            $table->enum('discount_type', ['none', 'nominal', 'percentage'])->default('none');
            $table->decimal('discount_value', 14, 2)->default(0);
            $table->decimal('discount_amount', 14, 2)->default(0);
            $table->decimal('subtotal', 14, 2);
            $table->decimal('total_price', 14, 2);
            $table->string('customer_name')->nullable();
            $table->dateTime('sold_at');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['product_id', 'sold_at'], 'outgoing_goods_product_date_idx');
            $table->index('sold_at', 'outgoing_goods_sold_at_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outgoing_goods');
    }
};
