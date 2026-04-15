@extends('layouts.app')

@section('content')
<h1>Return Transaction</h1>

<nav>
    <a href="{{ route('products.index') }}">Products</a> |
    <a href="{{ route('incoming-goods.create') }}">Incoming Goods</a> |
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

<form method="POST" action="{{ route('returns.store') }}">
    @csrf

    <label>Product
        <select name="product_id" required>
            <option value="">-- Select Product --</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}" @selected((string) old('product_id') === (string) $product->id)>
                    {{ $product->sku }} - {{ $product->name }} (Stock: {{ $product->stock }})
                </option>
            @endforeach
        </select>
    </label><br>

    <label>Return Quantity
        <input type="number" name="quantity" min="1" value="{{ old('quantity', 1) }}" required>
    </label><br>

    <label>Note
        <textarea name="notes">{{ old('notes') }}</textarea>
    </label><br>

    <button type="submit">Save Return</button>
</form>

<h2>Recent Returns</h2>
<table border="1" cellpadding="8">
    <thead>
    <tr>
        <th>Return Number</th>
        <th>Product ID</th>
        <th>Quantity</th>
        <th>Note</th>
    </tr>
    </thead>
    <tbody>
    @forelse($recentReturns as $item)
        <tr>
            <td>{{ $item->return_number }}</td>
            <td>{{ $item->product_id }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->notes }}</td>
        </tr>
    @empty
        <tr><td colspan="4">No return transactions yet.</td></tr>
    @endforelse
    </tbody>
</table>
@endsection
