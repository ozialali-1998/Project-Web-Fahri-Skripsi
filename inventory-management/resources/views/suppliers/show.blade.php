@extends('layouts.app')

@section('content')
<h1>Supplier Detail</h1>
<a href="{{ route('suppliers.index') }}">Back</a>

<ul>
    <li>Code: {{ $supplier->supplier_code }}</li>
    <li>Name: {{ $supplier->name }}</li>
    <li>Phone: {{ $supplier->phone }}</li>
    <li>Email: {{ $supplier->email }}</li>
    <li>City: {{ $supplier->city }}</li>
    <li>Contact Person: {{ $supplier->contact_person }}</li>
    <li>Status: {{ $supplier->is_active ? 'Active' : 'Inactive' }}</li>
</ul>
@endsection
