<x-layout>
    <x-slot:title>
        My Reservations
    </x-slot:title>

    <div class="space-y-8">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase text-primary">Member area</p>
                <h1 class="text-3xl font-bold">My Reservations</h1>
                <p class="mt-2 text-base-content/70">Review and cancel your booked gym sessions.</p>
            </div>
            <div class="stats w-full border border-base-300 bg-base-100 shadow-sm sm:w-auto">
                <div class="stat">
                    <div class="stat-title">Booked</div>
                    <div class="stat-value text-2xl">{{ $reservations->count() }}</div>
                </div>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($reservations as $reservation)
                @php
                    $trainingStartsAt = \Carbon\Carbon::parse($reservation->termin->date . ' ' . $reservation->termin->start_time);
                    $isPastTraining = $trainingStartsAt->isPast();
                @endphp

                <div class="card border border-base-300 bg-base-100 shadow-sm">
                    <div class="card-body gap-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="card-title">{{ $reservation->termin->room->name }}</h2>
                                <p class="text-sm text-base-content/60">{{ $reservation->termin->user?->name ?? 'Trainer pending' }}</p>
                            </div>
                            <div class="badge badge-primary badge-outline">
                                {{ $reservation->termin->reservations->count() }}/{{ $reservation->termin->room->max_capacity }}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div class="rounded-lg bg-base-200 p-3">
                                <div class="text-base-content/50">Date</div>
                                <div class="font-semibold">{{ \Carbon\Carbon::parse($reservation->termin->date)->format('M d, Y') }}</div>
                            </div>
                            <div class="rounded-lg bg-base-200 p-3">
                                <div class="text-base-content/50">Time</div>
                                <div class="font-semibold">{{ $reservation->termin->start_time }} - {{ $reservation->termin->end_time }}</div>
                            </div>
                        </div>

                        <div class="card-actions justify-end">
                            @if ($isPastTraining)
                                <span class="badge {{ $reservation->attended ? 'badge-success' : 'badge-warning' }}">
                                    {{ $reservation->attended ? 'Attended' : 'Not attended' }}
                                </span>
                            @else
                                <x-delete-confirmation-modal
                                    id="cancel-reservation-page-{{ $reservation->id }}"
                                    :action="route('reservations.destroy', $reservation)"
                                    title="Cancel reservation"
                                    message="Your spot for this termin will be released."
                                    button-label="Cancel Reservation"
                                    trigger-label="Cancel Reservation"
                                />
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-lg border border-dashed border-base-300 bg-base-100 p-8 text-center md:col-span-2 xl:col-span-3">
                    <h2 class="text-lg font-semibold">No reservations yet</h2>
                    <p class="mt-2 text-base-content/60">Reserve a termin to see it here.</p>
                    <a href="{{ route('termins.index') }}" class="btn btn-primary btn-sm mt-4">Browse Termins</a>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>
