<?php

namespace App\Http\Controllers;

use App\Models\Talk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TalkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('talks.index', [
            'talks' => Auth::user()->talks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('talks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'length' => 'required|string|max:255',
            'type' => 'required|in:lightting,standrad,keynote',
            'abstract' => 'required|string',
            'organizer_notes' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        Talk::create($validated);

        return redirect()->route('talks.index')->with('success', 'Talk created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Talk $talk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Talk $talk)
    {
        return view('talks.edit', [
            'talk' => $talk,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Talk $talk)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'length' => 'required|string|max:255',
            'type' => 'required|in:lightting,standrad,keynote',
            'abstract' => 'required|string',
            'organizer_notes' => 'nullable|string',
        ]);

        $talk->update($validated);

        return redirect()->route('talks.index')->with('success', 'Talk updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Talk $talk)
    {
        $talk->delete();

        return redirect()->route('talks.index')->with('success', 'Talk deleted successfully.');
    }
}
