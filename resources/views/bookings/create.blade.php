@extends('layouts.public')

@section('title', 'Book ' . $service->name)

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .booking-bg {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            background-size: 100% 100vh;
            background-repeat: no-repeat;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 
                0 4px 6px -1px rgba(0, 0, 0, 0.1), 
                0 2px 4px -1px rgba(0, 0, 0, 0.06),
                0 20px 25px -5px rgba(0, 0, 0, 0.1), 
                0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        .input-group input:focus ~ label,
        .input-group input:not(:placeholder-shown) ~ label,
        .input-group select:focus ~ label,
        .input-group select:not(:placeholder-shown) ~ label,
        .input-group textarea:focus ~ label,
        .input-group textarea:not(:placeholder-shown) ~ label {
            top: -0.5rem;
            left: 0.75rem;
            font-size: 0.75rem;
            background-color: white;
            padding: 0 0.5rem;
            color: #4F46E5;
            font-weight: 600;
        }

        .step-connector {
            position: absolute;
            top: 2rem;
            left: 0;
            width: 100%;
            height: 2px;
            background: #E2E8F0;
            z-index: 0;
        }
        
        .step-item.active .step-circle {
            background-color: #4F46E5;
            color: white;
            border-color: #4F46E5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.2);
        }
        
        .step-item.completed .step-circle {
            background-color: #10B981;
            color: white;
            border-color: #10B981;
        }

        .animate-spin-slow {
            animation: spin 3s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Ticket Perforation */
        .perforation {
            position: relative;
            height: 1.5rem;
            background: white;
            margin: 0 1rem;
        }
        .perforation::before, .perforation::after {
            content: "";
            position: absolute;
            top: -0.75rem;
            width: 1.5rem;
            height: 1.5rem;
            background: #F8FAFC; /* Matches background */
            border-radius: 50%;
        }
        .perforation::before { left: -1.75rem; }
        .perforation::after { right: -1.75rem; }
        .perforation-border {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            border-bottom: 2px dashed #E2E8F0;
        }
    </style>
    @endpush

    @section('content')
    <div class="min-h-screen booking-bg py-12 px-4 sm:px-6 lg:px-8 font-sans" x-data="bookingWizard()" x-cloak>
        
        <!-- Navbar Placeholder/Back Button -->
        <div class="max-w-7xl mx-auto mb-8 flex justify-between items-center text-white/90">
            <a href="{{ route('services.show', $service) }}" class="group flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md transition-all border border-white/10 hover:border-white/30">
                <i class="fa-solid fa-arrow-left-long group-hover:-translate-x-1 transition-transform"></i>
                <span class="text-sm font-medium">Back to Service</span>
            </a>
            <div class="hidden sm:flex items-center gap-3">
                <span class="text-xs font-bold uppercase tracking-widest opacity-75">Secure Checkout</span>
                <i class="fa-solid fa-lock text-emerald-400"></i>
            </div>
        </div>

        <div class="max-w-7xl mx-auto grid lg:grid-cols-12 gap-8">
            
            <!-- Left Side: Form -->
            <div class="lg:col-span-8">
                <div class="glass-card rounded-[2rem] p-5 sm:p-8 md:p-12 relative overflow-hidden">
                    
                    <!-- Progress Header -->
                    <div class="mb-12 relative px-4">
                        <div class="step-connector">
                            <div class="h-full bg-indigo-600 transition-all duration-500 rounded-full" :style="'width: ' + ((step - 1) / 2 * 100) + '%'"></div>
                        </div>
                        <div class="flex justify-between relative z-10">
                            <template x-for="(label, idx) in ['Identity', 'Details', 'Review']">
                                <div class="step-item flex flex-col items-center gap-2 cursor-pointer group" 
                                     :class="{'active': step === idx + 1, 'completed': step > idx + 1}"
                                     @click="if(step > idx + 1) step = idx + 1">
                                    <div class="step-circle w-10 h-10 rounded-full bg-white border-2 border-slate-200 flex items-center justify-center font-bold text-sm transition-all duration-300 text-slate-400 group-hover:border-slate-300">
                                        <i x-show="step > idx + 1" class="fa-solid fa-check"></i>
                                        <span x-show="step <= idx + 1" x-text="idx + 1"></span>
                                    </div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 transition-colors"
                                          :class="{'text-indigo-600': step >= idx + 1}" x-text="label"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <form @submit.prevent="handleSubmit" action="{{ route('services.store_booking', $service->id) }}" method="POST" id="bookingForm">
                        @csrf

                        <!-- Session Alerts -->
                        @if(session('success'))
                            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 flex items-center gap-3">
                                <i class="fa-solid fa-circle-check text-green-600 text-xl"></i>
                                <p class="text-green-700 font-medium">{{ session('success') }}</p>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 flex items-center gap-3">
                                <i class="fa-solid fa-circle-xmark text-red-600 text-xl"></i>
                                <p class="text-red-700 font-medium">{{ session('error') }}</p>
                            </div>
                        @endif

                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200">
                                <div class="flex items-center gap-3 text-red-800 font-bold mb-2">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <h3>Please correct the following errors:</h3>
                                </div>
                                <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- STEP 1: IDENTITY -->
                        <div x-show="step === 1" ...>
                            <!-- ... existing content ... -->
                            <div class="grid gap-6">
                                <!-- ... inputs ... -->
                                <div class="relative input-group">
                                    <input type="text" id="customer_name" name="customer_name" x-model="form.customer_name" placeholder=" "
                                           class="w-full h-14 px-4 pt-1 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-0 outline-none transition-colors peer bg-slate-50/50">
                                    <label for="customer_name" class="absolute top-4 left-4 text-slate-400 text-sm transition-all pointer-events-none">Full Name</label>
                                </div>
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="relative input-group">
                                        <input type="email" id="customer_email" name="customer_email" x-model="form.customer_email" placeholder=" "
                                               class="w-full h-14 px-4 pt-1 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-0 outline-none transition-colors peer bg-slate-50/50">
                                        <label for="customer_email" class="absolute top-4 left-4 text-slate-400 text-sm transition-all pointer-events-none">Email Address</label>
                                    </div>
                                    <div class="relative input-group">
                                        <input type="tel" id="customer_phone" name="customer_phone" x-model="form.customer_phone" placeholder=" "
                                               class="w-full h-14 px-4 pt-1 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-0 outline-none transition-colors peer bg-slate-50/50">
                                        <label for="customer_phone" class="absolute top-4 left-4 text-slate-400 text-sm transition-all pointer-events-none">Phone Number</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 2: DETAILS -->
                        <div x-show="step === 2" ... style="display: none;">
                           <!-- ... existing content ... -->
                            <div class="space-y-6">
                                <!-- Type & Package -->
                                <div class="grid md:grid-cols-2 gap-6">
                                    <!-- ... select inputs ... -->
                                    <div class="relative input-group">
                                        <select x-model="form.event_type" name="event_type" id="event_type" class="w-full h-14 px-4 pt-1 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-0 outline-none transition-colors appearance-none bg-slate-50/50">
                                            <!-- ... options ... -->
                                             <template x-if="isTransport">
                                                <optgroup label="Transport">
                                                    <option value="daily">Daily Rental</option>
                                                    <option value="intercity">Intercity Travel</option>
                                                    <option value="wedding_car">Wedding Ceremony</option>
                                                </optgroup>
                                            </template>
                                            <template x-if="!isTransport">
                                                <optgroup label="Standard Types">
                                                    <option value="standard">Standard Package</option>
                                                    <option value="premium">Premium Package</option>
                                                    <option value="custom">Custom Requirement</option>
                                                </optgroup>
                                            </template>
                                        </select>
                                        <label for="event_type" ...>Service Type</label>
                                        <i class="fa-solid fa-chevron-down ..."></i>
                                    </div>

                                    @if(!empty($service->packages))
                                    <div class="relative input-group">
                                        <select x-model="form.package_name" name="package_name" id="package_name" class="w-full h-14 px-4 pt-1 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-0 outline-none transition-colors appearance-none bg-slate-50/50">
                                            <option value="">Base Tier (Rs. {{ number_format($service->price) }})</option>
                                            @foreach($service->packages as $pkg)
                                                <option value="{{ $pkg['name'] }}">{{ $pkg['name'] }} (Rs. {{ number_format($pkg['price']) }})</option>
                                            @endforeach
                                        </select>
                                        <label for="package_name" ...>Package Tier</label>
                                        <i class="fa-solid fa-layer-group ..."></i>
                                    </div>
                                    @endif
                                </div>

                                <!-- Date & Location -->
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div x-show="!isLodging" x-cloak>
                                        <div class="relative input-group">
                                            <input type="text" id="booking-date-picker" name="booking_date_visual" x-model.fill="form.booking_date" placeholder=" " class="w-full h-14 px-4 pt-1 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-0 outline-none transition-colors bg-slate-50/50">
                                            <label class="absolute top-4 left-4 text-slate-400 text-sm transition-all pointer-events-none" x-text="isTransport ? 'Pickup Date & Time' : (isVisa ? 'Departure Date' : (isBrand ? 'Expected Delivery Date' : 'Target Date & Time'))">Start Date & Time</label>
                                            <i class="fa-regular fa-calendar absolute right-4 top-4 text-slate-300"></i>
                                        </div>
                                    </div>

                                    <div x-show="isLodging" x-cloak>
                                        <div class="relative input-group w-full">
                                            <input type="text" id="lodging-range-picker" name="booking_date_visual_lodging" x-model.fill="form.booking_date" placeholder=" " class="w-full h-14 px-4 pt-1 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-0 outline-none transition-colors bg-slate-50/50">
                                            <label class="absolute top-4 left-4 text-slate-400 text-sm transition-all pointer-events-none">Select Stay Window (Arrival - Departure)</label>
                                            <i class="fa-solid fa-calendar-range absolute right-4 top-4 text-slate-300"></i>
                                        </div>
                                    </div>
                                    
                                    <!-- Default Passenger Counter (Hidden for Transport) -->
                                    <div x-show="!isMedia && !isBrand && !isTransport">
                                        <div class="relative input-group">
                                            <input type="number" name="guest_count" x-model="form.guest_count" min="1" placeholder=" " class="w-full h-14 px-4 pt-1 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-0 outline-none transition-colors bg-slate-50/50">
                                            <label class="absolute top-4 left-4 text-slate-400 text-sm transition-all pointer-events-none" x-text="isCatering ? 'No. of Plates / Guests' : (isLodging ? 'No. of Guests' : (isVisa ? 'Passengers (e.g., 1 Adult)' : (isVenue || isEvent || isMega ? 'Expected Gathering Size' : (isVendor ? 'Required Manpower/Staff' : 'Unit Count'))))">Number of Guests</label>
                                            <i class="fa-solid fa-user-group absolute right-4 top-4 text-slate-300"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="relative input-group" x-show="!isVenue && !isBrand && !isTransport">
                                        <input type="text" name="event_location" x-model="form.event_location" placeholder=" " class="w-full h-14 px-4 pt-1 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-0 outline-none transition-colors bg-slate-50/50">
                                        <label class="absolute top-4 left-4 text-slate-400 text-sm transition-all pointer-events-none" x-text="isVisa ? 'From? (e.g., Karachi KHI)' : (isMega ? 'Project Site / Jurisdiction' : 'Location / Venue Address')">Location / Venue Address</label>
                                        <i class="fa-solid fa-map-pin absolute right-4 top-4 text-slate-300"></i>
                                    </div>
                                    <div class="relative input-group" x-show="(isTransport && form.event_type === 'daily') || isLodging || isVendor || isMega">
                                        <input type="number" name="booking_data[duration_days]" x-model="form.duration_days" min="1" placeholder=" " class="w-full h-14 px-4 pt-1 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-0 outline-none transition-colors bg-slate-50/50">
                                        <label class="absolute top-4 left-4 text-slate-400 text-sm transition-all pointer-events-none shadow-sm shadow-white" x-text="isLodging ? 'Total Nights' : (isVendor ? 'Contract Days' : 'Duration (Days)')">Duration (Days)</label>
                                        <i class="fa-solid fa-clock-rotate-left absolute right-4 top-4 text-slate-300"></i>
                                    </div>
                                </div>

                                <!-- Dynamic Category Fields -->
                                <div x-show="isTransport" class="p-6 bg-blue-50/50 rounded-2xl border border-blue-100 space-y-5">
                                    <div class="flex items-center gap-3 mb-2">
                                        <i class="fa-solid fa-van-shuttle text-blue-500 text-lg"></i>
                                        <h4 class="text-sm font-black uppercase tracking-widest text-blue-700">Transport Details</h4>
                                    </div>

                                    <!-- Row 1: Passengers & Luggage -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- Passengers Counter -->
                                        <div class="border border-blue-200 rounded-xl bg-white flex items-center justify-between px-3 sm:px-4 h-12 overflow-hidden">
                                            <div class="flex items-center gap-2 min-w-0">
                                                <i class="fa-solid fa-user-group text-blue-300 text-sm flex-shrink-0"></i>
                                                <span class="text-[10px] sm:text-xs text-blue-500 font-black uppercase tracking-widest truncate">Passengers</span>
                                            </div>
                                            <div class="flex items-center gap-2 flex-shrink-0">
                                                <button type="button" @click="form.guest_count = Math.max(1, form.guest_count - 1)" class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-blue-50 border border-blue-200 text-blue-600 font-black hover:bg-blue-100 transition-all flex items-center justify-center">−</button>
                                                <span class="text-xs sm:text-sm font-black text-blue-900 min-w-[16px] sm:min-w-[20px] text-center" x-text="form.guest_count">1</span>
                                                <input type="hidden" name="guest_count" x-model="form.guest_count">
                                                <button type="button" @click="form.guest_count = Math.min(50, form.guest_count + 1)" class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-blue-50 border border-blue-200 text-blue-600 font-black hover:bg-blue-100 transition-all flex items-center justify-center">+</button>
                                            </div>
                                        </div>
                                        <!-- Luggage Counter -->
                                        <div class="border border-blue-200 rounded-xl bg-white flex items-center justify-between px-3 sm:px-4 h-12 overflow-hidden">
                                            <div class="flex items-center gap-2 min-w-0">
                                                <i class="fa-solid fa-suitcase text-blue-300 text-sm flex-shrink-0"></i>
                                                <span class="text-[10px] sm:text-xs text-blue-500 font-black uppercase tracking-widest truncate">Luggage</span>
                                            </div>
                                            <div class="flex items-center gap-2 flex-shrink-0">
                                                <button type="button" @click="form.luggage_count = Math.max(0, form.luggage_count - 1)" class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-blue-50 border border-blue-200 text-blue-600 font-black hover:bg-blue-100 transition-all flex items-center justify-center">−</button>
                                                <span class="text-xs sm:text-sm font-black text-blue-900 min-w-[16px] sm:min-w-[20px] text-center" x-text="form.luggage_count">0</span>
                                                <input type="hidden" name="booking_data[luggage]" x-model="form.luggage_count">
                                                <button type="button" @click="form.luggage_count = Math.min(20, form.luggage_count + 1)" class="w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-blue-50 border border-blue-200 text-blue-600 font-black hover:bg-blue-100 transition-all flex items-center justify-center">+</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Row 2: Pickup & Dropoff Addresses -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="relative">
                                            <div class="absolute -top-2.5 left-4 bg-white px-2 z-10">
                                                <span class="text-[10px] sm:text-xs font-black text-blue-500 uppercase tracking-widest">Pickup City</span>
                                            </div>
                                            <div class="flex items-center gap-2 sm:gap-3 h-12 border border-blue-200 rounded-xl bg-white px-3 sm:px-4 focus-within:border-blue-500 transition-colors relative">
                                                <i class="fa-solid fa-location-dot text-blue-300 flex-shrink-0"></i>
                                                <select name="event_location" x-model="form.event_location" class="flex-1 min-w-0 bg-transparent text-xs sm:text-sm font-bold text-slate-800 outline-none appearance-none cursor-pointer w-full h-full pr-8">
                                                    <option value="" disabled selected>Select pickup city...</option>
                                                    <option value="Islamabad">Islamabad</option>
                                                    <option value="Lahore">Lahore</option>
                                                    <option value="Karachi">Karachi</option>
                                                    <option value="Rawalpindi">Rawalpindi</option>
                                                    <option value="Faisalabad">Faisalabad</option>
                                                    <option value="Multan">Multan</option>
                                                    <option value="Peshawar">Peshawar</option>
                                                    <option value="Quetta">Quetta</option>
                                                    <option value="Other">Other (Specify in Notes)</option>
                                                </select>
                                                <i class="fa-solid fa-chevron-down text-blue-200 absolute right-3 sm:right-4 pointer-events-none text-xs"></i>
                                            </div>
                                        </div>
                                        <div class="relative">
                                            <div class="absolute -top-2.5 left-4 bg-white px-2 z-10">
                                                <span class="text-[10px] sm:text-xs font-black text-rose-500 uppercase tracking-widest">Dropoff City</span>
                                            </div>
                                            <div class="flex items-center gap-2 sm:gap-3 h-12 border border-rose-200 rounded-xl bg-white px-3 sm:px-4 focus-within:border-rose-500 transition-colors relative">
                                                <i class="fa-solid fa-flag-checkered text-rose-300 flex-shrink-0"></i>
                                                <select name="booking_data[dropoff_location]" x-model="form.dropoff_location" class="flex-1 min-w-0 bg-transparent text-xs sm:text-sm font-bold text-slate-800 outline-none appearance-none cursor-pointer w-full h-full pr-8">
                                                    <option value="" disabled selected>Select dropoff city...</option>
                                                    <option value="Islamabad">Islamabad</option>
                                                    <option value="Lahore">Lahore</option>
                                                    <option value="Karachi">Karachi</option>
                                                    <option value="Rawalpindi">Rawalpindi</option>
                                                    <option value="Faisalabad">Faisalabad</option>
                                                    <option value="Multan">Multan</option>
                                                    <option value="Peshawar">Peshawar</option>
                                                    <option value="Quetta">Quetta</option>
                                                    <option value="Other">Other (Specify in Notes)</option>
                                                </select>
                                                <i class="fa-solid fa-chevron-down text-rose-200 absolute right-3 sm:right-4 pointer-events-none text-xs"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Row 3: Pickup & Dropoff Times -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- Pickup Time -->
                                        <div class="relative min-w-0">
                                            <div class="absolute -top-2.5 left-4 bg-white px-2 z-10">
                                                <span class="text-[10px] sm:text-xs font-black text-blue-500 uppercase tracking-widest">Pickup Time</span>
                                            </div>
                                            <div class="flex items-center gap-2 sm:gap-3 h-12 border border-blue-200 rounded-xl bg-white px-3 sm:px-4 focus-within:border-blue-500 transition-colors">
                                                <i class="fa-regular fa-clock text-blue-200 flex-shrink-0"></i>
                                                <input type="text" id="pickup-time-picker" name="booking_data[pickup_time]" x-model="form.pickup_time" placeholder="Click to select..." class="flex-1 min-w-0 bg-transparent text-xs sm:text-sm font-bold text-slate-800 outline-none placeholder:text-slate-300 cursor-pointer">
                                            </div>
                                        </div>
                                        <!-- Dropoff Time -->
                                        <div class="relative min-w-0">
                                            <div class="absolute -top-2.5 left-4 bg-white px-2 z-10">
                                                <span class="text-[10px] sm:text-xs font-black text-rose-500 uppercase tracking-widest">Dropoff Time</span>
                                            </div>
                                            <div class="flex items-center gap-2 sm:gap-3 h-12 border border-rose-200 rounded-xl bg-white px-3 sm:px-4 focus-within:border-rose-500 transition-colors">
                                                <i class="fa-regular fa-clock text-rose-200 flex-shrink-0"></i>
                                                <input type="text" id="dropoff-time-picker" name="booking_data[dropoff_time]" x-model="form.dropoff_time" placeholder="Click to select..." class="flex-1 min-w-0 bg-transparent text-xs sm:text-sm font-bold text-slate-800 outline-none placeholder:text-slate-300 cursor-pointer">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div x-show="isCatering" class="p-6 bg-orange-50/50 rounded-2xl border border-orange-100">
                                    <h4 class="text-xs font-bold uppercase tracking-widest text-orange-600 mb-4">Catering Details</h4>
                                    <div class="relative input-group">
                                        <textarea name="booking_data[menu_preference]" rows="3" placeholder=" " class="w-full p-4 rounded-lg border border-orange-200 focus:border-orange-500 outline-none bg-white"></textarea>
                                        <label class="text-xs font-bold text-orange-400 absolute -top-2 left-3 bg-white px-1">Menu Preferences</label>
                                    </div>
                                </div>

                                <div x-show="isMedia" class="p-6 bg-purple-50/50 rounded-2xl border border-purple-100">
                                    <h4 class="text-xs font-bold uppercase tracking-widest text-purple-600 mb-4">Coverage</h4>
                                    <div class="relative input-group">
                                        <input type="number" name="booking_data[coverage_hours]" min="1" placeholder=" " class="w-full h-12 px-4 rounded-lg border border-purple-200 focus:border-purple-500 outline-none bg-white">
                                        <label class="text-xs font-bold text-purple-400 absolute -top-2 left-3 bg-white px-1">Hours Needed</label>
                                    </div>
                                </div>

                                <div x-show="isVisa" class="p-8 bg-emerald-50/30 rounded-3xl border border-emerald-100/50 space-y-8">
                                    <div>
                                        <h4 class="text-sm font-black text-emerald-900 uppercase tracking-widest mb-1 flex items-center gap-2">
                                            <i class="fa-solid fa-plane-departure text-emerald-500"></i>
                                            Flight & Expedition Details
                                        </h4>
                                        <p class="text-[10px] text-emerald-600/70 font-bold uppercase tracking-widest">Specify your mission parameters</p>
                                    </div>

                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div class="relative input-group">
                                            <select name="booking_data[trip_type]" x-model="form.trip_type" class="w-full h-14 px-4 pt-1 rounded-xl border border-emerald-200 focus:border-emerald-500 outline-none bg-white font-bold text-emerald-900 appearance-none">
                                                <option value="round_trip">Round-Trip</option>
                                                <option value="one_way">One-Way</option>
                                            </select>
                                            <label class="text-xs font-bold text-emerald-500 absolute -top-2.5 left-4 bg-white px-2 rounded-full border border-emerald-100">Trip Configuration</label>
                                            <i class="fa-solid fa-right-left absolute right-4 top-5 text-emerald-200"></i>
                                        </div>
                                        <div class="relative input-group" x-show="form.trip_type === 'round_trip'">
                                            <input type="date" name="booking_data[return_date]" x-model="form.return_date" class="w-full h-14 px-4 pt-1 rounded-xl border border-emerald-200 focus:border-emerald-500 outline-none bg-white font-bold text-emerald-900">
                                            <label class="text-xs font-bold text-emerald-500 absolute -top-2.5 left-4 bg-white px-2 rounded-full border border-emerald-100">Return Date</label>
                                        </div>
                                    </div>

                                    <div class="grid md:grid-cols-2 gap-6">
                                        <div class="relative input-group">
                                            <input type="text" name="booking_data[flight_destination]" x-model="form.flight_destination" placeholder=" " class="w-full h-14 px-4 pt-1 rounded-xl border border-emerald-200 focus:border-emerald-500 outline-none bg-white font-black text-emerald-900 uppercase placeholder:text-emerald-100">
                                            <label class="text-xs font-bold text-emerald-500 absolute -top-2.5 left-4 bg-white px-2 rounded-full border border-emerald-100">To? (Destination Airport/City)</label>
                                            <i class="fa-solid fa-location-dot absolute right-4 top-5 text-emerald-200"></i>
                                        </div>
                                        <div class="relative input-group">
                                            <select name="booking_data[flight_class]" x-model="form.flight_class" class="w-full h-14 px-4 pt-1 rounded-xl border border-emerald-200 focus:border-emerald-500 outline-none bg-white appearance-none font-bold text-emerald-900">
                                                <option value="economy">Economy</option>
                                                <option value="premium_economy">Premium Economy</option>
                                                <option value="business">Business</option>
                                                <option value="first">First Class</option>
                                            </select>
                                            <label class="text-xs font-bold text-emerald-500 absolute -top-2.5 left-4 bg-white px-2 rounded-full border border-emerald-100">Cabin Class</label>
                                            <i class="fa-solid fa-chair absolute right-4 top-5 text-emerald-200"></i>
                                        </div>
                                    </div>

                                    <div class="pt-6 border-t border-emerald-100 mt-8">
                                        <div class="flex items-center justify-between mb-6">
                                            <div>
                                                <h4 class="text-sm font-black text-indigo-900 uppercase tracking-widest flex items-center gap-2">
                                                    <i class="fa-solid fa-user-tie text-indigo-500"></i>
                                                    Primary Passenger
                                                </h4>
                                                <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Adult (Over 12 years)</p>
                                            </div>
                                            <span class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">Required</span>
                                        </div>

                                        <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-4 mb-8 flex gap-3 items-start">
                                            <i class="fa-solid fa-circle-info text-blue-500 mt-1"></i>
                                            <p class="text-[11px] font-bold text-blue-700 leading-relaxed">
                                                To avoid boarding complications, enter all names exactly as they appear in your passport/ID.
                                            </p>
                                        </div>

                                        <div class="grid md:grid-cols-2 gap-6 mb-6">
                                            <div class="relative input-group">
                                                <input type="text" name="booking_data[passenger_given_names]" x-model="form.passenger_given_names" placeholder="e.g. Oliver James" class="w-full h-12 px-4 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none bg-white text-sm font-bold">
                                                <label class="text-[10px] font-black text-slate-400 absolute -top-2.5 left-4 bg-white px-2 uppercase tracking-widest">Given names</label>
                                            </div>
                                            <div class="relative input-group">
                                                <input type="text" name="booking_data[passenger_surname]" x-model="form.passenger_surname" placeholder="e.g. Brown" class="w-full h-12 px-4 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none bg-white text-sm font-bold">
                                                <label class="text-[10px] font-black text-slate-400 absolute -top-2.5 left-4 bg-white px-2 uppercase tracking-widest">Surnames</label>
                                            </div>
                                        </div>

                                        <div class="grid md:grid-cols-3 gap-4 mb-6">
                                            <div class="relative input-group col-span-1">
                                                <select name="booking_data[passenger_nationality]" x-model="form.passenger_nationality" class="w-full h-12 px-4 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none bg-white text-sm font-bold appearance-none">
                                                    <option value="">Select Nationality</option>
                                                    <option value="PK">Pakistan</option>
                                                    <option value="US">United States</option>
                                                    <option value="GB">United Kingdom</option>
                                                    <option value="AE">UAE</option>
                                                    <option value="SA">Saudi Arabia</option>
                                                </select>
                                                <label class="text-[10px] font-black text-slate-400 absolute -top-2.5 left-4 bg-white px-2 uppercase tracking-widest">Nationality</label>
                                            </div>
                                            <div class="relative input-group col-span-1">
                                                <select name="booking_data[passenger_gender]" x-model="form.passenger_gender" class="w-full h-12 px-4 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none bg-white text-sm font-bold appearance-none">
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="other">Other</option>
                                                </select>
                                                <label class="text-[10px] font-black text-slate-400 absolute -top-2.5 left-4 bg-white px-2 uppercase tracking-widest">Gender</label>
                                            </div>
                                            <div class="relative input-group col-span-1 border border-slate-100 rounded-xl bg-slate-50/50 p-2">
                                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 block ml-2">Date of Birth</label>
                                                <div class="flex gap-1">
                                                    <select x-model="form.passenger_dob.day" class="w-1/3 h-8 bg-white border border-slate-200 rounded-lg text-[10px] font-bold outline-none">
                                                        <option value="">DD</option>
                                                        @for($i=1; $i<=31; $i++) <option value="{{$i}}">{{sprintf('%02d', $i)}}</option> @endfor
                                                    </select>
                                                    <select x-model="form.passenger_dob.month" class="w-1/3 h-8 bg-white border border-slate-200 rounded-lg text-[10px] font-bold outline-none">
                                                        <option value="">MM</option>
                                                        @foreach(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] as $m)
                                                            <option value="{{$m}}">{{$m}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" x-model="form.passenger_dob.year" placeholder="YYYY" class="w-1/3 h-8 bg-white border border-slate-200 rounded-lg text-[10px] font-bold outline-none text-center">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grid md:grid-cols-2 gap-6">
                                            <div class="relative input-group">
                                                <input type="text" name="booking_data[passenger_passport]" x-model="form.passenger_passport" placeholder="Passport or ID number..." class="w-full h-12 px-4 rounded-xl border border-slate-200 focus:border-indigo-500 outline-none bg-white text-sm font-bold">
                                                <label class="text-[10px] font-black text-slate-400 absolute -top-2.5 left-4 bg-white px-2 uppercase tracking-widest">Passport or ID number</label>
                                            </div>
                                            <div class="relative input-group border border-slate-100 rounded-xl bg-slate-50/50 p-2">
                                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 block ml-2">Passport Expiration Date</label>
                                                <div class="flex gap-1">
                                                    <select x-model="form.passenger_passport_expiry.day" class="w-1/3 h-8 bg-white border border-slate-200 rounded-lg text-[10px] font-bold outline-none">
                                                        <option value="">DD</option>
                                                        @for($i=1; $i<=31; $i++) <option value="{{$i}}">{{sprintf('%02d', $i)}}</option> @endfor
                                                    </select>
                                                    <select x-model="form.passenger_passport_expiry.month" class="w-1/3 h-8 bg-white border border-slate-200 rounded-lg text-[10px] font-bold outline-none">
                                                        <option value="">MM</option>
                                                        @foreach(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] as $m)
                                                            <option value="{{$m}}">{{$m}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" x-model="form.passenger_passport_expiry.year" placeholder="YYYY" class="w-1/3 h-8 bg-white border border-slate-200 rounded-lg text-[10px] font-bold outline-none text-center">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div x-show="isLodging" class="p-6 bg-rose-50/50 rounded-2xl border border-rose-100">
                                    <h4 class="text-xs font-bold uppercase tracking-widest text-rose-600 mb-4">Room Details</h4>
                                    <div class="grid md:grid-cols-2 gap-4">
                                        <div class="relative input-group">
                                            <select name="booking_data[room_type]" x-model="form.room_type" class="w-full h-12 px-4 rounded-lg border border-rose-200 focus:border-rose-500 outline-none bg-white appearance-none">
                                                <option value="Standard">Standard Room</option>
                                                <option value="Deluxe">Deluxe Room</option>
                                                <option value="Suite">Executive Suite</option>
                                                <option value="Family">Family Room</option>
                                            </select>
                                            <label class="text-xs font-bold text-rose-400 absolute -top-2 left-3 bg-white px-1">Room Type</label>
                                        </div>
                                        <div class="relative input-group">
                                            <input type="number" name="booking_data[room_count]" x-model="form.room_count" min="1" placeholder=" " class="w-full h-12 px-4 rounded-lg border border-rose-200 focus:border-rose-500 outline-none bg-white">
                                            <label class="text-xs font-bold text-rose-400 absolute -top-2 left-3 bg-white px-1">No. of Rooms</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Hidden Mappings for Transport -->
                                <template x-if="isTransport">
                                    <div style="display:none;">
                                        <input type="hidden" name="booking_data[passengers]" :value="form.guest_count">
                                        <input type="hidden" name="booking_data[pickup_location]" :value="form.event_location">
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- STEP 3: REVIEW -->
                        <div x-show="step === 3" x-transition class="space-y-8">
                            <div class="bg-slate-50 rounded-3xl p-8 border border-slate-100">
                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6 flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-xs">03</span>
                                    Final Protocol Review
                                </h4>
                                
                                <div class="grid md:grid-cols-2 gap-8">
                                    <div class="space-y-4">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-extra">Principal Contact</p>
                                        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm shadow-slate-100/50">
                                            <p class="text-xs font-black text-slate-800" x-text="form.customer_name"></p>
                                            <div class="mt-2 space-y-1">
                                                <p class="text-[11px] text-slate-500 flex items-center gap-2 italic">
                                                    <i class="fa-solid fa-envelope text-[9px] text-slate-300"></i>
                                                    <span x-text="form.customer_email"></span>
                                                </p>
                                                <p class="text-[11px] text-slate-500 flex items-center gap-2 italic">
                                                    <i class="fa-solid fa-phone text-[9px] text-slate-300"></i>
                                                    <span x-text="form.customer_phone"></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="space-y-4">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-extra" x-text="isTransport ? 'Fleet Assignment' : (isLodging ? 'Reservations' : (isTravel ? 'Expedition Specs' : (isVisa ? 'Aviation Defaults' : (isBrand ? 'Creative Brief' : 'Mission Specs'))))">Mission Details</p>
                                        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm shadow-slate-100/50">
                                            <div class="flex flex-col gap-2">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-[10px] text-slate-400 uppercase font-bold" x-text="isTransport ? 'Deployment' : (isLodging ? 'Check-in' : (isVisa ? 'Departure' : (isBrand ? 'Delivery' : 'Target Date')))">Target Date</span>
                                                    <span class="text-xs font-black text-indigo-900" x-text="form.booking_date"></span>
                                                </div>
                                                <template x-if="isLodging && form.event_end_date">
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-[10px] text-slate-400 uppercase font-bold">Check-out</span>
                                                        <span class="text-xs font-black text-indigo-900" x-text="form.event_end_date"></span>
                                                    </div>
                                                </template>
                                                <template x-if="!isBrand">
                                                    <div class="flex justify-between items-center border-t border-slate-50 pt-2 mt-1">
                                                        <span class="text-[10px] text-slate-400 uppercase font-bold" x-text="isTransport ? 'Base' : (isMega ? 'Project Site' : 'Venue')">Location</span>
                                                        <span class="text-xs font-black text-slate-700" x-text="form.event_location || 'Fixed Location'"></span>
                                                    </div>
                                                </template>
                                                <template x-if="isTransport && form.dropoff_location">
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-[10px] text-slate-400 uppercase font-bold">Terminal</span>
                                                        <span class="text-xs font-black text-slate-700" x-text="form.dropoff_location"></span>
                                                    </div>
                                                </template>
                                                <template x-if="isTransport && (form.pickup_time || form.dropoff_time)">
                                                    <div class="flex flex-col gap-2 border-t border-slate-50 pt-2 mt-1">
                                                        <div class="flex justify-between items-center" x-show="form.pickup_time">
                                                            <span class="text-[10px] text-slate-400 uppercase font-bold text-blue-600">Pickup Schedule</span>
                                                            <span class="text-xs font-black text-blue-900" x-text="form.pickup_time"></span>
                                                        </div>
                                                        <div class="flex justify-between items-center" x-show="form.dropoff_time">
                                                            <span class="text-[10px] text-slate-400 uppercase font-bold text-red-600">Dropoff Schedule</span>
                                                            <span class="text-xs font-black text-red-900" x-text="form.dropoff_time"></span>
                                                        </div>
                                                    </div>
                                                </template>
                                                <template x-if="isVisa && form.passenger_given_names">
                                                    <div class="flex justify-between items-center border-t border-slate-50 pt-2 mt-1">
                                                        <span class="text-[10px] text-slate-400 uppercase font-bold">Primary Guest</span>
                                                        <span class="text-xs font-black text-indigo-900" x-text="form.passenger_given_names + ' ' + form.passenger_surname"></span>
                                                    </div>
                                                </template>
                                                <template x-if="isVisa && form.return_date && form.trip_type === 'round_trip'">
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-[10px] text-slate-400 uppercase font-bold">Return Flight</span>
                                                        <span class="text-xs font-black text-slate-700" x-text="form.return_date"></span>
                                                    </div>
                                                </template>
                                                <template x-if="isVisa && form.flight_destination">
                                                    <div class="flex justify-between items-center border-t border-slate-50 pt-2 mt-1">
                                                        <span class="text-[10px] text-slate-400 uppercase font-bold">Expedition Site</span>
                                                        <span class="text-xs font-black text-slate-700 uppercase" x-text="form.flight_destination"></span>
                                                    </div>
                                                </template>
                                                <template x-if="isVisa && form.flight_class">
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-[10px] text-slate-400 uppercase font-bold">Mission Class</span>
                                                        <span class="text-xs font-black text-slate-700 uppercase"><span x-text="form.flight_class"></span> (<span x-text="form.trip_type.replace('_', '-')"></span>)</span>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="relative group">
                                <textarea name="special_requests" x-model="form.special_requests" rows="4" placeholder=" "
                                          class="w-full p-6 rounded-3xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all peer bg-white placeholder:text-transparent"></textarea>
                                <label class="absolute top-6 left-6 text-slate-400 text-sm transition-all pointer-events-none peer-focus:top-[-0.5rem] peer-focus:left-6 peer-focus:text-xs peer-focus:bg-white peer-focus:px-2 peer-focus:text-indigo-600 peer-focus:font-bold">Additional Intelligence / Special Requirements</label>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-10 pt-6 border-t border-slate-100 flex items-center justify-between">
                            <!-- ... buttons ... -->
                             <button type="button" x-show="step > 1" @click="step--" class="text-slate-500 font-bold text-sm hover:text-slate-800 transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-arrow-left"></i> Previous
                            </button>
                            <div x-show="step === 1" class="flex-1"></div>

                            <button type="button" x-show="step < 3" @click="nextStep"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3.5 rounded-xl font-bold text-sm shadow-lg shadow-indigo-500/30 transition-all flex items-center gap-2">
                                Next Step <i class="fa-solid fa-arrow-right"></i>
                            </button>

                            <button type="submit" x-show="step === 3" :disabled="isSubmitting"
                                    class="bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-10 py-4 rounded-xl font-bold text-sm uppercase tracking-wider shadow-lg shadow-emerald-500/30 transition-all flex items-center gap-3 disabled:opacity-75 disabled:cursor-not-allowed">
                                <span x-show="!isSubmitting">Confirm Booking</span>
                                <span x-show="isSubmitting"><i class="fa-solid fa-circle-notch fa-spin"></i> Processing</span>
                            </button>
                        </div>

                        <!-- Hidden Inputs -->
                        <template x-for="addon in form.selected_addons" :key="addon">
                            <input type="hidden" name="selected_addons[]" :value="addon">
                        </template>
                        <input type="hidden" name="coupon_code" :value="appliedCoupon ? appliedCoupon.code : ''">
                        <input type="hidden" name="total_price" :value="estimatedCost">
                        <input type="hidden" name="booking_date" :value="form.booking_date">
                        <input type="hidden" name="event_end_date" :value="form.event_end_date">
                    </form>
                </div>
            </div>

            <!-- Right Side: Sidebar Ticket -->
            <div class="lg:col-span-4 sticky top-24 h-fit">
                <div class="bg-white rounded-[1.5rem] shadow-2xl shadow-indigo-900/10 overflow-hidden">
                    <!-- Ticket Header -->
                    <div class="bg-[#1e1b4b] p-6 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <i class="fa-solid fa-receipt text-6xl transform rotate-12"></i>
                        </div>
                        <p class="text-[10px] font-bold uppercase tracking-widest opacity-70 mb-1">Booking Summary</p>
                        <h3 class="text-xl font-bold leading-tight relative z-10">{{ $service->name }}</h3>
                        <div class="flex items-center gap-2 mt-2 text-indigo-200 text-xs">
                            <i class="fa-solid fa-store"></i>
                            <span>{{ $service->user->name ?? 'Vendor' }}</span>
                        </div>
                    </div>

                    <!-- Perforation -->
                    <div class="perforation">
                        <div class="perforation-border"></div>
                    </div>

                    <div class="p-6 pt-2 bg-white">
                        <div class="flex items-center gap-4 mb-6">
                            <img src="{{ $service->getFeaturedImage() ? (Str::startsWith($service->getFeaturedImage(), ['http', 'https']) ? $service->getFeaturedImage() : asset('storage/' . $service->getFeaturedImage())) : 'https://via.placeholder.com/64' }}" 
                                 class="w-16 h-16 rounded-xl object-cover shadow-md">
                            <div>
                                <span class="bg-indigo-50 text-indigo-600 px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider">
                                    {{ $service->category->name ?? 'Service' }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-4 text-[11px] mb-8">
                            <!-- Tactical Data Points (Dynamic) -->
                            <div class="flex justify-between items-center group/row" x-show="form.booking_date">
                                <span class="text-slate-400 font-bold uppercase tracking-widest" x-text="isTransport ? 'Pickup Date' : (isLodging ? 'Arrival Date' : (isTravel ? 'Departure' : (isVisa ? 'Submission' : 'Target Date')))">Target Date</span>
                                <span class="font-black text-[#1e1b4b] uppercase" x-text="form.booking_date"></span>
                            </div>

                            <div class="flex justify-between items-center group/row" x-show="form.package_name">
                                <span class="text-slate-400 font-bold uppercase tracking-widest">Selected Tier</span>
                                <span class="font-black text-[#1e1b4b] uppercase" x-text="form.package_name"></span>
                            </div>

                            <div class="flex justify-between items-center group/row" x-show="form.guest_count > 0 && !isMedia && !isBrand">
                                <span class="text-slate-400 font-bold uppercase tracking-widest" x-text="isTransport ? 'Passengers' : (isCatering ? 'Plates' : (isLodging ? 'Guests' : (isVisa ? 'Passengers' : (isVendor ? 'Manpower' : 'Unit Count'))))">Unit Count</span>
                                <span class="font-black text-[#1e1b4b] uppercase" x-text="form.guest_count"></span>
                            </div>

                            <div class="flex justify-between items-center group/row" x-show="form.event_location && !isVenue && !isBrand">
                                <span class="text-slate-400 font-bold uppercase tracking-widest" x-text="isTransport ? 'Pickup' : (isVisa || isTravel ? 'Origin' : (isMega ? 'Site' : 'Location'))">Location</span>
                                <span class="font-black text-[#1e1b4b] uppercase truncate max-w-[120px]" x-text="form.event_location"></span>
                            </div>

                            <div class="flex justify-between items-center group/row" x-show="isTransport && form.dropoff_location">
                                <span class="text-slate-400 font-bold uppercase tracking-widest">Dropoff</span>
                                <span class="font-black text-[#1e1b4b] uppercase truncate max-w-[120px]" x-text="form.dropoff_location"></span>
                            </div>

                            <div class="flex justify-between items-center group/row" x-show="isTransport && form.luggage_count > 0">
                                <span class="text-slate-400 font-bold uppercase tracking-widest">Luggage</span>
                                <span class="font-black text-[#1e1b4b] uppercase"><span x-text="form.luggage_count"></span> items</span>
                            </div>

                            <div class="flex justify-between items-center group/row" x-show="isVisa && form.flight_destination">
                                <span class="text-slate-400 font-bold uppercase tracking-widest">Destination</span>
                                <span class="font-black text-[#1e1b4b] uppercase truncate max-w-[120px]" x-text="form.flight_destination"></span>
                            </div>

                            <div class="flex justify-between items-center group/row" x-show="isVisa && form.trip_type === 'round_trip' && form.return_date">
                                <span class="text-slate-400 font-bold uppercase tracking-widest">Return Date</span>
                                <span class="font-black text-[#1e1b4b] uppercase truncate max-w-[120px]" x-text="form.return_date"></span>
                            </div>

                            <div class="flex justify-between items-center group/row" x-show="isTransport && form.pickup_time">
                                <span class="text-blue-500 font-bold uppercase tracking-widest">Pickup Time</span>
                                <span class="font-black text-blue-900 uppercase" x-text="form.pickup_time"></span>
                            </div>

                            <div class="flex justify-between items-center group/row" x-show="isTransport && form.dropoff_time">
                                <span class="text-rose-500 font-bold uppercase tracking-widest">Dropoff Time</span>
                                <span class="font-black text-rose-900 uppercase" x-text="form.dropoff_time"></span>
                            </div>

                            <div class="flex justify-between items-center group/row" x-show="(form.duration_days > 1 || (isLodging && form.duration_days)) && (isTransport || isLodging || isVendor || isMega)">
                                <span class="text-slate-400 font-bold uppercase tracking-widest" x-text="isLodging ? 'Duration' : 'Rent Period'">Duration</span>
                                <span class="font-black text-[#1e1b4b] uppercase"><span x-text="form.duration_days"></span> <span x-text="isLodging ? 'Nights' : 'Days'">Days</span></span>
                            </div>

                            <div class="flex justify-between items-center group/row" x-show="isLodging && form.room_count > 0">
                                <span class="text-slate-400 font-bold uppercase tracking-widest">Deployment</span>
                                <span class="font-black text-[#1e1b4b] uppercase"><span x-text="form.room_count"></span>x <span x-text="form.room_type"></span></span>
                            </div>

                            <template x-if="form.selected_addons.length > 0">
                                <div class="pt-4 border-t border-dashed border-slate-100">
                                    <p class="text-[9px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-3">Loaded Modules</p>
                                    <div class="space-y-2">
                                        <template x-for="addon in form.selected_addons" :key="addon">
                                            <div class="flex justify-between items-center">
                                                <span class="text-slate-500 font-bold uppercase text-[9px]" x-text="addon"></span>
                                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Promo Code -->
                        <div class="mb-6">
                            <div class="relative flex items-center">
                                <i class="fa-solid fa-tag absolute left-3 text-slate-400 text-xs"></i>
                                <input type="text" x-model="couponCode" 
                                       class="w-full bg-slate-50 border border-slate-200 rounded-lg py-2.5 pl-9 pr-20 text-xs font-bold uppercase focus:outline-none focus:border-indigo-400 transition-colors"
                                       placeholder="PROMO CODE" :disabled="appliedCoupon">
                                <button type="button" @click="applyCoupon" 
                                        class="absolute right-1 top-1 bottom-1 px-3 bg-slate-800 hover:bg-black text-white text-[10px] font-bold rounded-md uppercase tracking-wide transition-colors"
                                        x-show="!appliedCoupon"
                                        :disabled="!couponCode || isApplyingCoupon">
                                    Apply
                                </button>
                                <button type="button" @click="removeCoupon" 
                                        class="absolute right-2 text-rose-500 hover:text-rose-700 transition-colors"
                                        x-show="appliedCoupon">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                </button>
                            </div>
                            <p x-show="couponError" class="text-[10px] text-red-500 font-bold mt-1 ml-1" x-text="couponError"></p>
                            <div x-show="appliedCoupon" class="mt-2 text-center bg-emerald-50 border border-emerald-100 rounded-lg p-2">
                                <p class="text-xs text-emerald-600 font-bold">Coupon Applied!</p>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="bg-indigo-50 rounded-xl p-5 border border-indigo-100">
                            <div class="flex justify-between items-center mb-1" x-show="discountAmount > 0">
                                <span class="text-xs font-medium text-slate-500">Discount</span>
                                <span class="text-xs font-bold text-emerald-600">- Rs. <span x-text="discountAmount.toLocaleString()"></span></span>
                            </div>
                            <div class="flex justify-between items-end">
                                <span class="text-xs font-bold uppercase tracking-widest text-indigo-400">Total Est.</span>
                                <div class="text-right">
                                    <span class="text-xs text-slate-400 font-medium">PKR</span>
                                    <span class="text-2xl font-black text-indigo-900 leading-none" x-text="estimatedCost.toLocaleString()"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Toast -->
        <div x-data="{ show: false, message: '' }"
             @notify.window="message = $event.detail.message; show = true; setTimeout(() => show = false, 4000)"
             class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50">
            <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 scale-95"
                 class="bg-slate-900/90 backdrop-blur text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-3">
                <i class="fa-solid fa-circle-info text-indigo-400"></i>
                <span class="text-sm font-medium" x-text="message"></span>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('bookingWizard', () => ({
                step: 1,
                isSubmitting: false,
                categorySlug: '{{ optional($service->category)->slug ?? 'misc' }}',

                get isTransport() { 
                    return ['transport-logistics', 'transport', 'luxury-rentals', 'coasters-buses', 'protocol-jeeps', 'luxury-car-rentals', 'airport-trans', 'luxury-cars', 'guest-transport'].includes(this.categorySlug); 
                },
                get isLodging() { 
                    return ['venues-coordination', 'hotels', '5-star', 'resorts', 'guest-houses', 'hotels-stays'].includes(this.categorySlug); 
                },
                get isCatering() {
                    return ['catering-food', 'catering', 'wedding-catering', 'corporate-lunch', 'corp-buffet', 'live-cooking'].includes(this.categorySlug);
                },
                get isMedia() {
                    return ['marketing-media', 'branding-design', 'photography', 'videography', 'drone', 'media', 'wedding-photography', 'event-videography', 'drone-shoots', 'event-media', 'influencer-mkt', 'social-ads', 'visual-id', '3d-designs', 'print-media'].includes(this.categorySlug);
                },
                get isVisa() {
                    return ['flights-ticketing', 'visa', 'dom-flights', 'intl-flights', 'travel-hospitality', 'umrah', 'travel', 'group-tours', 'int-tours', 'family-honeymoon', 'vip-hospitality'].includes(this.categorySlug);
                },
                get isTravel() {
                    return ['travel-hospitality', 'umrah', 'travel', 'group-tours', 'int-tours', 'family-honeymoon', 'vip-hospitality'].includes(this.categorySlug);
                },
                get isVenue() {
                    return ['hotels', '5-star', 'resorts', 'guest-houses', 'hotels-stays', 'venues', 'banquets', 'marquees'].includes(this.categorySlug);
                },
                get isEvent() {
                    return ['events-management', 'exhibitions-expos', 'conferences-summits', 'corporate-events', 'weddings-social', 'concerts-festivals', 'awards-gala', 'expo-mgmt', 'stall-fab', 'trade-shows', 'int-summits'].includes(this.categorySlug);
                },
                get isVendor() {
                    return ['vendor-operations', 'security-protocol', 'staffing', 'ground-ops'].includes(this.categorySlug);
                },
                get isBrand() {
                    return ['branding-design', 'visual-id', '3d-designs', 'print-media'].includes(this.categorySlug);
                },
                get isMega() {
                    return ['government-mega-projects', 'public-civic', 'national-events'].includes(this.categorySlug);
                },

                form: {
                    customer_name: @json(optional(Auth::user())->name ?? ''),
                    customer_phone: '',
                    customer_email: @json(optional(Auth::user())->email ?? ''),
                    event_type: 'standard',
                    package_name: @json($tier ?? ''),
                    selected_addons: [],
                    booking_date: '',
                    event_location: @if(in_array(optional($service->category)->slug ?? '', ['hotels', '5-star', 'resorts', 'guest-houses', 'hotels-stays', 'venues', 'banquets', 'marquees', 'events-management', 'exhibitions-expos', 'conferences-summits', 'corporate-events', 'weddings-social', 'concerts-festivals', 'awards-gala', 'expo-mgmt', 'stall-fab', 'trade-shows', 'int-summits'])) @json($service->location) @else '' @endif,
                    event_end_date: '',
                    checkin: '',
                    checkout: '',
                    guest_count: 1,
                    special_requests: '',
                    notes: '',
                    pickup_location: '',
                    dropoff_location: '',
                    duration_days: 1,
                    room_count: 1,
                    room_type: 'Standard',
                    flight_destination: '',
                    flight_class: 'economy',
                    trip_type: 'round_trip',
                    return_date: '',
                    pickup_time: '',
                    dropoff_time: '',
                    luggage_count: 0,
                    passenger_given_names: '',
                    passenger_surname: '',
                    passenger_nationality: '',
                    passenger_gender: '',
                    passenger_dob: { day: '', month: '', year: '' },
                    passenger_passport: '',
                    passenger_passport_expiry: { day: '', month: '', year: '' }
                },

                packages: @json($service->packages ?? []),
                addons: @json($service->add_ons ?? []),
                basePrice: {{ $service->price ?? 0 }},
                serviceId: {{ $service->id }},

                couponCode: '',
                appliedCoupon: null,
                isApplyingCoupon: false,
                couponError: '',

                get availableTags() {
                    if (this.isTransport) return ['English Speaking', 'AC Plus', 'Quiet Ride', 'Music'];
                    return ['Urgent Request', 'Call Me', 'WhatsApp Only', 'Vegetarian'];
                },

                init() {
                    flatpickr("#booking-date-picker", {
                        enableTime: true,
                        dateFormat: "Y-m-d H:i",
                        minDate: "today",
                        onChange: (dates, dateStr) => { this.form.booking_date = dateStr; }
                    });

                    // Hotel/Lodging Range Picker
                    flatpickr("#lodging-range-picker", {
                        mode: "range",
                        dateFormat: "Y-m-d",
                        minDate: "today",
                        onChange: (dates, dateStr) => { 
                            if (dates.length === 2) {
                                this.form.booking_date = flatpickr.formatDate(dates[0], "Y-m-d");
                                this.form.event_end_date = flatpickr.formatDate(dates[1], "Y-m-d");
                            } else {
                                this.form.booking_date = dateStr;
                            }
                        }
                    });

                    // Transport Time Pickers
                    flatpickr("#pickup-time-picker", {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "h:i K",
                        onChange: (dates, dateStr) => { this.form.pickup_time = dateStr; }
                    });

                    flatpickr("#dropoff-time-picker", {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "h:i K",
                        onChange: (dates, dateStr) => { this.form.dropoff_time = dateStr; }
                    });
                },

                applyCoupon() {
                    this.isApplyingCoupon = true;
                    this.couponError = '';
                    
                    fetch('{{ route("coupons.validate") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            code: this.couponCode,
                            amount: this.rawSubtotal,
                            service_id: this.serviceId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.valid) {
                            this.appliedCoupon = {
                                code: this.couponCode,
                                discount: data.discount
                            };
                            this.notify('Success! Your discount has been applied.');
                        } else {
                            this.couponError = data.message;
                        }
                    })
                    .catch(e => {
                        this.couponError = 'An error occurred. Please try again.';
                    })
                    .finally(() => {
                        this.isApplyingCoupon = false;
                    });
                },

                removeCoupon() {
                    this.appliedCoupon = null;
                    this.couponCode = '';
                    this.couponError = '';
                },

                toggleTag(tag) {
                    let tags = this.form.special_requests ? this.form.special_requests.split(', ') : [];
                    if (tags.includes(tag)) tags = tags.filter(t => t !== tag);
                    else tags.push(tag);
                    this.form.special_requests = tags.filter(t => t).join(', ');
                },
                
                toggleAddon(name) {
                    if (this.form.selected_addons.includes(name)) {
                        this.form.selected_addons = this.form.selected_addons.filter(a => a !== name);
                    } else {
                        this.form.selected_addons.push(name);
                    }
                },

                validateStep() {
                    if (this.step === 1) {
                        if (!this.form.customer_name || !this.form.customer_phone) return this.notify('Please complete your contact details.');
                    }
                    if (this.step === 2) {
                        if (!this.form.booking_date || (!this.form.event_location && !this.isBrand)) return this.notify('Date and Location are required.');
                        if (this.isTransport && (!this.form.pickup_location || !this.form.dropoff_location)) return this.notify('Pickup and Dropoff are required.');
                        if (this.isVisa && (!this.form.passenger_given_names || !this.form.passenger_surname || !this.form.passenger_passport)) {
                            return this.notify('Please provide primary passenger documentation.');
                        }
                    }
                    return true;
                },

                nextStep() {
                    if (this.validateStep()) {
                        this.step++;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                },

                notify(msg) {
                    this.$dispatch('notify', { message: msg });
                },

                get rawSubtotal() {
                    let total = this.basePrice;
                    if (this.form.package_name) {
                        const pkg = this.packages.find(p => p.name === this.form.package_name);
                        if (pkg) total = parseFloat(pkg.price);
                    }
                    
                    // Dynamic Pricing Logic
                    if (this.isCatering || this.isTravel) {
                        total *= Math.max(1, (this.form.guest_count || 1));
                    }
                    if ((this.isTransport && this.categorySlug === 'luxury-rentals') || this.form.event_type === 'daily') {
                        total *= Math.max(1, (this.form.duration_days || 1));
                    }
                    if (this.isLodging) {
                        total *= Math.max(1, (this.form.room_count || 1));
                    }

                    this.form.selected_addons.forEach(name => {
                        const addon = this.addons.find(a => a.name === name);
                        if (addon) total += parseFloat(addon.price);
                    });
                    return total;
                },

                get discountAmount() {
                    if (!this.appliedCoupon) return 0;
                    return this.appliedCoupon.discount;
                },

                get estimatedCost() {
                    return Math.max(0, this.rawSubtotal - this.discountAmount);
                },

                handleSubmit() {
                    if (this.step === 3) {
                        this.isSubmitting = true;
                        document.getElementById('bookingForm').submit();
                    }
                }
            }));
        });
    </script>
    @endsection

