<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Termin;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class TerminController extends Controller
{
    public function index(): View
    {
        $terminsQuery = Termin::with('room', 'reservations', 'user')->latest('date');
        $rooms = Room::all();

        if (auth()->user()->hasRole('user')) {
            $now = now();

            $terminsQuery->where(function ($query) use ($now): void {
                $query->whereDate('date', '>', $now->toDateString())
                    ->orWhere(function ($query) use ($now): void {
                        $query->whereDate('date', $now->toDateString())
                            ->whereTime('start_time', '>=', $now->format('H:i:s'));
                    });
            });
        }

        $termins = $terminsQuery->get();

        if (auth()->user()->hasRole('admin')) {
            $roles = Role::where('name', 'trainer')->first();
            $trainers = $roles?->users ?? collect();

            return view('termins.index', compact('termins', 'rooms', 'trainers'));
        }

        if (auth()->user()->hasRole('user')) {
            $reservations = auth()->user()->reservations()->get();

            return view('termins.index', compact('termins', 'rooms', 'reservations'));
        }

        return view('termins.index', compact('termins', 'rooms'));
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('termins.index');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'date' => 'required|date',
            'trainer_id' => 'sometimes|required|exists:users,id',
        ], [
            'room_id.required' => 'Please select a room.',
            'room_id.exists' => 'The selected room does not exist.',
            'start_time.required' => 'Please provide a start time.',
            'end_time.required' => 'Please provide an end time.',
            'date.required' => 'Please provide a date.',
        ]);

        $userId = auth()->user()->hasRole('admin') && $request->has('trainer_id')
            ? (int) $request->input('trainer_id')
            : auth()->id();
        unset($validated['trainer_id']);

        $this->validateTerminConflicts($userId, $validated);

        $user = User::findOrFail($userId);
        $user->termins()->create($validated);

        return redirect('/termins')->with('success', 'Your termin has been created!');
    }

    public function show(Termin $termin): View
    {
        $this->authorize('view', $termin);
        $termin->load('room', 'user', 'reservations.user');

        return view('termins.detiles', compact('termin'));
    }

    public function edit(Termin $termin): View
    {
        $this->authorize('update', $termin);

        $rooms = Room::all();
        $trainers = null;

        if (auth()->user()->hasRole('admin')) {
            $trainers = Role::where('name', 'trainer')->first()?->users ?? collect();
        }

        return view('termins.edit', compact('termin', 'rooms', 'trainers'));
    }

    public function update(Request $request, Termin $termin): RedirectResponse
    {
        $this->authorize('update', $termin);

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'date' => 'required|date',
            'trainer_id' => 'sometimes|required|exists:users,id',
        ], [
            'room_id.required' => 'Please select a room.',
            'room_id.exists' => 'The selected room does not exist.',
            'start_time.required' => 'Please provide a start time.',
            'end_time.required' => 'Please provide an end time.',
            'date.required' => 'Please provide a date.',
        ]);

        $userId = auth()->user()->hasRole('admin') && $request->has('trainer_id')
            ? (int) $request->input('trainer_id')
            : $termin->user_id;
        unset($validated['trainer_id']);

        $this->validateTerminConflicts($userId, $validated, $termin->id);

        $termin->update([
            ...$validated,
            'user_id' => $userId,
        ]);

        return redirect('/termins')->with('success', 'Your termin has been updated!');
    }

    public function destroy(Termin $termin): RedirectResponse
    {
        $this->authorize('delete', $termin);

        $termin->delete();

        return redirect('/termins')->with('success', 'Your termin has been deleted!');
    }

    /**
     * @param  array{room_id: int|string, start_time: string, end_time: string, date: string}  $data
     */
    private function validateTerminConflicts(int $userId, array $data, ?int $ignoreTerminId = null): void
    {
        $userConflict = Termin::where('user_id', $userId)
            ->where('date', $data['date'])
            ->when($ignoreTerminId, fn ($query) => $query->where('id', '!=', $ignoreTerminId))
            ->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time'])
            ->exists();

        if ($userConflict) {
            throw ValidationException::withMessages([
                'start_time' => 'You already have a termin in that time range.',
            ]);
        }

        $roomConflict = Termin::where('room_id', $data['room_id'])
            ->where('date', $data['date'])
            ->when($ignoreTerminId, fn ($query) => $query->where('id', '!=', $ignoreTerminId))
            ->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time'])
            ->exists();

        if ($roomConflict) {
            throw ValidationException::withMessages([
                'room_id' => 'The room is already reserved in that time range.',
            ]);
        }
    }
}
