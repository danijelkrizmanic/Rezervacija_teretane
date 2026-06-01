<x-layout>
    <x-slot:title>
        Edit User
    </x-slot:title>

    <div class="mx-auto max-w-2xl space-y-6">
        <div>
            <p class="text-sm font-semibold uppercase text-primary">Administration</p>
            <h1 class="text-3xl font-bold">Edit User</h1>
            <p class="mt-2 text-base-content/70">{{ $user->name }} · {{ $user->email }}</p>
        </div>

        <div class="rounded-lg border border-base-300 bg-base-100 p-6 shadow-sm">
            <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text font-medium">Name</span>
                    </div>
                    <input type="text" class="input input-bordered w-full bg-base-200" value="{{ $user->name }}" disabled>
                </label>

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text font-medium">Email</span>
                    </div>
                    <input type="email" class="input input-bordered w-full bg-base-200" value="{{ $user->email }}" disabled>
                </label>

                <x-form.select-input label="Role" name="role" placeholder="Select a role" required>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role', $user->roles->first()?->name) == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </x-form.select-input>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('users.index') }}" class="btn btn-ghost btn-sm">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-sm">Update User</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
