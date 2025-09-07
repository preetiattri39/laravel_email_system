@extends('layouts.app')
@section('content')
<h1>Ticket Details</h1>
<ul>
    <li><strong>ID:</strong> {{ $ticket->id }}</li>
    <li><strong>Lead:</strong> {{ $ticket->lead->email ?? '' }}</li>
    <li><strong>Email:</strong> {{ $ticket->email->subject ?? '' }}</li>
    <li><strong>Priority:</strong> {{ $ticket->priority }}</li>
    <li><strong>Zoho Ticket ID:</strong> {{ $ticket->zoho_ticket_id }}</li>
</ul>
<a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-warning">Edit</a>
<a href="{{ route('tickets.index') }}" class="btn btn-secondary">Back</a>
@endsection
