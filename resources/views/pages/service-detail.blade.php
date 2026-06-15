@extends('layouts.public')

@section('title', $service->name . ' - Eventy')
@section('description', Str::limit($service->description, 160))

@section('content')
<div class="bg-[#F8FAFC] min-h-screen pt-28 pb-12">
    <div class="max-w-[1240px] mx-auto px-6">
        
        <!-- Standard Breadcrumbs -->
        <nav class="flex mb-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
            <a href="{{ route('home') }}" class="hover:text-[#ED1C24]">Hub</a>
            <span class="mx-3 opacity-30">/</span>
            <a href="{{ route('services') }}" class="hover:text-[#ED1C24]">Services</a>
            @if($service->category)
                <span class="mx-3 opacity-30">/</span>
                <span class="text-slate-900">{{ $service->category->name }}</span>
            @endif
        </nav>

        <!-- Header: Elite Theme & Standard Size -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
            <div class="max-w-4xl">
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-3 py-1 bg-[#0A192F] text-white text-[9px] font-black uppercase tracking-widest rounded-lg shadow-lg">Verified Asset</span>
                    @if($service->is_featured)
                        <span class="px-3 py-1 bg-[#ED1C24] text-white text-[9px] font-black uppercase tracking-widest rounded-lg shadow-lg">Featured</span>
                    @endif
                </div>
                <h1 class="text-3xl md:text-5xl font-black text-[#0A192F] tracking-tighter uppercase leading-[0.95]">
                    {{ $service->name }}
                </h1>
                <div class="flex flex-wrap items-center gap-6 mt-4">
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-500 uppercase tracking-wider">
                        <i class="fa-solid fa-location-dot text-[#ED1C24]"></i>
                        {{ $service->location }}
                    </div>
                    <div class="flex items-center gap-1.5 bg-white px-3 py-1 rounded-full border border-slate-100 shadow-sm">
                        <i class="fa-solid fa-star text-[#ED1C24] text-[10px]"></i>
                        <span class="text-xs font-black text-[#0A192F]">{{ number_format($service->averageRating(), 1) }}</span>
                        <span class="text-[10px] text-slate-400 uppercase font-bold">({{ $service->reviewCount() }} reviews)</span>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-2 shrink-0 pb-1">
                <button class="w-11 h-11 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 hover:text-[#ED1C24] hover:bg-slate-50 transition-all shadow-sm">
                    <i class="fa-regular fa-heart"></i>
                </button>
                <button onclick="navigator.clipboard.writeText('{{ url()->current() }}')" class="w-11 h-11 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 hover:text-[#ED1C24] hover:bg-slate-50 transition-all shadow-sm">
                    <i class="fa-solid fa-share-nodes"></i>
                </button>
            </div>
        </div>

        <!-- Premium Gallery: Precise & Professional -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 mb-10 h-[450px]">
            @php 
                $allImages = $service->getAllImages();
                $featured = $allImages[0] ?? null;
                $others = array_slice($allImages, 1, 4);
            @endphp
            
            <div class="md:col-span-7 h-full relative group cursor-pointer overflow-hidden rounded-[1.5rem] shadow-xl border-4 border-white">
                <img src="{{ Str::startsWith($featured, ['http', 'https']) ? $featured : asset('storage/' . $featured) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F]/40 to-transparent"></div>
            </div>

            <div class="md:col-span-5 grid grid-cols-2 gap-3 h-full">
                @foreach($others as $img)
                    <div class="relative group cursor-pointer overflow-hidden rounded-[1.2rem] shadow-md border-2 border-white">
                        <img src="{{ Str::startsWith($img, ['http', 'https']) ? $img : asset('storage/' . $img) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    </div>
                @endforeach
                @if(count($others) < 4)
                    @for($i = 0; $i < (4 - count($others)); $i++)
                        <div class="flex flex-col items-center justify-center bg-white rounded-[1.2rem] border-2 border-dashed border-slate-200 opacity-50">
                            <i class="fa-solid fa-camera-retro text-slate-300 text-2xl mb-2"></i>
                            <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Asset Node</span>
                        </div>
                    @endfor
                @endif
            </div>
        </div>

        <!-- Main Workspace -->
        <div class="grid lg:grid-cols-12 gap-8 items-start" x-data="{ 
            basePrice: {{ $service->price ?? 0 }},
            selectedAddons: [],
            totalPrice() {
                let total = this.basePrice;
                this.selectedAddons.forEach(a => total += parseInt(a.price));
                return total;
            }
        }">
            
            <!-- Left: Strategic Documentation -->
            <div class="lg:col-span-8 space-y-8">
                
                <!-- Event Intelligence Overview -->
                <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-[#ED1C24]/5 to-transparent"></div>
                    
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-14 h-14 rounded-2xl bg-[#0A192F] text-white flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-magnifying-glass-chart text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-[#0A192F] uppercase tracking-tighter">Event Intelligence</h2>
                            <p class="text-[9px] font-black text-[#ED1C24] uppercase tracking-widest">Operational Summary</p>
                        </div>
                    </div>

                    <p class="text-slate-500 font-medium text-[14px] leading-relaxed uppercase tracking-wider text-justify mb-8">
                        {{ $service->description }}
                    </p>

                    <!-- Tactical Features Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-8 border-t border-slate-50">
                        @php
                            $eventSpecs = [
                                ['icon' => 'fa-users', 'label' => 'Capacity', 'val' => '500+ Nodes'],
                                ['icon' => 'fa-clock', 'label' => 'Duration', 'val' => 'Flexible'],
                                ['icon' => 'fa-shield-halved', 'label' => 'Protocol', 'val' => 'Full Vetted'],
                                ['icon' => 'fa-headset', 'label' => 'Support', 'val' => '24/7 Command'],
                            ];
                        @endphp
                        @foreach($eventSpecs as $spec)
                        <div class="flex flex-col items-center text-center p-4 bg-slate-50/50 rounded-2xl border border-slate-50">
                            <i class="fa-solid {{ $spec['icon'] }} text-[#ED1C24] mb-3"></i>
                            <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ $spec['label'] }}</span>
                            <span class="text-[10px] font-black text-[#0A192F] uppercase">{{ $spec['val'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tiers & Deployment Plans -->
                @if(!empty($service->packages))
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-[3px] bg-[#ED1C24] rounded-full"></div>
                        <h3 class="text-lg font-black text-[#0A192F] uppercase tracking-widest">Strategic Tiers</h3>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach($service->packages as $pkg)
                        <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-sm hover:border-[#ED1C24]/30 hover:shadow-xl hover:-translate-y-1 transition-all group">
                            <div class="flex justify-between items-start mb-6">
                                <span class="px-3 py-1 bg-slate-100 text-[#0A192F] text-[8px] font-black uppercase tracking-widest rounded-full group-hover:bg-[#ED1C24] group-hover:text-white transition-all">Package Node</span>
                                <div class="text-right">
                                    <span class="text-xs font-medium text-slate-400">PKR</span>
                                    <span class="text-2xl font-black text-[#0A192F] tracking-tighter">{{ number_format($pkg['price']) }}</span>
                                </div>
                            </div>
                            <h4 class="font-black text-[#0A192F] uppercase mb-2">{{ $pkg['name'] }}</h4>
                            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest leading-relaxed mb-6">{{ $pkg['description'] ?? 'Integrated event protocol execution.' }}</p>
                            <a href="{{ route('services.book', ['service' => $service, 'tier' => $pkg['name']]) }}" class="w-full py-4 bg-[#0A192F] text-white rounded-xl text-[10px] font-black uppercase tracking-[0.2em] flex items-center justify-center gap-3 transition-all hover:bg-[#ED1C24]">Initialize Plan</a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Managed By Account -->
                @if($service->user)
                <div class="bg-[#0A192F] rounded-[2rem] p-8 text-white relative overflow-hidden group">
                    <div class="absolute right-0 top-0 w-48 h-full bg-gradient-to-l from-white/5 to-transparent"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-16 rounded-2xl border-2 border-white/20 overflow-hidden shadow-2xl">
                                <img src="{{ $service->user->getAvatarUrl() }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-white/40 uppercase tracking-[0.4em] mb-1">Authenticated Architect</p>
                                <h4 class="text-xl font-black uppercase tracking-tighter">{{ $service->user->name }}</h4>
                                <div class="flex items-center gap-2 mt-1">
                                    <i class="fa-solid fa-certificate text-[#ED1C24] text-xs"></i>
                                    <span class="text-[8px] font-black uppercase tracking-widest text-[#ED1C24]">Elite Tier Vendor</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('vendors.show', $service->user) }}" class="px-6 py-3 bg-white text-[#0A192F] rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-[#ED1C24] hover:text-white transition-all">View Archive</a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right: Command Center -->
            <div class="lg:col-span-4 sticky top-28 space-y-6">
                <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-2xl shadow-slate-200/50">
                    
                    <div class="pb-6 border-b border-slate-100 mb-8">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Asset valuation</p>
                        <div class="flex items-end gap-2">
                            <span class="text-xs font-black text-[#ED1C24] mb-2 uppercase">PKR</span>
                            <span class="text-4xl font-black text-[#0A192F] tracking-tighter" x-text="new Intl.NumberFormat().format(totalPrice())"></span>
                        </div>
                        <p class="text-[8px] font-bold text-slate-400 mt-2 uppercase tracking-widest">Inclusive of all standard protocols</p>
                    </div>

                    <!-- Module Selectors -->
                    @if(!empty($service->add_ons))
                    <div class="space-y-4 mb-8">
                        <p class="text-[9px] font-black text-[#0A192F] uppercase tracking-[0.3em]">Operational Modules</p>
                        <div class="space-y-2">
                            @foreach($service->add_ons as $addon)
                            <label class="flex items-center justify-between p-3 bg-slate-50 border border-slate-100 rounded-2xl cursor-pointer hover:border-[#ED1C24]/30 transition-all group"
                                   x-data="{ active: false }" @click="active = !active; if(active) selectedAddons.push({name: '{{$addon['name']}}', price: {{$addon['price']}} }); else selectedAddons = selectedAddons.filter(a => a.name !== '{{$addon['name']}}')"
                                   :class="active ? 'bg-red-50/50 border-[#ED1C24]/20' : ''">
                                <div class="flex items-center gap-3">
                                    <div class="w-7 h-7 bg-white rounded-lg flex items-center justify-center text-[10px] shadow-sm border border-slate-100 transition-all"
                                         :class="active ? 'bg-[#ED1C24] text-white border-transparent' : 'text-slate-300'">
                                        <i class="fa-solid fa-plus"></i>
                                    </div>
                                    <span class="text-[10px] font-black text-[#0A192F] uppercase tracking-tighter">{{ $addon['name'] }}</span>
                                </div>
                                <span class="text-[9px] font-black text-[#ED1C24] uppercase">+{{ number_format($addon['price']) }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Deployment Buttons -->
                    <div class="space-y-3">
                        @auth
                            <a href="{{ route('services.book', $service) }}" class="w-full py-5 bg-[#ED1C24] text-white rounded-2xl font-black text-[11px] uppercase tracking-widest shadow-xl shadow-red-500/20 flex items-center justify-center gap-3 transition-all hover:bg-[#0A192F] hover:scale-[1.03] active:scale-95">
                                Initiate Deployment <i class="fa-solid fa-arrow-right-long text-[10px]"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="w-full py-5 bg-[#0A192F] text-white rounded-2xl font-black text-[11px] uppercase tracking-widest flex items-center justify-center gap-3 transition-all hover:bg-[#ED1C24]">
                                Authentication Required <i class="fa-solid fa-lock text-[10px]"></i>
                            </a>
                        @endauth
                        
                        <a href="{{ route('contact') }}" class="w-full py-4 bg-white text-slate-900 border border-slate-200 rounded-2xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center gap-3 hover:bg-slate-50 transition-all">
                            Request Briefing <i class="fa-solid fa-file-invoice-dollar"></i>
                        </a>
                    </div>
                </div>

                <!-- Strategic Security Node -->
                <div class="bg-white rounded-[2rem] p-6 border border-slate-100 text-center space-y-3 shadow-md">
                    <div class="flex items-center justify-center gap-2 mb-2">
                        @foreach(['visa', 'mastercard', 'escrow'] as $icon)
                            <div class="w-8 h-4 bg-slate-100 rounded flex items-center justify-center opacity-40 grayscale">
                                <i class="fa-solid fa-shield-halved text-[8px] text-slate-400"></i>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest leading-relaxed">
                        Intel-Grade Escrow Protection <br/> Secured by Eventy Blockchain v4.0.0
                    </p>
                </div>
            </div>
        </div>

        <!-- Related Strategic Assets -->
        @if($relatedServices->count() > 0)
        <div class="mt-20 pt-16 border-t border-slate-100">
            <h2 class="text-2xl font-black text-[#0A192F] uppercase tracking-tighter mb-10 pl-6 border-l-4 border-[#0A192F]">Integrated Asset Nodes</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach($relatedServices as $rel)
                <a href="{{ route('services.show', $rel) }}" class="group bg-white rounded-[2rem] overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500">
                    <div class="h-40 overflow-hidden relative">
                        <img src="{{ Str::startsWith($rel->getFeaturedImage(), ['http', 'https']) ? $rel->getFeaturedImage() : asset('storage/' . $rel->getFeaturedImage()) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F]/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xs font-black text-[#0A192F] uppercase mb-4 line-clamp-1 group-hover:text-[#ED1C24] transition-colors">{{ $rel->name }}</h4>
                        <div class="flex justify-between items-center text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            <span>PKR {{ number_format($rel->price) }}</span>
                            <i class="fa-solid fa-chevron-right text-[#ED1C24]"></i>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
