@extends('layouts.public')

@section('title', 'Contact Us')
@section('description', 'Get in touch with Eventy - Our service desks are available 24/7 to help you.')

@section('content')
    <!-- Executive Hero Section -->
    <div class="relative min-h-[70vh] flex items-center justify-center overflow-hidden bg-slate-900 pt-32 pb-24 border-b border-slate-200"
         style="background-image: linear-gradient(to bottom, rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.92)), url('https://images.unsplash.com/photo-1423666639041-f56000c27a9a?auto=format&fit=crop&q=80&w=2000'); background-size: cover; background-position: center; background-attachment: fixed;">
        
        <!-- Refined Geometric Overlay -->
        <div class="absolute inset-0 opacity-10 pointer-events-none" 
             style="background-image: radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.3) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(10, 58, 122, 0.3) 0px, transparent 50%);"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-10">
            <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md px-5 py-2 rounded-full border border-white/20 shadow-xl">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                <span class="text-[9px] font-bold text-white uppercase tracking-[0.3em]">24/7 Support Available</span>
            </div>
            
            <div class="space-y-6">
                <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight leading-tight">
                    Get In <span class="text-blue-400">Touch</span>
                </h1>
                <p class="text-lg md:text-xl text-slate-300 font-medium max-w-3xl mx-auto tracking-tight leading-relaxed">
                    Dedicated service desks and expert teams ready to assist you with any inquiry, anytime, anywhere.
                </p>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-3 gap-6 pt-8 max-w-3xl mx-auto">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <div class="text-3xl font-black text-white mb-1">24/7</div>
                    <div class="text-[10px] font-bold text-blue-200 uppercase tracking-widest">Availability</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <div class="text-3xl font-black text-white mb-1">&lt;2h</div>
                    <div class="text-[10px] font-bold text-blue-200 uppercase tracking-widest">Response Time</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20">
                    <div class="text-3xl font-black text-white mb-1">10+</div>
                    <div class="text-[10px] font-bold text-blue-200 uppercase tracking-widest">Service Desks</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dedicated Service Desks -->
    <div class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 space-y-4">
                <h4 class="text-[9px] font-black text-primary-500 uppercase tracking-[0.6em]">Specialized Teams</h4>
                <h2 class="text-3xl md:text-5xl font-black text-slate-900 tracking-tight leading-none uppercase">
                    Service <span class="text-primary-500">Desks</span>
                </h2>
                <div class="h-1 w-20 bg-primary-500 mx-auto rounded-full"></div>
                <p class="text-slate-600 max-w-2xl mx-auto text-lg font-medium">
                    Contact the right team for your specific needs. Each desk is staffed with specialized experts.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                @foreach($categories->take(5) as $category)
                <a href="mailto:{{ $category->slug }}@eventy.pk" class="group bg-gradient-to-br from-white via-white to-blue-50/30 rounded-3xl p-8 border-2 border-slate-200 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 text-center relative overflow-hidden" style="border-color: {{ $category->color ?? '#e2e8f0' }};">
                    <div class="absolute inset-0 bg-gradient-to-br opacity-0 group-hover:opacity-100 transition-opacity" style="background-image: linear-gradient(to bottom right, {{ $category->color ?? '#3b82f6' }}0D, transparent, transparent);"></div>
                    <div class="w-20 h-20 mx-auto rounded-3xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-xl relative z-10 text-white" style="background: linear-gradient(to bottom right, {{ $category->color ?? '#3b82f6' }}, {{ $category->color ?? '#2563eb' }}); shadow-color: {{ $category->color ?? '#3b82f6' }}40;">
                        <i class="fa-solid {{ $category->icon ?? 'fa-star' }} text-3xl"></i>
                    </div>
                    <h5 class="font-black text-slate-900 text-lg mb-2 relative z-10">{{ $category->name }}</h5>
                    <p class="text-sm font-bold mb-1 relative z-10" style="color: {{ $category->color ?? '#3b82f6' }}">{{ $category->slug }}@eventy.pk</p>
                    <p class="text-xs text-slate-500 relative z-10 line-clamp-1">{{ $category->description ?? 'Specialized Service' }}</p>
                </a>
                @endforeach
            </div>
            @if($categories->count() > 5)
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($categories->skip(5) as $category)
                <a href="mailto:{{ $category->slug }}@eventy.pk" class="bg-white rounded-2xl p-6 border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition-all text-center group" style="hover:border-color: {{ $category->color ?? '#3b82f6' }}80;">
                    <i class="fa-solid {{ $category->icon ?? 'fa-star' }} text-3xl mb-3 group-hover:scale-110 transition-transform" style="color: {{ $category->color ?? '#3b82f6' }};"></i>
                    <h5 class="font-black text-slate-900 text-sm mb-1">{{ $category->name }}</h5>
                    <p class="text-xs font-bold" style="color: {{ $category->color ?? '#3b82f6' }};">{{ $category->slug }}@eventy.pk</p>
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <!-- Contact Information & Form -->
    <div class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-5 gap-12">
                <!-- Contact Information -->
                <div class="lg:col-span-2 space-y-8">
                    <div>
                        <h3 class="text-3xl font-black text-slate-900 mb-2">Contact Information</h3>
                        <p class="text-slate-600 font-medium">Reach out to us through any of these channels</p>
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-start gap-5 group">
                            <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-blue-700 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform shadow-lg shadow-blue-500/20">
                                <i class="fa-solid fa-envelope text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-black text-slate-900 text-lg mb-1">Email</h4>
                                <p class="text-primary-500 font-bold mb-1">info@eventy.pk</p>
                                <p class="text-slate-500 text-sm">We respond within 2-4 hours</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-5 group">
                            <div class="w-16 h-16 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform shadow-lg shadow-emerald-500/20">
                                <i class="fa-solid fa-phone text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-black text-slate-900 text-lg mb-1">Phone</h4>
                                <p class="text-emerald-600 font-bold mb-1">0300-6423878</p>
                                <p class="text-slate-500 text-sm">Available 24/7 for urgent inquiries</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-5 group">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform shadow-lg shadow-purple-500/20">
                                <i class="fa-brands fa-whatsapp text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-black text-slate-900 text-lg mb-1">WhatsApp</h4>
                                <p class="text-purple-600 font-bold mb-1">0300-6423878</p>
                                <p class="text-slate-500 text-sm">Chat with us instantly</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-5 group">
                            <div class="w-16 h-16 bg-gradient-to-br from-slate-600 to-slate-700 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform shadow-lg shadow-slate-500/20">
                                <i class="fa-solid fa-location-dot text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-black text-slate-900 text-lg mb-1">Head Office</h4>
                                <p class="text-slate-700 font-bold mb-1 line-clamp-2">335, 3rd Floor, The United Mall, Multan</p>
                                <p class="text-slate-500 text-sm">Abdali Road, Multan, Pakistan</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-5 group">
                            <div class="w-16 h-16 bg-gradient-to-br from-amber-600 to-amber-700 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform shadow-lg shadow-amber-500/20">
                                <i class="fa-solid fa-globe text-white text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-black text-slate-900 text-lg mb-1">Website</h4>
                                <p class="text-amber-600 font-bold mb-1">www.eventy.pk</p>
                                <p class="text-slate-500 text-sm">Explore our services online</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="pt-8 border-t border-slate-200">
                        <h4 class="font-black text-slate-900 text-lg mb-6">Follow Us</h4>
                        <div class="flex flex-wrap gap-4">
                            <a href="https://www.facebook.com/share/1C15CkM3z6/" class="w-14 h-14 bg-gradient-to-br from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-2xl flex items-center justify-center transition-all shadow-lg shadow-blue-500/20 hover:scale-110">
                                <i class="fa-brands fa-facebook-f text-white text-xl"></i>
                            </a>
                            <a href="https://www.instagram.com/eventy.pkk?igsh=dzFmZzUwNjEzZnds" class="w-14 h-14 bg-gradient-to-br from-pink-600 to-pink-700 hover:from-pink-700 hover:to-pink-800 rounded-2xl flex items-center justify-center transition-all shadow-lg shadow-pink-500/20 hover:scale-110">
                                <i class="fa-brands fa-instagram text-white text-xl"></i>
                            </a>
                            <a href="https://www.linkedin.com/in/eventypk?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" class="w-14 h-14 bg-gradient-to-br from-blue-700 to-blue-800 hover:from-blue-800 hover:to-blue-900 rounded-2xl flex items-center justify-center transition-all shadow-lg shadow-blue-500/20 hover:scale-110">
                                <i class="fa-brands fa-linkedin-in text-white text-xl"></i>
                            </a>
                            <a href="https://www.tiktok.com/@eventy.pk?_r=1&_t=ZS-92g5FwqUuzI" class="w-14 h-14 bg-gradient-to-br from-slate-900 to-black hover:from-black hover:to-slate-900 rounded-2xl flex items-center justify-center transition-all shadow-lg shadow-slate-500/20 hover:scale-110">
                                <i class="fa-brands fa-tiktok text-white text-xl"></i>
                            </a>
                            <a href="https://www.youtube.com/@Eventypk" class="w-14 h-14 bg-gradient-to-br from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-2xl flex items-center justify-center transition-all shadow-lg shadow-red-500/20 hover:scale-110">
                                <i class="fa-brands fa-youtube text-white text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="lg:col-span-3">
                    <div class="bg-gradient-to-br from-slate-50 to-blue-50/30 rounded-3xl p-10 border-2 border-slate-200 shadow-xl">
                        <div class="mb-10">
                            <h3 class="text-3xl font-black text-slate-900 mb-2">Send us a Message</h3>
                            <p class="text-slate-600 font-medium">Fill out the form below and we'll get back to you within 2-4 hours.</p>
                        </div>
                        
                        @if(session('success'))
                            <div class="mb-8 bg-green-50 border-2 border-green-600 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <span class="font-bold">{{ session('success') }}</span>
                            </div>
                        @endif

                        <form id="contactForm" action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="desk_type" id="desk_type" value="">
                            
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-black text-slate-700 mb-2">Full Name *</label>
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                        class="w-full px-5 py-4 bg-white border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-primary-500 transition-all text-slate-900 font-medium placeholder-slate-400" placeholder="John Doe">
                                </div>
                                <div>
                                    <label class="block text-sm font-black text-slate-700 mb-2">Email Address *</label>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                        class="w-full px-5 py-4 bg-white border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-primary-500 transition-all text-slate-900 font-medium placeholder-slate-400" placeholder="you@example.com">
                                </div>
                            </div>

                            <div x-data="{ serviceType: '{{ old('service_type') }}' }" x-init="$watch('serviceType', value => {
                                const deskMap = {
                                    'Flights Booking': 'flights',
                                    'Hotel Reservation': 'hotels',
                                    'Visa Consultancy': 'visa',
                                    'Tour Packages': 'tours',
                                    'Cab/Transportation': 'cabs',
                                    'Catering Services': 'catering',
                                    'Photography Services': 'photography',
                                    'Videography Services': 'videography',
                                    'Drone Coverage': 'drone',
                                    'Live Streaming': 'live_streaming',
                                };
                                document.getElementById('desk_type').value = deskMap[value] || '';
                                const form = document.getElementById('contactForm');
                                form.action = deskMap[value] ? '{{ route('service-desk.store') }}' : '{{ route('contact.store') }}';
                            })">
                                <label class="block text-sm font-black text-slate-700 mb-2">Service Required *</label>
                                <select name="service_type" x-model="serviceType" 
                                    class="w-full px-5 py-4 bg-white border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-primary-500 transition-all text-slate-900 font-medium appearance-none">
                                    <option value="">Choose a specialized desk...</option>
                                    <option value="Flights Booking">Flights Booking</option>
                                    <option value="Hotel Reservation">Hotel Reservation</option>
                                    <option value="Visa Consultancy">Visa Consultancy</option>
                                    <option value="Tour Packages">Tour Packages</option>
                                    <option value="Cab/Transportation">Cab/Transportation</option>
                                    <option value="Catering Services">Catering Services</option>
                                    <option value="Photography Services">Photography Services</option>
                                    <option value="Videography Services">Videography Services</option>
                                    <option value="Drone Coverage">Drone Coverage</option>
                                    <option value="Live Streaming">Live Streaming</option>
                                    <option value="Event Management">Event Management</option>
                                    <option value="Corporate Solutions">Corporate Solutions</option>
                                    <option value="General Inquiry">General Inquiry</option>
                                </select>

                                <!-- Dynamic Slots -->
                                <div class="mt-6" x-show="serviceType && !['General Inquiry', 'Event Management', 'Corporate Solutions'].includes(serviceType)">
                                    <div class="p-6 bg-blue-50 rounded-2xl border-2 border-blue-200">
                                        <h4 class="text-xs font-black text-primary-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                                            <i class="fa-solid fa-circle-info"></i> Specific Details for <span x-text="serviceType"></span>
                                        </h4>
                                        
                                        <template x-if="['Flights Booking'].includes(serviceType)">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <input type="text" name="departure_city" placeholder="From (City)" class="px-4 py-3 bg-white border-2 border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 transition-all text-sm font-medium">
                                                <input type="text" name="arrival_city" placeholder="To (City)" class="px-4 py-3 bg-white border-2 border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 transition-all text-sm font-medium">
                                                <input type="date" name="departure_date" class="px-4 py-3 bg-white border-2 border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 transition-all text-sm font-medium">
                                                <input type="date" name="return_date" class="px-4 py-3 bg-white border-2 border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 transition-all text-sm font-medium">
                                            </div>
                                        </template>

                                        <template x-if="['Hotel Reservation'].includes(serviceType)">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <input type="text" name="destination" placeholder="Destination City/Hotel" class="px-4 py-3 bg-white border-2 border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 transition-all text-sm font-medium">
                                                <input type="number" name="guests" placeholder="No. of Guests" class="px-4 py-3 bg-white border-2 border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 transition-all text-sm font-medium">
                                                <input type="date" name="check_in_date" class="px-4 py-3 bg-white border-2 border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 transition-all text-sm font-medium">
                                                <input type="date" name="check_out_date" class="px-4 py-3 bg-white border-2 border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 transition-all text-sm font-medium">
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-black text-slate-700 mb-2">Your Message *</label>
                                <textarea name="message" rows="6" required
                                    class="w-full px-5 py-4 bg-white border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-primary-500 transition-all text-slate-900 font-medium placeholder-slate-400"
                                    placeholder="Tell us exactly what you are looking for. The more detail, the better we can assist..."></textarea>
                            </div>

                            <button type="submit" 
                                class="w-full bg-gradient-to-r from-primary-500 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-black py-5 rounded-2xl shadow-xl shadow-blue-500/20 transition-all hover:-translate-y-1 flex items-center justify-center gap-3 text-lg">
                                <i class="fa-solid fa-paper-plane"></i>
                                Submit Inquiry
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="py-24 bg-slate-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 space-y-4">
                <h4 class="text-[9px] font-black text-primary-500 uppercase tracking-[0.6em]">Common Questions</h4>
                <h2 class="text-3xl md:text-5xl font-black text-slate-900 tracking-tight leading-none uppercase">
                    Frequently Asked <span class="text-primary-500">Questions</span>
                </h2>
                <div class="h-1 w-20 bg-primary-500 mx-auto rounded-full"></div>
            </div>

            <div class="space-y-4">
                <div class="bg-white rounded-2xl p-8 border-2 border-slate-200 hover:border-primary-500/30 hover:shadow-xl transition-all">
                    <h4 class="font-black text-slate-900 text-lg mb-2">What are your operating hours?</h4>
                    <p class="text-slate-600 font-medium">Our service desks are available 24/7 to assist you. We typically respond to inquiries within 2-4 hours.</p>
                </div>
                <div class="bg-white rounded-2xl p-8 border-2 border-slate-200 hover:border-primary-500/30 hover:shadow-xl transition-all">
                    <h4 class="font-black text-slate-900 text-lg mb-2">Which service desk should I contact?</h4>
                    <p class="text-slate-600 font-medium">Each desk specializes in specific services. Choose the desk that matches your inquiry for the fastest response from our expert teams.</p>
                </div>
                <div class="bg-white rounded-2xl p-8 border-2 border-slate-200 hover:border-primary-500/30 hover:shadow-xl transition-all">
                    <h4 class="font-black text-slate-900 text-lg mb-2">Do you offer international services?</h4>
                    <p class="text-slate-600 font-medium">Yes! We operate in 50+ countries worldwide through our global network of coordinators and partners.</p>
                </div>
            </div>
        </div>
    </div>
@endsection


