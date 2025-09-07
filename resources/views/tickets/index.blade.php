@extends('layouts.app')
@section('content')
<h1>Tickets</h1>
<a href="{{ route('tickets.create') }}" class="btn btn-primary mb-2">Add Ticket</a>
<table class="table">
    <thead><tr><th>ID</th><th>Lead</th><th>Email</th><th>Priority</th><th>Actions</th></tr></thead>
    <tbody>
    @foreach($tickets as $ticket)
        <tr>
            <td>{{ $ticket->id }}</td>
            <td>{{ $ticket->lead->email ?? '' }}</td>
            <td>{{ $ticket->email->subject ?? '' }}</td>
            <td>{{ $ticket->priority }}</td>
            <td>
                <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $tickets->links() }}
@endsection
