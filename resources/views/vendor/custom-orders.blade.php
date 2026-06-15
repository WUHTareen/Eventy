<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Ensemble Requests') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Manage inquiries that are part of a larger custom package.</p>
            </div>
            <a href="{{ route('vendor.dashboard') }}" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold py-2.5 px-5 rounded-xl shadow-sm transition-all flex items-center gap-2 hover:shadow-md">
                <i class="fa-solid fa-arrow-left text-gray-400"></i> Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
                <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100 ml-auto">
                    <div class="w-3 h-3 bg-primary-500 rounded-full animate-pulse"></div>
                    <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Live Updates</span>
                </div>
            </div>

            @if($bookings->isEmpty())
                <div class="bg-white/70 backdrop-blur-xl rounded-[2.5rem] p-16 text-center border border-white shadow-xl relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-gray-50/50 to-white/50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative z-10">
                        <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-6 text-gray-300 group-hover:scale-110 group-hover:bg-primary-50 group-hover:text-primary-500 transition-all duration-500">
                            <i class="fa-solid fa-layer-group text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-gray-900 mb-2">No Ensemble Requests Yet</h3>
                        <p class="text-gray-500 max-w-md mx-auto">When a customer includes your service in a custom package, the request will appear here with specific coordination details.</p>
                    </div>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($bookings as $booking)
                        <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] p-8 shadow-sm border border-white hover:shadow-xl hover:border-primary-100 transition-all duration-500 group relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity transform group-hover:scale-110">
                                <i class="fa-solid fa-puzzle-piece text-9xl"></i>
                            </div>

                            <div class="relative z-10 grid lg:grid-cols-4 gap-8">
                                <!-- Booking Info -->
                                <div class="lg:col-span-1 space-y-4">
                                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-primary-50 text-primary-600 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                        <i class="fa-solid fa-hashtag text-xs"></i> Order #{{ $booking->id }}
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Execution Date</p>
                                        <div class="flex items-center gap-2 text-gray-900">
                                            <i class="fa-regular fa-calendar text-primary-500"></i>
                                            <span class="font-bold">{{ $booking->booking_date->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-gray-500 text-sm mt-1">
                                            <i class="fa-regular fa-clock"></i>
                                            <span>{{ $booking->booking_date->format('h:i A') }}</span>
                                        </div>
                                    </div>
                                    
                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider
                                        {{ $booking->status === 'pending' ? 'bg-yellow-50 text-yellow-600' : '' }}
                                        {{ $booking->status === 'confirmed' ? 'bg-green-50 text-green-600' : '' }}
                                        {{ $booking->status === 'completed' ? 'bg-gray-100 text-gray-600' : '' }}
                                        {{ $booking->status === 'cancelled' ? 'bg-red-50 text-red-600' : '' }}">
                                        <span class="w-2 h-2 rounded-full bg-current"></span>
                                        {{ $booking->status }}
                                    </span>
                                </div>

                                <!-- Customer & Service -->
                                <div class="lg:col-span-1 space-y-6">
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Service Requested</p>
                                        <p class="font-bold text-gray-900">{{ $booking->service->name }}</p>
                                        <p class="text-xs text-primary-500 font-bold mt-1">PKR {{ number_format($booking->budget) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Contact Person</p>
                                        <p class="font-bold text-gray-900">{{ $booking->customer_name }}</p>
                                        <a href="tel:{{ $booking->customer_phone }}" class="text-xs font-bold text-gray-500 hover:text-primary-500 transition-colors flex items-center gap-2 mt-1">
                                            <i class="fa-solid fa-phone"></i> {{ $booking->customer_phone }}
                                        </a>
                                    </div>
                                </div>

                                <!-- Full Context & Team -->
                                <div class="lg:col-span-2 space-y-6">
                                    <!-- Full Brief Logic -->
                                    <div class="bg-gray-50/50 rounded-2xl p-6 border border-gray-100">
                                        <p class="text-[10px] font-black text-primary-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                                            <span class="w-1 h-1 bg-primary-500 rounded-full"></span> Full Event Brief
                                        </p>
                                        
                                        <div class="grid sm:grid-cols-2 gap-y-4 gap-x-8">
                                            @php
                                                // Filter out standard keys to show all custom context
                                                $standardKeys = ['package_booking_id', 'is_custom_package'];
                                                $customData = array_diff_key($booking->booking_data ?? [], array_flip($standardKeys));
                                            @endphp

                                            @forelse($customData as $key => $value)
                                                <div>
                                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ str_replace('_', ' ', $key) }}</p>
                                                    <p class="font-bold text-gray-900 text-sm">{{ is_array($value) ? implode(', ', $value) : $value }}</p>
                                                </div>
                                            @empty
                                                <p class="text-sm text-gray-400 ">No specific constraints specified.</p>
                                            @endforelse

                                            @if($booking->notes)
                                                <div class="col-span-full mt-2 pt-2 border-t border-gray-200/50">
                                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Concierge Note</p>
                                                    <p class="text-xs font-medium text-gray-600 leading-relaxed">{{ $booking->notes }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Collaborating Vendors -->
                                    <div class="bg-indigo-50/50 rounded-2xl p-6 border border-indigo-100">
                                        <p class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                                            <span class="w-1 h-1 bg-indigo-500 rounded-full"></span> Collaborating Team
                                        </p>
                                        
                                        <div class="space-y-3">
                                            @php
                                                $siblings = $booking->siblings();
                                            @endphp
                                            
                                            @forelse($siblings as $sibling)
                                                <div class="flex items-center justify-between bg-white p-3 rounded-xl border border-indigo-50 shadow-sm">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600">
                                                            <i class="fa-solid fa-{{ $sibling->service->category->icon ?? 'star' }} text-xs"></i>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs font-bold text-gray-900">{{ $sibling->service->name }}</p>
                                                            <p class="text-[10px] font-bold text-gray-400 uppercase">{{ $sibling->vendor->name ?? 'Unknown Vendor' }}</p>
                                                        </div>
                                                    </div>
                                                    <span class="px-2 py-0.5 bg-gray-50 rounded text-[10px] font-bold text-gray-500 uppercase">{{ $sibling->status }}</span>
                                                </div>
                                            @empty
                                                <p class="text-xs text-indigo-400  font-medium">No other known vendors for this package yet.</p>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                                        @if($booking->status === 'pending')
                                            <form action="{{ route('vendor.orders.update', $booking) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 text-xs font-black uppercase tracking-widest rounded-xl hover:bg-gray-50 hover:text-red-600 transition-colors">
                                                    Decline
                                                </button>
                                            </form>
                                            <form action="{{ route('vendor.orders.update', $booking) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="px-6 py-2 bg-gray-900 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-primary-600 shadow-lg shadow-gray-900/20 hover:shadow-primary-600/30 transition-all transform hover:-translate-y-0.5">
                                                    Confirm Assignment
                                                </button>
                                            </form>
                                        @else
                                            <button disabled class="px-4 py-2 bg-gray-100 text-gray-400 text-xs font-black uppercase tracking-widest rounded-xl cursor-not-allowed">
                                                Processed
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-8">
                        {{ $bookings->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>


