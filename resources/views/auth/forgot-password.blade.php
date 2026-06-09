<x-guest-layout>
    <div class="mb-8">
        <div class="inline-block px-3 py-1 bg-sky-500/10 border border-sky-500/20 rounded-full mb-4">
            <span class="text-xs font-semibold text-sky-400 uppercase tracking-wider">Password Reset</span>
        </div>
        <h2 class="text-4xl font-bold text-white mb-2">Forgot Password?</h2>
        <p class="text-slate-400">No problem. Enter your email and we'll send you a reset link.</p>
    </div>

    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div class="space-y-2">
            <label for="email" class="block text-sm font-medium text-slate-300">Email Address</label>
            <input id="email" class="auth-input w-full rounded-lg py-2.5 px-4 text-white text-sm" type="email" name="email" :value="old('email')" required autofocus placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <button type="submit" class="auth-btn w-full py-3 rounded-lg text-white font-semibold text-sm">
            Send Reset Link
        </button>

        <div class="pt-3">
            <a href="{{ route('login') }}" class="flex items-center justify-center w-full py-2.5 rounded-lg border border-slate-700 hover:border-sky-500/50 hover:bg-sky-500/5 text-slate-300 hover:text-white font-semibold text-sm transition-all">
                <i class="fa-solid fa-arrow-left mr-2 text-xs"></i>
                Back to Login
            </a>
        </div>
    </form>
</x-guest-layout>

