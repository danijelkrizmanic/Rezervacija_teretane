<x-layout>
    <x-slot:title>
        Register
    </x-slot:title>

    <div class="mx-auto grid min-h-[calc(100vh-13rem)] max-w-5xl items-center gap-8 lg:grid-cols-[1fr_420px]">
        <div class="hidden lg:block">
            <p class="text-sm font-semibold uppercase text-primary">Start reserving</p>
            <h1 class="mt-3 text-4xl font-extrabold leading-tight">Create a member account and book your next session.</h1>
            <p class="mt-4 text-lg text-base-content/70">New accounts start with the User role so reservations stay focused and protected from admin-only areas.</p>
        </div>

        <div class="rounded-lg border border-base-300 bg-base-100 p-6 shadow-sm">
            <h2 class="text-2xl font-bold">Create Account</h2>

            <form method="POST" action="{{ url('/register') }}" class="mt-6 space-y-4">
                @csrf

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text font-medium">Name</span>
                    </div>
                    <input type="text" name="name" value="{{ old('name') }}" class="input input-bordered w-full bg-base-100 @error('name') input-error @enderror" required>
                    @error('name')
                        <div class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </div>
                    @enderror
                </label>

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text font-medium">Email</span>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" class="input input-bordered w-full bg-base-100 @error('email') input-error @enderror" required>
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

                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text font-medium">Confirm password</span>
                    </div>
                    <input type="password" name="password_confirmation" class="input input-bordered w-full bg-base-100" required>
                </label>

                <button type="submit" class="btn btn-primary w-full">Register</button>
            </form>

            <div class="divider">OR</div>
            <p class="text-center text-sm">
                Already have an account?
                <a href="{{ url('/login') }}" class="link link-primary">Sign in</a>
            </p>
        </div>
    </div>
</x-layout>
