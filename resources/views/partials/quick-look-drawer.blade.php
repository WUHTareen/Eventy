<div x-data="{ 
        drawerOpen: false, 
        service: null, 
        loading: false,
        openDrawer(id) {
            this.drawerOpen = true;
            this.loading = true;
            // Fetch service details (Simulated or via Partial)
            fetch(`/services/${id}`, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-Partial': 'quick-look' }})
                .then(res => res.text())
                .then(html => {
                    this.service = html;
                    this.loading = false;
                });
        }
     }"
     @open-quick-look.window="openDrawer($event.detail.id)"
     class="fixed inset-0 z-[2000] pointer-events-none"
     x-cloak>
    
    <!-- Backdrop -->
    <div x-show="drawerOpen" 
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="drawerOpen = false"
         class="absolute inset-0 bg-slate-950/80 backdrop-blur-md pointer-events-auto"></div>

    <!-- Drawer Content -->
    <div x-show="drawerOpen" 
         x-transition:enter="transition ease-out duration-700 cubic-bezier(0.16, 1, 0.3, 1)"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="absolute top-0 right-0 h-full w-full max-w-2xl bg-white shadow-[-50px_0_100px_-20px_rgba(0,0,0,0.5)] pointer-events-auto flex flex-col">
        
        <!-- Header -->
        <div class="px-10 py-8 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div>

                <h3 class="text-3xl font-black text-slate-900 tracking-tighter uppercase leading-none">Quick <span class="text-slate-300">Look</span></h3>
            </div>
            <button @click="drawerOpen = false" class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-slate-900 hover:border-slate-900 transition-all">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Scrollable Content -->
        <div class="flex-grow overflow-y-auto p-10">


            <div x-html="service" class="animate-slide-up">
                <!-- If the request fails or is empty, show a luxury placeholder -->

            </div>
        </div>

        <!-- Footer Actions -->
        <div class="p-10 border-t border-slate-100 bg-slate-50 flex gap-4">
             <button @click="drawerOpen = false" class="flex-1 py-5 bg-white border border-slate-200 rounded-[2rem] text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-slate-900 hover:border-slate-900 transition-all">
                 Abandon View
             </button>
             <a :href="'/services/' + (service ? '...' : '')" class="flex-[2] py-5 bg-slate-900 text-white rounded-[2rem] text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-3 hover:bg-secondary-500 shadow-xl transition-all">
                 Full Experience <i class="fa-solid fa-arrow-right-long text-sm"></i>
             </a>
        </div>
    </div>
</div>

