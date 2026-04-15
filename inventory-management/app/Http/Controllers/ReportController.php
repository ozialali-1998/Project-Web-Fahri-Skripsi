<?php

namespace App\Http\Controllers;

use App\Models\IncomingGoods;
use App\Models\OutgoingGoods;
use App\Models\Product;
use App\Models\StockHistory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function stock(Request $request): View
    {
        [$dateFrom, $dateTo] = $this->dateRange($request);

        $stockChanges = StockHistory::query()
            ->selectRaw('product_id, SUM(quantity_change) as net_change, MAX(created_at) as last_movement_at')
            ->when($dateFrom, fn (Builder $query) => $query->whereDate('created_at', '>=', $dateFrom))
            ->when($dateTo, fn (Builder $query) => $query->whereDate('created_at', '<=', $dateTo))
            ->groupBy('product_id')
            ->pluck('net_change', 'product_id');

        $products = Product::query()->orderBy('name')->get()->map(function (Product $product) use ($stockChanges) {
            $product->net_change = (int) ($stockChanges[$product->id] ?? 0);
            return $product;
        });

        return view('reports.stock', [
            'products' => $products,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }

    public function incomingGoods(Request $request): View
    {
        [$dateFrom, $dateTo] = $this->dateRange($request);

        $incomingGoods = IncomingGoods::query()
            ->with(['product:id,sku,name', 'supplier:id,supplier_code,name'])
            ->when($dateFrom, fn (Builder $query) => $query->whereDate('received_at', '>=', $dateFrom))
            ->when($dateTo, fn (Builder $query) => $query->whereDate('received_at', '<=', $dateTo))
            ->orderByDesc('received_at')
            ->paginate(20)
            ->withQueryString();

        return view('reports.incoming-goods', [
            'incomingGoods' => $incomingGoods,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }

    public function outgoingGoods(Request $request): View
    {
        [$dateFrom, $dateTo] = $this->dateRange($request);

        $outgoingGoods = OutgoingGoods::query()
            ->with('product:id,sku,name')
            ->when($dateFrom, fn (Builder $query) => $query->whereDate('sold_at', '>=', $dateFrom))
            ->when($dateTo, fn (Builder $query) => $query->whereDate('sold_at', '<=', $dateTo))
            ->orderByDesc('sold_at')
            ->paginate(20)
            ->withQueryString();

        return view('reports.outgoing-goods', [
            'outgoingGoods' => $outgoingGoods,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }

    private function dateRange(Request $request): array
    {
        $validated = $request->validate([
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date'],
        ]);

        $dateFrom = !empty($validated['date_from']) ? Carbon::parse($validated['date_from'])->toDateString() : null;
        $dateTo = !empty($validated['date_to']) ? Carbon::parse($validated['date_to'])->toDateString() : null;

        return [$dateFrom, $dateTo];
    }
}
