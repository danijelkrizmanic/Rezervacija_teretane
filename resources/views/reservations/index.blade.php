<x-layout>
    <x-slot:title>
        Home Feed
    </x-slot:title>

    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mt-8">My Reservations</h1>
        <!-- Feed -->
        <div class="space-y-4 mt-8">
            @forelse ($reservations as $reservation)
                <div class="card big-base-100 shadow mt-8">
                    <div class="card-body">
                        <div class="flex gap-1">
                                <form method="POST" action="/reservations/{{ $reservation->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to cancel your reservation?')"
                                        class="btn btn-ghost btn-xs text-error">
                                        Cancel Reservation
                                    </button>
                                </form>
                        </div>

                        <div>
                            <div class="front-semibold">{{ $reservation->termin->room->name }}</div>
                            <div class="mt-1">{{ $reservation->termin->date }} starts at {{ $reservation->termin->start_time }} and ends at {{ $reservation->termin->end_time }}</div>
                            <div class="mt-1">Max capacity: {{ $reservation->termin->room->max_capacity }}</div>
                            <div class="mt-1">Reserved: {{ $reservation->termin->reservations->count() }}</div>
                            <div class="text-sm text-gray-500 mt-2"></div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="hero py-12">
                    <div class="hero-content text-center">
                        <div>
                            <svg class="mx-auto h-12 w-12 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <p class="mt-4 text-base-content/60">No reservations yet. Be the first to create a reservation!</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>