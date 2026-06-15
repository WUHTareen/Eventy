@extends('layouts.public')

@section('title', 'How It Works | Elite Intelligence')
@section('description', 'Decrypted: The architecture behind Eventy\'s executive event orchestration.')

@section('content')
<div class="bg-[#020617] min-h-screen font-sans selection:bg-[#ED1C24] selection:text-white">
    <!-- Cyber-Noir Hero Architecture -->
    <div class="relative pt-40 pb-32 overflow-hidden border-b border-white/5">
        <!-- Background Architecture -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute inset-0 opacity-[0.05]" 
                 style="background-image: linear-gradient(#3b82f6 1px, transparent 1px), linear-gradient(90deg, #3b82f6 1px, transparent 1px); background-size: 60px 60px;"></div>
            

            
            <div class="absolute top-0 right-0 w-[1000px] h-[1000px] bg-blue-600/10 rounded-full blur-[180px] translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 left-0 w-[800px] h-[800px] bg-[#ED1C24]/10 rounded-full blur-[150px] -translate-x-1/2 translate-y-1/2"></div>
            
            <!-- Tech Particles -->
            <div class="absolute top-1/3 left-1/4 w-1 h-1 bg-white/20 rounded-full"></div>
            <div class="absolute top-2/3 right-1/4 w-1 h-1 bg-white/20 rounded-full [animation-delay:1.5s]"></div>
        </div>

        <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10 text-center">
            <div class="inline-flex items-center gap-4 bg-white/5 backdrop-blur-3xl px-8 py-3 rounded-full border border-white/10 mb-12 transform hover:scale-105 transition-transform duration-500 cursor-default">
                <div class="flex gap-1.5">
                    <div class="w-1.5 h-1.5 bg-[#ED1C24] rounded-full"></div>
                    <div class="w-1.5 h-1.5 bg-[#ED1C24] rounded-full [animation-delay:0.2s]"></div>
                    <div class="w-1.5 h-1.5 bg-[#ED1C24] rounded-full [animation-delay:0.4s]"></div>
                </div>
                <span class="text-[12px] font-black text-white/90 uppercase tracking-[0.6em]">System Architecture_v4.0</span>
            </div>
            
            <h1 class="text-7xl md:text-9xl font-black text-white tracking-tighter uppercase leading-[0.8] mb-12">
                The <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-white to-white/30">Intelligence</span><br/>
                <span class="text-[#ED1C24]">Decrypted</span>
            </h1>
            
            <p class="text-blue-100/40 text-2xl md:text-3xl font-medium leading-relaxed max-w-4xl mx-auto border-t border-white/5 pt-12">
                A seamless synthesis of AI precision and elite human expertise. Explore the protocol that powers the world's most exclusive narratives.
            </p>
        </div>
    </div>

    <!-- Interactive Process Protocol -->
    <div class="py-32 relative">
        <div class="max-w-[1200px] mx-auto px-6 md:px-12">
            <div class="grid gap-12">
                <!-- Node 01: Submission -->
                <div class="group relative grid md:grid-cols-[200px_1fr] gap-12 items-center">
                    <div class="flex flex-col items-center justify-center">
                        <div class="text-8xl font-black text-white/5 tracking-tighter group-hover:text-[#ED1C24]/10 transition-colors duration-700">01</div>
                        <div class="w-px h-24 bg-gradient-to-b from-white/5 to-transparent"></div>
                    </div>
                    <div class="relative p-12 bg-white/5 backdrop-blur-3xl rounded-[3rem] border border-white/10 group-hover:border-[#ED1C24]/30 transition-all duration-700 overflow-hidden">
                        <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-100 transition-opacity">
                            <div class="w-4 h-4 border-t-2 border-r-2 border-[#ED1C24]"></div>
                        </div>
                        <div class="flex flex-col md:flex-row gap-12 items-center">
                            <div class="w-24 h-24 bg-[#ED1C24]/10 rounded-3xl flex items-center justify-center text-[#ED1C24] shrink-0 group-hover:scale-110 group-hover:rotate-12 transition-all duration-700">
                                <i class="fa-solid fa-terminal text-4xl"></i>
                            </div>
                            <div class="space-y-6">
                                <h3 class="text-4xl font-black text-white uppercase tracking-tighter">Initialize Requirement</h3>
                                <p class="text-blue-100/40 text-lg leading-relaxed font-medium">Connect through our elite digital nodes. Every request is immediately encrypted and channeled to the relevant specialized intelligence desk.</p>
                                <div class="flex flex-wrap gap-4 pt-4">
                                    <span class="px-6 py-2 bg-white/5 border border-white/10 rounded-full text-[10px] font-black text-white/60 uppercase tracking-widest">Web Interface</span>
                                    <span class="px-6 py-2 bg-white/5 border border-white/10 rounded-full text-[10px] font-black text-white/60 uppercase tracking-widest">Secure API</span>
                                    <span class="px-6 py-2 bg-white/5 border border-white/10 rounded-full text-[10px] font-black text-white/60 uppercase tracking-widest">VIP Uplink</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Node 02: Assignment -->
                <div class="group relative grid md:grid-cols-[200px_1fr] gap-12 items-center">
                    <div class="flex flex-col items-center justify-center">
                        <div class="text-8xl font-black text-white/5 tracking-tighter group-hover:text-blue-400/10 transition-colors duration-700">02</div>
                        <div class="w-px h-24 bg-gradient-to-b from-white/5 to-transparent"></div>
                    </div>
                    <div class="relative p-12 bg-white/5 backdrop-blur-3xl rounded-[3rem] border border-white/10 group-hover:border-blue-400/30 transition-all duration-700 overflow-hidden">
                        <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-100 transition-opacity">
                            <div class="w-4 h-4 border-t-2 border-r-2 border-blue-400"></div>
                        </div>
                        <div class="flex flex-col md:flex-row gap-12 items-center">
                            <div class="w-24 h-24 bg-blue-400/10 rounded-3xl flex items-center justify-center text-blue-400 shrink-0 group-hover:scale-110 group-hover:-rotate-12 transition-all duration-700">
                                <i class="fa-solid fa-microchip text-4xl"></i>
                            </div>
                            <div class="space-y-6">
                                <h3 class="text-4xl font-black text-white uppercase tracking-tighter">Desk Synchronization</h3>
                                <p class="text-blue-100/40 text-lg leading-relaxed font-medium">Our neural router assigns your vision to a specialized expert desk—Events, Travel, or Corporate—ensuring vertical-specific dominance.</p>
                                <div class="flex flex-wrap gap-4 pt-4">
                                    <span class="px-6 py-2 bg-blue-400/5 border border-blue-400/20 rounded-full text-[10px] font-black text-blue-400/60 uppercase tracking-widest">Events Desk</span>
                                    <span class="px-6 py-2 bg-blue-400/5 border border-blue-400/20 rounded-full text-[10px] font-black text-blue-400/60 uppercase tracking-widest">Travel Desk</span>
                                    <span class="px-6 py-2 bg-blue-400/5 border border-blue-400/20 rounded-full text-[10px] font-black text-blue-400/60 uppercase tracking-widest">Global Ops</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Node 03: Customization -->
                <div class="group relative grid md:grid-cols-[200px_1fr] gap-12 items-center">
                    <div class="flex flex-col items-center justify-center">
                        <div class="text-8xl font-black text-white/5 tracking-tighter group-hover:text-[#ED1C24]/10 transition-colors duration-700">03</div>
                        <div class="w-px h-24 bg-gradient-to-b from-white/5 to-transparent"></div>
                    </div>
                    <div class="relative p-12 bg-white/5 backdrop-blur-3xl rounded-[3rem] border border-white/10 group-hover:border-[#ED1C24]/30 transition-all duration-700 overflow-hidden">
                        <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-100 transition-opacity">
                            <div class="w-4 h-4 border-t-2 border-r-2 border-[#ED1C24]"></div>
                        </div>
                        <div class="flex flex-col md:flex-row gap-12 items-center">
                            <div class="w-24 h-24 bg-[#ED1C24]/10 rounded-3xl flex items-center justify-center text-[#ED1C24] shrink-0 group-hover:scale-110 group-hover:rotate-12 transition-all duration-700">
                                <i class="fa-solid fa-code-merge text-4xl"></i>
                            </div>
                            <div class="space-y-6">
                                <h3 class="text-4xl font-black text-white uppercase tracking-tighter">Neural Budgeting</h3>
                                <p class="text-blue-100/40 text-lg leading-relaxed font-medium">Our AI-Architect generates three distinct execution tiers—Essential, Signature, and Elite—tailored to your precise capital parameters.</p>
                                <ul class="space-y-3 pt-4">
                                    <li class="flex items-center gap-4 text-blue-100/60 font-bold uppercase text-[10px] tracking-widest"><i class="fa-solid fa-check text-[#ED1C24]"></i> Real-time variable optimization</li>
                                    <li class="flex items-center gap-4 text-blue-100/60 font-bold uppercase text-[10px] tracking-widest"><i class="fa-solid fa-check text-[#ED1C24]"></i> Multi-tier scenario analysis</li>
                                    <li class="flex items-center gap-4 text-blue-100/60 font-bold uppercase text-[10px] tracking-widest"><i class="fa-solid fa-check text-[#ED1C24]"></i> Dynamic resource allocation</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- VIP Uplink / Expert Consultation -->
    <div class="py-32 bg-white/2 border-y border-white/5 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20 pointer-events-none" 
             style="background-image: radial-gradient(#ED1C24 0.5px, transparent 0.5px); background-size: 30px 30px;"></div>
        
        <div class="max-w-[1400px] mx-auto px-6 md:px-12 relative z-10">
            <div class="grid lg:grid-cols-2 gap-24 items-center">
                <div class="relative group">
                    <div class="absolute -inset-10 bg-[#ED1C24]/5 rounded-full blur-[120px] opacity-50"></div>
                    <div class="relative rounded-[4rem] overflow-hidden border border-white/10 shadow-3xl">
                        <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=1200&q=80" alt="Consultation" class="w-full h-full object-cover grayscale brightness-75 group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#020617] via-transparent to-transparent"></div>
                    </div>
                </div>
                
                <div class="space-y-12">
                    <div class="inline-flex items-center gap-4 bg-[#ED1C24]/10 px-6 py-2 rounded-full border border-[#ED1C24]/20">
                        <span class="text-[10px] font-black text-[#ED1C24] uppercase tracking-[0.5em]">Secure Channel Active</span>
                    </div>
                    <h2 class="text-6xl md:text-8xl font-black text-white tracking-tighter uppercase leading-[0.8]">
                        The VIP <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-white/20">Consult</span>
                    </h2>
                    <p class="text-blue-100/40 text-xl font-medium leading-relaxed max-w-xl">
                        Beyond the algorithm lies the human edge. Engage in a direct uplink with our elite consultants to refine your strategy.
                    </p>
                    <div class="grid gap-8">
                        <div class="flex items-start gap-8 group">
                            <div class="w-16 h-16 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center text-[#ED1C24] group-hover:bg-[#ED1C24] group-hover:text-white transition-all duration-500">
                                <i class="fa-solid fa-fingerprint text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-black uppercase tracking-widest text-sm mb-2">Personalized Strategy</h4>
                                <p class="text-blue-100/20 text-xs font-bold leading-relaxed uppercase">Tailored tactical planning sessions for complex requirements.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-8 group">
                            <div class="w-16 h-16 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center text-blue-400 group-hover:bg-blue-400 group-hover:text-white transition-all duration-500">
                                <i class="fa-solid fa-tower-broadcast text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-black uppercase tracking-widest text-sm mb-2">Global Coordination</h4>
                                <p class="text-blue-100/20 text-xs font-bold leading-relaxed uppercase">Seamless interface across departmental and geographical boundaries.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Final Execution Node (Step 04) -->
    <div class="py-32">
        <div class="max-w-[1200px] mx-auto px-6 md:px-12">
            <div class="group relative grid md:grid-cols-[200px_1fr] gap-12 items-center">
                <div class="flex flex-col items-center justify-center">
                    <div class="text-8xl font-black text-white/5 tracking-tighter group-hover:text-[#ED1C24]/10 transition-colors duration-700">04</div>
                </div>
                <div class="relative p-12 bg-gradient-to-br from-[#ED1C24]/10 to-transparent backdrop-blur-3xl rounded-[3rem] border border-[#ED1C24]/20 group-hover:border-[#ED1C24]/50 transition-all duration-700 overflow-hidden">
                    <div class="flex flex-col md:flex-row gap-12 items-center">
                        <div class="w-24 h-24 bg-[#ED1C24] rounded-3xl flex items-center justify-center text-white shrink-0 group-hover:rotate-45 transition-all duration-700 shadow-[0_0_50px_rgba(237,28,36,0.3)]">
                            <i class="fa-solid fa-rocket text-4xl"></i>
                        </div>
                        <div class="space-y-6">
                            <h3 class="text-4xl font-black text-white uppercase tracking-tighter">Strategic Deployment</h3>
                            <p class="text-blue-100/40 text-lg leading-relaxed font-medium">Real-time on-ground supervision and monitoring. From security protocols to luxury aesthetics, every element is synchronized through your private dashboard.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Master CTA Architecture -->
    <div class="relative py-40 border-t border-white/5 overflow-hidden">
        <div class="absolute inset-0">
             <div class="absolute inset-0 bg-[#020617]"></div>
             <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[1200px] h-[600px] bg-[#ED1C24]/10 rounded-full blur-[200px] translate-y-1/2"></div>
        </div>
        
        <div class="max-w-4xl mx-auto px-6 relative z-10 text-center space-y-16">
            <h2 class="text-6xl md:text-8xl font-black text-white tracking-tighter uppercase leading-[0.8]">
                Initialize <br/><span class="text-[#ED1C24]">Narrative</span>
            </h2>
            <p class="text-blue-100/40 text-2xl font-medium leading-relaxed ">The infrastructure for your success is ready. Access the protocol today.</p>
            
            <div class="flex flex-col sm:flex-row gap-8 justify-center">
                <a href="{{ route('register') }}" class="group relative px-12 py-6 bg-[#ED1C24] text-white rounded-2xl font-black text-lg shadow-[0_20px_60px_rgba(237,28,36,0.4)] overflow-hidden transition-all hover:scale-105 active:scale-95 duration-500">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                    <span class="relative z-10 flex items-center justify-center gap-4 uppercase tracking-[0.4em]">Initialize Account <i class="fa-solid fa-key-skeleton"></i></span>
                </a>
                <a href="{{ route('contact') }}" class="px-12 py-6 bg-white/5 border border-white/10 text-white rounded-2xl font-black text-lg hover:bg-white/10 transition-all uppercase tracking-[0.4em] backdrop-blur-xl">
                    Secure Uplink
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes scan {
        0% { transform: translateY(-100vh); opacity: 0; }
        50% { opacity: 1; }
        100% { transform: translateY(100vh); opacity: 0; }
    }
    .animate-scan {
        animation: scan 6s linear infinite;
    }
</style>
@endsection


