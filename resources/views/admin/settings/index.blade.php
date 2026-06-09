<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">
            <i class="fa-solid fa-gear text-[#0A3A7A] mr-2"></i> Site Settings
        </h2>
        <p class="text-gray-500 text-sm mt-1">Manage your website settings, logo, social links and payment config</p>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4">

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 font-medium">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- GENERAL SETTINGS --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-globe text-[#0A3A7A]"></i> General Settings
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Site Name</label>
                            <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Contact Email</label>
                            <input type="email" name="site_email" value="{{ $settings['site_email'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Phone Number</label>
                            <input type="text" name="site_phone" value="{{ $settings['site_phone'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Address</label>
                            <input type="text" name="site_address" value="{{ $settings['site_address'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Meta Description (SEO)</label>
                            <textarea name="meta_description" rows="2" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">{{ $settings['meta_description'] ?? '' }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Footer Text</label>
                            <input type="text" name="footer_text" value="{{ $settings['footer_text'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>
                </div>

                {{-- LOGO & FAVICON --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-image text-[#0A3A7A]"></i> Logo & Favicon
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Site Logo</label>
                            @if(!empty($settings['site_logo']))
                                <img src="{{ asset('storage/' . $settings['site_logo']) }}" class="h-16 mb-3 rounded-lg border border-gray-200 p-2">
                            @endif
                            <input type="file" name="logo" accept="image/*" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm">
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG, SVG (max 2MB)</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Favicon</label>
                            @if(!empty($settings['site_favicon']))
                                <img src="{{ asset('storage/' . $settings['site_favicon']) }}" class="h-10 mb-3 rounded border border-gray-200 p-1">
                            @endif
                            <input type="file" name="favicon" accept="image/*" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm">
                            <p class="text-xs text-gray-400 mt-1">PNG, ICO (max 512KB)</p>
                        </div>
                    </div>
                </div>

                {{-- SOCIAL MEDIA --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-share-nodes text-[#0A3A7A]"></i> Social Media Links
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1"><i class="fa-brands fa-facebook text-blue-600 mr-1"></i> Facebook URL</label>
                            <input type="url" name="facebook_url" value="{{ $settings['facebook_url'] ?? '' }}" placeholder="https://facebook.com/yourpage" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1"><i class="fa-brands fa-instagram text-pink-500 mr-1"></i> Instagram URL</label>
                            <input type="url" name="instagram_url" value="{{ $settings['instagram_url'] ?? '' }}" placeholder="https://instagram.com/yourpage" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1"><i class="fa-brands fa-twitter text-sky-500 mr-1"></i> Twitter/X URL</label>
                            <input type="url" name="twitter_url" value="{{ $settings['twitter_url'] ?? '' }}" placeholder="https://twitter.com/yourpage" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1"><i class="fa-brands fa-whatsapp text-green-500 mr-1"></i> WhatsApp Number</label>
                            <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '' }}" placeholder="+923001234567" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>
                </div>

                {{-- PAYMENT SETTINGS --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-credit-card text-[#0A3A7A]"></i> Payment Settings
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Stripe Publishable Key</label>
                            <input type="text" name="stripe_key" value="{{ $settings['stripe_key'] ?? '' }}" placeholder="pk_live_..." class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none font-mono text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Stripe Secret Key</label>
                            <input type="password" name="stripe_secret" value="{{ $settings['stripe_secret'] ?? '' }}" placeholder="sk_live_..." class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none font-mono text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Default Commission Rate (%)</label>
                            <input type="number" name="commission_rate" value="{{ $settings['commission_rate'] ?? '10' }}" min="0" max="100" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                            <p class="text-xs text-gray-400 mt-1">Platform commission percentage on each booking</p>
                        </div>
                    </div>
                </div>

                {{-- SAVE BUTTON --}}
                <div class="flex justify-end">
                    <button type="submit" class="bg-[#0A3A7A] text-white px-8 py-3 rounded-xl font-bold hover:bg-[#0D4E9A] transition-colors shadow-lg">
                        <i class="fa-solid fa-save mr-2"></i> Save All Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
