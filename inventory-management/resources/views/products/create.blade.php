@extends('layouts.app')

@section('content')
<h1>Create Product</h1>
<a href="{{ route('products.index') }}">Back</a>

@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('products.store') }}">
    @csrf
    @include('products.partials.form', ['product' => null])
    <button type="submit">Save</button>
</form>
@endsection
