@extends('layouts.public')

@section('title', 'About Us')
@section('description', 'Learn about Eventy - Pakistan\'s First Hybrid Event, Travel & Hospitality Platform.')

@section('content')
    <!-- Executive Hero Section -->
    <div class="relative min-h-[75vh] flex items-center justify-center overflow-hidden bg-[#0A192F] pt-32 pb-24"
         style="background-image: linear-gradient(to bottom, rgba(10, 25, 47, 0.85), rgba(10, 25, 47, 0.95)), url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=2000'); background-size: cover; background-position: center; background-attachment: fixed;">
        
        <!-- Refined Geometric Overlay -->
        <div class="absolute inset-0 opacity-10 pointer-events-none" 
             style="background-image: radial-gradient(at 0% 0%, rgba(237, 28, 36, 0.3) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(10, 58, 122, 0.3) 0px, transparent 50%);"></div>
        
        <div class="max-w-7xl mx-auto px-6 md:px-12 relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8">
                    <div class="inline-flex items-center gap-3 bg-white/5 backdrop-blur-md px-5 py-2 rounded-full border border-white/10 shadow-xl">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#ED1C24] animate-pulse"></span>
                        <span class="text-[9px] font-black text-white uppercase tracking-[0.3em]">Corporate Protocol: About Eventy</span>
                    </div>
                    
                    <div class="space-y-6">
                        <h1 class="text-5xl md:text-8xl font-black text-white tracking-tighter uppercase leading-[0.85]">
                            The Future of <br/>
                            <span class="text-[#ED1C24]">Events & Travel</span>
                        </h1>
                        <p class="text-lg md:text-xl text-blue-100/40 font-medium leading-relaxed max-w-xl ">
                            "Founded in 2019, Eventy.pk is orchestrating a global evolution in Events, Travel, and Hospitality execution."
                        </p>
                    </div>
                    
                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="{{ route('contact') }}" class="inline-flex items-center gap-4 px-10 py-5 bg-[#ED1C24] text-white rounded-2xl font-black shadow-2xl shadow-[#ED1C24]/20 hover:scale-[1.05] transition-all uppercase tracking-widest text-xs">
                             Connect with HQ
                        </a>
                        <a href="{{ route('services') }}" class="inline-flex items-center gap-4 px-10 py-5 bg-white/5 backdrop-blur-md border border-white/10 text-white rounded-2xl font-black hover:bg-white/10 transition-all uppercase tracking-widest text-xs">
                            Master Portfolio
                        </a>
                    </div>
                </div>
                
                <div class="hidden lg:block relative">
                    <div class="absolute -inset-10 bg-gradient-to-r from-blue-600/20 to-[#ED1C24]/20 rounded-full blur-[100px] animate-pulse"></div>
                    <div class="relative rounded-[3rem] overflow-hidden border border-white/10 shadow-3xl">
                        <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&w=800&q=80" alt="Team Meeting" class="w-full h-full object-cover grayscale opacity-80 hover:grayscale-0 hover:opacity-100 transition-all duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0A192F] via-transparent to-transparent"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Counter -->
    <div class="py-16 bg-[#F8FAFC] relative -mt-20 z-20">
        <div class="max-w-[1400px] mx-auto px-6">
            <div class="bg-white rounded-[3rem] shadow-3xl border border-gray-100 p-12 grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center relative group">
                    <div class="text-5xl font-black text-[#0A192F] mb-1 counter" data-target="50">0+</div>
                    <div class="text-gray-400 font-black uppercase text-[9px] tracking-[0.3em]">Global Countries</div>
                    <div class="absolute -top-4 -right-4 w-12 h-12 bg-blue-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <i class="fa-solid fa-earth-americas text-blue-400 text-sm"></i>
                    </div>
                </div>
                <div class="text-center relative group">
                    <div class="text-5xl font-black text-[#ED1C24] mb-1 counter" data-target="500">0+</div>
                    <div class="text-gray-400 font-black uppercase text-[9px] tracking-[0.3em]">Verified Nodes</div>
                     <div class="absolute -top-4 -right-4 w-12 h-12 bg-red-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <i class="fa-solid fa-check-double text-red-400 text-sm"></i>
                    </div>
                </div>
                <div class="text-center relative group">
                    <div class="text-5xl font-black text-[#0A192F] mb-1 counter" data-target="10">0K+</div>
                    <div class="text-gray-400 font-black uppercase text-[9px] tracking-[0.3em]">Secure Executions</div>
                     <div class="absolute -top-4 -right-4 w-12 h-12 bg-blue-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <i class="fa-solid fa-shield-check text-blue-400 text-sm"></i>
                    </div>
                </div>
                <div class="text-center relative group">
                    <div class="text-5xl font-black text-[#ED1C24] mb-1">24/7</div>
                    <div class="text-gray-400 font-black uppercase text-[9px] tracking-[0.3em]">Active Support</div>
                     <div class="absolute -top-4 -right-4 w-12 h-12 bg-red-50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <i class="fa-solid fa-headset text-red-500 text-sm"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Executive Overview Section -->
    <div class="py-24 bg-white relative overflow-hidden">
        <!-- Floating shapes for aesthetic depth -->
        <div class="absolute top-0 right-1/4 w-[500px] h-[500px] bg-blue-500/5 rounded-full blur-[120px] -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-1/4 w-[400px] h-[400px] bg-purple-500/5 rounded-full blur-[100px] translate-y-1/2"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                <div class="space-y-8 fade-in-section opacity-100 transition-all duration-1000">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary-500/10 text-primary-500 rounded-full text-[10px] font-black uppercase tracking-widest border border-primary-500/20">
                        Corporate Narrative
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase leading-[0.9]">
                        Complete <span class="text-primary-500">Digital</span><br/>Ecosystem
                    </h2>
                    <div class="space-y-6 text-lg text-slate-600 font-medium leading-relaxed">
                        <p>
                            Backed by leadership with over a decade of professional expertise, Eventy.pk integrates advanced technology, deep industry insights, and operational excellence to deliver reliable, scalable, and world-class solutions across Pakistan and international markets.
                        </p>
                        <p>
                            From unforgettable weddings to global tours, from high-impact corporate events to fully managed travel programs, the platform ensures end-to-end planning, transparent vendor selection, and professional execution for every client.
                        </p>
                    </div>
                </div>
                <div class="relative group fade-in-section opacity-100 transition-all duration-1000">
                    <div class="absolute -inset-4 bg-gradient-to-r from-primary-500 to-blue-700 rounded-[3rem] blur-2xl opacity-20"></div>
                    <div class="relative bg-slate-900 rounded-[3rem] p-12 border border-white/10 shadow-2xl overflow-hidden">
                         <div class="absolute top-0 right-0 p-8 opacity-20">
                            <i class="fa-solid fa-quote-right text-8xl text-white"></i>
                        </div>
                        <p class="text-xl md:text-2xl text-white font-medium  leading-relaxed relative z-10 mb-8">
                            "Powered by a rapidly expanding vendor network and strategic corporate partnerships, Eventy.pk is committed to becoming the world’s leading all-in-one Events, Travel, and Hospitality marketplace."
                        </p>
                        <div class="pt-8 border-t border-white/10 relative z-10">
                            <p class="text-slate-400 font-medium">
                                Today, Eventy.pk stands not merely as a service provider — but as a complete lifestyle and business solution, redefining how people plan, book, and experience Events, Travel, and Hospitality across the globe.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mission & Vision -->
    <div class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                <div class="relative fade-in-section opacity-0 transition-all duration-1000">
                    <div class="absolute -inset-10 bg-blue-100/30 rounded-full blur-[100px]"></div>
                    <div class="relative rounded-[3rem] overflow-hidden border border-gray-100 shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1559136555-9303baea8ebd?auto=format&fit=crop&w=800&q=80" alt="Vision" class="w-full h-full object-cover grayscale">
                        <div class="absolute inset-0 bg-[#0A192F]/20 mix-blend-multiply"></div>
                    </div>
                </div>
                <div class="space-y-12 fade-in-section opacity-0 transition-all duration-1000">
                    <div>
                        <h4 class="text-[9px] font-black text-[#ED1C24] uppercase tracking-[0.8em] mb-4">Strategic Purpose</h4>
                        <h2 class="text-4xl md:text-5xl font-black text-[#0A192F] tracking-tighter uppercase leading-[0.9]">Mission & <span class="text-gray-300 ">Vision v2.0</span></h2>
                    </div>
                    
                    <div class="space-y-8">
                        <div class="group">
                            <div class="flex items-center gap-6 mb-4">
                                <div class="w-14 h-14 bg-[#0A192F] rounded-2xl flex items-center justify-center text-white shadow-xl group-hover:bg-[#ED1C24] transition-colors duration-500">
                                    <i class="fa-solid fa-bullseye text-xl"></i>
                                </div>
                                <h3 class="text-2xl font-black text-[#0A192F] uppercase tracking-wide">The Mission</h3>
                            </div>
                            <p class="text-gray-500 font-medium leading-relaxed pl-20">
                                "To engineer the world's most intelligent, transparent, and seamless orchestration platform for Events and Travel — empowering the elite network."
                            </p>
                        </div>
                        
                        <div class="group">
                            <div class="flex items-center gap-6 mb-4">
                                <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center text-[#0A192F] shadow-lg group-hover:bg-[#0A192F] group-hover:text-white transition-colors duration-500">
                                    <i class="fa-solid fa-eye text-xl"></i>
                                </div>
                                <h3 class="text-2xl font-black text-[#0A192F] uppercase tracking-wide">The Vision</h3>
                            </div>
                            <p class="text-gray-500 font-medium leading-relaxed pl-20">
                                "To become the global gold-standard marketplace for high-stakes experiences, defining the intersection of logic and luxury."
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Values -->
    <div class="py-24 bg-[#0A192F] relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" 
             style="background-image: radial-gradient(white 1px, transparent 1px); background-size: 40px 40px;"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-24 space-y-4 fade-in-section opacity-0 transition-all duration-700">
                <h4 class="text-[9px] font-black text-[#ED1C24] uppercase tracking-[0.8em]">Operational DNA</h4>
                <h2 class="text-4xl md:text-5xl font-black text-white tracking-widest uppercase leading-none">
                    Core <span class="text-[#ED1C24]">Values</span>
                </h2>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                @foreach([
                    ['title' => 'Integrity', 'desc' => 'Verified nodes & transparent execution protocols.', 'icon' => 'fa-shield-halved', 'color' => '#ED1C24'],
                    ['title' => 'Innovation', 'desc' => 'Neural matching & AI-driven event logic.', 'icon' => 'fa-microchip', 'color' => '#3B82F6'],
                    ['title' => 'Excellence', 'desc' => 'The absolute benchmark for premium service.', 'icon' => 'fa-crown', 'color' => '#ED1C24'],
                    ['title' => 'Intelligence', 'desc' => 'Data-backed decisions for every deployment.', 'icon' => 'fa-brain', 'color' => '#3B82F6']
                ] as $value)
                <div class="fade-in-section opacity-0 transition-all duration-700">
                    <div class="group h-full p-10 bg-white/5 border border-white/10 rounded-[2.5rem] hover:bg-white/[0.08] hover:border-white/20 transition-all duration-500">
                        <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center mb-8 border border-white/10 group-hover:scale-110 transition-transform duration-500">
                            <i class="fa-solid {{ $value['icon'] }} text-2xl" style="color: {{ $value['color'] }}"></i>
                        </div>
                        <h4 class="text-xl font-black text-white uppercase tracking-widest mb-4">{{ $value['title'] }}</h4>
                        <p class="text-white/40 text-xs font-medium leading-relaxed uppercase tracking-wider">{{ $value['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- The Hybrid Model -->
    <div class="py-24 bg-white relative overflow-hidden">
        <!-- Abstract neural lines -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 50 Q 25 0 50 50 T 100 50" fill="none" stroke="#ED1C24" stroke-width="0.5" />
                <path d="M0 70 Q 25 20 50 70 T 100 70" fill="none" stroke="#0A192F" stroke-width="0.5" />
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-24 space-y-4 fade-in-section opacity-0 transition-all duration-700">
                <h4 class="text-[9px] font-black text-[#ED1C24] uppercase tracking-[0.8em]">Operational Methodology</h4>
                <h2 class="text-4xl md:text-5xl font-black text-[#0A192F] tracking-tighter uppercase leading-none">
                    The Hybrid <span class="text-[#ED1C24]">Infrastructure</span>
                </h2>
                <p class="text-gray-400 max-w-2xl mx-auto text-lg font-medium ">"Integrating digital intelligence with terrestrial execution."</p>
            </div>

            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Online -->
                <div class="fade-in-section opacity-0 transition-all duration-1000">
                    <div class="group p-12 bg-gray-50 rounded-[3rem] border border-gray-100 hover:bg-[#0A192F] hover:text-white transition-all duration-700 h-full shadow-xl hover:shadow-2xl">
                        <div class="w-20 h-20 bg-white rounded-3xl flex items-center justify-center mb-10 shadow-lg group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-network-wired text-[#0A192F] text-3xl"></i>
                        </div>
                        <h3 class="text-3xl font-black uppercase tracking-widest mb-6">Neural Platform</h3>
                        <ul class="space-y-6">
                            @foreach(['AI-Powered Budget Architect', 'Real-time Vendor Synchronization', 'Corporate Governance Dashboard', 'Encrypted Payment Uplinks'] as $feature)
                            <li class="flex items-center gap-4 group/li">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#ED1C24]"></span>
                                <span class="text-sm font-bold uppercase tracking-wider group-hover:translate-x-2 transition-transform">{{ $feature }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- On-Ground -->
                <div class="fade-in-section opacity-0 transition-all duration-1000">
                    <div class="group p-12 bg-[#0A192F] text-white rounded-[3rem] border border-white/10 hover:bg-white hover:text-[#0A192F] transition-all duration-700 h-full shadow-xl hover:shadow-2xl">
                        <div class="w-20 h-20 bg-white/10 rounded-3xl flex items-center justify-center mb-10 shadow-lg group-hover:bg-[#ED1C24] group-hover:text-white transition-all">
                            <i class="fa-solid fa-users-gear text-3xl"></i>
                        </div>
                        <h3 class="text-3xl font-black uppercase tracking-widest mb-6">Terrestrial Ops</h3>
                        <ul class="space-y-6">
                            @foreach(['Dedicated Implementation Officers', '24/7 Field Intelligence', 'Global Logistics Coordination', 'Verified Tier-1 Vendor Network'] as $feature)
                            <li class="flex items-center gap-4 group/li">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#ED1C24]"></span>
                                <span class="text-sm font-bold uppercase tracking-wider group-hover:translate-x-2 transition-transform">{{ $feature }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline / Journey -->
    <div class="py-24 bg-[#0A192F] relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-6">
            <div class="text-center mb-24 space-y-4 fade-in-section opacity-0 transition-all duration-700">
                <h4 class="text-[9px] font-black text-[#ED1C24] uppercase tracking-[0.8em]">Operational History</h4>
                <h2 class="text-4xl md:text-5xl font-black text-white tracking-widest uppercase leading-none">
                    The Eventy <span class="text-[#ED1C24]">Evolution</span>
                </h2>
            </div>

            <div class="space-y-12 relative">
                <!-- Vertical Line -->
                <div class="absolute left-1/2 -translate-x-1/2 top-0 bottom-0 w-px bg-white/10 hidden md:block"></div>
                
                @foreach([
                    ['year' => '2019', 'title' => 'Initial Uplink', 'desc' => 'Eventy officially launched as a disruptive hybrid platform for Events and Travel in Pakistan.'],
                    ['year' => '2025', 'title' => 'Global Expansion', 'desc' => 'AI infrastructure deployment and operational nodes established across 50+ countries.'],
                    ['year' => '2030', 'title' => 'Global Dominance', 'desc' => 'Targeting total orchestration leadership across every high-stakes experience category.']
                ] as $index => $milestone)
                <div class="flex flex-col md:flex-row gap-8 items-center md:items-start fade-in-section opacity-0 transition-all duration-700 {{ $index % 2 == 0 ? '' : 'md:flex-row-reverse' }}">
                    <div class="md:w-1/2 {{ $index % 2 == 0 ? 'md:text-right' : 'md:text-left' }} order-2 md:order-1">
                        <div class="bg-white/5 p-8 rounded-[2rem] border border-white/10 hover:border-[#ED1C24]/30 transition-all">
                            <h4 class="font-black text-white text-xl mb-4 uppercase tracking-widest">{{ $milestone['title'] }}</h4>
                            <p class="text-white/40 text-sm font-medium leading-relaxed">{{ $milestone['desc'] }}</p>
                        </div>
                    </div>
                    
                    <div class="relative z-10 flex flex-col items-center order-1 md:order-2">
                        <div class="w-16 h-16 bg-[#ED1C24] rounded-full flex items-center justify-center text-white font-black text-xs shadow-2xl shadow-red-500/20 border-4 border-[#0A192F]">
                            {{ $milestone['year'] }}
                        </div>
                    </div>
                    
                    <div class="md:w-1/2 hidden md:block order-3"></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Leadership Team -->
    <div class="py-24 bg-slate-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-24 space-y-4 fade-in-section opacity-0 transition-all duration-700">
                <h4 class="text-[9px] font-black text-[#ED1C24] uppercase tracking-[0.8em]">Command Center</h4>
                <h2 class="text-4xl md:text-5xl font-black text-[#0A192F] tracking-tighter uppercase leading-none">
                    Leadership <span class="text-[#ED1C24]">Officers</span>
                </h2>
                <p class="text-gray-400 max-w-2xl mx-auto font-medium ">"Visionary execution across the global network."</p>
            </div>

            <div class="grid md:grid-cols-3 gap-12">
                @foreach([
                    ['role' => 'Founder & CEO', 'title' => 'Chief Executive', 'img' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&h=300&q=80', 'desc' => 'Orchestrating the high-level vision and global benchmarks.'],
                    ['role' => 'Chief Operations', 'title' => 'Head of Intelligence', 'img' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&h=300&q=80', 'desc' => 'Managing the logistical symmetry of our terrestrial nodes.'],
                    ['role' => 'Chief Technology', 'title' => 'Head of Systems', 'img' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=300&h=300&q=80', 'desc' => 'Architecting the neural framework for global orchestration.']
                ] as $member)
                <div class="text-center group fade-in-section opacity-0 transition-all duration-700">
                    <div class="relative inline-block mb-10">
                        <div class="absolute -inset-4 bg-[#ED1C24]/5 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-all duration-1000"></div>
                        <img src="{{ $member['img'] }}" class="relative w-56 h-56 rounded-full object-cover mx-auto grayscale group-hover:grayscale-0 transition-all duration-700 border-4 border-white shadow-2xl group-hover:scale-110">
                    </div>
                    <h4 class="text-2xl font-black text-[#0A192F] mb-1 uppercase tracking-tighter">{{ $member['role'] }}</h4>
                    <p class="text-[#ED1C24] font-black uppercase text-[10px] tracking-[0.4em] mb-4">{{ $member['title'] }}</p>
                    <p class="text-gray-400 font-medium  text-sm leading-relaxed max-w-xs mx-auto">{{ $member['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Executive CTA -->
    <div class="py-32 bg-white relative overflow-hidden">
        <div class="max-w-5xl mx-auto px-6 text-center relative z-10 space-y-12 fade-in-section opacity-0 transition-all duration-700">
            <h2 class="text-5xl md:text-8xl font-black text-[#0A192F] tracking-tighter uppercase leading-none">
                Begin Your <br/>
                <span class="text-[#ED1C24] ">Elite Deployment</span>
            </h2>
            <p class="text-xl text-gray-400 font-medium max-w-2xl mx-auto ">
                "The core network is active. Join thousands of high-stakes clients orchestrating the future today."
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center pt-8">
                <a href="{{ route('register') }}" class="group relative px-12 py-6 bg-[#ED1C24] text-white rounded-2xl font-black text-xs uppercase tracking-[0.3em] overflow-hidden transition-all hover:scale-110 active:scale-95 shadow-3xl shadow-red-500/20">
                    <span class="relative z-10">Initialize Now</span>
                    <div class="absolute inset-0 bg-[#0A192F] translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-12 py-6 bg-[#0A192F] border border-transparent text-white rounded-2xl font-black text-xs uppercase tracking-[0.3em] hover:bg-gray-900 transition-all shadow-xl">
                    Request Briefing
                </a>
            </div>
        </div>
    </div>

    <!-- Scroll Animation Script -->
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Intersection Observer for fade-in animations
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove('opacity-0');
                        entry.target.classList.add('opacity-100');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.fade-in-section').forEach((el) => {
                observer.observe(el);
            });

            // Counter animation
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const target = parseInt(counter.dataset.target);
                const suffix = counter.textContent.includes('K') ? 'K+' : '+';
                let count = 0;
                const increment = target / 50;
                
                const updateCount = () => {
                    if (count < target) {
                        count += increment;
                        counter.textContent = Math.ceil(count) + suffix;
                        requestAnimationFrame(updateCount);
                    } else {
                        counter.textContent = target + suffix;
                    }
                };
                
                // Start counter when visible
                const counterObserver = new IntersectionObserver((entries) => {
                    if (entries[0].isIntersecting) {
                        updateCount();
                        counterObserver.unobserve(counter);
                    }
                }, { threshold: 0.5 });
                
                counterObserver.observe(counter);
            });
        });
    </script>
    @endpush
@endsection


