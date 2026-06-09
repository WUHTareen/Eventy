@if($searchResults && $searchResults->count() > 0)
<div id="search-results" class="bg-gray-50 py-24 scroll-mt-20">
    <div class="max-w-[1400px] mx-auto ">
        <div class="flex items-center justify-between mb-8 px-6">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Search Results</h2>
                <p class="text-gray-600">Showing results for "{{ $searchQuery ?? 'your search' }}"</p>
            </div>
            <a href="{{ route('home') }}" class="text-sm font-semibold text-[#0A3A7A] hover:text-[#ED1C24] transition-colors">
                Clear Search
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-6">
            @foreach($searchResults as $service)
                <div class="group bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                    <!-- Service Image -->
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $service->image_url ?? 'https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=600&auto=format&fit=crop' }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" 
                             alt="{{ $service->name }}">
                        <div class="absolute top-4 right-4">
                            <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-[#0A3A7A]">
                                {{ $service->category->name ?? 'Service' }}
                            </span>
                        </div>
                    </div>

                    <!-- Service Content -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-[#0A3A7A] transition-colors line-clamp-1">
                            {{ $service->name }}
                        </h3>
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fa-solid fa-location-dot text-[#ED1C24] text-xs"></i>
                            <span class="text-sm text-gray-600">{{ $service->location ?? 'Unknown Location' }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center overflow-hidden">
                                    @if($service->user->avatar)
                                        <img src="{{ $service->user->avatar }}" alt="{{ $service->user->business_name }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fa-solid fa-user text-gray-400 text-xs"></i>
                                    @endif
                                </div>
                                <span class="text-xs font-semibold text-gray-700">{{ $service->user->business_name ?? $service->user->name }}</span>
                            </div>
                            <a href="{{ route('services.show', $service->id) }}" class="text-sm font-bold text-[#0A3A7A] hover:text-[#ED1C24] transition-colors">
                                View Details <i class="fa-solid fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@elseif(request()->filled('category') || request()->filled('search') || request()->filled('vendor_name'))
<div id="search-results" class="bg-gray-50 py-24 text-center">
    <div class="max-w-2xl mx-auto px-4">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fa-solid fa-magnifying-glass text-gray-400 text-2xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">No Results Found</h2>
        <p class="text-gray-600 mb-8">We couldn't find any vendors matching your search criteria. Try a different city or category.</p>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#0A3A7A] text-white font-bold rounded-xl hover:bg-[#ED1C24] transition-all">
            Clear Search
        </a>
    </div>
</div>
@endif

