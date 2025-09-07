@extends('layouts.app')
@section('content')
<h1>Email Details</h1>
<ul>
    <li><strong>ID:</strong> {{ $email->id }}</li>
    <li><strong>From:</strong> {{ $email->from_email }}</li>
    <li><strong>Subject:</strong> {{ $email->subject }}</li>
    <li><strong>Body:</strong> {{ $email->body }}</li>
    <li><strong>Lead:</strong> {{ $email->lead->email ?? '' }}</li>
</ul>
<a href="{{ route('emails.edit', $email) }}" class="btn btn-warning">Edit</a>
<a href="{{ route('emails.index') }}" class="btn btn-secondary">Back</a>
@endsection
