@extends('layouts.app')

@section('content')
<h1>Suppliers</h1>

@if(session('status'))
    <p>{{ session('status') }}</p>
@endif

<nav>
    <a href="{{ route('suppliers.create') }}">Add Supplier</a> |
    <a href="{{ route('products.index') }}">Manage Products</a>
</nav>

<table border="1" cellpadding="8">
    <thead>
    <tr>
        <th>Code</th>
        <th>Name</th>
        <th>Phone</th>
        <th>City</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @forelse($suppliers as $supplier)
        <tr>
            <td>{{ $supplier->supplier_code }}</td>
            <td>{{ $supplier->name }}</td>
            <td>{{ $supplier->phone }}</td>
            <td>{{ $supplier->city }}</td>
            <td>{{ $supplier->is_active ? 'Active' : 'Inactive' }}</td>
            <td>
                <a href="{{ route('suppliers.show', $supplier) }}">View</a>
                <a href="{{ route('suppliers.edit', $supplier) }}">Edit</a>
                <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this supplier?')">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6">No suppliers found.</td>
        </tr>
    @endforelse
    </tbody>
</table>

{{ $suppliers->links() }}
@endsection
