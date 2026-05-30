<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = auth()->user()->reservations()->with('termin.room')->get();

        return view('reservations.index', compact('reservations'));
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
            'termin_id' => 'required|exists:termins,id',
        ], [
            'termin_id.required' => 'Please select a termin.',
            'termin_id.exists' => 'The selected termin does not exist.',
        ]);

        $termin = \App\Models\Termin::find($validated['termin_id']);

        if ($termin->reservations->count() >= $termin->room->max_capacity) {
            return redirect('/termins')->with('error', 'This termin is already fully reserved.');
        }

        auth()->user()->reservations()->create($validated);
        
        return redirect('/termins')->with('success', 'You have successfully reserved the termin!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'attended' => 'required|boolean',
            'user_id' => 'required|exists:users,id',
        ], [
            'attended.required' => 'Please provide attendance status.',
            'attended.boolean' => 'The attended field must be true or false.',
            'user_id.required' => 'User ID is required.',
            'user_id.exists' => 'The specified user does not exist.',
        ]);

        $reservation->update($validated);
        return redirect('/termins/' . $reservation->termin_id)->with('success', 'Attendance status has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect('/termins')->with('success', 'Your reservation has been cancelled!');
    }
}
