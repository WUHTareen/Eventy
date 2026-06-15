<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('My Bookings') }}
            </h2>
            <a href="{{ route('home') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                <i class="fa-solid fa-plus mr-1"></i> Book New Service
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen" x-data="{ ratingModalOpen: false, selectedBookingId: null }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            

            @if($bookings->isEmpty())
                <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-gray-100">
                    <div class="bg-indigo-50 text-indigo-500 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 transform transition-transform hover:scale-110">
                        <i class="fa-regular fa-calendar-xmark text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">No Bookings Yet</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">You haven't scheduled any services yet. Explore our marketplace to find the perfect professional for your needs.</p>
                    <a href="{{ route('home') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-indigo-500/30 transition-all">
                        Browse Services
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($bookings as $booking)
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group flex flex-col">
                            <!-- Header with Date -->
                            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                                <div class="flex items-center text-gray-600 text-sm font-medium">
                                    <i class="fa-regular fa-calendar mr-2 text-indigo-500"></i>
                                    {{ $booking->booking_date->format('M d, Y') }}
                                </div>
                                <div class="text-gray-600 text-sm font-medium">
                                    <i class="fa-regular fa-clock mr-2 text-indigo-500"></i>
                                    {{ $booking->booking_date->format('h:i A') }}
                                </div>
                            </div>

                            <!-- Body -->
                            <div class="p-6 flex-1">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $booking->service->name }}</h4>
                                        <p class="text-sm text-gray-500 mt-1">
                                            by <span class="font-medium text-gray-700">{{ $booking->service->user->name }}</span>
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span class="block text-xl font-bold text-indigo-600">Rs. {{ number_format($booking->total_price ?? $booking->service->price) }}</span>
                                        @if(!empty($booking->booking_data['package_name']))
                                            <span class="text-[9px] font-black text-indigo-400 uppercase tracking-widest">{{ $booking->booking_data['package_name'] }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @if($booking->status === 'pending')
                                        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                            <span class="w-2 h-2 rounded-full bg-yellow-400 mr-2 animate-pulse"></span>
                                            Pending Approval
                                        </div>
                                    @elseif($booking->status === 'confirmed')
                                        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                            <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                                            Confirmed
                                        </div>
                                    @elseif($booking->status === 'completed')
                                        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                            <i class="fa-solid fa-check mr-2"></i> Completed
                                        </div>
                                    @else
                                        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                            <i class="fa-solid fa-ban mr-2"></i> Cancelled
                                        </div>
                                    @endif

                                    <!-- Specialized Specs Badges -->
                                    @php
                                        $catSlug = $booking->service->category->slug ?? '';
                                        $isTransport = in_array($catSlug, ['transport', 'luxury-rentals', 'coasters-buses', 'protocol-jeeps']);
                                        $isLodging = in_array($catSlug, ['hotels', '5-star', 'resorts', 'guest-houses', 'hotels-stays']);
                                        $isCatering = in_array($catSlug, ['catering', 'wedding-catering', 'corporate-lunch']);
                                        $isMedia = in_array($catSlug, ['photography', 'videography', 'drone', 'media', 'wedding-photography', 'event-videography', 'drone-shoots']);
                                    @endphp
                                    @if($booking->booking_data)
                                        @foreach($booking->booking_data as $key => $value)
                                            @if($key === 'selected_addons' && is_array($value))
                                                @foreach($value as $addon)
                                                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                                        <i class="fa-solid fa-plus mr-2"></i> {{ $addon }}
                                                    </div>
                                                @endforeach
                                            @elseif($key === 'passengers' && $isTransport)
                                                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                                    <i class="fa-solid fa-users mr-2"></i> {{ $value }} Pax
                                                </div>
                                            @elseif($key === 'menu_preference' && $isCatering)
                                                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                    <i class="fa-solid fa-utensils mr-2"></i> {{ ucfirst($value) }}
                                                </div>
                                            @elseif($key === 'coverage_hours' && $isMedia)
                                                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-purple-50 text-purple-700 border border-purple-100">
                                                    <i class="fa-solid fa-camera mr-2"></i> {{ $value }} Hours
                                                </div>
                                            @elseif($key === 'room_count' && $isLodging)
                                                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                                    <i class="fa-solid fa-bed mr-2"></i> {{ $value }} Rooms
                                                </div>
                                            @elseif($key === 'nationality')
                                                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-teal-50 text-teal-700 border border-teal-100">
                                                    <i class="fa-solid fa-passport mr-2"></i> {{ $value }}
                                                </div>
                                            @elseif($key === 'duration_days' && ($isTransport || $isLodging))
                                                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                                    <i class="fa-solid fa-hourglass-half mr-2"></i> {{ $value }} Days
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>

                                <!-- Progress Stepper -->
                                <div class="mb-8 px-2">
                                    <div class="flex items-center justify-between relative">
                                        <!-- Line -->
                                        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-[2px] bg-gray-100 -z-0"></div>
                                        @php
                                            $steps = [
                                                'pending' => ['label' => 'Received', 'icon' => 'fa-clock', 'active_color' => 'bg-yellow-500', 'line_color' => 'bg-yellow-500'],
                                                'confirmed' => ['label' => 'Approved', 'icon' => 'fa-check', 'active_color' => 'bg-blue-500', 'line_color' => 'bg-blue-500'],
                                                'completed' => ['label' => 'Delivered', 'icon' => 'fa-crown', 'active_color' => 'bg-green-500', 'line_color' => 'bg-green-500']
                                            ];
                                            $status = $booking->status === 'cancelled' ? 'pending' : $booking->status;
                                        @endphp
                                        
                                        @foreach($steps as $key => $step)
                                            @php
                                                $isPast = false;
                                                $isCurrent = ($status === $key);
                                                if($status === 'confirmed' && $key === 'pending') $isPast = true;
                                                if($status === 'completed') $isPast = true;
                                                $isActive = $isPast || $isCurrent;
                                            @endphp
                                            <div class="relative z-10 flex flex-col items-center">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center transition-all duration-500 {{ $isActive ? $step['active_color'] . ' text-white scale-110 shadow-lg' : 'bg-white text-gray-300 border-2 border-gray-100' }}">
                                                    <i class="fa-solid {{ $step['icon'] }} text-[10px]"></i>
                                                </div>
                                                <span class="absolute top-10 whitespace-nowrap text-[9px] font-black uppercase tracking-widest {{ $isActive ? 'text-gray-900' : 'text-gray-300' }}">{{ $step['label'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Notes -->
                                @if($booking->notes)
                                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 mb-2">
                                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Internal Notes</p>
                                        <p class="text-xs text-gray-600  leading-relaxed">"{{ $booking->notes }}"</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Footer -->
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center text-xs">
                                <div class="text-gray-400">Booked {{ $booking->created_at->diffForHumans() }}</div>
                                <div class="flex gap-4 items-center">
                                    @if($booking->status === 'pending')
                                        <div class="bg-amber-50 text-amber-600 px-4 py-1.5 rounded-lg text-xs font-black uppercase tracking-widest border border-amber-100 flex items-center gap-2">
                                            <i class="fa-solid fa-hourglass-start animate-spin-slow"></i> Request Pending
                                        </div>
                                    @elseif(!$booking->payment || $booking->payment->status !== 'completed')
                                        <form action="{{ route('payment.checkout', $booking) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-1.5 rounded-lg text-xs font-bold shadow-sm transition-all flex items-center gap-1">
                                                <i class="fa-solid fa-credit-card"></i> Pay Now
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-green-600 font-bold text-xs flex items-center gap-1">
                                            <i class="fa-solid fa-circle-check"></i> Paid
                                        </span>
                                    @endif
                                    <a href="{{ route('messages.index', $booking->service->user) }}" class="text-indigo-600 font-bold hover:underline flex items-center gap-1">
                                        <i class="fa-solid fa-message text-[10px]"></i> Message Vendor
                                    </a>
                                    <a href="{{ route('bookings.invoice', $booking) }}" class="text-emerald-600 font-bold hover:underline flex items-center gap-1">
                                        <i class="fa-solid fa-file-invoice text-[10px]"></i> Invoice
                                    </a>

                                    <!-- Review Button -->
                                    @if($booking->status === 'completed')
                                        @if($booking->review)
                                            <span class="text-yellow-500 font-bold text-xs flex items-center gap-1">
                                                <i class="fa-solid fa-star"></i> Rated {{ $booking->review->rating }}/5
                                            </span>
                                        @else
                                            <button @click="ratingModalOpen = true; selectedBookingId = {{ $booking->id }}" class="text-indigo-600 font-bold hover:underline flex items-center gap-1">
                                                <i class="fa-regular fa-star text-[10px]"></i> Rate Vendor
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Review Modal (AlpineJS) -->
            <div x-data="{ rating: 0, hoverRating: 0 }" x-show="ratingModalOpen" class="fixed inset-0 z-50 flex items-center justify-center px-4" style="display: none;">
                <div class="absolute inset-0 bg-gray-900 opacity-75" @click="ratingModalOpen = false"></div>
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-md z-10 p-6 transform transition-all scale-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Rate & Review Service</h3>
                        <button @click="ratingModalOpen = false" class="text-gray-400 hover:text-gray-600">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>
                    
                    <form :action="'/bookings/' + selectedBookingId + '/reviews'" method="POST">
                        @csrf
                        <div class="flex justify-center mb-6 space-x-2">
                            <template x-for="star in 5">
                                <button type="button" 
                                    @click="rating = star" 
                                    @mouseover="hoverRating = star" 
                                    @mouseleave="hoverRating = 0" 
                                    class="text-3xl focus:outline-none transition-colors duration-150"
                                    :class="(hoverRating >= star || (!hoverRating && rating >= star)) ? 'text-yellow-400' : 'text-gray-200'">
                                    <i class="fa-solid fa-star"></i>
                                </button>
                            </template>
                            <input type="hidden" name="rating" x-model="rating">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Your Feedback</label>
                            <textarea name="comment" rows="4" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="How was your experience with this vendor?"></textarea>
                        </div>
                        
                        <div class="flex justify-end gap-3">
                            <button type="button" @click="ratingModalOpen = false" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200">Cancel</button>
                            <button type="submit" :disabled="rating === 0" class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed">Submit Review</button>
                        </div>
                    </form>
                </div>
            </div>
</x-app-layout>


