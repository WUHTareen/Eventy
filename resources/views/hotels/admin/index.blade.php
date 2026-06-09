<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800"><i class="fa-solid fa-hotel text-[#0A3A7A] mr-2"></i> Hotel Management</h2>
                <p class="text-gray-500 text-sm mt-1">Add, approve, edit and manage all hotels</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.hotels.create') }}" class="bg-[#0A3A7A] text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-[#0D4E9A] transition flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Add Hotel
                </a>
                <a href="{{ route('admin.hotels.bookings') }}" class="bg-white border border-gray-200 text-gray-700 px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-gray-50 transition flex items-center gap-2">
                    <i class="fa-solid fa-calendar-check"></i> All Bookings
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 font-medium">✓ {{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b">
                    <h3 class="font-bold text-gray-800">All Hotels <span class="text-gray-400 font-normal text-sm">({{ $hotels->total() }} total)</span></h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase">
                            <tr>
                                <th class="px-6 py-4 text-left">Hotel</th>
                                <th class="px-6 py-4 text-left">Owner</th>
                                <th class="px-6 py-4 text-left">City</th>
                                <th class="px-6 py-4 text-left">Stars</th>
                                <th class="px-6 py-4 text-left">Rooms</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($hotels as $hotel)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $hotel->getCoverImageUrl() }}" class="w-12 h-12 rounded-xl object-cover">
                                        <div>
                                            <p class="font-semibold text-gray-800 text-sm">{{ $hotel->name }}</p>
                                            @if($hotel->is_featured) <span class="text-xs text-yellow-600 font-bold">⭐ Featured</span> @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $hotel->user->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $hotel->city->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm">{{ str_repeat('⭐', $hotel->star_rating) }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-indigo-600">{{ $hotel->rooms->count() }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $hotel->status === 'approved' ? 'bg-green-50 text-green-600' : ($hotel->status === 'rejected' ? 'bg-red-50 text-red-600' : 'bg-yellow-50 text-yellow-600') }}">
                                        {{ ucfirst($hotel->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2 flex-wrap">
                                        <a href="{{ route('admin.hotels.show', $hotel) }}" class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                            <i class="fa-solid fa-eye"></i> View
                                        </a>
                                        <a href="{{ route('admin.hotels.edit', $hotel) }}" class="bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                            <i class="fa-solid fa-pen"></i> Edit
                                        </a>
                                        @if($hotel->status === 'pending')
                                        <form action="{{ route('admin.hotels.approve', $hotel) }}" method="POST" class="inline">
                                            @csrf @method('PUT')
                                            <button class="bg-green-50 text-green-600 hover:bg-green-100 px-3 py-1.5 rounded-lg text-xs font-bold">✓ Approve</button>
                                        </form>
                                        @endif
                                        <form action="{{ route('admin.hotels.featured', $hotel) }}" method="POST" class="inline">
                                            @csrf @method('PUT')
                                            <button class="bg-yellow-50 text-yellow-600 hover:bg-yellow-100 px-3 py-1.5 rounded-lg text-xs font-bold">
                                                {{ $hotel->is_featured ? '★ Unfeature' : '☆ Feature' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.hotels.destroy', $hotel) }}" method="POST" class="inline" onsubmit="return confirm('Delete this hotel?')">
                                            @csrf @method('DELETE')
                                            <button class="bg-red-50 text-red-600 hover:bg-red-100 px-3 py-1.5 rounded-lg text-xs font-bold">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">No hotels found. <a href="{{ route('admin.hotels.create') }}" class="text-indigo-600 font-bold">Add one now →</a></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-5 border-t">{{ $hotels->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
