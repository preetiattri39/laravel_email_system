@extends('layouts.app')
@section('content')
<h1>Timeline Entry Details</h1>
<ul>
    <li><strong>ID:</strong> {{ $timeline->id }}</li>
    <li><strong>Lead:</strong> {{ $timeline->lead->email ?? '' }}</li>
    <li><strong>Type:</strong> {{ $timeline->type }}</li>
    <li><strong>Message:</strong> {{ $timeline->message }}</li>
</ul>
<a href="{{ route('timelines.edit', $timeline) }}" class="btn btn-warning">Edit</a>
<a href="{{ route('timelines.index') }}" class="btn btn-secondary">Back</a>
@endsection
