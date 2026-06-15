<div class="py-16 bg-slate-50 relative overflow-hidden" id="budget-preview-results">
    <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10">
        <div class="flex items-center justify-between mb-12">
            <div>
                <span class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.4em] mb-2 block">AI Generated Manifest</span>
                <h3 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Strategic <span class="text-indigo-600">Blueprints</span></h3>
                <p class="text-xs text-slate-500 font-medium mt-2">Based on your budget of <span class="text-slate-900 font-bold">PKR {{ number_format($budget) }}</span> for <span class="text-slate-900 font-bold capitalize">{{ $serviceSlug ?? 'Event' }}</span></p>
            </div>
            <button onclick="document.getElementById('budget-preview-results').remove()" class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 hover:bg-red-50 hover:text-red-500 transition-all">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        @if($matchingServices->isNotEmpty() || $matchingPackages->isNotEmpty())
        <!-- Real-Time Matches (Prioritized) -->
        <div class="mb-20">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-500">
                    <i class="fa-solid fa-bolt"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Market <span class="text-indigo-600">Matches</span></h3>
                    <p class="text-xs text-slate-500 font-medium">Verified services matching your budget criteria (Approx. PKR {{ number_format($budget) }})</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($matchingServices as $service)
                <a href="{{ route('services.show', $service->id) }}" class="group block bg-white rounded-3xl p-4 border border-slate-100 hover:border-indigo-500/30 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="aspect-video rounded-2xl overflow-hidden mb-4 relative">
                        <img src="{{ $service->getFeaturedImage() ? asset('storage/' . $service->getFeaturedImage()) : 'https://placehold.co/600x400' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider text-slate-900 shadow-sm">
                            Rs. {{ number_format($service->price) }}
                        </div>
                    </div>
                    <div class="px-2">
                        <h4 class="text-sm font-black text-slate-900 uppercase tracking-tight mb-1 group-hover:text-indigo-600 transition-colors line-clamp-1">{{ $service->name }}</h4>
                        <div class="flex items-center gap-2 text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-3">
                            <i class="fa-solid fa-user-circle"></i> {{ $service->user->name ?? 'Vendor' }}
                        </div>
                        <div class="flex items-center justify-between border-t border-slate-50 pt-3">
                            <span class="text-[10px] font-bold text-slate-400"><i class="fa-solid fa-star text-amber-400"></i> {{ $service->averageRating() }}</span>
                            <span class="text-[10px] font-black text-indigo-500 uppercase tracking-wider">Book Now <i class="fa-solid fa-arrow-right ml-1"></i></span>
                        </div>
                    </div>
                </a>
                @endforeach

                @foreach($matchingPackages as $package)
                <a href="{{ route('packages.show', $package->id) }}" class="group block bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-4 border border-white/10 hover:border-indigo-500/50 shadow-lg hover:shadow-indigo-500/20 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="aspect-video rounded-2xl overflow-hidden mb-4 relative">
                        <img src="{{ $package->image ? asset('storage/' . $package->image) : 'https://placehold.co/600x400' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 opacity-80 group-hover:opacity-100">
                        <div class="absolute top-2 right-2 bg-indigo-500 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider text-white shadow-lg">
                            Pkg: Rs. {{ number_format($package->total_price) }}
                        </div>
                    </div>
                    <div class="px-2">
                        <h4 class="text-sm font-black text-white uppercase tracking-tight mb-1 group-hover:text-indigo-400 transition-colors line-clamp-1">{{ $package->name }}</h4>
                        <div class="flex items-center gap-2 text-[10px] text-white/40 font-bold uppercase tracking-widest mb-3">
                            <i class="fa-solid fa-box-open"></i> {{ $package->services->count() }} Services Bundle
                        </div>
                        <div class="flex items-center justify-between border-t border-white/10 pt-3">
                            <span class="text-[10px] font-bold text-white/40">Bundle Deal</span>
                            <span class="text-[10px] font-black text-indigo-400 uppercase tracking-wider">View Details <i class="fa-solid fa-arrow-right ml-1"></i></span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @else
        <div class="mb-12 p-6 bg-slate-50 border border-slate-100 rounded-2xl text-center">
            <i class="fa-solid fa-magnifying-glass text-slate-300 text-3xl mb-3"></i>
            <p class="text-sm font-bold text-slate-600">No exact matches found in this budget range.</p>
            <p class="text-xs text-slate-400 mt-1">Try adjusting your budget or explore our strategic blueprints below.</p>
        </div>
        @endif




    </div>
</div>

