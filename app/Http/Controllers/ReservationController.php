<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Termin;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReservationController extends Controller
{
    public function index(): View
    {
        $reservations = auth()->user()
            ->reservations()
            ->with('termin.room', 'termin.user', 'termin.reservations')
            ->latest()
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'termin_id' => 'required|exists:termins,id',
        ], [
            'termin_id.required' => 'Please select a termin.',
            'termin_id.exists' => 'The selected termin does not exist.',
        ]);

        $termin = Termin::with('room', 'reservations')->findOrFail($validated['termin_id']);

        if ($termin->reservations->count() >= $termin->room->max_capacity) {
            return redirect('/termins')->with('error', 'This termin is already fully reserved.');
        }

        $alreadyReserved = auth()->user()
            ->reservations()
            ->where('termin_id', $termin->id)
            ->exists();

        if ($alreadyReserved) {
            return redirect('/termins')->with('error', 'You have already reserved this termin.');
        }

        auth()->user()->reservations()->create($validated);

        return redirect('/termins')->with('success', 'You have successfully reserved the termin!');
    }

    public function update(Request $request, Reservation $reservation): RedirectResponse
    {
        $reservation->load('termin');

        abort_unless(
            auth()->user()->hasRole('admin') || auth()->id() === $reservation->termin->user_id,
            403
        );

        $trainingStartsAt = Carbon::parse($reservation->termin->date.' '.$reservation->termin->start_time);

        if (now()->lt($trainingStartsAt)) {
            return back()->with('error', 'Attendance can be updated after the training starts.');
        }

        $validated = $request->validate([
            'attended' => 'required|boolean',
            'user_id' => 'required|exists:users,id',
        ], [
            'attended.required' => 'Please provide attendance status.',
            'attended.boolean' => 'The attended field must be true or false.',
            'user_id.required' => 'User ID is required.',
            'user_id.exists' => 'The specified user does not exist.',
        ]);

        abort_unless((int) $validated['user_id'] === $reservation->user_id, 403);

        $reservation->update([
            'attended' => $validated['attended'],
        ]);

        return redirect('/termins/'.$reservation->termin_id)->with('success', 'Attendance status has been updated!');
    }

    public function destroy(Reservation $reservation): RedirectResponse
    {
        abort_unless(auth()->id() === $reservation->user_id, 403);

        $reservation->delete();

        return back()->with('success', 'Your reservation has been cancelled!');
    }
}
