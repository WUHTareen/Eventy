<x-guest-layout :maxWidth="'md'">
    <div class="w-full">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-black text-white mb-1 tracking-tighter uppercase">Security Access</h2>
            <p class="text-slate-300 font-medium text-xs">Initialize authorized terminal session.</p> <!-- Brightened Description -->
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <!-- Email Address -->
            <div>
                <label for="email" class="label-text">Access Identifier</label>
                <div class="relative group">
                    <i class="fa-solid fa-envelope input-icon"></i>
                    <input id="email" class="input-dark" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="email@enterprise.com" />
                </div>
            </div>

            <!-- Password -->
            <div>
                <div class="flex justify-between mb-1">
                    <label for="password" class="label-text mb-0">Security Code</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-[8px] font-black text-[#ED1C24] uppercase tracking-widest hover:text-white transition-all">Token recovery?</a>
                    @endif
                </div>
                <div class="relative group" x-data="{ show: false }">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input :type="show ? 'text' : 'password'" id="password" class="input-dark pr-10" name="password" required placeholder="••••••••" />
                    <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 hover:text-white transition-colors">
                        <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    <div class="relative flex items-center justify-center">
                        <input id="remember_me" type="checkbox" class="peer h-4 w-4 appearance-none rounded border border-slate-700 bg-slate-900 checked:border-[#ED1C24] checked:bg-[#ED1C24] focus:ring-0 focus:ring-offset-0 transition-all cursor-pointer" name="remember">
                        <i class="fa-solid fa-check absolute scale-0 peer-checked:scale-100 text-white text-[10px] pointer-events-none transition-transform"></i>
                    </div>
                    <span class="ms-3 text-[11px] font-bold text-slate-300 uppercase tracking-widest group-hover:text-white transition-all">Stay Logged In</span>
                </label>
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-primary">
                    Authorize Entry
                </button>
            </div>

            <!-- Protocols -->
            <div class="pt-6 border-t border-white/5">
                <p class="text-[9px] text-center font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Initialize Portal Access</p>
                <div class="grid grid-cols-3 gap-3">
                    <a href="{{ route('register') }}" class="group flex flex-col items-center justify-center p-3 rounded-xl border border-white/5 bg-white/[0.02] hover:bg-white/[0.08] hover:border-indigo-500/30 transition-all duration-300">
                        <i class="fa-solid fa-user-shield text-indigo-400 text-sm mb-2 group-hover:scale-110 transition-transform"></i>
                        <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest group-hover:text-white">Client</span>
                    </a>
                    <a href="{{ route('vendor.register') }}" class="group flex flex-col items-center justify-center p-3 rounded-xl border border-white/5 bg-white/[0.02] hover:bg-white/[0.08] hover:border-cyan-500/30 transition-all duration-300">
                        <i class="fa-solid fa-store text-cyan-400 text-sm mb-2 group-hover:scale-110 transition-transform"></i>
                        <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest group-hover:text-white">Vendor</span>
                    </a>
                    <a href="{{ route('corporate.register') }}" class="group flex flex-col items-center justify-center p-3 rounded-xl border border-white/5 bg-white/[0.02] hover:bg-white/[0.08] hover:border-amber-500/30 transition-all duration-300">
                        <i class="fa-solid fa-building-columns text-amber-400 text-sm mb-2 group-hover:scale-110 transition-transform"></i>
                        <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest group-hover:text-white">Corp</span>
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>
