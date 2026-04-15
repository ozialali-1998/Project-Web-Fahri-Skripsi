@extends('layouts.app')

@section('content')
<h1>Incoming Goods Transaction</h1>

<nav>
    <a href="{{ route('products.index') }}">Products</a> |
    <a href="{{ route('suppliers.index') }}">Suppliers</a> |
    <a href="{{ route('outgoing-goods.create') }}">Outgoing Goods</a>
</nav>

@if(session('status'))
    <p>{{ session('status') }}</p>
@endif

@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('incoming-goods.store') }}">
    @csrf
    <label>Reference Number
        <input type="text" name="reference_number" value="{{ old('reference_number') }}" required>
    </label><br>

    <label>Product
        <select name="product_id" required>
            <option value="">-- Select Product --</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}" @selected((string) old('product_id') === (string) $product->id)>
                    {{ $product->sku }} - {{ $product->name }}
                </option>
            @endforeach
        </select>
    </label><br>

    <label>Supplier
        <select name="supplier_id" required>
            <option value="">-- Select Supplier --</option>
            @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}" @selected((string) old('supplier_id') === (string) $supplier->id)>
                    {{ $supplier->supplier_code }} - {{ $supplier->name }}
                </option>
            @endforeach
        </select>
    </label><br>

    <label>Quantity
        <input type="number" name="quantity" min="1" value="{{ old('quantity', 1) }}" required>
    </label><br>

    <label>Unit Cost
        <input type="number" step="0.01" name="unit_cost" min="0" value="{{ old('unit_cost', 0) }}" required>
    </label><br>

    <label>Received At
        <input type="datetime-local" name="received_at" value="{{ old('received_at') }}" required>
    </label><br>

    <label>Batch Number
        <input type="text" name="batch_number" value="{{ old('batch_number') }}">
    </label><br>

    <label>Expired Date
        <input type="date" name="expired_date" value="{{ old('expired_date') }}">
    </label><br>

    <label>Notes
        <textarea name="notes">{{ old('notes') }}</textarea>
    </label><br>

    <button type="submit">Save Incoming Goods</button>
</form>

<h2>Recent Incoming Goods</h2>
<table border="1" cellpadding="8">
    <thead>
    <tr>
        <th>Reference</th>
        <th>Product ID</th>
        <th>Supplier ID</th>
        <th>Qty</th>
        <th>Unit Cost</th>
        <th>Total Cost</th>
    </tr>
    </thead>
    <tbody>
    @forelse($recentIncomingGoods as $item)
        <tr>
            <td>{{ $item->reference_number }}</td>
            <td>{{ $item->product_id }}</td>
            <td>{{ $item->supplier_id }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->unit_cost }}</td>
            <td>{{ $item->total_cost }}</td>
        </tr>
    @empty
        <tr><td colspan="6">No transactions yet.</td></tr>
    @endforelse
    </tbody>
</table>
@endsection
