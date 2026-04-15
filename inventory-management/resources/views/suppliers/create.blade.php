@extends('layouts.app')

@section('content')
<h1>Create Supplier</h1>
<a href="{{ route('suppliers.index') }}">Back</a>

@if($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('suppliers.store') }}">
    @csrf
    @include('suppliers.partials.form', ['supplier' => null])
    <button type="submit">Save</button>
</form>
@endsection
