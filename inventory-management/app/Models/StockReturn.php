<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockReturn extends Model
{
    use HasFactory;

    protected $table = 'returns';

    protected $fillable = [
        'return_number',
        'return_type',
        'product_id',
        'outgoing_good_id',
        'incoming_good_id',
        'quantity',
        'unit_price',
        'total_amount',
        'returned_at',
        'reason',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'returned_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function outgoingGoods(): BelongsTo
    {
        return $this->belongsTo(OutgoingGoods::class, 'outgoing_good_id');
    }

    public function incomingGoods(): BelongsTo
    {
        return $this->belongsTo(IncomingGoods::class, 'incoming_good_id');
    }
}
