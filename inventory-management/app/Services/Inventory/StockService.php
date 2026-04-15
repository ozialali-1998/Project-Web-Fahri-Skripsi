<?php

namespace App\Services\Inventory;

use App\Models\IncomingGoods;
use App\Models\OutgoingGoods;
use App\Models\Product;
use App\Models\StockHistory;
use App\Models\StockReturn;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockService
{
    public function handleIncoming(array $data): IncomingGoods
    {
        return DB::transaction(function () use ($data): IncomingGoods {
            $product = Product::query()->lockForUpdate()->findOrFail($data['product_id']);
            $incoming = IncomingGoods::query()->create($data);

            $before = (int) $product->stock;
            $after = $before + (int) $data['quantity'];
            $product->update(['stock' => $after]);

            $this->writeHistory($product->id, 'in', 'incoming_goods', $incoming->id, (int) $data['quantity'], $before, $after, $data['notes'] ?? null);

            return $incoming;
        });
    }

    public function handleOutgoing(array $data): OutgoingGoods
    {
        return DB::transaction(function () use ($data): OutgoingGoods {
            $product = Product::query()->lockForUpdate()->findOrFail($data['product_id']);

            if ($product->stock < $data['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => 'Stock is not enough for this transaction.',
                ]);
            }

            $outgoing = OutgoingGoods::query()->create($data);

            $before = (int) $product->stock;
            $after = $before - (int) $data['quantity'];
            $product->update(['stock' => $after]);

            $this->writeHistory($product->id, 'out', 'outgoing_goods', $outgoing->id, -(int) $data['quantity'], $before, $after, $data['notes'] ?? null);

            return $outgoing;
        });
    }

    public function handleReturn(array $data): StockReturn
    {
        return DB::transaction(function () use ($data): StockReturn {
            $product = Product::query()->lockForUpdate()->findOrFail($data['product_id']);
            $return = StockReturn::query()->create($data);

            $before = (int) $product->stock;
            $after = $before + (int) $data['quantity'];
            $product->update(['stock' => $after]);

            $this->writeHistory($product->id, 'return_in', 'returns', $return->id, (int) $data['quantity'], $before, $after, $data['notes'] ?? null);

            return $return;
        });
    }

    private function writeHistory(
        int $productId,
        string $changeType,
        string $referenceType,
        int $referenceId,
        int $quantityChange,
        int $stockBefore,
        int $stockAfter,
        ?string $notes
    ): void {
        StockHistory::query()->create([
            'product_id' => $productId,
            'change_type' => $changeType,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'quantity_change' => $quantityChange,
            'stock_before' => $stockBefore,
            'stock_after' => $stockAfter,
            'notes' => $notes,
        ]);
    }
}
