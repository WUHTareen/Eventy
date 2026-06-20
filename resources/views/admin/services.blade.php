<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    <i class="fa-solid fa-boxes-stacked text-purple-600 mr-2"></i>{{ __('All Services') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Manage all services on the platform</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.services.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-5 rounded-xl transition-all flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Add Service
                </a>
                <a href="{{ route('admin.services.trash') }}" class="bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold py-2.5 px-5 rounded-xl transition-all flex items-center gap-2">
                    <i class="fa-solid fa-trash-can"></i> Trash
                </a>
                <a href="{{ route('admin.dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-5 rounded-xl transition-all flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50/50 to-white flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Services List</h3>
                        <p class="text-gray-500 text-sm">{{ $services->total() }} total services</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-4">Service</th>
                                <th class="px-6 py-4">Vendor</th>
                                <th class="px-6 py-4">Category</th>
                                <th class="px-6 py-4">Price</th>
                                <th class="px-6 py-4 text-center">Bookings</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($services as $service)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @php $featuredImage = $service->getFeaturedImage(); @endphp
                                            @if($featuredImage)
                                                <img src="{{ Str::startsWith($featuredImage, ['http', 'https']) ? $featuredImage : asset('storage/' . $featuredImage) }}" class="w-12 h-12 rounded-xl object-cover">
                                            @else
                                                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                                    <i class="fa-solid fa-image text-purple-400"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-bold text-gray-900">{{ Str::limit($service->name, 30) }}</p>
                                                <p class="text-xs text-gray-500">{{ $service->location ?? 'No location' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-900">{{ $service->user->name ?? 'Unknown' }}</p>
                                        <p class="text-xs text-gray-500">{{ $service->user->email ?? '' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold">
                                            {{ $service->category->name ?? 'Uncategorized' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        PKR {{ number_format($service->price) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">
                                            {{ $service->bookings()->count() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <form action="{{ route('admin.services.toggle', $service) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center transition-all {{ $service->is_featured ? 'bg-yellow-100 text-yellow-600 hover:bg-yellow-200' : 'bg-gray-100 text-gray-400 hover:bg-gray-200' }}" title="{{ $service->is_featured ? 'Unfeature' : 'Feature' }}">
                                                    <i class="fa-solid fa-star"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('services.show', $service) }}" class="w-8 h-8 bg-blue-50 hover:bg-blue-100 text-primary-500 rounded-lg flex items-center justify-center transition-all" title="View">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.services.edit', $service) }}" class="w-8 h-8 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center transition-all" title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <form action="{{ route('admin.services.delete', $service) }}" method="POST" onsubmit="return confirm('Move this service to trash? You can restore it later.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg flex items-center justify-center transition-all" title="Move to Trash">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <i class="fa-solid fa-box-open text-gray-300 text-4xl mb-3"></i>
                                        <p class="text-gray-500">No services found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($services->hasPages())
                    <div class="p-6 border-t border-gray-100">
                        {{ $services->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>


