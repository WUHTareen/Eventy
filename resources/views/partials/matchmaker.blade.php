<div x-data="{ 
        open: false, 
        step: 1, 
        processing: false,
        selections: { vibe: '', budget: '', city: '' },
        nextStep(vibe) {
            this.selections.vibe = vibe;
            this.processing = true;
            setTimeout(() => {
                this.processing = false;
                this.step = 2;
            }, 1500);
        },
        selectBudget(budget) {
            this.selections.budget = budget;
            this.processing = true;
            setTimeout(() => {
                this.processing = false;
                this.step = 3;
            }, 1200);
        },
        finish(city) {
            this.selections.city = city;
            let url = '{{ route('services') }}' + '?search=' + this.selections.vibe + '&city=' + this.selections.city;
            window.location.href = url;
        }
     }" 
     @open-matchmaker.window="open = true; step = 1; processing = false"
     class="fixed inset-0 z-[300] flex items-center justify-center p-6"
     x-show="open"
     x-cloak>
    
    <!-- Backdrop with High-End Blur -->
    <div class="absolute inset-0 bg-[#020617]/60 backdrop-blur-3xl" @click="open = false" x-show="open" x-transition:enter="transition duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"></div>

    <div class="relative bg-[#020617]/90 w-full max-w-2xl rounded-[3rem] shadow-[0_0_100px_rgba(237,28,36,0.1)] overflow-hidden border border-white/10 group"
         x-show="open"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 scale-95 translate-y-20 blur-xl"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0 blur-0">
        
        <!-- Tech Accents -->
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#ED1C24] to-transparent opacity-50"></div>
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 p-10 opacity-10">
                <i class="fa-solid fa-microchip text-8xl text-white rotate-12"></i>
            </div>
            <!-- Global Scanning Line -->

        </div>

        <!-- Header: Identity Header -->
        <div class="p-12 border-b border-white/5 flex justify-between items-center bg-white/[0.02]">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-1.5 h-1.5 rounded-full bg-[#ED1C24]"></div>
                    <span class="text-[9px] font-black text-[#ED1C24] uppercase tracking-[0.5em] font-mono">Neural Architect v4.0</span>
                </div>
                <h2 class="text-4xl font-black text-white tracking-tighter uppercase leading-none">Initialize <span class="text-white/40">Matchmaker</span></h2>
            </div>
            <button @click="open = false" class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white/40 hover:text-[#ED1C24] hover:border-[#ED1C24]/50 transition-all group/close">
                <i class="fa-solid fa-xmark text-xl transition-transform group-hover/close:rotate-90"></i>
            </button>
        </div>

        <!-- content area -->
        <div class="p-12 min-h-[400px] flex flex-col justify-center relative">
            


            <!-- Step 1: Vibe Selection -->
            <div x-show="step === 1 && !processing" x-transition:enter="transition duration-500 transform" x-transition:enter-start="translate-x-20 opacity-0">
                <div class="mb-10">
                    <span class="text-[10px] font-black text-white/30 uppercase tracking-[0.3em] font-mono block mb-2">Step _01</span>
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight">Define Atmosphere Protocol</h3>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <button @click="nextStep('Royal')" class="relative p-10 rounded-[2.5rem] bg-white/[0.03] border border-white/10 hover:border-[#ED1C24]/50 transition-all text-center group">
                        <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center text-white/20 group-hover:text-[#ED1C24] group-hover:bg-[#ED1C24]/10 mb-6 mx-auto transition-all duration-500">
                            <i class="fa-solid fa-crown text-3xl"></i>
                        </div>
                        <p class="text-xs font-black uppercase tracking-widest text-white group-hover:text-white mb-2 transition-colors">Royal Heritage</p>
                        <p class="text-[9px] font-bold text-white/20 uppercase">Grandeur & Tradition</p>
                    </button>
                    <button @click="nextStep('Modern')" class="relative p-10 rounded-[2.5rem] bg-white/[0.03] border border-white/10 hover:border-[#ED1C24]/50 transition-all text-center group">
                        <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center text-white/20 group-hover:text-[#ED1C24] group-hover:bg-[#ED1C24]/10 mb-6 mx-auto transition-all duration-500">
                            <i class="fa-solid fa-bolt text-3xl"></i>
                        </div>
                        <p class="text-xs font-black uppercase tracking-widest text-white group-hover:text-white mb-2 transition-colors">Modern Pulse</p>
                        <p class="text-[9px] font-bold text-white/20 uppercase">Sleek & Vanguard</p>
                    </button>
                </div>
            </div>

            <!-- Step 2: Budget Intelligence -->
            <div x-show="step === 2 && !processing" x-transition:enter="transition duration-500 transform" x-transition:enter-start="translate-x-20 opacity-0">
                <div class="mb-10">
                    <span class="text-[10px] font-black text-white/30 uppercase tracking-[0.3em] font-mono block mb-2">Step _02</span>
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight">Investment Allocation</h3>
                </div>
                <div class="space-y-4">
                    <button @click="selectBudget('Boutique')" class="w-full p-8 bg-white/[0.03] hover:bg-[#ED1C24]/10 hover:border-[#ED1C24]/50 rounded-3xl border border-white/10 flex justify-between items-center transition-all group">
                        <div class="flex items-center gap-6 text-left">
                            <div class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center text-white/20 group-hover:text-[#ED1C24]">
                                <i class="fa-solid fa-diamond"></i>
                            </div>
                            <div>
                                <span class="text-sm font-black text-white uppercase tracking-widest block">Boutique Experience</span>
                                <span class="text-[9px] font-bold text-white/20 uppercase">High Value, Curated Quality</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-right text-white/10 group-hover:text-[#ED1C24] group-hover:translate-x-2 transition-all"></i>
                    </button>
                    <button @click="selectBudget('Elite')" class="w-full p-8 bg-white/[0.03] hover:bg-[#ED1C24]/10 hover:border-[#ED1C24]/50 rounded-3xl border border-white/10 flex justify-between items-center transition-all group">
                        <div class="flex items-center gap-6 text-left">
                            <div class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center text-white/20 group-hover:text-[#ED1C24]">
                                <i class="fa-solid fa-crown"></i>
                            </div>
                            <div>
                                <span class="text-sm font-black text-white uppercase tracking-widest block">Elite Signature</span>
                                <span class="text-[9px] font-bold text-white/20 uppercase">Premium Tier, Uncompromised Luxury</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-right text-white/10 group-hover:text-[#ED1C24] group-hover:translate-x-2 transition-all"></i>
                    </button>
                    <button @click="step = 1" class="text-[10px] font-black text-white/20 uppercase tracking-[0.2em] mt-8 hover:text-[#ED1C24] transition-colors"><i class="fa-solid fa-arrow-left-long mr-2"></i> Recalibrate Previous</button>
                </div>
            </div>

            <!-- Step 3: Geographic Node -->
            <div x-show="step === 3 && !processing" x-transition:enter="transition duration-500 transform" x-transition:enter-start="translate-x-20 opacity-0">
                <div class="mb-10">
                    <span class="text-[10px] font-black text-white/30 uppercase tracking-[0.3em] font-mono block mb-2">Step _03</span>
                    <h3 class="text-2xl font-black text-white uppercase tracking-tight">Target Geographic Node</h3>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($cities->take(4) as $city)
                    <button @click="finish('{{ $city->name }}')" class="p-8 bg-white/[0.03] hover:bg-[#ED1C24]/10 hover:border-[#ED1C24]/50 rounded-2xl border border-white/10 transition-all text-center group">
                        <p class="text-xs font-black uppercase tracking-widest text-white mb-1">{{ $city->name }}</p>
                        <p class="text-[8px] font-black text-white/20 uppercase font-mono">NODE_{{ Str::upper(Str::limit($city->name, 3, '')) }}</p>
                    </button>
                    @endforeach
                </div>
                <button @click="step = 2" class="text-[10px] font-black text-white/20 uppercase tracking-[0.2em] mt-10 hover:text-[#ED1C24] transition-colors"><i class="fa-solid fa-arrow-left-long mr-2"></i> Step Back</button>
            </div>
        </div>

        <!-- Footer: System Indicators -->
        <div class="p-8 bg-white/[0.01] border-t border-white/5 flex items-center justify-between">
            <div class="flex items-center gap-4 px-5 py-2.5 bg-[#ED1C24]/5 rounded-xl border border-[#ED1C24]/20">
                <div class="flex gap-1">
                    <div class="w-1.5 h-1.5 bg-[#ED1C24] rounded-full"></div>
                    <div class="w-1.5 h-1.5 bg-[#ED1C24] rounded-full"></div>
                    <div class="w-1.5 h-1.5 bg-[#ED1C24] rounded-full"></div>
                </div>
                <p class="text-[9px] font-mono font-black text-[#ED1C24] uppercase tracking-widest">Architect Engine Listening...</p>
            </div>
            <p class="text-[9px] font-mono font-black text-white/10 uppercase tracking-widest">© 2026 EVENTY CORE</p>
        </div>
    </div>
</div>

