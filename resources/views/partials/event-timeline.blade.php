<div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-2xl overflow-hidden relative" 
     x-data="{ 
        phases: [
            { time: '09:00 AM', title: 'Arrival & Setup', icon: 'fa-truck-ramp-box', color: 'indigo-500' },
            { time: '12:00 PM', title: 'Grand Entry', icon: 'fa-door-open', color: 'amber-500' },
            { time: '02:00 PM', title: 'Main Feast', icon: 'fa-utensils', color: 'rose-500' },
            { time: '05:00 PM', title: 'Cake Cutting', icon: 'fa-cake-candles', color: 'purple-500' },
            { time: '08:00 PM', title: 'Grand Finale', icon: 'fa-sparkles', color: 'blue-500' }
        ],
        activePhase: 0
     }">
    
    <div class="flex items-center justify-between mb-12">
        <div>
            <span class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.4em] mb-2 block">Visual Planner</span>
            <h3 class="text-3xl font-black text-slate-900 tracking-tighter uppercase leading-none">Event <span class="text-slate-300">Timeline</span></h3>
        </div>
        <div class="flex items-center gap-4">
            <button class="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-all shadow-sm">
                <i class="fa-solid fa-download"></i>
            </button>
            <button class="w-12 h-12 rounded-2xl bg-slate-900 text-white flex items-center justify-center shadow-xl hover:bg-indigo-600 transition-all">
                <i class="fa-solid fa-plus"></i>
            </button>
        </div>
    </div>

    <!-- Timeline Track -->
    <div class="relative pb-12">
        <!-- Connecting Line -->
        <div class="absolute top-[60px] left-0 right-0 h-1 bg-slate-100 rounded-full">
            <div class="h-full bg-indigo-500 rounded-full transition-all duration-1000" :style="'width: ' + (activePhase / (phases.length - 1) * 100) + '%'"></div>
        </div>

        <div class="flex justify-between relative z-10">
            <template x-for="(phase, index) in phases" :key="index">
                <div class="flex flex-col items-center group cursor-pointer" @click="activePhase = index">
                    <!-- Point -->
                    <div class="w-[124px] h-[124px] rounded-[2.5rem] bg-white border-4 transition-all duration-500 flex items-center justify-center relative shadow-xl"
                         :class="activePhase === index ? 'border-indigo-500 scale-110 shadow-indigo-500/20' : 'border-slate-50 group-hover:border-slate-200'">
                        
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center transition-all duration-500"
                             :class="'bg-' + phase.color + (activePhase === index ? '/100 text-white' : '/10 text-' + phase.color)">
                            <i class="fa-solid text-xl" :class="phase.icon"></i>
                        </div>

                        <!-- Pulse Indicator -->
                        <template x-if="activePhase === index">
                            <span class="absolute -top-1 -right-1 flex h-4 w-4">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-4 w-4 bg-indigo-500"></span>
                            </span>
                        </template>
                    </div>

                    <!-- Label -->
                    <div class="mt-8 text-center transition-all duration-500" :class="activePhase === index ? 'opacity-100 translate-y-0' : 'opacity-40 translate-y-2'">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1" x-text="phase.time"></p>
                        <p class="text-sm font-black text-slate-900 uppercase tracking-tight" x-text="phase.title"></p>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="mt-12 p-8 bg-slate-50 rounded-[2rem] border border-slate-100 flex items-center justify-between group">
        <div class="flex items-center gap-8">
            <div class="w-20 h-20 rounded-[1.5rem] overflow-hidden shadow-xl">
                <img :src="'https://images.unsplash.com/photo-15' + (activePhase + 1) + '9225421980-715cb0215aed?auto=format&fit=crop&q=80&w=200'" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            </div>
            <div>
                <h4 class="text-xl font-black text-slate-900 uppercase tracking-tight mb-1" x-text="phases[activePhase].title"></h4>
                <p class="text-slate-500 text-xs font-medium ">Confirmed Partner: <span class="text-indigo-600 font-bold">Elite Logistics Pro</span></p>
                <div class="flex items-center gap-3 mt-4">
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-[9px] font-black uppercase tracking-widest">Confirmed</span>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg text-[9px] font-black uppercase tracking-widest">Vendor Notified</span>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-6 py-3 bg-white border border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-900 hover:bg-slate-900 hover:text-white transition-all">Modify</button>
            <button class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 transition-all shadow-lg active:scale-95">Chat Vendor</button>
        </div>
    </div>
</div>

