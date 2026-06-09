<div class="relative max-w-6xl mx-auto">
    <!-- Main Glass Vessel -->
    <div class="bg-white/90 backdrop-blur-2xl rounded-[3rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.1)] border border-white/60 p-12 md:p-16 grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-0 text-center relative overflow-hidden">
        
        <!-- Subtle Background Glows -->
        <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
            <div class="absolute top-[-20%] left-[-10%] w-[40%] h-[40%] bg-blue-500/5 rounded-full blur-[80px]"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-[40%] h-[40%] bg-red-500/5 rounded-full blur-[80px]"></div>
        </div>

        <!-- Verified Vendors -->
        <div class="group relative px-4 transition-all duration-500 hover:-translate-y-1">
            <div class="space-y-3">
                <div class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter uppercase group-hover:text-primary-500 transition-colors duration-500 leading-none">
                    {{ $stats['vendors'] }}
                </div>
                <div class="text-slate-500 text-[11px] font-black uppercase tracking-[0.3em] opacity-70 group-hover:opacity-100 transition-opacity">
                    Verified Vendors
                </div>
            </div>
            <!-- Vertical Divider -->
            <div class="hidden md:block absolute right-0 top-1/4 bottom-1/4 w-px bg-slate-200/60"></div>
        </div>

        <!-- Active Services -->
        <div class="group relative px-4 transition-all duration-500 hover:-translate-y-1">
            <div class="space-y-3">
                <div class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter uppercase group-hover:text-secondary-500 transition-colors duration-500 leading-none">
                    {{ $stats['services'] }}
                </div>
                <div class="text-slate-500 text-[11px] font-black uppercase tracking-[0.3em] opacity-70 group-hover:opacity-100 transition-opacity">
                    Active Services
                </div>
            </div>
            <!-- Vertical Divider -->
            <div class="hidden md:block absolute right-0 top-1/4 bottom-1/4 w-px bg-slate-200/60"></div>
        </div>

        <!-- Completed Bookings -->
        <div class="group relative px-4 transition-all duration-500 hover:-translate-y-1">
            <div class="space-y-3">
                <div class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter uppercase group-hover:text-emerald-500 transition-colors duration-500 leading-none">
                    {{ $stats['bookings'] }}
                </div>
                <div class="text-slate-500 text-[11px] font-black uppercase tracking-[0.3em] opacity-70 group-hover:opacity-100 transition-opacity">
                    Completed Bookings
                </div>
            </div>
            <!-- Vertical Divider -->
            <div class="hidden md:block absolute right-0 top-1/4 bottom-1/4 w-px bg-slate-200/60"></div>
        </div>

        <!-- Happy Customers -->
        <div class="group relative px-4 transition-all duration-500 hover:-translate-y-1">
            <div class="space-y-3">
                <div class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter uppercase group-hover:text-amber-500 transition-colors duration-500 leading-none">
                    {{ $stats['users'] }}
                </div>
                <div class="text-slate-500 text-[11px] font-black uppercase tracking-[0.3em] opacity-70 group-hover:opacity-100 transition-opacity">
                    Happy Customers
                </div>
            </div>
        </div>
    </div>
</div>

