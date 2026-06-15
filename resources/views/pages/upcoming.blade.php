@extends('layouts.public')

@section('title', 'Innovation Roadmap (Strategic R&D)')
@section('description', 'Explore the Eventy.pk neural roadmap and upcoming feature deployments.')

@section('content')
<div class="bg-[#0A192F] relative overflow-hidden min-h-screen">
    <!-- Orchestration Protocol (Hero) -->
    <div class="relative pt-48 pb-32 overflow-hidden border-b border-white/5">
        <!-- Strategic Background Architecture -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&q=80&w=2000" alt="Neural Network" class="w-full h-full object-cover opacity-10 filter grayscale contrast-125">
            <div class="absolute inset-0 bg-gradient-to-b from-[#0A192F]/50 via-[#0A192F]/80 to-[#0A192F]"></div>
        </div>
        <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 60px 60px;"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <div class="inline-flex items-center gap-4 bg-white/5 backdrop-blur-3xl px-6 py-3 rounded-full border border-white/10 mb-12 transform hover:scale-105 transition-all cursor-default group">
                <span class="w-2 h-2 rounded-full bg-[#ED1C24] group-hover:animate-ping"></span>
                <span class="text-[10px] font-black text-white uppercase tracking-[0.5em]">Innovation Roadmap v4.0.0</span>
            </div>
            
            <h1 class="text-6xl md:text-9xl font-black text-white mb-10 tracking-tighter uppercase leading-[0.85]">
                Future <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#ED1C24] via-white to-blue-400 ">Deployments</span>
            </h1>
            
            <p class="text-blue-100/40 text-xl md:text-2xl font-medium max-w-4xl mx-auto  leading-relaxed">
                "Eventy's strategic roadmap to engineering global leadership in events & hospitality technology through high-fidelity neural orchestration."
            </p>
        </div>
    </div>

    <!-- Features Matrix -->
    <section class="py-32 relative bg-white/[0.02]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-24 space-y-6">
                <h4 class="text-[10px] font-black text-[#ED1C24] uppercase tracking-[0.8em]">Core Capabilities</h4>
                <h2 class="text-5xl md:text-6xl font-black text-white uppercase tracking-tighter leading-none">
                    Strategic <span class="text-[#ED1C24]">Initiatives</span>
                </h2>
                <div class="h-px w-32 bg-[#ED1C24]/30 mx-auto mt-8"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $features = [
                        [
                            'title' => 'Mobile Neural App',
                            'q' => 'Q1 2026',
                            'icon' => 'fa-mobile-screen',
                            'desc' => 'Native mobile application for seamless event booking and vendor management on-the-go.',
                            'points' => ['Instant Node Booking', 'Real-time Vector Tracking', 'AI Assistance Sync', 'Secure Comms Protocol'],
                            'color' => '#ED1C24'
                        ],
                        [
                            'title' => 'AI Smart Planner',
                            'q' => 'Q2 2026',
                            'icon' => 'fa-robot',
                            'desc' => 'Advanced AI-powered event planning with automatic vendor matching and optimization.',
                            'points' => ['Auto Matching Logic', 'Budget Optimization', 'Timeline Generation', 'Smart Recommendations'],
                            'color' => '#3B82F6'
                        ],
                        [
                            'title' => 'Domestic Expansion',
                            'q' => '2026',
                            'icon' => 'fa-building',
                            'desc' => 'Physical presence across major cities in Pakistan for comprehensive on-ground support.',
                            'points' => ['Karachi Ops Center', 'Lahore Design Node', 'Islamabad Command', 'Multan Headquarters'],
                            'color' => '#ED1C24'
                        ],
                        [
                            'title' => 'Aerial Partnerships',
                            'q' => '2026-27',
                            'icon' => 'fa-plane',
                            'desc' => 'Direct partnerships with global airlines for seamless flight bookings and exclusive deals.',
                            'points' => ['PIA & Emirates Sync', 'Qatar Airways Node', 'Turkish Aero Links', 'Exclusive Aero Deals'],
                            'color' => '#3B82F6'
                        ],
                        [
                            'title' => 'Global Hotel Grid',
                            'q' => '2026',
                            'icon' => 'fa-hotel',
                            'desc' => 'Strategic partnerships with premium hotels and resorts worldwide for exclusive rates.',
                            'points' => ['5-Star Network Access', 'Luxury Sanctuary Keys', 'Budget Tier Integration', 'Verified Stay Protocol'],
                            'color' => '#ED1C24'
                        ],
                        [
                            'title' => 'Global Franchise',
                            'q' => '2027+',
                            'icon' => 'fa-earth-americas',
                            'desc' => 'Expand Eventy\'s presence globally through strategic franchise partnerships.',
                            'points' => ['UAE/MENA Expansion', 'Euro-Atlantic Grid', 'North American Nodes', 'SE-Asia Integration'],
                            'color' => '#3B82F6'
                        ],
                    ];
                @endphp

                @foreach($features as $feature)
                <div class="group relative bg-white/5 rounded-[2.5rem] p-12 border border-white/10 hover:bg-white/[0.08] hover:border-[#ED1C24]/30 transition-all duration-500 overflow-hidden">
                    <div class="absolute top-6 right-6 px-4 py-1.5 bg-white/5 rounded-full border border-white/10 text-[9px] font-black text-white uppercase tracking-widest">{{ $feature['q'] }}</div>
                    
                    <div class="relative z-10 space-y-8">
                        <div class="w-20 h-20 bg-white/5 rounded-3xl flex items-center justify-center group-hover:scale-110 transition-transform duration-500 border border-white/10">
                            <i class="fa-solid {{ $feature['icon'] }} text-3xl" style="color: {{ $feature['color'] }}"></i>
                        </div>
                        
                        <div>
                            <h3 class="text-2xl font-black text-white uppercase tracking-tight mb-4">{{ $feature['title'] }}</h3>
                            <p class="text-blue-100/40 text-sm font-medium leading-relaxed  mb-8">"{{ $feature['desc'] }}"</p>
                            
                            <ul class="space-y-4">
                                @foreach($feature['points'] as $point)
                                <li class="flex items-center gap-4 text-xs font-black text-white/60 uppercase tracking-widest group-hover:text-white transition-colors">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#ED1C24]"></span>
                                    {{ $point }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Glowing Pulse Accent -->
                    <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-2/3 h-px bg-[#ED1C24] blur-sm opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Development Timeline -->
    <section class="py-32 relative">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-24 space-y-6">
                <h4 class="text-[10px] font-black text-[#ED1C24] uppercase tracking-[0.8em]">Deployment Sequence</h4>
                <h2 class="text-5xl md:text-6xl font-black text-white uppercase tracking-tighter leading-none">
                    Mission <span class="text-[#ED1C24]">Log</span>
                </h2>
                <div class="h-px w-32 bg-[#ED1C24]/30 mx-auto mt-8"></div>
            </div>

            <div class="space-y-12 relative">
                <!-- Vertical Architecture Line -->
                <div class="absolute left-1/2 -translate-x-1/2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-[#ED1C24] via-blue-500 to-[#ED1C24] opacity-10"></div>
                
                @php
                    $timeline = [
                        ['date' => 'Dec 2025', 'title' => 'Global Genesis', 'desc' => 'eventy.pk network activation worldwide.', 'color' => '#ED1C24'],
                        ['date' => 'Q1 2026', 'title' => 'Mobile Neural', 'desc' => 'iOS & Android command center launch.', 'color' => '#3B82F6'],
                        ['date' => 'Q2 2026', 'title' => 'AI Processor', 'desc' => 'Advanced neural planning tools online.', 'color' => '#ED1C24'],
                        ['date' => '2026', 'title' => 'Regional Nodes', 'desc' => 'Command centers in Karachi, Lahore, Islamabad.', 'color' => '#3B82F6'],
                        ['date' => '2027+', 'title' => 'Planetary Expansion', 'desc' => 'Global franchise network activation.', 'color' => '#ED1C24'],
                    ];
                @endphp

                @foreach($timeline as $index => $item)
                <div class="relative flex items-center justify-between group">
                    @if($index % 2 == 0)
                    <div class="w-[45%] text-right pr-12">
                        <span class="text-[10px] font-black text-[#ED1C24] uppercase tracking-widest block mb-1">{{ $item['date'] }}</span>
                        <h4 class="text-xl font-black text-white uppercase tracking-tight">{{ $item['title'] }}</h4>
                        <p class="text-blue-100/30 text-xs ">"{{ $item['desc'] }}"</p>
                    </div>
                    <div class="relative z-10 w-4 h-4 rounded-full bg-white border-4 border-[#ED1C24] shadow-[0_0_20px_rgba(237,28,36,0.5)] group-hover:scale-150 transition-transform"></div>
                    <div class="w-[45%]"></div>
                    @else
                    <div class="w-[45%]"></div>
                    <div class="relative z-10 w-4 h-4 rounded-full bg-white border-4 border-[#3B82F6] shadow-[0_0_20px_rgba(59,130,246,0.5)] group-hover:scale-150 transition-transform"></div>
                    <div class="w-[45%] text-left pl-12">
                        <span class="text-[10px] font-black text-[#3B82F6] uppercase tracking-widest block mb-1">{{ $item['date'] }}</span>
                        <h4 class="text-xl font-black text-white uppercase tracking-tight">{{ $item['title'] }}</h4>
                        <p class="text-blue-100/30 text-xs ">"{{ $item['desc'] }}"</p>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Final Transmission CTA -->
    <section class="py-40 relative">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <div class="space-y-12">
                <h2 class="text-5xl md:text-8xl font-black text-white uppercase tracking-tighter leading-none">
                    Join the <br/>
                    <span class="text-[#ED1C24] ">Elite Ascent</span>
                </h2>
                <p class="text-xl text-blue-100/40 max-w-2xl mx-auto font-medium  leading-relaxed">
                    "Sync with Eventy HQ today and grow with the architects revolutionizing the global industry."
                </p>
                <div class="flex flex-col md:flex-row items-center justify-center gap-6 pt-12">
                    <a href="{{ route('register') }}" class="group relative px-16 py-8 bg-[#ED1C24] text-white rounded-[2rem] font-black uppercase tracking-[0.2em] text-xs transition-all hover:scale-110 shadow-2xl shadow-red-500/30 overflow-hidden">
                        <span class="relative z-10">Initialize Protocol</span>
                        <div class="absolute inset-x-0 bottom-0 h-0 group-hover:h-full bg-black/20 transition-all duration-500"></div>
                    </a>
                    <a href="{{ route('vendor.register') }}" class="px-16 py-8 bg-white/5 text-white border border-white/10 rounded-[2rem] font-black uppercase tracking-[0.2em] text-xs hover:bg-white/10 transition-all">
                        Partner Ops
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Animated Accents -->
        <div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-[#ED1C24] to-transparent opacity-30"></div>
    </section>
</div>
@endsection


