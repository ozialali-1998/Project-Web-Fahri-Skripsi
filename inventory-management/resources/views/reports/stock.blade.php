@extends('layouts.app')

@section('content')
<h1>Stock Report</h1>

<nav>
    <a href="{{ route('reports.incoming-goods') }}">Incoming Goods History</a> |
    <a href="{{ route('reports.outgoing-goods') }}">Outgoing Goods History</a>
</nav>

@include('reports.partials-filter', ['action' => route('reports.stock')])

<table border="1" cellpadding="8">
    <thead>
    <tr>
        <th>SKU</th>
        <th>Product Name</th>
        <th>Current Stock</th>
        <th>Net Change (Range)</th>
        <th>Minimum Stock</th>
    </tr>
    </thead>
    <tbody>
    @forelse($products as $product)
        <tr>
            <td>{{ $product->sku }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->net_change }}</td>
            <td>{{ $product->minimum_stock }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5">No stock records found.</td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection
