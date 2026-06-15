@extends('layouts.public')

@section('title', 'Finalize Your Custom Ensemble')

@section('content')
<div class="py-24 bg-gray-50/50 min-h-screen relative overflow-hidden" x-data="packageBookingWizard()" x-cloak>
    <!-- Toast Notification System -->
    <div x-data="{ 
            show: false, 
            message: '', 
            type: 'error',
            notify(msg, type = 'error') { 
                this.message = msg; 
                this.type = type; 
                this.show = true; 
                setTimeout(() => this.show = false, 3000); 
            } 
        }"
        @notify.window="notify($event.detail.message, $event.detail.type)"
        class="fixed top-6 right-6 z-[100] flex flex-col gap-2 pointer-events-none">
        
        <div x-show="show" 
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 translate-x-8"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-8"
            class="pointer-events-auto bg-white rounded-2xl shadow-2xl shadow-gray-200/50 p-4 pr-6 border-l-4 min-w-[300px] max-w-md relative overflow-hidden flex items-start gap-3 backdrop-blur-md"
            :class="type === 'error' ? 'border-red-500' : 'border-green-500'">
            
            <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0"
                :class="type === 'error' ? 'bg-red-50 text-red-500' : 'bg-green-50 text-green-500'">
                <i class="fa-solid" :class="type === 'error' ? 'fa-circle-exclamation' : 'fa-circle-check'"></i>
            </div>
            <div>
                <h5 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-0.5" x-text="type === 'error' ? 'Attention' : 'Success'"></h5>
                <p class="text-xs font-medium text-gray-500 leading-relaxed" x-text="message"></p>
            </div>
        </div>
    </div>
    
    <!-- Background Accents -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary-500/5 blur-[120px] rounded-full"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-secondary-500/5 blur-[120px] rounded-full"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        
        <!-- Premium Progress Steps -->
        <div class="mb-16">
            <div class="flex items-center justify-between relative max-w-4xl mx-auto">
                <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-gray-200/50 -translate-y-1/2 -z-10"></div>
                <div class="absolute top-1/2 left-0 h-0.5 bg-gradient-to-r from-gray-900 to-primary-500 transition-all duration-700 -translate-y-1/2 -z-10" 
                     :style="'width: ' + ((step - 1) / 3 * 100) + '%'"></div>
                
                <template x-for="(s, i) in ['Patron', 'Venue', 'Vision', 'Review']" :key="i">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-black text-sm transition-all duration-500 border-4"
                             :class="step > i + 1 ? 'bg-gray-900 border-gray-900 text-white' : (step === i + 1 ? 'bg-white border-primary-500 text-primary-500 shadow-xl shadow-primary-500/20 scale-110' : 'bg-white border-gray-100 text-gray-300')">
                            <span x-show="step <= i + 1" x-text="i + 1"></span>
                            <i x-show="step > i + 1" class="fa-solid fa-check"></i>
                        </div>
                        <span class="text-[10px] mt-3 font-black uppercase tracking-widest text-center"
                              :class="step >= i + 1 ? 'text-gray-900' : 'text-gray-400'" x-text="s"></span>
                    </div>
                </template>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Ensemble Summary Card -->
            <div class="lg:order-2">
                <div class="sticky top-24 space-y-6">
                    <div class="bg-white/70 backdrop-blur-2xl rounded-[2.5rem] shadow-2xl border border-white overflow-hidden">
                        <div class="p-8 bg-gray-900 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-4 opacity-10">
                                <i class="fa-solid fa-gem text-6xl"></i>
                            </div>
                            <h3 class="text-xl font-black tracking-tight mb-2">Selected Ensemble</h3>
                            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">{{ $package->name }}</p>
                        </div>
                        <div class="p-8 space-y-6">
                            <div class="space-y-4">
                                @foreach($package->services as $service)
                                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-2xl border border-gray-100">
                                        <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center text-primary-600 flex-shrink-0">
                                            <i class="fa-solid fa-{{ $service->category->icon ?? 'star' }} text-xs"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-black text-gray-900 truncate">{{ $service->name }}</p>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase">{{ $service->category->name }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="pt-6 border-t border-gray-100">
                                <div class="flex justify-between items-baseline">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Valuation</span>
                                    <span class="text-2xl font-black text-primary-500 tracking-tighter">Rs. {{ number_format($package->total_price) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Concierge Note -->
                    <div class="bg-primary-500 rounded-[2rem] p-8 text-white shadow-xl relative overflow-hidden group">
                        <div class="absolute -right-4 -bottom-4 opacity-10 transition-transform group-hover:scale-110">
                            <i class="fa-solid fa-headset text-8xl"></i>
                        </div>
                        <h4 class="text-sm font-black uppercase mb-2 tracking-widest">Concierge Support</h4>
                        <p class="text-xs font-medium text-white/80 leading-relaxed">Our premium team will manually coordinate with all {{ $package->services->count() }} vendors to ensure flawless execution of your custom order.</p>
                    </div>
                </div>
            </div>

            <!-- Booking Form Column -->
            <div class="lg:col-span-2 lg:order-1">
                <form action="{{ route('packages.store_booking', $package->id) }}" method="POST" @submit="handleSubmit($event)">
                    @csrf
                    <div class="bg-white/70 backdrop-blur-2xl rounded-[3rem] shadow-2xl border border-white overflow-hidden">
                        
                        <!-- Step 1: Patron Details -->
                        <div x-show="step === 1" x-transition:enter="transition ease-out duration-500" 
                             x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                            <div class="p-10 md:p-16 space-y-10">
                                <div class="flex items-center gap-6 border-b border-gray-100 pb-8">
                                    <div class="w-16 h-16 bg-gray-900 rounded-[1.5rem] flex items-center justify-center text-white shadow-2xl transition-transform hover:rotate-3 shadow-primary-500/20">
                                        <i class="fa-solid fa-id-card text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-3xl font-black text-gray-900 tracking-tight">Identity & Reach</h3>
                                        <p class="text-gray-400 font-medium">Please verify your primary contact credentials.</p>
                                    </div>
                                </div>

                                <div class="space-y-8">
                                    <div class="relative group/field">
                                        <label class="block text-xs font-black text-gray-400 mb-3 ml-1 uppercase tracking-widest">Full Legal Name</label>
                                        <div class="relative">
                                            <i class="fa-solid fa-user absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within/field:text-gray-900 transition-colors"></i>
                                            <input type="text" name="customer_name" x-model="form.customer_name" required
                                                class="w-full pl-14 pr-6 py-5 bg-gray-50/50 border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-gray-900/5 focus:bg-white focus:border-gray-900 transition-all font-black text-gray-900 shadow-sm"
                                                placeholder="Enter full name">
                                        </div>
                                    </div>

                                    <div class="grid md:grid-cols-2 gap-8">
                                        <div class="relative group/field">
                                            <label class="block text-xs font-black text-gray-400 mb-3 ml-1 uppercase tracking-widest">Personal Contact</label>
                                            <div class="relative">
                                                <i class="fa-solid fa-phone absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within/field:text-gray-900 transition-colors"></i>
                                                <input type="tel" name="customer_phone" x-model="form.customer_phone" required
                                                    class="w-full pl-14 pr-6 py-5 bg-gray-50/50 border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-gray-900/5 focus:bg-white focus:border-gray-900 transition-all font-black text-gray-900 shadow-sm"
                                                    placeholder="+92 XXX XXXXXXX">
                                            </div>
                                        </div>
                                        <div class="relative group/field">
                                            <label class="block text-xs font-black text-gray-400 mb-3 ml-1 uppercase tracking-widest">Email Address</label>
                                            <div class="relative">
                                                <i class="fa-solid fa-envelope absolute left-6 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within/field:text-gray-900 transition-colors"></i>
                                                <input type="email" name="customer_email" x-model="form.customer_email" required
                                                    class="w-full pl-14 pr-6 py-5 bg-gray-50/50 border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-gray-900/5 focus:bg-white focus:border-gray-900 transition-all font-black text-gray-900 shadow-sm"
                                                    placeholder="name@example.com">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Logistics & Venue -->
                        <div x-show="step === 2" x-transition:enter="transition ease-out duration-500" 
                             x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                            <div class="p-10 md:p-16 space-y-10">
                                <div class="flex items-center gap-6 border-b border-gray-100 pb-8">
                                    <div class="w-16 h-16 bg-primary-500 rounded-[1.5rem] flex items-center justify-center text-white shadow-2xl transition-transform hover:-rotate-3">
                                        <i class="fa-solid fa-map-location-dot text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-3xl font-black text-gray-900 tracking-tight">Time & Space</h3>
                                        <p class="text-gray-400 font-medium">Specify the moment and location for your ensemble.</p>
                                    </div>
                                </div>

                                <div class="space-y-8" x-transition>
                                    <div class="grid md:grid-cols-2 gap-8">
                                        <div class="relative group/field">
                                            <label class="block text-xs font-black text-gray-400 mb-3 ml-1 uppercase tracking-widest">Event Start Date</label>
                                            <div class="relative">
                                                <i class="fa-solid fa-calendar-day absolute left-6 top-1/2 -translate-y-1/2 text-primary-300 group-focus-within/field:text-primary-500 transition-colors"></i>
                                                <input type="datetime-local" name="booking_date" x-model="form.booking_date" required
                                                    class="w-full pl-14 pr-6 py-5 bg-gray-50/50 border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-primary-500/10 focus:bg-white focus:border-primary-500 transition-all font-black text-gray-900 shadow-sm">
                                            </div>
                                        </div>
                                        <div class="relative group/field">
                                            <label class="block text-xs font-black text-gray-400 mb-3 ml-1 uppercase tracking-widest">Event End Date</label>
                                            <div class="relative">
                                                <i class="fa-solid fa-calendar-check absolute left-6 top-1/2 -translate-y-1/2 text-blue-300 group-focus-within/field:text-blue-500 transition-colors"></i>
                                                <input type="datetime-local" name="event_end_date" x-model="form.event_end_date"
                                                    class="w-full pl-14 pr-6 py-5 bg-gray-50/50 border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-blue-500/10 focus:bg-white focus:border-blue-500 transition-all font-black text-gray-900 shadow-sm">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid md:grid-cols-2 gap-8">
                                        <div class="relative group/field">
                                            <label class="block text-xs font-black text-gray-400 mb-3 ml-1 uppercase tracking-widest">Event City</label>
                                            <div class="relative">
                                                <i class="fa-solid fa-city absolute left-6 top-1/2 -translate-y-1/2 text-indigo-300 group-focus-within/field:text-indigo-500 transition-colors"></i>
                                                <input type="text" name="event_location" x-model="form.event_location" required
                                                    class="w-full pl-14 pr-6 py-5 bg-gray-50/50 border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:bg-white focus:border-indigo-500 transition-all font-black text-gray-900 shadow-sm"
                                                    placeholder="e.g. Lahore, Karachi">
                                            </div>
                                        </div>
                                        <div class="relative group/field">
                                            <label class="block text-xs font-black text-gray-400 mb-3 ml-1 uppercase tracking-widest">Total Guest Count</label>
                                            <div class="relative">
                                                <i class="fa-solid fa-users-viewfinder absolute left-6 top-1/2 -translate-y-1/2 text-indigo-300 group-focus-within/field:text-indigo-500 transition-colors"></i>
                                                <input type="number" name="guest_count" x-model="form.guest_count" required min="1"
                                                    class="w-full pl-14 pr-6 py-5 bg-gray-50/50 border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:bg-white focus:border-indigo-500 transition-all font-black text-gray-900 shadow-sm"
                                                    placeholder="e.g. 150">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Service Specific Dynamic Fields -->
                                    <template x-if="hasCategory('venues')">
                                        <div class="grid md:grid-cols-2 gap-8 border-l-4 border-primary-500 pl-6 py-2">
                                            <div class="relative group/field">
                                                <label class="block text-xs font-black text-gray-400 mb-3 ml-1 uppercase tracking-widest">Venue Seating Layout</label>
                                                <select name="booking_data[seating_layout]" x-model="form.booking_data.seating_layout" 
                                                    class="w-full px-6 py-5 bg-white border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-primary-500/10 font-black text-gray-900 shadow-sm appearance-none focus:border-primary-500 transition-all">
                                                    <option value="theater">Theater Style</option>
                                                    <option value="banquet">Banquet Style</option>
                                                    <option value="classroom">Classroom Style</option>
                                                    <option value="u-shape">U-Shape Style</option>
                                                    <option value="round_table">Round Table</option>
                                                </select>
                                            </div>
                                            <div class="relative group/field">
                                                <label class="block text-xs font-black text-gray-400 mb-3 ml-1 uppercase tracking-widest">In-House Catering</label>
                                                <select name="booking_data[venue_catering]" x-model="form.booking_data.venue_catering"
                                                    class="w-full px-6 py-5 bg-white border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-primary-500/10 font-black text-gray-900 shadow-sm appearance-none focus:border-primary-500 transition-all">
                                                    <option value="no">Not Required</option>
                                                    <option value="standard">Standard Menu</option>
                                                    <option value="premium">Premium Menu</option>
                                                </select>
                                            </div>
                                        </div>
                                    </template>

                                    <template x-if="hasCategory('transport')">
                                        <div class="grid md:grid-cols-2 gap-8 border-l-4 border-secondary-500 pl-6 py-2">
                                            <div class="relative group/field">
                                                <label class="block text-xs font-black text-gray-400 mb-3 ml-1 uppercase tracking-widest">Chauffeur Service</label>
                                                <select name="booking_data[with_driver]" x-model="form.booking_data.with_driver"
                                                    class="w-full px-6 py-5 bg-white border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-secondary-500/10 font-black text-gray-900 shadow-sm appearance-none focus:border-secondary-500 transition-all">
                                                    <option value="yes">With Professional Driver</option>
                                                    <option value="no">Self-Drive Experience</option>
                                                </select>
                                            </div>
                                            <div class="relative group/field">
                                                <label class="block text-xs font-black text-gray-400 mb-3 ml-1 uppercase tracking-widest">Pickup Address</label>
                                                <input type="text" name="booking_data[pickup_address]" x-model="form.booking_data.pickup_address"
                                                    class="w-full px-6 py-5 bg-white border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-secondary-500/10 font-black text-gray-900 shadow-sm focus:border-secondary-500 transition-all"
                                                    placeholder="Precise pickup location">
                                            </div>
                                        </div>
                                    </template>

                                    <template x-if="hasCategory('catering')">
                                        <div class="grid md:grid-cols-2 gap-8 border-l-4 border-emerald-500 pl-6 py-2">
                                            <div class="relative group/field">
                                                <label class="block text-xs font-black text-gray-400 mb-3 ml-1 uppercase tracking-widest">Menu Type</label>
                                                <select name="booking_data[menu_type]" x-model="form.booking_data.menu_type"
                                                    class="w-full px-6 py-5 bg-white border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-emerald-500/10 font-black text-gray-900 shadow-sm appearance-none focus:border-emerald-500 transition-all">
                                                    <option value="buffet">Buffet Service</option>
                                                    <option value="box">Individual Boxes</option>
                                                    <option value="sitting">Table Service</option>
                                                </select>
                                            </div>
                                            <div class="relative group/field">
                                                <label class="block text-xs font-black text-gray-400 mb-3 ml-1 uppercase tracking-widest">Food Preference</label>
                                                <select name="booking_data[food_pref]" x-model="form.booking_data.food_pref"
                                                    class="w-full px-6 py-5 bg-white border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-emerald-500/10 font-black text-gray-900 shadow-sm appearance-none focus:border-emerald-500 transition-all">
                                                    <option value="mixed">Mixed Menu</option>
                                                    <option value="non-veg">Non-Veg Only</option>
                                                    <option value="veg">Veg Only</option>
                                                </select>
                                            </div>
                                        </div>
                                    </template>

                                    <div class="relative group/field">
                                        <label class="block text-xs font-black text-gray-400 mb-3 ml-1 uppercase tracking-widest">Full Event Address</label>
                                        <div class="relative">
                                            <i class="fa-solid fa-map-pin absolute left-6 top-1/2 -translate-y-1/2 text-pink-300 group-focus-within/field:text-pink-500 transition-colors"></i>
                                            <input type="text" name="event_address" x-model="form.event_address" required
                                                class="w-full pl-14 pr-6 py-5 bg-gray-50/50 border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-pink-500/10 focus:bg-white focus:border-pink-500 transition-all font-black text-gray-900 shadow-sm"
                                                placeholder="House/Plot/Hall full address">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Vision & Briefing -->
                        <div x-show="step === 3" x-transition:enter="transition ease-out duration-500" 
                             x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
                            <div class="p-10 md:p-16 space-y-10">
                                <div class="flex items-center gap-6 border-b border-gray-100 pb-8">
                                    <div class="w-16 h-16 bg-gray-900 rounded-[1.5rem] flex items-center justify-center text-white shadow-2xl transition-transform">
                                        <i class="fa-solid fa-wand-sparkles text-2xl animate-spin-slow"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-3xl font-black text-gray-900 tracking-tight">Vision Briefing</h3>
                                        <p class="text-gray-400 font-medium">Help our vendors understand the nuances of your vision.</p>
                                    </div>
                                </div>

                                <div class="space-y-8">
                                    <div class="relative group/field">
                                        <label class="block text-xs font-black text-gray-400 mb-3 ml-1 uppercase tracking-widest">Total Budget Expectation (PKR)</label>
                                        <div class="relative">
                                            <i class="fa-solid fa-money-bill-wave absolute left-6 top-1/2 -translate-y-1/2 text-emerald-300 group-focus-within/field:text-emerald-500 transition-colors"></i>
                                            <input type="number" name="budget" x-model="form.budget"
                                                class="w-full pl-14 pr-20 py-5 bg-gray-50/50 border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-emerald-500/10 focus:bg-white focus:border-emerald-500 transition-all font-black text-gray-900 shadow-sm"
                                                placeholder="Enter target budget for all services">
                                            <span class="absolute right-6 top-1/2 -translate-y-1/2 text-xs font-black text-gray-400 uppercase tracking-tighter">PKR</span>
                                        </div>
                                    </div>

                                    <div class="relative group/field">
                                        <div class="flex items-center gap-3 mb-4 ml-1">
                                            <i class="fa-solid fa-calendar-check text-indigo-500 text-[10px]"></i>
                                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest">Collective Service Agenda</label>
                                        </div>
                                        <textarea name="notes" x-model="form.notes" rows="6"
                                            class="w-full px-10 py-8 bg-white border border-gray-100 rounded-[2.5rem] focus:ring-8 focus:ring-indigo-500/5 focus:bg-white focus:border-indigo-500 transition-all font-medium text-gray-900 shadow-xl shadow-gray-200/50 placeholder-gray-300"
                                            placeholder="Outline the sequence or core objectives for this unified experience..."></textarea>
                                    </div>

                                    <div class="relative group/field">
                                        <label class="block text-xs font-black text-gray-400 mb-3 ml-1 uppercase tracking-widest">Elite Service Alterations</label>
                                        <textarea name="special_requests" x-model="form.special_requests" rows="4"
                                            class="w-full px-8 py-6 bg-gray-50/50 border border-gray-100 rounded-[2rem] focus:ring-4 focus:ring-primary-500/10 focus:bg-white focus:border-primary-500 transition-all font-medium text-gray-900 shadow-sm"
                                            placeholder="Mention any service-specific alterations..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Final Affirmation -->
                        <div x-show="step === 4" x-transition:enter="transition ease-out duration-500" 
                             x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                            <div class="p-10 md:p-16 space-y-10">
                                <div class="flex items-center gap-6 border-b border-gray-100 pb-8">
                                    <div class="w-16 h-16 bg-primary-500 rounded-[1.5rem] flex items-center justify-center text-white shadow-2xl animate-pulse">
                                        <i class="fa-solid fa-check-double text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-3xl font-black text-gray-900 tracking-tight">System Confirmation</h3>
                                        <p class="text-gray-400 font-medium">Review your high-density ensemble booking.</p>
                                    </div>
                                </div>

                                <div class="bg-gray-50/50 rounded-[2.5rem] p-10 border border-gray-100 space-y-10">
                                    <div class="grid md:grid-cols-2 gap-10">
                                        <div class="space-y-6">
                                            <div class="flex items-center gap-3">
                                                <i class="fa-solid fa-circle-user text-primary-500 text-xs"></i>
                                                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Patron Identity</h4>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-lg font-black text-gray-900" x-text="form.customer_name"></p>
                                                <p class="text-xs font-bold text-gray-500" x-text="form.customer_phone"></p>
                                                <p class="text-xs font-bold text-gray-500 truncate" x-text="form.customer_email"></p>
                                            </div>
                                        </div>
                                        <div class="space-y-6">
                                            <div class="flex items-center gap-3">
                                                <i class="fa-solid fa-compass text-primary-500 text-xs"></i>
                                                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Event Deployment</h4>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-lg font-black text-primary-600" x-text="formatDate(form.booking_date)"></p>
                                                <p class="text-xs font-bold text-gray-900" x-text="form.event_location"></p>
                                                <p class="text-xs font-medium text-gray-500" x-text="form.event_address"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-10 border-t border-gray-200/50 space-y-8">
                                        <div class="flex items-center gap-3">
                                            <i class="fa-solid fa-layer-group text-primary-500 text-xs"></i>
                                            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Ensemble Components & Specifics</h4>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            @foreach($package->services as $service)
                                                <div class="p-6 bg-white rounded-2xl border border-gray-100 shadow-sm group hover:border-primary-200 transition-colors">
                                                    <div class="flex justify-between items-start mb-3">
                                                        <p class="text-[10px] font-black text-primary-500 uppercase tracking-tighter">{{ $service->category->name }}</p>
                                                        <i class="fa-solid fa-{{ $service->category->icon ?? 'star' }} text-gray-200 group-hover:text-primary-500 transition-colors"></i>
                                                    </div>
                                                    <p class="text-sm font-black text-gray-900 truncate mb-4">{{ $service->name }}</p>
                                                    
                                                    <!-- Dynamic Detail Summary -->
                                                    <div class="space-y-2 border-t border-gray-50 pt-3">
                                                        <template x-if="'{{ $service->category->slug }}' === 'venues'">
                                                            <div class="flex justify-between text-[10px] font-bold">
                                                                <span class="text-gray-400">Layout</span>
                                                                <span class="text-gray-900 uppercase" x-text="form.booking_data.seating_layout || 'Standard'"></span>
                                                            </div>
                                                        </template>
                                                        <template x-if="'{{ $service->category->slug }}' === 'transport'">
                                                            <div class="flex justify-between text-[10px] font-bold">
                                                                <span class="text-gray-400">Driver</span>
                                                                <span class="text-gray-900 uppercase" x-text="form.booking_data.with_driver === 'yes' ? 'Included' : 'Self-drive'"></span>
                                                            </div>
                                                        </template>
                                                        <template x-if="'{{ $service->category->slug }}' === 'catering'">
                                                            <div class="flex justify-between text-[10px] font-bold">
                                                                <span class="text-gray-400">Menu</span>
                                                                <span class="text-gray-900 uppercase" x-text="form.booking_data.menu_type || 'Standard'"></span>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-primary-50 rounded-[2rem] p-8 border border-primary-100 flex items-start gap-6">
                                    <div class="w-12 h-12 bg-primary-500 rounded-2xl flex items-center justify-center text-white shrink-0 shadow-lg">
                                        <i class="fa-solid fa-shield-halved"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-black text-gray-900 uppercase mb-1">Elite Coordination Guarantee</h4>
                                        <p class="text-xs font-medium text-gray-500 leading-relaxed">Your unified order will be split into individual requests for all vendors. Our concierge will oversee the synchronization of all services.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Footer -->
                        <div class="px-10 md:px-16 py-10 bg-gray-50 border-t border-gray-100 flex items-center justify-between rounded-b-[3rem]">
                            <button type="button" x-show="step > 1" @click="step--"
                                class="group flex items-center gap-3 px-8 py-4 bg-white border border-gray-200 text-gray-900 rounded-[1.25rem] font-black text-xs uppercase tracking-widest hover:bg-gray-900 hover:text-white hover:border-gray-900 transition-all shadow-sm">
                                <i class="fa-solid fa-chevron-left transition-transform group-hover:-translate-x-1"></i>
                                Back
                            </button>
                            <div x-show="step === 1"></div>
                            
                            <button type="button" x-show="step < 4" @click="nextStep()"
                                class="group flex items-center gap-3 px-10 py-4 bg-gray-900 text-white rounded-[1.25rem] font-black text-xs uppercase tracking-widest hover:bg-primary-600 transition-all shadow-2xl">
                                Continue
                                <i class="fa-solid fa-chevron-right transition-transform group-hover:translate-x-1"></i>
                            </button>
                            
                            <button type="submit" x-show="step === 4"
                                class="group flex items-center gap-4 px-12 py-4 bg-primary-500 text-white rounded-[1.25rem] font-black text-xs uppercase tracking-widest hover:bg-primary-600 transition-all shadow-2xl hover:scale-[1.02] active:scale-95">
                                Dispatch Ensemble Order
                                <i class="fa-solid fa-paper-plane transition-transform group-hover:translate-x-1 group-hover:-translate-y-1"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function packageBookingWizard() {
        return {
            step: 1,
            form: {
                customer_name: '{{ Auth::user()->name ?? '' }}',
                customer_phone: '',
                customer_email: '{{ Auth::user()->email ?? '' }}',
                booking_date: '',
                event_end_date: '',
                event_location: '',
                event_address: '',
                guest_count: '',
                budget: '{{ $package->total_price }}',
                notes: '',
                special_requests: '',
                booking_data: {
                    seating_layout: 'theater',
                    venue_catering: 'no',
                    with_driver: 'yes',
                    pickup_address: '',
                    menu_type: 'buffet',
                    food_pref: 'mixed'
                }
            },
            categories: @json($package->services->pluck('category.slug')->unique()->values()),
            hasCategory(slug) {
                return this.categories.includes(slug);
            },
            nextStep() {
                if (this.validateStep()) {
                    this.step++;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            },
            validateStep() {
                if (this.step === 1) {
                    if (!this.form.customer_name || !this.form.customer_phone || !this.form.customer_email) {
                        this.$dispatch('notify', { message: 'Identity credentials are required.' });
                        return false;
                    }
                }
                if (this.step === 2) {
                    if (!this.form.booking_date || !this.form.event_location || !this.form.event_address) {
                        this.$dispatch('notify', { message: 'Deployment logistics are required.' });
                        return false;
                    }
                }
                return true;
            },
            formatDate(date) {
                if (!date) return '-';
                try {
                    return new Date(date).toLocaleString('en-PK', { 
                        dateStyle: 'medium', 
                        timeStyle: 'short' 
                    });
                } catch (e) {
                    return date;
                }
            },
            handleSubmit(e) {
                if (this.step !== 4) {
                    e.preventDefault();
                    return false;
                }
                return true;
            }
        }
    }
</script>
@endpush
@endsection


