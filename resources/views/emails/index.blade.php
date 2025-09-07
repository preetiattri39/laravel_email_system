@extends('layouts.app')
@section('content')
<h1>Emails</h1>
<a href="{{ route('emails.create') }}" class="btn btn-primary mb-2">Add Email</a>
<table class="table">
    <thead><tr><th>ID</th><th>From</th><th>Subject</th><th>Lead</th><th>Actions</th></tr></thead>
    <tbody>
    @foreach($emails as $email)
        <tr>
            <td>{{ $email->id }}</td>
            <td>{{ $email->from_email }}</td>
            <td>{{ $email->subject }}</td>
            <td>{{ $email->lead->email ?? '' }}</td>
            <td>
                <a href="{{ route('emails.show', $email) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('emails.edit', $email) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('emails.destroy', $email) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $emails->links() }}
@endsection
