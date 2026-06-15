<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl border-4 border-white shadow-xl overflow-hidden flex-shrink-0">
                    <img src="{{ Auth::user()->getAvatarUrl() }}" class="w-full h-full object-cover" alt="{{ Auth::user()->name }}">
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                        {{ __('Welcome Back') }}, <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#0A3A7A] to-[#ED1C24]">{{ Auth::user()->name }}</span>!
                    </h2>
                    <p class="text-gray-500 text-sm mt-1">Here's what's happening with your bookings today.</p>
                </div>
            </div>
            <div class="flex items-center gap-2 bg-green-50 px-4 py-2 rounded-xl border border-green-100">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-green-700 font-bold text-sm tracking-wide">SYSTEM ACTIVE</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-[#0A3A7A] via-[#0D4E9A] to-[#ED1C24] rounded-3xl p-8 mb-8 text-white relative overflow-hidden shadow-2xl shadow-primary-500/20">
                <!-- Decorative Elements -->
                <div class="absolute right-0 top-0 w-80 h-80 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/4"></div>
                <div class="absolute left-20 bottom-0 w-40 h-40 bg-white/5 rounded-full translate-y-1/2"></div>
                <div class="absolute right-1/4 bottom-0 w-24 h-24 bg-white/10 rounded-full translate-y-1/2"></div>
                
                <!-- Content -->
                <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-6 md:mb-0">
                        <div class="inline-flex items-center bg-white/20 backdrop-blur-sm px-4 py-1.5 rounded-full text-sm font-bold mb-4">
                            <i class="fa-solid fa-sparkles mr-2 text-yellow-300"></i> Eventy Excellence
                        </div>
                        <h3 class="text-3xl font-bold mb-2">Find Your Perfect Service</h3>
                        <p class="text-blue-50 max-w-lg font-medium">Explore our marketplace of verified professionals ready to help you with any task.</p>
                    </div>
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center bg-white text-[#0A3A7A] font-bold py-4 px-8 rounded-xl hover:bg-gray-50 transition-all shadow-xl transform hover:-translate-y-1 hover:shadow-2xl">
                        <i class="fa-solid fa-compass mr-2"></i> Browse Services
                    </a>
                </div>
            </div>

            <!-- Timeline Visual Planner -->
            <div class="mb-12">
                @include('partials.event-timeline')
            </div>

            <!-- Stats Grid with Polling -->
            <div x-data="{
                refreshDashboardStats() {
                    fetch('{{ route('dashboard') }}', {
                        headers: { 'X-Partial': 'user-stats', 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(response => response.text())
                    .then(html => {
                        $refs.userStatsContainer.innerHTML = html;
                    });
                },
                init() {
                    setInterval(() => this.refreshDashboardStats(), 5000);
                }
            }" x-init="init()">
                <div x-ref="userStatsContainer">
                    @include('partials.user-dashboard-stats')
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('bookings.index') }}" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-primary-200 transition-all group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-primary-50 to-blue-50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <h4 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-primary-600 transition-colors">
                                <i class="fa-solid fa-calendar-days mr-2 text-primary-500"></i>My Bookings
                            </h4>
                            <p class="text-gray-500">View and manage your service appointments</p>
                        </div>
                        <div class="w-14 h-14 bg-primary-50 rounded-xl flex items-center justify-center group-hover:bg-primary-600 transition-colors transform group-hover:scale-110 group-hover:-rotate-3">
                            <i class="fa-solid fa-arrow-right text-primary-600 group-hover:text-white transition-colors text-xl"></i>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('profile.edit') }}" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-gray-200 transition-all group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-gray-50 to-slate-50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <h4 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-gray-900 transition-colors">
                                <i class="fa-solid fa-user-gear mr-2 text-gray-400"></i>Profile Settings
                            </h4>
                            <p class="text-gray-500">Update your account information</p>
                        </div>
                        <div class="w-14 h-14 bg-gray-50 rounded-xl flex items-center justify-center group-hover:bg-gray-800 transition-colors transform group-hover:scale-110 group-hover:rotate-3">
                            <i class="fa-solid fa-arrow-right text-gray-400 group-hover:text-white transition-colors text-xl"></i>
                        </div>
                    </div>
                </a>

                <a href="{{ route('my-packages') }}" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-indigo-200 transition-all group relative overflow-hidden md:col-span-2">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-50 to-purple-50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <h4 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-indigo-600 transition-colors">
                                <i class="fa-solid fa-wand-magic-sparkles mr-2 text-indigo-500"></i>My Ensembles
                            </h4>
                            <p class="text-gray-500">Manage your multi-service custom event packages</p>
                        </div>
                        <div class="w-14 h-14 bg-indigo-50 rounded-xl flex items-center justify-center group-hover:bg-indigo-600 transition-colors transform group-hover:scale-110 group-hover:-rotate-3">
                            <i class="fa-solid fa-arrow-right text-indigo-600 group-hover:text-white transition-colors text-xl"></i>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>


