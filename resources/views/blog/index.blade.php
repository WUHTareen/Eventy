<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                <i class="fa-solid fa-newspaper text-[#0A3A7A] mr-2"></i>Blog & Insights
            </h2>
            <p class="text-gray-500 text-sm mt-1">Tips, stories and updates from Eventy</p>
        </div>
    </x-slot>

    <div class="py-10 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <form method="GET" action="{{ route('blog.index') }}" class="flex flex-col sm:flex-row gap-3 mb-8">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts..."
                    class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0A3A7A]/20 focus:border-[#0A3A7A] outline-none">
                @if($categories->count())
                <select name="category" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0A3A7A]/20 focus:border-[#0A3A7A] outline-none">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @endif
                <button type="submit" class="bg-[#0A3A7A] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-[#0D4E9A] transition">
                    <i class="fa-solid fa-search mr-1"></i> Search
                </button>
                @if(request('search') || request('category'))
                <a href="{{ route('blog.index') }}" class="bg-gray-100 text-gray-600 px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">Clear</a>
                @endif
            </form>

            @if($posts->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                <a href="{{ route('blog.show', $post->slug) }}" class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-[#0A3A7A]/10 to-[#0A3A7A]/5 flex items-center justify-center">
                            <i class="fa-solid fa-newspaper text-[#0A3A7A]/30 text-4xl"></i>
                        </div>
                    @endif
                    <div class="p-5">
                        @if($post->category)
                            <span class="text-xs font-semibold text-[#0A3A7A] bg-[#0A3A7A]/10 px-2 py-0.5 rounded-lg">{{ $post->category }}</span>
                        @endif
                        <h3 class="font-bold text-gray-800 mt-2 mb-1 group-hover:text-[#0A3A7A] transition-colors">{{ $post->title }}</h3>
                        @if($post->excerpt)
                            <p class="text-gray-500 text-sm line-clamp-2">{{ $post->excerpt }}</p>
                        @endif
                        <div class="flex items-center justify-between mt-4 text-xs text-gray-400">
                            <span><i class="fa-solid fa-user mr-1"></i>{{ $post->author->name ?? 'Eventy' }}</span>
                            <span><i class="fa-solid fa-calendar mr-1"></i>{{ $post->published_at?->format('M d, Y') }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="mt-8">{{ $posts->withQueryString()->links() }}</div>
            @else
            <div class="text-center py-20">
                <i class="fa-solid fa-newspaper text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-500 text-lg font-medium">No blog posts found</p>
                @if(request('search') || request('category'))
                    <a href="{{ route('blog.index') }}" class="mt-3 inline-block text-[#0A3A7A] font-semibold hover:underline">Clear filters</a>
                @endif
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
