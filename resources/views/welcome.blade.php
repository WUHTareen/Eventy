@extends('layouts.public')

@section('title', 'Events, Travel & Hospitality')
@section('description', 'Pakistan\'s First Hybrid Model Platform for Events, Travel & Hospitality. Book weddings, corporate events, tours, hotels, flights & more.')

@push('styles')
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #0A3A7A 0%, #082b5c 30%, #ED1C24 60%, #b2151b 100%);
        }
        .gradient-text {
            background: linear-gradient(135deg, #0A3A7A, #ED1C24, #0A3A7A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .service-card:hover { transform: translateY(-8px) scale(1.02); }
        .pulse-glow { animation: pulseGlow 2s ease-in-out infinite; }
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(168, 85, 247, 0.4); }
            50% { box-shadow: 0 0 40px rgba(168, 85, 247, 0.7); }
        }
        .marquee-container { mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent); }
        .marquee-content { animation: scroll 40s linear infinite; }
        @keyframes scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        .clip-text-image { background-clip: text; -webkit-background-clip: text; color: transparent; background-image: linear-gradient(to right, #0A3A7A, #ED1C24, #0A3A7A); }
        
        /* Swiper Custom Styles */
        .swiper-button-next, .swiper-button-prev {
            background-color: white;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            color: #ED1C24;
        }
        .swiper-button-next:after, .swiper-button-prev:after {
            font-size: 18px;
            font-weight: bold;
        }
        .swiper-pagination-bullet-active {
            background: #ED1C24;
        }

        /* Premium Card Styles */
        .premium-card {
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            overflow: hidden;
        }
        .premium-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
        }
        .shine-effect::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(
                to right,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent
            );
            transform: skewX(-25deg);
            transition: 0.7s;
            z-index: 5;
        }
        .premium-card:hover .shine-effect::before {
            left: 150%;
        }
        .glass-tag {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px border rgba(255, 255, 255, 0.2);
        }
        .text-gradient-premium {
            background: linear-gradient(to right, #1e293b, #334155, #1e293b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        @keyframes subtle-pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }
        .animate-subtle-pulse {
            animation: subtle-pulse 3s infinite ease-in-out;
        }
        .font-friendly { font-family: 'Plus Jakarta Sans', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_red.css">
    <style>
        .flatpickr-calendar {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border: 1px solid #f1f5f9;
        }
        .flatpickr-day.selected {
            background: #ED1C24 !important;
            border-color: #ED1C24 !important;
        }

        /* Flight Specific Calendar Styling */
        #flight-calendar-container .flatpickr-calendar {
            box-shadow: none !important;
            border: none !important;
            background: transparent !important;
            width: 100% !important;
            max-width: 320px !important;
        }
        #flight-calendar-container .flatpickr-months {
            margin-bottom: 20px;
        }
        #flight-calendar-container .flatpickr-month {
            height: 40px;
        }
        #flight-calendar-container .flatpickr-current-month {
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #0A192F;
        }
        #flight-calendar-container .flatpickr-weekday {
            font-size: 10px;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
        }
        #flight-calendar-container .dayContainer {
            min-width: unset !important;
            width: 100% !important;
        }
        #flight-calendar-container .flatpickr-day {
            font-size: 12px;
            font-weight: 700;
            color: #0A192F;
            border-radius: 12px;
            height: 38px;
            line-height: 38px;
            margin: 2px;
        }
        #flight-calendar-container .flatpickr-day.inRange {
            background: rgba(237, 28, 36, 0.05) !important;
            box-shadow: none !important;
        }
        #flight-calendar-container .flatpickr-day.selected, 
        #flight-calendar-container .flatpickr-day.startRange, 
        #flight-calendar-container .flatpickr-day.endRange {
            background: #ED1C24 !important;
            color: white !important;
            box-shadow: 0 10px 20px -5px rgba(237, 28, 36, 0.45) !important;
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section (Elite Enterprise Redesign) -->
    <div class="relative pt-16 md:pt-24 pb-80 md:pb-44 bg-[#0A192F] cursor-default" id="hero-container">
        <!-- Strategic Background Architecture -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Neural Patterns -->
            <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 60px 60px;"></div>
            
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-600/10 rounded-full blur-[120px] translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-[#ED1C24]/10 rounded-full blur-[120px] -translate-x-1/2 translate-y-1/2"></div>
            
            <img src="{{ !empty($hp['hp_hero_image']) ? asset('storage/' . $hp['hp_hero_image']) : 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?q=80&w=2074&auto=format&fit=crop' }}"
                 alt="Strategic Orchestration"
                 class="absolute inset-0 w-full h-full object-cover opacity-10 filter grayscale contrast-125">
            <div class="absolute inset-0 bg-gradient-to-b from-[#0A192F]/50 via-[#0A192F]/80 to-[#0A192F]"></div>
        </div>

        <div class="relative z-30 max-w-[1400px] mx-auto px-4 md:px-6 text-center">
            <div class="inline-flex items-center gap-3 bg-white/5 backdrop-blur-2xl px-4 py-1.5 rounded-full border border-white/10 mb-8 transform hover:scale-105 transition-all cursor-default group">
                <span class="w-1.5 h-1.5 rounded-full bg-[#ED1C24] group-hover:animate-ping"></span>
                <span class="text-[9px] md:text-[10px] font-bold text-white uppercase tracking-[0.2em] font-friendly">{{ $hp['hp_hero_badge'] ?? 'Your Trusted Event Partner' }}</span>
            </div>

            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-[54px] font-black text-white tracking-tight uppercase leading-[1.1] mb-6 font-friendly px-4">
                {{ $hp['hp_hero_title_1'] ?? 'Plan, Book & Manage' }} <br class="hidden md:block"/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#ED1C24] via-white to-blue-400">{{ $hp['hp_hero_title_2'] ?? 'Events, Travel & Hospitality' }}</span>
                <br class="hidden md:block"/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-white">{{ $hp['hp_hero_title_3'] ?? '— Worldwide' }}</span>
            </h1>

            <p class="text-blue-100/70 text-sm md:text-lg font-medium leading-relaxed max-w-2xl mx-auto mb-8 md:mb-12 font-friendly">
                {{ $hp['hp_hero_subtitle'] ?? 'From Weddings to Corporate Conferences, From Hotels to Visa & Transport — All in One Platform' }}
            </p>

                        <!-- Audience Selection (Portals) -->
            <div class="max-w-[620px] mx-auto mb-6 md:mb-8">
                <div class="grid grid-cols-3 gap-3">

                    <!-- Individual Portal -->
                    <a href="{{ route('register') }}" 
                       class="group flex flex-col items-center justify-center gap-2 px-4 py-3 bg-[#1a1a2e]/80 backdrop-blur-xl border border-white/8 rounded-[1rem] hover:bg-[#1e1e35] hover:border-white/15 transition-all duration-300 hover:-translate-y-1 decoration-0 text-center">
                        <div class="text-[#7c6af5] group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-user-tie text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-[11px] md:text-[10px] font-black text-white uppercase tracking-widest font-friendly mb-0.5">Individual</h3>
                            <p class="text-[8px] md:text-[7px] font-bold text-white/30 uppercase tracking-[0.2em] font-friendly">B2C Personal</p>
                        </div>
                    </a>

                    <!-- Corporate Portal -->
                    <a href="{{ route('corporate.register') }}" 
                       class="group flex flex-col items-center justify-center gap-2 px-4 py-3 bg-[#1a1a2e]/80 backdrop-blur-xl border border-white/8 rounded-[1rem] hover:bg-[#1e1e35] hover:border-white/15 transition-all duration-300 hover:-translate-y-1 decoration-0 text-center">
                        <div class="text-[#ED1C24] group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-city text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-[11px] md:text-[10px] font-black text-white uppercase tracking-widest font-friendly mb-0.5">Corporate</h3>
                            <p class="text-[8px] md:text-[7px] font-bold text-white/30 uppercase tracking-[0.2em] font-friendly">Enterprise</p>
                        </div>
                    </a>

                    <!-- Vendor Portal -->
                    <a href="{{ route('vendor.register') }}" 
                       class="group flex flex-col items-center justify-center gap-2 px-4 py-3 bg-[#1a1a2e]/80 backdrop-blur-xl border border-white/8 rounded-[1rem] hover:bg-[#1e1e35] hover:border-white/15 transition-all duration-300 hover:-translate-y-1 decoration-0 text-center">
                        <div class="text-emerald-400 group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid fa-handshake text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-[11px] md:text-[10px] font-black text-white uppercase tracking-widest font-friendly mb-0.5">Vendor</h3>
                            <p class="text-[8px] md:text-[7px] font-bold text-white/30 uppercase tracking-[0.2em] font-friendly">Partner Port</p>
                        </div>
                    </a>

                </div>
            </div>

<!-- Search Section -->
            <div x-data="{ activeTab: 'events-management' }" class="max-w-6xl mx-auto relative z-50">
                <form :action="activeTab === 'conferences-summits' ? '{{ route('corporate.dashboard') }}' : '{{ route('services') }}'" method="GET" id="main-search-form" x-data="{ instantBooking: false }">
                    <input type="hidden" name="from_hero" value="1">
                    <input type="hidden" name="category" :value="activeTab">
                    <input type="hidden" name="instant_booking" :value="instantBooking ? 1 : 0">

                <!-- Search Tabs -->
                <div class="flex md:flex-wrap justify-start md:justify-center gap-2 p-1.5 bg-black/20 backdrop-blur-3xl rounded-[2rem] border border-white/5 mb-4 md:mb-6 overflow-x-auto no-scrollbar scroll-smooth">
                    @php
                        $searchTabs = [
                            ['id' => 'events-management',   'label' => 'Events',             'icon' => 'fa-calendar-check'],
                            ['id' => 'venues-coordination', 'label' => 'Hotels',             'icon' => 'fa-hotel'],
                            ['id' => 'travel-hospitality',  'label' => 'Travel Packages',    'icon' => 'fa-suitcase-rolling'],
                            ['id' => 'catering-food',       'label' => 'Catering',           'icon' => 'fa-utensils'],
                            ['id' => 'flights-ticketing',   'label' => 'Visa Services',      'icon' => 'fa-passport'],
                            ['id' => 'transport-logistics', 'label' => 'Transportation',     'icon' => 'fa-car-side'],
                            ['id' => 'conferences-summits', 'label' => 'Corporate Solutions','icon' => 'fa-briefcase'],
                        ];
                    @endphp
                    @foreach($searchTabs as $tab)
                    <button type="button" @click="activeTab = '{{ $tab['id'] }}'" 
                            :class="activeTab === '{{ $tab['id'] }}' ? 'bg-white text-black shadow-lg scale-105' : 'text-white/60 hover:text-white hover:bg-white/5 bg-transparent'"
                            class="flex-shrink-0 px-4 py-2 md:px-5 md:py-2.5 rounded-full text-[11px] md:text-[10px] font-bold uppercase tracking-wider transition-all duration-500 flex items-center gap-2 font-friendly">
                        <i class="fa-solid {{ $tab['icon'] }} text-[14px] md:text-[12px]" :class="activeTab === '{{ $tab['id'] }}' ? 'text-[#ED1C24]' : ''"></i>
                        <span class="whitespace-nowrap">{{ $tab['label'] }}</span>
                    </button>
                    @endforeach
                </div>

                <!-- Search Fields -->
                <div class="bg-white rounded-[2rem] shadow-[0_30px_80px_-30px_rgba(0,0,0,0.5)] p-2 border border-slate-100 flex flex-col md:flex-row items-center gap-1.5 relative z-20">
                    
                    <div class="flex-1 w-full">
                        <!-- Events -->
                        <div x-show="activeTab === 'events-management'" class="grid grid-cols-1 md:grid-cols-4 w-full h-full">
                            <div class="p-5 hover:bg-slate-50/80 transition-all rounded-[1.8rem] group/field relative border border-transparent hover:border-slate-100">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 font-friendly">Event Type</label>
                                <div class="relative flex items-center">
                                    <i class="fa-solid fa-star text-[15px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                    <select name="event_type" :disabled="activeTab !== 'events-management'" class="w-full bg-transparent border-0 pl-7 pr-2 py-1 text-sm md:text-[15px] font-bold text-[#0A192F] focus:ring-0 cursor-pointer font-friendly">
                                        <option value="">What kind of event?</option>
                                        <option value="wedding">Wedding</option>
                                        <option value="corporate">Corporate Event</option>
                                        <option value="birthday">Birthday Party</option>
                                        <option value="expo">Exhibition</option>
                                    </select>
                                </div>
                                <div class="hidden md:block absolute right-0 top-1/4 bottom-1/4 w-[1px] bg-slate-100"></div>
                            </div>

                            <div class="p-5 hover:bg-slate-50/80 transition-all rounded-[1.8rem] group/field relative border border-transparent hover:border-slate-100">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 font-friendly">Location</label>
                                <div class="relative flex items-center">
                                    <i class="fa-solid fa-location-dot text-[15px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                    <select name="city" :disabled="activeTab !== 'events-management'" class="w-full bg-transparent border-0 pl-7 pr-2 py-1 text-sm md:text-[15px] font-bold text-[#0A192F] focus:ring-0 cursor-pointer font-friendly">
                                        <option value="">Which city?</option>
                                        @foreach($cities as $c)
                                            <option value="{{ $c->name }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="hidden md:block absolute right-0 top-1/4 bottom-1/4 w-[1px] bg-slate-100"></div>
                            </div>

                            <div class="p-5 hover:bg-slate-50/80 transition-all rounded-[1.8rem] group/field relative border border-transparent hover:border-slate-100">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 font-friendly">Date</label>
                                <div class="relative flex items-center">
                                    <i class="fa-solid fa-calendar text-[15px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                    <input type="text" name="date" :disabled="activeTab !== 'events-management'" id="event-datepicker" placeholder="When is it?" class="w-full bg-transparent border-0 pl-7 py-1 text-sm md:text-[15px] font-bold text-[#0A192F] focus:ring-0 cursor-pointer font-friendly">
                                </div>
                                <div class="hidden md:block absolute right-0 top-1/4 bottom-1/4 w-[1px] bg-slate-100"></div>
                            </div>

                            <div class="p-5 hover:bg-slate-50/80 transition-all rounded-[1.8rem] group/field border border-transparent hover:border-slate-100 relative"
                                 x-data="{ 
                                    open: false, 
                                    guestValue: '{{ request('guests', '') }}',
                                    customMode: false,
                                    ranges: [
                                        { label: 'Boutique (1-50)', val: '50' },
                                        { label: 'Small (50-150)', val: '150' },
                                        { label: 'Medium (150-300)', val: '300' },
                                        { label: 'Large (300-500)', val: '500' },
                                        { label: 'Grand (500-1000)', val: '1000' },
                                        { label: 'Mega (1000+)', val: '2000' }
                                    ],
                                    selectRange(val) {
                                        this.guestValue = val;
                                        this.open = false;
                                        this.customMode = false;
                                    }
                                 }">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 font-friendly">Guests</label>
                                <div class="relative flex items-center cursor-pointer" @click="open = !open">
                                    <i class="fa-solid fa-users text-[15px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                    <input type="text" name="guests" x-model="guestValue" 
                                           :readonly="!customMode"
                                           @click.stop="if(!customMode) open = !open"
                                           :placeholder="customMode ? 'Enter count...' : 'How many guests?'" 
                                           class="w-full bg-transparent border-0 pl-7 py-1 text-sm md:text-[15px] font-bold text-[#0A192F] focus:ring-0 placeholder-slate-300 font-friendly cursor-pointer"
                                           :disabled="activeTab !== 'events-management'">
                                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 absolute right-0 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                                </div>

                                <!-- Guest Range Dropdown -->
                                <div x-show="open" 
                                     @click.outside="open = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                     class="absolute top-full right-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl border border-slate-100 z-[100] p-2 overflow-hidden">
                                     <div class="max-h-64 overflow-y-auto custom-scrollbar">
                                         <template x-for="range in ranges" :key="range.val">
                                             <button type="button" @click="selectRange(range.val)" 
                                                     class="w-full text-left px-4 py-3 text-[11px] font-bold text-[#0A192F] hover:bg-slate-50 rounded-xl transition-all flex justify-between items-center group">
                                                 <span x-text="range.label"></span>
                                                 <i class="fa-solid fa-plus text-[8px] text-[#ED1C24] opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                             </button>
                                         </template>
                                     </div>
                                     <div class="border-t border-slate-50 mt-1 pt-1">
                                         <button type="button" @click="customMode = true; open = false; $nextTick(() => { $el.closest('.group/field').querySelector('input').focus(); $el.closest('.group/field').querySelector('input').select(); })" 
                                                 class="w-full text-left px-4 py-3 text-[11px] font-black text-[#ED1C24] uppercase tracking-widest hover:bg-red-50 rounded-xl transition-all">
                                             Manual Entry...
                                         </button>
                                     </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hotels -->
                        <div x-show="activeTab === 'venues-coordination'" style="display:none" class="flex flex-col md:flex-row w-full h-full items-stretch">
                            <div class="flex-[0.7] min-w-0 p-5 hover:bg-slate-50/80 transition-all rounded-[1.8rem] group/field relative border border-transparent hover:border-slate-100">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 font-friendly">City</label>
                                <div class="relative flex items-center">
                                    <i class="fa-solid fa-hotel text-[15px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                    <select name="city" :disabled="activeTab !== 'venues-coordination'" class="w-full bg-transparent border-0 pl-7 pr-2 py-1 text-sm md:text-[15px] font-bold text-[#0A192F] focus:ring-0 cursor-pointer font-friendly">
                                        <option value="">Where to stay?</option>
                                        @foreach($cities as $c)
                                            <option value="{{ $c->name }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="hidden md:block absolute right-0 top-1/4 bottom-1/4 w-[1px] bg-slate-100"></div>
                            </div>

                            <div class="flex-shrink-0 w-auto p-5 hover:bg-slate-50/80 transition-all rounded-[1.8rem] group/field relative border border-transparent hover:border-slate-100">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 font-friendly">Select Dates</label>
                                <div class="relative flex items-center">
                                    <i class="fa-solid fa-calendar-days text-[15px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                    <input type="text" name="dates" :disabled="activeTab !== 'venues-coordination'" id="hotel-datepicker" placeholder="Check-in — Check-out" class="bg-transparent border-0 pl-7 py-1 text-sm md:text-[15px] font-bold text-[#0A192F] focus:ring-0 cursor-pointer font-friendly" style="width:230px;">
                                </div>
                                <div class="hidden md:block absolute right-0 top-1/4 bottom-1/4 w-[1px] bg-slate-100"></div>
                            </div>

                            <div class="p-5 hover:bg-slate-50/80 transition-all rounded-[1.8rem] group/field border border-transparent hover:border-slate-100 relative" 
                                 x-data="{ 
                                    open: false, 
                                    adults: 1, 
                                    children: 0, 
                                    rooms: 1,
                                    triggerRect: null,
                                    get summary() {
                                        return this.adults + ' Adults · ' + this.children + ' Children · ' + this.rooms + ' Room' + (this.rooms > 1 ? 's' : '');
                                    },
                                    toggle(el) {
                                        this.open = !this.open;
                                        if (this.open) {
                                            this.triggerRect = el.getBoundingClientRect();
                                        }
                                    },
                                    updatePos(el) {
                                        if (this.open) {
                                            this.triggerRect = el.getBoundingClientRect();
                                        }
                                    },
                                    close() { this.open = false; }
                                 }"
                                 @click.outside="close()"
                                 @scroll.window="updatePos($el)"
                                 @resize.window="updatePos($el)">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 font-friendly">Guests & Rooms</label>
                                <div class="relative flex items-center cursor-pointer" @click="toggle($el)">
                                    <i class="fa-solid fa-user-group text-[15px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                    <div class="w-full bg-transparent pl-7 py-1 text-sm md:text-[15px] font-bold text-[#0A192F] font-friendly truncate" x-text="summary"></div>
                                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 absolute right-0 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                                    <!-- Hidden Inputs for Form Submission -->
                                    <input type="hidden" name="adults" :value="adults" :disabled="activeTab !== 'venues-coordination'">
                                    <input type="hidden" name="children" :value="children" :disabled="activeTab !== 'venues-coordination'">
                                    <input type="hidden" name="rooms" :value="rooms" :disabled="activeTab !== 'venues-coordination'">
                                    <input type="hidden" name="travelers" :value="adults + children" :disabled="activeTab !== 'venues-coordination'">
                                </div>

                                    <div x-show="open"
                                         x-transition:enter="transition ease-out duration-150"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-100"
                                         x-transition:leave-start="opacity-100 scale-100"
                                         x-transition:leave-end="opacity-0 scale-95"
                                         :style="triggerRect ? 'position:absolute;z-index:100;top:100%;right:0;width:300px;' : 'display:none;'"
                                         class="bg-white rounded-2xl shadow-2xl border border-slate-100 p-6 mt-2"
                                         @click.stop>
                                         
                                         <!-- Adults -->
                                         <div class="flex justify-between items-center mb-5">
                                             <div>
                                                 <span class="block text-sm font-bold text-[#0A192F]">Adults</span>
                                                 <span class="text-[10px] text-slate-400">Ages 18+</span>
                                             </div>
                                             <div class="flex items-center gap-3">
                                                 <button type="button" @click.stop="if(adults > 1) adults--" class="w-9 h-9 rounded-full border border-slate-200 flex items-center justify-center text-slate-600 hover:border-[#ED1C24] hover:text-[#ED1C24] transition-colors text-base font-light">−</button>
                                                 <span class="w-8 text-center font-bold text-[#0A192F] text-lg" x-text="adults"></span>
                                                 <button type="button" @click.stop="adults++" class="w-9 h-9 rounded-full border border-slate-200 flex items-center justify-center text-slate-600 hover:border-[#ED1C24] hover:text-[#ED1C24] transition-colors text-base font-light">+</button>
                                             </div>
                                         </div>
 
                                         <!-- Children -->
                                         <div class="flex justify-between items-center mb-5">
                                             <div>
                                                 <span class="block text-sm font-bold text-[#0A192F]">Children</span>
                                                 <span class="text-[10px] text-slate-400">Ages 0–17</span>
                                             </div>
                                             <div class="flex items-center gap-3">
                                                 <button type="button" @click.stop="if(children > 0) children--" class="w-9 h-9 rounded-full border border-slate-200 flex items-center justify-center text-slate-600 hover:border-[#ED1C24] hover:text-[#ED1C24] transition-colors text-base font-light">−</button>
                                                 <span class="w-8 text-center font-bold text-[#0A192F] text-lg" x-text="children"></span>
                                                 <button type="button" @click.stop="children++" class="w-9 h-9 rounded-full border border-slate-200 flex items-center justify-center text-slate-600 hover:border-[#ED1C24] hover:text-[#ED1C24] transition-colors text-base font-light">+</button>
                                             </div>
                                         </div>
 
                                         <!-- Rooms -->
                                         <div class="flex justify-between items-center pb-5 border-b border-slate-100">
                                             <div>
                                                 <span class="block text-sm font-bold text-[#0A192F]">Rooms</span>
                                                 <span class="text-[10px] text-slate-400">Required</span>
                                             </div>
                                             <div class="flex items-center gap-3">
                                                 <button type="button" @click.stop="if(rooms > 1) rooms--" class="w-9 h-9 rounded-full border border-slate-200 flex items-center justify-center text-slate-600 hover:border-[#ED1C24] hover:text-[#ED1C24] transition-colors text-base font-light">−</button>
                                                 <span class="w-8 text-center font-bold text-[#0A192F] text-lg" x-text="rooms"></span>
                                                 <button type="button" @click.stop="rooms++" class="w-9 h-9 rounded-full border border-slate-200 flex items-center justify-center text-slate-600 hover:border-[#ED1C24] hover:text-[#ED1C24] transition-colors text-base font-light">+</button>
                                             </div>
                                         </div>
                                         
                                         <div class="mt-4 flex justify-end">
                                             <button type="button" @click.stop="close()" class="px-6 py-2.5 bg-[#ED1C24] text-white rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-[#0A192F] transition-colors">Done</button>
                                         </div>
                                     </div>
                            </div>
                        </div>

                        <!-- Transportation Search (Streamlined) -->
                        <div x-show="activeTab === 'transport-logistics'" x-data="{ dropDifferent: false, transportType: 'self' }" x-cloak style="display:none" class="w-full flex flex-col">
                            <!-- Transportation Options Header -->
                            <div class="flex flex-wrap items-center gap-6 px-8 py-3 border-b border-slate-50">
                                <!-- Transport Mode -->
                                <div class="flex items-center gap-2 p-1 bg-slate-50/50 rounded-xl border border-slate-100">
                                    <button type="button" @click="transportType = 'self'" 
                                            :class="transportType === 'self' ? 'bg-[#ED1C24] text-white shadow-md' : 'text-slate-400 hover:text-[#0A192F]'"
                                            class="px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all">
                                        <i class="fa-solid fa-steering-wheel mr-1"></i> Self Drive
                                    </button>
                                    <button type="button" @click="transportType = 'driver'" 
                                            :class="transportType === 'driver' ? 'bg-[#ED1C24] text-white shadow-md' : 'text-slate-400 hover:text-[#0A192F]'"
                                            class="px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all">
                                        <i class="fa-solid fa-user-tie mr-1"></i> With Driver
                                    </button>
                                    <input type="hidden" name="transport_mode" :value="transportType">
                                </div>

                                <div class="w-px h-4 bg-slate-100 hidden md:block"></div>

                                <!-- Return Toggle -->
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <div class="relative inline-flex items-center">
                                        <input type="checkbox" x-model="dropDifferent" class="sr-only peer">
                                        <div class="w-8 h-4 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-[#ED1C24]"></div>
                                    </div>
                                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 group-hover:text-[#0A192F] transition-colors" :class="dropDifferent ? 'text-[#0A192F]' : ''">Return at different location</span>
                                </label>
                            </div>

                            <div class="grid grid-cols-1 w-full h-full" :class="dropDifferent ? 'md:grid-cols-4' : 'md:grid-cols-3'">

                                <!-- Pick-up Location -->
                                <div class="p-5 hover:bg-slate-50/80 transition-all rounded-[1.8rem] group/field relative border border-transparent hover:border-slate-100">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 font-friendly">Pick-up Location</label>
                                    <div class="relative flex items-center">
                                        <i class="fa-solid fa-location-dot text-[15px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                        <select name="city" :disabled="activeTab !== 'transport-logistics'" class="w-full bg-transparent border-0 pl-7 pr-2 py-1 text-sm md:text-[15px] font-bold text-[#0A192F] focus:ring-0 cursor-pointer font-friendly">
                                            <option value="">Which city?</option>
                                            @foreach($cities as $c)
                                                <option value="{{ $c->name }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="hidden md:block absolute right-0 top-1/4 bottom-1/4 w-[1px] bg-slate-100"></div>
                                </div>

                                <!-- Drop-off Location (Conditional) -->
                                <div x-show="dropDifferent" 
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-x-4"
                                     x-transition:enter-end="opacity-100 translate-x-0"
                                     class="p-5 hover:bg-slate-50/80 transition-all rounded-[1.8rem] group/field relative border border-transparent hover:border-slate-100">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 font-friendly">Drop-off Location</label>
                                    <div class="relative flex items-center">
                                        <i class="fa-solid fa-location-arrow text-[15px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                        <select name="dropoff_city" :disabled="!dropDifferent" class="w-full bg-transparent border-0 pl-7 pr-2 py-1 text-sm md:text-[15px] font-bold text-[#0A192F] focus:ring-0 cursor-pointer font-friendly">
                                            <option value="">Return City</option>
                                            @foreach($cities as $c)
                                                <option value="{{ $c->name }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="hidden md:block absolute right-0 top-1/4 bottom-1/4 w-[1px] bg-slate-100"></div>
                                </div>

                                <!-- Pick-up Date & Time -->
                                <div class="p-5 hover:bg-slate-50/80 transition-all rounded-[2rem] group/field relative border border-transparent hover:border-slate-100 flex flex-col justify-center">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 font-friendly">Pick-up Date & Time</label>
                                    <div class="relative flex items-center">
                                        <i class="fa-solid fa-calendar-plus text-[15px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                        <input type="datetime-local" name="pickup_datetime" :disabled="activeTab !== 'transport-logistics'" class="w-full bg-transparent border-0 pl-7 py-1 text-sm md:text-[14px] font-bold text-[#0A192F] focus:ring-0 cursor-pointer font-friendly">
                                    </div>
                                    <div class="hidden md:block absolute right-0 top-1/4 bottom-1/4 w-[1px] bg-slate-100"></div>
                                </div>

                                <!-- Drop-off Date & Time -->
                                <div class="p-5 hover:bg-slate-50/80 transition-all rounded-[2rem] group/field border border-transparent hover:border-slate-100 flex flex-col justify-center">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 font-friendly">Drop-off Date & Time</label>
                                    <div class="relative flex items-center">
                                        <i class="fa-solid fa-calendar-check text-[15px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                        <input type="datetime-local" name="dropoff_datetime" :disabled="activeTab !== 'transport-logistics'" class="w-full bg-transparent border-0 pl-7 py-1 text-sm md:text-[14px] font-bold text-[#0A192F] focus:ring-0 cursor-pointer font-friendly">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Flights Search (Specialized) -->
                        <div x-show="activeTab === 'flights-ticketing'" x-cloak style="display:none" class="flex flex-col w-full">
                            <!-- Flight Trip Type & Passengers -->
                            <div class="flex flex-wrap items-center gap-4 px-6 py-3 border-b border-slate-50">
                                <!-- Trip Type Dropdown -->
                                <div class="relative" x-data="{ open: false, type: 'Round-trip' }">
                                    <button type="button" @click="open = !open" class="flex items-center gap-2 px-4 py-2 hover:bg-slate-50 rounded-xl transition-all">
                                        <i class="fa-solid fa-arrows-left-right text-[#ED1C24] text-[10px]"></i>
                                        <span class="text-[10px] font-black uppercase tracking-widest text-[#0A192F]" x-text="type"></span>
                                        <i class="fa-solid fa-chevron-down text-[8px] text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                                    </button>
                                    <div x-show="open" @click.outside="open = false" class="absolute top-full left-0 mt-2 w-48 bg-white shadow-2xl rounded-2xl z-50 border border-slate-100 p-2 overflow-hidden" 
                                         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                                        <button type="button" @click="type = 'Round-trip'; open = false" class="w-full text-left px-4 py-3 text-[9px] font-black uppercase tracking-widest hover:bg-slate-50 text-[#0A192F] rounded-xl transition-colors">Round-trip</button>
                                        <button type="button" @click="type = 'One-way'; open = false" class="w-full text-left px-4 py-3 text-[9px] font-black uppercase tracking-widest hover:bg-slate-50 text-[#0A192F] rounded-xl transition-colors">One-way</button>
                                        <button type="button" @click="type = 'Multi-city'; open = false" class="w-full text-left px-4 py-3 text-[9px] font-black uppercase tracking-widest hover:bg-slate-50 text-[#0A192F] rounded-xl transition-colors">Multi-city</button>
                                    </div>
                                    <input type="hidden" name="trip_type" :value="type">
                                </div>

                                <div class="w-px h-4 bg-slate-100 hidden md:block"></div>

                                <!-- Passengers & Class -->
                                <div class="relative" x-data="{ open: false, adults: 1, class: 'Economy' }">
                                    <button type="button" @click="open = !open" class="flex items-center gap-2 px-4 py-2 hover:bg-slate-50 rounded-xl transition-all">
                                        <i class="fa-solid fa-user-group text-[#ED1C24] text-[10px]"></i>
                                        <span class="text-[10px] font-black uppercase tracking-widest text-[#0A192F]" x-text="adults + ' Adult, ' + class"></span>
                                        <i class="fa-solid fa-chevron-down text-[8px] text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                                    </button>
                                    <div x-show="open" @click.outside="open = false" class="absolute top-full left-0 mt-2 w-64 bg-white shadow-2xl rounded-2xl z-50 border border-slate-100 p-6"
                                         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                                        <div class="space-y-6">
                                            <div>
                                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3 block">Passengers</label>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-xs font-bold text-[#0A192F]">Adults</span>
                                                    <div class="flex items-center gap-3">
                                                        <button type="button" @click="if(adults > 1) adults--" class="w-8 h-8 rounded-full border border-slate-100 flex items-center justify-center text-slate-400 hover:text-[#ED1C24] transition-colors">-</button>
                                                        <span class="text-sm font-bold w-4 text-center" x-text="adults"></span>
                                                        <button type="button" @click="adults++" class="w-8 h-8 rounded-full border border-slate-100 flex items-center justify-center text-slate-400 hover:text-[#ED1C24] transition-colors">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3 block">Cabin Class</label>
                                                <select x-model="class" class="w-full bg-slate-50 border-0 rounded-xl text-[10px] font-black uppercase tracking-widest focus:ring-0">
                                                    <option>Economy</option>
                                                    <option>Premium Economy</option>
                                                    <option>Business</option>
                                                    <option>First Class</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="passengers" :value="adults">
                                    <input type="hidden" name="cabin_class" :value="class">
                                </div>
                            </div>

                            <!-- Inputs Row -->
                            <div class="grid grid-cols-1 md:grid-cols-4 w-full divide-x divide-slate-50">
                                <!-- From -->
                                <div class="p-5 hover:bg-slate-50 transition-all group/field">
                                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3">From</label>
                                    <div class="relative flex items-center">
                                        <i class="fa-solid fa-plane-departure absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                        <input type="text" name="origin" placeholder="Where from?" class="w-full bg-transparent border-0 pl-8 py-1 text-[15px] font-black text-[#0A192F] focus:ring-0 uppercase tracking-tighter placeholder-slate-200">
                                    </div>
                                </div>

                                <!-- To -->
                                <div class="p-5 hover:bg-slate-50 transition-all group/field">
                                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3">To</label>
                                    <div class="relative flex items-center">
                                        <i class="fa-solid fa-plane-arrival absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                        <input type="text" name="destination" placeholder="Where to?" class="w-full bg-transparent border-0 pl-8 py-1 text-[15px] font-black text-[#0A192F] focus:ring-0 uppercase tracking-tighter placeholder-slate-200">
                                    </div>
                                </div>

                                <!-- Date Selection (Complex) -->
                                <div class="col-span-1 md:col-span-2 p-5 hover:bg-slate-50 transition-all group/field relative" x-data="{ open: false, depOffset: 'exact', retOffset: 'exact', range: '{{ date('Y-m-d') }} to {{ date('Y-m-d', strtotime('+7 days')) }}' }" @click.outside="open = false">
                                    <div class="grid grid-cols-2 divide-x divide-slate-100">
                                        <div class="pr-5 cursor-pointer" @click="open = !open">
                                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3">Departure</label>
                                            <div class="relative flex items-center">
                                                <i class="fa-solid fa-calendar-days font-black absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                                <span class="pl-8 text-[15px] font-black text-[#0A192F] uppercase tracking-tighter whitespace-nowrap" x-text="range.split(' to ')[0] || 'Select'"></span>
                                            </div>
                                        </div>
                                        <div class="pl-5 cursor-pointer" @click="open = !open">
                                            <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3">Return</label>
                                            <div class="relative flex items-center">
                                                <i class="fa-solid fa-calendar-check absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                                <span class="pl-8 text-[15px] font-black text-[#0A192F] uppercase tracking-tighter whitespace-nowrap" x-text="range.split(' to ')[1] || 'Select'"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Complex Date Popover -->
                                    <div x-show="open" 
                                         class="absolute top-full left-0 mt-4 w-full md:w-[700px] bg-white shadow-[0_50px_100px_-20px_rgba(0,0,0,0.2)] rounded-[2.5rem] z-[100] border border-slate-100 flex flex-col md:flex-row divide-y md:divide-y-0 md:divide-x divide-slate-100 p-8"
                                         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" @click.stop>
                                        
                                        <!-- Left Side: Date Calendar Picker -->
                                        <div class="flex-1 pr-0 md:pr-8">
                                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Execution Schedule</h4>
                                            <input type="text" id="flight-range-picker" x-model="range" class="hidden">
                                            <div id="flight-calendar-container" class="bg-slate-50 rounded-3xl p-4 min-h-[300px]">
                                                <!-- Flatpickr will attach here -->
                                            </div>
                                        </div>

                                        <!-- Right Side: Tactical Offsets -->
                                        <div class="w-full md:w-[280px] pt-8 md:pt-0 md:pl-8 flex flex-col gap-8">
                                            <div>
                                                <div class="flex items-center gap-2 mb-4">
                                                    <div class="w-2 h-2 rounded-full bg-[#ED1C24]"></div>
                                                    <span class="text-[10px] font-black text-[#0A192F] uppercase tracking-widest">Departure Flexibility</span>
                                                </div>
                                                <div class="relative">
                                                     <select x-model="depOffset" class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-4 text-[10px] font-black text-[#0A192F] uppercase tracking-widest focus:ring-2 focus:ring-[#ED1C24]/10 cursor-pointer appearance-none">
                                                         <option value="exact">exact</option>
                                                         <option value="+1">+day after</option>
                                                         <option value="-1">-day before</option>
                                                         <option value="+-1">+-1day</option>
                                                         <option value="+-2">+-2day</option>
                                                         <option value="+-3">+-3day</option>
                                                     </select>
                                                     <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 text-[10px] pointer-events-none"></i>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="flex items-center gap-2 mb-4">
                                                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                                    <span class="text-[10px] font-black text-[#0A192F] uppercase tracking-widest">Return Flexibility</span>
                                                </div>
                                                <div class="relative">
                                                     <select x-model="retOffset" class="w-full bg-slate-50 border-0 rounded-2xl px-5 py-4 text-[10px] font-black text-[#0A192F] uppercase tracking-widest focus:ring-2 focus:ring-[#ED1C24]/10 cursor-pointer appearance-none">
                                                         <option value="exact">exact</option>
                                                         <option value="+1">+day after</option>
                                                         <option value="-1">-day before</option>
                                                         <option value="+-1">+-1day</option>
                                                         <option value="+-2">+-2day</option>
                                                         <option value="+-3">+-3day</option>
                                                     </select>
                                                     <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 text-[10px] pointer-events-none"></i>
                                                </div>
                                            </div>

                                            <div class="mt-auto">
                                                <button type="button" @click="open = false" class="w-full py-5 bg-[#0A192F] text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-[#ED1C24] transition-all shadow-xl">Apply Matrix</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" name="dep_offset" :value="depOffset">
                                    <input type="hidden" name="ret_offset" :value="retOffset">
                                    <input type="hidden" name="dates" :value="range">
                                </div>
                            </div>
                        </div>
                        <!-- Simplified Travel Architect (Streamlined Row) -->
                        <div x-show="activeTab === 'travel-hospitality'" x-cloak style="display:none" class="w-full" x-data="{ advanced: false }">
                            <div class="flex flex-col md:flex-row items-stretch gap-1.5">
                                <!-- Main Travel Search Strip -->
                                <div class="flex-1 grid grid-cols-1 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-slate-100 h-full">
                                    
                                    <!-- Trip Profile -->
                                    <div class="p-4 hover:bg-slate-50/50 transition-all rounded-l-[1.8rem] group/field relative">
                                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Trip Type</label>
                                        <div class="relative flex items-center">
                                            <i class="fa-solid fa-plane text-[14px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                            <select name="travel_type" :disabled="activeTab !== 'travel-hospitality'" class="w-full bg-transparent border-0 pl-6 py-1 text-[14px] font-bold text-[#0A192F] focus:ring-0 cursor-pointer font-friendly">
                                                <option value="">Mission Profile?</option>
                                                <option value="corporate">Corporate Visit</option>
                                                <option value="wedding">Wedding Group</option>
                                                <option value="leisure">Leisure Tour</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Target Destination -->
                                    <div class="p-4 hover:bg-slate-50/50 transition-all group/field relative">
                                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Destination</label>
                                        <div class="relative flex items-center">
                                            <i class="fa-solid fa-location-crosshairs text-[14px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                            <input type="text" name="destination" :disabled="activeTab !== 'travel-hospitality'" placeholder="Where to?" class="w-full bg-transparent border-0 pl-6 py-1 text-[14px] font-bold text-[#0A192F] focus:ring-0 uppercase placeholder-slate-300 font-friendly">
                                        </div>
                                    </div>

                                    <!-- Operational Dates -->
                                    <div class="p-4 hover:bg-slate-50/50 transition-all group/field relative">
                                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Travel Window</label>
                                        <div class="relative flex items-center">
                                            <i class="fa-solid fa-calendar-alt text-[14px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                            <input type="text" id="travel-datepicker-architect" name="dates" :disabled="activeTab !== 'travel-hospitality'" placeholder="Select Dates" class="w-full bg-transparent border-0 pl-6 py-1 text-[14px] font-bold text-[#0A192F] focus:ring-0 cursor-pointer font-friendly">
                                        </div>
                                    </div>

                                    <!-- Force Count -->
                                    <div class="p-4 hover:bg-slate-50/50 transition-all rounded-r-[1.8rem] group/field relative">
                                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Group Size</label>
                                        <div class="relative flex items-center">
                                            <i class="fa-solid fa-users absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                            <input type="number" name="pax" :disabled="activeTab !== 'travel-hospitality'" placeholder="Travelers (PAX)" class="w-full bg-transparent border-0 pl-6 py-1 text-[14px] font-bold text-[#0A192F] focus:ring-0 placeholder-slate-300 font-friendly">
                                        </div>
                                    </div>

                                </div>

                                <!-- Action Bundle -->
                                <div class="flex items-center gap-2 p-2">
                                    <button type="button" @click="advanced = !advanced" 
                                            class="w-12 h-12 flex items-center justify-center rounded-2xl border border-slate-100 text-slate-400 hover:text-[#ED1C24] hover:bg-red-50 transition-all group/adv"
                                            title="Advanced Logistics">
                                        <i class="fa-solid fa-sliders text-sm transition-transform duration-500" :class="advanced ? 'rotate-180' : ''"></i>
                                    </button>
                                    
                                    <button type="submit" class="h-12 px-8 bg-[#ED1C24] text-white rounded-2xl font-black text-[12px] uppercase tracking-[0.1em] hover:bg-[#0A192F] hover:shadow-xl hover:shadow-[#ED1C24]/20 transition-all flex items-center gap-3 group/btn">
                                        <span>Plan Search</span>
                                        <i class="fa-solid fa-arrow-right text-[10px] group-hover/btn:translate-x-1 transition-transform"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Advanced Travel Parameters (Slide Down) -->
                            <div x-show="advanced" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 -translate-y-4"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="mt-4 pt-6 border-t border-slate-50 grid grid-cols-1 md:grid-cols-4 gap-6 px-4 pb-4">
                                
                                <!-- Booking & Budget -->
                                <div class="space-y-4">
                                    <label class="block text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Logistics & Budget</label>
                                    <select name="transport_type" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-2 text-[12px] font-bold text-[#0A192F] focus:ring-1 focus:ring-[#ED1C24]/10">
                                        <option value="">Transport Preference</option>
                                        <option value="business">Business Class</option>
                                        <option value="private">Private Charter</option>
                                        <option value="ground">Ground Only</option>
                                    </select>
                                    <input type="number" name="budget" placeholder="Target Budget (PKR)" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-2 text-[12px] font-bold text-[#0A192F] focus:ring-1 focus:ring-[#ED1C24]/10">
                                </div>

                                <!-- Accommodation -->
                                <div class="space-y-4">
                                    <label class="block text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">HQ grade</label>
                                    <select name="hotel_grade" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-2 text-[12px] font-bold text-[#0A192F] focus:ring-1 focus:ring-[#ED1C24]/10">
                                        <option value="">Hotel Grade</option>
                                        <option value="5star">5-Star Elite</option>
                                        <option value="4star">4-Star Ops</option>
                                        <option value="resort">Resort Node</option>
                                    </select>
                                    <input type="number" name="rooms" placeholder="Room Blocks Needed" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-2 text-[12px] font-bold text-[#0A192F] focus:ring-1 focus:ring-[#ED1C24]/10">
                                </div>

                                <!-- Strategy & Itinerary -->
                                <div class="space-y-4">
                                    <label class="block text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Mission Strategy</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <label class="flex items-center gap-2 p-2 bg-slate-50 rounded-xl cursor-pointer hover:bg-red-50 transition-colors">
                                            <input type="checkbox" name="itinerary[]" value="sightseeing" checked class="sr-only peer">
                                            <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest peer-checked:text-[#ED1C24]">Sightseeing</span>
                                        </label>
                                        <label class="flex items-center gap-2 p-2 bg-slate-50 rounded-xl cursor-pointer hover:bg-red-50 transition-colors">
                                            <input type="checkbox" name="itinerary[]" value="business" class="sr-only peer">
                                            <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest peer-checked:text-[#ED1C24]">Business</span>
                                        </label>
                                    </div>
                                    <input type="text" name="requirements" placeholder="Special Requirements..." class="w-full bg-slate-50 border-0 rounded-xl px-4 py-2 text-[12px] font-bold text-[#0A192F] focus:ring-1 focus:ring-[#ED1C24]/10">
                                </div>

                                <!-- Risk & Docs -->
                                <div class="space-y-4">
                                    <label class="block text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Command & Docs</label>
                                    <select name="comm_tool" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-2 text-[12px] font-bold text-[#0A192F] focus:ring-0">
                                        <option value="whatsapp">WhatsApp Group Ops</option>
                                        <option value="telegram">Telegram Hub</option>
                                    </select>
                                    <div class="flex items-center justify-between p-2 bg-slate-50 rounded-xl">
                                        <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest leading-none">Visa/Audit <br/>Protocols</span>
                                        <i class="fa-solid fa-shield-halved text-emerald-500 text-[12px]"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Catering Search -->
                        <div x-show="activeTab === 'catering-food'" style="display:none" class="grid grid-cols-1 w-full h-full">
                            <div class="p-5 hover:bg-slate-50/80 transition-all rounded-[1.8rem] group/field border border-transparent hover:border-slate-100 relative">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 font-friendly">Location</label>
                                <div class="relative flex items-center">
                                    <i class="fa-solid fa-map-pin text-[15px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                    <select name="city" :disabled="activeTab !== 'catering-food'" class="w-full bg-transparent border-0 pl-7 pr-2 py-1 text-sm md:text-[15px] font-bold text-[#0A192F] focus:ring-0 cursor-pointer font-friendly">
                                        <option value="">Which city?</option>
                                        @foreach($cities as $c)
                                            <option value="{{ $c->name }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Corporate Solutions (Elite Redesign) -->
                        <div x-show="activeTab === 'conferences-summits'" x-cloak style="display:none" class="w-full" x-data="{ advanced: false }">
                            <div class="flex flex-col md:flex-row items-stretch gap-1.5">
                                <!-- Main Search Strip -->
                                <div class="flex-1 grid grid-cols-1 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-slate-100 h-full">
                                    <!-- Event Scope -->
                                    <div class="p-4 hover:bg-slate-50/50 transition-all rounded-l-[1.8rem] group/field relative">
                                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Corporate Service</label>
                                        <div class="relative flex items-center">
                                            <i class="fa-solid fa-briefcase text-[14px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                            <select name="corporate_event_type" :disabled="activeTab !== 'conferences-summits'" class="w-full bg-transparent border-0 pl-6 py-1 text-[14px] font-bold text-[#0A192F] focus:ring-0 cursor-pointer">
                                                <option value="">What kind of solution?</option>
                                                <option value="Conference">Executive Conference</option>
                                                <option value="Product Launch">Strategic Launch</option>
                                                <option value="Exhibition">Corporate Expo</option>
                                                <option value="Training">Personnel Training</option>
                                                <option value="Annual Dinner">Annual Summit</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Location Node -->
                                    <div class="p-4 hover:bg-slate-50/50 transition-all group/field relative">
                                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Location Node</label>
                                        <div class="relative flex items-center">
                                            <i class="fa-solid fa-location-crosshairs text-[14px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                            <select name="city" :disabled="activeTab !== 'conferences-summits'" class="w-full bg-transparent border-0 pl-6 py-1 text-[14px] font-bold text-[#0A192F] focus:ring-0 cursor-pointer">
                                                <option value="">Worldwide HQ</option>
                                                @foreach($cities as $c)
                                                    <option value="{{ $c->name }}">{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Operational Date -->
                                    <div class="p-4 hover:bg-slate-50/50 transition-all group/field relative">
                                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Mission Timeline</label>
                                        <div class="relative flex items-center">
                                            <i class="fa-solid fa-calendar-alt text-[14px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                            <input type="text" name="event_date_range" id="corporate-datepicker-refined" :disabled="activeTab !== 'conferences-summits'" placeholder="Select Operations Dates" class="w-full bg-transparent border-0 pl-6 py-1 text-[14px] font-bold text-[#0A192F] focus:ring-0 cursor-pointer">
                                        </div>
                                    </div>

                                    <!-- Asset Profile -->
                                    <div class="p-4 hover:bg-slate-50/50 transition-all rounded-r-[1.8rem] group/field relative">
                                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Guest Capacity</label>
                                        <div class="relative flex items-center">
                                            <i class="fa-solid fa-users-gear text-[14px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                            <select name="event_size" :disabled="activeTab !== 'conferences-summits'" class="w-full bg-transparent border-0 pl-6 py-1 text-[14px] font-bold text-[#0A192F] focus:ring-0 cursor-pointer">
                                                <option value="">Any Size</option>
                                                <option value="0-50">Micro (1-50)</option>
                                                <option value="50-200">Medium (50-200)</option>
                                                <option value="200-500">Large (200-500)</option>
                                                <option value="500+">Grand (1000+)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Search & Advanced Bundle -->
                                <div class="flex items-center gap-2 p-2">
                                    <button type="button" @click="advanced = !advanced" 
                                            class="w-12 h-12 flex items-center justify-center rounded-2xl border border-slate-100 text-slate-400 hover:text-[#ED1C24] hover:bg-red-50 transition-all group/adv"
                                            title="Advanced Parameters">
                                        <i class="fa-solid fa-sliders text-sm transition-transform duration-500" :class="advanced ? 'rotate-180' : ''"></i>
                                    </button>
                                    
                                    <button type="submit" class="h-12 px-8 bg-[#ED1C24] text-white rounded-2xl font-black text-[12px] uppercase tracking-[0.1em] hover:bg-[#0A192F] hover:shadow-xl hover:shadow-[#ED1C24]/20 transition-all flex items-center gap-3 group/btn">
                                        <span>Search Now</span>
                                        <i class="fa-solid fa-arrow-right text-[10px] group-hover/btn:translate-x-1 transition-transform"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Advanced Mission Parameters (Slide Down) -->
                            <div x-show="advanced" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 -translate-y-4"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="mt-4 pt-6 border-t border-slate-50 grid grid-cols-1 md:grid-cols-4 gap-6 px-4 pb-4">
                                
                                <!-- Compliance & Hierarchy -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Operational Hierarchy</label>
                                        <input type="text" name="department" placeholder="Department (e.g. Executive)" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-2 text-[12px] font-bold text-[#0A192F] focus:ring-1 focus:ring-[#ED1C24]/10">
                                    </div>
                                    <input type="text" name="cost_center" placeholder="Cost Center ID" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-2 text-[12px] font-bold text-[#0A192F] focus:ring-1 focus:ring-[#ED1C24]/10 uppercase">
                                </div>

                                <!-- Financial Architecture -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Budget Architecture</label>
                                        <input type="number" name="max_price" placeholder="Target Budget (PKR)" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-2 text-[12px] font-bold text-[#0A192F] focus:ring-1 focus:ring-[#ED1C24]/10">
                                    </div>
                                    <select name="approval_level" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-2 text-[12px] font-bold text-[#0A192F] focus:ring-0">
                                        <option value="">Approval Level Required</option>
                                        <option value="Level 1">L1: Operational</option>
                                        <option value="Level 2">L2: Management</option>
                                        <option value="Level 3">L3: Board Level</option>
                                    </select>
                                </div>

                                <!-- Strategy & Filters -->
                                <div class="space-y-4">
                                    <label class="block text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Mission Strategy</label>
                                    <div class="flex items-center justify-between p-2 bg-slate-50 rounded-xl border border-transparent hover:border-[#ED1C24]/10 transition-colors">
                                        <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Verified Assets Only</span>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="verified_only" value="1" class="sr-only peer">
                                            <div class="w-8 h-4 bg-slate-200 rounded-full peer peer-checked:bg-[#ED1C24] transition-all after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:after:translate-x-4"></div>
                                        </label>
                                    </div>
                                    <div class="flex items-center justify-between p-2 bg-slate-50 rounded-xl border border-transparent hover:border-[#ED1C24]/10 transition-colors">
                                        <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Corporate Pricing</span>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="corporate_pricing_applied" value="1" checked class="sr-only peer">
                                            <div class="w-8 h-4 bg-slate-200 rounded-full peer peer-checked:bg-[#ED1C24] transition-all after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:after:translate-x-4"></div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Regional Context -->
                                <div class="space-y-4">
                                    <label class="block text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Regional Precision</label>
                                    <select name="region" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-2 text-[12px] font-bold text-[#0A192F] focus:ring-0 cursor-pointer">
                                        <option value="">All Regions</option>
                                        <option value="North">North Hub</option>
                                        <option value="Central">Central Hub</option>
                                        <option value="South">South Hub</option>
                                        <option value="International">Global Node</option>
                                    </select>
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-user-shield text-slate-300 text-[10px]"></i>
                                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Scope: Executive Access</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- General Search (all other tabs) -->
                        <div x-show="!['events-management','venues-coordination','transport-logistics','flights-ticketing','travel-hospitality', 'catering-food', 'conferences-summits'].includes(activeTab)" style="display:none" class="grid grid-cols-1 md:grid-cols-12 w-full h-full">
                            <div class="md:col-span-12 hidden"></div>
                            <div class="md:col-span-6 p-5 hover:bg-slate-50/80 transition-all rounded-[1.8rem] group/field relative border border-transparent hover:border-slate-100">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 font-friendly">Search</label>
                                <div class="relative flex items-center">
                                    <i class="fa-solid fa-magnifying-glass text-[15px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                    <input type="text" name="search" :disabled="['events-management','venues-coordination','transport-logistics','flights-ticketing','travel-hospitality', 'catering-food', 'conferences-summits'].includes(activeTab)" placeholder="Search..." class="w-full bg-transparent border-0 pl-7 py-1 text-sm md:text-[15px] font-bold text-[#0A192F] focus:ring-0 placeholder-slate-300 font-friendly">
                                </div>
                                <div class="hidden md:block absolute right-0 top-1/4 bottom-1/4 w-[1px] bg-slate-100"></div>
                            </div>
                            <div class="md:col-span-6 p-5 hover:bg-slate-50/80 transition-all rounded-[1.8rem] group/field border border-transparent hover:border-slate-100">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 font-friendly">Location</label>
                                <div class="relative flex items-center">
                                    <i class="fa-solid fa-map-pin text-[15px] absolute left-0 text-[#ED1C24]/30 group-hover/field:text-[#ED1C24] transition-colors"></i>
                                    <select name="city" :disabled="['events-management','venues-coordination','transport-logistics','flights-ticketing','travel-hospitality', 'catering-food', 'conferences-summits'].includes(activeTab)" class="w-full bg-transparent border-0 pl-7 pr-2 py-1 text-sm md:text-[15px] font-bold text-[#0A192F] focus:ring-0 cursor-pointer font-friendly">
                                        <option value="">Which city?</option>
                                        @foreach($cities as $c)
                                            <option value="{{ $c->name }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search Button -->
                    <div class="p-2 w-full md:w-auto self-stretch flex items-center" x-show="!['conferences-summits', 'travel-hospitality'].includes(activeTab)">
                        <button type="submit" class="w-full md:w-auto h-full min-h-[55px] md:min-h-0 px-8 py-4 md:px-10 md:py-5 bg-[#ED1C24] hover:bg-black text-white rounded-[1.5rem] md:rounded-[2rem] font-bold uppercase tracking-wider text-[11px] shadow-[0_20px_45px_-12px_rgba(237,28,36,0.4)] transition-all duration-500 hover:scale-[1.03] active:scale-95 group/btn overflow-hidden relative font-friendly whitespace-nowrap flex items-center justify-center gap-3">
                            <span class="relative z-10">Search Now</span>
                            <i class="fa-solid fa-arrow-right text-[13px] relative z-10 group-hover/btn:translate-x-1 transition-transform"></i>
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/15 to-transparent -translate-x-full group-hover/btn:animate-[shimmer_1.8s_infinite] pointer-events-none"></div>
                        </button>
                    </div>
                </div>
                </form>

                <!-- Secondary CTAs -->
                <div class="grid grid-cols-1 sm:flex sm:flex-wrap justify-center gap-3 mt-6 md:mt-8">
                    <a href="{{ route('budget-planner') }}" class="px-5 py-3 md:px-6 md:py-3 bg-white/5 backdrop-blur-md border border-white/10 text-white rounded-xl text-[9px] md:text-[10px] font-black uppercase tracking-widest hover:bg-white/10 transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-wand-magic-sparkles text-indigo-400"></i>
                        AI-Assisted Planning
                    </a>
                    <a href="{{ route('contact') }}" class="px-5 py-3 md:px-6 md:py-3 bg-white/5 backdrop-blur-md border border-white/10 text-white rounded-xl text-[9px] md:text-[10px] font-black uppercase tracking-widest hover:bg-white/10 transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-file-invoice-dollar text-primary-400"></i>
                        Request Custom Quote
                    </a>
                    <div class="flex items-center justify-center gap-6 px-6 py-3 bg-emerald-500/10 rounded-xl border border-emerald-500/20">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <span class="text-[9px] font-black text-emerald-400 uppercase tracking-widest">Instant Booking</span>
                            <div class="relative inline-flex items-center">
                                <input type="checkbox" x-model="instantBooking" class="sr-only peer">
                                <div class="w-8 h-4 bg-white/10 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-emerald-500"></div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trust Bar (Polished Strategic Statistics) -->
        <div class="absolute bottom-8 left-0 right-0 z-20">
            <div class="max-w-[1200px] mx-auto px-6">
                <div class="bg-white/5 backdrop-blur-3xl rounded-[1.5rem] border border-white/10 p-4 md:p-6 grid grid-cols-2 md:grid-cols-5 items-center gap-4 md:gap-8">
                    <div class="flex flex-col items-center border-r border-white/5 md:border-0">
                        <div class="text-xl md:text-2xl font-black text-white mb-1 tracking-tighter">100K<span class="text-[#ED1C24]">+</span></div>
                        <div class="flex items-center gap-2 text-center">
                            <span class="text-[8px] font-black text-white/30 uppercase tracking-[0.2em] md:tracking-[0.3em]">Verified Assets</span>
                            <i class="fa-solid fa-circle-check text-[#ED1C24] text-[8px]"></i>
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-center">
                        <div class="text-xl md:text-2xl font-black text-white mb-1 tracking-tighter">10K<span class="text-[#ED1C24]">+</span></div>
                        <div class="flex items-center gap-2 text-center">
                            <span class="text-[8px] font-black text-white/30 uppercase tracking-[0.2em] md:tracking-[0.3em]">Successful Ops</span>
                            <i class="fa-solid fa-bolt text-blue-400 text-[8px]"></i>
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-center border-r border-white/5 md:border-0 pt-4 md:pt-0">
                        <div class="text-xl md:text-2xl font-black text-white mb-1 tracking-tighter">500<span class="text-[#ED1C24]">+</span></div>
                        <div class="flex items-center gap-2 text-center">
                            <span class="text-[8px] font-black text-white/30 uppercase tracking-[0.2em] md:tracking-[0.3em]">Global Nodes</span>
                            <i class="fa-solid fa-network-wired text-[#ED1C24] text-[8px]"></i>
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-center pt-4 md:pt-0">
                        <div class="text-xl md:text-2xl font-black text-white mb-1 tracking-tighter"><span class="text-[#ED1C24] text-sm">★</span> 4.9</div>
                        <div class="flex items-center gap-2 text-center">
                            <span class="text-[8px] font-black text-white/30 uppercase tracking-[0.2em] md:tracking-[0.3em]">Reliability</span>
                        </div>
                    </div>

                    <div class="col-span-2 md:col-span-1 flex flex-col items-center pt-4 md:pt-0 border-t border-white/5 md:border-0 w-full">
                        <i class="fa-solid fa-shield-check text-[#ED1C24] text-xl mb-1"></i>
                        <span class="text-[8px] font-black text-white/30 uppercase tracking-[0.2em] md:tracking-[0.3em]">Escrow Secured</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="budget-preview-container"></div>






    <!-- Stats Bar -->





    <!-- Custom Protocols (Packages Architecture) -->
    @if($customPackages->count() > 0)
    <div class="py-24 bg-[#0A192F] relative overflow-hidden">
        <!-- Neural Background Architecture -->
        <div class="absolute inset-0 opacity-5 pointer-events-none">
            <div class="absolute inset-0" style="background-image: radial-gradient(rgba(237, 28, 36, 0.2) 2px, transparent 2px); background-size: 80px 80px;"></div>
        </div>

        <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-12">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-3 bg-[#ED1C24]/10 px-6 py-2 rounded-full border border-[#ED1C24]/10 font-black text-[10px] text-[#ED1C24] uppercase tracking-[0.4em]">Proprietary Architectures</div>
                    <h2 class="text-4xl md:text-6xl font-black text-white uppercase tracking-tighter leading-none">
                        Tactical <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-white to-blue-400 ">Deployment</span>
                    </h2>
                </div>
                <div class="flex gap-4 pb-2">
                    <a href="{{ route('packages.create') }}" class="group px-10 py-5 bg-white text-[#0A192F] rounded-2xl font-black uppercase tracking-widest text-[11px] transition-all hover:scale-110 active:scale-95 flex items-center gap-3 shadow-2xl shadow-white/5">
                        <i class="fa-solid fa-wand-magic-sparkles text-[#ED1C24]"></i> Initiate Build
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                @foreach($customPackages as $package)
                <div class="group relative bg-white/5 backdrop-blur-3xl rounded-[3rem] border border-white/10 overflow-hidden hover:bg-white/10 transition-all duration-700 shadow-2xl">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ $package->image ? asset('storage/' . $package->image) : 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=800&q=80' }}" 
                             class="w-full h-full object-cover transform scale-110 group-hover:scale-100 transition-transform duration-[1.5s]">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F] via-[#0A192F]/40 to-transparent"></div>
                        
                        <div class="absolute top-6 left-6 px-4 py-2 bg-[#ED1C24]/80 backdrop-blur-xl rounded-full">
                            <span class="text-[9px] font-black text-white uppercase tracking-widest">{{ $package->services->count() }} Assets Included</span>
                        </div>
                    </div>

                    <div class="p-10 space-y-8">
                        <div>
                            <h3 class="text-2xl font-black text-white uppercase tracking-tighter mb-4 group-hover:text-[#ED1C24] transition-colors">{{ $package->name }}</h3>
                            <p class="text-blue-100/40 text-sm font-medium  leading-relaxed line-clamp-2">"{{ $package->description }}"</p>
                        </div>

                        <div class="flex items-center justify-between pt-8 border-t border-white/5">
                            <div>
                                <span class="block text-[9px] font-black text-white/30 uppercase tracking-widest mb-1">Bundle Value</span>
                                <div class="text-3xl font-black text-white">
                                    <span class="text-sm font-medium text-white/30 mr-1">Rs.</span>{{ number_format($package->total_price) }}
                                </div>
                            </div>
                            <a href="{{ route('packages.show', $package->id) }}" class="w-14 h-14 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center text-white group-hover:bg-[#ED1C24] group-hover:border-[#ED1C24] transition-all duration-500">
                                <i class="fa-solid fa-arrow-right-long text-lg"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Technical Bottom Accent -->
                    <div class="absolute bottom-0 left-0 h-1 w-0 bg-[#ED1C24] group-hover:w-full transition-all duration-700"></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    <!-- Elite Asset Deployment (Featured Selections) -->
    @if(($hp['hp_featured_show'] ?? '1') === '1')
    <div class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-10 mb-12">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-3 bg-[#ED1C24]/10 px-6 py-2 rounded-full border border-[#ED1C24]/10 font-black text-[10px] text-[#ED1C24] uppercase tracking-[0.4em]">{{ $hp['hp_featured_badge'] ?? 'High-Value Intelligence' }}</div>
                    <h2 class="text-4xl md:text-5xl font-black text-[#0A192F] uppercase tracking-tighter leading-none">
                        {{ $hp['hp_featured_title'] ?? 'Featured' }} <span class="text-[#ED1C24]">{{ $hp['hp_featured_title_hl'] ?? 'Assets' }}</span>
                    </h2>
                    <p class="text-lg text-gray-400 font-medium uppercase tracking-widest max-w-2xl">
                        "{{ $hp['hp_featured_subtitle'] ?? 'Pre-vetted elite protocols for specialized event architectures and high-stakes travel.' }}"
                    </p>
                </div>
                <div class="shrink-0 pb-2">
                    <a href="{{ route('services') }}" class="group flex items-center gap-4 px-10 py-5 bg-[#0A192F] text-white rounded-[1.5rem] font-black uppercase tracking-widest text-[11px] transition-all hover:scale-105 active:scale-95 shadow-2xl shadow-blue-900/20">
                        View All <i class="fa-solid fa-arrow-right-long group-hover:translate-x-3 transition-transform"></i>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                @php
                    $featuredOffers = $pakistanServices->merge($globalServices)->take(4);
                @endphp

                @foreach($featuredOffers as $offer)
                @php
                    $offerImg = $offer->getFeaturedImage();
                    $offerImg = $offerImg ? (\Illuminate\Support\Str::startsWith($offerImg, ['http', 'https']) ? $offerImg : asset('storage/' . $offerImg)) : 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=800&q=80';
                @endphp
                <a href="{{ route('services.show', $offer) }}" class="group relative bg-white rounded-[2.5rem] overflow-hidden border border-gray-100 shadow-2xl shadow-gray-200/40 hover:shadow-[#ED1C24]/10 transition-all duration-700 hover:-translate-y-4 block">
                    <!-- Image Architecture -->
                    <div class="relative h-72 overflow-hidden">
                        <img src="{{ $offerImg }}" alt="{{ $offer->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F]/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>

                        <!-- Premium Badge -->
                        <div class="absolute top-6 left-6 px-4 py-2 bg-[#0A192F]/80 backdrop-blur-xl border border-white/10 rounded-full">
                            <span class="text-[9px] font-black text-white uppercase tracking-widest">{{ $offer->category->name ?? 'Service' }}</span>
                        </div>

                        <!-- Rating Protocol -->
                        <div class="absolute top-6 right-6 px-4 py-2 bg-white/90 backdrop-blur-xl rounded-full flex items-center gap-2">
                             <i class="fa-solid fa-star text-[#ED1C24] text-[10px]"></i>
                             <span class="text-[11px] font-black text-[#0A192F]">{{ number_format($offer->cached_rating ?? 5, 1) }}</span>
                        </div>
                    </div>

                    <!-- Data Layer -->
                    <div class="p-8 space-y-6">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-[10px] font-black text-[#ED1C24] uppercase tracking-widest opacity-60">
                                <i class="fa-solid fa-location-crosshairs"></i>
                                {{ $offer->location }}
                            </div>
                            <h3 class="text-xl font-black text-[#0A192F] uppercase tracking-tighter leading-tight group-hover:text-[#ED1C24] transition-colors">{{ $offer->name }}</h3>
                        </div>

                        <div class="flex items-center justify-between pt-6 border-t border-gray-50">
                            <div>
                                <span class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Entry Value</span>
                                <div class="text-2xl font-black text-[#0A192F]">
                                    <span class="text-sm font-medium text-gray-400 mr-1">PKR</span>{{ number_format($offer->price) }}
                                </div>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-[#F8FAFC] border border-gray-100 flex items-center justify-center text-[#0A192F] group-hover:bg-[#ED1C24] group-hover:text-white transition-all duration-500">
                                <i class="fa-solid fa-chevron-right text-sm"></i>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Strategic Corporate Solutions (Elite Redesign) -->
    @if(($hp['hp_corp_show'] ?? '1') === '1')
    <div class="py-24 bg-[#F8FAFC] relative overflow-hidden">
        <!-- Background Accents -->
        <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-blue-50/50 to-transparent"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-[#ED1C24]/5 rounded-full blur-3xl"></div>

        <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-10 mb-16">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-3 bg-[#0A192F] px-6 py-2 rounded-full border border-white/10 font-black text-[9px] text-white uppercase tracking-[0.4em]">{{ $hp['hp_corp_badge'] ?? 'Enterprise Ecosystem' }}</div>
                    <h2 class="text-4xl md:text-5xl font-black text-[#0A192F] uppercase tracking-tighter leading-none">
                        {{ $hp['hp_corp_title'] ?? 'Strategic' }} <span class="text-[#ED1C24]">{{ $hp['hp_corp_title_hl'] ?? 'Corporate' }}</span> {{ $hp['hp_corp_title_end'] ?? 'Solutions' }}
                    </h2>
                    <p class="text-base text-gray-400 font-bold uppercase tracking-[0.15em] max-w-xl">
                        "{{ $hp['hp_corp_subtitle'] ?? 'Pre-Engineered Tactical Assets for Board-Level Events and Global Operations.' }}"
                    </p>
                </div>
                @php $avatarItems = $media['avatar'] ?? collect(); @endphp
                <div class="hidden md:flex gap-4">
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ $hp['hp_avatar_label'] ?? 'Vetted Vendors' }}</span>
                        <div class="flex -space-x-3">
                            @forelse($avatarItems->take(3) as $av)
                                <img src="{{ $av->image ? asset('storage/' . $av->image) : 'https://i.pravatar.cc/100?u=' . $av->id }}" class="w-10 h-10 rounded-full border-2 border-white shadow-lg object-cover">
                            @empty
                                <img src="https://i.pravatar.cc/100?u=1" class="w-10 h-10 rounded-full border-2 border-white shadow-lg">
                                <img src="https://i.pravatar.cc/100?u=2" class="w-10 h-10 rounded-full border-2 border-white shadow-lg">
                                <img src="https://i.pravatar.cc/100?u=3" class="w-10 h-10 rounded-full border-2 border-white shadow-lg">
                            @endforelse
                            <div class="w-10 h-10 rounded-full bg-[#ED1C24] border-2 border-white shadow-lg flex items-center justify-center text-white text-[10px] font-black">{{ $hp['hp_avatar_extra'] ?? '+42' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $corporateCards = ($media['corporate_card'] ?? collect())->map(function($m) {
                        return [
                            'link' => $m->link ?: '#',
                            'name' => $m->title,
                            'type' => $m->subtitle,
                            'pax' => $m->tag,
                            'compliance' => $m->badge,
                            'price' => $m->price,
                            'img' => $m->image ? asset('storage/' . $m->image) : 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?q=80&w=2069&auto=format&fit=crop',
                            'dept' => $m->meta['dept'] ?? '',
                            'verified' => $m->meta['verified'] ?? false,
                        ];
                    })->all();

                    if (empty($corporateCards)) {
                        $corporateCards = [
                            ['link' => ($s = \App\Models\Service::find(39)) ? route('services.show', $s) : url('/services'), 'name' => 'Strategic Summit Hall (Omega Unit)', 'type' => 'Executive Conference', 'pax' => '500-2000 PAX', 'compliance' => 'L3 Board Approved', 'price' => '1,250,000', 'img' => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?q=80&w=2069&auto=format&fit=crop', 'dept' => 'Global Logistics', 'verified' => true],
                            ['link' => ($s = \App\Models\Service::find(40)) ? route('services.show', $s) : url('/services'), 'name' => 'Monarch Boardroom Protocol', 'type' => 'Private Strategy Session', 'pax' => '20-50 PAX', 'compliance' => 'L2 Management Cleared', 'price' => '250,000', 'img' => 'https://images.unsplash.com/photo-1497366811353-6870744d04b2?q=80&w=2069&auto=format&fit=crop', 'dept' => 'Executive Suite', 'verified' => true],
                            ['link' => ($s = \App\Models\Service::find(42)) ? route('services.show', $s) : url('/services'), 'name' => 'Alpha Launch Infrastructure', 'type' => 'Product Activation Hub', 'pax' => '1000+ PAX', 'compliance' => 'L1 Operational Level', 'price' => '3,500,000', 'img' => 'https://images.unsplash.com/photo-1475721027187-402ad2989a38?q=80&w=2070&auto=format&fit=crop', 'dept' => 'Marketing & Activation', 'verified' => true],
                        ];
                    }
                @endphp

                @foreach($corporateCards as $service)
                <a href="{{ $service['link'] }}" class="group relative bg-white rounded-[2rem] overflow-hidden border border-slate-100 shadow-xl shadow-slate-200/40 hover:shadow-[#ED1C24]/10 transition-all duration-500 hover:-translate-y-3 block">
                    <!-- Image Shield -->
                    <div class="relative h-60 overflow-hidden">
                        <img src="{{ $service['img'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[1.2s]">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F] via-transparent to-transparent opacity-60"></div>
                        
                        <!-- Tactical Badges -->
                        <div class="absolute top-5 left-5 flex flex-col gap-2">
                            <span class="px-3 py-1 bg-[#ED1C24] text-white text-[8px] font-black uppercase tracking-widest rounded-full shadow-lg">
                                <i class="fa-solid fa-shield-halved mr-1"></i> {{ $service['compliance'] }}
                            </span>
                            <span class="px-3 py-1 bg-white/90 backdrop-blur-md text-[#0A192F] text-[8px] font-black uppercase tracking-widest rounded-full shadow-lg">
                                <i class="fa-solid fa-users mr-1"></i> {{ $service['pax'] }}
                            </span>
                        </div>

                        @if($service['verified'])
                        <div class="absolute top-5 right-5 w-10 h-10 bg-white/90 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-xl">
                            <i class="fa-solid fa-certificate text-[#ED1C24] text-lg"></i>
                        </div>
                        @endif
                    </div>

                    <!-- Operations Metadata -->
                    <div class="p-8">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[8px] font-black uppercase tracking-widest rounded">DEP: {{ $service['dept'] }}</span>
                            <div class="h-px flex-1 bg-slate-50"></div>
                        </div>
                        
                        <h3 class="text-xl font-black text-[#0A192F] uppercase tracking-tighter leading-tight mb-2 group-hover:text-[#ED1C24] transition-colors">
                            {{ $service['name'] }}
                        </h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">{{ $service['type'] }}</p>

                        <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                            <div>
                                <span class="block text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Corporate Value</span>
                                <div class="text-2xl font-black text-[#0A192F]">
                                    <span class="text-xs font-medium text-slate-400 mr-1">Rs.</span>{{ $service['price'] }}
                                </div>
                            </div>
                             <div class="px-5 py-2.5 bg-[#0A192F] text-white rounded-xl text-[9px] font-black uppercase tracking-[0.2em] transform group-hover:bg-[#ED1C24] transition-all hover:scale-110">
                                 Deploy Asset
                             </div>
                        </div>
                    </div>

                    <!-- Bottom Technical Accent -->
                    <div class="absolute bottom-0 left-0 h-[3px] w-0 bg-[#ED1C24] group-hover:w-full transition-all duration-700"></div>
                </a>
                @endforeach
            </div>

            <!-- Dashboard Portal Access -->
            <div class="mt-16 p-8 bg-[#0A192F] rounded-[2.5rem] relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-1/2 h-full bg-gradient-to-l from-[#ED1C24]/20 to-transparent"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 text-center md:text-left">
                    <div>
                        <h4 class="text-white text-2xl font-black uppercase tracking-tighter">Mission Control Dashboard</h4>
                        <p class="text-white/40 text-sm font-bold uppercase tracking-widest mt-1">Real-time Command of your enterprise fleet & bookings.</p>
                    </div>
                    <a href="{{ route('corporate.dashboard') }}" class="px-10 py-5 bg-white text-[#0A192F] rounded-2xl font-black uppercase tracking-[0.2em] text-[11px] hover:bg-[#ED1C24] hover:text-white transition-all transform hover:scale-105 active:scale-95 shadow-2xl">
                        Access Command Center <i class="fa-solid fa-arrow-right-to-bracket ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Operational Logic (How It Works) -->
    @if(($hp['hp_how_show'] ?? '1') === '1')
    <div class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-16">
                <h4 class="text-[10px] font-black text-[#ED1C24] uppercase tracking-[0.8em] mb-4">{{ $hp['hp_how_badge'] ?? 'Strategic Workflow' }}</h4>
                <h2 class="text-4xl md:text-5xl font-black text-[#0A192F] uppercase tracking-tighter leading-none mb-6">
                    {{ $hp['hp_how_title'] ?? 'Process' }} <span class="text-[#ED1C24]">{{ $hp['hp_how_title_hl'] ?? 'Architecture' }}</span>
                </h2>
                <div class="w-20 h-1.5 bg-gradient-to-r from-[#ED1C24] to-[#0A3A7A] mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 relative">
                <!-- Connecting Line -->
                <div class="absolute top-1/2 left-0 w-full h-px bg-gradient-to-r from-transparent via-gray-100 to-transparent -translate-y-1/2 hidden md:block"></div>

                @foreach(($hp['hp_steps'] ?? []) as $step)
                <div class="group relative flex flex-col items-center text-center space-y-8">
                    <div class="w-24 h-24 rounded-[2rem] bg-[#F8FAFC] border border-gray-100 flex items-center justify-center text-3xl text-[#0A192F] group-hover:bg-[#0A192F] group-hover:text-white transition-all duration-700 shadow-xl group-hover:shadow-[#0A192F]/20 relative z-10">
                        <i class="fa-solid {{ $step['icon'] }}"></i>
                        <div class="absolute -top-4 -right-4 w-10 h-10 bg-[#ED1C24] text-white text-[10px] font-black flex items-center justify-center rounded-xl shadow-lg border-4 border-white">
                            {{ $step['id'] }}
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-[#0A192F] uppercase tracking-tighter mb-3 group-hover:text-[#ED1C24] transition-colors">{{ $step['title'] }}</h3>
                        <p class="text-sm text-gray-500 font-medium  leading-relaxed px-4">"{{ $step['desc'] }}"</p>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-16 p-8 md:p-16 bg-[#0A192F] rounded-[3rem] shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-12 text-left">
                <!-- Background Decoration -->
                <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-br from-[#ED1C24]/10 to-transparent opacity-50"></div>
                
                <div class="relative z-10 space-y-4">
                    <h3 class="text-2xl md:text-4xl font-black text-white uppercase tracking-tighter leading-none">{{ $hp['hp_cta_title'] ?? 'Are you an' }} <br/><span class="text-[#ED1C24]">{{ $hp['hp_cta_title_hl'] ?? 'Organization?' }}</span></h3>
                    <p class="text-blue-100/40 text-base font-medium ">"{{ $hp['hp_cta_subtitle'] ?? 'Join our corporate ecosystem for specialized handling and bulk assets.' }}"</p>
                </div>
                <div class="flex flex-wrap gap-4 relative z-10">
                    <a href="{{ route('corporate') }}" class="px-8 py-4 bg-[#ED1C24] text-white rounded-xl font-black text-[10px] uppercase tracking-widest shadow-2xl shadow-[#ED1C24]/20 hover:scale-110 active:scale-95 transition-all">{{ $hp['hp_cta_btn1'] ?? 'Corporate Portal' }}</a>
                    <a href="{{ route('contact') }}" class="px-8 py-4 bg-white/5 border border-white/10 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">{{ $hp['hp_cta_btn2'] ?? 'Request Briefing' }}</a>
                </div>
            </div>
        </div>
    </div>
    @endif


    <!-- Service Solutions (Expanded Elite Grid) -->
    <div id="services" class="py-16 bg-white relative overflow-hidden border-t border-gray-100">
        <!-- Technical Decor -->
        <div class="absolute top-0 right-0 w-1/3 h-full bg-slate-50 opacity-50 transform skew-x-[-12deg] translate-x-20"></div>

        <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-3 bg-[#ED1C24]/10 px-6 py-2 rounded-full border border-[#ED1C24]/10 mb-6">
                    <span class="text-[9px] font-black text-[#ED1C24] uppercase tracking-[0.4em]">Integrated Platform Ecosystem</span>
                </div>
                <h2 class="text-3xl md:text-5xl font-black text-[#0A192F] mb-6 uppercase tracking-tighter leading-none">
                    Mission-Critical <br/><span class="text-[#ED1C24]">Solutions</span>
                </h2>
                <div class="w-16 h-1 bg-gradient-to-r from-[#ED1C24] via-[#0A192F] to-[#ED1C24] mx-auto rounded-full mb-6"></div>
                <p class="text-base text-gray-400 font-medium leading-relaxed max-w-3xl mx-auto uppercase tracking-wider">
                    "A decentralized network of premium assets engineered for seamless deployment and high-stakes execution."
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @php
                    $mainCategories = [
                        ['name' => 'Event Heritage', 'slug' => 'individual-events', 'icon' => 'fa-party-horn', 'img' => 'photo-1519741497674-611481863552', 'desc' => 'Custom multi-day weddings and private elite celebrations.'],
                        ['name' => 'Corporate Intel', 'slug' => 'corporate-events', 'icon' => 'fa-briefcase', 'img' => 'photo-1511578314322-379afb476865', 'desc' => 'High-fidelity conferences, expos and organizational summits.'],
                        ['name' => 'Logistics & Tours', 'slug' => 'travel-hospitality', 'icon' => 'fa-plane-departure', 'img' => 'photo-1502602898657-3e91760cbb34', 'desc' => 'Global hotel architecture, travel packages and hospitality.'],
                        ['name' => 'Catering Protocols', 'slug' => 'catering-marketplace', 'icon' => 'fa-utensils', 'img' => 'photo-1555244162-803834f70033', 'desc' => 'Specialized culinary units for large-scale enterprise events.'],
                        ['name' => 'Visa Clearances', 'slug' => 'visa-documentation', 'icon' => 'fa-id-card-clip', 'img' => 'photo-1544027993-37dbfe43562a', 'desc' => 'Strategic documentation and international travel authorizations.'],
                        ['name' => 'Tactical Transport', 'slug' => 'transportation-services', 'icon' => 'fa-car-side', 'img' => 'photo-1514316454349-750a7fd3da3a', 'desc' => 'Elite rentals, security protocols and terrestrial logistics.']
                    ];
                @endphp

                @foreach($mainCategories as $cat)
                <a href="{{ route('services', ['category' => $cat['slug']]) }}" class="group relative h-[420px] rounded-[2.5rem] overflow-hidden border border-white/5 shadow-2xl transition-all duration-700 hover:-translate-y-3 block">
                    <!-- Background Image -->
                    <img src="https://images.unsplash.com/{{ $cat['img'] }}?auto=format&fit=crop&w=800&q=80" 
                         class="absolute inset-0 w-full h-full object-cover transform scale-110 group-hover:scale-100 transition-transform duration-[2s]">
                    
                    <!-- Advanced Overlay -->
                    <div class="absolute inset-0 bg-[#0A192F]/40 group-hover:bg-[#0A192F]/20 transition-colors duration-700"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F] via-[#0A192F]/40 to-transparent opacity-90"></div>
                    
                    <div class="absolute inset-0 p-8 flex flex-col justify-end">
                        <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center mb-6 text-white group-hover:bg-[#ED1C24] group-hover:border-[#ED1C24] transition-all duration-700 shadow-2xl">
                            <i class="fa-solid {{ $cat['icon'] }} text-xl"></i>
                        </div>
                        
                        <div class="space-y-3">
                            <h3 class="text-2xl font-black text-white uppercase tracking-tighter leading-none">{{ $cat['name'] }}</h3>
                            <p class="text-[11px] text-white/50 font-medium leading-relaxed group-hover:text-white/80 transition-colors duration-500">
                                "{{ $cat['desc'] }}"
                            </p>
                            
                            <div class="pt-6 flex items-center gap-3 text-[#ED1C24] text-[9px] font-black uppercase tracking-[0.4em] opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500">
                                 Unlock Assets <i class="fa-solid fa-arrow-right-long group-hover:translate-x-2 transition-transform"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Technical Bottom Glow -->
                    <div class="absolute bottom-0 left-10 right-10 h-1 bg-[#ED1C24] blur-[2px] translate-y-full group-hover:translate-y-0 transition-transform duration-700"></div>
                </a>
                @endforeach
            </div>

        </div>
    </div>

    <!-- Strategic Map Nodes (Locations) -->
    <div class="py-24 bg-[#0A192F] relative overflow-hidden" x-data="{ locationTab: 'pakistan' }">
        <!-- Technical Grid Background -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(white 1px, transparent 1px); background-size: 50px 50px;"></div>
        
        <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10">
            <div class="flex flex-col lg:flex-row justify-between items-center mb-16 gap-12">
                <div class="space-y-4 text-center lg:text-left">
                    <div class="inline-flex items-center gap-3 bg-white/5 px-6 py-2 rounded-full border border-white/10 font-black text-[10px] text-white/60 uppercase tracking-[0.4em]">Global Connectivity</div>
                    <h2 class="text-4xl md:text-6xl font-black text-white tracking-tighter uppercase leading-none">
                        Strategic <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-[#ED1C24] via-white to-blue-400 ">Map Nodes</span>
                    </h2>
                </div>
                
                <div class="flex p-2 bg-white/5 backdrop-blur-3xl border border-white/10 rounded-[2rem] shadow-2xl">
                    <button @click="locationTab = 'pakistan'" 
                            :class="locationTab === 'pakistan' ? 'bg-[#ED1C24] text-white shadow-2xl shadow-[#ED1C24]/30' : 'text-white/40 hover:text-white'"
                            class="px-8 py-3 rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest transition-all duration-500">
                        Pakistan Hubs
                    </button>
                    <button @click="locationTab = 'global'" 
                            :class="locationTab === 'global' ? 'bg-[#ED1C24] text-white shadow-2xl shadow-[#ED1C24]/30' : 'text-white/40 hover:text-white'"
                            class="px-8 py-3 rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest transition-all duration-500">
                        Global Nodes
                    </button>
                </div>
            </div>

            <!-- Pakistan Grid -->
            <div x-show="locationTab === 'pakistan'" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-20" x-transition:enter-end="opacity-100 translate-y-0"
                 class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
                @php
                    $allLandmarks = $media['landmark'] ?? collect();
                    $pakLand = $allLandmarks->filter(fn($m) => ($m->meta['is_local'] ?? true));
                    $pakCities = $pakLand->isNotEmpty() ? $pakLand->map(fn($m) => [
                        'name' => $m->title, 'search' => $m->tag ?: $m->title, 'code' => $m->badge,
                        'img_url' => $m->image ? asset('storage/' . $m->image) : url('images/landmarks/lahore.png'),
                    ])->all() : [
                        ['name' => 'Lahore Hub', 'search' => 'Lahore', 'img_url' => url('images/landmarks/lahore.png'), 'code' => 'LHE-01'],
                        ['name' => 'Karachi District', 'search' => 'Karachi', 'img_url' => url('images/landmarks/karachi.png'), 'code' => 'KHI-02'],
                        ['name' => 'Islamabad Node', 'search' => 'Islamabad', 'img_url' => url('images/landmarks/islamabad.png'), 'code' => 'ISB-03'],
                        ['name' => 'Multan Core', 'search' => 'Multan', 'img_url' => url('images/landmarks/multan.png'), 'code' => 'MUX-04'],
                        ['name' => 'Faisalabad Grid', 'search' => 'Faisalabad', 'img_url' => url('images/landmarks/faisalabad.png'), 'code' => 'LYP-05'],
                    ];
                @endphp
                @foreach($pakCities as $city)
                <a href="{{ route('services', ['city' => $city['search'] ?? $city['name']]) }}" class="group relative h-[340px] rounded-[2rem] overflow-hidden border border-white/5 hover:border-[#ED1C24]/30 transition-all duration-700 block">
                    <img src="{{ $city['img_url'] }}"
                         class="w-full h-full object-cover transform scale-110 group-hover:scale-100 transition-transform duration-[2s]">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F] via-[#0A192F]/40 to-transparent opacity-90 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="absolute bottom-8 left-8 right-8 pointer-events-none">
                        <div class="text-[9px] font-black text-[#ED1C24] uppercase tracking-widest mb-2 opacity-60">{{ $city['code'] }}</div>
                        <h4 class="text-2xl font-black text-white uppercase tracking-tighter mb-4">{{ $city['name'] }}</h4>
                        <div class="w-12 h-0.5 bg-white/20 group-hover:w-full transition-all duration-700 rounded-full mb-6"></div>
                        <div class="flex items-center gap-2 text-[10px] font-black text-white uppercase tracking-widest opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500">
                            Scan Assets <i class="fa-solid fa-arrow-right-long"></i>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Global Grid -->
            <div x-show="locationTab === 'global'" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-20" x-transition:enter-end="opacity-100 translate-y-0"
                 class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
                @php
                    $globalLand = $allLandmarks->filter(fn($m) => !($m->meta['is_local'] ?? true));
                    $globalCities = $globalLand->isNotEmpty() ? $globalLand->map(fn($m) => [
                        'name' => $m->title, 'search' => $m->tag ?: $m->title, 'code' => $m->badge,
                        'img_url' => $m->image ? asset('storage/' . $m->image) : 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=600&q=80',
                    ])->all() : [
                        ['name' => 'Dubai Marina', 'search' => 'Dubai', 'img_url' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=600&q=80', 'code' => 'DXB-INT'],
                        ['name' => 'Istanbul Core', 'search' => 'Istanbul', 'img_url' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?auto=format&fit=crop&w=600&q=80', 'code' => 'IST-INT'],
                        ['name' => 'London Prime', 'search' => 'London', 'img_url' => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=600&q=80', 'code' => 'LHR-INT'],
                        ['name' => 'Kuala Lumpur', 'search' => 'Kuala Lumpur', 'img_url' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=600&q=80', 'code' => 'KUL-INT'],
                        ['name' => 'Maldives Atoll', 'search' => 'Maldives', 'img_url' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=600&q=80', 'code' => 'MLE-INT'],
                    ];
                @endphp
                @foreach($globalCities as $city)
                <a href="{{ route('services', ['city' => $city['search'] ?? $city['name']]) }}" class="group relative h-[340px] rounded-[2rem] overflow-hidden border border-white/5 hover:border-[#ED1C24]/30 transition-all duration-700 block">
                    <img src="{{ $city['img_url'] }}"
                         class="w-full h-full object-cover transform scale-110 group-hover:scale-100 transition-transform duration-[2s]">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F] via-[#0A192F]/40 to-transparent opacity-90 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="absolute bottom-8 left-8 right-8 pointer-events-none">
                        <div class="text-[9px] font-black text-[#ED1C24] uppercase tracking-widest mb-2 opacity-60">{{ $city['code'] }}</div>
                        <h4 class="text-2xl font-black text-white uppercase tracking-tighter mb-4">{{ $city['name'] }}</h4>
                        <div class="w-12 h-0.5 bg-white/20 group-hover:w-full transition-all duration-700 rounded-full mb-6"></div>
                        <div class="flex items-center gap-2 text-[10px] font-black text-white uppercase tracking-widest opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500">
                            Scan Packages <i class="fa-solid fa-arrow-right-long"></i>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>



    
    <style>
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
        }
        .reveal-visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Blob Animations */
        @keyframes float-blob-1 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        @keyframes float-blob-2 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(-30px, 50px) scale(1.1); }
            66% { transform: translate(20px, -20px) scale(0.9); }
        }
        
        .animate-blob-1 {
            animation: float-blob-1 10s infinite ease-in-out;
        }
        .animate-blob-2 {
            animation: float-blob-2 10s infinite ease-in-out;
        }
    </style>

    <!-- Scroll Animation Script -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Intersection Observer for Reveal on Scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('reveal-visible');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.reveal-on-scroll').forEach((el) => {
                observer.observe(el);
            });

            // Pakistan Services Swiper
            const pakistanSwiper = new Swiper('.pakistan-swiper', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                autoHeight: true,
                autoplay: {
                    delay: 3500,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.pakistan-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.pakistan-next',
                    prevEl: '.pakistan-prev',
                },
                breakpoints: {
                    640: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 },
                    1280: { slidesPerView: 4 },
                },
                on: {
                    init: function () {
                        if (typeof observer !== "undefined") {
                            document.querySelectorAll(".swiper-slide").forEach((el) => {
                                observer.observe(el);
                            });
                        }
                    }
                }
            });

            // Global Services Swiper
            const globalSwiper = new Swiper('.global-swiper', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                autoHeight: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.global-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.global-next',
                    prevEl: '.global-prev',
                },
                breakpoints: {
                    640: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 },
                    1280: { slidesPerView: 4 },
                },
                on: {
                    init: function () {
                        if (typeof observer !== "undefined") {
                            document.querySelectorAll(".swiper-slide").forEach((el) => {
                                observer.observe(el);
                            });
                        }
                    }
                }
            });

            // Testimonial Swiper
            const testimonialSwiper = new Swiper('.testimonial-swiper', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                autoHeight: true, // Enable auto height
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.testimonial-pagination',
                    clickable: true,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                }
            });

            // Premium Card 3D Tilt Effect
            const cards = document.querySelectorAll('.premium-card');
            cards.forEach(card => {
                card.addEventListener('mousemove', e => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    
                    const rotateX = (y - centerY) / 20;
                    const rotateY = (centerX - x) / 20;
                    
                    card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-10px) scale(1.02)`;
                });
                
                card.addEventListener('mouseleave', () => {
                    card.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(0) scale(1)`;
                });
            });
        });
    </script>
    @endpush





    <div id="home-marketplace-container">
        @include('partials.home-marketplace')
    </div>

    <!-- Strategic Infrastructure (Tech Platform) -->
    @if(($hp['hp_tech_show'] ?? '1') === '1')
    @php
        $tiles = $media['video_tile'] ?? collect();
        $tileDefaults = [
            ['icon' => 'fa-server', 'title' => 'Corporate Architecture', 'subtitle' => 'Unified command center for enterprise-scale logistics and multi-node asset tracking.', 'video' => asset('images/CORPORATE HUB.mp4'), 'poster' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=2070&auto=format&fit=crop', 'link' => ''],
            ['icon' => 'fa-brain', 'title' => 'AI Orchestrator', 'subtitle' => 'Real-time Budget Analytics', 'video' => asset('images/ai technology.mp4'), 'poster' => 'https://images.unsplash.com/photo-1620712943543-bcc4628c9bb5?q=80&w=600&auto=format&fit=crop', 'link' => route('budget-planner')],
            ['icon' => 'fa-network-wired', 'title' => 'Global Sync', 'subtitle' => 'Cross-Node Asset Locking', 'video' => asset('images/GLOBAL.mp4'), 'poster' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=600&auto=format&fit=crop', 'link' => ''],
        ];
        $vt = [];
        for ($i = 0; $i < 3; $i++) {
            $m = $tiles->get($i);
            $vt[$i] = $m ? [
                'icon'     => $m->meta['icon'] ?? $tileDefaults[$i]['icon'],
                'title'    => $m->title ?: $tileDefaults[$i]['title'],
                'subtitle' => $m->subtitle ?: $tileDefaults[$i]['subtitle'],
                'video'    => $m->video ? asset('storage/' . $m->video) : $tileDefaults[$i]['video'],
                'poster'   => $m->poster ? asset('storage/' . $m->poster) : $tileDefaults[$i]['poster'],
                'link'     => $m->link ?: $tileDefaults[$i]['link'],
            ] : $tileDefaults[$i];
        }
    @endphp
    <div class="py-24 bg-[#0A192F] relative overflow-hidden">
        <!-- Neural Map Texture -->
        <div class="absolute inset-0 opacity-5" style="background-image: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[1000px] h-[1000px] bg-blue-600/10 rounded-full blur-[200px] pointer-events-none"></div>

        <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10">
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-3 bg-white/5 px-6 py-2 rounded-full border border-white/10 mb-6 font-black text-[9px] text-white/60 uppercase tracking-[0.4em]">{{ $hp['hp_tech_badge'] ?? 'Engineered for Excellence' }}</div>
                <h2 class="text-3xl md:text-5xl font-black text-white mb-6 uppercase tracking-tighter leading-none">
                    {{ $hp['hp_tech_title'] ?? 'Mission' }} <span class="text-[#ED1C24]">{{ $hp['hp_tech_title_hl'] ?? 'Critical' }}</span> {{ $hp['hp_tech_title_end'] ?? 'Tech' }}
                </h2>
                <p class="text-base md:text-lg text-blue-100/40 font-medium max-w-3xl mx-auto uppercase tracking-widest leading-relaxed">
                    "{{ $hp['hp_tech_subtitle'] ?? 'Proprietary algorithmic ecosystem for budget orchestration and asset synchronization.' }}"
                </p>
            </div>

            <!-- Strategic Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 auto-rows-[200px]">
                <div class="md:col-span-8 row-span-2 group relative rounded-[2rem] overflow-hidden shadow-2xl bg-[#0A192F] border border-white/5">
                    <video autoplay loop muted playsinline preload="auto" poster="{{ $vt[0]['poster'] }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-80 transition-all duration-1000 z-0">
                        <source src="{{ $vt[0]['video'] }}" type="video/mp4">
                    </video>
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F] via-[#0A192F]/40 to-transparent z-10"></div>

                    <div class="absolute bottom-10 left-10 z-20">
                        <div class="w-16 h-16 bg-blue-600 rounded-[1.5rem] flex items-center justify-center mb-6 text-white shadow-2xl shadow-blue-600/30">
                            <i class="fa-solid {{ $vt[0]['icon'] }} text-2xl"></i>
                        </div>
                        <h3 class="text-3xl md:text-4xl font-black text-white mb-4 uppercase tracking-tighter">{{ $vt[0]['title'] }}</h3>
                        <p class="text-base text-blue-100/60 font-medium max-w-xl">"{{ $vt[0]['subtitle'] }}"</p>
                    </div>
                </div>

                <a href="{{ $vt[1]['link'] ?: route('budget-planner') }}" class="md:col-span-4 group relative rounded-[2rem] overflow-hidden shadow-2xl bg-[#0A192F] border border-white/5">
                    <video autoplay loop muted playsinline preload="auto" poster="{{ $vt[1]['poster'] }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-110 transition-transform duration-[6s] z-0">
                        <source src="{{ $vt[1]['video'] }}" type="video/mp4">
                    </video>
                    <div class="absolute inset-0 bg-gradient-to-br from-[#ED1C24]/30 via-transparent to-transparent z-10"></div>
                    <div class="absolute inset-0 p-8 flex flex-col justify-end z-20">
                        <div class="w-12 h-12 bg-[#ED1C24] rounded-xl flex items-center justify-center mb-4 text-white">
                            <i class="fa-solid {{ $vt[1]['icon'] }} text-lg"></i>
                        </div>
                        <h4 class="text-xl font-black text-white mb-1 uppercase tracking-tight">{{ $vt[1]['title'] }}</h4>
                        <p class="text-[10px] text-blue-100/50 font-bold uppercase tracking-widest">{{ $vt[1]['subtitle'] }}</p>
                    </div>
                </a>

                <div class="md:col-span-4 group relative rounded-[2rem] overflow-hidden shadow-2xl bg-[#0A192F] border border-white/5">
                    <video autoplay loop muted playsinline preload="auto" poster="{{ $vt[2]['poster'] }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:rotate-1 group-hover:scale-110 transition-transform duration-[7s] z-0">
                        <source src="{{ $vt[2]['video'] }}" type="video/mp4">
                    </video>
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-transparent z-10"></div>
                    <div class="absolute inset-0 p-8 flex flex-col justify-end z-20">
                        <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-4 text-white">
                            <i class="fa-solid {{ $vt[2]['icon'] }} text-lg"></i>
                        </div>
                        <h4 class="text-xl font-black text-white mb-1 uppercase tracking-tight">{{ $vt[2]['title'] }}</h4>
                        <p class="text-[10px] text-blue-100/50 font-bold uppercase tracking-widest">{{ $vt[2]['subtitle'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Partner Intel (Testimonials) -->
    @if(($hp['hp_testi_show'] ?? '1') === '1' && count($testimonialSlides))
    <div class="py-16 bg-white relative overflow-hidden">
        <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10">
            <div class="flex flex-col lg:flex-row items-end justify-between mb-12 gap-12">
                <div class="space-y-4 text-center lg:text-left">
                    <div class="inline-flex items-center gap-3 bg-[#ED1C24]/10 px-6 py-2 rounded-full border border-[#ED1C24]/10 font-black text-[9px] text-[#ED1C24] uppercase tracking-[0.4em]">{{ $hp['hp_testi_badge'] ?? 'Community Intel' }}</div>
                    <h2 class="text-3xl md:text-5xl font-black text-[#0A192F] uppercase tracking-tighter leading-none">
                        {{ $hp['hp_testi_title'] ?? 'Success' }} <span class="text-[#ED1C24]">{{ $hp['hp_testi_title_hl'] ?? 'Metrics' }}</span>
                    </h2>
                    <p class="text-base text-gray-400 font-medium uppercase tracking-widest max-w-2xl">
                        "{{ $hp['hp_testi_subtitle'] ?? 'Verified feedback from Pakistan\'s most prominent event architectures and corporate summits.' }}"
                    </p>
                </div>
            </div>
            
            <div class="swiper testimonial-swiper pb-16">
                <div class="swiper-wrapper !h-auto">
                    @foreach($testimonialSlides as $slide)
                    <div class="swiper-slide h-auto">
                        <div class="group relative bg-[#0A192F] rounded-[2rem] p-8 md:p-12 h-full flex flex-col justify-between shadow-xl border border-white/5 hover:border-[#ED1C24]/30 transition-all duration-700">
                            <i class="fa-solid fa-quote-right absolute top-8 right-8 text-4xl text-white/5"></i>
                            
                            <div class="space-y-6">
                                <div class="flex gap-1.5 text-[#ED1C24]">
                                    @for($i = 0; $i < $slide['stars']; $i++)
                                        <i class="fa-solid fa-star text-[8px]"></i>
                                    @endfor
                                </div>
                                <p class="text-blue-100/60 text-lg font-medium leading-relaxed">"{{ $slide['quote'] }}"</p>
                            </div>
                            
                            <div class="flex items-center gap-4 pt-8 border-t border-white/5 mt-8">
                                <div class="w-12 h-12 rounded-xl {{ $slide['color'] }} flex items-center justify-center text-white font-black text-lg shadow-xl shrink-0">
                                    {{ $slide['initial'] }}
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-white font-black uppercase tracking-tighter text-lg truncate">{{ $slide['name'] }}</h4>
                                    <p class="text-blue-600/60 text-[8px] font-black uppercase tracking-[0.2em] truncate">{{ $slide['role'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="testimonial-pagination mt-16 flex justify-center !static"></div>
            </div>
        </div>
    </div>
    @endif

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Neural Glow Logic
            const hero = document.getElementById('hero-container');
            const glow = document.getElementById('neural-glow');

            if (hero && glow) {
                hero.addEventListener('mousemove', (e) => {
                    const rect = hero.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    glow.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(237, 28, 36, 0.15) 0%, transparent 50%)`;
                    glow.style.opacity = '0.6';
                });

                hero.addEventListener('mouseleave', () => {
                    glow.style.opacity = '0.4';
                });
            }

            // Initialize Flatpickr
            flatpickr("#hotel-datepicker", {
                mode: "range",
                dateFormat: "Y-m-d",
                minDate: "today",
                disableMobile: "true"
            });

            flatpickr("#event-datepicker", {
                dateFormat: "Y-m-d",
                minDate: "today",
                disableMobile: "true"
            });

            flatpickr("#corporate-datepicker-refined", {
                mode: "range",
                dateFormat: "Y-m-d",
                minDate: "today",
                disableMobile: "true"
            });

            flatpickr("#travel-datepicker-architect", {
                mode: "range",
                dateFormat: "Y-m-d",
                minDate: "today",
                disableMobile: "true"
            });

            // Flight Range Picker with Inline Container
            flatpickr("#flight-range-picker", {
                mode: "range",
                dateFormat: "Y-m-d",
                inline: true,
                appendTo: document.getElementById('flight-calendar-container'),
                minDate: "today",
                onChange: function(selectedDates, dateStr, instance) {
                    // Update Alpine.js range if needed, or it handles via x-model
                }
            });

            const marketplaceContainer = document.getElementById('home-marketplace-container');
            const searchForms = document.querySelectorAll('.search-form');

            // Initialize Testimonial Swiper
            new Swiper('.testimonial-swiper', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.testimonial-pagination',
                    clickable: true,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                    }
                }
            });

            function initMarketplaceSwipers() {
                new Swiper('.pakistan-swiper', {
                    slidesPerView: 1,
                    spaceBetween: 30,
                    navigation: {
                        nextEl: '.pakistan-next',
                        prevEl: '.pakistan-prev',
                    },
                    pagination: {
                        el: '.pakistan-pagination',
                        clickable: true,
                    },
                    breakpoints: {
                        640: { slidesPerView: 2 },
                        1024: { slidesPerView: 3 },
                        1280: { slidesPerView: 4 },
                    }
                });

                new Swiper('.global-swiper', {
                    slidesPerView: 1,
                    spaceBetween: 30,
                    navigation: {
                        nextEl: '.global-next',
                        prevEl: '.global-prev',
                    },
                    pagination: {
                        el: '.global-pagination',
                        clickable: true,
                    },
                    breakpoints: {
                        640: { slidesPerView: 2 },
                        1024: { slidesPerView: 3 },
                        1280: { slidesPerView: 4 },
                    }
                });
            }

            window.initMarketplaceSwipers = initMarketplaceSwipers;
            initMarketplaceSwipers();
        });
    </script>
    @endpush
@endsection



