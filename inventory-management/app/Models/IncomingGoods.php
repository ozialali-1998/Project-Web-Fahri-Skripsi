<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IncomingGoods extends Model
{
    use HasFactory;

    protected $table = 'incoming_goods';

    protected $fillable = [
        'reference_number',
        'product_id',
        'supplier_id',
        'quantity',
        'unit_cost',
        'total_cost',
        'received_at',
        'batch_number',
        'expired_date',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'received_at' => 'datetime',
        'expired_date' => 'date',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function returns(): HasMany
    {
        return $this->hasMany(StockReturn::class, 'incoming_good_id');
    }
}
