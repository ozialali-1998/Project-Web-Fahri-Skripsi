@extends('layouts.app')

@section('content')
<h1>Edit Supplier</h1>
<a href="{{ route('suppliers.index') }}">Back</a>

@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('suppliers.update', $supplier) }}">
    @csrf
    @method('PUT')
    @include('suppliers.partials.form', ['supplier' => $supplier])
    <button type="submit">Update</button>
</form>
@endsection
