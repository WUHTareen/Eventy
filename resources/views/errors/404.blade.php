@extends('layouts.public')

@section('content')
<div class="bg-[#020617] min-h-screen flex items-center justify-center relative overflow-hidden">
    <!-- background effects -->
    <div class="absolute inset-0">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-[#ED1C24]/10 rounded-full blur-[150px]"></div>
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.05) 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>

    <div class="relative z-10 text-center px-6">
        <div class="mb-8">
            <span class="text-[#ED1C24] font-mono text-xl tracking-[0.5em] animate-pulse">ERROR_CODE: 404</span>
        </div>
        <h1 class="text-[12rem] md:text-[20rem] font-black text-white leading-none tracking-tighter uppercase opacity-10">404</h1>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full">
            <h2 class="text-4xl md:text-7xl font-black text-white uppercase tracking-tighter mb-6">Lost in the <span class="text-[#ED1C24]">Void</span></h2>
            <p class="text-white/40 text-lg md:text-xl max-w-lg mx-auto mb-10 font-medium">
                The neural coordinate you are attempting to reach does not exist within our secure ecosystem.
            </p>
            <div class="flex flex-col md:flex-row items-center justify-center gap-6">
                <a href="{{ route('home') }}" class="px-10 py-5 bg-[#ED1C24] text-white font-black uppercase tracking-widest rounded-2xl hover:scale-105 transition-all shadow-[0_0_30px_rgba(237,28,36,0.3)]">
                    Return to Command Center <i class="fa-solid fa-house-signal ml-2"></i>
                </a>
                <a href="{{ route('contact') }}" class="px-10 py-5 bg-white/5 text-white border border-white/10 font-black uppercase tracking-widest rounded-2xl hover:bg-white/10 transition-all">
                    Report Data Leak
                </a>
            </div>
        </div>
    </div>

    <!-- Scanned Effect Lines -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="w-full h-[2px] bg-[#ED1C24]/20 absolute top-0 animate-[scan_3s_linear_infinite]"></div>
    </div>
</div>

<style>
@keyframes scan {
    0% { transform: translateY(-100%); }
    100% { transform: translateY(100vh); }
}
</style>
@endsection

