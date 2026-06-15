<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    <i class="fa-solid fa-calendar-check text-primary-500 mr-2"></i>{{ __('All Bookings') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Monitor all platform bookings</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-5 rounded-xl transition-all flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50/50 to-white flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Bookings List</h3>
                        <p class="text-gray-500 text-sm">{{ $bookings->total() }} total bookings</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-4">Customer</th>
                                <th class="px-6 py-4">Service</th>
                                <th class="px-6 py-4">Vendor</th>
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4">Created</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($bookings as $booking)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                                                {{ substr($booking->user->name ?? 'U', 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $booking->user->name ?? 'Unknown' }}</p>
                                                <p class="text-xs text-gray-500">{{ $booking->user->email ?? '' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-900">{{ Str::limit($booking->service->name ?? 'Unknown', 25) }}</p>
                                        <div class="flex items-center gap-2">
                                            <p class="text-[10px] font-black text-indigo-600 uppercase tracking-tighter">
                                                PKR {{ number_format($booking->total_price ?? ($booking->service->price ?? 0)) }}
                                            </p>
                                            @if(!empty($booking->booking_data['package_name']))
                                                <span class="text-[8px] bg-indigo-50 text-indigo-500 px-1.5 py-0.5 rounded font-bold uppercase">{{ $booking->booking_data['package_name'] }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-gray-700">{{ $booking->vendor->name ?? 'Unknown' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-900">{{ $booking->booking_date->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-500">{{ $booking->booking_date->format('h:i A') }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($booking->status === 'pending')
                                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Pending</span>
                                        @elseif($booking->status === 'confirmed')
                                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">Confirmed</span>
                                        @elseif($booking->status === 'completed')
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Completed</span>
                                        @else
                                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">Cancelled</span>
                                        @endif
                                        
                                        <div class="mt-1">
                                            @if($booking->payment && $booking->payment->status === 'completed')
                                                <span class="text-[10px] font-bold text-green-600 uppercase">Paid</span>
                                            @else
                                                <span class="text-[10px] font-bold text-gray-400 uppercase">Unpaid</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $booking->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('bookings.invoice', $booking) }}" class="text-indigo-600 hover:text-indigo-900 font-bold flex items-center justify-end gap-1">
                                            <i class="fa-solid fa-download"></i> Invoice
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <i class="fa-solid fa-calendar-xmark text-gray-300 text-4xl mb-3"></i>
                                        <p class="text-gray-500">No bookings found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($bookings->hasPages())
                    <div class="p-6 border-t border-gray-100">
                        {{ $bookings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>


