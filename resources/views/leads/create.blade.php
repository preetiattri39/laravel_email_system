@extends('layouts.app')
@section('content')
<h1>Add Lead</h1>
<form method="POST" action="{{ route('leads.store') }}">
    @csrf
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
    </div>
    <button class="btn btn-success">Save</button>
</form>
@endsection
