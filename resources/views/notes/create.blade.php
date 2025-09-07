@extends('layouts.app')
@section('content')
<h1>Add Note</h1>
<form method="POST" action="{{ route('notes.store') }}">
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
        <label>Ticket</label>
        <select name="ticket_id" class="form-control">
            <option value="">-- None --</option>
            @foreach($tickets as $ticket)
                <option value="{{ $ticket->id }}">#{{ $ticket->id }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Note</label>
        <textarea name="note" class="form-control" required>{{ old('note') }}</textarea>
    </div>
    <button class="btn btn-success">Save</button>
</form>
@endsection
