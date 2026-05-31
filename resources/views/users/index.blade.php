<x-layout>
    <x-slot:title>
        Users
    </x-slot:title>

    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mt-8">All Users</h1>

        <div class="space-y-4 mt-8">
            @forelse($users as $user)
                <div class="card bg-base-100 shadow">
                    <div class="card-body">

                        @can('update', $user)
                        <div class="flex gap-1">
                            <a href="/users/{{ $user->id }}/edit" class="btn btn-ghost btn-xs">
                                Edit
                            </a>
                            <form method="POST" action="/users/{{ $user->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this user?')"
                                    class="btn btn-ghost btn-xs text-error">
                                    Delete
                                </button>
                            </form>
                        </div>
                        @endcan

                        <h2 class="card-title">{{ $user->name }}</h2>

                        <div>
                            <strong>ID:</strong> {{ $user->id }}
                        </div>

                        <div>
                            <strong>Email:</strong> {{ $user->email }}
                        </div>

                        <div>
                            <strong>Roles:</strong>
                            @forelse($user->roles as $role)
                                <span class="badge badge-primary">
                                    {{ $role->name }}
                                </span>
                            @empty
                                <span>No role assigned</span>
                            @endforelse
                        </div>

                    </div>
                </div>
            @empty
                <p>No users found.</p>
            @endforelse
        </div>
    </div>
</x-layout>