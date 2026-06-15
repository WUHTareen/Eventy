<div x-data="{ 
        show: false, 
        current: null,
        notifs: [
            { name: 'Sameer', city: 'Karachi', action: 'booked a Photographer', icon: 'fa-camera-retro' },
            { name: 'Sarah', city: 'Lahore', action: 'secured a Venue', icon: 'fa-building-columns' },
            { name: 'Ahmed', city: 'Islamabad', action: 'reserved a DJ', icon: 'fa-music' },
            { name: 'Fatima', city: 'Faisalabad', action: 'booked a Catering service', icon: 'fa-utensils' },
            { name: 'Zain', city: 'Multan', action: 'verified a new quote', icon: 'fa-file-invoice-dollar' }
        ],
        cycle() {
            setTimeout(() => {
                this.current = this.notifs[Math.floor(Math.random() * this.notifs.length)];
                this.show = true;
                setTimeout(() => {
                    this.show = false;
                    this.cycle();
                }, 5000);
            }, Math.random() * 15000 + 10000);
        }
     }" 
     x-init="cycle()"
     x-show="show"
     x-transition:enter="transition ease-out duration-700"
     x-transition:enter-start="opacity-0 translate-y-10 scale-90 blur-lg"
     x-transition:enter-end="opacity-100 translate-y-0 scale-100 blur-0"
     x-transition:leave="transition ease-in duration-500"
     x-transition:leave-start="opacity-100 translate-y-0 scale-100 blur-0"
     x-transition:leave-end="opacity-0 translate-y-10 scale-90 blur-lg"
     class="fixed bottom-10 left-10 z-[100] pointer-events-none"
     x-cloak>
    
    <div class="bg-[#020617]/80 backdrop-blur-2xl border border-white/10 p-5 rounded-[2rem] shadow-[0_20px_50px_rgba(237,28,36,0.15)] flex items-center gap-6 max-w-sm pointer-events-auto group hover:border-[#ED1C24]/40 transition-all duration-500 overflow-hidden relative">
        
        <!-- Glowing Tech Line -->
        <div class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-[#ED1C24] to-transparent opacity-50"></div>
        
        <div class="w-14 h-14 bg-white/5 rounded-2xl flex items-center justify-center text-[#ED1C24] shadow-2xl relative group-hover:bg-[#ED1C24]/10 transition-colors">
            <i class="fa-solid text-xl" :class="current?.icon"></i>
            <div class="absolute inset-0 bg-[#ED1C24]/20 blur-xl opacity-0 group-hover:opacity-50 transition-opacity"></div>
        </div>

        <div class="flex-1">
            <div class="flex items-center gap-2 mb-1">
                <div class="w-1.5 h-1.5 rounded-full bg-[#ED1C24]"></div>
                <span class="text-[9px] font-black text-white/30 uppercase tracking-[0.3em] font-mono">Live Sync</span>
            </div>
            <p class="text-[11px] font-black text-white leading-tight uppercase tracking-tight">
                <span x-text="current?.name" class="text-[#ED1C24]"></span> <span class="text-white/40">from</span> <span x-text="current?.city"></span>
            </p>
            <p class="text-[9px] font-black  text-white/40 mt-1 uppercase tracking-wider" x-text="'...just ' + current?.action"></p>
        </div>

        <div class="ml-4 flex flex-col items-end gap-2">
            <span class="flex h-2 w-2">
                <span class="relative inline-flex rounded-full h-2 w-2 bg-[#ED1C24]"></span>
            </span>
            <span class="text-[7px] font-mono font-black text-white/10 uppercase">SECURE_LINK</span>
        </div>

        <!-- Scanning line effect -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute h-full w-px bg-white/5 left-1/4"></div>
            <div class="absolute h-full w-px bg-white/5 left-2/4"></div>
            <div class="absolute h-full w-px bg-white/5 left-3/4"></div>
        </div>
    </div>
</div>

