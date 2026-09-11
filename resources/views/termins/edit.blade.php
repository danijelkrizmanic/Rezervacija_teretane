<x-layout>
    <x-slot:title>
        Edit Termin
    </x-slot:title>

    <div class="mx-auto max-w-2xl space-y-6">
        <div>
            <p class="text-sm font-semibold uppercase text-primary">Schedule</p>
            <h1 class="text-3xl font-bold">Edit Termin</h1>
        </div>

        <div class="rounded-lg border border-base-300 bg-base-100 p-6 shadow-sm">
            <form method="POST" action="{{ route('termins.update', $termin) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <x-form.select-input label="Room" name="room_id" placeholder="Select a room" required>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id', $termin->room_id) == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                    @endforeach
                </x-form.select-input>

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text font-medium">Start time</span>
                    </div>
                    <input type="time" name="start_time" class="input input-bordered w-full bg-base-100 @error('start_time') input-error @enderror" value="{{ old('start_time', substr($termin->start_time, 0, 5)) }}" required>
                    @error('start_time')
                        <div class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                    @enderror
                </label>

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text font-medium">End time</span>
                    </div>
                    <input type="time" name="end_time" class="input input-bordered w-full bg-base-100 @error('end_time') input-error @enderror" value="{{ old('end_time', substr($termin->end_time, 0, 5)) }}" required>
                    @error('end_time')
                        <div class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                    @enderror
                </label>

                <x-form.date-input label="Date" name="date" :value="$termin->date" required />

                @isset($trainers)
                    <x-form.select-input label="Trainer" name="trainer_id" placeholder="Select a trainer" required>
                        @foreach ($trainers as $trainer)
                            <option value="{{ $trainer->id }}" {{ old('trainer_id', $termin->user_id) == $trainer->id ? 'selected' : '' }}>{{ $trainer->name }}</option>
                        @endforeach
                    </x-form.select-input>
                @endisset

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('termins.index') }}" class="btn btn-ghost btn-sm">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm">Update Termin</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
