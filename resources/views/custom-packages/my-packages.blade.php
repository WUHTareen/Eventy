<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('My Custom Ensembles') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Track your multi-service event packages.</p>
            </div>
            <a href="{{ route('packages.create') }}" class="bg-gradient-to-r from-primary-600 to-indigo-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg hover:shadow-primary-500/30 transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <i class="fa-solid fa-wand-magic-sparkles"></i> Build New Ensemble
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($bookings->isEmpty())
                <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm">
                    <div class="w-24 h-24 bg-gradient-to-br from-primary-50 to-indigo-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-layer-group text-4xl text-primary-200"></i>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-2">No Ensembles Found</h3>
                    <p class="text-gray-500 max-w-md mx-auto mb-8">You haven't booked any custom packages yet. Start building your dream event today.</p>
                    <a href="{{ route('packages.create') }}" class="inline-flex items-center gap-2 bg-gray-900 text-white font-bold py-3 px-8 rounded-xl hover:bg-primary-600 transition-colors">
                        Start Building
                    </a>
                </div>
            @else
                <div class="grid gap-8">
                    @foreach($bookings as $booking)
                        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-500 relative overflow-hidden group">
                            <div class="absolute top-0 right-0 w-64 h-64 bg-primary-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 group-hover:bg-primary-500/10 transition-colors"></div>
                            
                            <div class="relative z-10 grid md:grid-cols-4 gap-8">
                                <div class="md:col-span-1 border-r border-gray-100 pr-8">
                                    <div class="mb-4">
                                        <span class="text-[10px] font-black uppercase tracking-widest text-primary-500 mb-1 block">Ensemble Name</span>
                                        <h3 class="text-xl font-black text-gray-900 leading-tight">{{ $booking->customPackage->name }}</h3>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <i class="fa-regular fa-calendar text-primary-400"></i>
                                            <span class="font-bold">{{ $booking->booking_date->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <i class="fa-solid fa-users text-primary-400"></i>
                                            <span class="font-bold">{{ $booking->guest_count }} Guests</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <i class="fa-solid fa-location-dot text-primary-400"></i>
                                            <span class="font-bold">{{ $booking->event_location }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-3 block">Included Services</span>
                                    <div class="grid sm:grid-cols-2 gap-3">
                                        @foreach($booking->customPackage->services as $service)
                                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100">
                                                <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-primary-500 shadow-sm">
                                                    <i class="fa-solid fa-{{ $service->category->icon ?? 'star' }} text-xs"></i>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-bold text-gray-900 truncate">{{ $service->name }}</p>
                                                    <p class="text-[10px] text-gray-500 font-bold uppercase">{{ $service->category->name }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="md:col-span-1 flex flex-col justify-between items-end pl-8 border-l border-gray-100">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold capitalize mb-4
                                        {{ $booking->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : '' }}
                                        {{ $booking->status === 'confirmed' ? 'bg-green-50 text-green-700' : '' }}
                                        {{ $booking->status === 'completed' ? 'bg-gray-100 text-gray-700' : '' }}
                                        {{ $booking->status === 'cancelled' ? 'bg-red-50 text-red-700' : '' }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        {{ $booking->status }}
                                    </span>
                                    
                                    <div class="text-right">
                                        <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 block mb-1">Total Valuation</span>
                                        <p class="text-2xl font-black text-primary-600 tracking-tight">PKR {{ number_format($booking->total_amount) }}</p>
                                        
                                        <a href="{{ route('my-packages.show', $booking) }}" class="mt-4 inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-indigo-600 transition-colors uppercase tracking-wider group-hover/link">
                                            View Details <i class="fa-solid fa-arrow-right group-hover/link:translate-x-1 transition-transform"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>


