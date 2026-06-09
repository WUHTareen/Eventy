<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                <i class="fa-solid fa-plus-circle text-indigo-600 mr-2"></i>{{ __('Add New Category') }}
            </h2>
            <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-gray-700 font-medium flex items-center gap-2 transition-colors">
                <i class="fa-solid fa-arrow-left"></i> Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-tags text-indigo-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">New Category Details</h3>
                        <p class="text-gray-500 mt-1">Define a new service category for vendors</p>
                    </div>

                    <form method="POST" action="{{ route('admin.categories.store') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-6">
                            <x-input-label for="name" :value="__('Category Name')" class="font-bold text-gray-700 mb-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-tag text-gray-400"></i>
                                </div>
                                <x-text-input id="name" class="block w-full pl-12 py-3.5 bg-gray-50 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all" type="text" name="name" :value="old('name')" required autofocus placeholder="e.g. Photography" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Icon -->
                        <div class="mb-6">
                            <x-input-label for="icon" :value="__('Icon Class (FontAwesome)')" class="font-bold text-gray-700 mb-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-icons text-gray-400"></i>
                                </div>
                                <x-text-input id="icon" class="block w-full pl-12 py-3.5 bg-gray-50 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all" type="text" name="icon" :value="old('icon')" placeholder="e.g. fa-solid fa-camera" />
                            </div>
                            <p class="text-xs text-gray-500 mt-1 ml-1">Use free FontAwesome class names.</p>
                            <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <x-primary-button class="w-full justify-center bg-indigo-600 hover:bg-indigo-700 py-3.5 rounded-xl font-bold text-base shadow-lg shadow-indigo-500/30">
                                <i class="fa-solid fa-save mr-2"></i> {{ __('Save Category') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


