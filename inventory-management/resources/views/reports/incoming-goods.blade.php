@extends('layouts.app')

@section('content')
<h1>Incoming Goods History</h1>

<nav>
    <a href="{{ route('reports.stock') }}">Stock Report</a> |
    <a href="{{ route('reports.outgoing-goods') }}">Outgoing Goods History</a>
</nav>

@include('reports.partials-filter', ['action' => route('reports.incoming-goods')])

<table border="1" cellpadding="8">
    <thead>
    <tr>
        <th>Date</th>
        <th>Reference</th>
        <th>Product</th>
        <th>Supplier</th>
        <th>Quantity</th>
        <th>Unit Cost</th>
        <th>Total Cost</th>
    </tr>
    </thead>
    <tbody>
    @forelse($incomingGoods as $item)
        <tr>
            <td>{{ $item->received_at }}</td>
            <td>{{ $item->reference_number }}</td>
            <td>{{ $item->product?->sku }} - {{ $item->product?->name }}</td>
            <td>{{ $item->supplier?->supplier_code }} - {{ $item->supplier?->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->unit_cost }}</td>
            <td>{{ $item->total_cost }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="7">No incoming goods records found.</td>
        </tr>
    @endforelse
    </tbody>
</table>

{{ $incomingGoods->links() }}
@endsection
