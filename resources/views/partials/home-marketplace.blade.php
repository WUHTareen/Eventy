
@if($pakistanServices->count() > 0)
    <div class="py-16 bg-white relative overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10">
            <div class="flex flex-col lg:flex-row items-center justify-between mb-12 gap-10">
                <div class="max-w-2xl text-center lg:text-left">
                    <span class="inline-block px-4 py-1.5 bg-[#ED1C24]/10 text-[#ED1C24] rounded-full text-[10px] font-black uppercase tracking-widest mb-3 border border-[#ED1C24]/10">
                        Pakistan Marketplace
                    </span>
                    <h2 class="text-3xl md:text-4xl font-black text-[#0A3A7A] mb-4 uppercase tracking-tighter">
                        Pakistan <span class="text-[#ED1C24]">Services</span>
                    </h2>
                    <p class="text-lg text-gray-500 font-medium leading-relaxed">
                        Hand-picked, premium services from our verified network across Pakistan.
                    </p>
                </div>
                <div class="flex gap-4">
                    <div class="pakistan-prev w-14 h-14 rounded-2xl bg-white shadow-xl flex items-center justify-center text-[#0A3A7A] cursor-pointer hover:bg-[#0A3A7A] hover:text-white transition-all">
                        <i class="fa-solid fa-chevron-left"></i>
                    </div>
                    <div class="pakistan-next w-14 h-14 rounded-2xl bg-white shadow-xl flex items-center justify-center text-[#0A3A7A] cursor-pointer hover:bg-[#0A3A7A] hover:text-white transition-all">
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                </div>
            </div>

            <div class="swiper pakistan-swiper pb-16">
                <div class="swiper-wrapper !h-auto">
                    @foreach($pakistanServices as $service)
                    <div class="swiper-slide h-auto">
                        <div class="group relative bg-white rounded-[2rem] overflow-hidden shadow-[0_20px_60px_-15px_rgba(0,0,0,0.05)] hover:shadow-[0_40px_80px_-15px_rgba(237,28,36,0.15)] transition-all duration-700 border border-gray-100/50 flex flex-col h-[480px] hover:-translate-y-3">
                            <!-- Premium Image Container -->
                            <div class="relative h-64 overflow-hidden">
                                @php $featuredImage = $service->getFeaturedImage(); @endphp
                                <img src="{{ $featuredImage ? (Str::startsWith($featuredImage, ['http', 'https']) ? $featuredImage : asset('storage/' . $featuredImage)) : 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=800&q=80' }}" 
                                     alt="{{ $service->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[2s] ease-out">
                                
                                <div class="absolute inset-0 bg-[#0A3A7A]/20 opacity-0 group-hover:opacity-100 transition-all duration-700 backdrop-blur-[4px] flex flex-col items-center justify-center gap-4">
                                    <a href="{{ route('services.show', $service->id) }}" class="px-8 py-3 bg-white text-[#0A3A7A] rounded-xl font-bold uppercase tracking-widest text-[10px] shadow-2xl hover:bg-[#ED1C24] hover:text-white transition-all transform translate-y-4 group-hover:translate-y-0 duration-500">
                                        View Details
                                    </a>
                                </div>

                                <div class="absolute top-6 inset-x-6 flex justify-between items-center z-20">
                                    <span class="bg-white/90 backdrop-blur-xl border border-white/20 px-4 py-2 rounded-xl text-[9px] font-black text-[#0A3A7A] uppercase tracking-widest shadow-lg">
                                        {{ $service->category->name ?? 'Elite' }}
                                    </span>
                                    <div class="flex items-center gap-1.5 bg-[#0A3A7A] px-3 py-1.5 rounded-xl border border-white/10 shadow-lg">
                                        <i class="fa-solid fa-star text-amber-400 text-[10px]"></i>
                                        <span class="text-[11px] font-black text-white leading-none">4.9</span>
                                    </div>
                                </div>
                            </div>

                            <div class="p-8 flex-1 flex flex-col justify-between bg-gradient-to-b from-white to-gray-50/50">
                                <div class="space-y-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></div>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                            {{ $service->user->business_name ?? $service->user->name }}
                                            <i class="fa-solid fa-circle-check text-blue-500 text-[9px]"></i>
                                        </span>
                                    </div>
                                    <h3 class="text-xl font-black text-[#0A3A7A] leading-tight line-clamp-2 hover:text-[#ED1C24] transition-colors duration-300 uppercase tracking-tight">
                                        {{ $service->name }}
                                    </h3>
                                    <div class="flex items-center gap-2 text-gray-400">
                                        <i class="fa-solid fa-location-dot text-[10px]"></i>
                                        <p class="text-[11px] font-bold tracking-wide">{{ $service->location }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-6 border-t border-gray-100 mt-6">
                                    <div class="flex flex-col">
                                        <span class="text-[9px] font-black text-[#ED1C24] uppercase tracking-widest mb-1">Starting From</span>
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-xs font-bold text-gray-400">PKR</span>
                                            <span class="text-3xl font-black text-[#0A3A7A] tracking-tighter">{{ number_format($service->price) }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('services.book', $service->id) }}" class="w-14 h-14 bg-[#0A192F] text-white rounded-2xl flex items-center justify-center shadow-xl hover:bg-[#ED1C24] hover:shadow-[#ED1C24]/30 hover:rotate-6 transition-all duration-500 group/btn">
                                        <i class="fa-solid fa-calendar-plus text-lg group-hover/btn:scale-110"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="pakistan-pagination mt-12 flex justify-center !static"></div>
            </div>
        </div>
    </div>
    @endif

    <!-- Neural Experience (CTA) - Consistent in default view -->
    <div class="relative py-24 bg-[#0A192F] overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=2000" alt="Neural Background" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#0A192F] via-transparent to-[#0A192F]"></div>
        
        <div class="max-w-[1400px] mx-auto px-6 md:px-12 text-center relative z-10">
            <div class="inline-flex items-center gap-4 bg-white/5 backdrop-blur-3xl border border-white/10 px-6 py-3 rounded-full text-[#ED1C24] font-black uppercase text-[10px] tracking-[0.4em] mb-10 shadow-2xl">
                <span class="w-2 h-2 rounded-full bg-[#ED1C24] animate-ping"></span>
                System Ready for Execution
            </div>
            
            <h2 class="text-5xl md:text-7xl font-black text-white mb-8 tracking-tighter uppercase leading-[0.85]">
                Initiate <br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#ED1C24] via-white to-blue-400 ">Redesign</span>
            </h2>
            
            <p class="text-blue-100/40 text-lg md:text-xl font-medium max-w-3xl mx-auto mb-12 leading-relaxed ">
                "Pakistan's premier platform for mission-critical events, business logistics, and luxury heritage."
            </p>
            
            <div class="flex flex-col sm:flex-row gap-8 justify-center items-center">
                <a href="{{ route('register') }}" class="group relative px-16 py-8 bg-[#ED1C24] text-white rounded-[2rem] font-black text-sm uppercase tracking-[0.2em] shadow-2xl shadow-red-500/40 hover:scale-110 active:scale-95 transition-all duration-500 overflow-hidden">
                    <span class="relative z-10">Deploy Protocol</span>
                    <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                </a>
                
                <a href="{{ route('vendor.register') }}" class="px-16 py-8 bg-white/5 backdrop-blur-3xl border border-white/10 text-white rounded-[2rem] font-black text-sm uppercase tracking-[0.2em] hover:bg-white/10 transition-all duration-500">
                    Partner Intel
                </a>
            </div>
        </div>
    </div>

    @if($globalServices->count() > 0)
    <div class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10">
            <div class="flex flex-col lg:flex-row items-center justify-between mb-16 gap-12">
                <div class="max-w-2xl text-center lg:text-left space-y-4">
                    <div class="inline-flex items-center gap-3 bg-blue-600/10 px-6 py-2 rounded-full border border-blue-600/10 font-black text-[10px] text-blue-600 uppercase tracking-[0.4em]">International Operations</div>
                    <h2 class="text-4xl md:text-6xl font-black text-[#0A192F] uppercase tracking-tighter leading-none">
                        Global <span class="text-blue-600">Executive</span> Assets
                    </h2>
                    <p class="text-lg text-gray-400 font-medium uppercase tracking-widest leading-relaxed">
                        "High-fidelity service protocols deployed across 50+ international nodes with 99.9% reliability."
                    </p>
                </div>
                <div class="flex gap-6">
                    <div class="global-prev w-16 h-16 rounded-2xl bg-[#F8FAFC] border border-gray-100 shadow-xl flex items-center justify-center text-[#0A192F] cursor-pointer hover:bg-blue-600 hover:text-white transition-all duration-500">
                        <i class="fa-solid fa-chevron-left text-xl"></i>
                    </div>
                    <div class="global-next w-16 h-16 rounded-2xl bg-[#F8FAFC] border border-gray-100 shadow-xl flex items-center justify-center text-[#0A192F] cursor-pointer hover:bg-blue-600 hover:text-white transition-all duration-500">
                        <i class="fa-solid fa-chevron-right text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="swiper global-swiper pb-24">
                <div class="swiper-wrapper !h-auto">
                    @foreach($globalServices as $service)
                    <div class="swiper-slide h-auto">
                        <div class="group relative bg-[#F8FAFC] rounded-[2.5rem] overflow-hidden border border-gray-200/50 flex flex-col h-[520px] hover:bg-white hover:shadow-2xl hover:shadow-blue-900/10 transition-all duration-700 hover:-translate-y-4">
                            <div class="relative h-72 overflow-hidden">
                                @php $featuredImage = $service->getFeaturedImage(); @endphp
                                <img src="{{ $featuredImage ? (Str::startsWith($featuredImage, ['http', 'https']) ? $featuredImage : asset('storage/' . $featuredImage)) : 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=800&q=80' }}" 
                                     alt="{{ $service->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[2s]">
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-blue-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>

                                <div class="absolute top-6 left-6 flex gap-2">
                                    <span class="bg-white/90 backdrop-blur-xl border border-white/20 px-4 py-2 rounded-xl text-[9px] font-black text-blue-600 uppercase tracking-widest shadow-lg">
                                        {{ $service->category->name ?? 'Global Elite' }}
                                    </span>
                                </div>
                                <div class="absolute top-6 right-6 flex items-center gap-1.5 bg-blue-600 px-4 py-2 rounded-xl border border-white/20 shadow-lg">
                                    <i class="fa-solid fa-star text-amber-400 text-[10px]"></i>
                                    <span class="text-[11px] font-black text-white leading-none">5.0</span>
                                </div>
                            </div>

                            <div class="p-10 flex-1 flex flex-col justify-between">
                                <div class="space-y-6">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-ping"></div>
                                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                            {{ $service->user->business_name ?? $service->user->name }}
                                        </span>
                                    </div>
                                    <h3 class="text-2xl font-black text-[#0A192F] leading-tight uppercase tracking-tighter group-hover:text-blue-600 transition-colors duration-500">
                                        {{ $service->name }}
                                    </h3>
                                    <div class="flex items-center gap-2 text-blue-600/60">
                                        <i class="fa-solid fa-globe text-sm"></i>
                                        <p class="text-xs font-black uppercase tracking-widest">{{ $service->location }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-10 border-t border-gray-100">
                                    <div class="space-y-1">
                                        <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Global Tier</span>
                                        <div class="text-3xl font-black text-[#0A192F]">
                                            <span class="text-sm font-medium text-gray-400 mr-1">PKR</span>{{ number_format($service->price) }}
                                        </div>
                                    </div>
                                    <a href="{{ route('services.show', $service->id) }}" class="w-16 h-16 bg-[#0A192F] text-white rounded-[1.5rem] flex items-center justify-center shadow-xl hover:bg-blue-600 transition-all duration-500 hover:rotate-6">
                                        <i class="fa-solid fa-arrow-right-long text-xl"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="global-pagination mt-16 flex justify-center !static"></div>
            </div>
        </div>
    </div>
    @endif
