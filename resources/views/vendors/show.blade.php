@extends('layouts.public')

@section('title', $vendor->name . ' - Verified Vendor Profile')
@section('description', 'Professional profile for ' . $vendor->name . '. Explorer their services, reviews, and portfolio on Eventy.')

@section('content')
    <!-- Vendor Hero Section -->
    <div class="relative pt-40 pb-32 overflow-hidden bg-slate-900">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900 to-slate-900"></div>
            <div class="absolute inset-0" style="background-image: radial-gradient(rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 60px 60px;"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <!-- Vendor Avatar -->
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-rose-500 rounded-[3rem] blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                    <div class="relative w-48 h-48 rounded-[2.5rem] border-4 border-white shadow-2xl overflow-hidden bg-slate-800">
                        <img src="{{ $vendor->getAvatarUrl() }}" class="w-full h-full object-cover" alt="{{ $vendor->name }}">
                    </div>
                    @if($vendor->is_verified)
                        <div class="absolute -top-4 -right-4 w-12 h-12 bg-indigo-500 rounded-full flex items-center justify-center text-white border-4 border-slate-900 shadow-xl" title="Verified Vendor">
                            <i class="fa-solid fa-crown text-sm"></i>
                        </div>
                    @endif
                </div>

                <div class="text-center md:text-left flex-grow">
                    <div class="inline-flex items-center gap-3 bg-white/5 backdrop-blur-2xl px-6 py-2 rounded-full border border-white/10 mb-8">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                        <span class="text-xs font-black text-white uppercase tracking-[0.3em]">Verified Boutique Platform</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-6xl font-black text-white mb-6 tracking-tighter leading-none">
                        {{ $vendor->name }}
                    </h1>
                    
                    <div class="flex flex-wrap justify-center md:justify-start items-center gap-8">
                        <div class="flex items-center gap-3">
                            <div class="flex text-amber-400 text-sm gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-{{ $i <= round($avgRating) ? 'solid' : 'regular' }} fa-star"></i>
                                @endfor
                            </div>
                            <span class="text-white font-black text-xl tracking-tighter">{{ number_format($avgRating, 1) }}</span>
                            <span class="text-slate-400 text-xs font-bold uppercase tracking-widest">({{ $reviewCount }} Reviews)</span>
                        </div>
                        
                        <div class="h-6 w-[1px] bg-slate-700 hidden md:block"></div>
                        
                        <div class="flex items-center gap-3 text-slate-400">
                            <i class="fa-solid fa-location-dot"></i>
                            <span class="text-sm font-bold uppercase tracking-widest">{{ $vendor->city->name ?? 'Global' }}</span>
                        </div>
                        
                        @auth
                            @if(auth()->id() !== $vendor->id)
                                <div class="h-6 w-[1px] bg-slate-700 hidden md:block"></div>
                                <a href="{{ route('messages.index', $vendor) }}" class="flex items-center gap-3 bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-2 rounded-full border border-indigo-400/50 transition-all font-black text-[10px] uppercase tracking-widest shadow-lg shadow-indigo-500/20">
                                    <i class="fa-solid fa-message text-[8px]"></i>
                                    Secure Dialogue
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-2 gap-4 w-full md:w-auto">
                    <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-[2rem] text-center">
                        <p class="text-2xl font-black text-white mb-1">{{ $services->total() }}</p>
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Total Services</p>
                    </div>
                    <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-[2rem] text-center">
                        <p class="text-2xl font-black text-white mb-1">100%</p>
                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Response Rate</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor Services Portfolio -->
    <div class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-16">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-[2px] bg-slate-900"></div>
                        <span class="text-xs font-black text-slate-400 uppercase tracking-[0.3em]">Master Portfolio</span>
                    </div>
                    <h2 class="text-4xl font-black text-slate-900 tracking-tighter">Bespoke Creations</h2>
                </div>
                <div class="flex items-center gap-3 text-slate-400 text-[10px] font-black uppercase tracking-widest">
                    <i class="fa-solid fa-filter"></i>
                    Sorted by Performance
                </div>
            </div>

            @if($services->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    @foreach($services as $service)
                        <a href="{{ route('services.show', $service) }}" class="group relative bg-white rounded-[2.5rem] overflow-hidden shadow-2xl shadow-slate-200/50 border border-slate-100 hover:shadow-indigo-500/10 hover:border-slate-300 transition-all duration-500 hover:-translate-y-3 h-full flex flex-col">
                            <div class="relative h-64 overflow-hidden">
                                @if($service->getFeaturedImage())
                                    <img src="{{ asset('storage/' . $service->getFeaturedImage()) }}" alt="{{ $service->name }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                                        <i class="fa-solid {{ $service->category->icon ?? 'fa-fingerprint' }} text-slate-200 text-6xl"></i>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/20 to-transparent"></div>
                                <div class="absolute top-6 left-6">
                                    <span class="bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl text-[10px] font-black text-slate-900 uppercase tracking-[0.2em] shadow-xl">
                                        {{ $service->category->name }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-8 flex-grow flex flex-col">
                                <h3 class="text-2xl font-black text-slate-900 mb-4 group-hover:text-indigo-600 transition-colors line-clamp-2 tracking-tight">
                                    {{ $service->name }}
                                </h3>
                                <div class="mt-auto pt-8 border-t border-slate-50 flex items-center justify-between">
                                    <div>
                                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-1">Value Starting At</p>
                                        <p class="text-xl font-black text-slate-900">PKR {{ number_format($service->price) }}</p>
                                    </div>
                                    <div class="w-12 h-12 bg-slate-50 group-hover:bg-slate-900 rounded-2xl flex items-center justify-center text-slate-900 group-hover:text-white transition-all duration-300 shadow-sm">
                                        <i class="fa-solid fa-arrow-right-long group-hover:translate-x-1 transition-transform"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-24">
                    {{ $services->links('pagination::tailwind') }}
                </div>
            @else
                <div class="text-center py-32 bg-white rounded-[3rem] border border-slate-100 shadow-xl">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-8">
                        <i class="fa-solid fa-wind text-slate-200 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Gallery in Preparation</h3>
                    <p class="text-slate-400 mt-3 font-medium max-w-sm mx-auto">This vendor is currently curating their master portfolio for display.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

