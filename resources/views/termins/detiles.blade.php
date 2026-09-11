<x-layout>
    <x-slot:title>
        Termin Details
    </x-slot:title>

    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase text-primary">Schedule</p>
                <h1 class="text-3xl font-bold">Termin Details</h1>
                <p class="mt-2 text-base-content/70">{{ $termin->room->name }} with {{ $termin->user?->name ?? 'Trainer pending' }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('termins.index') }}" class="btn btn-ghost btn-sm">Back</a>
                <a href="{{ route('termins.edit', $termin) }}" class="btn btn-primary btn-sm">Edit</a>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-4">
            <div class="rounded-lg border border-base-300 bg-base-100 p-5 shadow-sm">
                <div class="text-sm text-base-content/60">Date</div>
                <div class="mt-1 text-lg font-bold">{{ \Carbon\Carbon::parse($termin->date)->format('M d, Y') }}</div>
            </div>
            <div class="rounded-lg border border-base-300 bg-base-100 p-5 shadow-sm">
                <div class="text-sm text-base-content/60">Start</div>
                <div class="mt-1 text-lg font-bold">{{ $termin->start_time }}</div>
            </div>
            <div class="rounded-lg border border-base-300 bg-base-100 p-5 shadow-sm">
                <div class="text-sm text-base-content/60">End</div>
                <div class="mt-1 text-lg font-bold">{{ $termin->end_time }}</div>
            </div>
            <div class="rounded-lg border border-base-300 bg-base-100 p-5 shadow-sm">
                <div class="text-sm text-base-content/60">Capacity</div>
                <div class="mt-1 text-lg font-bold">{{ $termin->reservations->count() }}/{{ $termin->room->max_capacity }}</div>
            </div>
        </div>

        <div class="rounded-lg border border-base-300 bg-base-100 p-5 shadow-sm">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold">Reservations</h2>
                    <p class="text-sm text-base-content/60">Mark attendance after the training starts.</p>
                </div>
                <span class="badge badge-primary badge-outline">{{ $termin->reservations->count() }} booked</span>
            </div>

            @if ($termin->reservations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Attendance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($termin->reservations as $reservation)
                                @php
                                    $trainingStarted = now()->gte(\Carbon\Carbon::parse($termin->date . ' ' . $termin->start_time));
                                @endphp

                                <tr>
                                    <td class="font-medium">{{ $reservation->user->name }}</td>
                                    <td>{{ $reservation->user->email }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('reservations.update', $reservation) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="user_id" value="{{ $reservation->user_id }}">
                                            <input type="hidden" name="attended" value="0">
                                            <input
                                                type="checkbox"
                                                name="attended"
                                                value="1"
                                                class="toggle toggle-primary"
                                                {{ $reservation->attended ? 'checked' : '' }}
                                                {{ $trainingStarted ? '' : 'disabled' }}
                                                onchange="this.form.submit()"
                                            >
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="rounded-lg border border-dashed border-base-300 p-8 text-center text-base-content/60">
                    No reservations yet.
                </div>
            @endif
        </div>
    </div>
</x-layout>
