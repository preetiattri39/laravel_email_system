@extends('layouts.app')
@section('content')
<h1>Add Ticket</h1>
<form method="POST" action="{{ route('tickets.store') }}">
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
        <label>Email</label>
        <select name="email_id" class="form-control" required>
            @foreach($emails as $email)
                <option value="{{ $email->id }}">
                    {{ $email->subject ? $email->subject : '(no subject)' }} — {{ $email->from_email }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Priority</label>
        <input type="text" name="priority" class="form-control" value="high">
    </div>
    <button class="btn btn-success">Save</button>
</form>
@endsection
