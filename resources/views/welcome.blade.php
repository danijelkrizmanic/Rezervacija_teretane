<x-layout :full-width="true">
    <x-slot:title>
        Reserve Smarter
    </x-slot:title>

    <section class="relative min-h-[calc(100vh-4.5rem)] overflow-hidden bg-neutral text-neutral-content">
        <img
            src="{{ asset('images/gym-hero.png') }}"
            alt="Modern fitness studio prepared for reserved training sessions"
            class="absolute inset-0 h-full w-full object-cover"
        >
        <div class="absolute inset-0 bg-linear-to-r from-neutral via-neutral/82 to-neutral/12"></div>

        <div class="relative mx-auto flex min-h-[calc(100vh-4.5rem)] w-full max-w-7xl items-center px-4 py-16 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                <div class="badge badge-primary badge-lg mb-5">Gym reservation platform</div>
                <h1 class="text-4xl font-extrabold leading-tight sm:text-5xl lg:text-6xl">
                    Book rooms, manage termins, and keep every session moving.
                </h1>
                <p class="mt-6 max-w-xl text-lg leading-8 text-neutral-content/80">
                    A clean scheduling workspace for members, trainers, and admins who need fast reservations, clear capacity, and role-aware access.
                </p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    @auth
                        <a href="{{ route('termins.index') }}" class="btn btn-primary">Open Schedule</a>
                    @else
                        <a href="{{ url('/register') }}" class="btn btn-primary">Create Account</a>
                        <a href="{{ url('/login') }}" class="btn btn-outline border-neutral-content/40 text-neutral-content hover:border-primary hover:bg-primary">Sign In</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <section class="bg-base-100 px-4 py-14 sm:px-6 lg:px-8">
        <div class="mx-auto grid max-w-7xl gap-4 md:grid-cols-3">
            <div class="rounded-lg border border-base-300 bg-base-100 p-6">
                <div class="text-sm font-semibold uppercase text-primary">Members</div>
                <h2 class="mt-2 text-xl font-bold">Reserve without guesswork</h2>
                <p class="mt-3 text-base-content/70">Browse available termins, check capacity, and manage personal reservations from a simple card view.</p>
            </div>
            <div class="rounded-lg border border-base-300 bg-base-100 p-6">
                <div class="text-sm font-semibold uppercase text-primary">Trainers</div>
                <h2 class="mt-2 text-xl font-bold">Own the training calendar</h2>
                <p class="mt-3 text-base-content/70">Create room-based sessions and review attendance for your scheduled termins.</p>
            </div>
            <div class="rounded-lg border border-base-300 bg-base-100 p-6">
                <div class="text-sm font-semibold uppercase text-primary">Admins</div>
                <h2 class="mt-2 text-xl font-bold">Control access and capacity</h2>
                <p class="mt-3 text-base-content/70">Manage users, rooms, trainers, and system-wide scheduling rules from one responsive interface.</p>
            </div>
        </div>
    </section>
</x-layout>
