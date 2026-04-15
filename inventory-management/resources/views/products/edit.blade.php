@extends('layouts.app')

@section('content')
<h1>Edit Product</h1>
<a href="{{ route('products.index') }}">Back</a>

@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('products.update', $product) }}">
    @csrf
    @method('PUT')
    @include('products.partials.form', ['product' => $product])
    <button type="submit">Update</button>
</form>
@endsection
