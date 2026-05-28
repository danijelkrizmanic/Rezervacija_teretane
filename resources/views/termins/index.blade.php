<x-layout>
    <x-slot:title>
        Home Feed
    </x-slot:title>

    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mt-8">Termins</h1>

                <!-- Termin Form -->
        <div class="card bg-base-100 shadow mt-8">
            <div class="card-body">
                <form method="POST" action="/termins">
                    @csrf
                    <div class="form-control w-full">
                        <select name="room_id" class="select select-bordered w-full @error('room_id') input-error @enderror" required>
                            <option disabled selected>Select a room</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                            @endforeach
                        </select>

                        @error('room_id')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-control w-full mt-4">

                        <input type="text"
                            name="start_time"
                            placeholder="Start time"
                            class="input input-bordered w-full @error('start_time') input-error @enderror"
                            required
                        >{{ old('start_time') }}</input>

                        @error('start_time')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-control w-full mt-4">
                        <input type="text"
                            name="end_time"
                            placeholder="End time"
                            class="input input-bordered w-full @error('end_time') input-error @enderror"
                            required
                        >{{ old('end_time') }}</input>

                        @error('end_time')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-control w-full mt-4">
                        <input type="date"
                            name="date"
                            placeholder="Date"
                            class="input input-bordered w-full @error('date') input-error @enderror"
                            required
                        >{{ old('date') }}</input>

                        @error('date')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                        @error('start_time')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>  
                        @enderror
                    </div>

                    <div class="mt-4 flex items-center justify-end">
                        <button type="submit" class="btn btn-primary btn-sm">
                            Create Termin
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Feed -->
        <div class="space-y-4 mt-8">
            @forelse ($termins as $termin)
                <div class="card big-base-100 shadow mt-8">
                    <div class="card-body">

                        <div class="flex gap-1">
                            <a href="/termins/{{ $termin->id }}/edit" class="btn btn-ghost btn-xs">
                                Edit
                            </a>
                            <form method="POST" action="/termins/{{ $termin->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this termin?')"
                                    class="btn btn-ghost btn-xs text-error">
                                    Delete
                                </button>
                            </form>
                        </div>

                        <div>
                            <div class="front-semibold">{{ $termin->room->name }}</div>
                            <div class="mt-1">{{ $termin->date }} starts at {{ $termin->start_time }} and ends at {{ $termin->end_time }}</div>
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
                            <p class="mt-4 text-base-content/60">No termins yet. Be the first to create a termin!</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>