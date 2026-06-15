<x-public-layout>
    <div class="max-w-6xl mx-auto px-4 py-10">
        {{-- Header --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <img src="{{ $hotel->getCoverImageUrl() }}" class="w-full h-72 object-cover">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-black text-gray-800">{{ $hotel->name }}</h1>
                        <p class="text-gray-500 mt-1"><i class="fa-solid fa-location-dot mr-1 text-indigo-500"></i>{{ $hotel->address }}, {{ $hotel->city->name ?? '' }}</p>
                        <p class="text-yellow-500 mt-1 text-lg">{{ str_repeat('⭐', $hotel->star_rating) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-400 text-sm">Starting from</p>
                        <p class="text-3xl font-black text-indigo-600">Rs. {{ number_format($hotel->getMinPrice()) }}</p>
                        <p class="text-gray-400 text-xs">per night</p>
                    </div>
                </div>
                <p class="text-gray-600 mt-4">{{ $hotel->description }}</p>

                {{-- Amenities --}}
                @if($hotel->amenities)
                <div class="flex flex-wrap gap-2 mt-4">
                    @foreach($hotel->amenities as $amenity)
                        <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-bold">✓ {{ $amenity }}</span>
                    @endforeach
                </div>
                @endif

                {{-- Contact --}}
                <div class="flex gap-4 mt-4 text-sm text-gray-500">
                    @if($hotel->phone) <span><i class="fa-solid fa-phone mr-1"></i>{{ $hotel->phone }}</span> @endif
                    @if($hotel->email) <span><i class="fa-solid fa-envelope mr-1"></i>{{ $hotel->email }}</span> @endif
                </div>
            </div>
        </div>

        {{-- Rooms --}}
        <h2 class="text-2xl font-black text-gray-800 mb-4">Available Rooms</h2>

        @if($hotel->rooms->isEmpty())
            <div class="bg-white rounded-2xl p-10 text-center text-gray-400 border border-gray-100">
                <i class="fa-solid fa-bed text-4xl mb-3"></i>
                <p>No rooms available yet.</p>
            </div>
        @else
        <div class="space-y-4">
            @foreach($hotel->rooms as $room)
            @if($room->is_available)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row gap-5">
                @if($room->image)
                <img src="{{ asset('storage/' . $room->image) }}" class="w-full md:w-48 h-36 object-cover rounded-xl">
                @else
                <div class="w-full md:w-48 h-36 bg-slate-100 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-bed text-slate-400 text-3xl"></i>
                </div>
                @endif
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">{{ $room->name }}</h3>
                            <p class="text-gray-500 text-sm mt-1">👥 Max {{ $room->capacity }} guests • 🛏 {{ $room->total_rooms }} room(s)</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-black text-indigo-600">Rs. {{ number_format($room->price_per_night) }}</p>
                            <p class="text-gray-400 text-xs">per night</p>
                        </div>
                    </div>
                    @if($room->description)
                        <p class="text-gray-600 text-sm mt-2">{{ $room->description }}</p>
                    @endif
                    @if($room->amenities)
                    <div class="flex flex-wrap gap-1 mt-2">
                        @foreach($room->amenities as $a)
                            <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded text-xs">{{ $a }}</span>
                        @endforeach
                    </div>
                    @endif
                    <a href="{{ route('hotels.book', [$hotel, $room]) }}" class="mt-4 inline-block bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-indigo-700 transition">
                        Book This Room →
                    </a>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        @endif
    </div>
</x-public-layout>
