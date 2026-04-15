<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OutgoingGoods extends Model
{
    use HasFactory;

    protected $table = 'outgoing_goods';

    protected $fillable = [
        'reference_number',
        'product_id',
        'quantity',
        'unit_price',
        'discount_type',
        'discount_value',
        'discount_amount',
        'subtotal',
        'total_price',
        'customer_name',
        'sold_at',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'total_price' => 'decimal:2',
        'sold_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function returns(): HasMany
    {
        return $this->hasMany(StockReturn::class, 'outgoing_good_id');
    }
}
