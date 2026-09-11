<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="emerald">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name', 'Gym Reserve') : config('app.name', 'Gym Reserve') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-base-200 font-sans text-base-content antialiased">
    <div class="flex min-h-screen flex-col">
        <x-navigation />

        @if (session('success') || session('error'))
            <div class="toast toast-top toast-center top-20 z-30 pointer-events-none">
                <div class="alert {{ session('success') ? 'alert-success' : 'alert-error' }} pointer-events-auto animate-fade-out shadow-lg">
                    <span>{{ session('success') ?? session('error') }}</span>
                </div>
            </div>
        @endif

        <main class="flex-1 {{ ($fullWidth ?? false) ? '' : 'mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8' }}">
            {{ $slot }}
        </main>

        <footer class="border-t border-base-300 bg-base-100">
            <div class="mx-auto flex w-full max-w-7xl flex-col gap-3 px-4 py-6 text-sm text-base-content/60 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <span>{{ config('app.name', 'Gym Reserve') }}</span>
                <span>Plan sessions, rooms, and reservations with less friction.</span>
            </div>
        </footer>
    </div>
</body>

</html>
