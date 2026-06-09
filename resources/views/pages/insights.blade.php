@extends('layouts.public')

@section('content')
<div class="bg-[#020617] min-h-screen pt-32 pb-24 relative overflow-hidden">
    <!-- background effects -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-px bg-gradient-to-r from-transparent via-[#ED1C24]/50 to-transparent"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-blue-900/10 rounded-full blur-[120px]"></div>
    </div>

    <div class="max-w-[1400px] mx-auto px-6 relative z-10">
        <!-- header -->
        <div class="flex flex-col md:flex-row items-end justify-between mb-20 gap-8">
            <div class="max-w-2xl">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-2 h-2 rounded-full bg-[#ED1C24] animate-pulse"></div>
                    <span class="text-[#ED1C24] text-[10px] font-black uppercase tracking-[0.4em]">Intelligence Feed</span>
                </div>
                <h1 class="text-6xl md:text-8xl font-black text-white tracking-tighter uppercase leading-[0.9] mb-4">
                    Elite <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-white/20">Insights</span>
                </h1>
                <p class="text-white/40 font-medium text-lg ">"Deciphering the future of luxury hospitality & strategic planning."</p>
            </div>
            <div class="flex gap-4">
                <div class="px-6 py-3 bg-white/5 border border-white/10 rounded-xl text-white/60 text-xs font-bold uppercase tracking-widest hidden md:block">
                    Filtered by: All Archives
                </div>
            </div>
        </div>

        @if($posts->count() > 0)
            @php $featured = $posts->first(); @endphp
            <!-- featured article -->
            <div class="group relative bg-white/[0.02] border border-white/10 rounded-[3rem] overflow-hidden mb-20 hover:border-[#ED1C24]/30 transition-all duration-700">
                <div class="flex flex-col lg:flex-row">
                    <div class="lg:w-2/3 h-[500px] overflow-hidden">
                        <img src="{{ $featured->featured_image }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-1000">
                    </div>
                    <div class="lg:w-1/3 p-12 flex flex-col justify-center">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="px-3 py-1 bg-[#ED1C24] text-white text-[10px] font-black uppercase tracking-widest rounded-md">{{ $featured->category }}</span>
                            <span class="text-white/20 text-xs font-mono">{{ $featured->published_at->format('d M Y') }}</span>
                        </div>
                        <h2 class="text-4xl font-black text-white uppercase tracking-tighter leading-tight mb-6 group-hover:text-[#ED1C24] transition-colors">
                            {{ $featured->title }}
                        </h2>
                        <p class="text-white/40 leading-relaxed font-medium mb-10">
                            {{ $featured->excerpt }}
                        </p>
                        <a href="{{ route('insights') }}#{{ $featured->slug }}" class="text-white font-black uppercase tracking-[0.2em] text-sm flex items-center gap-3">
                            Read Operation <i class="fa-solid fa-arrow-right-long group-hover:translate-x-2 transition-transform"></i>
                        </a>
                    </div>
                </div>
                <!-- tag -->
                <div class="absolute top-8 left-8 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20">
                    <span class="text-white text-[10px] font-black uppercase tracking-widest">Featured Report</span>
                </div>
            </div>

            <!-- article grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($posts->skip(1) as $post)
                    <!-- Article -->
                    <div class="group bg-white/[0.02] border border-white/5 rounded-[2.5rem] p-8 hover:border-[#ED1C24]/30 transition-all">
                        <div class="h-60 rounded-3xl overflow-hidden mb-8 border border-white/5">
                            <img src="{{ $post->featured_image }}" class="w-full h-full object-cover opacity-50 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700">
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-[#ED1C24] text-[10px] font-black uppercase tracking-widest">{{ $post->category }}</span>
                                <span class="text-white/20 text-[10px] font-mono">{{ $post->published_at->format('d M Y') }}</span>
                            </div>
                            <h3 class="text-2xl font-black text-white uppercase tracking-tight group-hover:text-[#ED1C24] transition-colors">{{ $post->title }}</h3>
                            <p class="text-white/40 text-sm font-medium leading-relaxed">{{ $post->excerpt }}</p>
                            <a href="{{ route('insights') }}#{{ $post->slug }}" class="inline-block text-white/60 text-[10px] font-black uppercase tracking-widest border-b border-white/10 pb-1 group-hover:text-white transition-colors">Access File</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-40">
                <h3 class="text-white/20 text-4xl font-black uppercase tracking-widest">No archival data found.</h3>
            </div>
        @endif

        <!-- pagination/load more -->
        <div class="mt-20 flex justify-center">
            <button class="px-12 py-5 bg-white/5 border border-white/10 text-white font-black uppercase tracking-widest rounded-2xl hover:bg-[#ED1C24] hover:border-[#ED1C24] transition-all">
                Refresh Archives <i class="fa-solid fa-rotate ml-2"></i>
            </button>
        </div>
    </div>
</div>
@endsection

