<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Vendor: {{ $vendor->name }}
            </h2>
            @if(!$vendor->is_verified)
                <form method="POST" action="{{ route('admin.vendors.verify', $vendor->id) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-bold shadow hover:bg-green-700 transition">
                        Waitlist: Click to Verify
                    </button>
                </form>
            @else
                <span class="px-4 py-2 bg-green-100 text-white rounded-md text-sm font-bold text-green-700 border border-green-200">
                    <i class="fa-solid fa-check-circle mr-1"></i> Account Verified
                </span>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Vendor Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Vendor Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Business Name</p>
                            <p class="font-medium">{{ $vendor->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email Address</p>
                            <p class="font-medium">{{ $vendor->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Category Used</p>
                            <p class="font-medium">{{ $vendor->vendor_type ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Registered On</p>
                            <p class="font-medium">{{ $vendor->created_at->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">City</p>
                            <p class="font-medium">{{ $vendor->city->name ?? 'Unknown' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Published Services</h3>
                    
                    @if($services->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($services as $service)
                            <div class="border rounded-xl p-4 hover:shadow-lg transition">
                                <div class="h-40 w-full bg-gray-100 rounded-lg mb-4 overflow-hidden">
                                    @php $featuredImage = $service->getFeaturedImage(); @endphp
                                    @if($featuredImage)
                                        <img src="{{ Str::startsWith($featuredImage, ['http', 'https']) ? $featuredImage : asset('storage/' . $featuredImage) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-400">
                                            <i class="fa-regular fa-image text-3xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <h4 class="font-bold text-lg mb-1">{{ $service->title }}</h4>
                                <p class="text-purple-600 font-bold mb-2">${{ number_format($service->price) }}</p>
                                <div class="flex justify-between items-center text-sm text-gray-500">
                                    <span><i class="fa-solid fa-star text-yellow-400"></i> 4.5</span>
                                    <span><i class="fa-solid fa-calendar-check"></i> {{ $service->bookings_count ?? 0 }} bookings</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                            <i class="fa-solid fa-box-open text-gray-400 text-3xl mb-2"></i>
                            <p class="text-gray-500">This vendor hasn't published any services yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


