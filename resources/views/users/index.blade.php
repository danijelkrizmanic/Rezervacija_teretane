<x-layout>
    <x-slot:title>
        Users
    </x-slot:title>

    <div class="space-y-8">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase text-primary">Administration</p>
                <h1 class="text-3xl font-bold">Users</h1>
                <p class="mt-2 text-base-content/70">Assign roles and keep application access aligned with responsibilities.</p>
            </div>
            <div class="stats w-full border border-base-300 bg-base-100 shadow-sm sm:w-auto">
                <div class="stat">
                    <div class="stat-title">Accounts</div>
                    <div class="stat-value text-2xl">{{ $users->count() }}</div>
                </div>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($users as $user)
                <div class="card border border-base-300 bg-base-100 shadow-sm">
                    <div class="card-body gap-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="card-title">{{ $user->name }}</h2>
                                <p class="text-sm text-base-content/60">{{ $user->email }}</p>
                            </div>
                            <span class="badge badge-primary badge-outline">#{{ $user->id }}</span>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            @forelse ($user->roles as $role)
                                <span class="badge badge-neutral">{{ ucfirst($role->name) }}</span>
                            @empty
                                <span class="badge badge-warning">No role</span>
                            @endforelse
                        </div>

                        @can('update', $user)
                            <div class="card-actions justify-end">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-ghost btn-xs">Edit Role</a>
                            </div>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="rounded-lg border border-dashed border-base-300 bg-base-100 p-8 text-center md:col-span-2 xl:col-span-3">
                    <h2 class="text-lg font-semibold">No users found</h2>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>
