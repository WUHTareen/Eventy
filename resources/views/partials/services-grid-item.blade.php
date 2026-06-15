<a href="{{ route('services.show', $service) }}" class="group relative bg-white rounded-[2.5rem] overflow-hidden shadow-[0_20px_60px_-15px_rgba(0,0,0,0.05)] hover:shadow-[0_40px_80px_-15px_rgba(237,28,36,0.15)] transition-all duration-700 border border-slate-100 group-hover:border-[#ED1C24]/30 flex flex-col h-[540px] hover:-translate-y-3">
    <!-- Premium Image Container -->
    <div class="relative h-64 overflow-hidden">
        @php 
            $featuredImage = $service->getFeaturedImage();
            // Manual overrides for demo data
            if (trim($service->name) === 'Test Verification Service') {
                $featuredImage = 'https://images.unsplash.com/photo-1543269865-cbf427effbad?auto=format&fit=crop&w=800&q=80';
            }
        @endphp
        
        <img src="{{ $featuredImage ? (Str::startsWith($featuredImage, ['http', 'https']) ? $featuredImage : asset('storage/' . $featuredImage)) : 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=800&q=80' }}" 
             alt="{{ $service->name }}" 
             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[2s] ease-out grayscale-[0.2] group-hover:grayscale-0">
        
        <!-- Glassmorphic Overlay on Hover -->
        <div class="absolute inset-0 bg-[#0A192F]/40 opacity-0 group-hover:opacity-100 transition-all duration-700 backdrop-blur-[4px] flex flex-col items-center justify-center gap-4">
            <span class="px-8 py-3 bg-white text-[#0A192F] rounded-xl font-black uppercase tracking-widest text-[10px] shadow-2xl transform translate-y-4 group-hover:translate-y-0 duration-500">
                Strategic Spec
            </span>
        </div>

        <!-- Executive Badges -->
        <div class="absolute top-6 inset-x-6 flex justify-between items-start z-20">
            <div class="flex flex-col gap-2">
                @if($service->category)
                    <span class="bg-[#0A192F]/90 backdrop-blur-xl border border-white/20 px-4 py-2 rounded-xl text-[9px] font-black text-white uppercase tracking-widest shadow-lg inline-block w-fit">
                        {{ $service->category->name }}
                    </span>
                @endif
                @if($service->user && $service->user->is_verified)
                    <span class="bg-[#ED1C24]/90 backdrop-blur-xl border border-white/10 px-4 py-2 rounded-xl text-[9px] font-black text-white uppercase tracking-widest shadow-lg flex items-center gap-2 w-fit">
                        <i class="fa-solid fa-shield-check text-[8px]"></i> Verified Asset
                    </span>
                @endif
            </div>

            <!-- Heart / Favorite Button -->
            <div x-data="{ 
                isFavorited: {{ Auth::check() && $service->isFavoritedBy(Auth::user()) ? 'true' : 'false' }}, 
                loading: false,
                toggle() {
                    @if(Auth::check())
                        if(this.loading) return;
                        this.loading = true;
                        fetch('{{ route('services.favorite', $service) }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.isFavorited = data.favorited;
                            this.loading = false;
                        })
                        .catch(() => this.loading = false);
                    @else
                        window.location.href = '{{ route('login') }}';
                    @endif
                }
            }">
                <button @click.prevent="toggle()" 
                        class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 shadow-lg text-lg"
                        :class="isFavorited ? 'bg-[#ED1C24] text-white' : 'bg-white/90 backdrop-blur-sm text-slate-400 hover:text-[#ED1C24]'">
                    <i class="fa-solid fa-heart" :class="{'animate-ping': loading}"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Executive Content Body -->
    <div class="p-8 flex-1 flex flex-col justify-between bg-gradient-to-b from-white to-gray-50/50">
        <div class="space-y-4">
            <div class="flex items-center gap-2 text-gray-400">
                <i class="fa-solid fa-location-dot text-[10px] text-[#ED1C24]"></i>
                <p class="text-[11px] font-black uppercase tracking-widest">{{ $service->location ?? 'Global Dispatch' }}</p>
            </div>
            
            <h3 class="text-xl font-black text-[#0A192F] leading-tight line-clamp-2 group-hover:text-[#ED1C24] transition-colors duration-300 uppercase tracking-tighter">
                {{ $service->name }}
            </h3>
            
            <div class="pt-2">
                 <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                    Managed by: {{ $service->user->business_name ?? $service->user->name }}
                    <i class="fa-solid fa-circle-check text-blue-500 text-[9px]"></i>
                </span>
            </div>
        </div>

        <!-- Pricing & Action Hub -->
        <div class="flex items-center justify-between pt-6 border-t border-slate-100 mt-6 group/hub">
            <div class="flex flex-col">
                <span class="text-[9px] font-black text-[#ED1C24] uppercase tracking-widest mb-1">
                    {{ str_contains(strtolower($service->location ?? ''), 'pakistan') ? 'Domestic Node' : 'International Node' }}
                </span>
                <div class="flex items-baseline gap-1">
                    <span class="text-xs font-black text-gray-300 uppercase">PKR</span>
                    <span class="text-3xl font-black text-[#0A192F] tracking-tighter">
                        {{ $service->price ? number_format($service->price) : 'Quote' }}
                    </span>
                </div>
            </div>
            
            <div class="w-14 h-14 bg-[#0A192F] text-white rounded-2xl flex items-center justify-center shadow-xl group-hover:bg-[#ED1C24] group-hover:shadow-[#ED1C24]/30 group-hover:rotate-6 transition-all duration-500">
                <i class="fa-solid fa-arrow-right-long text-lg"></i>
            </div>
        </div>
    </div>
</a>

