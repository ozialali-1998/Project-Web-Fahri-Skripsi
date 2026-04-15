<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncomingGoodsController;
use App\Http\Controllers\OutgoingGoodsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockReturnController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware('auth')->group(function (): void {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::resource('suppliers', SupplierController::class);

    Route::get('incoming-goods/create', [IncomingGoodsController::class, 'create'])->name('incoming-goods.create');
    Route::post('incoming-goods', [IncomingGoodsController::class, 'store'])->name('incoming-goods.store');

    Route::get('outgoing-goods/create', [OutgoingGoodsController::class, 'create'])->name('outgoing-goods.create');
    Route::post('outgoing-goods', [OutgoingGoodsController::class, 'store'])->name('outgoing-goods.store');

    Route::get('returns/create', [StockReturnController::class, 'create'])->name('returns.create');
    Route::post('returns', [StockReturnController::class, 'store'])->name('returns.store');

    Route::get('reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
    Route::get('reports/incoming-goods', [ReportController::class, 'incomingGoods'])->name('reports.incoming-goods');
    Route::get('reports/outgoing-goods', [ReportController::class, 'outgoingGoods'])->name('reports.outgoing-goods');
});
