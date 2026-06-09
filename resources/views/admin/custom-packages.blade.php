<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Custom Ensembles') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Oversee high-level custom package bookings.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold py-2.5 px-5 rounded-xl shadow-sm transition-all flex items-center gap-2 hover:shadow-md">
                <i class="fa-solid fa-arrow-left text-gray-400"></i> Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($bookings->isEmpty())
                <div class="bg-white rounded-3xl p-16 text-center border border-gray-100 shadow-sm">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl text-gray-400">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">No Custom Ensembles</h3>
                    <p class="text-gray-500">There are no custom package bookings in the system yet.</p>
                </div>
            @else
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                                    <th class="p-6">ID</th>
                                    <th class="p-6">Customer</th>
                                    <th class="p-6">Ensemble Details</th>
                                    <th class="p-6">Execution Date</th>
                                    <th class="p-6">Status</th>
                                    <th class="p-6 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($bookings as $booking)
                                    <tr class="hover:bg-gray-50/50 transition-colors group">
                                        <td class="p-6">
                                            <span class="font-mono text-xs font-bold text-gray-400">#{{ $booking->id }}</span>
                                        </td>
                                        <td class="p-6">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-500 text-xs font-bold">
                                                    {{ substr($booking->customer_name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-900">{{ $booking->customer_name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $booking->customer_email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-6">
                                            <div class="font-bold text-gray-900">{{ $booking->customPackage->name }}</div>
                                            <div class="text-xs text-primary-600 font-bold">PKR {{ number_format($booking->total_amount) }}</div>
                                        </td>
                                        <td class="p-6">
                                            <div class="font-bold text-gray-900">{{ $booking->booking_date->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $booking->booking_date->format('g:i A') }}</div>
                                        </td>
                                        <td class="p-6">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold capitalize
                                                {{ $booking->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : '' }}
                                                {{ $booking->status === 'confirmed' ? 'bg-green-50 text-green-700' : '' }}
                                                {{ $booking->status === 'completed' ? 'bg-gray-100 text-gray-700' : '' }}
                                                {{ $booking->status === 'cancelled' ? 'bg-red-50 text-red-700' : '' }}">
                                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                                {{ $booking->status }}
                                            </span>
                                        </td>
                                        <td class="p-6 text-right">
                                        <a href="{{ route('admin.custom-packages.show', $booking) }}" class="text-gray-400 hover:text-primary-600 transition-colors" title="View Details">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-6 border-t border-gray-100">
                        {{ $bookings->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>


