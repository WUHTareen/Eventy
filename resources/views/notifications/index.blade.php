<x-app-layout>
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Notifications</h1>
                <p class="text-gray-500 mt-1">Stay updated with your latest activities</p>
            </div>
            @if($notifications->where('is_read', false)->count() > 0)
                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-purple-600 hover:text-purple-800 font-medium text-sm flex items-center gap-2">
                        <i class="fa-solid fa-check-double"></i> Mark all as read
                    </button>
                </form>
            @endif
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fa-solid fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Notifications List -->
        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
            @forelse($notifications as $notification)
                <div class="flex items-start gap-4 p-6 border-b border-gray-100 hover:bg-gray-50 transition-colors {{ !$notification->is_read ? 'bg-purple-50/50' : '' }}">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        @php
                            $colors = [
                                'green' => 'from-green-500 to-emerald-500',
                                'purple' => 'from-purple-500 to-pink-500',
                                'blue' => 'from-blue-500 to-cyan-500',
                                'pink' => 'from-pink-500 to-rose-500',
                                'orange' => 'from-orange-500 to-amber-500',
                            ];
                            $colorClass = $colors[$notification->color] ?? $colors['purple'];
                        @endphp
                        <div class="w-12 h-12 bg-gradient-to-br {{ $colorClass }} rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fa-solid {{ $notification->icon ?? 'fa-bell' }} text-white"></i>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-grow min-w-0">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h4 class="font-bold text-gray-900 {{ !$notification->is_read ? 'text-purple-900' : '' }}">
                                    {{ $notification->title }}
                                </h4>
                                <p class="text-gray-600 text-sm mt-1">{{ $notification->message }}</p>
                                <p class="text-xs text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex items-center gap-2 flex-shrink-0">
                                @if(!$notification->is_read)
                                    <form action="{{ route('notifications.read', $notification) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-purple-600 hover:text-purple-800 p-2 hover:bg-purple-100 rounded-lg transition-colors" title="Mark as read">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                @if($notification->link)
                                    <a href="{{ $notification->link }}" class="text-primary-500 hover:text-blue-800 p-2 hover:bg-blue-100 rounded-lg transition-colors" title="View">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                @endif
                                
                                <form action="{{ route('notifications.destroy', $notification) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 p-2 hover:bg-red-100 rounded-lg transition-colors" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Unread Indicator -->
                    @if(!$notification->is_read)
                        <div class="w-2 h-2 bg-purple-500 rounded-full flex-shrink-0 mt-2"></div>
                    @endif
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-bell-slash text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No notifications yet</h3>
                    <p class="text-gray-500 mt-1">We'll notify you when something important happens.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="mt-8">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
</x-app-layout>


