<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timelines = \App\Models\Timeline::latest()->paginate(10);
        return view('timelines.index', compact('timelines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leads = \App\Models\Lead::all();
        return view('timelines.create', compact('leads'));
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
            'type' => 'required|in:email,reply,note',
            'message' => 'required|string',
        ]);
        $timeline = \App\Models\Timeline::create($data);
        return redirect()->route('timelines.show', $timeline)->with('success', 'Timeline entry created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Timeline  $timeline
     * @return \Illuminate\Http\Response
     */
    public function show(Timeline $timeline)
    {
        return view('timelines.show', compact('timeline'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Timeline  $timeline
     * @return \Illuminate\Http\Response
     */
    public function edit(Timeline $timeline)
    {
        $leads = \App\Models\Lead::all();
        return view('timelines.edit', compact('timeline', 'leads'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Timeline  $timeline
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Timeline $timeline)
    {
        $data = $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'type' => 'required|in:email,reply,note',
            'message' => 'required|string',
        ]);
        $timeline->update($data);
        return redirect()->route('timelines.show', $timeline)->with('success', 'Timeline entry updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Timeline  $timeline
     * @return \Illuminate\Http\Response
     */
    public function destroy(Timeline $timeline)
    {
        $timeline->delete();
        return redirect()->route('timelines.index')->with('success', 'Timeline entry deleted successfully.');
    }
}
