@extends('layouts.public')

@section('title', 'Search Results - Strategic Assets')
@section('description', 'Filtered results for your strategic event requirements.')

@section('content')
<div class="bg-gray-50 min-h-screen pt-4 pb-20">
    <div class="max-w-[1400px] mx-auto px-4 md:px-6" id="search-results-container">
        
        <!-- Active Search Protocol Header -->
        <div class="bg-white rounded-[1.5rem] md:rounded-[2.5rem] p-4 md:p-10 mb-6 md:mb-8 shadow-xl border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-slate-50 rounded-full -mr-32 -mt-32 opacity-50"></div>
            
            <div class="relative z-10">
                <div class="inline-flex items-center gap-3 bg-[#ED1C24]/10 px-4 py-1.5 rounded-full border border-[#ED1C24]/10 mb-4 font-black text-[9px] text-[#ED1C24] uppercase tracking-[0.4em]">
                    Active Search Protocol
                </div>
                
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
                    <div>
                        <h1 class="text-2xl md:text-5xl font-black text-[#0A192F] uppercase tracking-tighter leading-none mb-3">
                            Search <span class="text-[#ED1C24]">Results</span>
                        </h1>
                        <p class="text-[10px] md:text-sm text-gray-400 font-bold uppercase tracking-[0.1em] md:tracking-[0.2em]">
                            "{{ $results->count() }} Assets identified matching your operational parameters."
                        </p>
                        
                        <div class="flex flex-wrap gap-2 mt-6">
                            @if($city)
                                <span class="px-3 py-1 bg-slate-100 text-[#0A192F] rounded-lg text-[9px] font-black uppercase tracking-widest border border-slate-200"><i class="fa-solid fa-location-dot mr-1 text-[#ED1C24]"></i> {{ $city }}</span>
                            @endif
                            @if($eventType)
                                <span class="px-3 py-1 bg-slate-100 text-[#0A192F] rounded-lg text-[9px] font-black uppercase tracking-widest border border-slate-200"><i class="fa-solid fa-sparkles mr-1 text-[#ED1C24]"></i> {{ $eventType }}</span>
                            @endif
                            @if($date)
                                 <span class="px-3 py-1 bg-slate-100 text-[#0A192F] rounded-lg text-[9px] font-black uppercase tracking-widest border border-slate-200"><i class="fa-solid fa-calendar mr-1 text-[#ED1C24]"></i> {{ $date }}</span>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('home') }}#hero-container" class="w-full md:w-auto text-center px-7 py-3.5 bg-[#0A192F] text-white rounded-xl font-black uppercase tracking-widest text-[9px] hover:bg-[#ED1C24] transition-all shadow-2xl group">
                        <i class="fa-solid fa-sliders mr-2 group-hover:rotate-180 transition-transform"></i> Modify Parameters
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Mobile Tactical Bar (Map & Filters) -->
        <div class="lg:hidden flex gap-3 mb-6 sticky top-20 z-40" x-data="{ mobileFiltersOpen: false }">
            <button onclick="openMapModal()" class="flex-1 bg-white border border-gray-100 rounded-2xl py-3 px-4 shadow-lg flex items-center justify-center gap-2 text-[11px] font-black uppercase tracking-widest text-[#0A192F]">
                <i class="fa-solid fa-map-location-dot text-[#ED1C24]"></i> Area Map
            </button>
            <button @click="mobileFiltersOpen = true" class="flex-1 bg-[#0A192F] rounded-2xl py-3 px-4 shadow-lg flex items-center justify-center gap-2 text-[11px] font-black uppercase tracking-widest text-white">
                <i class="fa-solid fa-sliders"></i> Filter Assets
            </button>

            <!-- Mobile Filter Drawer -->
            <div x-show="mobileFiltersOpen" 
                 x-cloak
                 class="fixed inset-0 z-[100] bg-slate-900/60 backdrop-blur-sm"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100">
                <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-[2.5rem] shadow-2xl p-6 max-h-[90vh] overflow-y-auto"
                     @click.away="mobileFiltersOpen = false"
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="translate-y-full"
                     x-transition:enter-end="translate-y-0">
                    
                    <div class="flex justify-between items-center mb-6 border-b border-gray-50 pb-4">
                        <h3 class="font-black text-[#0A192F] uppercase tracking-wider">Mission Parameters</h3>
                        <button @click="mobileFiltersOpen = false" class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <!-- Inject Sidebar Content Here for Mobile -->
                    <div class="mt-4">
                        @include('partials.search_sidebar')
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 items-start">
            <!-- Sidebar Filters (Desktop Only) -->
            <div class="hidden lg:block w-full lg:w-1/4 flex-shrink-0 space-y-6 order-2 lg:order-1">
                <!-- Map Widget -->
                <div onclick="openMapModal()" class="bg-white rounded-[2rem] overflow-hidden shadow-lg border border-gray-100 p-2 group cursor-pointer hover:border-[#ED1C24]/30 transition-all">
                    <div class="relative h-48 rounded-[1.5rem] overflow-hidden bg-slate-200">
                        <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover opacity-60 group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <button onclick="event.stopPropagation(); openMapModal()" class="relative z-20 px-6 py-3 bg-[#0A192F] text-white rounded-xl font-bold text-xs shadow-xl group-hover:bg-[#ED1C24] transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-map-location-dot"></i> Show on Map
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white rounded-[1.5rem] md:rounded-[2rem] p-4 md:p-6 shadow-lg border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-black text-[#0A192F] uppercase tracking-wider text-sm">Filter By</h3>
                        <button type="button" onclick="updateResults('{{ route('services', ['from_hero'=>1, 'event_type'=>request('event_type'), 'city'=>request('city')]) }}')" class="text-[10px] text-gray-400 font-bold uppercase hover:text-[#ED1C24] transition-colors">Reset</button>
                    </div>

                    @include('partials.search_sidebar')
                </div>
            </div>



            <!-- Results List -->
            <div class="flex-1 order-1 lg:order-2 w-full" x-data="{ 
                view: 'grid',
                calOpen: false, 
                calServiceId: null, 
                calServiceName: '', 
                calUnavailableDates: [],
                calMonth: new Date().getMonth(),
                calYear: new Date().getFullYear(),
                calLoading: false,
                getMonthName(month) {
                    return new Intl.DateTimeFormat('en-US', { month: 'long' }).format(new Date(2000, month));
                },
                async fetchAvailability() {
                    this.calLoading = true;
                    try {
                        const response = await fetch(`/services/${this.calServiceId}/unavailable-dates`);
                        this.calUnavailableDates = await response.json();
                    } catch (e) { console.error(e); }
                    this.calLoading = false;
                },
                isReserved(day) {
                    if (!day) return false;
                    const d = new Date(this.calYear, this.calMonth, day);
                    const year = d.getFullYear();
                    const month = String(d.getMonth() + 1).padStart(2, '0');
                    const date = String(d.getDate()).padStart(2, '0');
                    const dateStr = `${year}-${month}-${date}`;
                    return this.calUnavailableDates.includes(dateStr);
                },
                isPast(day) {
                    if (!day) return false;
                    const d = new Date(this.calYear, this.calMonth, day);
                    const today = new Date();
                    today.setHours(0,0,0,0);
                    return d < today;
                },
                canGoPrev() {
                    const today = new Date();
                    return this.calYear > today.getFullYear() || (this.calYear === today.getFullYear() && this.calMonth > today.getMonth());
                },
                daysInMonth() {
                    return new Date(this.calYear, this.calMonth + 1, 0).getDate();
                },
                firstDayOfMonth() {
                    return new Date(this.calYear, this.calMonth, 1).getDay();
                },
                prevMonth() {
                    if (!this.canGoPrev()) return;
                    if (this.calMonth === 0) {
                        this.calMonth = 11;
                        this.calYear--;
                    } else {
                        this.calMonth--;
                    }
                },
                nextMonth() {
                    if (this.calMonth === 11) {
                        this.calMonth = 0;
                        this.calYear++;
                    } else {
                        this.calMonth++;
                    }
                }
            }" @open-availability.window="calServiceId = $event.detail.id; calServiceName = $event.detail.name; calOpen = true; fetchAvailability()">
                
                <!-- Ad Unit (Moved for Mobile Visibility & Positioning) -->
                <div class="bg-[#0A192F] rounded-[1.5rem] md:rounded-[2rem] p-6 md:p-8 text-center relative overflow-hidden group mb-8 max-w-2xl mx-auto lg:max-w-none">
                     <div class="absolute inset-0 bg-gradient-to-br from-[#ED1C24]/20 to-transparent"></div>
                     <div class="relative z-10">
                        <i class="fa-solid fa-gem text-3xl md:text-4xl text-[#ED1C24] mb-4"></i>
                        <h3 class="text-white font-black uppercase text-base md:text-lg mb-2">Want to Go <span class="text-[#ED1C24]">Premium?</span></h3>
                        <p class="text-blue-100/60 text-[10px] md:text-xs mb-6">Unlock exclusive VIP assets not listed publicly.</p>
                        <button class="w-full sm:w-auto px-10 py-3 bg-white text-[#0A192F] rounded-xl font-black uppercase text-[10px] tracking-widest hover:bg-[#ED1C24] hover:text-white transition-all">Upgrade Access</button>
                     </div>
                </div>

                @if($results->count() > 0)
                    <div class="flex flex-col sm:flex-row justify-between items-center sm:items-end mb-8 gap-6 text-center sm:text-left">
                        <div class="w-full sm:w-auto flex flex-col items-center sm:items-start">
                            <p class="text-xs font-bold text-gray-500 mb-3 tracking-wide">Showing all {{ $results->count() }} properties in <span class="text-[#0A192F]">{{ $city ?? 'Global' }}</span></p>
                            
                            <!-- Sort Dropdown -->
                            @php
                                $currentSort = request('sort', 'top_picks');
                                $sortOptions = [
                                    'top_picks' => 'Our top picks',
                                    'price_asc' => 'Price (lowest first)',
                                    'price_desc' => 'Price (highest first)',
                                    'rating_desc' => 'Property rating (high to low)',
                                    'rating_asc' => 'Property rating (low to high)',
                                    'reviews_desc' => 'Top reviewed'
                                ];
                            @endphp
                            <div x-data="{ open: false }" class="relative inline-block">
                                <button @click="open = !open" @click.away="open = false" class="w-full sm:w-auto flex items-center justify-between sm:justify-start gap-2 px-4 py-2 border border-blue-600 rounded-full text-xs font-bold text-[#0A192F] hover:bg-blue-50 transition-colors">
                                    <span class="flex items-center gap-2">
                                        <i class="fa-solid fa-arrow-down-up-across-line text-blue-600"></i> Sort by: {{ $sortOptions[$currentSort] ?? 'Our top picks' }}
                                    </span>
                                    <i class="fa-solid fa-chevron-down ml-1 text-[10px]"></i>
                                </button>
                                
                                <div x-show="open" x-transition.opacity class="absolute top-full left-0 mt-2 w-64 bg-white border border-gray-100 shadow-xl rounded-2xl overflow-hidden z-50">
                                    <div class="py-2">
                                        @foreach($sortOptions as $key => $label)
                                            <button type="button" @click.prevent="
                                                let u = new URL(window.location.href);
                                                u.searchParams.set('sort', '{{ $key }}');
                                                updateResults(u.toString());
                                            " class="w-full text-left px-5 py-3 text-xs font-bold hover:bg-gray-50 transition-colors {{ $currentSort === $key ? 'text-[#ED1C24] bg-red-50/50' : 'text-gray-700' }}">
                                                {{ $label }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="hidden sm:flex items-center gap-2">
                            <button @click="view = 'list'" :class="view === 'list' ? 'bg-[#0A192F] text-white' : 'bg-white border border-gray-200 text-gray-400 hover:border-[#0A192F] hover:text-[#0A192F]'" class="w-8 h-8 rounded-lg flex items-center justify-center transition-all"><i class="fa-solid fa-list-ul"></i></button>
                            <button @click="view = 'grid'" :class="view === 'grid' ? 'bg-[#0A192F] text-white' : 'bg-white border border-gray-200 text-gray-400 hover:border-[#0A192F] hover:text-[#0A192F]'" class="w-8 h-8 rounded-lg flex items-center justify-center transition-all"><i class="fa-solid fa-grip"></i></button>
                        </div>
                    </div>

                    <div :class="view === 'list' ? 'space-y-6' : 'grid grid-cols-1 md:grid-cols-2 gap-6'">
                        @foreach($results as $service)
                            <div class="bg-white rounded-[1.5rem] md:rounded-[2rem] p-4 md:p-6 border border-gray-100 shadow-lg hover:shadow-2xl hover:border-[#ED1C24]/20 transition-all duration-500 group flex gap-4 md:gap-6" :class="view === 'list' ? 'flex-col md:flex-row' : 'flex-col'">
                                <!-- Image -->
                                <div :class="view === 'list' ? 'w-full md:w-72 h-48 sm:h-64 md:h-auto' : 'w-full h-48'" class="rounded-[1.2rem] md:rounded-[1.5rem] overflow-hidden relative flex-shrink-0">
                                    <img src="{{ $service->getFeaturedImage() ? (Str::startsWith($service->getFeaturedImage(), ['http', 'https']) ? $service->getFeaturedImage() : asset('storage/' . $service->getFeaturedImage())) : 'https://images.unsplash.com/photo-1543269865-cbf427effbad?auto=format&fit=crop&w=800&q=80' }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    
                                    <div class="absolute top-4 left-4">
                                        @if($service->category)
                                            <span class="bg-[#0A192F]/90 backdrop-blur-md text-white text-[9px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg shadow-lg">
                                                {{ $service->category->name }}
                                            </span>
                                        @endif
                                    </div>
                                    <button class="absolute top-4 right-4 w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-400 hover:text-[#ED1C24] transition-colors shadow-lg">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 flex flex-col justify-between py-2">
                                    <div>
                                        <div class="flex flex-col sm:flex-row justify-between items-start mb-2 gap-2">
                                            <h3 class="text-lg md:text-2xl font-black text-[#0A192F] uppercase tracking-tight group-hover:text-[#ED1C24] transition-colors leading-tight">
                                                <a href="{{ route('services.show', $service) }}">{{ $service->name }}</a>
                                            </h3>
                                            @if($service->overall_rating)
                                                <div class="flex sm:flex-col items-center sm:items-end gap-2 sm:gap-0">
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-[10px] sm:text-sm font-bold text-[#0A192F]">{{ $service->rating_text ?? 'Excellent' }}</span>
                                                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-[#0A192F] text-white flex items-center justify-center font-black text-[10px] sm:text-xs">
                                                            {{ number_format($service->overall_rating, 1) }}
                                                        </div>
                                                    </div>
                                                    <span class="text-[9px] sm:text-[10px] text-gray-400 sm:mt-1">{{ $service->reviews_count ?? 0 }} reviews</span>
                                                </div>
                                            @endif
                                        </div>

                                        <p class="text-xs font-bold text-[#ED1C24] uppercase tracking-widest mb-3 flex items-center gap-2">
                                            <i class="fa-solid fa-location-dot"></i> {{ $service->location ?? 'Global' }}
                                            <span class="text-gray-300">|</span>
                                            <span class="text-gray-500 font-medium normal-case">1.2 km from center</span>
                                        </p>

                                        <div class="flex flex-wrap gap-2 mb-4">
                                            <span class="px-2 py-1 border border-gray-200 rounded text-[10px] font-bold text-gray-500 uppercase">Premium Service</span>
                                            <span class="px-2 py-1 border border-gray-200 rounded text-[10px] font-bold text-gray-500 uppercase">Verified</span>
                                            <span class="px-2 py-1 border border-green-200 bg-green-50 text-green-600 rounded text-[10px] font-bold uppercase">Free Cancellation</span>
                                        </div>

                                        <p class="text-xs sm:text-sm text-gray-500 line-clamp-2 mb-4" :class="view === 'list' ? 'md:w-3/4' : 'w-full'">
                                            {{ $service->description ?? 'Experience premium service with vetted professionals dedicated to your event success.' }}
                                        </p>
                                    </div>

                                    <div class="flex gap-4 border-t border-gray-100 pt-4 mt-auto" :class="view === 'list' ? 'flex-col md:flex-row items-start md:items-end justify-between' : 'flex-col items-start'">
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase">Starting Price</p>
                                            <div class="flex items-baseline gap-1">
                                                <span class="text-xs font-black text-gray-400">PKR</span>
                                                <span class="text-2xl font-black text-[#0A192F] tracking-tighter">{{ number_format($service->price) }}</span>
                                            </div>
                                            <p class="text-[9px] text-gray-400">+PKR 1,200 taxes and charges</p>
                                        </div>
                                        
                                        <div class="flex gap-2 w-full md:w-auto mt-4" :class="view === 'list' ? 'w-full md:w-auto' : 'w-full'">
                                            <a href="{{ route('services.book', $service->id) }}" class="flex-1 px-4 py-3 bg-[#0A192F] text-white rounded-xl font-black uppercase text-[10px] tracking-widest hover:bg-[#ED1C24] transition-all shadow-lg text-center">
                                                Book Now
                                            </a>
                                            <button @click="$dispatch('open-availability', {id: {{ $service->id }}, name: '{{ addslashes($service->name) }}'})" 
                                                    class="p-3 bg-slate-100 text-[#0A192F] rounded-xl hover:bg-[#ED1C24] hover:text-white transition-all shadow-lg flex items-center justify-center shrink-0">
                                                <i class="fa-solid fa-calendar-days text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Availability Calendar Modal -->
                    <div x-show="calOpen" 
                         class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-[#0A192F]/80 backdrop-blur-sm"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         x-cloak>
                        <div @click.away="calOpen = false" 
                             class="bg-white rounded-[2.5rem] w-full max-w-md overflow-hidden shadow-2xl transform transition-all"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100">
                            
                            <!-- Header -->
                            <div class="p-8 bg-[#0A192F] text-white flex justify-between items-center">
                                <div>
                                    <h3 class="text-xl font-black uppercase tracking-tighter" x-text="calServiceName"></h3>
                                    <p class="text-[10px] text-white/40 font-bold uppercase tracking-widest mt-1">Operational Availability Grid</p>
                                </div>
                                <button @click="calOpen = false" class="text-white/40 hover:text-white transition-colors">
                                    <i class="fa-solid fa-xmark text-2xl"></i>
                                </button>
                            </div>

                            <!-- Calendar Body -->
                            <div class="p-8">
                                <div class="flex justify-between items-center mb-8">
                                    <h4 class="text-lg font-black text-[#0A192F] uppercase tracking-tight">
                                        <span x-text="getMonthName(calMonth)"></span> <span x-text="calYear"></span>
                                    </h4>
                                    <div class="flex gap-2">
                                        <button @click="prevMonth()" :disabled="!canGoPrev()" :class="!canGoPrev() ? 'opacity-30 cursor-not-allowed' : ''" class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-[#0A192F] hover:bg-[#ED1C24] hover:text-white transition-all"><i class="fa-solid fa-chevron-left"></i></button>
                                        <button @click="nextMonth()" class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-[#0A192F] hover:bg-[#ED1C24] hover:text-white transition-all"><i class="fa-solid fa-chevron-right"></i></button>
                                    </div>
                                </div>

                                <!-- Grid Header -->
                                <div class="grid grid-cols-7 gap-2 text-center mb-4">
                                    <template x-for="day in ['S', 'M', 'T', 'W', 'T', 'F', 'S']">
                                        <div class="text-[10px] font-black text-gray-400 uppercase" x-text="day"></div>
                                    </template>
                                </div>

                                <!-- Calendar Grid -->
                                <div class="grid grid-cols-7 gap-2 text-center">
                                    <template x-for="i in firstDayOfMonth()">
                                        <div class="h-12"></div>
                                    </template>
                                    <template x-for="day in daysInMonth()">
                                        <div class="relative h-12 flex flex-col items-center justify-center rounded-xl border border-gray-100 group transition-all"
                                             :class="isPast(day) ? 'bg-slate-50 text-slate-300 cursor-not-allowed' : (isReserved(day) ? 'bg-red-50 border-red-100 cursor-not-allowed' : 'bg-green-50/30 border-green-100/50 hover:bg-[#ED1C24] hover:text-white cursor-pointer')">
                                            <span class="text-xs font-black" x-text="day"></span>
                                            <span class="text-[7px] font-black uppercase tracking-tighter mt-1" 
                                                  :class="isPast(day) ? 'text-slate-300' : (isReserved(day) ? 'text-[#ED1C24]' : 'text-green-600 group-hover:text-white')"
                                                  x-text="isPast(day) ? 'Past' : (isReserved(day) ? 'Reserved' : 'Available')"></span>
                                        </div>
                                    </template>
                                </div>

                                <!-- Legend -->
                                <div class="mt-8 flex justify-center gap-6 border-t border-gray-100 pt-6">
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Reserved</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Available</span>
                                    </div>
                                </div>
                            </div>

                            <div class="p-8 bg-slate-50 border-t border-gray-100">
                                <a :href="'/services/' + calServiceId + '/book'" 
                                   class="w-full py-4 bg-[#ED1C24] text-white rounded-2xl font-black uppercase text-xs tracking-[0.2em] shadow-2xl shadow-red-500/20 hover:scale-[1.02] active:scale-95 transition-all text-center block">
                                    Initialize Booking <i class="fa-solid fa-arrow-right-long ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-12">
                        {{ $results->appends(request()->query())->links() }}
                    </div>

                @else
                    <!-- No Results State -->
                    <div class="bg-white rounded-[2rem] md:rounded-[3rem] p-10 md:p-20 text-center shadow-xl border border-gray-100">
                        <div class="w-16 h-16 md:w-24 md:h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 md:mb-10 shadow-xl border border-gray-100">
                            <i class="fa-solid fa-satellite-dish text-2xl md:text-4xl text-gray-300"></i>
                        </div>
                        <h2 class="text-2xl md:text-4xl font-black text-[#0A192F] uppercase tracking-tighter mb-4 md:mb-6">No Assets Identified</h2>
                        <p class="text-gray-500 text-sm md:text-lg uppercase tracking-wide mb-8 md:mb-12">"Your specific mission parameters yielded zero results in our active network."</p>
                        <button type="button" onclick="updateResults('{{ route('services') }}')" class="w-full sm:w-auto px-12 py-5 bg-[#0A192F] text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-[#ED1C24] transition-all shadow-2xl">
                            Reset Search Protocol
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Strategic Assets Map Matrix Overlay -->
        <div id="mapOverlay" class="fixed inset-0 z-[100] bg-white opacity-0 pointer-events-none transition-all duration-700 ease-in-out translate-y-10" style="display: none;">
            <div class="absolute inset-0 flex flex-col">
                <!-- Map Header Control -->
                <div class="bg-white border-b border-gray-100 px-4 md:px-8 py-4 md:py-6 flex justify-between items-center z-[110]">
                    <div>
                        <h3 class="text-lg md:text-xl font-black text-[#0A192F] uppercase tracking-tighter">Tactical Area <span class="text-[#ED1C24]">Matrix</span></h3>
                        <p class="text-[8px] md:text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Live Asset Deployment Coordinates</p>
                    </div>
                    <button onclick="closeMapModal()" class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-[#0A192F] hover:bg-[#ED1C24] hover:text-white transition-all">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- Map Container -->
                <div id="leafletMap" class="flex-1 w-full bg-slate-100 z-10"></div>
                
                <!-- Bottom Floating Asset Summary -->
                <div class="absolute bottom-6 md:bottom-10 left-1/2 -translate-x-1/2 z-50 pointer-events-none w-[90%] md:w-auto">
                     <div class="bg-[#0A192F] text-white px-4 md:px-8 py-3 md:py-4 rounded-2xl md:rounded-3xl shadow-3xl border border-white/10 flex items-center justify-between md:justify-start gap-4 md:gap-6 backdrop-blur-3xl opacity-90">
                         <div class="flex flex-col">
                             <span class="text-[8px] font-black uppercase text-[#ED1C24] tracking-widest">Active Search</span>
                             <span class="text-xs font-bold">{{ $results->count() }} Assets Mapped</span>
                         </div>
                         <div class="h-8 w-px bg-white/10"></div>
                         <span class="text-[10px] font-bold text-blue-200 uppercase tracking-widest">{{ $city ?? 'Live Search Area' }}</span>
                     </div>
                </div>
            </div>
        </div>

        @php
            $currentMapData = $results->map(function($service) {
                $lat = 31.5204; $lng = 74.3587;
                $loc = strtolower($service->location ?? '');
                if (str_contains($loc, 'islamabad')) { $lat = 33.6844; $lng = 73.0479; }
                elseif (str_contains($loc, 'karachi')) { $lat = 24.8607; $lng = 67.0011; }
                elseif (str_contains($loc, 'multan')) { $lat = 30.1575; $lng = 71.5249; }
                elseif (str_contains($loc, 'rawalpindi')) { $lat = 33.5651; $lng = 73.0169; }
                elseif (str_contains($loc, 'faisalabad')) { $lat = 31.4504; $lng = 73.1350; }
                $lat += (rand(-300, 300) / 10000);
                $lng += (rand(-300, 300) / 10000);
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'price' => number_format($service->price),
                    'lat' => $lat, 'lng' => $lng,
                    'img' => $service->getFeaturedImage() ? (Str::startsWith($service->getFeaturedImage(), ['http', 'https']) ? $service->getFeaturedImage() : asset('storage/' . $service->getFeaturedImage())) : 'https://images.unsplash.com/photo-1543269865-cbf427effbad?auto=format&fit=crop&w=400&q=80',
                    'url' => route('services.show', $service),
                    'location' => $service->location,
                    'category' => $service->category->name ?? 'Asset'
                ];
            });
        @endphp
        <script id="map-data-json" type="application/json">@json($currentMapData)</script>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .leaflet-popup-content-wrapper {
        border-radius: 1.5rem !important;
        padding: 0 !important;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0,0,0,0.15) !important;
    }
    .leaflet-popup-content {
        margin: 0 !important;
        width: 320px !important;
    }
    .marker-pin {
        width: 40px;
        height: 40px;
        border-radius: 50% 50% 50% 0;
        background: #ED1C24;
        position: absolute;
        transform: rotate(-45deg);
        left: 50%;
        top: 50%;
        margin: -20px 0 0 -20px;
        border: 4px solid white;
        box-shadow: 0 10px 20px rgba(237, 28, 36, 0.3);
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map = null;
    let markers = [];

    function openMapModal() {
        const overlay = document.getElementById('mapOverlay');
        if (!overlay) return;
        
        overlay.style.display = 'block';
        // Force reflow
        overlay.offsetHeight;
        
        overlay.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-10');
        overlay.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
        
        document.body.style.overflow = 'hidden';
        
        if (!map) {
            setTimeout(initMap, 100);
        } else {
            setTimeout(() => map.invalidateSize(), 150);
        }
    }

    function closeMapModal() {
        const overlay = document.getElementById('mapOverlay');
        if (!overlay) return;

        overlay.classList.add('opacity-0', 'pointer-events-none', 'translate-y-10');
        overlay.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
        document.body.style.overflow = '';
        
        setTimeout(() => {
            overlay.style.display = 'none';
        }, 700);
    }

    function initMap() {
        const dataElement = document.getElementById('map-data-json');
        if (!dataElement) return;
        const assets = JSON.parse(dataElement.textContent);
        
        // Use average center or fallback to first asset
        const center = assets.length > 0 ? [assets[0].lat, assets[0].lng] : [31.5204, 74.3587];

        map = L.map('leafletMap').setView(center, 12);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
        }).addTo(map);

        assets.forEach(asset => {
            const popupHtml = `
                <div class="w-[320px] bg-white">
                    <div class="relative h-44 overflow-hidden">
                        <img src="${asset.img}" class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4">
                            <span class="bg-[#0A192F]/90 backdrop-blur-md text-white text-[8px] font-black uppercase px-2 py-1 rounded shadow-lg">${asset.category}</span>
                        </div>
                    </div>
                    <div class="p-5">
                        <h4 class="text-sm font-black text-[#0A192F] uppercase tracking-tighter mb-1">${asset.name}</h4>
                        <p class="text-[10px] text-[#ED1C24] font-bold uppercase mb-4"><i class="fa-solid fa-location-dot mr-1"></i> ${asset.location}</p>
                        <div class="flex justify-between items-center border-t border-gray-100 pt-4">
                            <div>
                                <span class="text-[8px] text-gray-400 font-bold uppercase block">Starting Price</span>
                                <span class="text-base font-black text-[#0A192F]">PKR ${asset.price}</span>
                            </div>
                            <a href="${asset.url}" class="px-4 py-2 bg-[#0A192F] text-white text-[9px] font-black rounded-lg uppercase tracking-widest hover:bg-[#ED1C24] transition-colors">Details</a>
                        </div>
                    </div>
                </div>
            `;

            const markerIcon = L.divIcon({
                className: 'custom-div-icon',
                html: "<div class='marker-pin'></div><i class='fa-solid fa-building text-white absolute' style='left: 20px; top: -14px; font-size: 10px; z-index: 100;'></i>",
                iconSize: [30, 42],
                iconAnchor: [15, 42]
            });

            L.marker([asset.lat, asset.lng], {icon: markerIcon})
                .addTo(map)
                .bindPopup(popupHtml);
        });

        // Fit bounds if more than 1 asset
        if(assets.length > 1) {
            const bounds = L.latLngBounds(assets.map(a => [a.lat, a.lng]));
            map.fitBounds(bounds, {padding: [50, 50]});
        }
    }
</script>
@endpush

<script>
    let isUpdating = false;

    // Synchronize checkboxes between mobile and desktop sidebars
    window.syncAndFilter = function(el) {
        const name = el.getAttribute('name');
        const val = el.value;
        const isChecked = el.checked;
        
        // Find ALL checkboxes with the same name and value and sync them
        document.querySelectorAll(`input[name="${name}"][value="${val}"]`).forEach(cb => {
            cb.checked = isChecked;
        });
        
        window.applyDetailsFilter();
    };

    window.applyDetailsFilter = function() {
        const url = new URL(window.location.href);
        const getChecked = (name) => Array.from(document.querySelectorAll(`input[name='${name}']:checked`)).map(cb => cb.value);
        
        const locs = getChecked('locations[]');
        const cats = getChecked('categories[]');

        // Reset pagination on any filter change
        url.searchParams.delete('page');

        // Clear existing filter params (both variations)
        ['locations', 'locations[]', 'categories', 'categories[]'].forEach(p => url.searchParams.delete(p));
        
        // Append unique checked values
        [...new Set(locs)].forEach(l => url.searchParams.append('locations[]', l));
        [...new Set(cats)].forEach(c => url.searchParams.append('categories[]', c));

        updateResults(url.toString());
    };

    async function updateResults(urlStr) {
        if (isUpdating) return;
        isUpdating = true;

        const container = document.getElementById('search-results-container');
        if (!container) {
            window.location.href = urlStr;
            return;
        }

        // Visual feedback
        container.style.opacity = '0.5';
        container.style.pointerEvents = 'none';

        try {
            // Update the browser URL without reloading
            window.history.pushState({}, '', urlStr);

            // Fetch the updated HTML
            const response = await fetch(urlStr);
            const html = await response.text();

            // Parse returned HTML
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            const newContent = doc.getElementById('search-results-container');
            
            if(newContent) {
                if (typeof map !== 'undefined' && map !== null) {
                    map.remove();
                    map = null;
                }
                // Replace content
                container.innerHTML = newContent.innerHTML;
            } else {
                console.error("Could not find the new content container.");
                window.location.href = urlStr; // Fallback to normal navigation
            }
        } catch(error) {
            console.error("AJAX Fetch failed, falling back to page reload:", error);
            window.location.href = urlStr; 
        } finally {
            container.style.opacity = '1';
            container.style.pointerEvents = 'auto';
            isUpdating = false;
        }
    }
</script>
@endsection
