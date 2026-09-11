@php
    $navItems = [];

    if (auth()->check()) {
        $user = auth()->user();

        if ($user->hasAnyRole(['user', 'trainer', 'admin'])) {
            $navItems[] = ['label' => 'Termins', 'route' => 'termins.index', 'active' => 'termins.*'];
        }

        if ($user->hasRole('user')) {
            $navItems[] = ['label' => 'My Reservations', 'route' => 'reservations.index', 'active' => 'reservations.index'];
        }

        if ($user->hasAnyRole(['trainer', 'admin'])) {
            $navItems[] = ['label' => 'Rooms', 'route' => 'rooms.index', 'active' => 'rooms.*'];
        }

        if ($user->hasRole('admin')) {
            $navItems[] = ['label' => 'Users', 'route' => 'users.index', 'active' => 'users.*'];
        }
    }
@endphp

<header class="sticky top-0 z-50 border-b border-base-300/80 bg-base-100/95 shadow-sm backdrop-blur">
    <div class="navbar mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="navbar-start">
            @auth
                <div class="dropdown lg:hidden">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-square" aria-label="Open navigation">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </div>
                    <ul tabindex="0" class="menu dropdown-content z-50 mt-3 w-56 rounded-box border border-base-300 bg-base-100 p-2 shadow-xl">
                        @foreach ($navItems as $item)
                            <li>
                                <a href="{{ route($item['route']) }}" @class([
                                    'font-medium',
                                    'bg-primary text-primary-content hover:bg-primary hover:text-primary-content' => request()->routeIs($item['active']),
                                ])>
                                    {{ $item['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endauth

            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <span class="grid size-10 place-items-center rounded-lg bg-primary text-lg font-black text-primary-content">GR</span>
                <span class="hidden text-lg font-bold sm:inline">{{ config('app.name', 'Gym Reserve') }}</span>
            </a>
        </div>

        @auth
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal gap-1 px-1">
                    @foreach ($navItems as $item)
                        <li>
                            <a href="{{ route($item['route']) }}" @class([
                                'font-semibold',
                                'bg-primary text-primary-content hover:bg-primary hover:text-primary-content' => request()->routeIs($item['active']),
                            ])>
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endauth

        <div class="navbar-end gap-2">
            @auth
                <div class="hidden text-right sm:block">
                    <div class="text-sm font-semibold">{{ auth()->user()->name }}</div>
                    <div class="text-xs uppercase text-base-content/50">{{ auth()->user()->roles->first()?->name ?? 'user' }}</div>
                </div>
                <form method="POST" action="{{ url('/logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-sm">Logout</button>
                </form>
            @else
                <a href="{{ url('/login') }}" class="btn btn-ghost btn-sm">Sign In</a>
                <a href="{{ url('/register') }}" class="btn btn-primary btn-sm">Sign Up</a>
            @endauth
        </div>
    </div>
</header>
