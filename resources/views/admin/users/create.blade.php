<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 bg-white border border-gray-100 rounded-xl flex items-center justify-center text-gray-500 hover:text-primary-600 hover:shadow-sm transition-all">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Create New Account') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Add a new admin, vendor, or regular user</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                        @csrf

                        <!-- Role Selection -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="role" value="user" class="peer sr-only" checked onchange="toggleVendorFields(false)">
                                <div class="p-4 border-2 border-gray-100 rounded-2xl peer-checked:border-primary-500 peer-checked:bg-primary-50/50 hover:bg-gray-50 transition-all text-center">
                                    <div class="w-10 h-10 bg-gray-100 peer-checked:bg-primary-100 rounded-xl flex items-center justify-center mx-auto mb-2 transition-colors">
                                        <i class="fa-solid fa-user text-gray-500 peer-checked:text-primary-600"></i>
                                    </div>
                                    <span class="font-bold text-gray-700 block">Regular User</span>
                                </div>
                            </label>

                            <label class="relative cursor-pointer">
                                <input type="radio" name="role" value="vendor" class="peer sr-only" onchange="toggleVendorFields(true)">
                                <div class="p-4 border-2 border-gray-100 rounded-2xl peer-checked:border-secondary-500 peer-checked:bg-secondary-50/50 hover:bg-gray-50 transition-all text-center">
                                    <div class="w-10 h-10 bg-gray-100 peer-checked:bg-secondary-100 rounded-xl flex items-center justify-center mx-auto mb-2 transition-colors">
                                        <i class="fa-solid fa-store text-gray-500 peer-checked:text-secondary-600"></i>
                                    </div>
                                    <span class="font-bold text-gray-700 block">Vendor</span>
                                </div>
                            </label>

                            <label class="relative cursor-pointer">
                                <input type="radio" name="role" value="admin" class="peer sr-only" onchange="toggleVendorFields(false)">
                                <div class="p-4 border-2 border-gray-100 rounded-2xl peer-checked:border-primary-700 peer-checked:bg-primary-50/80 hover:bg-gray-50 transition-all text-center">
                                    <div class="w-10 h-10 bg-gray-100 peer-checked:bg-primary-200 rounded-xl flex items-center justify-center mx-auto mb-2 transition-colors">
                                        <i class="fa-solid fa-shield-halved text-gray-500 peer-checked:text-primary-800"></i>
                                    </div>
                                    <span class="font-bold text-gray-700 block">Admin</span>
                                </div>
                            </label>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Full Name')" class="text-gray-700 font-bold mb-2 ml-1" />
                                <x-text-input id="name" class="block w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-primary-500 focus:border-primary-500" type="text" name="name" :value="old('name')" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-bold mb-2 ml-1" />
                                <x-text-input id="email" class="block w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-primary-500 focus:border-primary-500" type="email" name="email" :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div>
                                <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-bold mb-2 ml-1" />
                                <x-text-input id="password" class="block w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-primary-500 focus:border-primary-500" type="password" name="password" required />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Vendor Fields (Shown dynamically) -->
                        <div id="vendor-fields" class="hidden space-y-6 pt-6 border-t border-gray-100">
                            <h4 class="font-bold text-gray-800 flex items-center gap-2">
                                <i class="fa-solid fa-briefcase text-secondary-500"></i> Vendor Information
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="city_id" :value="__('City')" class="text-gray-700 font-bold mb-2 ml-1" />
                                    <select id="city_id" name="city_id" class="block w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-primary-500 focus:border-primary-500">
                                        <option value="">Select City</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="category_id" :value="__('Service Category')" class="text-gray-700 font-bold mb-2 ml-1" />
                                    <select id="category_id" name="category_id" class="block w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-primary-500 focus:border-primary-500">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-100">
                            <x-primary-button class="bg-gradient-to-r from-primary-600 to-primary-800 border-none px-8 py-3 rounded-xl shadow-lg shadow-primary-500/30">
                                {{ __('Create Account') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleVendorFields(show) {
            const fields = document.getElementById('vendor-fields');
            if (show) {
                fields.classList.remove('hidden');
            } else {
                fields.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>


