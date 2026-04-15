<?php

namespace App\Http\Controllers;

use App\Models\IncomingGoods;
use App\Models\Product;
use App\Models\Supplier;
use App\Services\Inventory\StockService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IncomingGoodsController extends Controller
{
    public function __construct(private readonly StockService $stockService)
    {
    }

    public function create(): View
    {
        return view('incoming-goods.create', [
            'products' => Product::query()->where('is_active', true)->orderBy('name')->get(),
            'suppliers' => Supplier::query()->where('is_active', true)->orderBy('name')->get(),
            'recentIncomingGoods' => IncomingGoods::query()->latest()->limit(10)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'reference_number' => ['required', 'string', 'max:40', 'unique:incoming_goods,reference_number'],
            'product_id' => ['required', 'exists:products,id'],
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_cost' => ['required', 'numeric', 'min:0'],
            'received_at' => ['required', 'date'],
            'batch_number' => ['nullable', 'string', 'max:80'],
            'expired_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['total_cost'] = $validated['quantity'] * $validated['unit_cost'];
        $this->stockService->handleIncoming($validated);

        return redirect()->route('incoming-goods.create')->with('status', 'Incoming goods recorded and stock updated.');
    }
}
