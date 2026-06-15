<div x-data="{ 
    showScrollTop: false,
    scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}" 
x-init="window.addEventListener('scroll', () => { showScrollTop = window.pageYOffset > 500 })"
x-show="showScrollTop"
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="opacity-0 translate-y-10"
x-transition:enter-end="opacity-100 translate-y-0"
x-transition:leave="transition ease-in duration-300"
x-transition:leave-start="opacity-100 translate-y-0"
x-transition:leave-end="opacity-0 translate-y-10"
class="fixed bottom-8 right-8 z-[60]">
    <button @click="scrollToTop()" class="w-14 h-14 bg-white/80 backdrop-blur-md text-primary-600 rounded-2xl shadow-2xl border border-primary-100 flex items-center justify-center hover:bg-primary-600 hover:text-white transition-all transform hover:-translate-y-2 group">
        <i class="fa-solid fa-chevron-up text-xl transition-transform group-hover:scale-125"></i>
    </button>
</div>

