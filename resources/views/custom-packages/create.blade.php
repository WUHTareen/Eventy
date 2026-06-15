@extends('layouts.public')

@section('title', 'Concierge Event Planner')

@section('content')
<div class="pt-24 pb-20 bg-gray-50/50 min-h-screen relative overflow-hidden" x-data="packageBuilder()" x-cloak>
    <!-- Background Accents -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-500/5 blur-[120px] rounded-full -z-10"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-secondary-500/5 blur-[120px] rounded-full -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <!-- Header Section -->
        <div class="mb-12">
            <h1 class="text-4xl font-black text-gray-900 tracking-tight mb-4 text-center lg:text-left">
                Concierge <span class="text-primary-500">Event Planner</span>
            </h1>
            <p class="text-gray-500 font-medium text-lg text-center lg:text-left">Select multiple premium services to create your unified custom experience.</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left: Premium Service Browser -->
            <div class="lg:w-2/3 space-y-8">
                <!-- Search & Filters -->
                <div class="bg-white/70 backdrop-blur-xl rounded-[2rem] p-8 shadow-xl border border-white">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="flex-1 relative group">
                            <i class="fa-solid fa-magnifying-glass absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-primary-500 transition-colors"></i>
                            <input type="text" x-model="search" placeholder="Search elite services..." 
                                class="w-full pl-14 pr-6 py-4 bg-gray-50/50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-500/10 focus:bg-white focus:border-primary-500 transition-all font-bold text-gray-900 shadow-inner">
                        </div>
                        <div class="relative">
                            <select x-model="categoryFilter" class="appearance-none pl-6 pr-14 py-4 bg-gray-50/50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-primary-500/10 focus:bg-white focus:border-primary-500 transition-all font-black text-xs uppercase tracking-widest text-gray-700 cursor-pointer shadow-inner min-w-[200px]">
                                <option value="all">Global Catalog</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Service Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <template x-for="service in filteredServices" :key="service.id">
                        <div class="group relative bg-white/70 backdrop-blur-xl rounded-[2.5rem] p-6 border-2 transition-all cursor-pointer overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-1"
                            :class="selectedServices.includes(service.id) ? 'border-primary-500 ring-4 ring-primary-500/5 bg-white' : 'border-white hover:border-primary-200'"
                            @click="toggleService(service.id)">
                            
                            <div class="flex gap-6 items-center">
                                <div class="w-24 h-24 rounded-[1.5rem] overflow-hidden flex-shrink-0 shadow-lg border-2 border-white relative">
                                    <img :src="service.image ? '/storage/' + service.image : 'https://images.unsplash.com/photo-1544126566-475a1062b183?auto=format&fit=crop&w=800&q=80'" 
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-primary-500/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <i class="fa-solid fa-plus text-white text-xl"></i>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="text-[10px] font-black text-primary-500 uppercase tracking-widest" x-text="service.category.name"></span>
                                        <div x-show="selectedServices.includes(service.id)" class="w-6 h-6 bg-primary-500 rounded-full flex items-center justify-center text-white text-[10px] shadow-lg animate-bounce">
                                            <i class="fa-solid fa-check"></i>
                                        </div>
                                    </div>
                                    <h3 class="font-black text-gray-900 text-lg leading-tight mb-2 tracking-tight" x-text="service.name"></h3>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-black text-gray-400">Starting from</span>
                                        <div class="text-primary-500 font-black text-lg tracking-tighter">Rs. <span x-text="new Intl.NumberFormat().format(service.price)"></span></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Selection Ripple effect -->
                            <div x-show="selectedServices.includes(service.id)" class="absolute top-0 right-0 p-4">
                                <span class="flex h-3 w-3 bg-primary-500 rounded-full animate-ping"></span>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Empty State -->
                <template x-if="filteredServices.length === 0">
                    <div class="text-center py-20 bg-white/30 rounded-[3rem] border border-dashed border-gray-200">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                            <i class="fa-solid fa-wand-magic-sparkles text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-gray-400">No Services Found</h3>
                        <p class="text-gray-400 font-medium">Try adjusting your filters for better options.</p>
                    </div>
                </template>
            </div>

            <!-- Right: Concierge Hub -->
            <div class="lg:w-1/3">
                <form action="{{ route('packages.store') }}" method="POST" enctype="multipart/form-data" class="sticky top-28">
                    @csrf
                    <div class="bg-gray-900 rounded-[2.5rem] p-10 shadow-2xl border border-gray-800 relative overflow-hidden">
                        <!-- Decorative glow -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-primary-500/10 blur-[60px] rounded-full"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center gap-4 mb-8">
                                <div class="w-12 h-12 bg-primary-500 rounded-2xl flex items-center justify-center text-white shadow-lg">
                                    <i class="fa-solid fa-briefcase text-xl"></i>
                                </div>
                                <h2 class="text-2xl font-black text-white tracking-tight">Concierge Hub</h2>
                            </div>
                            
                            <div class="space-y-6">
                                <div class="relative group/field">
                                    <label class="block text-[10px] font-black text-gray-500 mb-3 uppercase tracking-widest ml-1">Plan Identifier *</label>
                                    <input type="text" name="name" required placeholder="e.g. My Grand Wedding Bundle"
                                        class="w-full px-6 py-4 bg-gray-800/50 border border-gray-700 rounded-2xl focus:ring-4 focus:ring-primary-500/10 focus:bg-gray-800 focus:border-primary-500 transition-all font-bold text-white shadow-inner">
                                </div>
                                
                                <div class="relative group/field">
                                    <label class="block text-[10px] font-black text-gray-500 mb-3 uppercase tracking-widest ml-1">Special Requirements</label>
                                    <textarea name="description" rows="3" placeholder="Tell our concierge about your vision..."
                                        class="w-full px-6 py-4 bg-gray-800/50 border border-gray-700 rounded-2xl focus:ring-4 focus:ring-primary-500/10 focus:bg-gray-800 focus:border-primary-500 transition-all font-medium text-white shadow-inner"></textarea>
                                </div>

                                <!-- Selected Services Hidden Inputs -->
                                <template x-for="id in selectedServices">
                                    <input type="hidden" name="services[]" :value="id">
                                </template>

                                <div class="pt-8 mt-4 border-t border-gray-800">
                                    <div class="flex justify-between items-center mb-6">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Ensemble Count</span>
                                            <span class="text-xl font-black text-white" x-text="selectedServices.length + ' Elite Services'">0 Items</span>
                                        </div>
                                        <div class="w-12 h-12 rounded-full border border-gray-700 flex items-center justify-center">
                                            <i class="fa-solid fa-list-check text-primary-500"></i>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-gray-800/30 rounded-3xl p-6 border border-gray-800 mb-8 mt-2">
                                        <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest block mb-2">Estimated Aggregation</span>
                                        <div class="flex items-baseline gap-2">
                                            <span class="text-xs font-black text-primary-500">Rs.</span>
                                            <span class="text-4xl font-black text-white tracking-tighter" x-text="new Intl.NumberFormat().format(totalPrice)"></span>
                                        </div>
                                    </div>

                                    <button type="submit" :disabled="selectedServices.length === 0"
                                        class="group w-full py-5 bg-primary-500 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-primary-500/20 hover:bg-primary-600 transition-all disabled:opacity-30 disabled:cursor-not-allowed hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-3">
                                        Proceed to Booking
                                        <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                                    </button>
                                    
                                    <p class="text-center mt-6 text-[10px] font-black text-gray-600 uppercase tracking-tighter">Verified Concierge Selection System</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function packageBuilder() {
        return {
            services: @json($services),
            selectedServices: [],
            search: '',
            categoryFilter: 'all',
            
            get filteredServices() {
                return this.services.filter(s => {
                    const matchesSearch = s.name.toLowerCase().includes(this.search.toLowerCase());
                    const matchesCategory = this.categoryFilter === 'all' || s.category_id == this.categoryFilter;
                    return matchesSearch && matchesCategory;
                });
            },

            toggleService(id) {
                if (this.selectedServices.includes(id)) {
                    this.selectedServices = this.selectedServices.filter(sid => sid !== id);
                } else {
                    this.selectedServices.push(id);
                }
            },

            get totalPrice() {
                return this.services
                    .filter(s => this.selectedServices.includes(s.id))
                    .reduce((sum, s) => sum + parseFloat(s.price), 0);
            }
        }
    }
</script>
@endpush

@endsection


