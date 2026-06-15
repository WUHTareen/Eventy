<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            <i class="fa-solid fa-box-open text-amber-500 mr-2"></i>{{ __('Marketing Resources') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if($resources->count() > 0)
                        @foreach($resources as $type => $items)
                            <h3 class="text-xl font-bold text-gray-800 mb-4 capitalize">{{ $type }}s</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                                @foreach($items as $resource)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition">
                                        @if($resource->thumbnail)
                                            <img src="{{ asset('storage/' . $resource->thumbnail) }}" alt="{{ $resource->title }}" class="w-full h-40 object-cover rounded-md mb-4">
                                        @else
                                            <div class="w-full h-40 bg-gray-100 rounded-md mb-4 flex items-center justify-center">
                                                <i class="fa-solid fa-image text-gray-400 text-3xl"></i>
                                            </div>
                                        @endif
                                        <h4 class="font-bold text-lg mb-2">{{ $resource->title }}</h4>
                                        <div class="flex justify-between items-center mt-4">
                                            @if($resource->type === 'link')
                                                <input type="text" readonly value="{{ $resource->content }}" class="w-full text-xs border-gray-300 rounded mr-2">
                                                <button onclick="navigator.clipboard.writeText('{{ $resource->content }}')" class="text-[#0A3A7A] hover:text-[#0D4E9A]">
                                                    <i class="fa-solid fa-copy"></i>
                                                </button>
                                            @elseif($resource->type === 'banner')
                                                <a href="{{ asset('storage/' . $resource->content) }}" download class="w-full text-center bg-[#0A3A7A] text-white px-4 py-2 rounded text-sm hover:bg-[#0D4E9A]">
                                                    Download
                                                </a>
                                            @else
                                                <a href="{{ $resource->content }}" target="_blank" class="w-full text-center border border-[#0A3A7A] text-[#0A3A7A] px-4 py-2 rounded text-sm hover:bg-slate-50">
                                                    View
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-12">
                            <i class="fa-solid fa-folder-open text-gray-300 text-6xl mb-4"></i>
                            <p class="text-gray-500 text-lg">No marketing resources available yet. Check back soon!</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

