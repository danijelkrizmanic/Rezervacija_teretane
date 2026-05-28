<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with('termins')->get();
        return view('rooms.index', compact('rooms'));
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
            'name' => 'required|string|max:255',
            'max_capacity' => 'required|integer|min:1',
        ], [
            'name.required' => 'Please provide a name for the room.',
            'max_capacity.required' => 'Please provide a maximum capacity for the room.',
            'max_capacity.integer' => 'The maximum capacity must be an integer.',
            'max_capacity.min' => 'The maximum capacity must be at least 1.',
        ]);

        Room::create($validated);

        return redirect('/rooms')->with('success', 'Your room has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'max_capacity' => 'required|integer|min:1',
        ], [
            'name.required' => 'Please provide a name for the room.',
            'max_capacity.required' => 'Please provide a maximum capacity for the room.',
            'max_capacity.integer' => 'The maximum capacity must be an integer.',
            'max_capacity.min' => 'The maximum capacity must be at least 1.',
        ]);

        $room->update($validated);

        return redirect('/rooms')->with('success', 'Your room has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect('/rooms')->with('success', 'Your room has been deleted!');
    }
}
