<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800"><i class="fa-solid fa-hotel text-[#0A3A7A] mr-2"></i> {{ $hotel->name }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.hotels.edit', $hotel) }}" class="bg-indigo-600 text-white px-5 py-2 rounded-xl font-bold text-sm hover:bg-indigo-700 transition"><i class="fa-solid fa-pen mr-1"></i> Edit Hotel</a>
                <a href="{{ route('admin.hotels.index') }}" class="bg-white border border-gray-200 text-gray-700 px-5 py-2 rounded-xl font-bold text-sm hover:bg-gray-50 transition">← Back</a>
            </div>
        </div>
    </x-slot>
    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-50 border border-green-200 rounded-xl text-green-700">✓ {{ session('success') }}</div>
            @endif

            {{-- Hotel Info --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <img src="{{ $hotel->getCoverImageUrl() }}" class="w-full h-52 object-cover">
                <div class="p-6 flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-xl text-gray-800">{{ $hotel->name }}</h3>
                        <p class="text-gray-500 text-sm mt-1">{{ $hotel->city->name ?? '' }} — {{ $hotel->address }}</p>
                        <p class="text-yellow-500 mt-1">{{ str_repeat('⭐', $hotel->star_rating) }}</p>
                        <p class="text-gray-600 mt-2 text-sm">{{ $hotel->description }}</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold text-center {{ $hotel->status === 'approved' ? 'bg-green-50 text-green-600' : 'bg-yellow-50 text-yellow-600' }}">{{ ucfirst($hotel->status) }}</span>
                        @if($hotel->status === 'pending')
                        <form action="{{ route('admin.hotels.approve', $hotel) }}" method="POST">
                            @csrf @method('PUT')
                            <button class="w-full bg-green-600 text-white px-4 py-1.5 rounded-xl text-xs font-bold hover:bg-green-700 transition">✓ Approve</button>
                        </form>
                        @endif
                        <form action="{{ route('admin.hotels.featured', $hotel) }}" method="POST">
                            @csrf @method('PUT')
                            <button class="w-full bg-yellow-50 text-yellow-600 px-4 py-1.5 rounded-xl text-xs font-bold hover:bg-yellow-100 transition">{{ $hotel->is_featured ? '★ Unfeature' : '☆ Feature' }}</button>
                        </form>
                        <form action="{{ route('admin.hotels.destroy', $hotel) }}" method="POST" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="w-full bg-red-50 text-red-600 px-4 py-1.5 rounded-xl text-xs font-bold hover:bg-red-100 transition">🗑 Delete</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Add Room --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-lg text-gray-800 mb-4">Add Room to This Hotel</h3>
                <form method="POST" action="{{ route('admin.hotels.rooms.store', $hotel) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div><label class="block text-xs font-bold text-gray-500 mb-1">Room Name</label>
                        <input type="text" name="name" placeholder="Deluxe Room" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500" required></div>
                        <div><label class="block text-xs font-bold text-gray-500 mb-1">Price/Night (Rs.)</label>
                        <input type="number" name="price_per_night" placeholder="5000" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500" required></div>
                        <div><label class="block text-xs font-bold text-gray-500 mb-1">Max Guests</label>
                        <input type="number" name="capacity" placeholder="2" min="1" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500" required></div>
                        <div><label class="block text-xs font-bold text-gray-500 mb-1">Total Rooms</label>
                        <input type="number" name="total_rooms" placeholder="5" min="1" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500" required></div>
                        <div class="md:col-span-2"><label class="block text-xs font-bold text-gray-500 mb-1">Description</label>
                        <input type="text" name="description" placeholder="Room description" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500"></div>
                        <div><label class="block text-xs font-bold text-gray-500 mb-1">Room Image</label>
                        <input type="file" name="image" accept="image/*" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm"></div>
                        <div class="flex items-end"><button type="submit" class="w-full bg-[#0A3A7A] text-white py-2 rounded-xl font-bold text-sm hover:bg-[#0D4E9A] transition">Add Room</button></div>
                    </div>
                </form>
            </div>

            {{-- Rooms List --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-lg text-gray-800 mb-4">Rooms ({{ $hotel->rooms->count() }})</h3>
                @if($hotel->rooms->isEmpty())
                    <p class="text-gray-400 text-center py-6">No rooms yet.</p>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($hotel->rooms as $room)
                    <div class="border border-gray-100 rounded-xl p-4 flex gap-4 items-start">
                        @if($room->image)
                            <img src="{{ asset('storage/' . $room->image) }}" class="w-20 h-20 object-cover rounded-lg">
                        @endif
                        <div class="flex-1">
                            <p class="font-bold text-gray-800">{{ $room->name }}</p>
                            <p class="text-indigo-600 font-bold">Rs. {{ number_format($room->price_per_night) }}/night</p>
                            <p class="text-gray-500 text-xs">👥 {{ $room->capacity }} guests • 🛏 {{ $room->total_rooms }} rooms</p>
                        </div>
                        <form action="{{ route('admin.hotels.rooms.destroy', [$hotel, $room]) }}" method="POST" onsubmit="return confirm('Delete room?')">
                            @csrf @method('DELETE')
                            <button class="text-red-400 hover:text-red-600 text-xs font-bold transition"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Bookings --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b"><h3 class="font-bold text-gray-800">Bookings ({{ $hotel->bookings->count() }})</h3></div>
                <table class="min-w-full">
                    <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left">Guest</th>
                            <th class="px-6 py-3 text-left">Room</th>
                            <th class="px-6 py-3 text-left">Dates</th>
                            <th class="px-6 py-3 text-left">Total</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Update</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($hotel->bookings as $b)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-sm">{{ $b->guest_name }}</td>
                            <td class="px-6 py-4 text-sm">{{ $b->room->name }}</td>
                            <td class="px-6 py-4 text-sm">{{ $b->check_in->format('d M') }} → {{ $b->check_out->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm font-bold">Rs. {{ number_format($b->total_amount) }}</td>
                            <td class="px-6 py-4"><span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-50 text-yellow-600">{{ ucfirst($b->status) }}</span></td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.hotels.bookings.update', $b) }}" method="POST" class="flex gap-2">
                                    @csrf @method('PUT')
                                    <select name="status" class="border border-gray-200 rounded-lg px-2 py-1 text-xs outline-none">
                                        <option value="pending" {{ $b->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $b->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="completed" {{ $b->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $b->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded-lg text-xs font-bold hover:bg-indigo-700">Update</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">No bookings yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
