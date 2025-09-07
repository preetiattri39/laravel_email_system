@extends('layouts.app')
@section('content')
<h1>Timelines</h1>
<a href="{{ route('timelines.create') }}" class="btn btn-primary mb-2">Add Timeline Entry</a>
<table class="table">
    <thead><tr><th>ID</th><th>Lead</th><th>Type</th><th>Message</th><th>Actions</th></tr></thead>
    <tbody>
    @foreach($timelines as $timeline)
        <tr>
            <td>{{ $timeline->id }}</td>
            <td>{{ $timeline->lead->email ?? '' }}</td>
            <td>{{ $timeline->type }}</td>
            <td>{{ $timeline->message }}</td>
            <td>
                <a href="{{ route('timelines.show', $timeline) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('timelines.edit', $timeline) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('timelines.destroy', $timeline) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $timelines->links() }}
@endsection
