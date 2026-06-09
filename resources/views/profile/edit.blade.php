<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="w-10 h-10 bg-white shadow-sm rounded-xl flex items-center justify-center text-gray-400 hover:text-primary-600 transition-all">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Account Settings') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Manage your identity and security preferences</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Sidebar Navigation -->
                <div class="lg:col-span-1 space-y-4">
                    <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 sticky top-24">
                        <div class="flex flex-col items-center text-center mb-10">
                            <div class="relative group">
                                <div class="w-24 h-24 rounded-full p-1 bg-gradient-to-tr from-primary-500 to-red-500 overflow-hidden shadow-xl mb-4">
                                    <img src="{{ Auth::user()->getAvatarUrl() }}" class="w-full h-full object-cover rounded-full bg-white border-2 border-white" alt="{{ Auth::user()->name }}">
                                </div>
                                <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-green-500 border-4 border-white rounded-full"></div>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">{{ Auth::user()->name }}</h3>
                            <p class="text-gray-500 text-sm font-medium tracking-wide">{{ strtoupper(Auth::user()->role) }}</p>
                        </div>

                        <nav class="space-y-2">
                            <a href="#identity" class="flex items-center gap-3 px-6 py-4 bg-primary-50 text-primary-700 rounded-2xl font-bold transition-all transform hover:scale-[1.02]">
                                <i class="fa-solid fa-id-card"></i> Personal Info
                            </a>
                            <a href="#security" class="flex items-center gap-3 px-6 py-4 text-gray-500 hover:bg-gray-50 hover:text-gray-800 rounded-2xl font-bold transition-all transition-all">
                                <i class="fa-solid fa-shield-halved"></i> Security
                            </a>
                            <a href="#danger" class="flex items-center gap-3 px-6 py-4 text-red-500 hover:bg-red-50 rounded-2xl font-bold transition-all">
                                <i class="fa-solid fa-circle-exclamation"></i> Danger Zone
                            </a>
                        </nav>

                        <div class="mt-12 p-6 bg-gradient-to-br from-gray-900 to-slate-800 rounded-3xl text-white relative overflow-hidden">
                            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/5 rounded-full"></div>
                            <h4 class="font-bold mb-1 relative z-10 text-sm">Need Help?</h4>
                            <p class="text-white/60 text-xs leading-relaxed relative z-10">Contact our support desk for any assistance with your account.</p>
                            <a href="#" class="mt-4 inline-block text-[10px] font-black uppercase tracking-widest bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg transition-all relative z-10">
                                Support Center
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Profile Information Section -->
                    <div id="identity" class="scroll-mt-24">
                        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between">
                                <h3 class="font-black text-gray-900 uppercase tracking-widest text-sm">Identification</h3>
                                <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-500">
                                    <i class="fa-solid fa-user-circle"></i>
                                </div>
                            </div>
                            <div class="p-8">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </div>

                    <!-- Security Section -->
                    <div id="security" class="scroll-mt-24">
                        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between">
                                <h3 class="font-black text-gray-900 uppercase tracking-widest text-sm">Security & Access</h3>
                                <div class="w-8 h-8 bg-yellow-50 rounded-lg flex items-center justify-center text-yellow-500">
                                    <i class="fa-solid fa-lock"></i>
                                </div>
                            </div>
                            <div class="p-8">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>
                    </div>

                    <!-- Delete Account Section -->
                    <div id="danger" class="scroll-mt-24">
                        <div class="bg-red-50/50 rounded-[2.5rem] shadow-sm border border-red-100 overflow-hidden">
                            <div class="px-8 py-6 border-b border-red-100 flex items-center justify-between bg-white/50">
                                <h3 class="font-black text-red-900 uppercase tracking-widest text-sm underline decoration-red-200 decoration-2">Danger Zone</h3>
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center text-red-600 animate-pulse">
                                    <i class="fa-solid fa-trash"></i>
                                </div>
                            </div>
                            <div class="p-8">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

