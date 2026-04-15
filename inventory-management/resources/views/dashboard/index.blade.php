@extends('layouts.app')

@section('content')
<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }
    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 16px;
        background: #fafafa;
    }
    .card h2 {
        margin: 0 0 8px;
        font-size: 1rem;
    }
    .card .metric {
        font-size: 1.7rem;
        font-weight: 700;
    }
    .dashboard-nav {
        margin-bottom: 16px;
    }
</style>

<h1>Admin Dashboard</h1>

<div class="dashboard-nav">
    <a href="{{ route('products.index') }}">Products</a> |
    <a href="{{ route('suppliers.index') }}">Suppliers</a> |
    <a href="{{ route('incoming-goods.create') }}">Incoming Goods</a> |
    <a href="{{ route('outgoing-goods.create') }}">Outgoing Goods</a> |
    <a href="{{ route('returns.create') }}">Returns</a> |
    <a href="{{ route('reports.stock') }}">Reports</a>
</div>

<div class="dashboard-grid">
    <div class="card">
        <h2>Total Products</h2>
        <div class="metric">{{ $totalProducts }}</div>
    </div>

    <div class="card">
        <h2>Total Stock</h2>
        <div class="metric">{{ $totalStock }}</div>
    </div>
</div>

<div class="card">
    <h2>Recent Transactions</h2>

    <table border="1" cellpadding="8" width="100%">
        <thead>
        <tr>
            <th>Type</th>
            <th>Reference</th>
            <th>Quantity</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @forelse($recentTransactions as $transaction)
            <tr>
                <td>{{ $transaction['type'] }}</td>
                <td>{{ $transaction['reference'] }}</td>
                <td>{{ $transaction['quantity'] }}</td>
                <td>{{ $transaction['date'] }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No transaction data available.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
