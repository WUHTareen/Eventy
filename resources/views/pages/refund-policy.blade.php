@extends('layouts.public')

@section('content')
<div class="bg-[#020617] min-h-screen pt-32 pb-24 relative overflow-hidden">
    <!-- background effects -->
    <div class="absolute top-0 left-0 w-full h-full">
        <div class="absolute top-[-10%] left-1/2 -translate-x-1/2 w-[40%] h-[40%] bg-[#ED1C24]/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-blue-900/10 rounded-full blur-[120px]"></div>
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.05) 1px, transparent 0); background-size: 30px 30px;"></div>
    </div>

    <div class="max-w-4xl mx-auto px-6 relative z-10">
        <!-- header -->
        <div class="mb-16">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-px bg-[#ED1C24]"></div>
                <span class="text-[#ED1C24] text-xs font-black uppercase tracking-[0.4em]">Capital Correction</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter uppercase leading-none mb-8">
                Refund <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-white/20">Protocols</span>
            </h1>
            <p class="text-white/40 font-mono text-sm">Protocol Status: Active // January 2026</p>
        </div>

        <!-- content grid -->
        <div class="space-y-12">
            <section class="group">
                <div class="flex gap-6">
                    <div class="hidden md:block">
                        <span class="text-white/10 font-black text-3xl font-mono">01</span>
                    </div>
                    <div class="space-y-4">
                        <h2 class="text-2xl font-black text-white uppercase tracking-tight group-hover:text-[#ED1C24] transition-colors">Cancellation Window</h2>
                        <p class="text-white/60 leading-relaxed text-lg">
                            Refund eligibility is determined by the temporal distance between the cancellation request and the scheduled execution date. Standard protocols allow full capital restoration if cancelled 30 days prior to the event.
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
                        <h2 class="text-2xl font-black text-white uppercase tracking-tight group-hover:text-[#ED1C24] transition-colors">Vendor Specifics</h2>
                        <p class="text-white/60 leading-relaxed text-lg">
                            Some premium partners operate under strict "Non-Refundable" parameters due to high-demand resource allocation. These specific protocols will always be visible on the "Neural Search Terminal" prior to booking.
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
                        <h2 class="text-2xl font-black text-white uppercase tracking-tight group-hover:text-[#ED1C24] transition-colors">Restoration Pipeline</h2>
                        <p class="text-white/60 leading-relaxed text-lg">
                            Once a refund is approved by our system architects, capital restoration typically takes 5-10 business cycles. This delay is necessary for cross-border cryptographic verification and bank clearance.
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
                        <h2 class="text-2xl font-black text-white uppercase tracking-tight group-hover:text-[#ED1C24] transition-colors">Dispute Resolution</h2>
                        <p class="text-white/60 leading-relaxed text-lg">
                            In the event of a protocol conflict between a client and a partner, Eventy intelligence will act as a neutral arbitrator to ensure a fair and logical resolution based on documented evidence.
                        </p>
                    </div>
                </div>
            </section>
        </div>

        <!-- Call to Action -->
        <div class="mt-20 p-1 bg-gradient-to-r from-transparent via-[#ED1C24]/30 to-transparent rounded-[2rem]">
            <div class="bg-[#020617] rounded-[2rem] p-12 text-center border border-white/5">
                <h3 class="text-2xl font-black text-white uppercase mb-4">Refund Request?</h3>
                <p class="text-white/40 mb-8 max-w-xl mx-auto">If you need to initiate a capital restoration request, please access your bookings portal.</p>
                <a href="{{ route('bookings.index') }}" class="inline-flex items-center gap-3 px-10 py-5 bg-[#ED1C24] text-white font-black uppercase tracking-widest rounded-2xl hover:bg-red-700 transition-all">
                    Access Bookings <i class="fa-solid fa-clock-rotate-left"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

