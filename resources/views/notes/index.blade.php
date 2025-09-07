@extends('layouts.app')
@section('content')
<h1>Notes</h1>
<a href="{{ route('notes.create') }}" class="btn btn-primary mb-2">Add Note</a>
<table class="table">
    <thead><tr><th>ID</th><th>Lead</th><th>Ticket</th><th>Note</th><th>Actions</th></tr></thead>
    <tbody>
    @foreach($notes as $note)
        <tr>
            <td>{{ $note->id }}</td>
            <td>{{ $note->lead->email ?? '' }}</td>
            <td>{{ $note->ticket->id ?? '' }}</td>
            <td>{{ $note->note }}</td>
            <td>
                <a href="{{ route('notes.show', $note) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('notes.edit', $note) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('notes.destroy', $note) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $notes->links() }}
@endsection
