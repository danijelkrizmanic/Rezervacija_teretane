<?php

namespace App\Http\Controllers;

use App\Models\Termin;
use App\Models\Room;
use Illuminate\Http\Request;

class TerminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $termins = Termin::with('room')->get();
        $rooms = Room::all();
        return view('termins.index', compact('termins', 'rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'date' => 'required|date'
        ], [
            'room_id.required' => 'Please select a room.',
            'room_id.exists' => 'The selected room does not exist.',
            'start_time.required' => 'Please provide a start time.',
            'end_time.required' => 'Please provide an end time.',
            'date.required' => 'Please provide a date.',
        ]);

        auth()->user()->termins()->create($validated);

        return redirect('/termins')->with('success', 'Your termin has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Termin $termin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Termin $termin)
    {
        $rooms = Room::all();
        return view('termins.edit', compact('termin', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Termin $termin)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'date' => 'required|date'
        ], [
            'room_id.required' => 'Please select a room.',
            'room_id.exists' => 'The selected room does not exist.',
            'start_time.required' => 'Please provide a start time.',
            'end_time.required' => 'Please provide an end time.',
            'date.required' => 'Please provide a date.',
        ]);

        $termin->update($validated);

        return redirect('/termins')->with('success', 'Your termin has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Termin $termin)
    {
        $termin->delete();

        return redirect('/termins')->with('success', 'Your termin has been deleted!');
    }
}
