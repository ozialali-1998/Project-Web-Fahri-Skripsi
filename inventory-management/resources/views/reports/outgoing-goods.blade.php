@extends('layouts.app')

@section('content')
<h1>Outgoing Goods History</h1>

<nav>
    <a href="{{ route('reports.stock') }}">Stock Report</a> |
    <a href="{{ route('reports.incoming-goods') }}">Incoming Goods History</a>
</nav>

@include('reports.partials-filter', ['action' => route('reports.outgoing-goods')])

<table border="1" cellpadding="8">
    <thead>
    <tr>
        <th>Date</th>
        <th>Reference</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Discount</th>
        <th>Total Price</th>
    </tr>
    </thead>
    <tbody>
    @forelse($outgoingGoods as $item)
        <tr>
            <td>{{ $item->sold_at }}</td>
            <td>{{ $item->reference_number }}</td>
            <td>{{ $item->product?->sku }} - {{ $item->product?->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->discount_amount }}</td>
            <td>{{ $item->total_price }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="6">No outgoing goods records found.</td>
        </tr>
    @endforelse
    </tbody>
</table>

{{ $outgoingGoods->links() }}
@endsection
