<x-layout>
    <x-slot:title>
        Sign In
    </x-slot:title>

    <div class="mx-auto grid min-h-[calc(100vh-13rem)] max-w-5xl items-center gap-8 lg:grid-cols-[1fr_420px]">
        <div class="hidden lg:block">
            <p class="text-sm font-semibold uppercase text-primary">Welcome back</p>
            <h1 class="mt-3 text-4xl font-extrabold leading-tight">Pick up the schedule exactly where you left it.</h1>
            <p class="mt-4 text-lg text-base-content/70">Sign in to manage rooms, termins, users, or your personal reservations based on your assigned role.</p>
        </div>

        <div class="rounded-lg border border-base-300 bg-base-100 p-6 shadow-sm">
            <h2 class="text-2xl font-bold">Sign In</h2>

            <form method="POST" action="{{ url('/login') }}" class="mt-6 space-y-4">
                @csrf

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text font-medium">Email</span>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" class="input input-bordered w-full bg-base-100 @error('email') input-error @enderror" required autofocus>
                    @error('email')
                        <div class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                    @enderror
                </label>

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text font-medium">Password</span>
                    </div>
                    <input type="password" name="password" class="input input-bordered w-full bg-base-100 @error('password') input-error @enderror" required>
                    @error('password')
                        <div class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                    @enderror
                </label>

                <label class="label cursor-pointer justify-start gap-3">
                    <input type="checkbox" name="remember" class="checkbox checkbox-primary">
                    <span class="label-text">Remember me</span>
                </label>

                <button type="submit" class="btn btn-primary w-full">Sign In</button>
            </form>

            <div class="divider">OR</div>
            <p class="text-center text-sm">
                Don't have an account?
                <a href="{{ url('/register') }}" class="link link-primary">Register</a>
            </p>
        </div>
    </div>
</x-layout>
