<div x-data="{ compareModal: false }" 
     x-show="$store.compare.items.length > 0" 
     x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="translate-y-full opacity-0"
     x-transition:enter-end="translate-y-0 opacity-100"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="translate-y-0 opacity-100"
     x-transition:leave-end="translate-y-full opacity-0"
     class="fixed bottom-8 left-1/2 -translate-x-1/2 z-[100] w-full max-w-2xl px-6"
     x-cloak>
    
    <!-- Floating Interaction Bar -->
    <div class="bg-slate-900/90 backdrop-blur-2xl rounded-[2.5rem] border border-white/10 p-3 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] flex items-center justify-between gap-6">
        <div class="flex items-center gap-4 pl-4">
            <div class="relative">
                <div class="w-12 h-12 rounded-2xl bg-indigo-500/20 flex items-center justify-center text-indigo-400 border border-indigo-500/30">
                    <i class="fa-solid fa-layer-group text-xl"></i>
                </div>
                <div class="absolute -top-2 -right-2 w-6 h-6 bg-secondary-500 text-white text-[10px] font-black rounded-full flex items-center justify-center border-2 border-slate-900" x-text="$store.compare.items.length"></div>
            </div>
            <div>
                <h4 class="text-white font-black text-[11px] uppercase tracking-widest leading-none mb-1">Elite Comparison</h4>
                <p class="text-slate-400 text-[9px] font-bold uppercase tracking-tight">Select up to 3 for side-by-side analysis</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button @click="$store.compare.clear()" class="px-6 py-3 rounded-2xl text-[10px] font-black text-slate-400 hover:text-white uppercase tracking-widest transition-colors">
                Reset
            </button>
            <button @click="compareModal = true" class="px-8 py-3 bg-white text-slate-900 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-secondary-500 hover:text-white transition-all shadow-xl active:scale-95">
                Analyze Now <i class="fa-solid fa-arrow-right-long ml-2"></i>
            </button>
        </div>
    </div>

    <!-- Luxury Comparison Modal Overlay -->
    <template x-teleport="body">
        <div x-show="compareModal" 
             class="fixed inset-0 z-[1000] flex items-center justify-center p-6 md:p-12"
             x-cloak>
            
            <!-- Backdrop -->
            <div x-show="compareModal"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="compareModal = false"
                 class="absolute inset-0 bg-slate-950/90 backdrop-blur-xl"></div>

            <!-- Modal Content -->
            <div x-show="compareModal"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-12"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-12"
                 class="relative w-full max-w-7xl bg-white rounded-[3rem] shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
                
                <!-- Modal Header -->
                <div class="px-12 py-8 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div>
                        <span class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.3em] mb-2 block">Premium Suite</span>
                        <h2 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">Marketplace <span class="text-slate-400">Analysis</span></h2>
                    </div>
                    <button @click="compareModal = false" class="w-16 h-16 rounded-[1.5rem] bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-900 hover:border-slate-900 transition-all shadow-sm">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <!-- Comparison Grid -->
                <div class="p-12 overflow-y-auto flex-grow">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                        <template x-for="item in $store.compare.items" :key="item.id">
                            <div class="space-y-10 group/item">
                                <!-- Service Header card -->
                                <div class="relative h-64 rounded-[2.5rem] overflow-hidden shadow-2xl">
                                    <img :src="item.image" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent"></div>
                                    <div class="absolute bottom-6 left-6 right-6">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-[9px] font-black text-white uppercase tracking-widest border border-white/20" x-text="item.category"></span>
                                        </div>
                                        <h3 class="text-xl font-black text-white leading-tight" x-text="item.name"></h3>
                                    </div>
                                    <button @click="$store.compare.remove(item.id)" class="absolute top-4 right-4 w-10 h-10 bg-white/10 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:bg-red-500 transition-all opacity-0 group-hover/item:opacity-100">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </div>

                                <!-- Specs Table -->
                                <div class="space-y-6">
                                    <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100">
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Base Investment</p>
                                        <p class="text-3xl font-black text-indigo-600" x-text="'PKR ' + item.price"></p>
                                    </div>

                                    <div class="space-y-4 px-2">
                                        <div class="flex items-center justify-between text-sm py-4 border-b border-slate-100">
                                            <span class="font-bold text-slate-400 uppercase tracking-widest text-[10px]">Location</span>
                                            <span class="font-black text-slate-900" x-text="item.location"></span>
                                        </div>
                                        <div class="flex items-center justify-between text-sm py-4 border-b border-slate-100">
                                            <span class="font-bold text-slate-400 uppercase tracking-widest text-[10px]">Partner</span>
                                            <span class="font-black text-slate-900" x-text="item.vendor"></span>
                                        </div>
                                        <div class="flex items-center justify-between text-sm py-4 border-b border-slate-100">
                                            <span class="font-bold text-slate-400 uppercase tracking-widest text-[10px]">Reputation</span>
                                            <div class="flex items-center gap-1.5">
                                                <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                                <span class="font-black text-slate-900" x-text="item.rating"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <a :href="'/services/' + item.id" class="w-full flex items-center justify-center gap-3 py-5 bg-slate-900 text-white rounded-[2rem] font-black uppercase text-[10px] tracking-widest hover:bg-secondary-500 transition-all shadow-xl">
                                        View Masterpiece <i class="fa-solid fa-arrow-right-long transition-transform"></i>
                                    </a>
                                </div>
                            </div>
                        </template>

                        <!-- Empty slots if < 3 -->
                        <template x-if="$store.compare.items.length < 3">
                            <template x-for="i in (3 - $store.compare.items.length)" :key="i">
                                <div class="h-full border-2 border-dashed border-slate-100 rounded-[3rem] flex flex-col items-center justify-center p-12 text-center opacity-50">
                                    <div class="w-20 h-20 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 mb-6">
                                        <i class="fa-solid fa-plus text-3xl"></i>
                                    </div>
                                    <h4 class="text-slate-400 font-black text-[10px] uppercase tracking-widest leading-loose">Slot Available<br>Add service to compare</h4>
                                </div>
                            </template>
                        </template>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-12 py-8 bg-slate-50 border-t border-slate-100 flex items-center justify-center">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em]  text-center">Engineered by Eventy Intelligence Suite for Elite Market Analysis</p>
                </div>
            </div>
        </div>
    </template>
</div>

