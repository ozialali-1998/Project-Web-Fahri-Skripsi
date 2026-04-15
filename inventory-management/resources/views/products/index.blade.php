@extends('layouts.app')

@section('content')
<h1>Products</h1>

@if(session('status'))
    <p>{{ session('status') }}</p>
@endif

<nav>
    <a href="{{ route('products.create') }}">Add Product</a> |
    <a href="{{ route('suppliers.index') }}">Manage Suppliers</a>
</nav>

<table border="1" cellpadding="8">
    <thead>
    <tr>
        <th>SKU</th>
        <th>Name</th>
        <th>Category</th>
        <th>Stock</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @forelse($products as $product)
        <tr>
            <td>{{ $product->sku }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->is_active ? 'Active' : 'Inactive' }}</td>
            <td>
                <a href="{{ route('products.show', $product) }}">View</a>
                <a href="{{ route('products.edit', $product) }}">Edit</a>
                <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this product?')">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6">No products found.</td>
        </tr>
    @endforelse
    </tbody>
</table>

{{ $products->links() }}
@endsection
