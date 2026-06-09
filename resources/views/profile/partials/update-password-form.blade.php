<section x-data="{ submitting: false }">
    <form method="post" action="{{ route('password.update') }}" class="space-y-6" @submit="submitting = true">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Current Password -->
            <div class="space-y-2">
                <x-input-label for="update_password_current_password" :value="__('Current Password')" class="font-bold text-gray-700 tracking-tight" />
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none group-focus-within:text-yellow-500 transition-colors">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <x-text-input id="update_password_current_password" name="current_password" type="password" class="block w-full pl-11 py-4 bg-gray-50 border-gray-100 rounded-2xl focus:ring-2 focus:ring-yellow-500 focus:bg-white transition-all shadow-sm group-hover:border-gray-300" autocomplete="current-password" placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <!-- New Password -->
            <div class="space-y-2">
                <x-input-label for="update_password_password" :value="__('New Password')" class="font-bold text-gray-700 tracking-tight" />
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none group-focus-within:text-indigo-500 transition-colors">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <x-text-input id="update_password_password" name="password" type="password" class="block w-full pl-11 py-4 bg-gray-50 border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all shadow-sm group-hover:border-gray-300" autocomplete="new-password" placeholder="Min. 8 characters" />
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <x-input-label for="update_password_password_confirmation" :value="__('Confirm New Password')" class="font-bold text-gray-700 tracking-tight" />
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none group-focus-within:text-indigo-500 transition-colors">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full pl-11 py-4 bg-gray-50 border-gray-100 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all shadow-sm group-hover:border-gray-300" autocomplete="new-password" />
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-6 mt-4 border-t border-gray-100">
            <button type="submit" :disabled="submitting" 
                    class="bg-gradient-to-r from-yellow-600 to-orange-600 hover:from-yellow-700 hover:to-orange-700 text-white font-black py-4 px-10 rounded-2xl shadow-xl shadow-yellow-500/10 transition-all transform hover:-translate-y-1 active:scale-95 disabled:opacity-70 disabled:pointer-events-none flex items-center gap-2">
                <span x-show="!submitting">Save Password <i class="fa-solid fa-save ml-1"></i></span>
                <span x-show="submitting">Updating... <i class="fa-solid fa-circle-notch animate-spin ml-1"></i></span>
            </button>
        </div>
    </form>
</section>

