<x-guest-layout :maxWidth="'lg'">
    <div class="w-full">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-black text-white mb-1 tracking-tighter uppercase">Corporate Signup</h2>
            <p class="text-slate-300 font-medium text-xs">Register your company for corporate access.</p> <!-- Brightened Description -->
        </div>

        <form method="POST" action="{{ route('corporate.register.store') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Company Name -->
                <div>
                    <label for="name" class="label-text">Company Name</label>
                    <div class="relative group">
                        <i class="fa-solid fa-building input-icon"></i>
                        <input id="name" class="input-dark" type="text" name="name" :value="old('name')" required autofocus placeholder="Registered Company Name" />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <!-- NTN Number -->
                <div>
                    <label for="ntn_number" class="label-text">NTN Number</label>
                    <div class="relative group">
                        <i class="fa-solid fa-file-invoice input-icon"></i>
                        <input id="ntn_number" class="input-dark" type="text" name="ntn_number" :value="old('ntn_number')" required placeholder="7-Digit NTN" />
                    </div>
                </div>
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="label-text">Email Address</label>
                <div class="relative group">
                    <i class="fa-solid fa-envelope input-icon"></i>
                    <input id="email" class="input-dark" type="email" name="email" :value="old('email')" required placeholder="ops@enterprise.com" />
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
                <button type="submit" class="btn-primary">
                    Create Account
                </button>
            </div>

            <div class="pt-4 border-t border-white/5 text-center">
                <a href="{{ route('login') }}" class="text-[10px] font-black text-white hover:text-[#ED1C24] uppercase tracking-widest transition-all">
                    Already have an account? Log In
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
