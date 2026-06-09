<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    <i class="fa-solid fa-list-check text-indigo-600 mr-2"></i>{{ __('Service Category Management') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Manage service categories and their subcategories</p>
            </div>
            <a href="{{ route('admin.service-categories.create') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-indigo-500/30 transition-all flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Add New Category
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl relative mb-8 shadow-sm flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fa-solid fa-check text-green-600"></i>
                    </div>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50/50 to-white">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-layer-group text-indigo-500"></i> Service Hierachy
                        </h3>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50/50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                <th class="px-8 py-5">Category Name</th>
                                <th class="px-6 py-5 text-center">Icon</th>
                                <th class="px-6 py-5">Subcategories</th>
                                <th class="px-6 py-5">Order</th>
                                <th class="px-8 py-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($categories as $category)
                                <tr class="hover:bg-indigo-50/30 transition-colors group">
                                    <td class="px-8 py-5">
                                        <div class="font-bold text-gray-900">{{ $category->name }}</div>
                                        <div class="text-xs text-gray-400 font-mono">{{ $category->slug }}</div>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center mx-auto text-white" style="background-color: {{ $category->color }}">
                                            <i class="fa-solid {{ $category->icon }}"></i>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex flex-wrap gap-1">
                                            @forelse($category->children as $child)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ $child->name }}
                                                </span>
                                            @empty
                                                <span class="text-gray-400 text-xs ">No subcategories</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-gray-500 font-medium">
                                        {{ $category->sort_order }}
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <div class="flex items-center justify-end gap-2 opacity-70 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('admin.service-categories.edit', $category->id) }}" class="w-9 h-9 bg-yellow-50 hover:bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center transition-all" title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.service-categories.destroy', $category->id) }}" onsubmit="return confirm('Are you sure? This will delete all subcategories too.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-9 h-9 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg flex items-center justify-center transition-all" title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                
                                {{-- Show children rows with indentation if they exist --}}
                                @foreach($category->children as $child)
                                    <tr class="bg-gray-50/30 hover:bg-indigo-50/20 transition-colors group">
                                        <td class="px-8 py-4 pl-16">
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-arrow-turn-up rotate-90 text-gray-300 text-xs"></i>
                                                <div class="text-sm font-medium text-gray-700">{{ $child->name }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center mx-auto text-gray-500 border border-gray-200">
                                                <i class="fa-solid {{ $child->icon }}"></i>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-xs text-gray-400 ">
                                            Sub-category of {{ $category->name }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-400 text-sm">
                                            {{ $child->sort_order }}
                                        </td>
                                        <td class="px-8 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2 opacity-50 group-hover:opacity-100 transition-opacity">
                                                <a href="{{ route('admin.service-categories.edit', $child->id) }}" class="w-8 h-8 bg-yellow-50 hover:bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center transition-all">
                                                    <i class="fa-solid fa-pen text-xs"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.service-categories.destroy', $child->id) }}" onsubmit="return confirm('Delete this subcategory?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg flex items-center justify-center transition-all">
                                                        <i class="fa-solid fa-trash text-xs"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <i class="fa-solid fa-list-check text-gray-400 text-2xl"></i>
                                            </div>
                                            <p class="text-lg font-medium">No service categories found</p>
                                            <p class="text-sm mt-1">Start by adding a new service category.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($categories->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

