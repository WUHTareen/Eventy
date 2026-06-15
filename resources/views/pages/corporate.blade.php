@extends('layouts.public')

@section('title', 'Corporate Solutions')
@section('description', 'Enterprise-grade event management, corporate travel, and business hospitality solutions.')

@section('content')
<div class="min-h-screen bg-[#0A192F] relative overflow-hidden">
    <!-- Sophisticated Neural Background -->
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="absolute top-0 left-0 w-full h-full" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.05) 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
    
    <!-- Hero Section -->
    <section class="relative pt-48 pb-32 overflow-hidden">
        <!-- Technical Accents -->
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-[#ED1C24] to-transparent opacity-30"></div>
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-600/10 rounded-full filter blur-[150px] animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-[#ED1C24]/10 rounded-full filter blur-[150px] animate-pulse" style="animation-delay: 2s;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6">
            <div class="text-center space-y-12">
                <div class="inline-flex items-center gap-4 bg-white/5 backdrop-blur-3xl px-6 py-3 rounded-full border border-white/10 hover:border-[#ED1C24]/30 transition-all cursor-default group">
                    <span class="w-2 h-2 rounded-full bg-[#ED1C24] group-hover:animate-ping"></span>
                    <span class="text-[10px] font-black text-white uppercase tracking-[0.5em]">Corporate Protocol v4.0</span>
                </div>

                <h1 class="text-6xl md:text-9xl font-black text-white tracking-tighter uppercase leading-[0.85]">
                    Enterprise <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#ED1C24] via-white to-blue-400 ">Engineering</span>
                </h1>

                <p class="text-xl md:text-2xl text-blue-100/40 font-medium max-w-3xl mx-auto leading-relaxed ">
                    "High-fidelity orchestration for multinational organizations, specialized in mission-critical event logistics and terrestrial operations."
                </p>

                <div class="flex flex-wrap justify-center gap-6 pt-12">
                    <a href="{{ route('contact') }}" class="group relative px-12 py-6 bg-[#ED1C24] text-white rounded-2xl font-black uppercase tracking-widest text-xs overflow-hidden transition-all duration-300 hover:scale-110 active:scale-95 shadow-2xl shadow-red-500/20">
                        <span class="relative z-10 flex items-center gap-3">
                            Connect with HQ <i class="fa-solid fa-arrow-right-long group-hover:translate-x-2 transition-transform"></i>
                        </span>
                        <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                    </a>
                    <a href="#solutions" class="px-12 py-6 bg-white/5 border border-white/10 text-white rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-white/10 transition-all">
                        Operational Portfolio
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Corporate Solutions Grid -->
    <section id="solutions" class="py-32 relative bg-white/2 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-24 space-y-4">
                <h4 class="text-[10px] font-black text-[#ED1C24] uppercase tracking-[0.8em]">Operational Capabilities</h4>
                <h2 class="text-5xl md:text-6xl font-black text-white uppercase tracking-tighter leading-none">
                    Mission <span class="text-[#ED1C24]">Parameters</span>
                </h2>
                <p class="text-blue-100/40 max-w-2xl mx-auto text-lg font-medium ">
                    "Scalable logistics for the high-performing modern enterprise."
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $services = [
                        ['icon' => 'fa-handshake', 'title' => 'Executive Galas', 'img' => 'photo-1505373877841-8d25f7d46678', 'desc' => 'Precision-engineered annual meetings and high-stakes award ceremonies.', 'color' => '#ED1C24'],
                        ['icon' => 'fa-users-gear', 'title' => 'Neural Syncing', 'img' => 'photo-1522071820081-009f0129c71c', 'desc' => 'Tactical team retreats designed to align core organizational values.', 'color' => '#3B82F6'],
                        ['icon' => 'fa-plane-departure', 'title' => 'Global Logistics', 'img' => 'photo-1436450412740-6b988f486c6b', 'desc' => 'Total travel management for executive deployments and group hospitality.', 'color' => '#ED1C24'],
                        ['icon' => 'fa-chalkboard-user', 'title' => 'Summit Management', 'img' => 'photo-1475721027187-402ad2989a3b', 'desc' => 'End-to-end conference technicals, venue secure-ops, and coordination.', 'color' => '#3B82F6'],
                        ['icon' => 'fa-champagne-glasses', 'title' => 'Node Hospitality', 'img' => 'photo-1517457373958-b7bdd4587205', 'desc' => 'Premium entertainment protocols for Tier-1 client engagement.', 'color' => '#ED1C24'],
                        ['icon' => 'fa-building-user', 'title' => 'Asset Acquisition', 'img' => 'photo-1497366216548-37526070297c', 'desc' => 'Strategic access to exclusive corporate venues and neural centers.', 'color' => '#3B82F6'],
                    ];
                @endphp

                @foreach($services as $service)
                <div class="group relative h-[380px] rounded-[2.5rem] overflow-hidden border border-white/10 transition-all duration-700 hover:-translate-y-3">
                    <!-- Background Image -->
                    <img src="https://images.unsplash.com/{{ $service['img'] }}?auto=format&fit=crop&w=600&q=80" 
                         class="absolute inset-0 w-full h-full object-cover transform scale-110 group-hover:scale-100 transition-transform duration-[2s]">
                    
                    <!-- Advanced Overlay -->
                    <div class="absolute inset-0 bg-[#0A192F]/60 group-hover:bg-[#0A192F]/30 transition-colors duration-700"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F] via-[#0A192F]/40 to-transparent"></div>
                    
                    <div class="absolute inset-0 p-10 flex flex-col justify-end">
                        <div class="w-14 h-14 rounded-2xl bg-white/5 backdrop-blur-xl border border-white/10 flex items-center justify-center mb-6 text-white group-hover:scale-110 transition-all duration-700">
                            <i class="fa-solid {{ $service['icon'] }} text-xl" style="color: {{ $service['color'] }}"></i>
                        </div>
                        
                        <div>
                            <h3 class="text-2xl font-black text-white uppercase tracking-tighter mb-4">{{ $service['title'] }}</h3>
                            <p class="text-[11px] text-blue-100/40 font-medium leading-relaxed group-hover:text-blue-100/70 transition-colors duration-500">"{{ $service['desc'] }}"</p>
                        </div>
                    </div>

                    <!-- Glowing Pulse Accent -->
                    <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-2/3 h-px bg-[#ED1C24] blur-sm opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Enterprise Core Advancements -->
    <section class="py-32 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-white/5 rounded-[3rem] border border-white/10 p-12 md:p-24 relative overflow-hidden">
                <div class="absolute inset-0 opacity-5 pointer-events-none">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <path d="M0 50 Q 50 0 100 50" fill="none" stroke="#ED1C24" stroke-width="0.5" />
                    </svg>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center relative z-10">
                    <div class="space-y-12">
                        <div>
                            <h4 class="text-[10px] font-black text-[#ED1C24] uppercase tracking-[0.8em] mb-4">Core Infrastructure</h4>
                            <h2 class="text-5xl md:text-7xl font-black text-white uppercase tracking-tighter leading-none">
                                Enterprise <span class="text-[#ED1C24]">Architecture</span>
                            </h2>
                        </div>
                        
                        <div class="space-y-10">
                            @php
                                $benefits = [
                                    ['icon' => 'fa-chart-line', 'title' => 'Scaling Protocol', 'desc' => 'Fluid transition from regional meeting nodes to global architecture.'],
                                    ['icon' => 'fa-shield-halved', 'title' => 'Secure Billing', 'desc' => 'Corporate accounts with encrypted invoicing and secure credit portals.'],
                                    ['icon' => 'fa-user-astronaut', 'title' => 'Dedicated Intel Liaison', 'desc' => 'Single-point command for all organizational deployment needs.'],
                                    ['icon' => 'fa-dna', 'title' => 'Neural Data Ops', 'desc' => 'Enterprise-grade confidentiality and tactical security protocols.'],
                                ];
                            @endphp

                            @foreach($benefits as $benefit)
                            <div class="flex gap-8 items-start group">
                                <div class="w-14 h-14 bg-white/5 rounded-2xl flex items-center justify-center shrink-0 group-hover:bg-[#ED1C24] transition-all duration-500 border border-white/10">
                                    <i class="fa-solid {{ $benefit['icon'] }} text-[#ED1C24] group-hover:text-white transition-colors duration-500"></i>
                                </div>
                                <div class="space-y-1">
                                    <h4 class="text-xl font-black text-white uppercase tracking-tight">{{ $benefit['title'] }}</h4>
                                    <p class="text-blue-100/40 text-sm font-medium ">"{{ $benefit['desc'] }}"</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="relative hidden lg:block">
                        <div class="relative z-10 aspect-square rounded-full border border-[#ED1C24]/30 p-12 animate-[spin_60s_linear_infinite]">
                            <div class="w-full h-full rounded-full border-2 border-dashed border-white/10 flex items-center justify-center">
                                <i class="fa-solid fa-microchip text-white/5 text-[10rem]"></i>
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-[#ED1C24]/10 rounded-full filter blur-3xl scale-75"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Global Network Nodes (Logos) -->
    <section class="py-32 relative border-y border-white/10">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h4 class="text-[10px] font-black text-gray-500 uppercase tracking-[1em] mb-12">Authorized Global Partners</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-8 opacity-40 grayscale transition-all hover:opacity-100 duration-1000">
                @for($i = 1; $i <= 8; $i++)
                <div class="flex items-center justify-center">
                    <i class="fa-solid fa-building text-3xl text-white"></i>
                </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- Final Transmission CTA -->
    <section class="py-40 relative">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center space-y-12">
                <h2 class="text-5xl md:text-8xl font-black text-white uppercase tracking-tighter leading-none">
                    Start Your <br/>
                    <span class="text-[#ED1C24] ">Elite Deployment</span>
                </h2>
                <p class="text-xl text-blue-100/40 max-w-2xl mx-auto font-medium  leading-relaxed">
                    "Connect with our strategic operations unit to engineer your next enterprise-scale orchestration."
                </p>
                <div class="flex flex-col md:flex-row items-center justify-center gap-6 pt-12">
                    <a href="{{ route('contact') }}" class="group relative px-16 py-8 bg-[#ED1C24] text-white rounded-[2rem] font-black uppercase tracking-[0.2em] text-xs transition-all hover:scale-110 shadow-2xl shadow-red-500/30 overflow-hidden">
                        <span class="relative z-10">Initialize HQ Protocol</span>
                        <div class="absolute inset-x-0 bottom-0 h-0 group-hover:h-full bg-black/20 transition-all duration-500"></div>
                    </a>
                    <a href="mailto:hq@eventy.pk" class="px-16 py-8 bg-white/5 text-white border border-white/10 rounded-[2rem] font-black uppercase tracking-[0.2em] text-xs hover:bg-white/10 transition-all">
                        Secure Comms
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Animated Accents -->
        <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-[#ED1C24] to-transparent opacity-30"></div>
    </section>

</div>
@endsection

