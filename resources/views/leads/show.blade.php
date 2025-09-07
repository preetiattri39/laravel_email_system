@extends('layouts.app')
@section('content')
<h1>Lead Details</h1>
<ul>
    <li><strong>ID:</strong> {{ $lead->id }}</li>
    <li><strong>Name:</strong> {{ $lead->name }}</li>
    <li><strong>Email:</strong> {{ $lead->email }}</li>
    <li><strong>UUID:</strong> {{ $lead->uuid }}</li>
</ul>
<a href="{{ route('leads.edit', $lead) }}" class="btn btn-warning">Edit</a>
<a href="{{ route('leads.index') }}" class="btn btn-secondary">Back</a>
@endsection
