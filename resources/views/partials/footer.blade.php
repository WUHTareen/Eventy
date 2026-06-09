<footer class="bg-[#0A192F] border-t-2 border-[#ED1C24]/30 pt-16 pb-8 overflow-hidden relative">
    <!-- Sophisticated Background Elements -->
    <div class="absolute top-0 left-1/4 w-[600px] h-[600px] bg-blue-600/5 rounded-full blur-[150px] pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-[#ED1C24]/5 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute inset-0 opacity-[0.02] pointer-events-none" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>

    <div class="max-w-[1400px] mx-auto px-6 relative z-10">

        <!-- Main Strategic Row -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 pb-12 border-b border-white/5">

            <!-- Brand Architecture -->
            <div class="lg:col-span-4 space-y-6">
                <div class="space-y-4">
                    <a href="{{ route('home') }}" class="block">
                        <img src="{{ asset('images/EVN.png') }}" alt="Eventy.pk" class="h-14 w-auto brightness-0 invert opacity-90 hover:opacity-100 transition-all duration-500">
                    </a>
                    <p class="text-blue-100/40 text-[11px] leading-relaxed max-w-sm uppercase tracking-wider font-medium">
                        "Pakistan's decentralized network for mission-critical events, executive travel, and high-fidelity hospitality architectures."
                    </p>
                </div>
                
                <div class="flex gap-3">
                    @php $socials = [
                        ['fa-facebook-f',  'https://www.facebook.com/share/1C15CkM3z6/'],
                        ['fa-instagram',   'https://www.instagram.com/eventy.pkk?igsh=dzFmZzUwNjEzZnds'],
                        ['fa-linkedin-in', 'https://www.linkedin.com/in/eventypk'],
                        ['fa-tiktok',      'https://www.tiktok.com/@eventy.pk'],
                        ['fa-youtube',     'https://www.youtube.com/@Eventypk'],
                    ]; @endphp
                    @foreach($socials as [$icon, $link])
                        <a href="{{ $link }}" target="_blank" class="w-10 h-10 rounded-xl border border-white/5 bg-white/[0.03] flex items-center justify-center text-white/30 hover:bg-[#ED1C24] hover:border-[#ED1C24] hover:text-white transition-all duration-500">
                            <i class="fa-brands {{ $icon }} text-[14px]"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Navigation Protocols -->
            <div class="lg:col-span-5 grid grid-cols-2 gap-8">
                <div class="space-y-6">
                    <h5 class="text-[10px] font-black text-[#ED1C24] uppercase tracking-[0.4em] mb-4">Core Directory</h5>
                    <ul class="space-y-3">
                        @foreach([['About Intelligence','about'],['AI Architect','budget-planner'],['Tactical Insights','insights'],['Vendor Protocol','vendor-onboarding']] as [$l,$r])
                        <li>
                            <a href="{{ route($r) }}" class="group flex items-center gap-3 text-xs text-blue-100/40 hover:text-white transition-all duration-300">
                                <span class="w-1 h-px bg-white/10 group-hover:w-4 group-hover:bg-[#ED1C24] transition-all"></span>
                                {{ $l }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="space-y-6">
                    <h5 class="text-[10px] font-black text-blue-400 uppercase tracking-[0.4em] mb-4">Governance</h5>
                    <ul class="space-y-3">
                        @foreach([['Terms of Service','terms'],['Privacy Shield','privacy'],['Refund Protocol','refund-policy']] as [$l,$r])
                        <li>
                            <a href="{{ route($r) }}" class="group flex items-center gap-3 text-xs text-blue-100/40 hover:text-white transition-all duration-300">
                                <span class="w-1 h-px bg-white/10 group-hover:w-4 group-hover:bg-blue-400 transition-all"></span>
                                {{ $l }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Intel Subscription -->
            <div class="lg:col-span-3 space-y-6">
                <div>
                    <h5 class="text-[10px] font-black text-white uppercase tracking-[0.4em] mb-4">Intel Briefing</h5>
                    <p class="text-blue-100/30 text-[11px] mb-6 uppercase tracking-widest leading-relaxed">Secure exclusive tactical data and VIP deployment offers.</p>
                </div>
                <form class="space-y-3" onsubmit="return false;">
                    <div class="relative group">
                        <input type="email" placeholder="AUTHENTICATE EMAIL"
                            class="w-full bg-white/[0.03] border border-white/10 rounded-xl px-5 py-4 text-[10px] font-black tracking-widest text-white placeholder-white/20 focus:outline-none focus:border-[#ED1C24]/40 focus:bg-white/[0.05] transition-all">
                    </div>
                    <button class="w-full py-4 bg-[#ED1C24] text-white font-black text-[11px] uppercase tracking-[0.2em] rounded-xl hover:bg-red-700 hover:shadow-2xl hover:shadow-[#ED1C24]/20 active:scale-[0.98] transition-all duration-500">
                        Initiate Subscription
                    </button>
                </form>
            </div>

        </div>

        <!-- Operational Status Bar -->
        <div class="pt-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-6">
                <p class="text-[10px] font-black text-white/20 tracking-[0.3em] uppercase">
                    &copy; {{ date('Y') }} <span class="text-white/40">Eventy Deployment Hub</span>
                </p>
                <div class="hidden md:block w-px h-3 bg-white/10"></div>
                <div class="flex items-center gap-3">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="text-[9px] font-black text-white/40 uppercase tracking-[0.2em]">All Systems Operational</span>
                </div>
            </div>
            
            <div class="flex items-center gap-8 opacity-20 grayscale hover:grayscale-0 hover:opacity-60 transition-all duration-700">
                <i class="fa-brands fa-cc-visa text-2xl"></i>
                <i class="fa-brands fa-cc-mastercard text-2xl"></i>
                <i class="fa-solid fa-shield-halved text-xl"></i>
            </div>
        </div>

    </div>
</footer>
