@extends('layouts.app')
@section('content')
<h1>Note Details</h1>
<ul>
    <li><strong>ID:</strong> {{ $note->id }}</li>
    <li><strong>Lead:</strong> {{ $note->lead->email ?? '' }}</li>
    <li><strong>Ticket:</strong> {{ $note->ticket->id ?? '' }}</li>
    <li><strong>Note:</strong> {{ $note->note }}</li>
</ul>
<a href="{{ route('notes.edit', $note) }}" class="btn btn-warning">Edit</a>
<a href="{{ route('notes.index') }}" class="btn btn-secondary">Back</a>
@endsection
