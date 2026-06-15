@if($pakistanServices->count() > 0 || $globalServices->count() > 0)
    <!-- Pakistan Services -->
    @if($pakistanServices->count() > 0)
    <div class="mb-32 py-10 relative group/pak">
        <div class="flex flex-col md:flex-row justify-between items-center mb-16 gap-8 px-4">
            <div class="text-center md:text-left">
                <div class="flex items-center justify-center md:justify-start gap-4 mb-4">
                    <span class="px-5 py-2 bg-[#ED1C24]/10 text-[#ED1C24] rounded-full text-[9px] font-black uppercase tracking-[0.3em] border border-[#ED1C24]/10">Domestic Node</span>
                    <div class="h-[1px] w-12 bg-[#ED1C24]/20 hidden md:block"></div>
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">{{ $pakistanServices->count() }} Assets Active</span>
                </div>
                <h2 class="text-4xl md:text-6xl font-black text-[#0A192F] tracking-tighter uppercase leading-none">Pakistan <span class="text-[#ED1C24]">Creations</span></h2>
            </div>
            
            <div class="flex gap-4">
                <div class="pakistan-prev w-14 h-14 rounded-2xl bg-white shadow-xl flex items-center justify-center text-[#0A192F] hover:bg-[#ED1C24] hover:text-white transition-all border border-gray-100 cursor-pointer active:scale-90 group/btn">
                    <i class="fa-solid fa-arrow-left-long text-lg group-hover/btn:-translate-x-1 transition-transform"></i>
                </div>
                <div class="pakistan-next w-14 h-14 rounded-2xl bg-white shadow-xl flex items-center justify-center text-[#0A192F] hover:bg-[#ED1C24] hover:text-white transition-all border border-gray-100 cursor-pointer active:scale-90 group/btn">
                    <i class="fa-solid fa-arrow-right-long text-lg group-hover/btn:translate-x-1 transition-transform"></i>
                </div>
            </div>
        </div>

        <div class="swiper pakistan-services-swiper overflow-hidden px-4">
            <div class="swiper-wrapper py-10">
                @foreach($pakistanServices as $service)
                    <div class="swiper-slide h-auto">
                        @include('partials.services-grid-item', ['service' => $service])
                    </div>
                @endforeach
            </div>
            <div class="pakistan-pagination flex justify-center mt-12"></div>
        </div>
    </div>
    @endif

    <!-- Global Services -->
    @if($globalServices->count() > 0)
    <div class="mb-32 py-10 relative group/glob">
        <div class="flex flex-col md:flex-row justify-between items-center mb-16 gap-8 px-4">
            <div class="text-center md:text-left">
                <div class="flex items-center justify-center md:justify-start gap-4 mb-4">
                    <span class="px-5 py-2 bg-blue-600/10 text-blue-600 rounded-full text-[9px] font-black uppercase tracking-[0.3em] border border-blue-600/10">Global Node</span>
                    <div class="h-[1px] w-12 bg-blue-600/20 hidden md:block"></div>
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">{{ $globalServices->count() }} International Assets</span>
                </div>
                <h2 class="text-4xl md:text-6xl font-black text-[#0A192F] tracking-tighter uppercase leading-none">Global <span class="text-blue-600">Excellence</span></h2>
            </div>
            
            <div class="flex gap-4">
                <div class="global-prev w-14 h-14 rounded-2xl bg-white shadow-xl flex items-center justify-center text-[#0A192F] hover:bg-blue-600 hover:text-white transition-all border border-gray-100 cursor-pointer active:scale-90 group/btn">
                    <i class="fa-solid fa-arrow-left-long text-lg group-hover/btn:-translate-x-1 transition-transform"></i>
                </div>
                <div class="global-next w-14 h-14 rounded-2xl bg-white shadow-xl flex items-center justify-center text-[#0A192F] hover:bg-blue-600 hover:text-white transition-all border border-gray-100 cursor-pointer active:scale-90 group/btn">
                    <i class="fa-solid fa-arrow-right-long text-lg group-hover/btn:translate-x-1 transition-transform"></i>
                </div>
            </div>
        </div>

        <div class="swiper global-services-swiper overflow-hidden px-4">
            <div class="swiper-wrapper py-10">
                @foreach($globalServices as $service)
                    <div class="swiper-slide h-auto">
                        @include('partials.services-grid-item', ['service' => $service])
                    </div>
                @endforeach
            </div>
            <div class="global-pagination flex justify-center mt-12"></div>
        </div>
    </div>
    @endif

@else
    <div class="text-center py-32 bg-white rounded-[3rem] border border-gray-100 shadow-3xl">
        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8">
            <i class="fa-solid fa-network-wired text-gray-200 text-4xl"></i>
        </div>
        <h3 class="text-2xl font-black text-[#0A192F] tracking-tight uppercase tracking-widest">Protocol Awaiting Uplink</h3>
        <p class="text-gray-400 mt-3 font-medium max-w-sm mx-auto ">"Our curators are currently sourcing Prime Vendors for this orchestration tier."</p>
        <a href="{{ route('contact') }}" class="inline-flex mt-10 text-[10px] font-black text-[#ED1C24] uppercase tracking-[0.4em] border-b-2 border-[#ED1C24] pb-1 hover:text-[#0A192F] hover:border-[#0A192F] transition-all">
            Consult HQ Specialists
        </a>
    </div>
@endif

