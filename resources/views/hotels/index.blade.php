<x-public-layout>
    <div class="bg-slate-900 py-16">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-4xl font-black text-white mb-2">🏨 Hotels</h1>
            <p class="text-slate-400">Find and book the perfect hotel for your stay</p>

            {{-- Filters --}}
            <form method="GET" class="mt-6 flex flex-wrap gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search hotels..." class="bg-white/10 text-white placeholder-slate-400 border border-white/10 rounded-xl px-4 py-2.5 text-sm w-52 outline-none focus:ring-2 focus:ring-indigo-500">
                <select name="city_id" class="bg-white/10 text-white border border-white/10 rounded-xl px-4 py-2.5 text-sm outline-none">
                    <option value="">All Cities</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }} class="text-black">{{ $city->name }}</option>
                    @endforeach
                </select>
                <select name="stars" class="bg-white/10 text-white border border-white/10 rounded-xl px-4 py-2.5 text-sm outline-none">
                    <option value="">All Stars</option>
                    @foreach([5,4,3,2,1] as $s)
                        <option value="{{ $s }}" {{ request('stars') == $s ? 'selected' : '' }} class="text-black">{{ $s }} Stars</option>
                    @endforeach
                </select>
                <button class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-indigo-700 transition">Search</button>
                <a href="{{ route('hotels.index') }}" class="bg-white/10 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-white/20 transition">Reset</a>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-12">
        @if($hotels->isEmpty())
            <div class="text-center py-20 text-gray-400">
                <i class="fa-solid fa-hotel text-5xl mb-4"></i>
                <p class="text-xl font-bold">No hotels found</p>
            </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($hotels as $hotel)
            <a href="{{ route('hotels.show', $hotel) }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition group">
                <div class="h-48 overflow-hidden bg-gray-100">
                    <img src="{{ $hotel->getCoverImageUrl() }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-5">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-bold text-gray-800 text-lg">{{ $hotel->name }}</h3>
                        <span class="text-yellow-500 text-sm">{{ str_repeat('⭐', $hotel->star_rating) }}</span>
                    </div>
                    <p class="text-gray-500 text-sm mb-3"><i class="fa-solid fa-location-dot mr-1"></i>{{ $hotel->city->name ?? '' }}, {{ $hotel->address }}</p>
                    <p class="text-gray-600 text-sm line-clamp-2 mb-4">{{ $hotel->description }}</p>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-xs text-gray-400">Starting from</span>
                            <p class="text-indigo-600 font-black text-xl">Rs. {{ number_format($hotel->getMinPrice()) }}<span class="text-gray-400 text-xs font-normal">/night</span></p>
                        </div>
                        <span class="bg-indigo-50 text-indigo-600 px-4 py-2 rounded-xl text-sm font-bold">View Rooms →</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div class="mt-8">{{ $hotels->links() }}</div>
        @endif
    </div>
</x-public-layout>
