<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('bookings.index') }}" class="text-gray-400 hover:text-gray-700">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">{{ __('Complete Your Payment') }}</h2>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Amount summary -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6 flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Booking #{{ $booking->id }}</p>
                    <p class="text-gray-800 font-bold text-lg mt-1">{{ optional($booking->service)->name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Amount Due</p>
                    <p class="text-2xl font-black text-indigo-600">PKR {{ number_format($amount) }}</p>
                </div>
            </div>

            <!-- Where to pay -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-building-columns text-indigo-500"></i> Send your payment to
                </h3>

                <div class="grid sm:grid-cols-2 gap-4">
                    @if($accounts['bank_account'] || $accounts['bank_iban'])
                        <div class="border border-gray-100 rounded-xl p-4 bg-slate-50">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Bank Transfer</p>
                            @if($accounts['bank_name'])<p class="text-sm text-gray-700"><span class="text-gray-400">Bank:</span> <b>{{ $accounts['bank_name'] }}</b></p>@endif
                            @if($accounts['bank_title'])<p class="text-sm text-gray-700"><span class="text-gray-400">Title:</span> <b>{{ $accounts['bank_title'] }}</b></p>@endif
                            @if($accounts['bank_account'])<p class="text-sm text-gray-700"><span class="text-gray-400">Account:</span> <b>{{ $accounts['bank_account'] }}</b></p>@endif
                            @if($accounts['bank_iban'])<p class="text-sm text-gray-700"><span class="text-gray-400">IBAN:</span> <b>{{ $accounts['bank_iban'] }}</b></p>@endif
                        </div>
                    @endif

                    @if($accounts['jazzcash_number'])
                        <div class="border border-gray-100 rounded-xl p-4 bg-slate-50">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">JazzCash</p>
                            <p class="text-sm text-gray-700"><span class="text-gray-400">Number:</span> <b>{{ $accounts['jazzcash_number'] }}</b></p>
                            @if($accounts['bank_title'])<p class="text-sm text-gray-700"><span class="text-gray-400">Name:</span> <b>{{ $accounts['bank_title'] }}</b></p>@endif
                        </div>
                    @endif

                    @if($accounts['easypaisa_number'])
                        <div class="border border-gray-100 rounded-xl p-4 bg-slate-50">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">EasyPaisa</p>
                            <p class="text-sm text-gray-700"><span class="text-gray-400">Number:</span> <b>{{ $accounts['easypaisa_number'] }}</b></p>
                            @if($accounts['bank_title'])<p class="text-sm text-gray-700"><span class="text-gray-400">Name:</span> <b>{{ $accounts['bank_title'] }}</b></p>@endif
                        </div>
                    @endif
                </div>

                @if(!$accounts['bank_account'] && !$accounts['jazzcash_number'] && !$accounts['easypaisa_number'])
                    <p class="text-sm text-amber-600 bg-amber-50 border border-amber-100 rounded-xl p-4">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        Payment account details have not been configured yet. Please contact support.
                    </p>
                @endif

                @if($accounts['instructions'])
                    <div class="mt-4 text-sm text-gray-600 bg-indigo-50 border border-indigo-100 rounded-xl p-4 whitespace-pre-line">{{ $accounts['instructions'] }}</div>
                @endif
            </div>

            <!-- Upload proof -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-receipt text-indigo-500"></i> Upload payment proof
                </h3>

                <form action="{{ route('payment.manual.submit', $booking) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Paid via</label>
                        <select name="payment_method" required class="w-full rounded-xl border-gray-200 focus:border-indigo-400 focus:ring-indigo-400 text-sm">
                            <option value="bank">Bank Transfer</option>
                            <option value="jazzcash">JazzCash</option>
                            <option value="easypaisa">EasyPaisa</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Sender name <span class="text-red-400">*</span></label>
                        <input type="text" name="sender_name" value="{{ old('sender_name', auth()->user()->name) }}" required
                               class="w-full rounded-xl border-gray-200 focus:border-indigo-400 focus:ring-indigo-400 text-sm" placeholder="Name on the sending account">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Transaction ID / Reference <span class="text-gray-400">(optional)</span></label>
                        <input type="text" name="transaction_reference" value="{{ old('transaction_reference') }}"
                               class="w-full rounded-xl border-gray-200 focus:border-indigo-400 focus:ring-indigo-400 text-sm" placeholder="e.g. TXN123456789">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Screenshot of payment <span class="text-red-400">*</span></label>
                        <input type="file" name="payment_proof" accept="image/png,image/jpeg" required
                               class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-600 file:font-bold hover:file:bg-indigo-100">
                        <p class="text-xs text-gray-400 mt-1">PNG or JPG, up to 4 MB.</p>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Submit Payment Proof
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
