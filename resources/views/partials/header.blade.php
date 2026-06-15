@inject('serviceCategoryModel', 'App\Models\ServiceCategory')
@php
    $categories = $serviceCategoryModel::getTree();
@endphp

<nav x-data="{ open: false, mobileMenuOpen: false, searchOpen: false }" class="bg-white/95 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100/50 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex justify-between h-20 items-center">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center gap-3">
                <a href="{{ route('home') }}" class="group flex items-center gap-2">
                    <img src="{{ asset('images/EVN.png') }}" alt="Eventy" class="h-10 md:h-14 w-auto transition-transform duration-300 group-hover:scale-105">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-1">
                <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-primary-600 rounded-full hover:bg-primary-50 transition-all duration-200 {{ request()->routeIs('home') ? 'bg-primary-50 text-primary-600' : '' }}">
                    Home
                </a>

                <!-- Mega Menu Trigger -->
                <div class="group" x-data="{ hoverString: '' }">
                    <button class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-primary-600 rounded-full hover:bg-primary-50 transition-all duration-200 group flex items-center gap-1">
                        Services
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 group-hover:rotate-180"></i>
                    </button>

                    <!-- Mega Menu Dropdown -->
                    <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-screen max-w-7xl bg-white rounded-3xl shadow-[0_20px_70px_-10px_rgba(0,0,0,0.15)] border border-gray-100/50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-500 transform origin-top p-8 z-50">
                        <div class="grid grid-cols-12 gap-8">
                            <!-- Categories Grid (Balanced for 12 items) -->
                            <div class="col-span-9 grid grid-cols-3 gap-x-8 gap-y-4 max-h-[70vh] overflow-y-auto pr-4 custom-scrollbar">
                                @foreach($categories as $category)
                                <div class="group/cat p-3 rounded-2xl hover:bg-gray-50/80 transition-all duration-300 border border-transparent hover:border-primary-100/50">
                                    <a href="{{ route('desk.show', $category->slug) }}" class="flex items-start gap-3 mb-2">
                                        <div class="w-9 h-9 flex-shrink-0 rounded-xl flex items-center justify-center text-xs group-hover/cat:scale-110 group-hover/cat:rotate-3 transition-all duration-500 shadow-sm" style="background-color: {{ $category->color }}15; color: {{ $category->color }}">
                                            <i class="fa-solid {{ $category->icon }}"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <h3 class="font-black text-[12px] text-gray-900 group-hover/cat:text-primary-600 transition-colors uppercase tracking-tight leading-tight line-clamp-2">{{ $category->name }}</h3>
                                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">{{ $category->children->count() }} Specialties</p>
                                        </div>
                                    </a>
                                    @if($category->children->count() > 0)
                                    <ul class="space-y-1 ml-1 border-l border-gray-100 pl-4">
                                        @foreach($category->children->take(4) as $child)
                                        <li>
                                            <a href="{{ route('services', ['category' => $child->slug]) }}" class="text-[11px] text-gray-500 hover:text-secondary-500 block transition-colors font-medium truncate">
                                                {{ $child->name }}
                                            </a>
                                        </li>
                                        @endforeach
                                        @if($category->children->count() > 4)
                                        <li class="pt-0.5">
                                            <a href="{{ route('desk.show', $category->slug) }}" class="text-[9px] font-black text-primary-500 hover:text-secondary-500 uppercase tracking-widest">
                                                +{{ $category->children->count() - 4 }} More
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                    @endif
                                </div>
                                @endforeach
                            </div>

                            <!-- Featured / Promo Section (Refined) -->
                            <div class="col-span-3 rounded-[2rem] p-8 text-white overflow-hidden relative group/promo flex flex-col justify-between shadow-2xl" style="background: url('{{ asset('images/promo/ai-event-planner.png') }}') center/cover no-repeat;">
                                <div class="absolute inset-0 bg-gradient-to-br from-primary-950 via-primary-900/80 to-secondary-900/40 opacity-95 group-hover/promo:opacity-90 transition-opacity duration-300"></div>

                                <div class="relative z-10">
                                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 text-[10px] font-black uppercase tracking-[0.2em] rounded-full mb-6">
                                        <span class="w-1.5 h-1.5 bg-secondary-500 rounded-full"></span>
                                        Smart Tool
                                    </div>
                                    <h4 class="text-2xl font-black mb-3 leading-tight tracking-tighter">AI Event <br>Architect</h4>
                                    <p class="text-xs text-blue-100/80 mb-6 font-medium leading-relaxed ">Engineered to bring your vision to life with precision.</p>
                                </div>

                                <a href="{{ route('budget-planner') }}" class="inline-flex items-center justify-center gap-3 bg-white text-primary-900 hover:bg-secondary-500 hover:text-white text-xs font-black px-6 py-4 rounded-2xl transition-all duration-300 relative z-10 shadow-xl group-hover/promo:-translate-y-1 uppercase tracking-widest">
                                    Initialize <i class="fa-solid fa-arrow-right-long text-[10px]"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Mega Menu Footer (Polished) -->
                        <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="text-[10px] font-black text-gray-300 uppercase tracking-[0.3em]">Corporate Ecosystem</span>
                                <div class="w-8 h-[1px] bg-gray-200"></div>
                                <p class="text-[11px] text-gray-400 font-medium">Serving 500+ Luxury Brands Worldwide</p>
                            </div>
                            <a href="{{ route('services') }}" class="group flex items-center gap-3 text-primary-600 hover:text-secondary-500 transition-all font-black text-[11px] uppercase tracking-widest">
                                <span>Master Portfolio</span>
                                <div class="w-6 h-6 rounded-full bg-primary-50 flex items-center justify-center group-hover:bg-secondary-500 group-hover:text-white transition-colors">
                                    <i class="fa-solid fa-chevron-right text-[8px]"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('packages.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-primary-600 rounded-full hover:bg-primary-50 transition-all duration-200 {{ request()->routeIs('packages.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                    Packages
                </a>

                <!-- More Dropdown -->
                <div class="group relative">
                    <button class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-primary-600 rounded-full hover:bg-primary-50 transition-all duration-200 flex items-center gap-1">
                        More
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 group-hover:rotate-180"></i>
                    </button>

                    <!-- More Dropdown Menu -->
                    <div class="absolute right-0 top-full mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100/50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-right p-2 z-50">
                        <a href="{{ route('about') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all {{ request()->routeIs('about') ? 'bg-primary-50 text-primary-600' : '' }}">
                            <i class="fa-solid fa-info-circle text-xs w-4"></i>
                            About
                        </a>
                        <a href="{{ route('global') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all {{ request()->routeIs('global') ? 'bg-primary-50 text-primary-600' : '' }}">
                            <i class="fa-solid fa-globe text-xs w-4"></i>
                            Global Network
                        </a>
                        <a href="{{ route('upcoming') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all {{ request()->routeIs('upcoming') ? 'bg-primary-50 text-primary-600' : '' }}">
                            <i class="fa-solid fa-rocket text-xs w-4"></i>
                            Upcoming Features
                        </a>
                        <a href="{{ route('blueprint') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-xl transition-all">
                            <i class="fa-solid fa-map text-xs w-4"></i>
                            Roadmap
                        </a>
                        <a href="{{ route('insights') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all {{ request()->routeIs('insights') ? 'bg-primary-50 text-primary-600' : '' }}">
                            <i class="fa-solid fa-lightbulb text-xs w-4"></i>
                            Elite Insights
                        </a>
                        <a href="{{ route('blog.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all {{ request()->routeIs('blog.*') ? 'bg-primary-50 text-primary-600' : '' }}">
                            <i class="fa-solid fa-newspaper text-xs w-4"></i>
                            Blog
                        </a>
                        <a href="{{ route('vendor-onboarding') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all {{ request()->routeIs('vendor-onboarding') ? 'bg-primary-50 text-primary-600' : '' }}">
                            <i class="fa-solid fa-briefcase text-xs w-4"></i>
                            Join as Vendor
                        </a>
                        <div class="h-px bg-gray-100 my-2"></div>
                        <a href="{{ route('contact') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all {{ request()->routeIs('contact') ? 'bg-primary-50 text-primary-600' : '' }}">
                            <i class="fa-solid fa-envelope text-xs w-4"></i>
                            Contact
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Actions -->
            <div class="hidden lg:flex items-center gap-3">
                <!-- Global Search Trigger -->
                <button @click="$dispatch('open-search')" class="w-10 h-10 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-white hover:text-primary-600 hover:shadow-md transition-all">
                    <i class="fa-solid fa-magnifying-glass text-lg"></i>
                </button>

                @auth
                    <!-- Wallet Balance (Vendor/Admin) -->
                    @if(Auth::user()->role === 'vendor' || Auth::user()->role === 'admin')
                        <div class="hidden md:flex items-center px-4 py-2 bg-white border border-slate-100 rounded-2xl gap-2 shadow-sm mr-2 group/wallet hover:border-indigo-300 transition-all cursor-default">
                            <i class="fa-solid fa-wallet text-indigo-500 text-[10px] group-hover:rotate-12 transition-transform"></i>
                            <span class="text-[10px] font-black text-slate-900 tracking-widest uppercase">PKR {{ number_format(Auth::user()->balance) }}</span>
                        </div>
                    @endif

                    <!-- Notifications Polled -->
                    <div class="relative" x-data="{
                        open: false,
                        count: 0,
                        recent: [],
                        fetchNotifications() {
                            fetch('{{ route('notifications.recent') }}', {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            })
                                .then(res => res.json())
                                .then(data => {
                                    this.recent = data.notifications;
                                    this.count = data.unread_count;
                                });
                        },
                        init() {
                            this.fetchNotifications();
                            setInterval(() => this.fetchNotifications(), 15000);
                        }
                    }">
                        <button @click="open = !open" class="w-10 h-10 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-white hover:text-primary-600 hover:shadow-md transition-all relative">
                            <i class="fa-solid fa-bell text-lg"></i>
                            <template x-if="count > 0">
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-rose-500 text-white text-[10px] font-black rounded-full flex items-center justify-center border-2 border-white" x-text="count"></span>
                            </template>
                        </button>

                        <!-- Notification Dropdown -->
                        <div x-show="open"
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             class="absolute right-0 mt-3 w-80 bg-white rounded-[2rem] shadow-2xl border border-slate-100 overflow-hidden z-50">

                            <div class="p-5 border-b border-slate-50 flex justify-between items-center">
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Updates</h4>
                                <a href="{{ route('notifications.index') }}" class="text-[9px] font-bold text-indigo-500 uppercase hover:underline">View All</a>
                            </div>

                            <div class="max-h-[350px] overflow-y-auto">
                                <template x-if="recent.length === 0">
                                    <div class="p-10 text-center">
                                        <p class="text-[10px] font-bold text-slate-300 uppercase ">No recent updates</p>
                                    </div>
                                </template>

                                <template x-for="notif in recent" :key="notif.id">
                                    <a :href="notif.link || 'javascript:void(0)'"
                                       class="block p-5 hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0">
                                        <div class="flex gap-4">
                                            <div :class="{
                                                'w-10 h-10 rounded-xl flex items-center justify-center shadow-sm': true,
                                                'bg-emerald-50 text-emerald-500': notif.color === 'green',
                                                'bg-blue-50 text-blue-500': notif.color === 'blue',
                                                'bg-rose-50 text-rose-500': notif.color === 'red',
                                                'bg-amber-50 text-amber-500': notif.color === 'orange',
                                                'bg-indigo-50 text-indigo-500': notif.color === 'indigo' || !notif.color,
                                                'bg-purple-50 text-purple-500': notif.color === 'purple'
                                            }">
                                                <i class="fa-solid" :class="notif.icon || 'fa-info-circle'"></i>
                                            </div>
                                            <div class="flex-1">
                                                <h5 class="text-[11px] font-black text-slate-900 uppercase tracking-tighter mb-1" x-text="notif.title"></h5>
                                                <p class="text-[10px] text-slate-500 leading-relaxed line-clamp-2 " x-text="notif.message"></p>
                                            </div>
                                        </div>
                                    </a>
                                </template>
                            </div>

                            <div class="p-4 bg-slate-50/50 text-center">
                                <button onclick="fetch('{{ route('notifications.mark-all-read') }}', {method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}}).then(() => window.location.reload())"
                                        class="text-[9px] font-black text-slate-400 uppercase tracking-widest hover:text-slate-900">Mark all as read</button>
                            </div>
                        </div>
                    </div>

                    <!-- User Menu Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center gap-2 px-4 py-2 rounded-full bg-slate-50 border border-slate-200 hover:bg-white hover:shadow-md transition-all">
                            <div class="w-7 h-7 rounded-full bg-primary-100 flex items-center justify-center">
                                <i class="fa-solid fa-user text-primary-600 text-xs"></i>
                            </div>
                            <i class="fa-solid fa-chevron-down text-xs text-slate-600"></i>
                        </button>

                        <!-- User Dropdown Menu -->
                        <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-2xl shadow-xl border border-gray-100/50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-right p-2 z-50">
                            <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all">
                                <i class="fa-solid fa-gauge text-xs w-4"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('bookings.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all">
                                <i class="fa-solid fa-calendar-check text-xs w-4"></i>
                                My Bookings
                            </a>
                            <a href="{{ route('my-packages') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all">
                                <i class="fa-solid fa-box-archive text-xs w-4"></i>
                                My Packages
                            </a>
                            <a href="{{ route('messages.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all">
                                <i class="fa-solid fa-comment-dots text-xs w-4"></i>
                                Messages
                            </a>
                            <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all">
                                <i class="fa-solid fa-heart text-xs w-4"></i>
                                Wishlist
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all">
                                <i class="fa-solid fa-user-circle text-xs w-4"></i>
                                Profile
                            </a>
                            <div class="h-px bg-gray-100 my-2"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium text-red-600 hover:bg-red-50 rounded-xl transition-all">
                                    <i class="fa-solid fa-right-from-bracket text-xs w-4"></i>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-bold text-gray-600 hover:text-primary-900 transition-colors relative group">
                        Log in
                        <span class="absolute bottom-2 left-1/2 w-0 h-0.5 bg-primary-600 transition-all duration-300 -translate-x-1/2 group-hover:w-full opacity-0 group-hover:opacity-100"></span>
                    </a>
                    <a href="{{ route('register') }}" class="group relative px-6 py-2.5 rounded-full bg-slate-900 text-white shadow-xl shadow-slate-900/20 hover:shadow-slate-900/40 hover:-translate-y-0.5 transition-all duration-300 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-primary-600 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <span class="relative z-10 text-sm font-black tracking-wide flex items-center gap-2">
                            Sign Up <i class="fa-solid fa-arrow-right-long group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </a>
                @endauth
            </div>

            <!-- Mobile Quick Access -->
            <div class="lg:hidden flex items-center gap-3">
                @auth
                    <!-- Logged In: Show Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="w-10 h-10 rounded-full flex items-center justify-center text-red-500 hover:bg-red-50 transition-all border border-red-100" title="Logout">
                            <i class="fa-solid fa-power-off text-lg"></i>
                        </button>
                    </form>
                @else
                    <!-- Not Logged In: Show Sign Up -->
                    <a href="{{ route('register') }}" class="w-10 h-10 rounded-full flex items-center justify-center text-slate-600 hover:bg-slate-50 border border-slate-100 transition-all" title="Sign Up">
                        <i class="fa-solid fa-user-plus text-lg"></i>
                    </a>
                @endauth

                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 hover:text-primary-600 p-2.5 border border-gray-100 rounded-xl ml-1">
                    <i class="fa-solid fa-bars-staggered text-xl" x-show="!mobileMenuOpen"></i>
                    <i class="fa-solid fa-xmark text-xl" x-show="mobileMenuOpen" x-cloak></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="lg:hidden bg-white border-t border-gray-100 absolute w-full left-0 shadow-xl max-h-[80vh] overflow-y-auto" x-cloak>
        <div class="px-4 pt-2 pb-6 space-y-2">
            <a href="{{ route('home') }}" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-lg hover:bg-gray-50 hover:text-primary-600">Home</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-lg hover:bg-gray-50 hover:text-primary-600">About</a>

            <!-- Mobile Services Accordion -->
            <div x-data="{ servicesOpen: false }">
                <button @click="servicesOpen = !servicesOpen" class="w-full flex justify-between items-center px-3 py-2 text-base font-medium text-gray-700 rounded-lg hover:bg-gray-50 hover:text-primary-600">
                    <span>Services</span>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300" :class="{ 'rotate-180': servicesOpen }"></i>
                </button>
                <div x-show="servicesOpen" class="pl-4 space-y-1 mt-1 bg-gray-50/50 rounded-lg">
                    @foreach($categories as $category)
                    <div x-data="{ catOpen: false }">
                         <button @click="catOpen = !catOpen" class="w-full flex justify-between items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-primary-600">
                            <span class="flex items-center gap-2">
                                <i class="fa-solid {{ $category->icon }} text-xs opacity-70"></i> {{ $category->name }}
                            </span>
                            @if($category->children->count() > 0)
                            <i class="fa-solid fa-plus text-[10px] opacity-50" :class="{ 'rotate-45': catOpen }"></i>
                            @endif
                        </button>
                        @if($category->children->count() > 0)
                        <div x-show="catOpen" class="pl-8 pb-2 space-y-1">
                            @foreach($category->children as $child)
                             <a href="{{ route('services', ['category' => $child->slug]) }}" class="block px-3 py-1.5 text-xs text-gray-500 hover:text-secondary-500 border-l border-gray-200 ml-1">
                                {{ $child->name }}
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <a href="{{ route('packages.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-lg hover:bg-gray-50 hover:text-primary-600">Packages</a>
            <a href="{{ route('global') }}" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-lg hover:bg-gray-50 hover:text-primary-600">Global Network</a>
            <a href="{{ route('upcoming') }}" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-lg hover:bg-gray-50 hover:text-primary-600">Upcoming Features</a>
            <a href="{{ route('insights') }}" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-lg hover:bg-gray-50 hover:text-primary-600">Elite Insights</a>
            <a href="{{ route('blog.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-lg hover:bg-gray-50 hover:text-primary-600">Blog</a>
            <a href="{{ route('vendor-onboarding') }}" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-lg hover:bg-gray-50 hover:text-primary-600">Join as Vendor</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-lg hover:bg-gray-50 hover:text-primary-600">Contact Us</a>

            <div class="pt-4 border-t border-gray-100 flex flex-col gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full text-center text-gray-700 font-bold py-2 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full bg-red-50 text-red-600 font-bold py-3 rounded-xl hover:bg-red-100 transition-colors">Log Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="w-full text-center text-gray-600 font-bold py-3 hover:text-primary-600 transition-colors">Log In</a>
                    <a href="{{ route('register') }}" class="group relative w-full block text-center bg-slate-900 text-white font-bold py-3 rounded-xl shadow-lg overflow-hidden">
                         <div class="absolute inset-0 bg-gradient-to-r from-primary-600 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                         <span class="relative z-10 flex items-center justify-center gap-2">
                             Sign Up Free <i class="fa-solid fa-arrow-right"></i>
                         </span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>