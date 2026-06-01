<x-layout>
    <x-slot:title>
        Rooms
    </x-slot:title>

    <div class="space-y-8">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase text-primary">Facility</p>
                <h1 class="text-3xl font-bold">Rooms</h1>
                <p class="mt-2 text-base-content/70">Manage studio spaces and capacity for scheduled termins.</p>
            </div>
            <div class="stats w-full border border-base-300 bg-base-100 shadow-sm sm:w-auto">
                <div class="stat">
                    <div class="stat-title">Total rooms</div>
                    <div class="stat-value text-2xl">{{ $rooms->count() }}</div>
                </div>
            </div>
        </div>

        @can('manage rooms')
            <div class="rounded-lg border border-base-300 bg-base-100 p-5 shadow-sm">
                <form method="POST" action="{{ route('rooms.store') }}" class="grid gap-4 md:grid-cols-[1fr_180px_auto] md:items-end">
                    @csrf
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-medium">Room name</span>
                        </div>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Studio A" class="input input-bordered w-full bg-base-100 @error('name') input-error @enderror" maxlength="255" required>
                        @error('name')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>

                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text font-medium">Capacity</span>
                        </div>
                        <input type="number" name="max_capacity" value="{{ old('max_capacity') }}" placeholder="16" class="input input-bordered w-full bg-base-100 @error('max_capacity') input-error @enderror" min="1" required>
                        @error('max_capacity')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </label>

                    <button type="submit" class="btn btn-primary">Create Room</button>
                </form>
            </div>
        @endcan

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($rooms as $room)
                <div class="card border border-base-300 bg-base-100 shadow-sm">
                    <div class="card-body gap-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="card-title">{{ $room->name }}</h2>
                                <p class="text-sm text-base-content/60">{{ $room->termins->count() }} scheduled termins</p>
                            </div>
                            <div class="badge badge-primary badge-outline">{{ $room->max_capacity }} people</div>
                        </div>

                        @can('manage rooms')
                            <div class="card-actions justify-end">
                                <a href="{{ route('rooms.edit', $room) }}" class="btn btn-ghost btn-xs">Edit</a>
                                <x-delete-confirmation-modal
                                    id="delete-room-{{ $room->id }}"
                                    :action="route('rooms.destroy', $room)"
                                    title="Delete room"
                                    message="This will delete the room from the schedule workspace."
                                />
                            </div>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="rounded-lg border border-dashed border-base-300 bg-base-100 p-8 text-center md:col-span-2 xl:col-span-3">
                    <h2 class="text-lg font-semibold">No rooms yet</h2>
                    <p class="mt-2 text-base-content/60">Create your first room to start scheduling termins.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>
