<?php

namespace App\Http\Controllers;

use App\Models\OutgoingGoods;
use App\Models\Product;
use App\Services\Inventory\StockService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OutgoingGoodsController extends Controller
{
    public function __construct(private readonly StockService $stockService)
    {
    }

    public function create(): View
    {
        return view('outgoing-goods.create', [
            'products' => Product::query()->where('is_active', true)->orderBy('name')->get(),
            'recentOutgoingGoods' => OutgoingGoods::query()->latest()->limit(10)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'reference_number' => ['required', 'string', 'max:40', 'unique:outgoing_goods,reference_number'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'discount_type' => ['required', 'in:none,nominal,percentage'],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'sold_at' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        $product = Product::query()->findOrFail($validated['product_id']);
        $validated['unit_price'] = (float) $product->selling_price;
        $validated['subtotal'] = $validated['quantity'] * $validated['unit_price'];
        $validated['discount_amount'] = $validated['discount_type'] === 'percentage'
            ? ($validated['subtotal'] * $validated['discount_value']) / 100
            : $validated['discount_value'];
        $validated['total_price'] = max($validated['subtotal'] - $validated['discount_amount'], 0);

        $this->stockService->handleOutgoing($validated);

        return redirect()->route('outgoing-goods.create')->with('status', 'Outgoing goods recorded and stock updated.');
    }
}
