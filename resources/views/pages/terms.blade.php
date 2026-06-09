@extends('layouts.public')

@section('content')
<div class="bg-[#020617] min-h-screen pt-32 pb-24 relative overflow-hidden">
    <!-- background effects -->
    <div class="absolute top-0 left-0 w-full h-full">
        <div class="absolute top-[-10%] right-[-10%] w-[40%] h-[40%] bg-[#ED1C24]/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-900/10 rounded-full blur-[120px]"></div>
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.05) 1px, transparent 0); background-size: 30px 30px;"></div>
    </div>

    <div class="max-w-4xl mx-auto px-6 relative z-10">
        <!-- header -->
        <div class="mb-16">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-px bg-[#ED1C24]"></div>
                <span class="text-[#ED1C24] text-xs font-black uppercase tracking-[0.4em]">System Governance</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter uppercase leading-none mb-8">
                Terms of <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-white/20">Service</span>
            </h1>
            <p class="text-white/40 font-mono text-sm">Agreement Revision: January 2026 // v.2.1.0</p>
        </div>

        <!-- content grid -->
        <div class="space-y-12">
            <section class="group">
                <div class="flex gap-6">
                    <div class="hidden md:block">
                        <span class="text-white/10 font-black text-3xl font-mono">01</span>
                    </div>
                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white uppercase tracking-tight group-hover:text-[#ED1C24] transition-colors">Acceptance of Protocols</h2>
                        <p class="text-white/60 leading-relaxed text-lg">
                            By accessing the Eventy ecosystem, you agree to abide by all platform governance protocols. These terms constitute a legally binding agreement between you and the Eventy Network.
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
                        <h2 class="text-2xl font-black text-white uppercase tracking-tight group-hover:text-[#ED1C24] transition-colors">Platform Logistics</h2>
                        <p class="text-white/60 leading-relaxed text-lg">
                            Our platform serves as a high-tech intermediary between clients and premium service providers. While we verify all partners, the specific execution of on-ground services remains subject to individual vendor protocols.
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
                        <h2 class="text-2xl font-black text-white uppercase tracking-tight group-hover:text-[#ED1C24] transition-colors">Financial Transactions</h2>
                        <p class="text-white/60 leading-relaxed text-lg">
                            All financial exchanges are processed through encrypted channels. Bookings are only confirmed once the designated capital has been successfully transmitted through our clearing house.
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
                        <h2 class="text-2xl font-black text-white uppercase tracking-tight group-hover:text-[#ED1C24] transition-colors">Intellectual Framework</h2>
                        <p class="text-white/60 leading-relaxed text-lg">
                            The visual interface, proprietary code, and trademarked architecture of Eventy are protected by international intellectual property law. Unauthorized replication of our systems is strictly prohibited.
                        </p>
                    </div>
                </div>
            </section>
        </div>

        <!-- Call to Action -->
        <div class="mt-20 p-1 bg-gradient-to-r from-transparent via-[#ED1C24]/30 to-transparent rounded-[2rem]">
            <div class="bg-[#020617] rounded-[2rem] p-12 text-center border border-white/5">
                <h3 class="text-2xl font-black text-white uppercase mb-4">Legal Inquiry?</h3>
                <p class="text-white/40 mb-8 max-w-xl mx-auto">For clarification on specific governance clauses, please initiate a formal request.</p>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-3 px-10 py-5 bg-white text-[#020617] font-black uppercase tracking-widest rounded-2xl hover:bg-white/90 transition-all">
                    Legal Dashboard <i class="fa-solid fa-gavel"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

