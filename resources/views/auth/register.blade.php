<x-guest-layout :maxWidth="'md'">
    <div class="w-full">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-black text-white mb-1 tracking-tighter uppercase">Create Account</h2>
            <p class="text-slate-400 font-medium text-xs opacity-70">Sign up to get started.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="label-text">Full Name</label>
                <div class="relative group">
                    <i class="fa-solid fa-user input-icon"></i>
                    <input id="name" class="input-dark" type="text" name="name" :value="old('name')" required autofocus placeholder="Your Full Name" />
                </div>
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="label-text">Email Address</label>
                <div class="relative group">
                    <i class="fa-solid fa-envelope input-icon"></i>
                    <input id="email" class="input-dark" type="email" name="email" :value="old('email')" required placeholder="email@example.com" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Password -->
                <div>
                    <label for="password" class="label-text">Password</label>
                    <div class="relative group">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input id="password" class="input-dark" type="password" name="password" required placeholder="••••••••" />
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="label-text">Confirm Password</label>
                    <div class="relative group">
                        <i class="fa-solid fa-shield-halved input-icon"></i>
                        <input id="password_confirmation" class="input-dark" type="password" name="password_confirmation" required placeholder="••••••••" />
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-primary" style="background: linear-gradient(to right, #6366f1, #4f46e5); box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.2);">
                    Create Account
                </button>
            </div>

            <div class="pt-4 border-t border-white/5 text-center">
                <a href="{{ route('login') }}" class="text-[10px] font-black text-white hover:text-indigo-400 uppercase tracking-widest transition-all">
                    Already have an account? Log In
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
