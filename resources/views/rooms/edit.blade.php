<x-layout>
    <x-slot:title>
        Edit Room
    </x-slot:title>

    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mt-8">Edit Room</h1>

        <div class="card bg-base-100 mt-8">
            <div class="card-body">
                <form method="POST" action="/rooms/{{ $room->id }}">
                    @csrf
                    @method('PUT')

                    <div class="form-control w-full">
                        <input type="text" name="name" class="input input-bordered w-full @error('name') input-error @enderror"
                            placeholder="Room Name" value="{{ old('name', $room->name) }}" required>

                        @error('name')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-control w-full mt-4">
                        <input type="number" name="max_capacity" class="input input-bordered w-full @error('max_capacity') input-error @enderror"
                            placeholder="Maximum Capacity" value="{{ old('max_capacity', $room->max_capacity) }}" required>

                        @error('max_capacity')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="card-actions justify-between mt-4">
                        <a href="/rooms" class="btn btn-ghost btn-sm">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            Update Room
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>