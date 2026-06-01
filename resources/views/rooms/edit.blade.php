<x-layout>
    <x-slot:title>
        Edit Room
    </x-slot:title>

    <div class="mx-auto max-w-2xl space-y-6">
        <div>
            <p class="text-sm font-semibold uppercase text-primary">Facility</p>
            <h1 class="text-3xl font-bold">Edit Room</h1>
        </div>

        <div class="rounded-lg border border-base-300 bg-base-100 p-6 shadow-sm">
            <form method="POST" action="{{ route('rooms.update', $room) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text font-medium">Room name</span>
                    </div>
                    <input type="text" name="name" class="input input-bordered w-full bg-base-100 @error('name') input-error @enderror" value="{{ old('name', $room->name) }}" required>
                    @error('name')
                        <div class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                    @enderror
                </label>

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text font-medium">Maximum capacity</span>
                    </div>
                    <input type="number" name="max_capacity" class="input input-bordered w-full bg-base-100 @error('max_capacity') input-error @enderror" value="{{ old('max_capacity', $room->max_capacity) }}" min="1" required>
                    @error('max_capacity')
                        <div class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                    @enderror
                </label>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('rooms.index') }}" class="btn btn-ghost btn-sm">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm">Update Room</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
