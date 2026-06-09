<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800"><i class="fa-solid fa-pen text-[#0A3A7A] mr-2"></i> Edit Hotel</h2>
            <a href="{{ route('admin.hotels.show', $hotel) }}" class="bg-white border border-gray-200 text-gray-700 px-5 py-2 rounded-xl font-bold text-sm hover:bg-gray-50 transition">← Back</a>
        </div>
    </x-slot>
    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4">
            @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700">
                <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ route('admin.hotels.update', $hotel) }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Hotel Name</label>
                            <input type="text" name="name" value="{{ $hotel->name }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">City</label>
                            <select name="city_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
                                @foreach($cities as $city)<option value="{{ $city->id }}" {{ $hotel->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>@endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Star Rating</label>
                            <select name="star_rating" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
                                @foreach([5,4,3,2,1] as $s)<option value="{{ $s }}" {{ $hotel->star_rating == $s ? 'selected' : '' }}>{{ $s }} Stars</option>@endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Status</label>
                            <select name="status" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="pending" {{ $hotel->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $hotel->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $hotel->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Phone</label>
                            <input type="text" name="phone" value="{{ $hotel->phone }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Email</label>
                            <input type="email" name="email" value="{{ $hotel->email }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Address</label>
                            <input type="text" name="address" value="{{ $hotel->address }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Description</label>
                            <textarea name="description" rows="4" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>{{ $hotel->description }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Cover Image <span class="text-gray-400 font-normal">(leave empty to keep current)</span></label>
                            @if($hotel->cover_image)<img src="{{ asset('storage/' . $hotel->cover_image) }}" class="h-20 rounded-lg mb-2">@endif
                            <input type="file" name="cover_image" accept="image/*" class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm">
                        </div>
                        <div class="flex items-center gap-3 pt-6">
                            <input type="checkbox" name="is_featured" id="is_featured" {{ $hotel->is_featured ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300">
                            <label for="is_featured" class="text-sm font-semibold text-gray-600">Mark as Featured</label>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-[#0A3A7A] text-white py-3 rounded-xl font-bold hover:bg-[#0D4E9A] transition">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
