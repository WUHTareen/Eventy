<x-guest-layout>
    <div class="mb-8">
        <div class="inline-block px-3 py-1 bg-sky-500/10 border border-sky-500/20 rounded-full mb-4">
            <span class="text-xs font-semibold text-sky-400 uppercase tracking-wider">Email Verification</span>
        </div>
        <h2 class="text-4xl font-bold text-white mb-2">Verify Your Email</h2>
        <p class="text-slate-400 leading-relaxed">
            Thanks for signing up! Before getting started, please verify your email address by clicking the link we sent you. Didn't receive it? We'll gladly send another.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-lg">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-check-circle text-green-400 text-xl"></i>
                <span class="text-sm font-medium text-green-300">
                    A new verification link has been sent to your email address.
                </span>
            </div>
        </div>
    @endif

    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="auth-btn w-full py-3 rounded-lg text-white font-semibold text-sm">
                <i class="fa-solid fa-paper-plane mr-2"></i>
                Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center justify-center w-full py-2.5 rounded-lg border border-slate-700 hover:border-slate-600 hover:bg-slate-800/50 text-slate-400 hover:text-white font-semibold text-sm transition-all">
                <i class="fa-solid fa-right-from-bracket mr-2"></i>
                Log Out
            </button>
        </form>
    </div>
</x-guest-layout>

