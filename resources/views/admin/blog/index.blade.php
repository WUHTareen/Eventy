<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    <i class="fa-solid fa-newspaper text-[#0A3A7A] mr-2"></i>Blog Management
                </h2>
                <p class="text-gray-500 text-sm mt-1">Create and manage blog posts</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('blog.index') }}" target="_blank" class="flex items-center gap-2 bg-white text-[#0A3A7A] px-4 py-2 rounded-xl border border-[#0A3A7A]/20 hover:bg-slate-50 transition-colors shadow-lg">
                    <i class="fa-solid fa-eye text-green-500"></i>
                    <span class="font-bold text-sm">View Blog</span>
                </a>
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 bg-white text-[#0A3A7A] px-4 py-2 rounded-xl border border-[#0A3A7A]/20 hover:bg-slate-50 transition-colors shadow-lg">
                    <i class="fa-solid fa-house text-blue-500"></i>
                    <span class="font-bold text-sm">Front Page</span>
                </a>
                <a href="{{ route('admin.blog.create') }}" class="flex items-center gap-2 bg-[#0A3A7A] text-white px-4 py-2 rounded-xl hover:bg-[#0D4E9A] transition-colors shadow-lg">
                    <i class="fa-solid fa-plus"></i>
                    <span class="font-bold text-sm">New Post</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl mb-6 flex items-center">
                    <i class="fa-solid fa-check text-green-600 mr-3"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-newspaper text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Posts</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $posts->total() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-circle-check text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Published</p>
                            <p class="text-2xl font-bold text-gray-800">{{ \App\Models\BlogPost::where('is_published', true)->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-clock text-yellow-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Drafts</p>
                            <p class="text-2xl font-bold text-gray-800">{{ \App\Models\BlogPost::where('is_published', false)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-[#0A3A7A]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Post</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Views</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($posts as $post)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($post->featured_image)
                                        <img src="{{ $post->featured_image_url }}" class="w-12 h-12 rounded-xl object-cover" alt="">
                                    @else
                                        <div class="w-12 h-12 rounded-xl bg-[#0A3A7A]/10 flex items-center justify-center">
                                            <i class="fa-solid fa-image text-[#0A3A7A]"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">{{ Str::limit($post->title, 50) }}</p>
                                        <p class="text-xs text-gray-400">by {{ $post->author->name ?? 'Admin' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($post->category)
                                    <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-lg font-medium">{{ $post->category }}</span>
                                @else
                                    <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('admin.blog.toggle-publish', $post) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="{{ $post->is_published ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }} text-xs px-3 py-1 rounded-lg font-semibold hover:opacity-80 transition">
                                        {{ $post->is_published ? 'Published' : 'Draft' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <i class="fa-solid fa-eye text-gray-400 mr-1"></i>{{ number_format($post->views) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $post->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 transition" title="View">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('admin.blog.edit', $post) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-100 hover:bg-blue-200 text-blue-700 transition" title="Edit">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.blog.destroy', $post) }}" onsubmit="return confirm('Delete this post?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 hover:bg-red-200 text-red-600 transition" title="Delete">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <i class="fa-solid fa-newspaper text-gray-300 text-4xl mb-3"></i>
                                <p class="text-gray-500 font-medium">No blog posts yet</p>
                                <a href="{{ route('admin.blog.create') }}" class="mt-3 inline-block text-[#0A3A7A] text-sm font-semibold hover:underline">Create your first post</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($posts->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $posts->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
