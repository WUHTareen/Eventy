<div x-data="{ 
        show: false, 
        message: 'Looking for the perfect venue for 2026? We just verified 5 elite properties in Lahore!',
        step: 0,
        messages: [
            'Looking for the perfect venue for 2026? We just verified 5 elite properties in Lahore!',
            'Pro Tip: Book your catering 6 months in advance to secure early-bird rates!',
            'Found a top-rated photographer with a 5.0 rating near your location!'
        ]
     }"
     x-init="setInterval(() => { step = (step + 1) % messages.length; message = messages[step]; }, 10000)"
     class="fixed bottom-20 md:bottom-32 right-4 md:right-6 z-[100]"
     x-cloak>
    
    <!-- Concierge Hub -->
    <div x-show="show" 
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 translate-y-12 scale-90"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-12 scale-90"
         class="relative mb-6">
        
        <div class="bg-[#020617]/90 backdrop-blur-3xl border border-white/10 p-6 rounded-[2rem] shadow-[0_40px_80px_-20px_rgba(0,0,0,0.4)] max-w-[300px] relative overflow-hidden group">

            
            <div class="flex items-center gap-4 mb-5">
                <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-[#ED1C24] shadow-2xl relative overflow-hidden group-hover:border-[#ED1C24]/30 transition-all">
                    <i class="fa-solid fa-microchip text-lg"></i>
                    <div class="absolute inset-0 bg-[#ED1C24]/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
                <div>
                    <h4 class="text-[10px] font-black text-white/40 tracking-[0.3em] uppercase leading-tight font-mono">Smart Concierge</h4>
                    <div class="flex items-center gap-1.5 mt-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 shadow-[0_0_8px_#22c55e]"></span>
                        <span class="text-[8px] font-black text-white/60 tracking-widest uppercase">AI Uplink Active</span>
                    </div>
                </div>
                <button @click="show = false" class="ml-auto w-8 h-8 rounded-full flex items-center justify-center text-white/20 hover:text-white hover:bg-white/5 transition-all">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>
            
            <div class="space-y-4">
                <div class="bg-white/5 border border-white/5 p-4 rounded-2xl relative">
                    <i class="fa-solid fa-quote-left absolute -top-2 -left-2 text-[#ED1C24]/40 text-xs"></i>
                    <p class="text-white/60 text-[11px] font-bold leading-relaxed font-mono" x-text="message"></p>
                </div>
                
                <a href="{{ route('services') }}" class="w-full py-4 bg-gradient-to-r from-[#ED1C24] to-[#b2151b] text-white rounded-2xl text-[9px] font-black uppercase tracking-[0.4em] flex items-center justify-center gap-3 hover:scale-[1.02] active:scale-95 transition-all shadow-2xl">
                    Deploy Search <i class="fa-solid fa-location-crosshairs text-xs"></i>
                </a>
            </div>
        </div>
    </div>

    <button x-show="!show" @click="show = true" 
            class="relative group w-16 h-16 md:w-20 md:h-20 flex items-center justify-center transition-all duration-500 hover:scale-110 active:scale-90">
        <!-- Pulse circles -->
        <div class="absolute inset-0 rounded-full bg-[#ED1C24]/20"></div>
        <div class="absolute inset-2 rounded-full bg-[#ED1C24]/10"></div>
        
        <div class="relative w-12 h-12 md:w-16 md:h-16 bg-[#020617] border-2 border-white/10 rounded-full shadow-2xl flex items-center justify-center group-hover:border-[#ED1C24]/50 transition-all overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-tr from-[#ED1C24]/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <i class="fa-solid fa-brain text-[#ED1C24] text-xl md:text-2xl group-hover:scale-110 transition-transform"></i>
        </div>
        
        <!-- Status Indicator -->
        <div class="absolute top-1 right-1 w-4 h-4 bg-[#020617] rounded-full border-2 border-white/5 flex items-center justify-center">
            <div class="w-1.5 h-1.5 bg-green-500 rounded-full shadow-[0_0_8px_#22c55e]"></div>
        </div>
    </button>
</div>

