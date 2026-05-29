<x-layout>
    <x-slot:title>
        Home Feed
    </x-slot:title>

    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mt-8">Rooms</h1>

        
                <!-- Room Form -->
        @can('manage rooms')
        <div class="card bg-base-100 shadow mt-8">
            <div class="card-body">
                <form method="POST" action="/rooms">
                    @csrf
                    <div class="form-control w-full">
                        <input type="text"
                            name="name"
                            placeholder="Room name"
                            class="input input-bordered w-full @error('name') input-error @enderror"
                            maxlength="255"
                            required
                        >{{ old('name') }}</input>

                        @error('name')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-control w-full mt-4">
                        <input type="number"
                            name="max_capacity"
                            placeholder="Max capacity"
                            class="input input-bordered w-full @error('max_capacity') input-error @enderror"
                            min="1"
                            required
                        >{{ old('max_capacity') }}</input>

                        @error('max_capacity')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>  
                        @enderror
                    </div>

                    <div class="mt-4 flex items-center justify-end">
                        <button type="submit" class="btn btn-primary btn-sm">
                            Create Room
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endcan


        <!-- Feed -->
        <div class="space-y-4 mt-8">
            @forelse ($rooms as $room)
                <div class="card big-base-100 shadow mt-8">
                    <div class="card-body">
                        @can('manage rooms')
                        <div class="flex gap-1">
                            <a href="/rooms/{{ $room->id }}/edit" class="btn btn-ghost btn-xs">
                                Edit
                            </a>
                            <form method="POST" action="/rooms/{{ $room->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this room?')"
                                    class="btn btn-ghost btn-xs text-error">
                                    Delete
                                </button>
                            </form>
                        </div>
                        @endcan

                        <div>
                            <div class="front-semibold">{{ $room->name }}</div>
                            <div class="mt-1">{{ $room->max_capacity }} people</div>
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
                            <p class="mt-4 text-base-content/60">No rooms yet. Be the first to create a room!</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>