<x-layout>
    <x-slot:title>
        Edit Termin
    </x-slot:title>

<div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">

    <h2 class="text-2xl font-bold mb-4">Detalji termina</h2>

    <div class="space-y-3">

        <div class="flex justify-between border-b pb-2">
            <span class="font-semibold">Trener:</span>
            <span>{{ $termin->user->name }}</span>
        </div>

        <div class="flex justify-between border-b pb-2">
            <span class="font-semibold">Soba:</span>
            <span>{{ $termin->room->name }}</span>
        </div>

        <div class="flex justify-between border-b pb-2">
            <span class="font-semibold">Datum:</span>
            <span>{{ \Carbon\Carbon::parse($termin->date)->format('d.m.Y') }}</span>
        </div>

        <div class="flex justify-between border-b pb-2">
            <span class="font-semibold">Vrijeme početka:</span>
            <span>{{ $termin->start_time }}</span>
        </div>

        <div class="flex justify-between border-b pb-2">
            <span class="font-semibold">Vrijeme završetka:</span>
            <span>{{ $termin->end_time }}</span>
        </div>

        <div class="flex justify-between">
            <span class="font-semibold">Trajanje:</span>
            <span>
                {{ \Carbon\Carbon::parse($termin->start_time)->diff(\Carbon\Carbon::parse($termin->end_time))->format('%h h %i min') }}
            </span>
        </div>

        <div class="flex justify-between">
            <span class="font-semibold">Broj rezervacija:</span>
            <span>{{ $termin->reservations->count() }}</span>
        </div>

        <div class="flex justify-between">
            <span class="font-semibold">Maksimalni kapacitet:</span>
            <span>{{ $termin->room->max_capacity }}</span>
        </div>

        {{-- show list of reservations --}}
        <div class="mt-4">
    <h3 class="font-semibold mb-2">Rezervacije</h3>

    @if($termin->reservations->count() > 0)
        

            <table class="w-full border border-gray-300 text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border-b">User</th>
                        <th class="p-2 border-b">Attendance</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($termin->reservations as $reservation)
                        <tr class="border-b">
                            <td class="p-2">
                                {{ $reservation->user->name }}
                            </td>

                            <td class="p-2">
                                <form method="POST" action="/reservations/{{ $reservation->id }}">
                                    @csrf
                                    @method('PUT')
                                        <input type="hidden" name="user_id" value="{{ $reservation->user_id }}">
                                        <input type="hidden" name="attended" value="0">
                                        <input type="checkbox"
                                            name="attended"
                                            value="1"
                                            {{ $reservation->attended ? 'checked' : '' }}
                                            {{ ($termin->date <= now()->format('Y-m-d')) ? '' : 'disabled' }}
                                            onchange="this.form.submit()">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    @else
        <p>Nema rezervacija.</p>
    @endif
</div>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ url()->previous() }}"
           class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
            Nazad
        </a>

        <a href="{{ route('termins.edit', $termin->id) }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Edit
        </a>
    </div>

</div>

</x-layout>