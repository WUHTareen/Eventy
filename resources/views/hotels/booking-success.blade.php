<x-app-layout>
    <div class="py-16 bg-slate-50 min-h-screen">
        <div class="max-w-lg mx-auto px-4 text-center">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5">
                    <i class="fa-solid fa-check text-green-600 text-3xl"></i>
                </div>
                <h2 class="text-2xl font-black text-gray-800 mb-2">Booking Confirmed!</h2>
                <p class="text-gray-500 mb-6">Your booking has been submitted successfully.</p>

                <div class="bg-slate-50 rounded-xl p-5 text-left space-y-3 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Booking ID</span>
                        <span class="font-bold">#{{ $booking->id }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Hotel</span>
                        <span class="font-bold">{{ $booking->hotel->name }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Room</span>
                        <span class="font-bold">{{ $booking->room->name }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Check-in</span>
                        <span class="font-bold">{{ $booking->check_in->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Check-out</span>
                        <span class="font-bold">{{ $booking->check_out->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Nights</span>
                        <span class="font-bold">{{ $booking->nights }}</span>
                    </div>
                    <hr>
                    <div class="flex justify-between">
                        <span class="font-bold">Total Amount</span>
                        <span class="font-black text-indigo-600 text-lg">Rs. {{ number_format($booking->total_amount) }}</span>
                    </div>
                </div>

                <a href="{{ route('hotels.index') }}" class="block w-full bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 transition">
                    Browse More Hotels
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
