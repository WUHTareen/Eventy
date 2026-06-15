@extends('layouts.public')

@section('title', $package->name)

@section('content')
<div class="pt-24 pb-20 bg-gray-50/50 min-h-screen relative overflow-hidden">
    <!-- Background Accents -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-500/5 blur-[120px] rounded-full -z-10"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-secondary-500/5 blur-[120px] rounded-full -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid lg:grid-cols-3 gap-12">
            <!-- Left: Details & Services -->
            <div class="lg:col-span-2 space-y-12">
                <!-- Elite Header Card -->
                <div class="bg-white/70 backdrop-blur-2xl rounded-[3rem] p-10 md:p-14 shadow-2xl border border-white relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-12 text-gray-100/50 -rotate-12 transition-transform group-hover:scale-110 pointer-events-none">
                        <i class="fa-solid fa-gem text-[15rem]"></i>
                    </div>
                    
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full bg-primary-500 shadow-lg shadow-primary-500/20 text-white text-[10px] font-black uppercase tracking-widest mb-8">
                            <i class="fa-solid fa-crown text-[12px]"></i> Verified Ensemble Bundle
                        </div>
                        
                        <h1 class="text-4xl md:text-6xl font-black text-gray-900 mb-8 leading-tight tracking-tighter">
                            {{ $package->name }}
                        </h1>
                        
                        <p class="text-gray-500 text-lg md:text-xl leading-relaxed font-medium mb-12 max-w-2xl">
                            {{ $package->description }}
                        </p>
                        
                        <div class="flex flex-wrap gap-10 items-center border-t border-gray-100 pt-10">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-gray-900 flex items-center justify-center text-white shadow-xl rotate-3">
                                    <i class="fa-solid fa-fingerprint text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Architect</div>
                                    <div class="font-black text-gray-900 text-lg">{{ $package->user->name }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-primary-500 flex items-center justify-center text-white shadow-xl -rotate-3">
                                    <i class="fa-solid fa-layer-group text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Composition</div>
                                    <div class="font-black text-gray-900 text-lg">{{ $package->services->count() }} Elite Services</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service List -->
                <div class="space-y-8">
                    <div class="flex items-center gap-4 ml-4">
                        <span class="w-12 h-1 bg-primary-500 rounded-full"></span>
                        <h2 class="text-2xl font-black text-gray-900 tracking-tight uppercase tracking-widest text-sm">Ensemble Manifest</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6">
                        @foreach($package->services as $service)
                        <div class="bg-white/70 backdrop-blur-xl rounded-[2.5rem] p-8 border-2 border-white shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 group">
                            <div class="flex flex-col md:flex-row gap-8 items-center">
                                <div class="w-full md:w-56 h-40 rounded-[2rem] overflow-hidden flex-shrink-0 shadow-lg border-2 border-white relative">
                                    @php $featuredImage = $service->getFeaturedImage(); @endphp
                                    <img src="{{ $featuredImage ? (Str::startsWith($featuredImage, ['http', 'https']) ? $featuredImage : asset('storage/' . $featuredImage)) : 'https://images.unsplash.com/photo-1544126566-475a1062b183?auto=format&fit=crop&w=800&q=80' }}" 
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                                    <div class="absolute inset-0 bg-primary-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                </div>
                                <div class="flex-1 space-y-4">
                                    <div class="flex justify-between items-start">
                                        <span class="text-[10px] font-black text-primary-500 uppercase tracking-[0.2em]">{{ $service->category->name }}</span>
                                        <div class="text-gray-900 font-black text-xl tracking-tighter">
                                            <span class="text-xs text-gray-400 font-bold uppercase mr-1">Rs.</span>{{ number_format($service->price) }}
                                        </div>
                                    </div>
                                    <h3 class="text-2xl font-black text-gray-900 leading-tight tracking-tight">{{ $service->name }}</h3>
                                    <p class="text-gray-500 text-sm font-medium leading-relaxed line-clamp-2">{{ $service->description }}</p>
                                    <div class="pt-4 flex items-center justify-between">
                                        <a href="{{ route('services.show', $service->id) }}" class="inline-flex items-center gap-2 text-xs font-black text-gray-900 uppercase tracking-widest hover:text-primary-500 transition-colors group/link">
                                            Service Portfolio 
                                            <i class="fa-solid fa-arrow-right-long transition-transform group-hover/link:translate-x-2"></i>
                                        </a>
                                        <div class="flex -space-x-3">
                                            <div class="w-8 h-8 rounded-full border-2 border-white bg-gray-100 flex items-center justify-center text-[10px] font-black text-gray-400">
                                                <i class="fa-solid fa-star text-primary-500"></i>
                                            </div>
                                            <div class="w-8 h-8 rounded-full border-2 border-white bg-gray-100 flex items-center justify-center text-[10px] font-black text-gray-400">
                                                4.9
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right: Management Hub -->
            <div class="lg:col-span-1">
                <div class="sticky top-28 space-y-6">
                    <div class="bg-gray-900 rounded-[3rem] p-10 shadow-2xl text-white relative overflow-hidden border border-gray-800">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-primary-500/10 blur-[60px] rounded-full"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center gap-4 mb-10">
                                <div class="w-12 h-12 bg-primary-500 rounded-2xl flex items-center justify-center text-white shadow-lg">
                                    <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                                </div>
                                <h2 class="text-xl font-black text-white tracking-tight">Management Hub</h2>
                            </div>
                            
                            <div class="space-y-8">
                                <div class="bg-white/5 rounded-3xl p-8 border border-white/5 relative group transition-all hover:bg-white/10">
                                    <span class="text-[10px] font-black text-primary-400 uppercase tracking-[0.2em] block mb-2">Aggregated Valuation</span>
                                    <div class="flex items-baseline gap-3">
                                        <span class="text-sm font-black text-gray-500 uppercase">PKR</span>
                                        <span class="text-5xl font-black text-white tracking-tighter">{{ number_format($package->total_price) }}</span>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-white/5">
                                        <p class="text-[10px] text-gray-500 font-bold leading-relaxed ">Verified bundled pricing. Includes coordination and management fees.</p>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div class="flex items-center gap-4 px-4 py-3 bg-white/5 rounded-2xl text-xs font-bold text-gray-300">
                                        <i class="fa-solid fa-circle-check text-primary-500"></i> Unified Logistics Point
                                    </div>
                                    <div class="flex items-center gap-4 px-4 py-3 bg-white/5 rounded-2xl text-xs font-bold text-gray-300">
                                        <i class="fa-solid fa-circle-check text-primary-500"></i> Multi-Vendor Syncing
                                    </div>
                                    <div class="flex items-center gap-4 px-4 py-3 bg-white/5 rounded-2xl text-xs font-bold text-gray-300">
                                        <i class="fa-solid fa-circle-check text-primary-500"></i> Concierge Guarantee
                                    </div>
                                </div>

                                <a href="{{ route('packages.book', $package->id) }}" class="group block w-full py-6 bg-primary-500 text-white rounded-[1.5rem] font-black text-sm uppercase tracking-widest text-center shadow-xl shadow-primary-500/20 hover:bg-primary-600 transition-all hover:scale-[1.02] active:scale-95">
                                    Proceed to Booking 
                                    <i class="fa-solid fa-arrow-right-long ml-3 transition-transform group-hover:translate-x-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Concierge Card -->
                    <div class="bg-white/70 backdrop-blur-xl rounded-[2.5rem] p-8 border border-white shadow-xl group cursor-default">
                        <div class="flex items-center gap-5 mb-6">
                            <div class="w-12 h-12 rounded-2xl bg-primary-50 flex items-center justify-center text-primary-600">
                                <i class="fa-solid fa-headset text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-black text-gray-900 text-sm uppercase tracking-wider">Expert Advice</h4>
                                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Available 24/7</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 font-medium leading-relaxed mb-6">Need modifications to this ensemble? Our concierge team can help you tailor every detail to perfection.</p>
                        <a href="#" class="block text-center py-4 border-2 border-gray-100 rounded-2xl text-[10px] font-black uppercase tracking-widest text-gray-900 hover:bg-gray-900 hover:text-white hover:border-gray-900 transition-all">
                            Request Modification
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


