@extends('layouts.public')

@section('title', $vendor->name . ' | Elite Operational Node')

@section('content')
<div class="min-h-screen bg-[#0A192F] pt-40 pb-32 selection:bg-[#ED1C24] selection:text-white">
    <!-- background effects -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-[1000px] h-[1000px] bg-[#ED1C24]/5 rounded-full blur-[150px]"></div>
        <div class="absolute bottom-0 left-0 w-[800px] h-[800px] bg-blue-900/5 rounded-full blur-[150px]"></div>
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(white 1px, transparent 1px); background-size: 60px 60px;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        
        <!-- Luxury Vendor Hero (Operational Command) -->
        <div class="relative rounded-[4rem] overflow-hidden bg-white/5 backdrop-blur-3xl border border-white/10 shadow-3xl mb-24 group">
            <!-- Strategic Background -->
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=2000" class="w-full h-full object-cover opacity-10 grayscale group-hover:scale-110 transition-transform duration-1000">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F] via-[#0A192F]/40 to-transparent"></div>
            </div>

            <div class="relative z-10 p-12 md:p-20 flex flex-col lg:flex-row items-center lg:items-end gap-16">
                <!-- Profile Avatar Cluster -->
                <div class="relative">
                    <div class="absolute -inset-8 bg-[#ED1C24]/20 rounded-full blur-3xl animate-pulse"></div>
                    <div class="w-56 h-56 rounded-[3.5rem] border-4 border-white/10 overflow-hidden relative shadow-2xl bg-slate-900 group-hover:rotate-3 transition-transform duration-500">
                        <img src="{{ $vendor->getAvatarUrl() }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                </div>

                <div class="flex-1 text-center lg:text-left space-y-8">
                    <div class="space-y-4">
                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4">
                            <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter uppercase leading-[0.85]">{{ $vendor->name }}</h1>
                        </div>
                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4">
                            @if($vendor->is_verified)
                                <div class="bg-[#ED1C24] text-white px-6 py-2 rounded-full text-[9px] font-black uppercase tracking-[0.3em] flex items-center gap-3 shadow-2xl shadow-[#ED1C24]/20">
                                    <i class="fa-solid fa-crown text-[8px] animate-bounce"></i> Verified Strategic Node
                                </div>
                            @endif
                            <div class="bg-white/5 border border-white/10 text-white/60 px-6 py-2 rounded-full text-[9px] font-black uppercase tracking-[0.3em] flex items-center gap-3">
                                <i class="fa-solid fa-network-wired text-[#ED1C24]"></i> ID: #{{ str_pad($vendor->id, 6, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-10 text-blue-100/40 text-xs font-black uppercase tracking-widest">
                        <span class="flex items-center gap-3 group/stat">
                            <i class="fa-solid fa-location-dot text-[#ED1C24] group-hover:scale-125 transition-transform"></i> 
                            {{ $vendor->city->name ?? 'Regional Node' }}
                        </span>
                        <span class="flex items-center gap-3 group/stat">
                            <i class="fa-solid fa-star text-amber-400 group-hover:rotate-45 transition-transform"></i> 
                            <span class="text-white">{{ $avgRating }}</span> ({{ $reviewCount }} Reports)
                        </span>
                        <span class="flex items-center gap-3 group/stat">
                            <i class="fa-solid fa-briefcase text-blue-400 group-hover:-translate-y-1 transition-transform"></i> 
                            {{ $vendor->category->name ?? 'Specialized Asset' }}
                        </span>
                    </div>
                </div>

                <div class="flex gap-6">
                    <a href="https://wa.me/{{ $vendor->phone }}?text=Hi%20{{ $vendor->name }}!%20I%20saw%20your%20profile%20on%20Eventy." target="_blank" class="group relative px-12 py-6 bg-white text-[#0A192F] rounded-[2rem] font-black text-[10px] uppercase tracking-[0.4em] shadow-2xl hover:scale-110 active:scale-95 transition-all flex items-center gap-4 overflow-hidden">
                        <span class="relative z-10 flex items-center gap-4"><i class="fa-brands fa-whatsapp text-lg"></i> Direct Uplink</span>
                        <div class="absolute inset-0 bg-[#ED1C24] translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-16">
            <!-- Strategic Intelligence Hub -->
            <div class="lg:col-span-1 space-y-12">
                <!-- Bio / Objective -->
                <div class="bg-white/5 backdrop-blur-3xl rounded-[3.5rem] p-12 border border-white/10 hover:border-[#ED1C24]/30 transition-all duration-700">
                    <h3 class="text-[10px] font-black text-[#ED1C24] uppercase tracking-[0.4em] mb-10 flex items-center gap-4">
                        <span class="w-8 h-px bg-[#ED1C24]/30"></span> Mission Parameters
                    </h3>
                    <p class="text-blue-100/60 leading-relaxed font-medium  text-lg">
                        "{{ $vendor->bio ?? 'This elite partner is currently refining their professional narrative. They are a verified specialist on the Eventy network.' }}"
                    </p>
                    
                    <div class="mt-12 flex flex-wrap gap-4 pt-8 border-t border-white/5">
                        @if($vendor->social_links)
                            @php
                                $allowedPlatforms = ['facebook', 'instagram', 'linkedin', 'tiktok', 'youtube'];
                            @endphp
                            @foreach($vendor->social_links as $platform => $url)
                                @if($url && in_array(strtolower($platform), $allowedPlatforms))
                                <a href="{{ $url }}" target="_blank" class="w-14 h-14 bg-white/5 rounded-2xl flex items-center justify-center text-white/40 hover:text-white hover:bg-[#ED1C24] transition-all border border-white/10 shadow-xl group/soc">
                                    <i class="fa-brands fa-{{ strtolower($platform) === 'facebook' ? 'facebook-f' : (strtolower($platform) === 'linkedin' ? 'linkedin-in' : strtolower($platform)) }} text-lg group-hover/soc:scale-125 transition-transform"></i>
                                </a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Operational Windows -->
                <div class="bg-[#020617] rounded-[3.5rem] p-12 border border-white/5 shadow-3xl group">
                    <h3 class="text-[10px] font-black text-blue-100/40 uppercase tracking-[0.4em] mb-10 border-b border-white/5 pb-6">Sync Schedules</h3>
                    <div class="space-y-8">
                        @if($vendor->business_hours)
                            @foreach($vendor->business_hours as $day => $hours)
                                <div class="flex justify-between items-center group/time">
                                    <span class="text-[10px] font-black text-white/30 uppercase tracking-[0.2em] group-hover/time:text-[#ED1C24] transition-colors">{{ $day }}</span>
                                    <span class="text-xs font-bold text-white/80 group-hover/time:text-white transition-colors">{{ $hours }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="flex items-center gap-4 p-4 bg-white/5 rounded-2xl border border-white/10">
                                <span class="w-2 h-2 rounded-full bg-[#ED1C24] animate-ping"></span>
                                <p class="text-[10px] font-black text-blue-100/40 uppercase tracking-widest ">Live On-Call Availability</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Technical Node Details -->
                <div class="p-8 bg-gradient-to-br from-[#ED1C24]/10 to-transparent rounded-[3rem] border border-[#ED1C24]/20">
                    <div class="flex items-center gap-4 text-white uppercase font-black text-[9px] tracking-widest mb-4">
                        <i class="fa-solid fa-microchip text-[#ED1C24]"></i> Node Latency: 4ms
                    </div>
                    <div class="flex items-center gap-4 text-white uppercase font-black text-[9px] tracking-widest">
                        <i class="fa-solid fa-shield-halved text-blue-400"></i> Secure Link: Active
                    </div>
                </div>
            </div>

            <!-- Asset Portfolio Masterpiece -->
            <div class="lg:col-span-2 space-y-16">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-white/5 backdrop-blur-xl p-8 rounded-[3rem] border border-white/10">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 bg-[#ED1C24] rounded-3xl flex items-center justify-center text-white shadow-2xl">
                            <i class="fa-solid fa-layer-group text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-3xl font-black text-white tracking-tighter uppercase">Asset Portfolio</h2>
                            <p class="text-blue-100/40 text-[10px] font-black uppercase tracking-widest">Deployments currently active: {{ $vendor->services->count() }}</p>
                        </div>
                    </div>
                    <div class="h-10 w-px bg-white/10 hidden md:block"></div>
                    <div class="flex gap-4">
                        <span class="px-5 py-2 bg-white/5 rounded-full text-[9px] font-black text-white/40 uppercase tracking-widest border border-white/10">Sort: Relevance</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 pt-4">
                    @forelse($vendor->services as $service)
                        <div class="fade-up">
                            @include('partials.services-grid-item', ['service' => $service])
                        </div>
                    @empty
                        <div class="col-span-2 py-48 text-center bg-white/5 backdrop-blur-3xl rounded-[4rem] border border-white/10 shadow-2xl">
                            <div class="w-32 h-32 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-10 border border-white/10">
                                <i class="fa-solid fa-folder-open text-[#ED1C24] text-4xl opacity-40"></i>
                            </div>
                            <h3 class="text-2xl font-black text-white uppercase tracking-widest">Portfolio Under Curation</h3>
                            <p class="text-blue-100/40 mt-4 font-medium ">"System nodes are currently calibrating new asset data. Re-check imminent."</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fade-up {
        animation: fadeUp 1s ease-out forwards;
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

