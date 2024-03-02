@extends('layouts.home_layouts')

@section('content')
<div class="container">
<h1>User Details</h1>
    <p>Name: {{ $user->name }}</p>
    <p>Email: {{ $user->email }}</p>
    <p>Role: {{ $user->roles->implode('name', ', ') }}</p>
</div>
@endsection