<x-layout>
    <x-slot:title>
        Termins
    </x-slot:title>

    <div class="space-y-8">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase text-primary">Schedule</p>
                <h1 class="text-3xl font-bold">Termins</h1>
                <p class="mt-2 text-base-content/70">Browse available sessions and manage gym scheduling by role.</p>
            </div>
            <div class="stats w-full border border-base-300 bg-base-100 shadow-sm sm:w-auto">
                <div class="stat">
                    <div class="stat-title">Scheduled</div>
                    <div class="stat-value text-2xl">{{ $termins->count() }}</div>
                </div>
            </div>
        </div>

        @can('manage termins')
            <div class="rounded-lg border border-base-300 bg-base-100 p-5 shadow-sm">
                <form method="POST" action="{{ route('termins.store') }}" class="grid gap-4 lg:grid-cols-5 lg:items-end">
                    @csrf

                    <x-form.select-input label="Room" name="room_id" placeholder="Select a room" required>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                        @endforeach
                    </x-form.select-input>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-medium">Start time</span>
                        </div>
                        <input type="time" name="start_time" value="{{ old('start_time') }}" class="input input-bordered w-full bg-base-100 @error('start_time') input-error @enderror" required>
                        @error('start_time')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-medium">End time</span>
                        </div>
                        <input type="time" name="end_time" value="{{ old('end_time') }}" class="input input-bordered w-full bg-base-100 @error('end_time') input-error @enderror" required>
                        @error('end_time')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>

                    <x-form.date-input label="Date" name="date" required />

                    @can('manage termins for trainers')
                        <x-form.select-input label="Trainer" name="trainer_id" placeholder="Select a trainer" required>
                            @foreach ($trainers as $trainer)
                                <option value="{{ $trainer->id }}" {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}>{{ $trainer->name }}</option>
                            @endforeach
                        </x-form.select-input>
                    @else
                        <button type="submit" class="btn btn-primary">Create Termin</button>
                    @endcan

                    @can('manage termins for trainers')
                        <div class="lg:col-start-5">
                            <button type="submit" class="btn btn-primary w-full">Create Termin</button>
                        </div>
                    @endcan
                </form>
            </div>
        @endcan

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($termins as $termin)
                @php
                    $reservedCount = $termin->reservations->count();
                    $capacity = $termin->room->max_capacity;
                    $userReservation = isset($reservations) ? $reservations->firstWhere('termin_id', $termin->id) : null;
                @endphp

                <div class="card border border-base-300 bg-base-100 shadow-sm">
                    <div class="card-body gap-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="card-title">{{ $termin->room->name }}</h2>
                                <p class="text-sm text-base-content/60">{{ $termin->user?->name ?? 'Trainer pending' }}</p>
                            </div>
                            <div class="badge {{ $reservedCount >= $capacity ? 'badge-error' : 'badge-primary' }} badge-outline">
                                {{ $reservedCount }}/{{ $capacity }}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div class="rounded-lg bg-base-200 p-3">
                                <div class="text-base-content/50">Date</div>
                                <div class="font-semibold">{{ \Carbon\Carbon::parse($termin->date)->format('M d, Y') }}</div>
                            </div>
                            <div class="rounded-lg bg-base-200 p-3">
                                <div class="text-base-content/50">Time</div>
                                <div class="font-semibold">{{ $termin->start_time }} - {{ $termin->end_time }}</div>
                            </div>
                        </div>

                        <div class="card-actions justify-end">
                            @can('update', $termin)
                                <a href="{{ route('termins.show', $termin) }}" class="btn btn-ghost btn-xs">View</a>
                                <a href="{{ route('termins.edit', $termin) }}" class="btn btn-ghost btn-xs">Edit</a>
                                <x-delete-confirmation-modal
                                    id="delete-termin-{{ $termin->id }}"
                                    :action="route('termins.destroy', $termin)"
                                    title="Delete termin"
                                    message="This will remove the scheduled termin and its reservation context."
                                />
                            @endcan

                            @role('user')
                                @if ($userReservation)
                                    <x-delete-confirmation-modal
                                        id="cancel-reservation-{{ $userReservation->id }}"
                                        :action="route('reservations.destroy', $userReservation)"
                                        title="Cancel reservation"
                                        message="Your spot for this termin will be released."
                                        button-label="Cancel Reservation"
                                        trigger-label="Cancel Reservation"
                                    />
                                @elseif ($reservedCount < $capacity)
                                    <form method="POST" action="{{ route('reservations.store') }}">
                                        @csrf
                                        <input type="hidden" name="termin_id" value="{{ $termin->id }}">
                                        <button type="submit" class="btn btn-primary btn-xs">Reserve</button>
                                    </form>
                                @else
                                    <span class="badge badge-error">Full</span>
                                @endif
                            @endrole
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-lg border border-dashed border-base-300 bg-base-100 p-8 text-center md:col-span-2 xl:col-span-3">
                    <h2 class="text-lg font-semibold">No termins yet</h2>
                    <p class="mt-2 text-base-content/60">Create a termin to make the schedule available.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>
