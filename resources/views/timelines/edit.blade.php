@extends('layouts.app')
@section('content')
<h1>Edit Timeline Entry</h1>
<form method="POST" action="{{ route('timelines.update', $timeline) }}">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Lead</label>
        <select name="lead_id" class="form-control" required>
            @foreach($leads as $lead)
                <option value="{{ $lead->id }}" @if($timeline->lead_id == $lead->id) selected @endif>{{ $lead->email }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Type</label>
        <select name="type" class="form-control" required>
            <option value="email" @if($timeline->type == 'email') selected @endif>Email</option>
            <option value="reply" @if($timeline->type == 'reply') selected @endif>Reply</option>
            <option value="note" @if($timeline->type == 'note') selected @endif>Note</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Message</label>
        <textarea name="message" class="form-control" required>{{ old('message', $timeline->message) }}</textarea>
    </div>
    <button class="btn btn-success">Update</button>
</form>
@endsection
