<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Ensemble #') }}{{ $booking->id }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Status and details of your event package.</p>
            </div>
            <a href="{{ route('my-packages') }}" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold py-2.5 px-5 rounded-xl shadow-sm transition-all flex items-center gap-2 hover:shadow-md">
                <i class="fa-solid fa-arrow-left text-gray-400"></i> Back to My Ensembles
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Hero Status Card -->
            <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-3xl p-8 shadow-xl text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-96 h-96 bg-primary-500/10 blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-sm rounded-lg text-xs font-bold uppercase tracking-widest mb-4">
                            <span class="w-2 h-2 rounded-full bg-primary-400 animate-pulse"></span>
                            {{ $booking->status }}
                        </span>
                        <h3 class="text-3xl font-black mb-1">{{ $booking->customPackage->name }}</h3>
                        <p class="text-gray-400 font-medium">{{ $booking->customPackage->description }}</p>
                    </div>
                    <div class="text-left md:text-right">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Total Investment</p>
                        <p class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-indigo-400">PKR {{ number_format($booking->total_amount) }}</p>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="md:col-span-2 space-y-8">
                    
                    <!-- Logistics -->
                    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                        <h4 class="font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="fa-solid fa-compass text-primary-500"></i> Event Logistics
                        </h4>
                        <div class="grid grid-cols-2 gap-y-6 gap-x-8">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Date & Time</p>
                                <p class="font-bold text-gray-900">{{ $booking->booking_date->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-500 font-bold">{{ $booking->booking_date->format('h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Guest Count</p>
                                <p class="font-bold text-gray-900">{{ $booking->guest_count }} People</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Location</p>
                                <p class="font-bold text-gray-900">{{ $booking->event_address }}</p>
                                <p class="text-xs text-gray-500 font-bold">{{ $booking->event_location }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Service Breakdown -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between px-2">
                            <h4 class="font-bold text-gray-900">Service Status</h4>
                            <span class="text-xs font-bold text-gray-500">{{ $childBookings->count() }} Components</span>
                        </div>
                        
                        @foreach($childBookings as $child)
                            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center justify-between group hover:border-primary-100 transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-primary-50 group-hover:text-primary-500 transition-colors">
                                        <i class="fa-solid fa-{{ $child->service->category->icon ?? 'star' }}"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-gray-900">{{ $child->service->name }}</h5>
                                        <p class="text-xs text-gray-500 font-bold uppercase tracking-wide">{{ $child->service->category->name }}</p>
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
                                    @if($child->vendor)
                                        <p class="text-[10px] text-gray-400 font-bold">by {{ $child->vendor->name }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Sidebar / Support -->
                <div class="space-y-6">
                    <div class="bg-indigo-50 rounded-3xl p-8 border border-indigo-100/50">
                        <h4 class="font-black text-indigo-900 mb-2">Need Changes?</h4>
                        <p class="text-indigo-700/80 text-sm mb-6 leading-relaxed">
                            For modifications to your ensemble, please contact our concierge team directly. Automated changes are disabled to ensure coordination.
                        </p>
                        <a href="{{ route('contact') }}" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl shadow-lg hover:bg-indigo-700 transition-colors flex items-center justify-center gap-2">
                            <i class="fa-solid fa-headset"></i> Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


