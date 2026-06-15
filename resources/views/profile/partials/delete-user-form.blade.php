<section class="space-y-6">
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-700 py-3 px-6 rounded-xl font-bold"
    ><i class="fa-solid fa-trash mr-2"></i> {{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6" x-data="{ deleting: false }" @submit="deleting = true">
            @csrf
            @method('delete')

            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-triangle-exclamation text-red-600 text-3xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>
            </div>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-lock text-gray-400"></i>
                    </div>
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="block w-full pl-11 py-3 bg-gray-50 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:bg-white transition-all"
                        placeholder="{{ __('Enter your password') }}"
                    />
                </div>

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="py-3 px-6 rounded-xl" x-bind:disabled="deleting">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="bg-red-600 hover:bg-red-700 py-3 px-6 rounded-xl font-bold" x-bind:disabled="deleting">
                    <span x-show="!deleting"><i class="fa-solid fa-trash mr-2"></i> {{ __('Delete Account') }}</span>
                    <span x-show="deleting">Processing... <i class="fa-solid fa-circle-notch animate-spin ml-1"></i></span>
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>


