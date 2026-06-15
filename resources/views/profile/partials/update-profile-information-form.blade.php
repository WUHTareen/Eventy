<section x-data="{ 
    submitting: false,
    avatarPreview: '{{ Auth::user()->getAvatarUrl() }}',
    handleAvatarChange(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.avatarPreview = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
}">
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-8" @submit="submitting = true">
        @csrf
        @method('patch')

        <!-- Avatar Uploader -->
        <div class="flex items-center gap-8">
            <div class="relative group cursor-pointer">
                <div class="w-32 h-32 rounded-[2rem] overflow-hidden border-4 border-white shadow-2xl relative">
                    <img :src="avatarPreview" class="w-full h-full object-cover bg-gray-100" />
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white">
                        <i class="fa-solid fa-camera text-2xl mb-1"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest">Change</span>
                    </div>
                </div>
                <input type="file" name="avatar" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" @change="handleAvatarChange($event)">
                <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-primary-500 rounded-2xl flex items-center justify-center text-white shadow-lg pointer-events-none group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                </div>
            </div>
            <div class="flex-1">
                <h4 class="text-xl font-bold text-gray-900 mb-1">Profile Photo</h4>
                <p class="text-gray-500 text-sm leading-relaxed">Upload a clear photo of yourself. Preferred formats are JPG, PNG or WEBP up to 2MB.</p>
                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div class="space-y-2">
                <x-input-label for="name" :value="__('Full Name')" class="font-bold text-gray-700 tracking-tight" />
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none group-focus-within:text-primary-500 transition-colors">
                        <i class="fa-solid fa-signature"></i>
                    </div>
                    <x-text-input id="name" name="name" type="text" class="block w-full pl-11 py-4 bg-gray-50 border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary-500 focus:bg-white transition-all shadow-sm group-hover:border-gray-300" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Email -->
            <div class="space-y-2">
                <x-input-label for="email" :value="__('Email Address')" class="font-bold text-gray-700 tracking-tight" />
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none group-focus-within:text-primary-500 transition-colors">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <x-text-input id="email" name="email" type="email" class="block w-full pl-11 py-4 bg-gray-50 border-gray-100 rounded-2xl focus:ring-2 focus:ring-primary-500 focus:bg-white transition-all shadow-sm group-hover:border-gray-300" :value="old('email', $user->email)" required autocomplete="username" />
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-3 p-4 bg-yellow-50 border border-yellow-100 rounded-2xl">
                        <p class="text-xs text-yellow-800 font-medium">
                            <i class="fa-solid fa-triangle-exclamation mr-1.5 animate-pulse"></i> Email unverified.
                            <button form="send-verification" class="ml-2 underline text-yellow-700 hover:text-yellow-900 font-black uppercase tracking-tighter">Resend</button>
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-4 pt-6 mt-4 border-t border-gray-100">
            <button type="submit" :disabled="submitting" 
                    class="bg-gradient-to-r from-primary-600 to-indigo-600 hover:from-primary-700 hover:to-indigo-700 text-white font-black py-4 px-10 rounded-2xl shadow-xl shadow-primary-500/20 transition-all transform hover:-translate-y-1 active:scale-95 disabled:opacity-70 disabled:pointer-events-none flex items-center gap-2">
                <span x-show="!submitting">Save Changes <i class="fa-solid fa-save ml-1"></i></span>
                <span x-show="submitting">Saving... <i class="fa-solid fa-circle-notch animate-spin ml-1"></i></span>
            </button>
        </div>
    </form>
</section>

