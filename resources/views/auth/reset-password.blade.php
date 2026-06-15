<x-guest-layout>
    <div class="mb-8">
        <div class="inline-block px-3 py-1 bg-sky-500/10 border border-sky-500/20 rounded-full mb-4">
            <span class="text-xs font-semibold text-sky-400 uppercase tracking-wider">Reset Password</span>
        </div>
        <h2 class="text-4xl font-bold text-white mb-2">Create New Password</h2>
        <p class="text-slate-400">Enter your new password below</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <div class="space-y-2">
            <label for="email" class="block text-sm font-medium text-slate-300">Email Address</label>
            <input id="email" class="auth-input w-full rounded-lg py-2.5 px-4 text-white text-sm" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <!-- Password -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-slate-300">New Password</label>
                <input id="password" class="auth-input w-full rounded-lg py-2.5 px-4 text-white text-sm" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <label for="password_confirmation" class="block text-sm font-medium text-slate-300">Confirm Password</label>
                <input id="password_confirmation" class="auth-input w-full rounded-lg py-2.5 px-4 text-white text-sm" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>
        </div>

        <button type="submit" class="auth-btn w-full py-3 rounded-lg text-white font-semibold text-sm">
            Reset Password
        </button>

        <div class="pt-3">
            <a href="{{ route('login') }}" class="flex items-center justify-center w-full py-2.5 rounded-lg border border-slate-700 hover:border-sky-500/50 hover:bg-sky-500/5 text-slate-300 hover:text-white font-semibold text-sm transition-all">
                Back to Login
            </a>
        </div>
    </form>
</x-guest-layout>

