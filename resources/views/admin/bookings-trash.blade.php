<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    <i class="fa-solid fa-trash-can text-amber-600 mr-2"></i>{{ __('Trashed Bookings') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Restore deleted bookings or remove them permanently</p>
            </div>
            <a href="{{ route('admin.bookings') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-5 rounded-xl transition-all flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50/50 to-white">
                    <h3 class="text-lg font-bold text-gray-800">Trashed Bookings</h3>
                    <p class="text-gray-500 text-sm">{{ $bookings->total() }} booking(s) in trash</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-4">Customer</th>
                                <th class="px-6 py-4">Service</th>
                                <th class="px-6 py-4">Vendor</th>
                                <th class="px-6 py-4">Deleted At</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($bookings as $booking)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-900">{{ $booking->user->name ?? $booking->customer_name ?? 'Unknown' }}</p>
                                        <p class="text-xs text-gray-500">{{ $booking->user->email ?? $booking->customer_email ?? '' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-900">{{ Str::limit($booking->service->name ?? 'Unknown', 25) }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-gray-700">{{ $booking->vendor->name ?? 'Unknown' }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $booking->deleted_at?->format('d M Y, h:i A') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <form action="{{ route('admin.bookings.restore', $booking->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="px-4 py-2 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg font-bold text-sm flex items-center gap-2 transition-all" title="Restore">
                                                    <i class="fa-solid fa-rotate-left"></i> Restore
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.bookings.force-delete', $booking->id) }}" method="POST" onsubmit="return confirm('Permanently delete this booking? This cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-9 h-9 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg flex items-center justify-center transition-all" title="Delete Permanently">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <i class="fa-solid fa-box-open text-gray-300 text-4xl mb-3"></i>
                                        <p class="text-gray-500">Trash is empty</p>
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
