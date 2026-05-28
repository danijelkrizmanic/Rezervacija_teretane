<x-layout>
    <x-slot:title>
        Edit Termin
    </x-slot:title>

    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mt-8">Edit Termin</h1>

        <div class="card bg-base-100 mt-8">
            <div class="card-body">
                <form method="POST" action="/termins/{{ $termin->id }}">
                    @csrf
                    @method('PUT')

                    <div class="form-control w-full">
                        <select name="room_id" class="select select-bordered w-full @error('room_id') input-error @enderror" required>
                            <option disabled selected>Select a room</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id', $termin->room_id) == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                            @endforeach
                        </select>

                            @error('room_id')
                                <div class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </div>
                            </div>
                        @enderror
                    </div>

                    <div class="form-control w-full mt-4">
                        <input type="text" name="start_time" class="input input-bordered w-full @error('start_time') input-error @enderror"
                            placeholder="Start Time" value="{{ old('start_time', $termin->start_time) }}" required>

                        @error('start_time')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-control w-full mt-4">
                        <input type="text" name="end_time" class="input input-bordered w-full @error('end_time') input-error @enderror"
                            placeholder="End Time" value="{{ old('end_time', $termin->end_time) }}" required>

                        @error('end_time')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-control w-full mt-4">
                        <input type="date" name="date" class="input input-bordered w-full @error('date') input-error @enderror" value="{{ old('date', $termin->date) }}" required>
                        @error('date')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>  
                            </div>
                        @enderror
                    </div>

                    <div class="card-actions justify-between mt-4">
                        <a href="/termins" class="btn btn-ghost btn-sm">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            Update Termin   
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>