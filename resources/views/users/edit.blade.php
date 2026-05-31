<x-layout>
    <x-slot:title>
        Edit User
    </x-slot:title>

    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mt-8">Edit User</h1>

        <div class="card bg-base-100 mt-8">
            <div class="card-body">
                <form method="POST" action="/users/{{ $user->id }}">
                    @csrf
                    @method('PUT')

                    <div class="form-control w-full">
                        <input
                            type="text"
                            name="name"
                            class="input input-bordered w-full @error('name') input-error @enderror"
                            placeholder="Name"
                            value="{{ old('name', $user->name) }}"
                            required
                        >

                        @error('name')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-control w-full mt-4">
                        <input
                            type="email"
                            name="email"
                            class="input input-bordered w-full @error('email') input-error @enderror"
                            placeholder="Email"
                            value="{{ old('email', $user->email) }}"
                            required
                        >

                        @error('email')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="form-control w-full mt-4">
                        <select
                            name="role"
                            class="select select-bordered w-full @error('role') select-error @enderror"
                            required
                        >
                            <option disabled>Select a role</option>

                            @foreach ($roles as $role)
                                <option
                                    value="{{ $role->name }}"
                                    {{ old('role', $user->roles->first()?->name) == $role->name ? 'selected' : '' }}
                                >
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('role')
                            <div class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="card-actions justify-between mt-4">
                        <a href="/users" class="btn btn-ghost btn-sm">
                            Cancel
                        </a>

                        <button type="submit" class="btn btn-primary btn-sm">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>