<div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }} mb-8 group/msg">
    <div class="flex {{ $message->sender_id === auth()->id() ? 'flex-row-reverse' : 'flex-row' }} items-end gap-4 max-w-[85%]">
        <!-- Tactical Avatar Frame -->
        @if($message->sender_id !== auth()->id())
            <div class="w-10 h-10 rounded-xl border-2 border-slate-100 overflow-hidden flex-shrink-0 shadow-sm transition-transform group-hover/msg:-rotate-6">
                <img src="{{ $message->sender->getAvatarUrl() }}" class="w-full h-full object-cover">
            </div>
        @endif
        
        <!-- Bubble Matrix -->
        <div class="relative">
            <div class="px-8 py-5 rounded-[2.5rem] {{ $message->sender_id === auth()->id() ? 'bg-[#0A3A7A] text-white rounded-br-none shadow-[0_15px_30px_rgba(10,58,122,0.2)]' : 'bg-white border-2 border-slate-50 text-[#0A3A7A] rounded-bl-none shadow-sm' }} transition-all group-hover/msg:shadow-md">
                <p class="text-sm font-bold leading-[1.6] tracking-tight">{{ $message->body }}</p>
            </div>
            
            <!-- Metadata Stream -->
            <div class="mt-3 flex items-center gap-3 {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                <span class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-300 ">
                    {{ $message->created_at->format('h:i A') }}
                </span>
                @if($message->sender_id === auth()->id())
                    <span class="flex items-center">
                        @if($message->is_read)
                            <div class="flex -space-x-1">
                                <i class="fa-solid fa-check text-[8px] text-[#ED1C24] animate-pulse"></i>
                                <i class="fa-solid fa-check text-[8px] text-[#ED1C24] animate-pulse"></i>
                            </div>
                        @else
                            <i class="fa-solid fa-check text-[8px] text-slate-200"></i>
                        @endif
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

