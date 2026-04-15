@extends('layouts.app')

@section('content')
<form method="POST" action="{{ url('/login') }}">
    @csrf
    <h1>Login</h1>
    <label>Email <input type="email" name="email" required></label>
    <label>Password <input type="password" name="password" required></label>
    <button type="submit">Sign in</button>
</form>
@endsection
