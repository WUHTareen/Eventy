<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight">
            {{ __('Corporate Command Center') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl mb-8 border border-slate-100">
                <div class="p-8 text-slate-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-black mb-2">Welcome back, {{ $user->name }}</h3>
                            <p class="text-slate-500 font-medium">Enterprise Access Level: <span class="text-indigo-600 font-bold uppercase tracking-wider">Gold</span></p>
                        </div>
                        <div class="bg-slate-100 p-4 rounded-2xl">
                            <i class="fa-solid fa-building-columns text-3xl text-slate-400"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 p-6 flex items-center relative group hover:shadow-lg transition-all">
                    <div class="bg-blue-50 w-12 h-12 rounded-xl flex items-center justify-center text-blue-600 mr-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-400 uppercase tracking-wider">Total Spend</div>
                        <div class="text-2xl font-black text-slate-900">PKR {{ number_format($stats['total_spent']) }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 p-6 flex items-center relative group hover:shadow-lg transition-all">
                    <div class="bg-green-50 w-12 h-12 rounded-xl flex items-center justify-center text-green-600 mr-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-box-open text-xl"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-400 uppercase tracking-wider">Active Orders</div>
                        <div class="text-2xl font-black text-slate-900">{{ $stats['active_orders'] }}</div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 p-6 flex items-center relative group hover:shadow-lg transition-all">
                    <div class="bg-purple-50 w-12 h-12 rounded-xl flex items-center justify-center text-purple-600 mr-4 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-handshake text-xl"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-400 uppercase tracking-wider">Total Deals</div>
                        <div class="text-2xl font-black text-slate-900">{{ $stats['total_orders'] }}</div>
                    </div>
                </div>
            </div>

            <!-- Operations Ledger -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-slate-100">
                <div class="p-6 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
                    <div>
                        <h3 class="font-black text-lg text-slate-800 uppercase tracking-tighter">Strategic Operations Ledger</h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Real-time Asset Control & Compliance</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 bg-green-50 text-green-600 text-[10px] font-black rounded-full uppercase tracking-widest">
                            <i class="fa-solid fa-circle-check mr-1"></i> Live Feedback
                        </span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Transaction ID</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Asset Profile</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Operational Status</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Compliance Specs</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Financial Value</th>
                                <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Timeline</th>
                                <th class="px-6 py-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($bookings as $booking)
                            <tr class="hover:bg-slate-50/80 transition-all group">
                                <td class="px-6 py-4">
                                    <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest">#OPS-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-slate-100 flex-shrink-0 relative overflow-hidden">
                                            @if($booking->service && $booking->service->getFeaturedImage())
                                                <img src="{{ $booking->service->getFeaturedImage() }}" class="w-full h-full object-cover">
                                            @else
                                                <i class="fa-solid fa-cube text-slate-300 absolute inset-0 flex items-center justify-center"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-[13px] font-black text-[#0A192F] line-clamp-1 capitalize">{{ $booking->service ? $booking->service->name : 'N/A' }}</p>
                                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $booking->service && $booking->service->category ? $booking->service->category->name : 'General' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusConfig = [
                                            'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-600', 'icon' => 'fa-clock'],
                                            'confirmed' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-600', 'icon' => 'fa-check'],
                                            'in_progress' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600', 'icon' => 'fa-spinner fa-spin'],
                                            'completed' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'icon' => 'fa-circle-check'],
                                            'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-600', 'icon' => 'fa-xmark'],
                                        ];
                                        $cfg = $statusConfig[strtolower($booking->status)] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'icon' => 'fa-info-circle'];
                                    @endphp
                                    <span class="px-3 py-1 {{ $cfg['bg'] }} {{ $cfg['text'] }} text-[9px] font-black rounded-full uppercase tracking-[0.1em] flex items-center w-fit gap-1.5">
                                        <i class="fa-solid {{ $cfg['icon'] }}"></i>
                                        {{ $booking->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-sitemap text-[#ED1C24] text-[8px]"></i>
                                            <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest">{{ $booking->department ?? 'N/A' }}</span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-id-card-clip text-blue-600 text-[8px]"></i>
                                            <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest">{{ $booking->cost_center ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-[13px] font-black text-[#0A192F]">PKR {{ number_format($booking->total_price) }}</p>
                                        <p class="text-[9px] font-bold {{ $booking->payout_status == 'Paid' ? 'text-green-500' : 'text-amber-500' }} uppercase tracking-widest">{{ $booking->payout_status ?: 'Payment Pending' }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-1.5 text-slate-500">
                                            <i class="fa-solid fa-calendar text-[9px]"></i>
                                            <span class="text-[10px] font-bold">{{ $booking->booking_date ? $booking->booking_date->format('M d, Y') : 'N/A' }}</span>
                                        </div>
                                        <div class="flex items-center gap-1.5 text-slate-300">
                                            <i class="fa-solid fa-location-dot text-[9px] text-[#ED1C24]/50"></i>
                                            <span class="text-[10px] font-bold truncate max-w-[100px]">{{ $booking->service ? $booking->service->location : 'N/A' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 hover:bg-[#ED1C24] hover:text-white transition-all">
                                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="p-20 text-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                        <i class="fa-solid fa-magnifying-glass text-3xl text-slate-200"></i>
                                    </div>
                                    <h4 class="text-xl font-black text-slate-800 mb-2">No Operations Found</h4>
                                    <p class="text-slate-400 font-medium max-w-sm mx-auto">"There are no assets currently synced with your selected mission parameters."</p>
                                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mt-8 px-6 py-3 bg-[#0A192F] text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#ED1C24] transition-all">
                                        <i class="fa-solid fa-plus"></i> Initiate New Mission
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($bookings->hasPages())
                <div class="p-6 border-t border-slate-50 bg-slate-50/30">
                    {{ $bookings->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

