<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight  uppercase tracking-tighter">
            {{ __('Financial Oversight: Withdrawals') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-[2.5rem] border border-gray-100">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-10">
                        <h3 class="text-2xl font-black text-[#0A3A7A] tracking-tighter uppercase">Vendor <span class="text-[#ED1C24]">Payouts</span></h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b-2 border-gray-50 uppercase text-[10px] font-black text-gray-400 tracking-widest">
                                    <th class="px-6 py-4">Vendor</th>
                                    <th class="px-6 py-4">Amount</th>
                                    <th class="px-6 py-4">Method</th>
                                    <th class="px-6 py-4">Date</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($withdrawals as $withdrawal)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-6 font-bold text-[#0A3A7A]">
                                            {{ $withdrawal->user->name }}
                                            <p class="text-[10px] text-gray-400 lowercase font-medium">{{ $withdrawal->user->email }}</p>
                                        </td>
                                        <td class="px-6 py-6 font-black text-lg">PKR {{ number_format($withdrawal->amount, 2) }}</td>
                                        <td class="px-6 py-6">
                                            <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">{{ str_replace('_', ' ', $withdrawal->payment_method) }}</span>
                                        </td>
                                        <td class="px-6 py-6 text-sm text-gray-500">{{ $withdrawal->created_at->format('M d, H:i') }}</td>
                                        <td class="px-6 py-6">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-amber-100 text-amber-600',
                                                    'approved' => 'bg-blue-100 text-blue-600',
                                                    'paid' => 'bg-emerald-100 text-emerald-600',
                                                    'rejected' => 'bg-red-100 text-red-600',
                                                ];
                                                $color = $statusColors[$withdrawal->status] ?? 'bg-gray-100 text-gray-600';
                                            @endphp
                                            <span class="{{ $color }} px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest">
                                                {{ $withdrawal->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-6 text-right">
                                            <div class="flex justify-end gap-2" x-data="{ open: false }">
                                                <button @click="open = !open" class="bg-gray-900 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg hover:shadow-gray-900/40 transition-all active:scale-95">
                                                    Manage
                                                </button>

                                                <!-- Inline Management Modal (Simulated) -->
                                                <template x-if="open">
                                                    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
                                                        <div @click.away="open = false" class="bg-white rounded-[2rem] p-8 w-full max-w-lg shadow-2xl">
                                                            <h4 class="text-xl font-black text-[#0A3A7A] mb-6 uppercase">Update Withdrawal Status</h4>
                                                            <form action="{{ route('admin.withdrawals.update', $withdrawal) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="space-y-6">
                                                                    <div>
                                                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Target Status</label>
                                                                        <select name="status" class="w-full bg-gray-50 border-gray-100 rounded-2xl px-4 py-3 font-bold text-sm">
                                                                            <option value="pending" {{ $withdrawal->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                            <option value="approved" {{ $withdrawal->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                                            <option value="paid" {{ $withdrawal->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                                                            <option value="rejected" {{ $withdrawal->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                                        </select>
                                                                    </div>
                                                                    <div>
                                                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Admin Notes</label>
                                                                        <textarea name="admin_notes" class="w-full bg-gray-50 border-gray-100 rounded-2xl px-4 py-3 font-medium text-sm" rows="3" placeholder="Reference ID, payment proof link, or reason for rejection...">{{ $withdrawal->admin_notes }}</textarea>
                                                                    </div>
                                                                    <div class="flex gap-4">
                                                                        <button type="submit" class="flex-1 bg-[#0A3A7A] text-white py-4 rounded-2xl font-black uppercase tracking-widest shadow-xl">Update</button>
                                                                        <button type="button" @click="open = false" class="flex-1 bg-gray-100 text-gray-600 py-4 rounded-2xl font-black uppercase tracking-widest">Cancel</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-20 text-center font-bold text-gray-400 uppercase tracking-widest text-xs ">
                                            No withdrawal requests in protocol.
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
        </div>
    </div>
</x-app-layout>

