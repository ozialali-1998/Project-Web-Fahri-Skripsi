<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockReturn;
use App\Services\Inventory\StockService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StockReturnController extends Controller
{
    public function __construct(private readonly StockService $stockService)
    {
    }

    public function create(): View
    {
        return view('returns.create', [
            'products' => Product::query()->where('is_active', true)->orderBy('name')->get(),
            'recentReturns' => StockReturn::query()->latest()->limit(10)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string'],
        ]);

        $payload = [
            'return_number' => 'RET-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4)),
            'return_type' => 'sales_return',
            'product_id' => $validated['product_id'],
            'outgoing_good_id' => null,
            'incoming_good_id' => null,
            'quantity' => $validated['quantity'],
            'unit_price' => 0,
            'total_amount' => 0,
            'returned_at' => now(),
            'reason' => 'Manual stock return',
            'notes' => $validated['notes'] ?? null,
        ];

        $this->stockService->handleReturn($payload);

        return redirect()->route('returns.create')->with('status', 'Return saved and stock increased automatically.');
    }
}
