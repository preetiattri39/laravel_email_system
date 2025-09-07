<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emails = \App\Models\Email::latest()->paginate(10);
        return view('emails.index', compact('emails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leads = \App\Models\Lead::all();
        return view('emails.create', compact('leads'));
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
            'message_id' => 'required|string|unique:emails,message_id',
            'from_name' => 'nullable|string',
            'from_email' => 'required|email',
            'subject' => 'nullable|string',
            'body' => 'nullable|string',
            'headers' => 'nullable|array',
            'lead_id' => 'nullable|exists:leads,id',
        ]);
        $email = \App\Models\Email::create($data);
        return redirect()->route('emails.show', $email)->with('success', 'Email created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function show(Email $email)
    {
        return view('emails.show', compact('email'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function edit(Email $email)
    {
        $leads = \App\Models\Lead::all();
        return view('emails.edit', compact('email', 'leads'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Email $email)
    {
        $data = $request->validate([
            'message_id' => 'required|string|unique:emails,message_id,' . $email->id,
            'from_name' => 'nullable|string',
            'from_email' => 'required|email',
            'subject' => 'nullable|string',
            'body' => 'nullable|string',
            'headers' => 'nullable|array',
            'lead_id' => 'nullable|exists:leads,id',
        ]);
        $email->update($data);
        return redirect()->route('emails.show', $email)->with('success', 'Email updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(Email $email)
    {
        $email->delete();
        return redirect()->route('emails.index')->with('success', 'Email deleted successfully.');
    }
}
