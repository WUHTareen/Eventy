@extends('layouts.public')

@section('title', 'Strategic Portfolio (Services)')
@section('description', 'Pakistan\'s premier neural network for global events, business hospitality, and strategic logistics.')

@section('content')
    <!-- Orchestration Protocol (Hero) -->
    <div class="relative pt-40 pb-48 overflow-hidden bg-[#0A192F]">
        <!-- Strategic Background Architecture -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1540575861501-7cf05a4b125a?auto=format&fit=crop&w=2000&q=80" alt="Asset Network" class="w-full h-full object-cover opacity-10 filter grayscale contrast-125">
            <div class="absolute inset-0 bg-gradient-to-b from-[#0A192F]/50 via-[#0A192F]/80 to-[#0A192F]"></div>
        </div>
        <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 60px 60px;"></div>
        
        <div class="max-w-[1400px] mx-auto px-6 relative z-10 text-center">
            <div class="inline-flex items-center gap-3 bg-white/5 backdrop-blur-3xl px-6 py-2 rounded-full border border-white/10 mb-12 transform hover:scale-105 transition-all cursor-default group">
                <span class="w-2 h-2 rounded-full bg-[#ED1C24] group-hover:animate-ping"></span>
                <span class="text-[10px] font-black text-white uppercase tracking-[0.4em]">Strategic Asset Portfolio v4.0.0</span>
            </div>
            
            <h1 class="text-5xl md:text-9xl font-black text-white mb-10 tracking-tighter uppercase leading-[0.85]">
                Asset <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#ED1C24] via-white to-blue-400 ">Portfolio</span>
            </h1>
            
            <p class="text-blue-100/40 text-lg md:text-2xl font-medium max-w-4xl mx-auto  leading-relaxed">
                "Curating Pakistan's most sophisticated network of premium vendors and logistical architects for high-stakes execution."
            </p>
        </div>
    </div>

    <!-- Operations Hub -->
    <div class="py-32 bg-white" x-init="initSwiper()" x-data="{ 
        loading: false,
        showFilters: false,
        search: '{{ request('search') }}',
        category: '{{ request('category') }}',
        minPrice: '{{ request('min_price', '') }}',
        maxPrice: '{{ request('max_price', '') }}',
        rating: '{{ request('rating', '') }}',
        city: '{{ request('city', '') }}',
        eventType: '{{ request('event_type', '') }}',

        initSwiper() {
            this.$nextTick(() => {
                setTimeout(() => {
                    // Force destroy existing instances to prevent duplicates
                    const destroySelectors = ['.pakistan-services-swiper', '.global-services-swiper'];
                    destroySelectors.forEach(sel => {
                        const el = document.querySelector(sel);
                        if (el && el.swiper) el.swiper.destroy(true, true);
                    });

                    window.pakSwiper = new Swiper('.pakistan-services-swiper', {
                        slidesPerView: 1,
                        spaceBetween: 30,
                        loop: false,
                        speed: 800,
                        watchSlidesProgress: true,
                        grabCursor: true,
                        navigation: {
                            nextEl: '.pakistan-next',
                            prevEl: '.pakistan-prev',
                        },
                        pagination: {
                            el: '.pakistan-pagination',
                            clickable: true,
                            dynamicBullets: true,
                        },
                        breakpoints: {
                            640: { slidesPerView: 2 },
                            1024: { slidesPerView: 3 },
                            1400: { slidesPerView: 4 }
                        }
                    });

                    window.globSwiper = new Swiper('.global-services-swiper', {
                        slidesPerView: 1,
                        spaceBetween: 30,
                        loop: false,
                        speed: 800,
                        watchSlidesProgress: true,
                        grabCursor: true,
                        navigation: {
                            nextEl: '.global-next',
                            prevEl: '.global-prev',
                        },
                        pagination: {
                            el: '.global-pagination',
                            clickable: true,
                            dynamicBullets: true,
                        },
                        breakpoints: {
                            640: { slidesPerView: 2 },
                            1024: { slidesPerView: 3 },
                            1400: { slidesPerView: 4 }
                        }
                    });
                }, 100);
            });
        },

        async fetchData(url) {
            this.loading = true;
            try {
                const response = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();
                document.getElementById('services-grid-container').innerHTML = html;
                window.history.pushState({}, '', url);
                this.initSwiper();
                // document.getElementById('services-grid-container').scrollIntoView({ behavior: 'smooth', block: 'start' });
            } catch (error) {
                console.error('Network Error:', error);
            } finally {
                this.loading = false;
            }
        },
        applyFilters() {
            const url = new URL('{{ route('services') }}');
            if (this.search) url.searchParams.set('search', this.search);
            if (this.category) url.searchParams.set('category', this.category);
            if (this.minPrice) url.searchParams.set('min_price', this.minPrice);
            if (this.maxPrice) url.searchParams.set('max_price', this.maxPrice);
            if (this.rating) url.searchParams.set('rating', this.rating);
            if (this.city) url.searchParams.set('city', this.city);
            if (this.eventType) url.searchParams.set('event_type', this.eventType);
            this.fetchData(url.toString());
        },
        resetFilters() {
            this.search = '';
            this.category = '';
            this.minPrice = '';
            this.maxPrice = '';
            this.rating = '';
            this.city = '';
            this.eventType = '';
            this.applyFilters();
        }
    }">
        <div class="max-w-[1400px] mx-auto px-6">
            <!-- Sector Matrix (Category Carousel) -->
            <div class="mb-32 relative" x-data="categoryCarousel()">
                @php
                    $categoryStyles = [
                        'Event Management & Production' => ['icon' => 'fa-calendar-check', 'image' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=600&q=80'],
                        'Exhibitions, Expos & Stall Solutions' => ['icon' => 'fa-building-columns', 'image' => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?auto=format&fit=crop&w=600&q=80'],
                        'Conferences & Summits' => ['icon' => 'fa-users-rectangle', 'image' => 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?auto=format&fit=crop&w=600&q=80'],
                        'Travel, Tours & Hospitality Services' => ['icon' => 'fa-plane-departure', 'image' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=600&q=80'],
                        'Flight Booking & Ticketing' => ['icon' => 'fa-ticket', 'image' => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?auto=format&fit=crop&w=600&q=80'],
                        'Catering & Food Services' => ['icon' => 'fa-utensils', 'image' => 'https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&w=600&q=80'],
                        'Cab, Transport & Logistics Services' => ['icon' => 'fa-car', 'image' => 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?auto=format&fit=crop&w=600&q=80'],
                        'Venue Booking & Coordination' => ['icon' => 'fa-door-open', 'image' => 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&w=600&q=80'],
                        'Brand Activations, Marketing & Media' => ['icon' => 'fa-camera-retro', 'image' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=600&q=80'],
                        'Event Branding, Design & Creative' => ['icon' => 'fa-pen-nib', 'image' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=600&q=80'],
                        'Vendor, Manpower & Operations' => ['icon' => 'fa-handshake', 'image' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=600&q=80'],
                        'Government, CSR & Mega Projects' => ['icon' => 'fa-landmark', 'image' => 'https://images.unsplash.com/photo-1529107386315-e1a2ed48a620?auto=format&fit=crop&w=600&q=80'],
                    ];
                @endphp

                <!-- Strategic Navigation -->
                <button @click="prev()" class="absolute -left-10 top-1/2 -translate-y-1/2 z-30 w-16 h-16 rounded-3xl bg-white shadow-2xl flex items-center justify-center text-[#0A192F] hover:bg-[#ED1C24] hover:text-white transition-all duration-500 border border-gray-100 hidden md:flex hover:scale-105 active:scale-95 group">
                    <i class="fa-solid fa-arrow-left text-lg group-hover:-translate-x-1 transition-transform"></i>
                </button>

                <div class="overflow-hidden py-10" @mouseenter="pauseAutoSlide()" @mouseleave="resumeAutoSlide()">
                    <div x-ref="slider" class="flex gap-8 transition-transform duration-700 cubic-bezier(0.25, 1, 0.5, 1)" :style="window.innerWidth >= 768 ? `transform: translateX(-${currentSlide * slideWidth}px)` : ''">
                        
                        <!-- Core Hub Module -->
                        <button @click="handleCategory('')" 
                           class="flex-shrink-0 w-[320px] h-[200px] rounded-[3rem] bg-[#0A192F] text-white relative overflow-hidden transition-all duration-700 group shadow-2xl border border-white/5"
                           :class="!category ? 'ring-4 ring-[#ED1C24] ring-offset-8 scale-95' : 'hover:scale-[1.05]'">
                            <img src="https://images.unsplash.com/photo-1505236858219-8359eb29e329?auto=format&fit=crop&w=600&q=80" class="absolute inset-0 w-full h-full object-cover opacity-30 filter grayscale group-hover:grayscale-0 transition-transform duration-[3s]">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F] via-transparent to-transparent"></div>
                            
                            <div class="absolute inset-0 p-10 flex flex-col justify-between items-start z-10 text-left">
                                <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center backdrop-blur-3xl border border-white/20 group-hover:rotate-12 transition-transform shadow-2xl">
                                    <i class="fa-solid fa-microchip text-xl"></i>
                                </div>
                                <div>
                                    <span class="block text-[8px] font-black uppercase tracking-[0.5em] text-white/40 mb-2">Network Hub</span>
                                    <span class="block text-2xl font-black uppercase tracking-tighter leading-none">Universal <br/>Portfolio</span>
                                </div>
                            </div>
                        </button>

                        @foreach($categories as $cat)
                            @php $style = $categoryStyles[$cat->name] ?? ['icon' => 'fa-cube', 'image' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=600&q=80']; @endphp
                            <button @click="handleCategory('{{ $cat->slug }}')" 
                               class="flex-shrink-0 w-[320px] h-[200px] rounded-[3rem] bg-gray-50 border border-gray-100 relative overflow-hidden transition-all duration-700 group shadow-2xl"
                               :class="category == '{{ $cat->slug }}' ? 'ring-4 ring-[#ED1C24] ring-offset-8 scale-95' : 'hover:scale-[1.05]'">
                                
                                <img src="{{ $style['image'] }}" class="absolute inset-0 w-full h-full object-cover opacity-80 filter grayscale group-hover:grayscale-0 transition-transform duration-[3s]">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F] via-[#0A192F]/20 to-transparent"></div>

                                <div class="absolute inset-0 p-10 flex flex-col justify-between items-start z-10 text-left">
                                    <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-3xl border border-white/20 text-white flex items-center justify-center group-hover:bg-[#ED1C24] transition-all duration-700 shadow-2xl">
                                        <i class="fa-solid {{ $style['icon'] }} text-lg"></i>
                                    </div>
                                    
                                    <div>
                                        <span class="block text-[8px] font-black uppercase tracking-[0.5em] text-white/40 mb-2">Strategic Sector</span>
                                        <span class="block text-2xl font-black text-white leading-tight uppercase tracking-tighter">
                                            {{ $cat->name }}
                                        </span>
                                    </div>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>

                <button @click="next()" class="absolute -right-10 top-1/2 -translate-y-1/2 z-30 w-16 h-16 rounded-3xl bg-white shadow-2xl flex items-center justify-center text-[#0A192F] hover:bg-[#ED1C24] hover:text-white transition-all duration-500 border border-gray-100 hidden md:flex hover:scale-105 active:scale-95 group">
                    <i class="fa-solid fa-arrow-right text-lg group-hover:translate-x-1 transition-transform"></i>
                </button>
            </div>

            <!-- Executive Search Engine -->
            <div class="max-w-6xl mx-auto mb-32">
                <form @submit.prevent="applyFilters" class="flex flex-col md:flex-row gap-4 items-stretch p-3 md:p-4 bg-white rounded-[3rem] md:rounded-[4rem] border border-gray-100 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)]">
                    <div class="flex-1 relative group/search flex items-center min-h-[80px] md:min-h-auto">
                        <i class="fa-solid fa-network-wired absolute left-8 text-[#ED1C24] text-xl group-focus-within/search:scale-110 transition-transform"></i>
                        <input type="text" x-model="search" placeholder="Enter service protocol / intel..." 
                            class="w-full pl-20 pr-10 py-8 border-0 focus:ring-0 font-black text-lg text-[#0A192F] placeholder-gray-300 uppercase tracking-tighter" />
                    </div>
                    
                    <div class="h-auto w-px bg-gray-50 hidden md:block my-4"></div>

                    <div class="flex flex-col md:flex-row gap-4 p-4 md:p-0">
                        <button type="button" @click="showFilters = !showFilters" 
                                :class="showFilters ? 'bg-[#0A192F] text-white' : 'bg-gray-50 text-gray-400'"
                                class="px-10 py-6 rounded-3xl font-black uppercase tracking-[0.3em] text-[10px] transition-all flex items-center justify-center gap-4 hover:shadow-2xl active:scale-95">
                            <i class="fa-solid fa-sliders"></i>
                            <span x-text="showFilters ? 'Protocol Open' : 'Configure Ops'"></span>
                        </button>
                        
                        <button type="submit" class="px-12 py-6 rounded-3xl bg-[#ED1C24] text-white font-black uppercase tracking-[0.4em] shadow-2xl shadow-[#ED1C24]/30 hover:bg-[#0A192F] transition-all flex items-center justify-center gap-4 active:scale-95 text-[10px]" :disabled="loading">
                             <span x-text="loading ? 'Authenticating...' : 'Submit Mission'"></span>
                             <i class="fa-solid fa-satellite-dish  text-xs animate-pulse" x-show="loading"></i>
                             <i class="fa-solid fa-arrow-right-long text-xs" x-show="!loading"></i>
                        </button>
                    </div>
                </form>

                <!-- Strategic Filter Panel -->
                <div x-show="showFilters" 
                     x-transition:enter="transition cubic-bezier(0.23, 1, 0.32, 1) duration-700"
                     x-transition:enter-start="opacity-0 -translate-y-12"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-cloak
                     class="mt-12 p-12 bg-gray-50 rounded-[4rem] border border-gray-100 shadow-2xl">
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                        <div class="space-y-4">
                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-4 block">Fee Matrix (PKR)</label>
                            <div class="flex items-center gap-4">
                                <input type="number" x-model="minPrice" placeholder="0" class="w-full bg-white border-0 rounded-2xl px-6 py-4 text-xs font-black focus:ring-4 focus:ring-[#ED1C24]/10 transition-all shadow-sm">
                                <span class="text-gray-200">/</span>
                                <input type="number" x-model="maxPrice" placeholder="5M" class="w-full bg-white border-0 rounded-2xl px-6 py-4 text-xs font-black focus:ring-4 focus:ring-[#ED1C24]/10 transition-all shadow-sm">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-4 block">Deployment Node</label>
                            <select x-model="city" class="w-full bg-white border-0 rounded-2xl px-6 py-4 text-xs font-black focus:ring-4 focus:ring-[#ED1C24]/10 transition-all shadow-sm appearance-none cursor-pointer">
                                <option value="">Global Operations</option>
                                @foreach($cities as $c)
                                    <option value="{{ $c->slug }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-4">
                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-4 block">Asset Quality</label>
                            <select x-model="rating" class="w-full bg-white border-0 rounded-2xl px-6 py-4 text-xs font-black focus:ring-4 focus:ring-[#ED1C24]/10 transition-all shadow-sm appearance-none cursor-pointer">
                                <option value="">Unfiltered</option>
                                <option value="4.5">4.5+ Elite Tier</option>
                                <option value="4.0">4.0+ Prime Tier</option>
                            </select>
                        </div>

                        <div class="space-y-4">
                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-4 block">Protocol Alignment</label>
                            <select x-model="eventType" class="w-full bg-white border-0 rounded-2xl px-6 py-4 text-xs font-black focus:ring-4 focus:ring-[#ED1C24]/10 transition-all shadow-sm appearance-none cursor-pointer">
                                <option value="">Universal Mode</option>
                                <option value="Wedding">Wedding Heritage</option>
                                <option value="Corporate">Corporate Elite</option>
                                <option value="Exhibition">Exhibition Logistics</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-12 pt-10 border-t border-gray-200 flex justify-between items-center">
                        <button @click="resetFilters" class="text-[9px] font-black text-[#ED1C24] uppercase tracking-[0.3em] hover:text-[#0A192F] transition-colors border-b-2 border-[#ED1C24]/20 pb-1">Reset Specifications</button>
                        <button @click="applyFilters" class="px-12 py-5 bg-[#0A192F] text-white rounded-[1.5rem] font-black text-[9px] uppercase tracking-[0.3em] shadow-2xl hover:bg-blue-600 transition-all">Establish Protocol</button>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-end gap-10 mb-20">
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-[2px] bg-[#0A192F]"></div>
                        <h2 class="text-[10px] font-black text-[#0A192F] uppercase tracking-[0.5em]">Active Portfolio</h2>
                    </div>
                    <h3 class="text-4xl md:text-6xl font-black text-[#0A192F] tracking-tighter uppercase" x-text="category ? 'Bespoke ' + category.replace('-', ' ') : 'All Creations'"></h3>
                </div>
            </div>

            <!-- Asset Grid Output -->
            <div id="services-grid-container" class="relative min-h-[600px]">
                @include('partials.services-grid')
            </div>
        </div>
    </div>

    <!-- Master CTA Protocol -->
    <div class="py-40 bg-[#0A192F] relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/20 via-[#ED1C24]/5 to-transparent"></div>
        <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255,255,255,0.02) 1px, transparent 1px); background-size: 40px 40px;"></div>
        
        <div class="max-w-5xl mx-auto px-6 text-center relative z-10 space-y-16">
            <h2 class="text-5xl md:text-8xl font-black text-white tracking-tighter uppercase leading-[0.85]">
                Custom <br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#ED1C24] to-white ">Orchestration</span>
            </h2>
            <p class="text-xl md:text-2xl text-blue-100/40 font-medium max-w-3xl mx-auto  leading-relaxed uppercase tracking-widest">
                "Our elite logistics unit is ready to engineer bespoke service protocols for mission-critical enterprise assignments."
            </p>
            <div class="flex flex-col md:flex-row items-center justify-center gap-10">
                <a href="{{ route('contact') }}" class="group relative px-16 py-8 bg-[#ED1C24] text-white rounded-[2rem] font-black uppercase tracking-[0.5em] text-[10px] shadow-2xl shadow-[#ED1C24]/30 hover:scale-105 transition-all">
                    Initiate Hub Link
                </a>
                <a href="/corporate" class="px-16 py-8 bg-white/5 text-white border border-white/10 rounded-[2rem] font-black uppercase tracking-[0.5em] text-[10px] hover:bg-white/10 transition-all backdrop-blur-3xl">
                    Corporate Intel
                </a>
            </div>
        </div>
    </div>

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        .swiper-slide { height: auto !important; }
        .pakistan-pagination .swiper-pagination-bullet,
        .global-pagination .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: #0A192F;
            opacity: 0.1;
            transition: all 0.3s;
            border-radius: 4px;
        }
        .pakistan-pagination .swiper-pagination-bullet-active {
            background: #ED1C24 !important;
            opacity: 1 !important;
            width: 30px !important;
        }
        .global-pagination .swiper-pagination-bullet-active {
            background: #2563eb !important;
            opacity: 1 !important;
            width: 30px !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        function categoryCarousel() {
            return {
                currentSlide: 0,
                slideWidth: 352, // 320px width + 32px gap
                totalSlides: 1,
                autoSlideInterval: null,
                isPaused: false,
                init() {
                    this.$nextTick(() => {
                        this.calculateSlides();
                        this.startAutoSlide();
                        window.addEventListener('resize', () => this.calculateSlides());
                    });
                },
                calculateSlides() {
                    const container = this.$refs.slider;
                    if (!container) return;
                    const containerWidth = container.parentElement.offsetWidth;
                    const totalWidth = container.scrollWidth;
                    this.totalSlides = Math.ceil((totalWidth - containerWidth) / this.slideWidth) + 1;
                },
                next() {
                    if (this.currentSlide < this.totalSlides) this.currentSlide++;
                    else this.currentSlide = 0;
                },
                prev() {
                    if (this.currentSlide > 0) this.currentSlide--;
                    else this.currentSlide = this.totalSlides;
                },
                startAutoSlide() {
                    this.autoSlideInterval = setInterval(() => {
                        if (!this.isPaused && window.innerWidth >= 768) this.next();
                    }, 4000);
                },
                pauseAutoSlide() { this.isPaused = true; },
                resumeAutoSlide() { this.isPaused = false; },
                handleCategory(slug) {
                    // Call the parent Alpine component's applyFilters if needed
                    this.$parent.category = slug;
                    this.$parent.applyFilters();
                }
            }
        }
    </script>
@endpush
@endsection


