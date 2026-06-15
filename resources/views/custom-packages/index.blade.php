@extends('layouts.public')

@section('title', 'Browser Custom Packages')

@section('content')
<div class="pt-24 pb-20 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">Exclusive Member Packages</h1>
            <p class="text-gray-600 max-w-2xl mx-auto text-lg">Bundled services for better planning and value.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($packages as $package)
            <div class="group bg-white rounded-[2.5rem] overflow-hidden shadow-sm border border-gray-100 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                <div class="relative h-64">
                    <img src="{{ $package->image ? asset('storage/' . $package->image) : 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=800&q=80' }}" 
                        class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 flex justify-between items-end text-white">
                        <div>
                            <div class="text-xs font-bold uppercase tracking-widest text-indigo-400 mb-1">
                                {{ $package->services->count() }} Services Included
                            </div>
                            <h3 class="text-2xl font-bold">{{ $package->name }}</h3>
                        </div>
                    </div>
                </div>
                
                <div class="p-8">
                    <p class="text-gray-600 line-clamp-2 mb-6">{{ $package->description }}</p>
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-xs text-gray-400 uppercase font-bold">Total Price</div>
                            <div class="text-2xl font-black text-indigo-600">Rs. {{ number_format($package->total_price) }}</div>
                        </div>
                        <a href="{{ route('packages.show', $package->id) }}" class="px-6 py-3 bg-gray-900 text-white rounded-2xl font-bold hover:bg-indigo-600 transition-colors">
                            View Bundle
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200">
                <i class="fa-solid fa-box-open text-6xl text-gray-200 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-900">No Packages Yet</h3>
                <p class="text-gray-500 mt-2">Check back later or <a href="{{ route('packages.create') }}" class="text-indigo-600 font-bold">build your own</a>.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $packages->links() }}
        </div>
    </div>
</div>
@endsection


