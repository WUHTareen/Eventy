<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    <i class="fa-solid fa-shield-halved text-[#0A3A7A] mr-2"></i>{{ __('Admin Control Center') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Manage users, vendors, and platform settings</p>
            </div>
            <div class="flex items-center gap-3" x-data="{ open: false }">
                <a href="/admin/hotels" class="flex items-center gap-2 bg-white text-[#0A3A7A] px-4 py-2 rounded-xl border border-[#0A3A7A]/20 hover:bg-slate-50 transition-colors shadow-lg hover:shadow-xl">
                    <i class="fa-solid fa-hotel text-indigo-500"></i>
                    <span class="font-bold text-sm">Hotels</span>
                </a>
                <a href="{{ route('admin.blog.index') }}" class="flex items-center gap-2 bg-white text-[#0A3A7A] px-4 py-2 rounded-xl border border-[#0A3A7A]/20 hover:bg-slate-50 transition-colors shadow-lg hover:shadow-xl">
                    <i class="fa-solid fa-newspaper text-green-500"></i>
                    <span class="font-bold text-sm">Blog</span>
                </a>
                <div class="flex items-center gap-2 bg-[#0A3A7A]/5 px-3 py-2 rounded-xl border border-[#0A3A7A]/10">
                    <div class="w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-[#0A3A7A] font-bold text-xs">Online</span>
                </div>
                <div class="relative">
                    <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2 bg-[#0A3A7A] text-white px-4 py-2 rounded-xl border border-[#0A3A7A] hover:bg-[#0D4E9A] transition-colors shadow-lg hover:shadow-xl">
                        <i class="fa-solid fa-bars-staggered"></i>
                        <span class="font-bold text-sm">Quick Actions</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': open }" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                        <a href="{{ route('admin.custom-packages') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-slate-50 transition-colors">
                            <i class="fa-solid fa-layer-group text-yellow-500 w-4"></i> Custom Ensembles
                        </a>
                        <a href="{{ route('admin.budget-requests') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-slate-50 transition-colors">
                            <i class="fa-solid fa-calculator text-primary-500 w-4"></i> Budget Requests
                        </a>
                        <a href="/admin/settings" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-slate-50 transition-colors">
                            <i class="fa-solid fa-gear text-gray-500 w-4"></i> Site Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl relative mb-8 shadow-sm flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fa-solid fa-check text-green-600"></i>
                    </div>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Stats Overview -->
            <div>
                <div class="transition-opacity duration-500">
                    @include('admin.partials.dashboard-stats')
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Clients Section (Live Polling) -->
                <div x-data="{
                    refreshClients() {
                        fetch('{{ route('admin.dashboard') }}', { 
                            method: 'GET',
                            headers: { 'X-Partial': 'clients', 'X-Requested-With': 'XMLHttpRequest' }
                        })
                        .then(response => response.text())
                        .then(html => {
                            $refs.clientsContainer.innerHTML = html;
                        });
                    },
                    init() {
                        setInterval(() => {
                            this.refreshClients();
                        }, 5000);
                    }
                }" x-init="init()">
                    <div x-ref="clientsContainer" class="transition-opacity duration-500">
                        @include('admin.partials.recent-clients-table')
                    </div>
                </div>

                <!-- Vendor Verification Section (Live Polling) -->
                <div x-data="{
                    refreshVendors() {
                        fetch('{{ route('admin.dashboard') }}', { 
                            method: 'GET',
                            headers: { 'X-Partial': 'vendors', 'X-Requested-With': 'XMLHttpRequest' }
                        })
                        .then(response => response.text())
                        .then(html => {
                            $refs.vendorsContainer.innerHTML = html;
                        });
                    },
                    init() {
                        setInterval(() => {
                            this.refreshVendors();
                        }, 5000);
                    }
                }" x-init="init()">
                    <div x-ref="vendorsContainer" class="transition-opacity duration-500">
                        @include('admin.partials.pending-vendors-table')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>


