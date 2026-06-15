<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800"><i class="fa-solid fa-calendar-check text-[#0A3A7A] mr-2"></i> Hotel Bookings</h2>
    </x-slot>
    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b"><h3 class="font-bold text-gray-800">All Hotel Bookings ({{ $bookings->total() }})</h3></div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase">
                            <tr>
                                <th class="px-6 py-4 text-left">#</th>
                                <th class="px-6 py-4 text-left">Guest</th>
                                <th class="px-6 py-4 text-left">Hotel</th>
                                <th class="px-6 py-4 text-left">Room</th>
                                <th class="px-6 py-4 text-left">Dates</th>
                                <th class="px-6 py-4 text-left">Total</th>
                                <th class="px-6 py-4 text-left">Commission</th>
                                <th class="px-6 py-4 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($bookings as $b)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 text-sm text-gray-400">#{{ $b->id }}</td>
                                <td class="px-6 py-4 text-sm">{{ $b->guest_name }}</td>
                                <td class="px-6 py-4 text-sm font-semibold">{{ $b->hotel->name }}</td>
                                <td class="px-6 py-4 text-sm">{{ $b->room->name }}</td>
                                <td class="px-6 py-4 text-sm">{{ $b->check_in->format('d M') }} → {{ $b->check_out->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-800">Rs. {{ number_format($b->total_amount) }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-green-600">Rs. {{ number_format($b->commission_amount) }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $b->status === 'confirmed' ? 'bg-green-50 text-green-600' : 'bg-yellow-50 text-yellow-600' }}">
                                        {{ ucfirst($b->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="px-6 py-12 text-center text-gray-400">No bookings yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-5 border-t">{{ $bookings->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
