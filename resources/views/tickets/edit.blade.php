@extends('layouts.app')
@section('content')
<h1>Edit Ticket</h1>
<form method="POST" action="{{ route('tickets.update', $ticket) }}">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Lead</label>
        <select name="lead_id" class="form-control" required>
            @foreach($leads as $lead)
                <option value="{{ $lead->id }}" @if($ticket->lead_id == $lead->id) selected @endif>{{ $lead->email }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <select name="email_id" class="form-control" required>
            @foreach($emails as $email)
                <option value="{{ $email->id }}" @if($ticket->email_id == $email->id) selected @endif>{{ $email->subject }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Priority</label>
        <input type="text" name="priority" class="form-control" value="{{ old('priority', $ticket->priority) }}">
    </div>
    <button class="btn btn-success">Update</button>
</form>
@endsection
