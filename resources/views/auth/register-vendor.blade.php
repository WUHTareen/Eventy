<x-guest-layout :maxWidth="'lg'">
    <div class="w-full">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-black text-white mb-1 tracking-tighter uppercase">Vendor Signup</h2>
            <p class="text-slate-400 font-medium text-xs opacity-70">Register your business to start selling.</p>
        </div>

        <form method="POST" action="{{ route('vendor.register.store') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Business Name -->
                <div>
                    <label for="name" class="label-text">Business Name</label>
                    <div class="relative group">
                        <i class="fa-solid fa-briefcase input-icon"></i>
                        <input id="name" class="input-dark" type="text" name="name" :value="old('name')" required autofocus placeholder="Your Business Name" />
                    </div>
                </div>

                <!-- Operating Hub -->
                <div>
                    <label for="city_id" class="label-text">City</label>
                    <div class="relative group">
                        <i class="fa-solid fa-location-dot input-icon"></i>
                        <select id="city_id" name="city_id" class="input-dark appearance-none">
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" class="bg-gray-900">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Category -->
                <div>
                    <label for="category_id" class="label-text">Service Category</label>
                    <div class="relative group">
                        <i class="fa-solid fa-layer-group input-icon"></i>
                        <select id="category_id" name="category_id" class="input-dark appearance-none">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" class="bg-gray-900">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Registry Email -->
                <div>
                    <label for="email" class="label-text">Email Address</label>
                    <div class="relative group">
                        <i class="fa-solid fa-envelope input-icon"></i>
                        <input id="email" class="input-dark" type="email" name="email" :value="old('email')" required placeholder="vendor@supply.com" />
                    </div>
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

                <!-- Verify PIN -->
                <div>
                    <label for="password_confirmation" class="label-text">Confirm Password</label>
                    <div class="relative group">
                        <i class="fa-solid fa-shield-halved input-icon"></i>
                        <input id="password_confirmation" class="input-dark" type="password" name="password_confirmation" required placeholder="••••••••" />
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-primary" style="background: linear-gradient(to right, #06b6d4, #0891b2); box-shadow: 0 10px 15px -3px rgba(6, 182, 212, 0.2);">
                    Register Business
                </button>
            </div>

            <div class="pt-4 text-center grid grid-cols-2 gap-3 border-t border-white/5">
                <a href="{{ route('login') }}" class="py-2 border border-white/5 rounded-lg text-[9px] font-black text-white hover:text-cyan-400 uppercase tracking-widest transition-all bg-white/[0.01]">Login</a>
                <a href="{{ route('register') }}" class="py-2 border border-white/5 rounded-lg text-[9px] font-black text-white hover:text-indigo-400 uppercase tracking-widest transition-all bg-white/[0.01]">Client Sign Up</a>
            </div>
        </form>
    </div>
</x-guest-layout>
