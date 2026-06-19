<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Booking | Eventy.pk</title>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] } } }
        };
    </script>
</head>
<body class="font-sans antialiased bg-slate-50 min-h-screen">

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <h2 class="font-bold text-2xl text-gray-800 leading-tight mb-6">Your Booking</h2>

            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl mb-6 font-medium">
                    <i class="fa-solid fa-check"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl mb-6 font-medium">
                    <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Booking #{{ $booking->id }}</p>
                        <p class="text-gray-800 font-bold text-lg mt-1">{{ optional($booking->service)->name }}</p>
                    </div>
                    @php
                        $statusColors = [
                            'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                            'confirmed' => 'bg-blue-50 text-blue-600 border-blue-100',
                            'completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                            'cancelled' => 'bg-red-50 text-red-600 border-red-100',
                        ];
                        $c = $statusColors[$booking->status] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                    @endphp
                    <span class="{{ $c }} border px-4 py-1.5 rounded-xl text-xs font-black uppercase tracking-widest">
                        {{ $booking->status }}
                    </span>
                </div>

                <div class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-400 text-xs">Event Date</p>
                        <p class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs">Total Amount</p>
                        <p class="font-bold text-gray-700">PKR {{ number_format($booking->total_price ?: optional($booking->service)->price) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center justify-between flex-wrap gap-4">
                <div>
                    <p class="font-bold text-gray-800">Payment Status</p>
                    @if($booking->status === 'pending')
                        <p class="text-sm text-gray-500 mt-1">Awaiting vendor approval. You can pay once confirmed.</p>
                    @elseif($booking->payment && $booking->payment->status === 'completed')
                        <p class="text-sm text-emerald-600 font-bold mt-1"><i class="fa-solid fa-circle-check"></i> Paid</p>
                    @elseif($booking->payment && $booking->payment->status === 'awaiting_verification')
                        <p class="text-sm text-amber-600 font-bold mt-1"><i class="fa-solid fa-hourglass-half"></i> Verifying your payment...</p>
                    @elseif($booking->payment && $booking->payment->status === 'failed')
                        <p class="text-sm text-red-500 font-bold mt-1"><i class="fa-solid fa-circle-xmark"></i> Rejected: {{ $booking->payment->admin_notes ?: 'Please re-submit.' }}</p>
                    @else
                        <p class="text-sm text-gray-500 mt-1">Not paid yet.</p>
                    @endif
                </div>

                @if($booking->status !== 'pending' && (!$booking->payment || $booking->payment->status !== 'completed'))
                    <a href="{{ route('payment.manual', ['booking' => $booking->id, 'token' => $booking->tracking_token]) }}"
                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-all flex items-center gap-2">
                        <i class="fa-solid fa-credit-card"></i> Pay Now
                    </a>
                @endif
            </div>

            <p class="text-xs text-gray-400 mt-6 text-center">
                Bookmark this page to check your booking status anytime. We've also emailed you this link.
            </p>
        </div>
    </div>
</body>
</html>
