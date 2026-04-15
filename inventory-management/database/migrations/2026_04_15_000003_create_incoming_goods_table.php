<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('incoming_goods', function (Blueprint $table): void {
            $table->id();
            $table->string('reference_number', 40)->unique();
            $table->foreignId('product_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('supplier_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedInteger('quantity');
            $table->decimal('unit_cost', 14, 2);
            $table->decimal('total_cost', 14, 2);
            $table->dateTime('received_at');
            $table->string('batch_number', 80)->nullable();
            $table->date('expired_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['product_id', 'received_at'], 'incoming_goods_product_date_idx');
            $table->index(['supplier_id', 'received_at'], 'incoming_goods_supplier_date_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incoming_goods');
    }
};
