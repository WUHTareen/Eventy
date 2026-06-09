<x-guest-layout>
    <div class="mb-8">
        <div class="inline-block px-3 py-1 bg-amber-500/10 border border-amber-500/20 rounded-full mb-4">
            <span class="text-xs font-semibold text-amber-400 uppercase tracking-wider">Secure Area</span>
        </div>
        <h2 class="text-4xl font-bold text-white mb-2">Confirm Password</h2>
        <p class="text-slate-400">This is a secure area. Please confirm your password before continuing.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <!-- Password -->
        <div class="space-y-2">
            <label for="password" class="block text-sm font-medium text-slate-300">Password</label>
            <div class="relative">
                <input id="password" class="auth-input w-full rounded-lg py-2.5 px-4 pr-10 text-white text-sm" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
                <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white">
                    <i class="fa-solid fa-eye text-sm" id="toggleIcon"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <button type="submit" class="auth-btn w-full py-3 rounded-lg text-white font-semibold text-sm" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);">
            <i class="fa-solid fa-shield-halved mr-2"></i>
            Confirm
        </button>
    </form>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</x-guest-layout>

