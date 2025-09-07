@extends('layouts.app')
@section('content')
<h1>Edit Lead</h1>
<form method="POST" action="{{ route('leads.update', $lead) }}">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $lead->name) }}">
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $lead->email) }}" required>
    </div>
    <button class="btn btn-success">Update</button>
</form>
@endsection
