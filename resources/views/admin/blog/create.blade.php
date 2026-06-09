<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    <i class="fa-solid fa-plus-circle text-[#0A3A7A] mr-2"></i>Create Blog Post
                </h2>
                <p class="text-gray-500 text-sm mt-1">Write a new article for your blog</p>
            </div>
            <a href="{{ route('admin.blog.index') }}" class="flex items-center gap-2 bg-white text-[#0A3A7A] px-4 py-2 rounded-xl border border-[#0A3A7A]/20 hover:bg-slate-50 transition-colors shadow">
                <i class="fa-solid fa-arrow-left"></i>
                <span class="font-bold text-sm">Back to Posts</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl mb-6">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
                    <h3 class="font-bold text-gray-700 text-sm uppercase tracking-wider border-b pb-3">Post Details</h3>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#0A3A7A]/20 focus:border-[#0A3A7A] outline-none transition"
                            placeholder="Enter post title">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
                            <input type="text" name="category" value="{{ old('category') }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#0A3A7A]/20 focus:border-[#0A3A7A] outline-none transition"
                                placeholder="e.g. Events, Tips, News">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Featured Image</label>
                            <input type="file" name="featured_image" accept="image/*"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#0A3A7A]/20 focus:border-[#0A3A7A] outline-none transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Excerpt <span class="text-gray-400 font-normal">(short summary)</span></label>
                        <textarea name="excerpt" rows="2"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#0A3A7A]/20 focus:border-[#0A3A7A] outline-none transition resize-none"
                            placeholder="Brief description shown in blog listing...">{{ old('excerpt') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Content <span class="text-red-500">*</span></label>
                        <textarea name="content" rows="16" required
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#0A3A7A]/20 focus:border-[#0A3A7A] outline-none transition font-mono"
                            placeholder="Write your blog post content here...">{{ old('content') }}</textarea>
                        <p class="text-xs text-gray-400 mt-1">You can use basic HTML tags for formatting.</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_published" value="0">
                            <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                                class="w-5 h-5 text-[#0A3A7A] rounded border-gray-300 focus:ring-[#0A3A7A]">
                            <label for="is_published" class="text-sm font-semibold text-gray-700">Publish immediately</label>
                        </div>
                        <button type="submit" class="flex items-center gap-2 bg-[#0A3A7A] text-white px-6 py-3 rounded-xl hover:bg-[#0D4E9A] transition-colors shadow-lg font-semibold">
                            <i class="fa-solid fa-save"></i> Save Post
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
