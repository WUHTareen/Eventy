@extends('layouts.public')

@section('content')
<div class="bg-[#020617] min-h-screen pt-32 pb-24 relative overflow-hidden">
    <!-- background effects -->
    <div class="absolute top-0 left-0 w-full h-full">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-[#ED1C24]/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-blue-900/10 rounded-full blur-[120px]"></div>
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.05) 1px, transparent 0); background-size: 30px 30px;"></div>
    </div>

    <div class="max-w-4xl mx-auto px-6 relative z-10">
        <!-- header -->
        <div class="mb-16">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-px bg-[#ED1C24]"></div>
                <span class="text-[#ED1C24] text-xs font-black uppercase tracking-[0.4em]">Security Protocols</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter uppercase leading-none mb-8">
                Privacy <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-white/20">Policy</span>
            </h1>
            <p class="text-white/40 font-mono text-sm">Last Cryptographic Update: January 2026 // v.1.0.4</p>
        </div>

        <!-- content grid -->
        <div class="space-y-12">
            <section class="group">
                <div class="flex gap-6">
                    <div class="hidden md:block">
                        <span class="text-white/10 font-black text-3xl font-mono">01</span>
                    </div>
                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white uppercase tracking-tight group-hover:text-[#ED1C24] transition-colors">Neural Data Collection</h2>
                        <p class="text-white/60 leading-relaxed text-lg">
                            We collect only the essential intelligence required to facilitate elite event and travel experiences. This includes your identity markers, strategic preferences, and payment vectors.
                        </p>
                    </div>
                </div>
            </section>

            <section class="group">
                <div class="flex gap-6">
                    <div class="hidden md:block">
                        <span class="text-white/10 font-black text-3xl font-mono">02</span>
                    </div>
                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white uppercase tracking-tight group-hover:text-[#ED1C24] transition-colors">Information Utilization</h2>
                        <p class="text-white/60 leading-relaxed text-lg">
                            Your data flows through our secure proprietary pipelines solely to optimize your itineraries, verify premium partner connectivity, and maintain the integrity of our global marketplace.
                        </p>
                    </div>
                </div>
            </section>

            <section class="group">
                <div class="flex gap-6">
                    <div class="hidden md:block">
                        <span class="text-white/10 font-black text-3xl font-mono">03</span>
                    </div>
                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white uppercase tracking-tight group-hover:text-[#ED1C24] transition-colors">Partner Shield</h2>
                        <p class="text-white/60 leading-relaxed text-lg">
                            When booking through verified partners, only crucial operational data is transmitted. We employ cryptographic standards to ensure no unauthorized third-party access occurs within our ecosystem.
                        </p>
                    </div>
                </div>
            </section>

            <section class="group">
                <div class="flex gap-6">
                    <div class="hidden md:block">
                        <span class="text-white/10 font-black text-3xl font-mono">04</span>
                    </div>
                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white uppercase tracking-tight group-hover:text-[#ED1C24] transition-colors">User Sovereignty</h2>
                        <p class="text-white/60 leading-relaxed text-lg">
                            You retain absolute sovereignty over your digital footprint. At any point, you may request complete data extraction or recursive deletion from our primary and secondary storage arrays.
                        </p>
                    </div>
                </div>
            </section>
        </div>

        <!-- Call to Action -->
        <div class="mt-20 p-1 bg-gradient-to-r from-transparent via-[#ED1C24]/30 to-transparent rounded-[2rem]">
            <div class="bg-[#020617] rounded-[2rem] p-12 text-center border border-white/5">
                <h3 class="text-2xl font-black text-white uppercase mb-4">Security Concerns?</h3>
                <p class="text-white/40 mb-8 max-w-xl mx-auto">Our security team is standing by to address any inquiries regarding your data integrity.</p>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-3 px-10 py-5 bg-[#ED1C24] text-white font-black uppercase tracking-widest rounded-2xl hover:bg-red-700 transition-all">
                    Initiate Contact <i class="fa-solid fa-shield-halved"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

