<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Eventy.pk') | Global Event, Travel & Hospitality Platform</title>
    <meta name="description" content="@yield('description', 'Eventy.pk - Pakistan\'s First Hybrid Model Platform for Events, Travel & Hospitality.')">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f4f9', 100: '#e1e9f3', 200: '#c3d3e7', 300: '#a5bddb', 400: '#6991c3',
                            500: '#0A3A7A', 600: '#09346e', 700: '#082b5c', 800: '#062349', 900: '#051b3b'
                        },
                        secondary: {
                            50: '#fef3f3', 100: '#fee7e7', 200: '#fcc3c5', 300: '#fa9fa3', 400: '#f6575e',
                            500: '#ED1C24', 600: '#d51920', 700: '#b2151b', 800: '#8e1115', 900: '#750e11'
                        }
                    }
                }
            }
        }

        document.addEventListener('alpine:init', () => {
            Alpine.store('compare', {
                items: [],
                add(item) {
                    if (this.items.length >= 3) {
                        window.dispatchEvent(new CustomEvent('toast', {
                            detail: { message: 'Comparison limit reached (Max 3)', type: 'error' }
                        }));
                        return;
                    }
                    if (this.items.find(i => i.id === item.id)) {
                        this.remove(item.id);
                        return;
                    }
                    this.items.push(item);
                },
                remove(id) {
                    this.items = this.items.filter(i => i.id !== id);
                },
                clear() {
                    this.items = [];
                }
            })
        })
    </script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en', 
                includedLanguages: 'en,ur,ar,zh-CN,es,fr,de,ru', // Explicitly include Urdu (ur)
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <style>
        /* Global Google Translate Overrides */
        body { top: 0 !important; }
        .goog-te-banner-frame { display: none !important; }
        .goog-tooltip { display: none !important; }
        .goog-te-gadget-icon { display: none !important; }
        /* Hide "Powered by Google" */
        .goog-logo-link { display: none !important; }
        .goog-te-gadget { color: transparent !important; }
        [x-cloak] { display: none !important; }
    </style>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        // Fallback to jsDelivr if cloudflare CDN fails
        if (!document.querySelector('link[href*="font-awesome"]').sheet) {
            var link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css';
            document.head.appendChild(link);
        }
    </script>
    <style>
        html { font-size: 92%; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.02em; overflow-x: hidden; width: 100%; }
        .glass { background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.15); }
        .floating { animation: float 5s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        @keyframes pulse-glow { 0%, 100% { box-shadow: 0 0 20px rgba(37, 211, 102, 0.5); } 50% { box-shadow: 0 0 40px rgba(37, 211, 102, 0.8); } }
        .whatsapp-pulse { animation: pulse-glow 2s ease-in-out infinite; }
        @keyframes slide-up { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-slide-up { animation: slide-up 0.5s ease-out; }
        @keyframes toast-in { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }
        .toast-animate { animation: toast-in 0.4s ease-out; }
    </style>
    @stack('styles')

    {{-- Admin-managed header tracking / verification code (GSC, Analytics, Clarity, Meta Pixel, etc.) --}}
    @if($headerTrackingCode = \App\Models\SiteSetting::get('header_tracking_code'))
        {!! $headerTrackingCode !!}
    @endif
</head>
<body class="text-gray-800 antialiased flex flex-col min-h-screen overflow-x-hidden">
    @include('partials.toast')
    @include('partials.header')

    @include('partials.compare-dock')
    @include('partials.smart-concierge')

    @include('partials.social-pulse')


    <!-- Page Content -->
    <main class="flex-grow">
        @yield('content')
    </main>
    @include('partials.footer')

    <!-- Global Search Modal -->
    <div x-data="{ globalSearchOpen: false, query: '' }" 
         x-show="globalSearchOpen" 
         @open-search.window="globalSearchOpen = true; $nextTick(() => $refs.searchInput.focus())"
         @keydown.escape.window="globalSearchOpen = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 backdrop-blur-0"
         x-transition:enter-end="opacity-100 backdrop-blur-xl"
         x-transition:leave="transition ease-in duration-200"
         x-cloak
         class="fixed inset-0 z-[200] flex items-start justify-center pt-20 px-6 bg-slate-900/60 backdrop-blur-2xl">
        
        <div class="w-full max-w-3xl transform"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-12"
             x-transition:enter-end="opacity-100 translate-y-0"
             @click.away="globalSearchOpen = false">
            
             <form action="{{ route('services') }}" method="GET" class="relative group" autocomplete="off">
                <i class="fa-solid fa-magnifying-glass absolute left-8 top-1/2 -translate-y-1/2 text-slate-400 text-2xl group-focus-within:text-indigo-500 transition-colors"></i>
                <input type="text" 
                       name="search" 
                       x-ref="searchInput"
                       x-model="query"
                       @input.debounce.300ms="
                           if(query.length > 1) {
                               fetch(`/search-suggestions?q=${query}`)
                                   .then(res => res.json())
                                   .then(data => $refs.suggestions.innerHTML = data.map(s => `
                                       <a href='${s.url}' class='flex items-center gap-4 p-4 hover:bg-slate-50 rounded-2xl transition-all group/item'>
                                           <div class='w-12 h-12 rounded-xl overflow-hidden shadow-sm'>
                                               <img src='${s.image}' class='w-full h-full object-cover group-hover/item:scale-110 transition-transform'>
                                           </div>
                                           <div>
                                               <p class='text-sm font-black text-slate-900 leading-none mb-1'>${s.name}</p>
                                               <p class='text-[9px] font-black text-slate-400 uppercase tracking-widest'>${s.category}</p>
                                           </div>
                                           <i class='fa-solid fa-arrow-right-long ml-auto text-slate-200 group-hover/item:text-indigo-500 transition-colors'></i>
                                       </a>
                                   `).join(''))
                           } else {
                               $refs.suggestions.innerHTML = ''
                           }
                       "
                       placeholder="What are you celebrating today?" 
                       class="w-full pl-20 pr-8 py-10 rounded-[3rem] bg-white border-0 shadow-2xl text-2xl font-black text-slate-900 placeholder:text-slate-300 focus:ring-0 transition-all">
                
                <div class="absolute right-8 top-1/2 -translate-y-1/2 flex items-center gap-4">
                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100">ESC to close</span>
                    <button type="submit" class="w-16 h-16 bg-slate-900 text-white rounded-[1.5rem] flex items-center justify-center hover:bg-indigo-600 transition-colors shadow-xl">
                        <i class="fa-solid fa-arrow-right-long text-xl"></i>
                    </button>
                </div>

                <!-- Suggestions Pulse Dropdown -->
                <div x-ref="suggestions" class="absolute top-full left-0 right-0 mt-4 bg-white/90 backdrop-blur-2xl rounded-[2.5rem] shadow-2xl overflow-hidden border border-white p-2"></div>
            </form>

            <!-- Quick Links -->
            <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-6">
                @php
                    $trending = \App\Models\ServiceCategory::whereNull('parent_id')->limit(4)->get();
                @endphp
                @foreach($trending as $trend)
                    <a href="{{ route('desk.show', $trend->slug) }}" class="group p-6 bg-white/10 backdrop-blur-md rounded-[2.5rem] border border-white/10 hover:bg-white hover:border-white transition-all duration-500 text-center">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-white mb-4 mx-auto group-hover:bg-indigo-50 group-hover:text-indigo-500 transition-all">
                            <i class="fa-solid {{ $trend->icon }} text-lg"></i>
                        </div>
                        <p class="text-[10px] font-black text-white group-hover:text-slate-900 uppercase tracking-widest transition-colors">{{ $trend->name }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/923006423878?text=Hi%20Eventy!%20I%20need%20help%20with%20my%20event." target="_blank" 
       class="fixed bottom-6 right-6 z-50 w-16 h-16 bg-green-500 rounded-full flex items-center justify-center shadow-2xl whatsapp-pulse hover:scale-110 transition-transform group">
        <i class="fa-brands fa-whatsapp text-white text-3xl"></i>
        <span class="absolute right-full mr-3 bg-white text-gray-800 px-4 py-2 rounded-lg shadow-lg text-sm font-medium whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">
            Chat with us! 💬
        </span>
    </a>

    <!-- Back to Top Button -->
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" id="backToTop" 
            class="fixed bottom-6 left-6 z-50 w-12 h-12 bg-navy-600 text-white rounded-full flex items-center justify-center shadow-xl hover:bg-accent-500 hover:scale-110 transition-all hidden">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <script>
        // Back to top visibility
        window.addEventListener('scroll', function() {
            const btn = document.getElementById('backToTop');
            if (window.scrollY > 500) {
                btn.classList.remove('hidden');
                btn.classList.add('flex');
            } else {
                btn.classList.add('hidden');
                btn.classList.remove('flex');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>


