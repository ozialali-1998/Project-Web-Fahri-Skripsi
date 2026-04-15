<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('returns', function (Blueprint $table): void {
            $table->id();
            $table->string('return_number', 40)->unique();
            $table->enum('return_type', ['sales_return', 'purchase_return']);
            $table->foreignId('product_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('outgoing_good_id')->nullable()->constrained('outgoing_goods')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('incoming_good_id')->nullable()->constrained('incoming_goods')->cascadeOnUpdate()->nullOnDelete();
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 14, 2)->default(0);
            $table->decimal('total_amount', 14, 2)->default(0);
            $table->dateTime('returned_at');
            $table->string('reason', 255)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['product_id', 'returned_at'], 'returns_product_date_idx');
            $table->index('return_type', 'returns_type_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
