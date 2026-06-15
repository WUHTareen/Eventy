@php
    $message = session('success') ?? session('error') ?? session('status') ?? session('newsletter_success');
    $type = 'info';
    if(session('success') || session('newsletter_success')) $type = 'success';
    if(session('error')) $type = 'error';
    if(session('warning')) $type = 'warning';
@endphp

@if($message)
<div x-data="{ show: true }" 
     x-show="show" 
     x-init="setTimeout(() => show = false, 5000)"
     x-transition:enter="transition ease-out duration-300 transform"
     x-transition:enter-start="translate-y-4 opacity-0"
     x-transition:enter-end="translate-y-0 opacity-100"
     x-transition:leave="transition ease-in duration-300 transform"
     x-transition:leave-start="translate-y-0 opacity-100"
     x-transition:leave-end="translate-y-4 opacity-0"
     class="fixed bottom-6 right-6 z-[100] max-w-sm w-full">
    
    <div class="glass overflow-hidden rounded-2xl shadow-2xl border border-white/20 p-5 flex items-start gap-4 relaitve">
        <!-- Colored Pillar -->
        <div class="absolute left-0 top-0 bottom-0 w-1.5 
            @if($type == 'success') bg-green-500 @elseif($type == 'error') bg-red-500 @elseif($type == 'warning') bg-amber-500 @else bg-indigo-500 @endif">
        </div>

        <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center
            @if($type == 'success') bg-green-500/10 text-green-600 @elseif($type == 'error') bg-red-500/10 text-red-600 @elseif($type == 'warning') bg-amber-500/10 text-amber-600 @else bg-indigo-500/10 text-indigo-600 @endif">
            <i class="fa-solid 
                @if($type == 'success') fa-check-circle @elseif($type == 'error') fa-triangle-exclamation @elseif($type == 'warning') fa-circle-exclamation @else fa-circle-info @endif text-xl"></i>
        </div>

        <div class="flex-grow pt-0.5">
            <h4 class="font-black text-gray-900 text-sm uppercase tracking-widest mb-1">
                {{ ucfirst($type) }}
            </h4>
            <p class="text-sm text-gray-600 font-medium leading-relaxed">
                {{ $message }}
            </p>
        </div>

        <button @click="show = false" class="text-gray-400 hover:text-gray-900 transition-colors">
            <i class="fa-solid fa-times"></i>
        </button>
    </div>
</div>
@endif


