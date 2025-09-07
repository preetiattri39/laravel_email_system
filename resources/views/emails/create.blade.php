@extends('layouts.app')
@section('content')
<h1>Add Email</h1>
<form method="POST" action="{{ route('emails.store') }}">
    @csrf
    <div class="mb-3">
        <label>From Name</label>
        <input type="text" name="from_name" class="form-control" value="{{ old('from_name') }}">
    </div>
    <div class="mb-3">
        <label>From Email</label>
        <input type="email" name="from_email" class="form-control" value="{{ old('from_email') }}" required>
    </div>
    <div class="mb-3">
        <label>Subject</label>
        <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
    </div>
    <div class="mb-3">
        <label>Body</label>
        <textarea name="body" class="form-control">{{ old('body') }}</textarea>
    </div>
    <div class="mb-3">
        <label>Lead</label>
        <select name="lead_id" class="form-control">
            <option value="">-- None --</option>
            @foreach($leads as $lead)
                <option value="{{ $lead->id }}">{{ $lead->email }}</option>
            @endforeach
        </select>
    </div>
    <input type="hidden" name="message_id" value="{{ (string) Str::uuid() }}">
    <button class="btn btn-success">Save</button>
</form>
@endsection
