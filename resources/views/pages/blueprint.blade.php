@extends('layouts.public')

@section('title', 'Celebration Roadmap | Strategic Architecture')
@section('description', 'The definitive blueprint for orchestrating elite events and high-stakes hospitality.')

@section('content')
<div class="bg-[#0A192F] min-h-screen selection:bg-[#ED1C24] selection:text-white">
    <!-- Planning Architecture (Hero) -->
    <div class="relative pt-40 pb-48 overflow-hidden">
        <!-- Strategic Background Architecture -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?auto=format&fit=crop&q=80&w=2000" alt="Asset Network" class="w-full h-full object-cover opacity-10 filter grayscale contrast-125">
            <div class="absolute inset-0 bg-gradient-to-b from-[#0A192F]/50 via-[#0A192F]/80 to-[#0A192F]"></div>
        </div>
        <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 60px 60px;"></div>
        
        <div class="max-w-[1400px] mx-auto px-6 relative z-10 text-center">
            <div class="inline-flex items-center gap-3 bg-white/5 backdrop-blur-3xl px-6 py-2 rounded-full border border-white/10 mb-12 transform hover:scale-105 transition-all cursor-default group">
                <span class="w-2 h-2 rounded-full bg-[#ED1C24] group-hover:animate-ping"></span>
                <span class="text-[10px] font-black text-white uppercase tracking-[0.4em]">Strategic Excellence Protocol v4.0.0</span>
            </div>
            
            <h1 class="text-5xl md:text-9xl font-black text-white mb-10 tracking-tighter uppercase leading-[0.85]">
                Event <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#ED1C24] via-white to-blue-400 ">Blueprint</span>
            </h1>
            
            <p class="text-blue-100/40 text-lg md:text-2xl font-medium max-w-4xl mx-auto  leading-relaxed">
                "A master-class in event orchestration. Follow the proprietary roadmap to secure the world's most elite service nodes at the critical window."
            </p>
        </div>
    </div>

    <!-- The Roadmap Matrix -->
    <div class="max-w-7xl mx-auto px-6 -mt-32 pb-48 relative z-20">
        <div class="grid gap-16">
            @foreach($stages as $stage)
                <div class="group relative bg-white/5 backdrop-blur-3xl rounded-[4rem] p-12 border border-white/10 hover:border-[#ED1C24]/30 transition-all duration-700 overflow-hidden">
                    <!-- Stage Badge -->
                    <div class="absolute -top-0 right-12 px-8 py-3 bg-[#ED1C24] text-white rounded-b-2xl text-[10px] font-black uppercase tracking-[0.4em] shadow-2xl">
                        {{ $stage['time'] }}
                    </div>

                    <div class="grid lg:grid-cols-12 gap-16 items-center">
                        <!-- Iconography Cluster -->
                        <div class="lg:col-span-4 flex justify-center">
                            <div class="relative">
                                <div class="absolute -inset-10 bg-[#ED1C24]/10 rounded-full blur-[60px] group-hover:bg-[#ED1C24]/20 transition-all duration-700"></div>
                                <div class="w-48 h-48 rounded-[3.5rem] bg-white/5 border border-white/10 flex items-center justify-center text-white relative group-hover:scale-110 group-hover:rotate-6 transition-all duration-700 shadow-2xl overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-br from-[#ED1C24]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <i class="fa-solid {{ $stage['icon'] }} text-7xl relative z-10 group-hover:text-[#ED1C24] transition-colors"></i>
                                </div>
                                @if(!$loop->last)
                                    <div class="absolute top-full left-1/2 w-px h-32 bg-gradient-to-b from-white/20 to-transparent -translate-x-1/2 z-0 hidden lg:block border-dashed border-white/20"></div>
                                @endif
                            </div>
                        </div>

                        <!-- Strategic Content -->
                        <div class="lg:col-span-8 space-y-10">
                            <div>
                                <div class="flex items-center gap-4 mb-4">
                                    <span class="px-3 py-1 bg-white/5 rounded text-[9px] font-black text-[#ED1C24] uppercase tracking-widest border border-[#ED1C24]/20">PHASE_{{ $loop->iteration }}</span>
                                    <div class="h-px w-12 bg-white/10"></div>
                                </div>
                                <h3 class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase mb-6">{{ $stage['title'] }}</h3>
                                <p class="text-blue-100/40 font-medium leading-relaxed  text-xl max-w-2xl">
                                    "{{ $stage['description'] }}"
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-4 pt-4">
                                @foreach($stage['categories'] as $catName)
                                    @php 
                                        $cat = $allCategories->where('name', $catName)->first(); 
                                    @endphp
                                    @if($cat)
                                        <a href="{{ route('services', ['category' => $cat->slug]) }}" 
                                           class="group/cat inline-flex items-center gap-6 px-10 py-5 bg-white/5 hover:bg-white text-white hover:text-[#0A192F] border border-white/10 hover:border-white rounded-3xl transition-all duration-500 shadow-xl">
                                            <i class="fa-solid {{ $cat->icon ?? 'fa-arrow-right-long' }} text-sm group-hover/cat:scale-110 transition-transform"></i>
                                            <span class="text-[10px] font-black uppercase tracking-[0.3em]">{{ $cat->name }}</span>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Master CTA Architecture -->
        <div class="mt-48 text-center bg-white/5 backdrop-blur-3xl rounded-[4rem] p-24 border border-white/10 relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-[#ED1C24]/10 rounded-full blur-[100px]"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px]"></div>

            <div class="relative z-10 space-y-12">
                <div class="inline-flex items-center gap-4 bg-[#ED1C24]/10 px-6 py-2 rounded-full border border-[#ED1C24]/20">
                    <span class="w-2 h-2 rounded-full bg-[#ED1C24] animate-pulse"></span>
                    <p class="text-[10px] font-black text-[#ED1C24] uppercase tracking-[0.4em]">Awaiting Command Authorization</p>
                </div>
                
                <h2 class="text-5xl md:text-8xl font-black text-white tracking-tighter uppercase leading-[0.85]">
                    Initiate <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-white/20">Planning Protocol</span>
                </h2>
                
                <div class="flex flex-col sm:flex-row justify-center gap-8 pt-6">
                    <a href="{{ route('services') }}" class="group relative px-16 py-8 bg-[#ED1C24] text-white rounded-[2rem] font-black text-sm uppercase tracking-[0.4em] shadow-2xl shadow-[#ED1C24]/20 hover:scale-110 active:scale-95 transition-all duration-500 overflow-hidden">
                        <span class="relative z-10 flex items-center gap-4">Access Marketplace <i class="fa-solid fa-network-wired"></i></span>
                        <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                    </a>
                    <a href="{{ route('contact') }}" class="px-16 py-8 bg-white/5 border border-white/10 text-white rounded-[2rem] font-black text-sm uppercase tracking-[0.4em] hover:bg-white/10 transition-all duration-500 backdrop-blur-xl">
                        Consult Strategy Desk
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes pulse-soft {
        0%, 100% { opacity: 0.1; transform: scale(1); }
        50% { opacity: 0.2; transform: scale(1.05); }
    }
    .animate-pulse-soft {
        animation: pulse-soft 8s infinite ease-in-out;
    }
</style>
@endsection

