<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(): View
    {
        $rooms = Room::with('termins')->get();

        return view('rooms.index', compact('rooms'));
    }

    public function store(Request $request): RedirectResponse
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

    public function edit(Room $room): View
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room): RedirectResponse
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

    public function destroy(Room $room): RedirectResponse
    {
        $room->delete();

        return redirect('/rooms')->with('success', 'Your room has been deleted!');
    }
}
