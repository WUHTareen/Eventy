<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase tracking-tighter">
                {{ __('Payment Verification') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-xl transition-all flex items-center gap-2 text-sm">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl mb-6 font-medium">
                    <i class="fa-solid fa-check"></i> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl rounded-[2.5rem] border border-gray-100">
                <div class="p-8">
                    <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
                        <h3 class="text-2xl font-black text-[#0A3A7A] tracking-tighter uppercase">
                            Manual <span class="text-[#ED1C24]">Payments</span>
                            @if($pendingCount > 0)
                                <span class="ml-2 bg-amber-100 text-amber-600 px-3 py-1 rounded-full text-xs align-middle">{{ $pendingCount }} pending</span>
                            @endif
                        </h3>

                        <div class="flex gap-2 text-[10px] font-black uppercase tracking-widest">
                            @foreach(['awaiting_verification' => 'Pending', 'completed' => 'Verified', 'failed' => 'Rejected', 'all' => 'All'] as $key => $label)
                                <a href="{{ route('admin.payments.index', ['status' => $key]) }}"
                                   class="px-4 py-2 rounded-xl transition-all {{ $filter === $key ? 'bg-[#0A3A7A] text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b-2 border-gray-50 uppercase text-[10px] font-black text-gray-400 tracking-widest">
                                    <th class="px-4 py-4">Booking</th>
                                    <th class="px-4 py-4">Customer</th>
                                    <th class="px-4 py-4">Amount</th>
                                    <th class="px-4 py-4">Method</th>
                                    <th class="px-4 py-4">Reference</th>
                                    <th class="px-4 py-4">Proof</th>
                                    <th class="px-4 py-4">Status</th>
                                    <th class="px-4 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($payments as $payment)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-4 py-5 font-bold text-[#0A3A7A]">
                                            #{{ $payment->booking_id }}
                                            <p class="text-[10px] text-gray-400 font-medium">{{ optional($payment->booking->service)->name }}</p>
                                        </td>
                                        <td class="px-4 py-5">
                                            <span class="font-bold text-sm text-gray-700">{{ $payment->sender_name ?: optional($payment->user)->name }}</span>
                                            <p class="text-[10px] text-gray-400">{{ optional($payment->user)->email }}</p>
                                        </td>
                                        <td class="px-4 py-5 font-black text-lg">PKR {{ number_format($payment->amount) }}</td>
                                        <td class="px-4 py-5">
                                            <span class="text-xs font-bold text-gray-500 uppercase">{{ $payment->payment_method }}</span>
                                        </td>
                                        <td class="px-4 py-5 text-xs text-gray-500">{{ $payment->transaction_reference ?: '—' }}</td>
                                        <td class="px-4 py-5">
                                            @if($payment->payment_proof)
                                                <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank"
                                                   class="text-indigo-600 font-bold text-xs hover:underline flex items-center gap-1">
                                                    <i class="fa-solid fa-image"></i> View
                                                </a>
                                            @else
                                                <span class="text-gray-300 text-xs">—</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-5">
                                            @php
                                                $colors = [
                                                    'awaiting_verification' => 'bg-amber-100 text-amber-600',
                                                    'completed' => 'bg-emerald-100 text-emerald-600',
                                                    'failed' => 'bg-red-100 text-red-600',
                                                    'pending' => 'bg-gray-100 text-gray-500',
                                                ];
                                                $c = $colors[$payment->status] ?? 'bg-gray-100 text-gray-600';
                                            @endphp
                                            <span class="{{ $c }} px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest whitespace-nowrap">
                                                {{ str_replace('_', ' ', $payment->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-5 text-right">
                                            @if($payment->status === 'awaiting_verification')
                                                <div x-data="{ open: false }" class="inline-block">
                                                    <div class="flex justify-end gap-2">
                                                        <form action="{{ route('admin.payments.verify', $payment) }}" method="POST" onsubmit="return confirm('Confirm this payment as received?')">
                                                            @csrf @method('PUT')
                                                            <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest">
                                                                <i class="fa-solid fa-check"></i> Verify
                                                            </button>
                                                        </form>
                                                        <button @click="open = true" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest">
                                                            <i class="fa-solid fa-xmark"></i> Reject
                                                        </button>
                                                    </div>

                                                    <template x-if="open">
                                                        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
                                                            <div @click.away="open = false" class="bg-white rounded-[2rem] p-8 w-full max-w-md shadow-2xl text-left">
                                                                <h4 class="text-lg font-black text-[#0A3A7A] mb-4 uppercase">Reject Payment</h4>
                                                                <form action="{{ route('admin.payments.reject', $payment) }}" method="POST">
                                                                    @csrf @method('PUT')
                                                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Reason (sent to customer)</label>
                                                                    <textarea name="admin_notes" rows="3" class="w-full bg-gray-50 border-gray-100 rounded-2xl px-4 py-3 text-sm" placeholder="e.g. Amount does not match / proof unclear"></textarea>
                                                                    <div class="flex gap-3 mt-5">
                                                                        <button type="submit" class="flex-1 bg-red-600 text-white py-3 rounded-2xl font-black uppercase tracking-widest text-xs">Reject</button>
                                                                        <button type="button" @click="open = false" class="flex-1 bg-gray-100 text-gray-600 py-3 rounded-2xl font-black uppercase tracking-widest text-xs">Cancel</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            @else
                                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                                    {{ $payment->verified_at ? $payment->verified_at->format('M d, H:i') : '—' }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-20 text-center font-bold text-gray-400 uppercase tracking-widest text-xs">
                                            No payments found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
