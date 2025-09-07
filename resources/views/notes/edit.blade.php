@extends('layouts.app')
@section('content')
<h1>Edit Note</h1>
<form method="POST" action="{{ route('notes.update', $note) }}">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Lead</label>
        <select name="lead_id" class="form-control" required>
            @foreach($leads as $lead)
                <option value="{{ $lead->id }}" @if($note->lead_id == $lead->id) selected @endif>{{ $lead->email }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Ticket</label>
        <select name="ticket_id" class="form-control">
            <option value="">-- None --</option>
            @foreach($tickets as $ticket)
                <option value="{{ $ticket->id }}" @if($note->ticket_id == $ticket->id) selected @endif>#{{ $ticket->id }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Note</label>
        <textarea name="note" class="form-control" required>{{ old('note', $note->note) }}</textarea>
    </div>
    <button class="btn btn-success">Update</button>
</form>
@endsection
