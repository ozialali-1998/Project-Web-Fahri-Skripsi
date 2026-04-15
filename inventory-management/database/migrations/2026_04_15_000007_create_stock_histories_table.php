<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stock_histories', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->enum('change_type', ['in', 'out', 'return_in']);
            $table->string('reference_type', 50);
            $table->unsignedBigInteger('reference_id');
            $table->integer('quantity_change');
            $table->unsignedBigInteger('stock_before');
            $table->unsignedBigInteger('stock_after');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['product_id', 'created_at'], 'stock_histories_product_date_idx');
            $table->index(['reference_type', 'reference_id'], 'stock_histories_reference_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_histories');
    }
};
