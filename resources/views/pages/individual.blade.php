@extends('layouts.public')

@section('title', 'Personalized Orchestration (Individuals)')
@section('description', 'Bespoke event planning, premium travel, and executive hospitality for individuals and families.')

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
        <div class="absolute bottom-20 left-10 w-[500px] h-[500px] bg-[#ED1C24]/10 rounded-full filter blur-[120px] animate-pulse" style="animation-delay: 1s;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6">
            <div class="text-center space-y-12">
                <div class="inline-flex items-center gap-4 bg-white/5 backdrop-blur-3xl px-6 py-3 rounded-full border border-white/10 hover:border-[#ED1C24]/30 transition-all cursor-default group">
                    <span class="w-2 h-2 rounded-full bg-[#ED1C24] group-hover:animate-ping"></span>
                    <span class="text-[10px] font-black text-white uppercase tracking-[0.5em]">Bespoke Individual Protocol</span>
                </div>

                <h1 class="text-6xl md:text-9xl font-black text-white tracking-tighter uppercase leading-[0.85]">
                    Personal <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#ED1C24] via-white to-blue-400 ">Excellence</span>
                </h1>

                <p class="text-xl md:text-2xl text-blue-100/40 font-medium max-w-3xl mx-auto leading-relaxed ">
                    "Tailored event architecture, global travel nodes, and executive hospitality services engineered exclusively for elite individuals and their inner circle."
                </p>

                <div class="flex flex-wrap justify-center gap-6 pt-12">
                    <a href="{{ route('services') }}" class="group relative px-12 py-6 bg-[#ED1C24] text-white rounded-2xl font-black uppercase tracking-widest text-xs overflow-hidden transition-all duration-300 hover:scale-110 active:scale-95 shadow-2xl shadow-red-500/20">
                        <span class="relative z-10 flex items-center gap-3">
                            Access Portfolio <i class="fa-solid fa-arrow-right-long group-hover:translate-x-2 transition-transform"></i>
                        </span>
                        <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                    </a>
                    <a href="{{ route('contact') }}" class="px-12 py-6 bg-white/5 border border-white/10 text-white rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-white/10 transition-all">
                        Initiate Contact
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Capabilities Matrix -->
    <section class="py-32 relative bg-white/2 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-24 space-y-4">
                <h4 class="text-[10px] font-black text-[#ED1C24] uppercase tracking-[0.8em]">Bespoke Capabilities</h4>
                <h2 class="text-5xl md:text-6xl font-black text-white uppercase tracking-tighter leading-none">
                    Asset <span class="text-[#ED1C24]">Solutions</span>
                </h2>
                <p class="text-blue-100/40 max-w-2xl mx-auto text-lg font-medium ">
                    "Curated lifestyle management for the discerning individual."
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $offerings = [
                        ['icon' => 'fa-heart', 'title' => 'Signature Weddings', 'img' => 'photo-1519741497674-611481863552', 'desc' => 'High-fidelity matrimonial orchestration for unforgettable legacy events.', 'color' => '#ED1C24'],
                        ['icon' => 'fa-plane', 'title' => 'Executive Travel', 'img' => 'photo-1502602898657-3e91760cbb34', 'desc' => 'Precision-mapped global expeditions and bespoke hospitality tiers.', 'color' => '#3B82F6'],
                        ['icon' => 'fa-hotel', 'title' => 'Elite Residencies', 'img' => 'photo-1566073771259-6a8506099945', 'desc' => 'Exclusive access to premier hospitality nodes and sanctuary bookings.', 'color' => '#ED1C24'],
                        ['icon' => 'fa-camera', 'title' => 'Visual Assetry', 'img' => 'photo-1542038784456-1ea8e935640e', 'desc' => 'Professional media units to document and archive your private milestones.', 'color' => '#3B82F6'],
                        ['icon' => 'fa-utensils', 'title' => 'Bespoke Catering', 'img' => 'photo-1555244162-803834f70033', 'desc' => 'Culinary engineering for private galas and intimate executive dining.', 'color' => '#ED1C24'],
                        ['icon' => 'fa-car', 'title' => 'Tactical Transport', 'img' => 'photo-1514316454349-750a7fd3da3a', 'desc' => 'Secure vehicle logistics and premium terrestrial mobility solutions.', 'color' => '#3B82F6'],
                    ];
                @endphp

                @foreach($offerings as $offer)
                <div class="group relative h-[380px] rounded-[2.5rem] overflow-hidden border border-white/10 transition-all duration-700 hover:-translate-y-3">
                    <!-- Background Image -->
                    <img src="https://images.unsplash.com/{{ $offer['img'] }}?auto=format&fit=crop&w=600&q=80" 
                         class="absolute inset-0 w-full h-full object-cover transform scale-110 group-hover:scale-100 transition-transform duration-[2s]">
                    
                    <!-- Advanced Overlay -->
                    <div class="absolute inset-0 bg-[#0A192F]/60 group-hover:bg-[#0A192F]/30 transition-colors duration-700"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F] via-[#0A192F]/40 to-transparent"></div>
                    
                    <div class="absolute inset-0 p-10 flex flex-col justify-end">
                        <div class="w-14 h-14 rounded-2xl bg-white/5 backdrop-blur-xl border border-white/10 flex items-center justify-center mb-6 text-white group-hover:scale-110 transition-all duration-700">
                            <i class="fa-solid {{ $offer['icon'] }} text-xl" style="color: {{ $offer['color'] }}"></i>
                        </div>
                        
                        <div>
                            <h3 class="text-2xl font-black text-white uppercase tracking-tighter mb-4">{{ $offer['title'] }}</h3>
                            <p class="text-[11px] text-blue-100/40 font-medium leading-relaxed group-hover:text-blue-100/70 transition-colors duration-500">"{{ $offer['desc'] }}"</p>
                        </div>
                    </div>

                    <!-- Glowing Pulse Accent -->
                    <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-2/3 h-px bg-[#ED1C24] blur-sm opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Why Eventy HQ -->
    <section class="py-32 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-white/5 rounded-[3rem] border border-white/10 p-12 md:p-24 relative overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
                    <div class="space-y-12">
                        <div>
                            <h4 class="text-[10px] font-black text-[#ED1C24] uppercase tracking-[0.8em] mb-4">Core Infrastructure</h4>
                            <h2 class="text-5xl md:text-7xl font-black text-white uppercase tracking-tighter leading-none">
                                Why <span class="text-[#ED1C24]">Eventy HQ</span>?
                            </h2>
                        </div>
                        
                        <div class="space-y-10">
                            @php
                                $benefits = [
                                    ['icon' => 'fa-shield-halved', 'title' => 'Verified Assets', 'desc' => 'Total screening of all service nodes within the neural network.'],
                                    ['icon' => 'fa-gem', 'title' => 'Elite Value', 'desc' => 'Competitive procurement for premium-tier orchestration services.'],
                                    ['icon' => 'fa-headset', 'title' => '24/7 Command', 'desc' => 'Continuous liaison for mission-critical support in any time zone.'],
                                    ['icon' => 'fa-star', 'title' => 'Proven Protocol', 'desc' => 'Premium deliverables backed by a legacy of successful missions.'],
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
                        <div class="aspect-square rounded-[3rem] bg-gradient-to-br from-[#ED1C24]/20 to-blue-500/20 backdrop-blur-3xl border border-white/10 flex items-center justify-center relative overflow-hidden">
                            <i class="fa-solid fa-user-tie text-white/5 text-[15rem]"></i>
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F] via-transparent to-transparent"></div>
                        </div>
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-[#ED1C24]/20 rounded-full blur-3xl animate-pulse"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final Transmission CTA -->
    <section class="py-40 relative">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <div class="space-y-12">
                <h2 class="text-5xl md:text-8xl font-black text-white uppercase tracking-tighter leading-none">
                    Initialize <br/>
                    <span class="text-[#ED1C24] ">Your Vision</span>
                </h2>
                <p class="text-xl text-blue-100/40 max-w-2xl mx-auto font-medium  leading-relaxed">
                    "Link with our personnel architects to engineer your next personal masterpiece."
                </p>
                <div class="flex flex-col md:flex-row items-center justify-center gap-6 pt-12">
                    <a href="{{ route('services') }}" class="group relative px-16 py-8 bg-[#ED1C24] text-white rounded-[2rem] font-black uppercase tracking-[0.2em] text-xs transition-all hover:scale-110 shadow-2xl shadow-red-500/30 overflow-hidden">
                        <span class="relative z-10">Explore Services</span>
                        <div class="absolute inset-x-0 bottom-0 h-0 group-hover:h-full bg-black/20 transition-all duration-500"></div>
                    </a>
                    <a href="{{ route('contact') }}" class="px-16 py-8 bg-white/5 text-white border border-white/10 rounded-[2rem] font-black uppercase tracking-[0.2em] text-xs hover:bg-white/10 transition-all">
                        Secure Liaison
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Animated Accents -->
        <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-[#ED1C24] to-transparent opacity-30"></div>
    </section>

</div>
@endsection

