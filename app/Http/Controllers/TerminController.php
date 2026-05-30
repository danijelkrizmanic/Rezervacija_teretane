<?php

namespace App\Http\Controllers;

use App\Models\Termin;
use App\Models\Room;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;

class TerminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $termins = Termin::with('room', 'reservations')->get();
        $rooms = Room::all();
        if(auth()->user()->hasRole('admin')){
            $roles = Role::where('name', 'trainer')->first();
            $trainers = $roles->users;
            return view('termins.index', compact('termins', 'rooms', 'trainers'));
        }

        if(auth()->user()->hasRole('user')){
            $reservations = auth()->user()->reservations()->get();
            return view('termins.index', compact('termins', 'rooms', 'reservations'));
        }
        
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
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'date' => 'required|date'
        ], [
            'room_id.required' => 'Please select a room.',
            'room_id.exists' => 'The selected room does not exist.',
            'start_time.required' => 'Please provide a start time.',
            'end_time.required' => 'Please provide an end time.',
            'date.required' => 'Please provide a date.',
        ]);

        $userId = auth()->user()->hasRole('admin') && $request->has('trainer_id') ? $request->input('trainer_id') : auth()->id();

        $this->validateTerminConflicts($userId, $validated);

        $user = User::find($userId);
        $user->termins()->create($validated);

        return redirect('/termins')->with('success', 'Your termin has been created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Termin $termin)
    {
        return view('termins.detiles', compact('termin'));
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

        $userId = auth()->user()->hasRole('admin') && $request->has('trainer_id') ? $request->input('trainer_id') : $termin->user_id;

        $this->validateTerminConflicts(
            $userId,
            $validated,
            $termin->id // ignoriraj trenutni termin
        );

        $termin->update([
            ...$validated,
            'user_id' => $userId,
        ]);

        // $termin->update($validated);

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

    private function validateTerminConflicts(
    int $userId,
    array $data,
    ?int $ignoreTerminId = null
): void {
    $userConflict = Termin::where('user_id', $userId)
        ->where('date', $data['date'])
        ->when($ignoreTerminId, fn ($query) => $query->where('id', '!=', $ignoreTerminId))
        ->where('start_time', '<', $data['end_time'])
        ->where('end_time', '>', $data['start_time'])
        ->exists();

    if ($userConflict) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'start_time' => 'Već imate termin u tom vremenu.'
        ]);
    }

    $roomConflict = Termin::where('room_id', $data['room_id'])
        ->where('date', $data['date'])
        ->when($ignoreTerminId, fn ($query) => $query->where('id', '!=', $ignoreTerminId))
        ->where('start_time', '<', $data['end_time'])
        ->where('end_time', '>', $data['start_time'])
        ->exists();

    if ($roomConflict) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'room_id' => 'Soba je već rezervirana u tom vremenu.'
        ]);
    }
}
}
