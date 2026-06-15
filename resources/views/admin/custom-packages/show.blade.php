<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Ensemble Details') }} <span class="text-gray-400">#{{ $booking->id }}</span>
                </h2>
                <p class="text-gray-500 text-sm mt-1">Full breakdown of the custom package booking.</p>
            </div>
            <a href="{{ route('admin.custom-packages') }}" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold py-2.5 px-5 rounded-xl shadow-sm transition-all flex items-center gap-2 hover:shadow-md">
                <i class="fa-solid fa-arrow-left text-gray-400"></i> Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Status -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Booking Status</p>
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-bold capitalize
                        {{ $booking->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : '' }}
                        {{ $booking->status === 'confirmed' ? 'bg-green-50 text-green-700' : '' }}
                        {{ $booking->status === 'completed' ? 'bg-gray-100 text-gray-700' : '' }}
                        {{ $booking->status === 'cancelled' ? 'bg-red-50 text-red-700' : '' }}">
                        <span class="w-2 h-2 rounded-full bg-current"></span>
                        {{ $booking->status }}
                    </span>
                </div>
                <!-- Customer -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm md:col-span-2">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2">Customer Information</p>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center text-primary-600 font-bold">
                            {{ substr($booking->customer_name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $booking->customer_name }}</p>
                            <div class="flex gap-4 text-xs text-gray-500 mt-1">
                                <span class="flex items-center gap-1"><i class="fa-solid fa-envelope"></i> {{ $booking->customer_email }}</span>
                                <span class="flex items-center gap-1"><i class="fa-solid fa-phone"></i> {{ $booking->customer_phone }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Total Value -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-right">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Total Valuation</p>
                    <p class="text-2xl font-black text-primary-600">PKR {{ number_format($booking->total_amount) }}</p>
                    <p class="text-xs text-gray-400 font-semibold">{{ $childBookings->count() }} Sub-orders</p>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Main Booking Info -->
                <div class="md:col-span-2 space-y-8">
                    <!-- Event Details -->
                    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <i class="fa-solid fa-calendar-star text-primary-500"></i> Event Logistics
                        </h3>
                        <div class="grid grid-cols-2 gap-y-6 gap-x-8">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Event Type</p>
                                <p class="font-bold text-gray-900">{{ $booking->event_type ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Guest Count</p>
                                <p class="font-bold text-gray-900">{{ $booking->guest_count }} Guests</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Start Time</p>
                                <p class="font-bold text-gray-900">{{ $booking->booking_date->format('M d, Y h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">End Time</p>
                                <p class="font-bold text-gray-900">{{ $booking->event_end_date ? \Carbon\Carbon::parse($booking->event_end_date)->format('M d, Y h:i A') : 'N/A' }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Location</p>
                                <p class="font-bold text-gray-900">{{ $booking->event_address }} <span class="text-gray-400">({{ $booking->event_location }})</span></p>
                            </div>
                            @if($booking->special_requests)
                                <div class="col-span-2 bg-yellow-50 p-4 rounded-xl border border-yellow-100">
                                    <p class="text-xs font-bold text-yellow-600 uppercase tracking-wide mb-1">Special Concierge Requests</p>
                                    <p class="text-sm text-yellow-800 font-medium">{{ $booking->special_requests }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Vendor Orders -->
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <i class="fa-solid fa-network-wired text-indigo-500"></i> Vendor Allocations
                            </h3>
                            <span class="bg-white px-3 py-1 rounded-full text-xs font-black shadow-sm text-gray-500">{{ $childBookings->count() }} Orders</span>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @foreach($childBookings as $child)
                                <div class="p-6 hover:bg-gray-50 transition-colors flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-500">
                                            <i class="fa-solid fa-{{ $child->service->category->icon ?? 'star' }}"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $child->service->name }}</p>
                                            <p class="text-xs text-gray-500 font-medium">Vendor: <span class="text-gray-700">{{ $child->vendor->name ?? 'Unknown' }}</span></p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold capitalize mb-1
                                            {{ $child->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : '' }}
                                            {{ $child->status === 'confirmed' ? 'bg-green-50 text-green-700' : '' }}
                                            {{ $child->status === 'completed' ? 'bg-gray-100 text-gray-700' : '' }}
                                            {{ $child->status === 'cancelled' ? 'bg-red-50 text-red-700' : '' }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            {{ $child->status }}
                                        </span>
                                        <p class="text-xs font-bold text-gray-400">Order #{{ $child->id }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Snapshot / Package Info -->
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-gray-900 text-white rounded-3xl p-8 shadow-xl shadow-gray-900/10">
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-500 mb-4">Package Configuration</p>
                        <h3 class="text-2xl font-black mb-2">{{ $booking->customPackage->name }}</h3>
                        <p class="text-gray-400 text-sm mb-6">{{ $booking->customPackage->description }}</p>
                        
                        <div class="space-y-4">
                            @php
                                // Aggregate standard keys to exclude
                                $standardKeys = ['event_end_date', 'event_type', 'booking_data', 'special_requests'];
                                $customData = array_diff_key($booking->booking_data ?? [], array_flip($standardKeys));
                            @endphp
                            
                            @if(!empty($customData))
                                <div class="bg-gray-800 rounded-xl p-4 border border-gray-700">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Additionals</p>
                                    <div class="space-y-2">
                                        @foreach($customData as $key => $value)
                                            <div class="flex justify-between border-b border-gray-700 pb-1 last:border-0">
                                                <span class="text-xs text-gray-400 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                                                <span class="text-xs text-white font-bold text-right">{{ is_array($value) ? implode(', ', $value) : $value }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


