<?php

namespace App\Http\Controllers;

use App\Models\IncomingGoods;
use App\Models\OutgoingGoods;
use App\Models\Product;
use App\Models\StockReturn;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $recentTransactions = $this->recentTransactions();

        return view('dashboard.index', [
            'totalProducts' => Product::count(),
            'totalStock' => Product::sum('stock'),
            'recentTransactions' => $recentTransactions,
        ]);
    }

    private function recentTransactions(): Collection
    {
        $incoming = IncomingGoods::query()
            ->latest('received_at')
            ->limit(5)
            ->get()
            ->map(fn (IncomingGoods $item) => [
                'type' => 'Incoming',
                'reference' => $item->reference_number,
                'quantity' => '+' . $item->quantity,
                'date' => $item->received_at,
            ]);

        $outgoing = OutgoingGoods::query()
            ->latest('sold_at')
            ->limit(5)
            ->get()
            ->map(fn (OutgoingGoods $item) => [
                'type' => 'Outgoing',
                'reference' => $item->reference_number,
                'quantity' => '-' . $item->quantity,
                'date' => $item->sold_at,
            ]);

        $returns = StockReturn::query()
            ->latest('returned_at')
            ->limit(5)
            ->get()
            ->map(fn (StockReturn $item) => [
                'type' => 'Return',
                'reference' => $item->return_number,
                'quantity' => '+' . $item->quantity,
                'date' => $item->returned_at,
            ]);

        return collect()
            ->merge($incoming)
            ->merge($outgoing)
            ->merge($returns)
            ->sortByDesc('date')
            ->take(10)
            ->values();
    }
}
