<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Testimonial') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $testimonial->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Role -->
                        <div class="mb-4">
                            <x-input-label for="role" :value="__('Role / Location')" />
                            <x-text-input id="role" class="block mt-1 w-full" type="text" name="role" :value="old('role', $testimonial->role)" required />
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <!-- Quote -->
                        <div class="mb-4">
                            <x-input-label for="quote" :value="__('Quote')" />
                            <textarea id="quote" name="quote" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" required>{{ old('quote', $testimonial->quote) }}</textarea>
                            <x-input-error :messages="$errors->get('quote')" class="mt-2" />
                        </div>

                        <!-- Stars -->
                        <div class="mb-4">
                            <x-input-label for="stars" :value="__('Stars (1-5)')" />
                            <x-text-input id="stars" class="block mt-1 w-full" type="number" name="stars" :value="old('stars', $testimonial->stars)" min="1" max="5" required />
                            <x-input-error :messages="$errors->get('stars')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.testimonials.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <x-primary-button>
                                {{ __('Update Testimonial') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


