@extends('layouts.public')

@section('title', $post->title)
@section('description', $post->excerpt ?? Str::limit(strip_tags($post->content), 160))

@section('content')
<div class="py-10 bg-gradient-to-b from-slate-50 to-white min-h-screen">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-6">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-[#0A3A7A] font-semibold hover:underline text-sm">
                <i class="fa-solid fa-arrow-left"></i> Back to Blog
            </a>
        </div>

        @if($post->featured_image)
            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-64 sm:h-80 object-cover rounded-2xl mb-8 shadow">
        @endif

        <div class="flex flex-wrap items-center gap-3 mb-4">
            @if($post->category)
                <span class="text-xs font-semibold text-[#0A3A7A] bg-[#0A3A7A]/10 px-3 py-1 rounded-full">{{ $post->category }}</span>
            @endif
            <span class="text-xs text-gray-400"><i class="fa-solid fa-calendar mr-1"></i>{{ $post->published_at?->format('M d, Y') }}</span>
            <span class="text-xs text-gray-400"><i class="fa-solid fa-eye mr-1"></i>{{ number_format($post->views) }} views</span>
            <span class="text-xs text-gray-400"><i class="fa-solid fa-clock mr-1"></i>{{ $post->read_time }} min read</span>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-3 leading-tight">{{ $post->title }}</h1>

        @if($post->excerpt)
            <p class="text-lg text-gray-500 mb-6 leading-relaxed">{{ $post->excerpt }}</p>
        @endif

        <div class="flex items-center gap-2 mb-8 pb-6 border-b border-gray-100">
            <div class="w-8 h-8 bg-[#0A3A7A] rounded-full flex items-center justify-center">
                <i class="fa-solid fa-user text-white text-xs"></i>
            </div>
            <span class="text-sm font-semibold text-gray-700">{{ $post->author->name ?? 'Eventy Team' }}</span>
        </div>

        <div class="prose prose-slate max-w-none text-gray-700 leading-relaxed">
            {!! $post->content !!}
        </div>

        @if($related->count())
        <div class="mt-12 pt-8 border-t border-gray-100">
            <h3 class="font-bold text-gray-800 text-lg mb-5">Related Posts</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach($related as $rel)
                <a href="{{ route('blog.show', $rel->slug) }}" class="group bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-md transition">
                    @if($rel->featured_image)
                        <img src="{{ $rel->featured_image_url }}" class="w-full h-32 object-cover" alt="">
                    @else
                        <div class="w-full h-32 bg-[#0A3A7A]/5 flex items-center justify-center">
                            <i class="fa-solid fa-newspaper text-[#0A3A7A]/30 text-2xl"></i>
                        </div>
                    @endif
                    <div class="p-3">
                        <p class="text-sm font-semibold text-gray-800 group-hover:text-[#0A3A7A] transition line-clamp-2">{{ $rel->title }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <div class="mt-8">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-[#0A3A7A] font-semibold hover:underline">
                <i class="fa-solid fa-arrow-left"></i> Back to Blog
            </a>
        </div>
    </div>
</div>
@endsection