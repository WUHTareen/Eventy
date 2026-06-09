<div class="space-y-12">
    <!-- Hero Preview -->
    <div class="relative h-96 rounded-[3rem] overflow-hidden shadow-2xl">
        <img src="{{ $service->getFeaturedImage() ? (Str::startsWith($service->getFeaturedImage(), ['http', 'https']) ? $service->getFeaturedImage() : asset('storage/' . $service->getFeaturedImage())) : asset('images/placeholder.jpg') }}" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent"></div>
        <div class="absolute bottom-10 left-10 right-10">
            <div class="flex items-center gap-3 mb-4">
                <span class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-full text-[10px] font-black text-white uppercase tracking-widest border border-white/20">
                    {{ $service->category->name }}
                </span>
                @if($service->user->is_verified)
                    <span class="px-4 py-2 bg-indigo-500/90 backdrop-blur-md rounded-full text-[10px] font-black text-white uppercase tracking-widest flex items-center gap-2">
                        <i class="fa-solid fa-crown"></i> Verified 
                    </span>
                @endif
            </div>
            <h2 class="text-4xl font-black text-white tracking-tighter uppercase leading-none">{{ $service->name }}</h2>
        </div>
    </div>

    <!-- Metrics -->
    <div class="grid grid-cols-2 gap-6">
        <div class="p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100 group hover:border-indigo-500/30 transition-all duration-500">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Base Investment</p>
            <p class="text-3xl font-black text-slate-900">PKR {{ number_format($service->price) }}</p>
        </div>
        <div class="p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100 group hover:border-amber-500/30 transition-all duration-500">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Reputation</p>
            <div class="flex items-center gap-3">
                <p class="text-3xl font-black text-slate-900">{{ $service->cached_rating ?? 'New' }}</p>
                <div class="flex text-amber-400 text-sm gap-1">
                    @for($i=0; $i<5; $i++)
                        <i class="fa-solid fa-star"></i>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <!-- Insight Section -->
    <div class="space-y-6 px-4">
        <div>
            <h4 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.4em] mb-4">Service Narrative</h4>
            <p class="text-slate-500 text-lg font-medium leading-relaxed ">"{{ $service->description }}"</p>
        </div>

        <div class="pt-8 border-t border-slate-100 grid grid-cols-2 gap-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-sm">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Base Hub</p>
                    <p class="text-sm font-black text-slate-900">{{ $service->location }}</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-900 flex items-center justify-center text-white shadow-sm">
                    <img src="{{ $service->user->getAvatarUrl() }}" class="w-full h-full object-cover rounded-2xl">
                </div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Partner</p>
                    <p class="text-sm font-black text-slate-900">{{ $service->user->name }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

