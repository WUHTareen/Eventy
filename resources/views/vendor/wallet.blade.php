<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vendor Wallet') }}
        </h2>
    </x-slot>
<div class="p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-[#0A3A7A] tracking-tighter uppercase">Vendor <span class="text-[#ED1C24]">Wallet</span></h1>
            <p class="text-gray-500 font-medium">Manage your earnings, commissions, and withdrawal requests.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Balance Card -->
        <div class="lg:col-span-1 bg-gradient-to-br from-[#0A3A7A] to-[#0D4E9A] rounded-[2rem] p-8 text-white shadow-xl shadow-blue-900/20 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-12 -mt-12 -mr-12 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-all"></div>
            <div class="relative z-10">
                <p class="text-blue-100 font-bold uppercase tracking-widest text-xs mb-4">Available Balance</p>
                <h2 class="text-5xl font-black mb-8 tracking-tighter ">PKR {{ number_format($user->balance, 2) }}</h2>
                
                <div class="flex items-center gap-4">
                    <div class="bg-white/10 px-4 py-2 rounded-xl border border-white/20">
                        <p class="text-[10px] font-bold text-blue-200 uppercase">Commission Rate</p>
                        <p class="font-black">{{ $user->commission_rate }}%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Withdrawal Form -->
        <div class="lg:col-span-2 bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm shadow-blue-900/5">
            <h3 class="text-xl font-black text-[#0A3A7A] mb-6 tracking-tight uppercase">Request <span class="text-[#ED1C24]">Withdrawal</span></h3>
            
            <form action="{{ route('vendor.withdraw') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 uppercase tracking-widest">Amount to Withdraw</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">PKR</span>
                            <input type="number" name="amount" min="500" max="{{ $user->balance }}" step="0.01" required
                                class="w-full pl-16 pr-4 py-4 bg-gray-50 border-gray-100 rounded-2xl focus:ring-2 focus:ring-[#0A3A7A] focus:bg-white transition-all font-bold text-lg"
                                placeholder="0.00">
                        </div>
                        <p class="text-xs text-gray-400 font-medium">Minimum withdrawal: PKR 500</p>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 uppercase tracking-widest">Payment Method</label>
                        <select name="payment_method" required class="w-full px-4 py-4 bg-gray-50 border-gray-100 rounded-2xl focus:ring-2 focus:ring-[#0A3A7A] focus:bg-white transition-all font-bold">
                            <option value="bank_transfer">Bank Transfer (JazzCash/EasyPaisa/Bank)</option>
                            <option value="cash">Direct Cash</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full md:w-auto px-12 py-4 bg-[#ED1C24] hover:bg-[#D1181F] text-white rounded-2xl font-black uppercase tracking-widest shadow-lg shadow-red-900/20 transition-all hover:-translate-y-1 active:scale-95 disabled:opacity-50" {{ $user->balance < 500 ? 'disabled' : '' }}>
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- History -->
    <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm shadow-blue-900/5">
        <h3 class="text-xl font-black text-[#0A3A7A] mb-8 tracking-tight uppercase">Withdrawal <span class="text-[#ED1C24]">History</span></h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-50">
                        <th class="pb-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Date</th>
                        <th class="pb-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Amount</th>
                        <th class="pb-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Method</th>
                        <th class="pb-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="pb-6 text-[10px] font-black text-gray-400 uppercase tracking-widest">Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($withdrawals as $withdrawal)
                    <tr class="group hover:bg-gray-50/50 transition-colors">
                        <td class="py-6 font-bold text-gray-600">{{ $withdrawal->created_at->format('M d, Y') }}</td>
                        <td class="py-6 font-black text-[#0A3A7A]">PKR {{ number_format($withdrawal->amount, 2) }}</td>
                        <td class="py-6 font-medium text-gray-500 uppercase text-xs tracking-widest">{{ str_replace('_', ' ', $withdrawal->payment_method) }}</td>
                        <td class="py-6">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-amber-100 text-amber-600 border-amber-200',
                                    'approved' => 'bg-blue-100 text-blue-600 border-blue-200',
                                    'paid' => 'bg-emerald-100 text-emerald-600 border-emerald-200',
                                    'rejected' => 'bg-red-100 text-red-600 border-red-200',
                                ];
                                $color = $statusColors[$withdrawal->status] ?? 'bg-gray-100 text-gray-600 border-gray-200';
                            @endphp
                            <span class="{{ $color }} px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border">
                                {{ $withdrawal->status }}
                            </span>
                        </td>
                        <td class="py-6 text-sm text-gray-400 ">{{ $withdrawal->admin_notes ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fa-solid fa-receipt text-gray-200 text-2xl"></i>
                            </div>
                            <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">No withdrawal history yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-8">
            {{ $withdrawals->links() }}
        </div>
    </div>
</div>
</x-app-layout>

