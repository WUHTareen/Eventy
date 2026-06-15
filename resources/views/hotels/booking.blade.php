<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800">Book Room — {{ $hotel->name }}</h2>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4">

            @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700">
                <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Booking Form --}}
                <div class="md:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-lg text-gray-800 mb-4">Booking Details</h3>
                    <form method="POST" action="{{ route('hotels.book.store', [$hotel, $room]) }}">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Check-in Date</label>
                                <input type="date" name="check_in" value="{{ old('check_in') }}" min="{{ date('Y-m-d') }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Check-out Date</label>
                                <input type="date" name="check_out" value="{{ old('check_out') }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Guests</label>
                                <select name="guests" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">
                                    @for($i = 1; $i <= $room->capacity; $i++)
                                        <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'Guest' : 'Guests' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Guest Phone</label>
                                <input type="text" name="guest_phone" value="{{ old('guest_phone') }}" placeholder="+92 300 0000000" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Guest Full Name</label>
                                <input type="text" name="guest_name" value="{{ old('guest_name', auth()->user()->name) }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500" required>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-semibold text-gray-600 mb-1">Special Requests <span class="text-gray-400 font-normal">(optional)</span></label>
                                <textarea name="special_requests" rows="3" placeholder="Any special requirements..." class="w-full border border-gray-200 rounded-xl px-4 py-2.5 outline-none focus:ring-2 focus:ring-indigo-500">{{ old('special_requests') }}</textarea>
                            </div>
                        </div>
                        <button type="submit" class="mt-5 w-full bg-indigo-600 text-white py-3 rounded-xl font-bold text-lg hover:bg-indigo-700 transition">
                            Confirm Booking
                        </button>
                    </form>
                </div>

                {{-- Room Summary --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-fit">
                    <h3 class="font-bold text-gray-800 mb-4">Room Summary</h3>
                    @if($room->image)
                        <img src="{{ asset('storage/' . $room->image) }}" class="w-full h-32 object-cover rounded-xl mb-4">
                    @endif
                    <p class="font-bold text-gray-800">{{ $room->name }}</p>
                    <p class="text-gray-500 text-sm">{{ $hotel->name }}</p>
                    <p class="text-gray-500 text-sm mt-1">👥 Max {{ $room->capacity }} guests</p>
                    <hr class="my-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Per Night</span>
                        <span class="font-bold">Rs. {{ number_format($room->price_per_night) }}</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Total will be calculated based on selected dates</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
