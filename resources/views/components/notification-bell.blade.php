<!-- Notification Bell Dropdown Component -->
<div class="relative" x-data="{ open: false, notifications: [], unreadCount: 0 }" 
     x-init="
        fetch('{{ route('notifications.recent') }}', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(r => r.json())
            .then(data => { 
                notifications = data.notifications; 
                unreadCount = data.unread_count;
            });
        setInterval(() => {
            fetch('{{ route('notifications.recent') }}', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(r => r.json())
                .then(data => { 
                    notifications = data.notifications; 
                    unreadCount = data.unread_count;
                });
        }, 5000);
     ">
    <!-- Bell Icon -->
    <button @click="open = !open" class="relative p-2 text-gray-600 hover:text-purple-600 transition-colors">
        <i class="fa-solid fa-bell text-xl"></i>
        <!-- Unread Badge -->
        <span x-show="unreadCount > 0" 
              x-text="unreadCount > 9 ? '9+' : unreadCount"
              class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse">
        </span>
    </button>

    <!-- Dropdown Panel -->
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
        
        <!-- Header -->
        <div class="px-4 py-3 bg-gradient-to-r from-purple-600 to-pink-500 flex items-center justify-between">
            <h3 class="text-white font-bold">Notifications</h3>
            <span x-show="unreadCount > 0" class="text-purple-100 text-xs" x-text="unreadCount + ' new'"></span>
        </div>

        <!-- Notifications List -->
        <div class="max-h-80 overflow-y-auto">
            <template x-for="notification in notifications" :key="notification.id">
                <a :href="notification.link || '#'" 
                   class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors border-b border-gray-100"
                   :class="{ 'bg-purple-50/50': !notification.is_read }">
                    <!-- Icon -->
                    <div class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center"
                         :class="{
                            'bg-gradient-to-br from-green-500 to-emerald-500': notification.color === 'green',
                            'bg-gradient-to-br from-purple-500 to-pink-500': notification.color === 'purple',
                            'bg-gradient-to-br from-blue-500 to-cyan-500': notification.color === 'blue',
                            'bg-gradient-to-br from-pink-500 to-rose-500': notification.color === 'pink',
                            'bg-gradient-to-br from-orange-500 to-amber-500': notification.color === 'orange'
                         }">
                        <i class="fa-solid text-white" :class="notification.icon || 'fa-bell'"></i>
                    </div>
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate" x-text="notification.title"></p>
                        <p class="text-xs text-gray-500 line-clamp-2" x-text="notification.message"></p>
                    </div>
                    <!-- Unread dot -->
                    <div x-show="!notification.is_read" class="w-2 h-2 bg-purple-500 rounded-full flex-shrink-0 mt-2"></div>
                </a>
            </template>

            <!-- Empty State -->
            <div x-show="notifications.length === 0" class="py-8 text-center">
                <i class="fa-solid fa-bell-slash text-gray-300 text-3xl mb-2"></i>
                <p class="text-gray-500 text-sm">No notifications yet</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-4 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
            <a href="{{ route('notifications.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                View All
            </a>
            <form action="{{ route('notifications.mark-all-read') }}" method="POST" x-show="unreadCount > 0">
                @csrf
                <button type="submit" class="text-gray-500 hover:text-gray-700 text-xs">
                    Mark all as read
                </button>
            </form>
        </div>
    </div>
</div>


