@extends('layouts.public')

@section('title', 'Strategic Budget Intelligence')
@section('description', 'Sophisticated AI-powered resource allocation for premium event manifests.')

@section('content')
    <!-- V5 Executive Minimalism Style Deck -->
    <style>
        :root {
            --executive-blue: #0A3A7A;
            --royal-blue: #2563EB;
            --slate-900: #0F172A;
            --glass-surface: rgba(255, 255, 255, 0.9);
        }
        .premium-form-card {
            background: var(--glass-surface);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(15, 23, 42, 0.1);
            box-shadow: 0 10px 30px -10px rgba(10, 58, 122, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .premium-form-card:hover {
            box-shadow: 0 20px 40px -15px rgba(10, 58, 122, 0.15);
        }
        .premium-input {
            border: 1px solid #E2E8F0;
            background: #F8FAFC;
            transition: all 0.3s ease;
            color: var(--slate-900);
            line-height: normal !important;
        }
        .premium-input:focus {
            border-color: var(--royal-blue);
            background: white;
            box-shadow: 0 0 0-4px rgba(37, 99, 235, 0.1);
            outline: none;
        }
        .premium-label {
            display: block;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--executive-blue);
            margin-bottom: 0.75rem;
            margin-left: 0.5rem;
        }
        .event-type-card {
            transition: all 0.4s ease;
        }
        .event-type-card:hover {
            transform: translateY(-4px);
        }
    </style>

    <!-- Executive Intelligence Hero: V5 Precision -->
    <div class="relative min-h-[50vh] flex items-center justify-center overflow-hidden bg-slate-900 pt-32 pb-20 border-b border-slate-200"
         style="background-image: linear-gradient(to bottom, rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.9)), url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&q=80&w=2000'); background-size: cover; background-position: center; background-attachment: fixed;">
        
        <!-- Refined Geometric Overlay -->
        <div class="absolute inset-0 opacity-20 pointer-events-none" 
             style="background-image: radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.2) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(10, 58, 122, 0.2) 0px, transparent 50%);"></div>
        
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-8">
            <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md px-5 py-2 rounded-full border border-white/20 shadow-xl">
                <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                <span class="text-[9px] font-bold text-white uppercase tracking-[0.3em]">Executive Intelligence Engine</span>
            </div>
            
            <div class="space-y-4">
                <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight leading-tight">
                    Strategic Budget <span class="text-blue-400">Planner</span>
                </h1>
                <p class="text-lg md:text-xl text-slate-300 font-medium max-w-2xl mx-auto tracking-tight leading-relaxed">
                    Optimize your resource allocation with precision-engineered manifests. 
                    Professional grade synthesis for high-fidelity event logistics.
                </p>
            </div>

            <div class="flex items-center justify-center gap-6 pt-4">
                <div class="flex -space-x-3">
                    @foreach(['fa-user-tie', 'fa-user-shield', 'fa-user-gear'] as $icon)
                        <div class="w-10 h-10 rounded-full border-2 border-white/20 bg-white/10 backdrop-blur-md flex items-center justify-center shadow-lg">
                            <i class="fa-solid {{ $icon }} text-sm text-blue-100"></i>
                        </div>
                    @endforeach
                </div>
                <div class="h-10 w-px bg-white/20"></div>
                <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest leading-none text-left">
                    Verified Strategic <br> Framework v5.0
                </p>
            </div>
        </div>
    </div>

    <!-- Strategic Package Matrix (Tiers) MOVED UP -->
    <div id="results-section" class="py-32 relative overflow-hidden bg-slate-50 {{ session('synthesis_result') ? '' : 'opacity-40 grayscale' }}">
        @if(!session('synthesis_result'))
        <div class="absolute inset-0 z-30 flex items-center justify-center bg-white/40 backdrop-blur-[4px]">
            <div class="px-12 py-6 bg-[#0A3A7A] text-white rounded-[2rem] font-black text-xs uppercase tracking-[0.5em] shadow-[0_20px_50px_rgba(10,58,122,0.3)] flex items-center gap-6">
                <i class="fa-solid fa-lock text-[#ED1C24] animate-pulse"></i>
                Awaiting Manifest Parameters
            </div>
        </div>
        @endif

        <!-- Background accents -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-[#0A3A7A]/5 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-[#ED1C24]/5 blur-[120px] rounded-full"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-20 space-y-4">
                <h4 class="text-[9px] font-black text-primary-500 uppercase tracking-[0.6em]">System Output Deck</h4>
                <h2 class="text-3xl md:text-5xl font-black text-slate-900 tracking-tight leading-none uppercase">
                    Strategic <span class="text-primary-500">Projections</span>
                </h2>
                <div class="h-1 w-20 bg-primary-500 mx-auto rounded-full"></div>
            </div>

            <div class="grid lg:grid-cols-3 gap-8 items-stretch pt-2">
                @php
                    $synthesis_result = session('synthesis_result') ?? [
                        'economy' => ['total' => '0', 'per_guest' => '0', 'features' => ['Essential Venues', 'Basic Decor'], 'label' => 'Standard Essence'],
                        'premium' => ['total' => '0', 'per_guest' => '0', 'features' => ['Premium Logistics', 'Full Media Strip'], 'label' => 'Elite Fusion'],
                        'luxury' => ['total' => '0', 'per_guest' => '0', 'features' => ['VVIP Access', 'Bespoke Scenography'], 'label' => 'Absolute Authority']
                    ];
                @endphp
                @php
                    $tiers = [
                        'economy' => ['icon' => 'fa-seedling', 'label' => 'Baseline'],
                        'premium' => ['icon' => 'fa-crown', 'label' => 'Strategic Choice'],
                        'luxury' => ['icon' => 'fa-gem', 'label' => 'High Asset']
                    ];
                @endphp

                @foreach($tiers as $key => $style)
                @php $data = $synthesis_result[$key]; @endphp
                <div class="group/tier bg-white rounded-3xl p-10 border border-slate-200 transition-all hover:border-primary-500/30 hover:shadow-2xl hover:-translate-y-2 flex flex-col h-full relative overflow-hidden {{ $key === 'premium' ? 'ring-2 ring-primary-500 shadow-blue-500/10' : 'shadow-sm' }}">
                    
                    @if($key === 'premium')
                        <!-- Subtle Dot Pattern Overlay -->
                        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" 
                             style="background-image: radial-gradient(#2563EB 0.5px, transparent 0.5px); background-size: 10px 10px;"></div>
                        
                        <div class="absolute top-4 right-4 bg-primary-500 text-white text-[8px] font-black uppercase tracking-widest px-3 py-1 rounded-full shadow-lg z-20">
                            Verified Strategic Alpha
                        </div>
                    @endif

                    <div class="flex-grow space-y-10">
                        <!-- Refined Header -->
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 group-hover/tier:bg-slate-900 group-hover/tier:text-white transition-all shadow-sm">
                                <i class="fa-solid {{ $style['icon'] }} text-sm"></i>
                            </div>
                            <div>
                                <h4 class="text-[9px] font-black text-primary-500 uppercase tracking-widest leading-none mb-1">{{ $style['label'] }}</h4>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest opacity-60">System Tier v5.0</span>
                            </div>
                        </div>

                        <!-- Card Identity -->
                        <div class="space-y-2">
                            <h3 class="text-2xl font-black text-slate-900 tracking-tight leading-none uppercase">{{ $data['label'] }}</h3>
                            <div class="h-1 w-8 bg-primary-500 rounded-full"></div>
                        </div>

                        <!-- Pricing Manifest -->
                        <div class="py-8 border-y border-slate-100">
                            <div class="text-center">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Projected Total Valuation</p>
                                <div class="flex flex-col items-center gap-1">
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-[10px] font-black text-slate-300 uppercase">PKR</span>
                                        <span class="text-4xl font-black text-slate-900 tracking-tighter">
                                            {{ number_format(str_replace(',', '', $data['total'])) }}
                                        </span>
                                    </div>
                                    <div class="px-3 py-1 bg-blue-50 rounded-full">
                                        <p class="text-[9px] font-black text-primary-500 tracking-widest uppercase">
                                            {{ number_format(str_replace(',', '', $data['per_guest'])) }} <span class="opacity-50 text-[8px]">/ unit cost</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Strategy Components -->
                        <div class="space-y-4">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Core Capabilities</p>
                            <ul class="grid grid-cols-1 gap-3">
                                @foreach($data['features'] as $feature)
                                <li class="flex items-center gap-3 group/item">
                                    <div class="w-1 h-1 rounded-full bg-slate-200 group-hover/tier:bg-primary-500 transition-colors"></div>
                                    <span class="text-xs font-bold text-slate-600 tracking-tight leading-none">{{ $feature }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Strategic Action -->
                    @if(session('request_id'))
                    <form action="{{ route('budget-planner.acquire', ['budgetRequest' => session('request_id')]) }}" method="POST" class="pt-10 mt-auto">
                        @csrf
                        <input type="hidden" name="tier" value="{{ $key }}">
                        <button type="submit" 
                            class="w-full py-5 rounded-xl font-black text-[10px] uppercase tracking-[0.2em] transition-all shadow-sm flex items-center justify-center gap-3
                            {{ $key === 'premium' 
                                ? 'bg-primary-500 text-white hover:bg-white hover:text-primary-500 hover:ring-2 hover:ring-primary-500' 
                                : 'bg-slate-900 text-white hover:bg-slate-800' }}">
                            <i class="fa-solid fa-file-signature text-[8px]"></i>
                            Acquire Strategy
                        </button>
                    </form>
                    @else
                    <div class="pt-10 mt-auto">
                        <button onclick="document.getElementById('plannerForm').scrollIntoView({behavior: 'smooth'})"
                            class="w-full py-5 rounded-xl font-black text-[10px] uppercase tracking-[0.2em] transition-all bg-slate-50 text-slate-300 border border-slate-100 cursor-not-allowed flex items-center justify-center gap-3">
                            <i class="fa-solid fa-lock text-[8px]"></i>
                            Awaiting Parameters
                        </button>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- AI Budget Planner Matrix -->
    <div class="py-24 relative overflow-hidden bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12 items-start">
                
                <!-- Left Column: Strategic Sidebar (v5) -->
                <div class="lg:col-span-3 space-y-6">
                    <div class="rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                        <!-- Header Section -->
                        <div class="p-8 bg-slate-50 border-b border-slate-200">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center border border-slate-200 mb-4 shadow-sm">
                                <i class="fa-solid fa-shield-halved text-lg text-primary-500"></i>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight leading-none uppercase">Strategic Intelligence</h3>
                            <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase tracking-widest">System Core v5.0.1</p>
                        </div>

                        <!-- Content Section -->
                        <div class="p-8 space-y-6">
                            <div class="space-y-4">
                                <div class="flex items-start gap-4">
                                    <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mt-1.5"></div>
                                    <div class="space-y-1">
                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-900">Resource Optimization</p>
                                        <p class="text-[11px] text-slate-500 leading-relaxed">AI-driven vendor matching based on verified fiscal performance.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="w-1.5 h-1.5 rounded-full bg-slate-300 mt-1.5"></div>
                                    <div class="space-y-1">
                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-900">Tiered Synthesis</p>
                                        <p class="text-[11px] text-slate-500 leading-relaxed">Dynamic partitioning across curated value manifests.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Telemetry Strip (Simplified) -->
                            <div class="pt-6 border-t border-slate-100 mt-4 space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Resource efficiency</span>
                                    <span class="text-[10px] font-black text-primary-500">94.2%</span>
                                </div>
                                <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-primary-500 rounded-full" style="width: 94%"></div>
                                </div>
                                <div class="flex justify-between items-center text-[8px] font-bold text-slate-400 uppercase tracking-widest pt-1">
                                    <span>System v5.1</span>
                                    <span class="flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                        Live Optimization
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Compact Image Accent -->
                    <div class="rounded-3xl overflow-hidden h-40 border border-slate-200 relative group">
                        <img src="https://images.unsplash.com/photo-1543007630-9710e4a00a20?auto=format&fit=crop&w=800&q=80" 
                             class="w-full h-full object-cover grayscale opacity-50 transition-all group-hover:grayscale-0 group-hover:opacity-100" alt="Planning">
                        <div class="absolute inset-0 bg-primary-500/5"></div>
                    </div>
                </div>

                <!-- Right Column: The AI Form Architecture (v5) -->
                <div class="lg:col-span-9 space-y-8">
                    <form action="{{ route('budget-planner.store') }}" method="POST" id="plannerForm" class="space-y-8">
                        @csrf
                        
                        @if(session('success'))
                        <div class="p-6 bg-blue-50 border border-blue-100 rounded-3xl flex items-center gap-6 animate-pulse">
                            <div class="w-12 h-12 bg-primary-500 rounded-2xl flex items-center justify-center shadow-lg">
                                <i class="fa-solid fa-satellite-dish text-white"></i>
                            </div>
                            <div class="space-y-1">
                                <h4 class="text-[10px] font-black text-primary-500 uppercase tracking-widest">Synthesis Complete</h4>
                                <p class="text-sm font-bold text-slate-900 leading-tight">{{ session('success') }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Phase 01: Event Architecture -->
                        <div class="premium-form-card rounded-3xl p-8 md:p-12 relative overflow-hidden group">
                            <div class="relative z-10 space-y-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white text-xs font-black shadow-lg">01</div>
                                    <div class="grow">
                                        <h4 class="text-[10px] font-black text-primary-500 uppercase tracking-[0.4em]">Event Parameters</h4>
                                        <div class="h-px bg-slate-100 mt-2 w-full"></div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach([
                                        ['id' => 'wedding', 'label' => 'Wedding', 'icon' => 'fa-church', 'img' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=400&q=80'],
                                        ['id' => 'corporate', 'label' => 'Corporate', 'icon' => 'fa-briefcase', 'img' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=400&q=80'],
                                        ['id' => 'birthday', 'label' => 'Birthday', 'icon' => 'fa-cake-candles', 'img' => 'https://images.unsplash.com/photo-1464349095431-e9a21285b5f3?auto=format&fit=crop&w=400&q=80'],
                                        ['id' => 'tour', 'label' => 'Tour', 'icon' => 'fa-plane', 'img' => 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=400&q=80'],
                                        ['id' => 'destination', 'label' => 'Global', 'icon' => 'fa-earth-americas', 'img' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=400&q=80'],
                                        ['id' => 'other', 'label' => 'Custom', 'icon' => 'fa-sliders', 'img' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=400&q=80'],
                                    ] as $event)
                                    <label class="group relative cursor-pointer block h-32 rounded-2xl overflow-hidden event-type-card border border-slate-200 hover:border-primary-500 transition-all">
                                        <input type="radio" name="service_type" value="{{ $event['id'] }}" 
                                               class="hidden peer" 
                                               {{ request('service') == $event['id'] ? 'checked' : '' }}
                                               required>
                                        
                                        <div class="absolute inset-0 transition-transform duration-700 group-hover:scale-105 bg-cover bg-center grayscale opacity-60 peer-checked:grayscale-0 peer-checked:opacity-100"
                                                style="background-image: url('{{ $event['img'] }}')"></div>
                                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent opacity-80 peer-checked:from-blue-900/90"></div>
                                        
                                        <div class="relative h-full flex flex-col justify-end p-4 text-white z-10">
                                            <i class="fa-solid {{ $event['icon'] }} text-sm mb-1 opacity-70 group-hover:opacity-100"></i>
                                            <span class="font-black text-[10px] uppercase tracking-wider">{{ $event['label'] }}</span>
                                        </div>
                                        
                                        <div class="absolute top-3 right-3 opacity-0 peer-checked:opacity-100 transition-all transform scale-50 peer-checked:scale-100 z-20">
                                            <div class="w-6 h-6 bg-primary-500 rounded-full flex items-center justify-center text-white text-[10px] shadow-lg">
                                                <i class="fa-solid fa-check"></i>
                                            </div>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Phase 02: Logistics Framework -->
                        <div class="premium-form-card rounded-3xl p-8 md:p-12 relative overflow-hidden group">
                            <div class="relative z-10 space-y-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white text-xs font-black shadow-lg">02</div>
                                    <div class="grow">
                                        <h4 class="text-[10px] font-black text-primary-500 uppercase tracking-[0.4em]">Logistics Framework</h4>
                                        <div class="h-px bg-slate-100 mt-2 w-full"></div>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 gap-8">
                                    <div class="relative group/field">
                                        <label class="premium-label">Operational Hub</label>
                                        <div class="relative">
                                            <select name="location" class="w-full px-5 py-4 rounded-xl premium-input font-bold appearance-none cursor-pointer text-sm" required>
                                                <option value="">Select Location</option>
                                                @foreach(['Pakistan', 'UAE', 'Turkey', 'Thailand', 'Maldives', 'UK', 'USA'] as $loc)
                                                    <option value="{{ $loc }}">{{ $loc }}</option>
                                                @endforeach
                                            </select>
                                            <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-[8px]"></i>
                                        </div>
                                    </div>
                                    <div class="relative group/field">
                                        <label class="premium-label">Personnel Count</label>
                                        <input type="number" name="guests" required
                                            class="w-full px-5 py-4 rounded-xl premium-input font-bold placeholder-slate-400 text-sm"
                                            placeholder="Total Guests">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Phase 03: Budgetary Control -->
                        <div class="premium-form-card rounded-3xl p-8 md:p-12 relative overflow-hidden">
                            <div class="relative z-10 space-y-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white text-xs font-black shadow-lg">03</div>
                                    <div class="grow">
                                        <h4 class="text-[10px] font-black text-primary-500 uppercase tracking-[0.4em]">Fiscal Ceiling</h4>
                                        <div class="h-px bg-slate-100 mt-2 w-full"></div>
                                    </div>
                                </div>

                                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200 relative">
                                    <div class="space-y-6">
                                        <label class="block text-center text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Maximum Resource Allocation (PKR)</label>
                                        <div class="relative max-w-md mx-auto">
                                            <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 font-black text-xl">Rs.</span>
                                            <input type="number" name="budget" required
                                                value="{{ request('budget') }}"
                                                class="w-full bg-white border border-slate-200 px-16 py-6 rounded-xl font-black text-3xl md:text-4xl text-center text-slate-900 focus:border-primary-500 transition-all outline-none"
                                                placeholder="5,000,000">
                                        </div>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em] text-center ">Calculated partitioning across competitive manifests.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Phase 04: System Components -->
                        <div class="premium-form-card rounded-3xl p-8 md:p-12 relative overflow-hidden">
                            <div class="relative z-10 space-y-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white text-xs font-black shadow-lg">04</div>
                                    <div class="grow">
                                        <h4 class="text-[10px] font-black text-primary-500 uppercase tracking-[0.4em]">Resource Modules</h4>
                                        <div class="h-px bg-slate-100 mt-2 w-full"></div>
                                    </div>
                                </div>

                                <div class="flex flex-wrap justify-center gap-4">
                                    @foreach([
                                        'venue' => 'fa-building-columns', 'catering' => 'fa-utensils', 'decor' => 'fa-wand-magic-sparkles', 
                                        'photography' => 'fa-camera-retro', 'transport' => 'fa-car-side', 
                                        'hotel' => 'fa-bed', 'flights' => 'fa-plane-up', 'entertainment' => 'fa-masks-theater'
                                    ] as $val => $icon)
                                    <label class="group cursor-pointer">
                                        <input type="checkbox" name="services_needed[]" value="{{ $val }}" class="hidden peer">
                                        <div class="px-6 py-4 rounded-xl border border-slate-200 bg-white peer-checked:border-primary-500 peer-checked:bg-primary-500 peer-checked:text-white font-bold text-[10px] uppercase tracking-wider transition-all hover:bg-slate-50 flex items-center gap-3 shadow-sm">
                                            <i class="fa-solid {{ $icon }} text-xs opacity-60 group-hover:opacity-100"></i>
                                            {{ ucfirst($val) }}
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Final Process Action -->
                        <div class="pt-6">
                            <button type="submit" 
                                class="w-full group bg-primary-500 text-white py-6 rounded-2xl font-black text-lg uppercase tracking-widest transition-all hover:bg-blue-700 active:scale-[0.98] shadow-lg shadow-blue-500/20">
                                <span class="flex items-center justify-center gap-6">
                                    Generate Strategy Manifest
                                    <i class="fa-solid fa-chevron-right text-sm group-hover:translate-x-1 transition-transform"></i>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(session('synthesis_result'))
    <script>
        window.addEventListener('load', function() {
            const resultsSection = document.getElementById('results-section');
            if (resultsSection) {
                resultsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    </script>
    @endif

    <!-- Executive Fulfillment CTA (v5) -->
    <div class="py-24 bg-slate-50 border-t border-slate-200 relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-12">
            <div class="space-y-4">
                <h2 class="text-3xl md:text-5xl font-black text-slate-900 tracking-tight leading-none uppercase">
                    Ready for <span class="text-primary-500">Fulfillment?</span>
                </h2>
                <p class="text-lg text-slate-600 font-medium max-w-2xl mx-auto tracking-tight leading-relaxed">
                    Your bespoke strategic manifest is ready. Connect with our logistics command center for tailored execution.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-8 pt-8">
                <a href="{{ route('contact') }}" class="group bg-primary-500 text-white px-10 py-5 rounded-2xl font-black text-xs uppercase tracking-widest transition-all hover:bg-blue-700 shadow-xl shadow-blue-500/20 flex items-center gap-4">
                    <i class="fa-solid fa-headset text-sm group-hover:animate-bounce"></i>
                    Logistics Command
                </a>
                
                <div class="flex items-center gap-6 px-8 py-4 bg-white rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex -space-x-3">
                        @foreach([1,2,3] as $i)
                            <div class="w-10 h-10 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center shadow-sm">
                                <i class="fa-solid fa-user-tie text-xs text-slate-400"></i>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-left">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Available Now</p>
                        <p class="text-[10px] font-black text-primary-500 uppercase tracking-widest">Support Team Active</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

