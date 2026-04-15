@extends('layouts.app')

@section('content')
<h1>Product Detail</h1>
<a href="{{ route('products.index') }}">Back</a>

<ul>
    <li>SKU: {{ $product->sku }}</li>
    <li>Name: {{ $product->name }}</li>
    <li>Category: {{ $product->category }}</li>
    <li>Unit: {{ $product->unit }}</li>
    <li>Stock: {{ $product->stock }}</li>
    <li>Minimum Stock: {{ $product->minimum_stock }}</li>
    <li>Purchase Price: {{ $product->purchase_price }}</li>
    <li>Selling Price: {{ $product->selling_price }}</li>
    <li>Status: {{ $product->is_active ? 'Active' : 'Inactive' }}</li>
</ul>
@endsection
