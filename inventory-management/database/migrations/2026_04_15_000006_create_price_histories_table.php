<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('price_histories', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('price_type', ['purchase', 'selling']);
            $table->decimal('old_price', 14, 2)->nullable();
            $table->decimal('new_price', 14, 2);
            $table->dateTime('effective_at');
            $table->string('reference_number', 40)->nullable();
            $table->string('changed_by', 100)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['product_id', 'price_type', 'effective_at'], 'price_history_lookup_idx');
            $table->index('effective_at', 'price_history_effective_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_histories');
    }
};
