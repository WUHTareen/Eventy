<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800"><i class="fa-solid fa-hotel text-indigo-600 mr-2"></i> My Hotel Dashboard</h2>
            @if(!$hotel)
            <a href="{{ route('hotel.vendor.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-indigo-700 transition">
                <i class="fa-solid fa-plus mr-1"></i> Register Hotel
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 font-medium">✓ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 font-medium">⚠ {{ session('error') }}</div>
            @endif

            @if(!$hotel)
            {{-- No Hotel --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <i class="fa-solid fa-hotel text-5xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Register Your Hotel</h3>
                <p class="text-gray-500 mb-6">You haven't registered a hotel yet. Register now to start accepting bookings!</p>
                <a href="{{ route('hotel.vendor.create') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-plus mr-2"></i> Register Hotel
                </a>
            </div>

            @else

            {{-- Hotel Info Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <img src="{{ $hotel->getCoverImageUrl() }}" class="w-full h-40 object-cover">
                <div class="p-6 flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-xl text-gray-800">{{ $hotel->name }}</h3>
                        <p class="text-gray-500 text-sm mt-1"><i class="fa-solid fa-location-dot mr-1 text-indigo-400"></i>{{ $hotel->city->name ?? '' }} — {{ $hotel->address }}</p>
                        <p class="text-yellow-500 mt-1">{{ str_repeat('⭐', $hotel->star_rating) }}</p>
                    </div>
                    <div class="flex flex-col gap-2 items-end">
                        <span class="px-4 py-1.5 rounded-full text-sm font-bold {{ $hotel->status === 'approved' ? 'bg-green-50 text-green-600' : ($hotel->status === 'rejected' ? 'bg-red-50 text-red-600' : 'bg-yellow-50 text-yellow-600') }}">
                            {{ ucfirst($hotel->status) }}
                        </span>
                        <a href="{{ route('hotel.vendor.edit') }}" class="bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-4 py-1.5 rounded-xl text-sm font-bold transition">
                            <i class="fa-solid fa-pen mr-1"></i> Edit Hotel
                        </a>
                        <form action="{{ route('hotel.vendor.destroy') }}" method="POST" onsubmit="return confirm('Delete your hotel? All rooms and bookings will be lost!')">
                            @csrf @method('DELETE')
                            <button class="bg-red-50 text-red-500 hover:bg-red-100 px-4 py-1.5 rounded-xl text-sm font-bold transition">
                                <i class="fa-solid fa-trash mr-1"></i> Delete Hotel
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            @if($hotel->status === 'pending')
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 text-yellow-700 mb-6">
                <i class="fa-solid fa-clock mr-2"></i> Your hotel is <strong>pending approval</strong>. Admin will review and approve soon.
            </div>
            @elseif($hotel->status === 'rejected')
            <div class="bg-red-50 border border-red-200 rounded-xl p-5 text-red-700 mb-6">
                <i class="fa-solid fa-times mr-2"></i> Your hotel was <strong>rejected</strong>. Please contact admin for details.
            </div>
            @else

            {{-- Add Room --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="font-bold text-lg text-gray-800 mb-4"><i class="fa-solid fa-plus text-indigo-500 mr-2"></i>Add New Room</h3>
                <form method="POST" action="{{ route('hotel.vendor.addRoom') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div><label class="block text-xs font-bold text-gray-500 mb-1">Room Name</label>
                        <input type="text" name="name" placeholder="Deluxe, Suite..." class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500" required></div>
                        <div><label class="block text-xs font-bold text-gray-500 mb-1">Price/Night (Rs.)</label>
                        <input type="number" name="price_per_night" placeholder="5000" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500" required></div>
                        <div><label class="block text-xs font-bold text-gray-500 mb-1">Max Guests</label>
                        <input type="number" name="capacity" placeholder="2" min="1" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500" required></div>
                        <div><label class="block text-xs font-bold text-gray-500 mb-1">Total Rooms</label>
                        <input type="number" name="total_rooms" placeholder="5" min="1" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500" required></div>
                        <div><label class="block text-xs font-bold text-gray-500 mb-1">Room Image</label>
                        <input type="file" name="image" accept="image/*" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm"></div>
                        <div><label class="block text-xs font-bold text-gray-500 mb-1">Description</label>
                        <input type="text" name="description" placeholder="Brief description" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500"></div>
                    </div>
                    <button type="submit" class="mt-4 bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold text-sm hover:bg-indigo-700 transition">Add Room</button>
                </form>
            </div>

            {{-- Rooms --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="font-bold text-lg text-gray-800 mb-4">My Rooms ({{ $hotel->rooms->count() }})</h3>
                @if($hotel->rooms->isEmpty())
                    <p class="text-gray-400 text-center py-6">No rooms added yet.</p>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($hotel->rooms as $room)
                    <div class="border border-gray-100 rounded-xl p-4 flex gap-4 items-start">
                        @if($room->image)
                            <img src="{{ asset('storage/' . $room->image) }}" class="w-20 h-20 object-cover rounded-lg">
                        @else
                            <div class="w-20 h-20 bg-slate-100 rounded-lg flex items-center justify-center"><i class="fa-solid fa-bed text-slate-400 text-2xl"></i></div>
                        @endif
                        <div class="flex-1">
                            <p class="font-bold text-gray-800">{{ $room->name }}</p>
                            <p class="text-indigo-600 font-bold text-sm">Rs. {{ number_format($room->price_per_night) }}/night</p>
                            <p class="text-gray-500 text-xs">👥 {{ $room->capacity }} guests • 🛏 {{ $room->total_rooms }} rooms</p>
                        </div>
                        <form action="{{ route('hotel.vendor.deleteRoom', $room) }}" method="POST" onsubmit="return confirm('Delete this room?')">
                            @csrf @method('DELETE')
                            <button class="text-red-400 hover:text-red-600 transition text-sm"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Bookings --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b"><h3 class="font-bold text-gray-800">My Bookings ({{ $bookings->count() }})</h3></div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase">
                            <tr>
                                <th class="px-6 py-3 text-left">Guest</th>
                                <th class="px-6 py-3 text-left">Room</th>
                                <th class="px-6 py-3 text-left">Dates</th>
                                <th class="px-6 py-3 text-left">Earnings</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="px-6 py-3 text-left">Update</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($bookings as $b)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 text-sm">
                                    <p class="font-semibold">{{ $b->guest_name }}</p>
                                    <p class="text-gray-400 text-xs">{{ $b->guest_phone }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $b->room->name }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <p>{{ $b->check_in->format('d M Y') }}</p>
                                    <p class="text-gray-400 text-xs">→ {{ $b->check_out->format('d M Y') }} ({{ $b->nights }} nights)</p>
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-green-600">Rs. {{ number_format($b->vendor_amount) }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $b->status === 'confirmed' ? 'bg-green-50 text-green-600' : ($b->status === 'cancelled' ? 'bg-red-50 text-red-600' : ($b->status === 'completed' ? 'bg-blue-50 text-blue-600' : 'bg-yellow-50 text-yellow-600')) }}">
                                        {{ ucfirst($b->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('hotel.vendor.updateBooking', $b) }}" method="POST" class="flex gap-2">
                                        @csrf @method('PUT')
                                        <select name="status" class="border border-gray-200 rounded-lg px-2 py-1 text-xs outline-none">
                                            <option value="pending" {{ $b->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed" {{ $b->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="completed" {{ $b->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $b->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded-lg text-xs font-bold hover:bg-indigo-700">Save</button>
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
            @endif
            @endif
        </div>
    </div>
</x-app-layout>
