@extends('layouts.public')

@section('title', 'Global Network | Strategic Asset Deployment')
@section('description', 'Eventy operates a decentralized global network of verified service nodes, coordinators, and logistics partners across 50+ countries.')

@section('content')
<div class="bg-[#0A192F] min-h-screen selection:bg-[#ED1C24] selection:text-white">
    <!-- Global Intelligence (Hero) -->
    <div class="relative pt-40 pb-48 overflow-hidden">
        <!-- Strategic Background Architecture -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&q=80&w=2000" alt="Global Network" class="w-full h-full object-cover opacity-10 filter grayscale contrast-125">
            <div class="absolute inset-0 bg-gradient-to-b from-[#0A192F]/50 via-[#0A192F]/80 to-[#0A192F]"></div>
        </div>
        <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 60px 60px;"></div>
        
        <div class="max-w-[1400px] mx-auto px-6 relative z-10 text-center">
            <div class="inline-flex items-center gap-3 bg-white/5 backdrop-blur-3xl px-6 py-2 rounded-full border border-white/10 mb-12 transform hover:scale-105 transition-all cursor-default group">
                <span class="w-2 h-2 rounded-full bg-[#3B82F6] group-hover:animate-ping"></span>
                <span class="text-[10px] font-black text-white uppercase tracking-[0.4em]">Decentralized Asset Network v4.0.0</span>
            </div>
            
            <h1 class="text-5xl md:text-9xl font-black text-white mb-10 tracking-tighter uppercase leading-[0.85]">
                Global <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#ED1C24] via-white to-blue-400 ">Command</span>
            </h1>
            
            <p class="text-blue-100/40 text-lg md:text-2xl font-medium max-w-4xl mx-auto  leading-relaxed mb-20">
                "Operating in 50+ sovereign jurisdictions through verified local intelligence, terrestrial vendor networks, and strategic logistical partnerships."
            </p>

            <!-- Integrated Telemetry Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 max-w-5xl mx-auto">
                @foreach([
                    ['label' => 'Sovereign States', 'value' => '50+', 'icon' => 'fa-globe-europe'],
                    ['label' => 'Verified Assets', 'value' => '500+', 'icon' => 'fa-shield-check'],
                    ['label' => 'Strategic Hubs', 'value' => '200+', 'icon' => 'fa-network-wired'],
                    ['label' => 'Uplink Success', 'value' => '99.9%', 'icon' => 'fa-bolt']
                ] as $stat)
                <div class="bg-white/5 backdrop-blur-3xl rounded-[2rem] p-8 border border-white/10 hover:bg-white/10 transition-all duration-500 group">
                    <div class="text-3xl font-black text-white mb-2 tracking-tighter group-hover:text-[#ED1C24] transition-colors">{{ $stat['value'] }}</div>
                    <div class="text-[9px] font-black text-blue-100/30 uppercase tracking-[0.3em] flex items-center justify-center gap-3">
                        <i class="fa-solid {{ $stat['icon'] }} text-[#ED1C24]"></i>
                        {{ $stat['label'] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Regional Nodes Coverage -->
    <div class="py-40 bg-white relative overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-32 space-y-6">
                <h4 class="text-[10px] font-black text-[#ED1C24] uppercase tracking-[0.8em]">Terrestrial Hub Architecture</h4>
                <h2 class="text-5xl md:text-7xl font-black text-[#0A192F] tracking-tighter uppercase leading-none">
                    Regional <span class="text-[#ED1C24]">Nodes</span>
                </h2>
                <div class="w-24 h-2 bg-gradient-to-r from-[#ED1C24] to-blue-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                @php
                    $nodes = [
                        ['code' => 'PK', 'name' => 'Pakistan', 'sub' => 'Central Command', 'status' => 'Active', 'type' => 'HQ'],
                        ['code' => 'AE', 'name' => 'United Arab Emirates', 'sub' => 'MENA Hub', 'status' => 'Active', 'type' => 'Node'],
                        ['code' => 'SA', 'name' => 'Saudi Arabia', 'sub' => 'Gulf Operations', 'status' => 'Active', 'type' => 'Node'],
                        ['code' => 'TR', 'name' => 'Türkiye', 'sub' => 'Eurasia Link', 'status' => 'Active', 'type' => 'Node'],
                        ['code' => 'UK', 'name' => 'United Kingdom', 'sub' => 'Europe Prime', 'status' => 'Active', 'type' => 'Node'],
                        ['code' => 'US', 'name' => 'United States', 'sub' => 'Americas Hub', 'status' => 'Expanding', 'type' => 'Link'],
                        ['code' => 'MY', 'name' => 'Malaysia', 'sub' => 'ASEAN Center', 'status' => 'Active', 'type' => 'Node'],
                        ['code' => 'TH', 'name' => 'Thailand', 'sub' => 'East Asia Ops', 'status' => 'Active', 'type' => 'Node'],
                    ];
                @endphp

                @foreach($nodes as $node)
                <div class="group relative bg-[#F8FAFC] rounded-[3rem] p-10 border border-gray-100 hover:bg-[#0A192F] hover:text-white transition-all duration-700 hover:-translate-y-4 shadow-xl shadow-gray-200/20">
                    <div class="text-6xl font-black text-gray-100 group-hover:text-white/10 mb-8 transition-colors duration-700 tracking-tighter">{{ $node['code'] }}</div>
                    <div class="space-y-2 mb-8">
                        <h4 class="font-black text-xl uppercase tracking-tighter">{{ $node['name'] }}</h4>
                        <p class="text-xs font-bold text-gray-400 group-hover:text-blue-100/40 uppercase tracking-widest">{{ $node['sub'] }}</p>
                    </div>
                    <div class="flex items-center justify-between pt-8 border-t border-gray-100 group-hover:border-white/10">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[9px] font-black uppercase {{ $node['status'] == 'Active' ? 'bg-emerald-50 text-emerald-700 group-hover:bg-emerald-500 group-hover:text-white' : 'bg-blue-50 text-blue-700 group-hover:bg-blue-500 group-hover:text-white' }} transition-colors">
                            <span class="w-1.5 h-1.5 rounded-full {{ $node['status'] == 'Active' ? 'bg-emerald-500 group-hover:bg-white' : 'bg-blue-500 group-hover:bg-white' }} animate-pulse"></span>
                            {{ $node['status'] }}
                        </span>
                        <span class="text-[9px] font-black text-gray-300 group-hover:text-white/20 uppercase tracking-widest">{{ $node['type'] }}</span>
                    </div>
                    <!-- Technical Decoration -->
                    <div class="absolute top-8 right-8 w-1.5 h-1.5 rounded-full bg-[#ED1C24] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Operational Methodology -->
    <div class="py-40 bg-[#0A192F] relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(white 1px, transparent 1px); background-size: 60px 60px;"></div>
        
        <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-32 space-y-6">
                <h4 class="text-[10px] font-black text-[#ED1C24] uppercase tracking-[0.8em]">Strategic Workflow</h4>
                <h2 class="text-5xl md:text-7xl font-black text-white tracking-tighter uppercase leading-none">
                    Mission <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-white/20">Execution</span>
                </h2>
                <div class="w-24 h-2 bg-gradient-to-r from-[#ED1C24] to-blue-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-12">
                @foreach([
                    ['title' => 'In-Situ Coordinators', 'icon' => 'fa-users-gear', 'desc' => 'On-ground operational teams in each node ensuring absolute precision and local symmetry.'],
                    ['title' => 'Vetted Asset Clusters', 'icon' => 'fa-network-wired', 'desc' => 'Proprietary networks of verified hospitality, logistics, and media partners across all regions.'],
                    ['title' => 'Logistical Synergy', 'icon' => 'fa-plane-departure', 'desc' => 'Strategic deep-integrations with elite carrier networks for seamless cross-border deployment.']
                ] as $item)
                <div class="group p-12 bg-white/5 border border-white/10 rounded-[4rem] hover:bg-white/10 hover:border-[#ED1C24]/30 transition-all duration-700 h-full shadow-2xl">
                    <div class="w-20 h-20 bg-white/5 rounded-3xl flex items-center justify-center mb-10 border border-white/10 group-hover:scale-110 group-hover:bg-[#ED1C24] transition-all duration-700">
                        <i class="fa-solid {{ $item['icon'] }} text-3xl text-white"></i>
                    </div>
                    <h4 class="text-2xl font-black text-white uppercase tracking-tighter mb-6">{{ $item['title'] }}</h4>
                    <p class="text-blue-100/40 font-medium leading-relaxed  text-lg">{{ $item['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Final Execution Node (CTA) -->
    <div class="relative py-48 overflow-hidden bg-white">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-blue-600/5 rounded-full blur-[150px]"></div>
            <div class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-[#ED1C24]/5 rounded-full blur-[120px]"></div>
        </div>

        <div class="max-w-5xl mx-auto px-6 text-center relative z-10 space-y-16">
            <h2 class="text-6xl md:text-9xl font-black text-[#0A192F] tracking-tighter uppercase leading-[0.85]">
                Plan Global <br/><span class="text-[#ED1C24]">Orchestration</span>
            </h2>
            <p class="text-gray-400 text-xl font-medium max-w-2xl mx-auto ">
                "Destination heritage, international summits, or global luxury tours — we deliver seamless execution across continents."
            </p>
            
            <div class="flex flex-col sm:flex-row gap-8 justify-center pt-8">
                <a href="{{ route('contact') }}" class="group relative px-16 py-8 bg-[#0A192F] text-white rounded-[2rem] font-black text-sm uppercase tracking-[0.4em] shadow-2xl hover:scale-110 active:scale-95 transition-all duration-500 overflow-hidden">
                    <span class="relative z-10 flex items-center gap-4">Contact Global Ops <i class="fa-solid fa-satellite-dish"></i></span>
                    <div class="absolute inset-0 bg-[#ED1C24] translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                </a>
                <a href="{{ route('services') }}" class="px-16 py-8 bg-gray-50 border border-gray-100 text-[#0A192F] rounded-[2rem] font-black text-sm uppercase tracking-[0.4em] hover:bg-gray-100 transition-all duration-500">
                    Explore Asset Map
                </a>
            </div>
        </div>
    </div>
</div>
@endsection


