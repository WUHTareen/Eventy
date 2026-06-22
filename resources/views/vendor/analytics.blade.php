<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    <i class="fa-solid fa-chart-line text-purple-600 mr-2"></i>{{ __('Analytics & Earnings') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Track your business performance and revenue</p>
            </div>
            <a href="{{ route('vendor.dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-5 rounded-xl transition-all flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Earnings Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Earnings -->
                <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-6 rounded-3xl text-white relative overflow-hidden shadow-xl shadow-green-500/20">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="relative">
                        <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fa-solid fa-wallet text-2xl"></i>
                        </div>
                        <p class="text-green-100 text-sm font-medium mb-1">Total Earnings</p>
                        <p class="text-4xl font-bold">PKR {{ number_format($totalEarnings) }}</p>
                        <p class="text-green-100 text-xs mt-2">From completed bookings</p>
                    </div>
                </div>

                <!-- This Month -->
                <div class="bg-gradient-to-br from-blue-500 to-cyan-600 p-6 rounded-3xl text-white relative overflow-hidden shadow-xl shadow-blue-500/20">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="relative">
                        <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fa-solid fa-calendar-check text-2xl"></i>
                        </div>
                        <p class="text-blue-100 text-sm font-medium mb-1">This Month</p>
                        <p class="text-4xl font-bold">PKR {{ number_format($thisMonthEarnings) }}</p>
                        <p class="text-blue-100 text-xs mt-2">{{ now()->format('F Y') }}</p>
                    </div>
                </div>

                <!-- Total Bookings -->
                <div class="bg-gradient-to-br from-purple-500 to-pink-600 p-6 rounded-3xl text-white relative overflow-hidden shadow-xl shadow-purple-500/20">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="relative">
                        <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fa-solid fa-receipt text-2xl"></i>
                        </div>
                        <p class="text-purple-100 text-sm font-medium mb-1">Total Completed</p>
                        <p class="text-4xl font-bold">{{ $recentBookings->where('status', 'completed')->count() }}</p>
                        <p class="text-purple-100 text-xs mt-2">Completed orders</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Top Services -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50/50 to-white">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-trophy text-yellow-500"></i> Top Performing Services
                        </h3>
                        <p class="text-gray-500 text-sm mt-1">Ranked by number of bookings</p>
                    </div>
                    <div class="p-6">
                        @forelse($topServices as $index => $service)
                            <div class="flex items-center gap-4 {{ !$loop->last ? 'mb-4 pb-4 border-b border-gray-100' : '' }}">
                                <div class="w-10 h-10 bg-gradient-to-br {{ $index === 0 ? 'from-yellow-400 to-orange-500' : ($index === 1 ? 'from-gray-300 to-gray-400' : 'from-amber-600 to-amber-700') }} rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-grow">
                                    <h4 class="font-bold text-gray-900">{{ $service->name }}</h4>
                                    <p class="text-sm text-gray-500">PKR {{ number_format($service->price) }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-bold">
                                        {{ $service->bookings_count }} bookings
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <i class="fa-solid fa-chart-simple text-gray-300 text-4xl mb-3"></i>
                                <p class="text-gray-500">No services with bookings yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50/50 to-white">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-clock-rotate-left text-blue-500"></i> Recent Activity
                        </h3>
                        <p class="text-gray-500 text-sm mt-1">Latest booking updates</p>
                    </div>
                    <div class="p-6 max-h-80 overflow-y-auto">
                        @forelse($recentBookings as $booking)
                            <div class="flex items-start gap-4 {{ !$loop->last ? 'mb-4 pb-4 border-b border-gray-100' : '' }}">
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold flex-shrink-0">
                                    {{ substr($booking->user->name ?? $booking->customer_name ?? 'G', 0, 1) }}
                                </div>
                                <div class="flex-grow min-w-0">
                                    <p class="font-medium text-gray-900">{{ $booking->user->name ?? $booking->customer_name ?? 'Guest' }}</p>
                                    <p class="text-sm text-gray-500 truncate">{{ $booking->service->name }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $booking->created_at->diffForHumans() }}</p>
                                </div>
                                <div>
                                    @if($booking->status === 'pending')
                                        <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-lg text-xs font-bold">Pending</span>
                                    @elseif($booking->status === 'confirmed')
                                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-lg text-xs font-bold">Confirmed</span>
                                    @elseif($booking->status === 'completed')
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-lg text-xs font-bold">Completed</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded-lg text-xs font-bold">Cancelled</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <i class="fa-solid fa-inbox text-gray-300 text-4xl mb-3"></i>
                                <p class="text-gray-500">No recent activity</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('vendor.orders') }}" class="group bg-white rounded-2xl p-6 border border-gray-100 hover:border-indigo-200 hover:shadow-xl transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center group-hover:bg-indigo-600 transition-colors">
                            <i class="fa-solid fa-clipboard-list text-indigo-600 group-hover:text-white transition-colors"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Manage Orders</h4>
                            <p class="text-sm text-gray-500">View and update bookings</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('vendor.create-service') }}" class="group bg-white rounded-2xl p-6 border border-gray-100 hover:border-green-200 hover:shadow-xl transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center group-hover:bg-green-600 transition-colors">
                            <i class="fa-solid fa-plus text-green-600 group-hover:text-white transition-colors"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Add New Service</h4>
                            <p class="text-sm text-gray-500">Create a new listing</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('vendor.dashboard') }}" class="group bg-white rounded-2xl p-6 border border-gray-100 hover:border-purple-200 hover:shadow-xl transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center group-hover:bg-purple-600 transition-colors">
                            <i class="fa-solid fa-boxes-stacked text-purple-600 group-hover:text-white transition-colors"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">My Services</h4>
                            <p class="text-sm text-gray-500">Manage your listings</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>


