@extends('layouts.public')

@section('content')
<div class="bg-[#020617] min-h-screen pt-32 pb-24 relative overflow-hidden font-sans">
    <!-- background effects -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-[1000px] h-[1000px] bg-[#ED1C24]/5 rounded-full blur-[150px] translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 left-0 w-[800px] h-[800px] bg-indigo-900/5 rounded-full blur-[150px] -translate-x-1/3 translate-y-1/3"></div>
        <!-- grid -->
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(white 1px, transparent 1px); background-size: 50px 50px;"></div>
    </div>

    <div class="max-w-[1400px] mx-auto px-6 relative z-10">
        <!-- Hero: Partnership Uplink -->
        <div class="flex flex-col lg:flex-row items-center gap-20 mb-40">
            <div class="lg:w-3/5">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-[2px] bg-[#ED1C24]"></div>
                    <span class="text-[#ED1C24] text-[10px] font-black uppercase tracking-[0.5em]">Network Expansion Protocol</span>
                </div>
                
                <h1 class="text-6xl md:text-9xl font-black text-white tracking-widest uppercase leading-[0.85] mb-10">
                    Propel Your <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-white to-white/10 uppercase ">Elite Assets</span>
                </h1>
                
                <p class="text-white/40 text-lg md:text-xl leading-relaxed max-w-2xl mb-12 font-mono ">
                    "Join the most sophisticated neural network for high-end event orchestration. Connect your legacy to global premium demand."
                </p>
                
                <div class="flex flex-wrap gap-6">
                    <a href="{{ route('register') }}" class="group relative px-12 py-6 bg-white text-[#020617] font-black uppercase tracking-[0.3em] text-xs rounded-2xl overflow-hidden active:scale-95 transition-all shadow-[0_20px_50px_rgba(255,255,255,0.1)]">
                        <span class="relative z-10 flex items-center gap-3">
                            Apply for Integration <i class="fa-solid fa-plus-minus text-[10px]"></i>
                        </span>
                        <div class="absolute inset-0 bg-[#ED1C24] translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                    </a>
                    
                    <div class="flex items-center gap-6 text-white/20 font-black text-[10px] uppercase tracking-[0.4em]">
                        <div class="flex items-center gap-2 group/status">
                            <span class="w-2 h-2 rounded-full bg-[#ED1C24]"></span>
                            Uplink Active
                        </div>
                        <div class="w-px h-8 bg-white/10"></div>
                        <div class="flex items-center gap-2">
                             System Latency: 4ms
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:w-2/5 relative">
                <div class="relative group/vid">
                    <!-- Scanner Frame -->
                    <div class="absolute -inset-4 border border-white/5 rounded-[4rem] pointer-events-none group-hover/vid:border-[#ED1C24]/20 transition-all duration-700"></div>
                    
                    <div class="relative rounded-[3rem] overflow-hidden border border-white/10 shadow-2xl bg-slate-900 group-hover/vid:scale-[1.02] transition-transform duration-700">
                        <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?q=80&w=2070&auto=format&fit=crop" class="w-full h-[500px] object-cover opacity-60 mix-blend-luminosity hover:opacity-100 transition-opacity duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#020617] via-transparent to-transparent"></div>
                        
                        <!-- High-Tech Overlays -->
                        <div class="absolute top-10 right-10 flex flex-col items-end gap-2">
                            <div class="px-4 py-2 bg-white/5 backdrop-blur-xl border border-white/10 rounded-xl text-[8px] font-black text-white/60 tracking-widest uppercase">
                                Encryption: AES-256
                            </div>
                            <div class="px-4 py-2 bg-white/5 backdrop-blur-xl border border-white/10 rounded-xl text-[8px] font-black text-[#ED1C24] tracking-widest uppercase">
                                Live Feed: Secured
                            </div>
                        </div>

                        <!-- Scan Line -->

                    </div>

                    <!-- Verified Badge -->
                    <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-[#020617] border border-white/10 rounded-full shadow-2xl flex items-center justify-center group/badge overflow-hidden hidden xl:flex">
                        <div class="absolute inset-0 bg-[#ED1C24]/5"></div>
                        <div class="text-center relative z-10">
                            <i class="fa-solid fa-crown text-[#ED1C24] text-3xl mb-2"></i>
                            <div class="text-[8px] font-black text-white/40 uppercase tracking-widest">Elite Tier</div>
                            <div class="text-[10px] font-black text-white uppercase tracking-tighter">Verified Node</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Integration Protocol: 1-2-3-4 -->
        <div class="mb-40">
            <div class="text-center mb-24">
                <h2 class="text-[10px] font-black text-[#ED1C24] uppercase tracking-[0.8em] mb-4">The Process</h2>
                <h3 class="text-4xl md:text-5xl font-black text-white tracking-widest uppercase">Integration Protocol</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @foreach([
                    ['title' => 'Application', 'desc' => 'Submit your portfolio for aesthetic and capacity verification.', 'icon' => 'fa-file-signature'],
                    ['title' => 'Vetting', 'desc' => 'Internal logic check of service quality and historical reliability.', 'icon' => 'fa-shield-heart'],
                    ['title' => 'Syncing', 'desc' => 'Connect your inventory to our global real-time neural network.', 'icon' => 'fa-bolt-lightning'],
                    ['title' => 'Deployment', 'desc' => 'Go live and receive instant uplinks from premium global clients.', 'icon' => 'fa-satellite-dish']
                ] as $index => $step)
                <div class="relative group/step p-8 bg-white/[0.02] border border-white/5 rounded-[2.5rem] hover:bg-white/[0.04] hover:border-[#ED1C24]/30 transition-all duration-500">
                    <div class="absolute top-8 right-8 text-4xl font-black text-white/5  select-none group-hover/step:text-[#ED1C24]/10 transition-colors">0{{ $index + 1 }}</div>
                    <div class="w-14 h-14 bg-white/5 rounded-2xl flex items-center justify-center text-white/40 mb-10 border border-white/5 group-hover/step:text-[#ED1C24] group-hover/step:border-[#ED1C24]/30 group-hover/step:scale-110 transition-all duration-500">
                        <i class="fa-solid {{ $step['icon'] }} text-xl"></i>
                    </div>
                    <h4 class="text-xl font-black text-white uppercase tracking-widest mb-4">{{ $step['title'] }}</h4>
                    <p class="text-white/40 text-xs font-medium leading-relaxed uppercase tracking-wider">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Technical Specifications (Bento Grid) -->
        <div class="mb-40">
            <div class="flex items-center justify-between mb-20">
                <div>
                    <h2 class="text-[10px] font-black text-[#ED1C24] uppercase tracking-[0.8em] mb-4">Network Specs</h2>
                    <h3 class="text-4xl md:text-5xl font-black text-white tracking-widest uppercase">Technical Benefits</h3>
                </div>
                <div class="hidden md:block">
                    <div class="flex gap-2">
                        <div class="w-12 h-[2px] bg-[#ED1C24]"></div>
                        <div class="w-3 h-[2px] bg-white/10"></div>
                        <div class="w-3 h-[2px] bg-white/10"></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 auto-rows-[250px] gap-6">
                <!-- Large Feature: AI Matching -->
                <div class="md:col-span-8 md:row-span-2 relative group/spec bg-[#020617] rounded-[3rem] border border-white/5 overflow-hidden shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#ED1C24]/5 via-transparent to-transparent"></div>
                    <!-- Background Visual -->
                    <div class="absolute right-0 bottom-0 w-2/3 h-2/3 opacity-20 filter grayscale Contrast-150">
                        <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc51?q=80&w=2021&auto=format&fit=crop" class="w-full h-full object-cover rounded-tl-[10rem]">
                    </div>
                    
                    <div class="relative z-10 p-12 h-full flex flex-col justify-between">
                        <div>
                            <div class="w-16 h-16 bg-[#ED1C24]/10 rounded-2xl flex items-center justify-center text-[#ED1C24] mb-8 border border-[#ED1C24]/20 group-hover/spec:scale-110 transition-transform duration-700">
                                <i class="fa-solid fa-microchip text-2xl"></i>
                            </div>
                            <h4 class="text-4xl font-black text-white uppercase tracking-tighter mb-6">Neural Matching Engine</h4>
                            <p class="text-white/40 text-lg max-w-sm leading-relaxed font-medium ">
                                "Our proprietary algorithm predicts client intent and maps it to your specific service nodes with 99.4% precision."
                            </p>
                        </div>
                        <div class="flex gap-4">
                            <span class="px-4 py-2 bg-white/5 rounded-full text-[8px] font-black text-white/60 tracking-widest uppercase">AI Core v4.2</span>
                            <span class="px-4 py-2 bg-white/5 rounded-full text-[8px] font-black text-white/60 tracking-widest uppercase">Predictive Analysis</span>
                        </div>
                    </div>
                </div>

                <!-- Atomic Settlements -->
                <div class="md:col-span-4 md:row-span-1 relative group/spec bg-white/[0.02] rounded-[3rem] border border-white/5 p-10 flex flex-col justify-between hover:border-[#ED1C24]/30 transition-all duration-700">
                    <div class="flex justify-between items-start">
                        <div class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center text-white/40 group-hover/spec:text-[#ED1C24] transition-colors">
                            <i class="fa-solid fa-money-bill-transfer"></i>
                        </div>
                        <div class="text-[8px] font-black text-[#ED1C24]">LIVE NODE</div>
                    </div>
                    <div>
                        <h4 class="text-xl font-black text-white uppercase tracking-widest mb-2">Atomic Settlement</h4>
                        <p class="text-white/20 text-[10px] uppercase font-bold leading-tight tracking-wider">Instant reconciliation & lightning-fast payment clearing.</p>
                    </div>
                </div>

                <!-- Global Traffic -->
                <div class="md:col-span-4 md:row-span-1 relative group/spec bg-white/[0.02] rounded-[3rem] border border-white/5 p-10 flex flex-col justify-between hover:border-[#ED1C24]/30 transition-all duration-700">
                    <div class="flex justify-between items-start">
                        <div class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center text-white/40 group-hover/spec:text-[#ED1C24] transition-colors">
                            <i class="fa-solid fa-globe"></i>
                        </div>
                        <div class="text-[8px] font-black text-white/20 uppercase tracking-widest text-right">SECURE CDN</div>
                    </div>
                    <div>
                        <h4 class="text-xl font-black text-white uppercase tracking-widest mb-2">Elite Global Traffic</h4>
                        <p class="text-white/20 text-[10px] uppercase font-bold leading-tight tracking-wider">Connect directly to HNWIs and Corporate Event Planners worldwide.</p>
                    </div>
                </div>

                <!-- Security Tier -->
                <div class="md:col-span-4 md:row-span-1 relative group/spec bg-[#ED1C24] rounded-[3rem] p-10 flex flex-col justify-between hover:bg-white hover:text-[#020617] group transition-all duration-700">
                    <div class="w-12 h-12 bg-black/10 rounded-xl flex items-center justify-center text-white group-hover:bg-[#020617] transition-all">
                        <i class="fa-solid fa-shield-virus"></i>
                    </div>
                    <div>
                        <h4 class="text-xl font-black text-white group-hover:text-[#020617] uppercase tracking-widest mb-2">Military-Grade Escrow</h4>
                        <p class="text-white/60 group-hover:text-[#020617]/60 text-[10px] uppercase font-bold leading-tight tracking-wider">End-to-End protection for every deployment contract.</p>
                    </div>
                </div>

                <!-- Analytics -->
                <div class="md:col-span-8 md:row-span-1 relative group/spec bg-white/[0.02] rounded-[3rem] border border-white/5 p-10 flex items-center gap-10 hover:border-[#ED1C24]/30 transition-all duration-700 overflow-hidden">
                    <div class="hidden md:flex flex-col gap-2 opacity-10">
                        <div class="w-40 h-2 bg-white rounded-full"></div>
                        <div class="w-64 h-2 bg-[#ED1C24] rounded-full"></div>
                        <div class="w-48 h-2 bg-white rounded-full"></div>
                    </div>
                    <div class="flex-grow">
                        <h4 class="text-3xl font-black text-white uppercase tracking-tighter mb-2">Signature Analytics</h4>
                        <p class="text-white/40 text-[10px] uppercase font-black tracking-[0.3em]">Real-time dossier of your assets' performance.</p>
                    </div>
                    <div class="shrink-0 w-24 h-24 bg-white/5 rounded-full border border-white/10 flex items-center justify-center group-hover/spec:scale-110 transition-transform">
                        <i class="fa-solid fa-chart-line text-white/20 text-3xl group-hover/spec:text-[#ED1C24]"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Partnership Initialization CTA -->
        <div class="relative py-32 bg-[#020617] rounded-[4rem] border border-white/5 overflow-hidden group/cta text-center shadow-3xl">
            <!-- Pulse Effect -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-[#ED1C24]/5 rounded-full blur-[100px] opacity-0 group-hover/cta:opacity-100 transition-opacity duration-1000"></div>
            
            <div class="relative z-10 max-w-3xl mx-auto px-6">
                <div class="inline-flex items-center gap-3 bg-white/5 px-4 py-2 rounded-full border border-white/10 mb-8">
                    <span class="w-2 h-2 rounded-full bg-[#ED1C24]"></span>
                    <span class="text-[8px] font-black text-white/40 uppercase tracking-[0.4em]">Initialize Final Uplink</span>
                </div>
                
                <h2 class="text-4xl md:text-7xl font-black text-white uppercase tracking-widest leading-none mb-10">
                    Ready for <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-white to-[#ED1C24]/50">Strategic Integration?</span>
                </h2>
                
                <p class="text-white/30 text-lg md:text-xl font-mono  mb-12 leading-relaxed">
                    "The elite network is waiting for your signature. Connect your assets to the orchestration desk."
                </p>
                
                <div class="flex flex-col md:flex-row items-center justify-center gap-8">
                    <a href="{{ route('register') }}" class="group/btn relative px-16 py-8 bg-white text-[#020617] font-black uppercase tracking-[0.4em] text-xs rounded-2xl overflow-hidden shadow-2xl transition-all hover:scale-110 active:scale-95">
                        <span class="relative z-10 flex items-center gap-4">
                            Establish Connection <i class="fa-solid fa-network-wired text-[10px] group-hover/btn:rotate-180 transition-transform duration-700"></i>
                        </span>
                        <div class="absolute inset-0 bg-[#ED1C24] translate-x-full group-hover:translate-x-0 transition-transform duration-500"></div>
                    </a>
                    
                    <button @click="$dispatch('open-concierge', { message: 'I want to discuss partner integration protocols.' })" 
                            class="text-white/40 hover:text-white font-black text-[10px] uppercase tracking-[0.3em] flex items-center gap-3 transition-colors group/msg">
                        <i class="fa-regular fa-comment-dots text-lg group-hover/msg:scale-125 transition-transform"></i> Request Briefing
                    </button>
                </div>
            </div>
            
            <!-- Bottom Scan Line -->
            <div class="absolute bottom-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-[#ED1C24]/40 to-transparent"></div>
        </div>
    </div>
</div>
@endsection

