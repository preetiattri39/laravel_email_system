<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = \App\Models\Note::latest()->paginate(10);
        return view('notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leads = \App\Models\Lead::all();
        $tickets = \App\Models\Ticket::all();
        return view('notes.create', compact('leads', 'tickets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'ticket_id' => 'nullable|exists:tickets,id',
            'note' => 'required|string',
        ]);
        $note = \App\Models\Note::create($data);
        return redirect()->route('notes.show', $note)->with('success', 'Note created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        $leads = \App\Models\Lead::all();
        $tickets = \App\Models\Ticket::all();
        return view('notes.edit', compact('note', 'leads', 'tickets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        $data = $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'ticket_id' => 'nullable|exists:tickets,id',
            'note' => 'required|string',
        ]);
        $note->update($data);
        return redirect()->route('notes.show', $note)->with('success', 'Note updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $note->delete();
        return redirect()->route('notes.index')->with('success', 'Note deleted successfully.');
    }
}
