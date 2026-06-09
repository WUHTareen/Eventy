<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-end">
            <div class="relative group">
                <div class="absolute -left-4 top-0 bottom-0 w-1 bg-[#ED1C24] rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <h2 class="font-black text-5xl text-[#0A3A7A] tracking-tighter leading-none mb-2">
                    Message <span class="text-[#ED1C24]">Hub</span>
                </h2>
                <p class="text-[10px] font-black uppercase tracking-[0.5em] text-slate-400 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#0A3A7A]"></span>
                    Elite Communications Terminal
                </p>
            </div>
            <div class="hidden lg:flex items-center gap-4">
                <div class="flex flex-col items-end">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Channel Intensity</span>
                    <div class="flex gap-1 mt-1">
                        @for($i = 0; $i < 5; $i++)
                            <div class="w-1.5 h-3 rounded-full {{ $i < 4 ? 'bg-[#0A3A7A]' : 'bg-slate-200' }}"></div>
                        @endfor
                    </div>
                </div>
                <div class="h-12 w-[1px] bg-slate-100 mx-2"></div>
                <div class="bg-white px-6 py-3 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.6)] animate-pulse"></div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-[#0A3A7A]">Secure Link</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#F8FAFC] min-h-[calc(100vh-160px)] relative overflow-hidden font-['Plus_Jakarta_Sans']">
        <!-- Elite Visual Foundation -->
        <div class="absolute top-[-20%] left-[-10%] w-[60%] h-[60%] bg-gradient-to-br from-[#0A3A7A]/10 to-transparent blur-[150px] rounded-full animate-float"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[50%] h-[50%] bg-gradient-to-tr from-[#ED1C24]/5 to-transparent blur-[150px] rounded-full animate-float" style="animation-delay: -5s;"></div>
        <div class="absolute inset-0 opacity-[0.01] pointer-events-none" style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>

        <div class="max-w-[1600px] mx-auto px-6 h-[800px] relative z-10">
            <!-- Floating Command Center -->
            <div class="bg-white/70 backdrop-blur-3xl rounded-[4rem] shadow-[0_50px_120px_rgba(0,0,0,0.1)] border border-white overflow-hidden flex h-full group/main transition-all duration-700 hover:shadow-[0_60px_150px_rgba(10,58,122,0.15)]">
                
                <!-- Sidebar: The Roster -->
                <div class="w-[380px] border-r border-slate-100 flex flex-col bg-slate-50/40 backdrop-blur-xl shrink-0">
                    <div class="p-10 pb-8 flex flex-col gap-8">
                        <div class="flex justify-between items-center">
                            <h3 class="text-[11px] font-black text-[#0A3A7A] uppercase tracking-[0.4em]">Active Threads</h3>
                            <button class="w-8 h-8 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-[#0A3A7A] hover:bg-[#0A3A7A] hover:text-white transition-all shadow-sm">
                                <i class="fa-solid fa-plus text-[10px]"></i>
                            </button>
                        </div>
                        <div class="relative group/search">
                            <i class="fa-solid fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 text-xs transition-colors group-focus-within/search:text-[#0A3A7A]"></i>
                            <input type="text" placeholder="Locate entity..." class="w-full pl-14 pr-6 py-5 bg-white border-2 border-slate-50 rounded-[2rem] text-sm font-bold placeholder:text-slate-300 focus:ring-8 focus:ring-[#0A3A7A]/5 focus:border-[#0A3A7A]/20 transition-all outline-none shadow-sm">
                        </div>
                    </div>
                    
                    <div class="flex-grow overflow-y-auto custom-scrollbar px-6 pb-10 space-y-4">
                        @forelse($conversations as $convo)
                            @php
                                $is_active = $receiver && $receiver->id === $convo->id;
                                $unread = $convo->unread_count;
                            @endphp
                            <a href="{{ route('messages.index', $convo) }}" class="flex items-center gap-5 p-5 rounded-[2.8rem] transition-all duration-700 border-2 {{ $is_active ? 'bg-white shadow-[0_20px_60px_rgba(10,58,122,0.12)] border-white scale-[1.03]' : 'bg-transparent border-transparent hover:bg-white/80 hover:border-white/50' }} group">
                                <div class="relative flex-shrink-0">
                                    <div class="w-16 h-16 rounded-[2rem] p-[4px] shadow-2xl transition-all group-hover:rotate-[10deg] {{ $is_active ? 'bg-gradient-to-br from-[#0A3A7A] to-[#ED1C24]' : 'bg-slate-200 group-hover:bg-[#0A3A7A]' }}">
                                        <div class="w-full h-full bg-white rounded-[1.8rem] overflow-hidden border-2 border-white">
                                            <img src="{{ $convo->getAvatarUrl() }}" class="w-full h-full object-cover grayscale-[0.3] group-hover:grayscale-0 transition-all duration-500">
                                        </div>
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-full border-[4px] border-white shadow-lg"></div>
                                    @if($unread > 0)
                                        <div class="absolute -top-1 -right-1 min-w-[24px] h-[24px] bg-[#ED1C24] text-white text-[10px] font-black rounded-full border-[4px] border-white flex items-center justify-center px-1 shadow-xl animate-pulse">
                                            {{ $unread }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow overflow-hidden">
                                    <div class="flex justify-between items-center mb-1">
                                        <h4 class="font-black text-[#0A3A7A] text-sm tracking-tight truncate group-hover:text-[#ED1C24] transition-colors uppercase">{{ $convo->name }}</h4>
                                        <span class="text-[8px] font-bold text-slate-300">{{ $convo->messages_max_created_at ? \Carbon\Carbon::parse($convo->messages_max_created_at)->format('H:i') : '' }}</span>
                                    </div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest truncate flex items-center gap-2">
                                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                        {{ $convo->role === 'vendor' ? 'Elite Partner' : 'Platform Client' }}
                                    </p>
                                </div>
                            </a>
                        @empty
                            <div class="flex flex-col items-center justify-center py-24 px-10 text-center">
                                <div class="w-20 h-20 bg-slate-100 rounded-[2.5rem] flex items-center justify-center mb-6 shadow-inner">
                                    <i class="fa-solid fa-comment-slash text-slate-300 text-3xl"></i>
                                </div>
                                <h5 class="text-[11px] font-black text-[#0A3A7A]/40 uppercase tracking-[0.3em]">No Threads Active</h5>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Main Content Area: Tactical Display -->
                <div class="flex-grow flex flex-col bg-white relative">
                    @if($receiver)
                        <!-- Display Header -->
                        <div class="p-10 border-b border-slate-50 flex justify-between items-center bg-white/90 backdrop-blur-2xl sticky top-0 z-20">
                            <div class="flex items-center gap-8">
                                <div class="relative">
                                    <div class="w-[72px] h-[72px] rounded-[2.2rem] p-1 bg-gradient-to-br from-[#0A3A7A]/20 to-[#ED1C24]/20 shadow-xl overflow-hidden group/header">
                                        <img src="{{ $receiver->getAvatarUrl() }}" class="w-full h-full object-cover rounded-[1.8rem] transition-transform duration-[2s] group-hover/header:scale-125">
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-emerald-500 rounded-full border-[5px] border-white shadow-lg"></div>
                                </div>
                                <div>
                                    <h3 class="font-black text-3xl text-[#0A3A7A] tracking-tighter uppercase leading-none mb-2">{{ $receiver->name }}</h3>
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center gap-2 py-1.5 px-4 bg-emerald-50 rounded-2xl border border-emerald-100/50">
                                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.5)] animate-pulse"></div>
                                            <span class="text-[9px] font-black text-emerald-600 uppercase tracking-[0.2em]">Operational</span>
                                        </div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest  opacity-50">{{ $receiver->role }} : {{ $receiver->id }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-5">
                                <button class="w-14 h-14 rounded-[1.8rem] bg-white border-2 border-slate-50 flex items-center justify-center text-slate-400 hover:text-[#0A3A7A] hover:bg-[#0A3A7A]/5 hover:border-[#0A3A7A]/10 transition-all shadow-sm group">
                                    <i class="fa-solid fa-phone-volume text-sm group-hover:scale-110 transition-transform"></i>
                                </button>
                                <button class="w-14 h-14 rounded-[1.8rem] bg-white border-2 border-slate-50 flex items-center justify-center text-slate-400 hover:text-[#ED1C24] hover:bg-[#ED1C24]/5 hover:border-[#ED1C24]/10 transition-all shadow-sm group">
                                    <i class="fa-solid fa-shield-virus text-sm group-hover:scale-110 transition-transform"></i>
                                </button>
                                <div class="h-10 w-[1px] bg-slate-100 mx-2"></div>
                                <button class="w-14 h-14 rounded-[1.8rem] bg-[#0A3A7A] flex items-center justify-center text-white shadow-[0_15px_30px_rgba(10,58,122,0.3)] hover:bg-[#ED1C24] hover:shadow-[#ED1C24]/30 transition-all">
                                    <i class="fa-solid fa-ellipsis-v"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Data Flow Display -->
                        <div 
                            id="chat-messages" 
                            class="flex-grow overflow-y-auto p-12 custom-scrollbar space-y-8 bg-gradient-to-b from-slate-50/30 to-white"
                            x-data="{ 
                                receiverId: {{ $receiver->id }},
                                init() {
                                    this.$nextTick(() => { this.scrollToBottom(); });
                                    setInterval(() => this.fetchUpdates(), 3000);
                                },
                                scrollToBottom() {
                                    const container = document.getElementById('chat-messages');
                                    container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
                                },
                                fetchUpdates() {
                                    fetch(`/messages/${this.receiverId}/updates`)
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.count > 0) {
                                            const container = document.getElementById('chat-messages-container');
                                            container.insertAdjacentHTML('beforeend', data.html);
                                            this.scrollToBottom();
                                        }
                                    });
                                }
                            }"
                        >
                            <!-- Date Separator -->
                            <div class="flex items-center gap-6 opacity-30">
                                <div class="h-[1px] flex-grow bg-gradient-to-r from-transparent to-[#0A3A7A]"></div>
                                <span class="text-[9px] font-black uppercase tracking-[0.5em] text-[#0A3A7A]">Tactical Archive</span>
                                <div class="h-[1px] flex-grow bg-gradient-to-l from-transparent to-[#0A3A7A]"></div>
                            </div>

                            <div id="chat-messages-container" class="space-y-10">
                                @foreach($messages as $message)
                                    @include('chat.partials.message', ['message' => $message])
                                @endforeach
                            </div>
                        </div>

                        <!-- Communication Uplink Module -->
                        <div class="p-12 border-t border-slate-50 bg-white" x-data="{ 
                            body: '',
                            submitting: false,
                            sendMessage() {
                                if (!this.body.trim() || this.submitting) return;
                                this.submitting = true;
                                
                                fetch('{{ route('messages.send', $receiver) }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'X-Requested-With': 'XMLHttpRequest'
                                    },
                                    body: JSON.stringify({ body: this.body })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    document.getElementById('chat-messages-container').insertAdjacentHTML('beforeend', data.html);
                                    this.body = '';
                                    this.submitting = false;
                                    this.$nextTick(() => {
                                        const container = document.getElementById('chat-messages');
                                        container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
                                    });
                                });
                            }
                        }">
                            <div class="relative group/input">
                                <div class="absolute inset-0 bg-gradient-to-r from-[#0A3A7A]/5 to-[#ED1C24]/5 rounded-[3rem] blur-2xl opacity-0 group-focus-within/input:opacity-100 transition-opacity"></div>
                                <div class="relative flex items-center gap-4 bg-slate-50/80 border-2 border-slate-50 rounded-[3rem] p-3 transition-all group-focus-within/input:bg-white group-focus-within/input:border-[#0A3A7A]/20 group-focus-within/input:shadow-2xl">
                                    <button class="w-14 h-14 rounded-full flex items-center justify-center text-slate-400 hover:text-[#0A3A7A] hover:bg-white transition-all shadow-sm">
                                        <i class="fa-solid fa-paperclip text-sm"></i>
                                    </button>
                                    <textarea 
                                        x-model="body"
                                        @keydown.enter.prevent="sendMessage()"
                                        placeholder="Draft secure mission directive..." 
                                        rows="1" 
                                        class="flex-grow py-5 bg-transparent border-none text-base font-bold text-[#0A3A7A] placeholder:text-slate-300 focus:ring-0 resize-none overflow-hidden"
                                    ></textarea>
                                    <button 
                                        @click="sendMessage()"
                                        class="h-14 px-12 bg-gradient-to-r from-[#0A3A7A] to-[#062c5a] text-white rounded-full font-black text-[11px] uppercase tracking-[0.3em] shadow-2xl shadow-[#0A3A7A]/30 hover:shadow-[#0A3A7A]/50 hover:scale-105 active:scale-95 transition-all flex items-center gap-4 bg-[length:200%_auto] hover:bg-right disabled:opacity-50"
                                        :disabled="submitting || !body.trim()"
                                    >
                                        <span x-show="!submitting">Initialize <i class="fa-solid fa-paper-plane  text-[10px]"></i></span>
                                        <span x-show="submitting"><i class="fa-solid fa-circle-notch animate-spin"></i></span>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-8 flex justify-between items-center px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Quantum-Locked Channel Security</p>
                                </div>
                                <span class="text-[9px] font-bold text-slate-200 tracking-widest uppercase ">Protocols V2.4 Active</span>
                            </div>
                        </div>
                    @else
                        <!-- Null Command State -->
                        <div class="flex-grow flex items-center justify-center p-20 text-center relative">
                            <div class="max-w-xl relative">
                                <div class="absolute inset-0 bg-[#0A3A7A]/5 blur-[100px] rounded-full scale-150 -z-10 animate-pulse"></div>
                                <div class="w-48 h-48 bg-white border border-slate-100 rounded-[4rem] flex items-center justify-center mx-auto mb-12 shadow-2xl relative group">
                                    <div class="absolute inset-4 border-2 border-dashed border-slate-100 rounded-[3rem] transition-all group-hover:rotate-45"></div>
                                    <i class="fa-solid fa-headset text-[#0A3A7A]/10 text-7xl transition-all group-hover:scale-110 group-hover:text-[#0A3A7A]/20"></i>
                                </div>
                                <h3 class="text-4xl font-black text-[#0A3A7A] tracking-tighter mb-4 uppercase leading-none">Command Interface <span class="text-[#ED1C24]">Ready</span></h3>
                                <p class="text-slate-400 font-bold text-xs leading-relaxed mb-12 uppercase tracking-[0.25em] max-w-sm mx-auto opacity-60">Authorize a synchronization with an elite partner to initialize secure negotiation protocols.</p>
                                <a href="{{ route('services') }}" class="inline-flex items-center gap-6 px-14 py-7 bg-gradient-to-r from-[#0A3A7A] to-[#ED1C24] text-white rounded-[2.5rem] text-[10px] font-black uppercase tracking-[0.5em] shadow-[0_20px_50px_rgba(10,58,122,0.25)] hover:shadow-[0_20px_60px_rgba(237,28,36,0.25)] hover:scale-105 active:scale-95 transition-all">
                                    <i class="fa-solid fa-satellite-dish animate-pulse"></i> Open Marketplace
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&display=swap');
        
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 20px;
            border: 2px solid transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #0A3A7A; }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(20px, -20px) scale(1.1); }
        }
        .animate-float { animation: float 20s ease-in-out infinite; }

        #chat-messages { scroll-behavior: smooth; }
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>

