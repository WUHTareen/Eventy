<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Manage Orders') }}
            </h2>
            <div class="flex gap-2">
                <span class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-bold border border-indigo-100 flex items-center">
                    <i class="fa-solid fa-list-check mr-2"></i> All Orders
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Incoming Requests</h3>
                        <p class="text-sm text-gray-500">Manage your service bookings and update statuses.</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-1 flex">
                        <button class="px-4 py-1.5 bg-indigo-50 text-indigo-700 rounded-md text-xs font-bold shadow-sm">All</button>
                        <button class="px-4 py-1.5 text-gray-500 hover:text-gray-700 rounded-md text-xs font-medium transition-colors">Pending</button>
                        <button class="px-4 py-1.5 text-gray-500 hover:text-gray-700 rounded-md text-xs font-medium transition-colors">Completed</button>
                    </div>
                </div>

                @if($bookings->isEmpty())
                    <div class="text-center py-20">
                        <div class="bg-gray-50 text-gray-400 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-clipboard text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">No Orders Yet</h3>
                        <p class="text-gray-500">When customers book your services, they will appear here.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <th class="px-8 py-5">Customer Details</th>
                                    <th class="px-6 py-5">Service & Notes</th>
                                    <th class="px-6 py-5">Date & Time</th>
                                    <th class="px-6 py-5 text-center">Status</th>
                                    <th class="px-8 py-5 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($bookings as $booking)
                                    <tr class="hover:bg-gray-50/50 transition-colors group" x-data="{ showDetails: false }">
                                        <td class="px-8 py-6">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-full border-2 border-white shadow-sm overflow-hidden flex-shrink-0 mr-4">
                                                    <img src="{{ $booking->user ? $booking->user->getAvatarUrl() : 'https://ui-avatars.com/api/?name=' . urlencode($booking->customer_name ?? 'User') }}" class="w-full h-full object-cover">
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-900">{{ $booking->customer_name ?? $booking->user->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $booking->customer_email ?? $booking->user->email }}</div>
                                                    @if($booking->customer_phone)
                                                        <div class="text-xs text-gray-500">{{ $booking->customer_phone }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 max-w-xs">
                                            <div class="text-sm font-bold text-gray-900 mb-1">{{ $booking->service->name }}</div>
                                            <div class="flex flex-wrap gap-2 mb-2">
                                                <div class="text-[10px] text-indigo-600 font-black uppercase tracking-widest bg-indigo-50 px-2 py-0.5 rounded">
                                                    {{ $booking->booking_data['package_name'] ?? 'Base Service' }}
                                                </div>
                                                @if(!empty($booking->booking_data['selected_addons']))
                                                    @foreach($booking->booking_data['selected_addons'] as $addon)
                                                        <div class="text-[10px] text-rose-500 font-black uppercase tracking-widest bg-rose-50 px-2 py-0.5 rounded">
                                                            + {{ $addon }}
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="text-[10px] text-gray-500 mb-1 font-bold">
                                                <i class="fa-solid fa-tag mr-1 text-gray-300"></i> {{ ucfirst($booking->event_type ?? 'Event') }}
                                            </div>
                                            <button @click="showDetails = true" class="text-[10px] text-indigo-400 hover:text-indigo-600 font-black uppercase tracking-widest flex items-center gap-1 transition-colors">
                                                Detailed Specs <i class="fa-solid fa-chevron-right text-[8px]"></i>
                                            </button>
                                        </td>
                                        <td class="px-6 py-6 text-sm text-gray-600">
                                            <div class="font-medium text-gray-900">{{ $booking->booking_date->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $booking->booking_date->format('h:i A') }}</div>
                                            @if($booking->guest_count)
                                                <div class="text-xs text-gray-500 mt-1">
                                                    <i class="fa-solid fa-users mr-1"></i> {{ $booking->guest_count }} Guests
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-6 text-center">
                                            @if($booking->status === 'pending')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                    Pending
                                                </span>
                                            @elseif($booking->status === 'confirmed')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                                    Confirmed
                                                </span>
                                            @elseif($booking->status === 'completed')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                                    Completed
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                                                    Cancelled
                                                </span>
                                            @endif

                                            <div class="mt-2 text-[10px] font-black uppercase tracking-tighter">
                                                @if($booking->payment && $booking->payment->status === 'completed')
                                                    <span class="text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100"><i class="fa-solid fa-check-circle"></i> Paid</span>
                                                @elseif($booking->payment && $booking->payment->status === 'awaiting_verification')
                                                    <span class="text-amber-600 bg-amber-50 px-2 py-0.5 rounded border border-amber-100"><i class="fa-solid fa-hourglass-half"></i> Verify Needed</span>
                                                @elseif($booking->payment && $booking->payment->status === 'failed')
                                                    <span class="text-red-500 bg-red-50 px-2 py-0.5 rounded border border-red-100"><i class="fa-solid fa-circle-xmark"></i> Rejected</span>
                                                @else
                                                    <span class="text-gray-400 bg-gray-50 px-2 py-0.5 rounded border border-gray-100"><i class="fa-solid fa-clock"></i> Unpaid</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                                @if($booking->user_id)
                                                    <a href="{{ route('messages.index', $booking->user_id) }}" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 p-2 rounded-lg shadow-sm transition-all hover:shadow-md" title="Message Customer">
                                                        <i class="fa-solid fa-message"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ route('bookings.invoice', $booking) }}" class="bg-emerald-50 hover:bg-emerald-100 text-emerald-600 p-2 rounded-lg shadow-sm transition-all hover:shadow-md" title="Download Invoice">
                                                    <i class="fa-solid fa-file-invoice"></i>
                                                </a>
                                                @if($booking->status === 'pending')
                                                    <form action="{{ route('vendor.orders.update', $booking->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="confirmed">
                                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-lg shadow-sm transition-all hover:shadow-md" title="Accept">
                                                            <i class="fa-solid fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('vendor.orders.update', $booking->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg shadow-sm transition-all hover:shadow-md" title="Reject">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                    </form>
                                                @elseif($booking->status === 'confirmed')
                                                    <form action="{{ route('vendor.orders.update', $booking->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-xs font-bold shadow-sm transition-all hover:shadow-indigo-500/30">
                                                            Mark Complete
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($booking->payment && in_array($booking->payment->status, ['awaiting_verification', 'completed', 'failed']))
                                                    @php
                                                        $payStyles = [
                                                            'awaiting_verification' => ['bg' => 'bg-amber-50 border-amber-100', 'text' => 'text-amber-700', 'icon' => 'fa-hourglass-half', 'label' => 'Payment Awaiting Verification'],
                                                            'completed' => ['bg' => 'bg-emerald-50 border-emerald-100', 'text' => 'text-emerald-700', 'icon' => 'fa-check-circle', 'label' => 'Payment Verified'],
                                                            'failed' => ['bg' => 'bg-red-50 border-red-100', 'text' => 'text-red-700', 'icon' => 'fa-circle-xmark', 'label' => 'Payment Rejected'],
                                                        ][$booking->payment->status];
                                                    @endphp
                                                    <div class="mt-2 w-full {{ $payStyles['bg'] }} border rounded-xl p-3 text-left">
                                                        <p class="text-[10px] font-black uppercase tracking-widest {{ $payStyles['text'] }} mb-2">
                                                            <i class="fa-solid {{ $payStyles['icon'] }}"></i> {{ $payStyles['label'] }}
                                                        </p>
                                                        <div class="text-[11px] text-gray-600 space-y-0.5 mb-2">
                                                            <div><span class="text-gray-400">Method:</span> <span class="font-bold capitalize">{{ $booking->payment->payment_method }}</span></div>
                                                            <div><span class="text-gray-400">Sender:</span> <span class="font-bold">{{ $booking->payment->sender_name ?? '—' }}</span></div>
                                                            @if($booking->payment->transaction_reference)
                                                                <div><span class="text-gray-400">Ref:</span> <span class="font-bold">{{ $booking->payment->transaction_reference }}</span></div>
                                                            @endif
                                                            <div><span class="text-gray-400">Amount:</span> <span class="font-bold text-emerald-600">PKR {{ number_format($booking->payment->amount) }}</span></div>
                                                        </div>
                                                        <div class="flex flex-wrap gap-2">
                                                            @if($booking->payment->payment_proof)
                                                                <a href="{{ asset('storage/' . $booking->payment->payment_proof) }}" target="_blank" class="text-[10px] font-bold bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 px-3 py-1.5 rounded-lg">
                                                                    <i class="fa-solid fa-image"></i> View Proof
                                                                </a>
                                                            @endif
                                                            @if($booking->payment->status === 'awaiting_verification')
                                                                <form action="{{ route('vendor.orders.payment.verify', $booking->id) }}" method="POST" onsubmit="return confirm('Verify this payment as received?')">
                                                                    @csrf @method('PUT')
                                                                    <button type="submit" class="text-[10px] font-bold bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg">
                                                                        <i class="fa-solid fa-check"></i> Verify
                                                                    </button>
                                                                </form>
                                                                <form action="{{ route('vendor.orders.payment.reject', $booking->id) }}" method="POST" onsubmit="return confirm('Reject this payment proof?')">
                                                                    @csrf @method('PUT')
                                                                    <button type="submit" class="text-[10px] font-bold bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg">
                                                                        <i class="fa-solid fa-xmark"></i> Reject
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Detail Modal -->
                                        <template x-teleport="body">
                                            <div x-show="showDetails" 
                                                 class="fixed inset-0 z-50 overflow-y-auto" 
                                                 aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak>
                                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                    <div x-show="showDetails" 
                                                         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                                         class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showDetails = false" aria-hidden="true"></div>

                                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                                    <div x-show="showDetails" 
                                                         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                         class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                        
                                                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 flex justify-between items-center">
                                                            <h3 class="text-lg leading-6 font-bold text-white" id="modal-title">
                                                                Booking Details
                                                            </h3>
                                                            <button @click="showDetails = false" class="text-white hover:text-gray-200">
                                                                <i class="fa-solid fa-times text-xl"></i>
                                                            </button>
                                                        </div>
                                                        
                                                        <div class="px-6 py-5 max-h-[70vh] overflow-y-auto">
                                                            <!-- Contact Section -->
                                                            <div class="mb-6">
                                                                <h4 class="text-sm uppercase tracking-wide text-gray-500 font-bold mb-3 border-b pb-1">Client Information</h4>
                                                                <div class="grid grid-cols-2 gap-4 text-sm">
                                                                    <div>
                                                                        <span class="block text-gray-500 text-xs">Name</span>
                                                                        <span class="font-medium text-gray-900">{{ $booking->customer_name }}</span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="block text-gray-500 text-xs">Service</span>
                                                                        <span class="font-medium text-indigo-600">{{ $booking->service->name }}</span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="block text-gray-500 text-xs">Email</span>
                                                                        <span class="font-medium text-gray-900">{{ $booking->customer_email }}</span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="block text-gray-500 text-xs">Phone</span>
                                                                        <span class="font-medium text-gray-900">{{ $booking->customer_phone }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Event Section -->
                                                            <div class="mb-6">
                                                                <h4 class="text-sm uppercase tracking-wide text-gray-500 font-bold mb-3 border-b pb-1">Event Details</h4>
                                                                <div class="grid grid-cols-2 gap-4 text-sm">
                                                                    <div>
                                                                        <span class="block text-gray-500 text-xs">Event Type</span>
                                                                        <span class="font-medium text-gray-900 capitalize">{{ $booking->event_type }}</span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="block text-gray-500 text-xs">Guests</span>
                                                                        <span class="font-medium text-gray-900">{{ $booking->guest_count }} People</span>
                                                                    </div>
                                                                    <div>
                                                                        <span class="block text-gray-500 text-xs">Start Time</span>
                                                                        <span class="font-medium text-gray-900">{{ $booking->booking_date->format('M d, Y h:i A') }}</span>
                                                                    </div>
                                                                    @if($booking->event_end_date)
                                                                    <div>
                                                                        <span class="block text-gray-500 text-xs">End Time</span>
                                                                        <span class="font-medium text-gray-900">{{ $booking->event_end_date->format('M d, Y h:i A') }}</span>
                                                                    </div>
                                                                    @endif
                                                                    <div class="col-span-2">
                                                                        <span class="block text-gray-500 text-xs">Location</span>
                                                                        <span class="font-medium text-gray-900">{{ $booking->event_location }}</span>
                                                                        @if($booking->event_address)
                                                                            <span class="text-gray-500 text-xs block mt-1">({{ $booking->event_address }})</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Requirements Section -->
                                                            <div>
                                                                <h4 class="text-sm uppercase tracking-wide text-gray-500 font-bold mb-3 border-b pb-1">Requirements</h4>
                                                                <div class="space-y-4 text-sm">
                                                                    @if($booking->budget)
                                                                    <div>
                                                                        <span class="block text-gray-500 text-xs">Budget</span>
                                                                        <span class="font-medium text-green-600">PKR {{ number_format($booking->budget) }}</span>
                                                                    </div>
                                                                    @endif

                                                                    <!-- Specialized Data Display -->
                                                                    @if($booking->booking_data)
                                                                    <div class="bg-indigo-50/50 p-4 rounded-2xl border border-indigo-100">
                                                                        <span class="block text-indigo-700 text-[10px] font-black uppercase tracking-widest mb-3">Specialized Specifications</span>
                                                                        <div class="grid grid-cols-2 gap-y-3 gap-x-4">
                                                                            @foreach($booking->booking_data as $key => $value)
                                                                                @if(!is_array($value))
                                                                                    <div>
                                                                                        <span class="block text-gray-500 text-[9px] uppercase font-bold">{{ str_replace('_', ' ', $key) }}</span>
                                                                                        <span class="text-gray-900 font-bold capitalize">{{ $value }}</span>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="col-span-2">
                                                                                        <span class="block text-gray-500 text-[9px] uppercase font-bold">{{ str_replace('_', ' ', $key) }}</span>
                                                                                        <div class="flex flex-wrap gap-2 mt-1">
                                                                                            @foreach($value as $item)
                                                                                                <span class="px-2 py-0.5 bg-white border border-indigo-200 text-indigo-700 text-[10px] font-bold rounded-md capitalize">{{ str_replace('_', ' ', $item) }}</span>
                                                                                            @endforeach
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    
                                                                    @if($booking->notes)
                                                                    <div>
                                                                        <span class="block text-gray-500 text-xs mb-1">General Notes</span>
                                                                        <div class="bg-gray-50 p-3 rounded-lg text-gray-700  border border-gray-100">
                                                                            "{{ $booking->notes }}"
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    
                                                                    @if($booking->special_requests)
                                                                    <div>
                                                                        <span class="block text-gray-500 text-xs mb-1">Special Internal Alerts</span>
                                                                        <div class="bg-amber-50 p-3 rounded-lg text-amber-900 border border-amber-100">
                                                                            {{ $booking->special_requests }}
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-gray-100 gap-2">
                                                            @if($booking->status === 'pending')
                                                                <form action="{{ route('vendor.orders.update', $booking->id) }}" method="POST" class="inline-block">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="status" value="confirmed">
                                                                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none sm:w-auto sm:text-sm">
                                                                        Accept Order
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            <button type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm" @click="showDetails = false">
                                                                Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>


