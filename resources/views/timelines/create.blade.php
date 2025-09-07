@extends('layouts.app')
@section('content')
<h1>Add Timeline Entry</h1>
<form method="POST" action="{{ route('timelines.store') }}">
    @csrf
    <div class="mb-3">
        <label>Lead</label>
        <select name="lead_id" class="form-control" required>
            @foreach($leads as $lead)
                <option value="{{ $lead->id }}">{{ $lead->email }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Type</label>
        <select name="type" class="form-control" required>
            <option value="email">Email</option>
            <option value="reply">Reply</option>
            <option value="note">Note</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Message</label>
        <textarea name="message" class="form-control" required>{{ old('message') }}</textarea>
    </div>
    <button class="btn btn-success">Save</button>
</form>
@endsection
