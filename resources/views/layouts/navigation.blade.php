<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <img src="{{ asset('images/logo.png') }}" alt="Eventy" class="h-10  w-auto transition-transform duration-300 group-hover:scale-105">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-8 sm:flex">
                    <!-- Live Time Node -->
                    <div class="flex items-center px-4 py-2 bg-slate-50 rounded-xl border border-gray-100 my-2 self-center gap-3 group/clock">
                        <div class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#ED1C24] opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-[#ED1C24]"></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Live PKT</span>
                            <span id="nav-clock" class="text-xs font-black text-[#0A3A7A] tabular-nums tracking-wider leading-none">--:--:--</span>
                        </div>
                    </div>

                    @if(Auth::user()->hasRole('vendor'))
                        <x-nav-link :href="route('vendor.dashboard')" :active="request()->routeIs('vendor.dashboard')">
                            <i class="fa-solid fa-chart-line mr-2 text-[#0A3A7A]"></i> {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('vendor.orders')" :active="request()->routeIs('vendor.orders')">
                            <i class="fa-solid fa-clipboard-list mr-2 text-[#ED1C24]"></i> {{ __('Orders') }}
                        </x-nav-link>
                        <x-nav-link :href="route('vendor.analytics')" :active="request()->routeIs('vendor.analytics')">
                            <i class="fa-solid fa-chart-pie mr-2 text-green-600"></i> {{ __('Analytics') }}
                        </x-nav-link>
                        <x-nav-link :href="route('vendor.finance')" :active="request()->routeIs('vendor.finance')">
                            <i class="fa-solid fa-wallet mr-2 text-amber-500"></i> {{ __('Wallet') }}
                        </x-nav-link>
                        <x-nav-link :href="route('vendor.profile')" :active="request()->routeIs('vendor.profile')">
                            <i class="fa-solid fa-store mr-2 text-purple-600"></i> {{ __('Store Profile') }}
                        </x-nav-link>
                    @elseif(Auth::user()->hasRole('affiliate'))
        <x-nav-link :href="route('affiliate.dashboard')" :active="request()->routeIs('affiliate.dashboard')">
            <i class="fa-solid fa-chart-line mr-2 text-[#0A3A7A]"></i> {{ __('Dashboard') }}
        </x-nav-link>
        <x-nav-link :href="route('affiliate.leads')" :active="request()->routeIs('affiliate.leads')">
            <i class="fa-solid fa-users mr-2 text-primary-500"></i> {{ __('Leads') }}
        </x-nav-link>
        <x-nav-link :href="route('affiliate.commissions')" :active="request()->routeIs('affiliate.commissions')">
            <i class="fa-solid fa-money-bill-wave mr-2 text-green-600"></i> {{ __('Commissions') }}
        </x-nav-link>
        <x-nav-link :href="route('affiliate.resources')" :active="request()->routeIs('affiliate.resources')">
            <i class="fa-solid fa-box-open mr-2 text-amber-500"></i> {{ __('Resources') }}
        </x-nav-link>
    @elseif(Auth::user()->hasRole('admin'))
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            <i class="fa-solid fa-shield-halved mr-2 text-[#0A3A7A]"></i> {{ __('Dashboard') }}
                        </x-nav-link>
                        
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            <i class="fa-solid fa-users mr-2 text-primary-500"></i> {{ __('Users') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.vendors.index')" :active="request()->routeIs('admin.vendors.*')">
                            <i class="fa-solid fa-store mr-2 text-green-600"></i> {{ __('Vendors') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.vendor-logs')" :active="request()->routeIs('admin.vendor-logs')">
                            <i class="fa-solid fa-file-contract mr-2 text-indigo-600"></i> {{ __('Vendor Logs') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.withdrawals')" :active="request()->routeIs('admin.withdrawals')">
                            <i class="fa-solid fa-money-bill-transfer mr-2 text-amber-600"></i> {{ __('Withdrawals') }}
                        </x-nav-link>

                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="top" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-[#0A3A7A] hover:border-[#0A3A7A] focus:outline-none transition duration-150 ease-in-out h-[64px]">
                                        <div><i class="fa-solid fa-sliders mr-2 text-gray-500 group-hover:text-[#0A3A7A]"></i> Setup</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('admin.cities.index')">
                                        <i class="fa-solid fa-city mr-2 text-gray-400"></i> {{ __('Cities') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.service-categories.index')">
                                        <i class="fa-solid fa-list-check mr-2 text-gray-400"></i> {{ __('Service Categories') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.testimonials.index')">
                                        <i class="fa-solid fa-comment-dots mr-2 text-gray-400"></i> {{ __('Testimonials') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.features.index')">
                                        <i class="fa-solid fa-star mr-2 text-gray-400"></i> {{ __('Feature Cards') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        <i class="fa-solid fa-compass mr-2 text-primary-500"></i> {{ __('Explore') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                <!-- Messages Icon -->
                <div class="relative group" x-data="{ 
                    count: 0,
                    updateCount() {
                        fetch('{{ route('messages.unread-count') }}', {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                            .then(res => res.json())
                            .then(data => this.count = data.count);
                    },
                    init() {
                        this.updateCount();
                        setInterval(() => this.updateCount(), 10000);
                    }
                }">
                    <a href="{{ route('messages.index') }}" class="w-11 h-11 rounded-2xl border-2 border-slate-50 flex items-center justify-center text-slate-400 hover:text-[#0A3A7A] hover:border-[#0A3A7A]/20 hover:bg-[#0A3A7A]/5 transition-all group-hover:shadow-lg">
                        <i class="fa-solid fa-message text-base"></i>
                    </a>
                    <template x-if="count > 0">
                        <div class="absolute -top-1 -right-1 min-w-[20px] h-[20px] bg-[#ED1C24] rounded-full border-2 border-white flex items-center justify-center text-[8px] font-black text-white shadow-lg animate-bounce px-1" x-text="count"></div>
                    </template>
                </div>

                <!-- Notification Bell -->
                @include('components.notification-bell')
                
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-xl text-gray-600 bg-gray-50 hover:bg-primary-50 hover:text-primary-700 focus:outline-none transition ease-in-out duration-150 group">
                            <div class="w-9 h-9 border-2 border-white shadow-sm overflow-hidden rounded-full mr-2 group-hover:scale-110 transition-transform">
                                <img src="{{ Auth::user()->getAvatarUrl() }}" class="w-full h-full object-cover" alt="{{ Auth::user()->name }}">
                            </div>
                            <div class="font-bold">{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100 bg-primary-50/50">
                            <p class="text-xs text-primary-600 uppercase font-bold tracking-wider">Signed in as</p>
                            <p class="text-sm font-medium text-gray-800 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('notifications.index')">
                            <i class="fa-solid fa-bell mr-2 text-gray-400"></i> {{ __('Notifications') }}
                        </x-dropdown-link>
                        @if(Auth::user()->hasRole('admin'))
                        <x-dropdown-link :href="route('admin.bookings')">
                            <i class="fa-solid fa-calendar-check mr-2 text-[#0A3A7A]"></i> {{ __('All Bookings') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('admin.services')">
                            <i class="fa-solid fa-boxes-stacked mr-2 text-[#0A3A7A]"></i> {{ __('All Services') }}
                        </x-dropdown-link>
                        @endif
                        <x-dropdown-link :href="route('bookings.index')">
                            <i class="fa-solid fa-calendar-check mr-2 text-[#ED1C24]"></i> {{ __('My Bookings') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fa-solid fa-user-gear mr-2 text-gray-400"></i> {{ __('Profile') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('wishlist.index')">
                            <i class="fa-solid fa-heart mr-2 text-red-500"></i> {{ __('My Wishlist') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 hover:bg-red-50">
                                <i class="fa-solid fa-right-from-bracket mr-2"></i> {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->hasRole('vendor'))
                <x-responsive-nav-link :href="route('vendor.dashboard')" :active="request()->routeIs('vendor.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
    @elseif(Auth::user()->hasRole('affiliate'))
        <x-responsive-nav-link :href="route('affiliate.dashboard')" :active="request()->routeIs('affiliate.dashboard')">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('affiliate.leads')" :active="request()->routeIs('affiliate.leads')">
            {{ __('Leads') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('affiliate.commissions')" :active="request()->routeIs('affiliate.commissions')">
            {{ __('Commissions') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('affiliate.resources')" :active="request()->routeIs('affiliate.resources')">
            {{ __('Resources') }}
        </x-responsive-nav-link>
    @elseif(Auth::user()->hasRole('admin'))
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Admin Panel') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endif
        </div>
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
<script>
    function updateClock() {
        const now = new Date();
        const options = { 
            timeZone: 'Asia/Karachi',
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit',
            hour12: true 
        };
        const formatter = new Intl.DateTimeFormat('en-US', options);
        document.getElementById('nav-clock').innerText = formatter.format(now);
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>


