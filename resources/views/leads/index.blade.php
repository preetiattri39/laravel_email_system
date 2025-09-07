@extends('layouts.app')
@section('content')
<h1>Leads</h1>
<a href="{{ route('leads.create') }}" class="btn btn-primary mb-2">Add Lead</a>
<table class="table">
    <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr></thead>
    <tbody>
    @foreach($leads as $lead)
        <tr>
            <td>{{ $lead->id }}</td>
            <td>{{ $lead->name }}</td>
            <td>{{ $lead->email }}</td>
            <td>
                <a href="{{ route('leads.show', $lead) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('leads.edit', $lead) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('leads.destroy', $lead) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $leads->links() }}
@endsection
