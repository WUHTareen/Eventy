<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center text-gray-600 transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight"><i class="fa-solid fa-ticket text-indigo-600 mr-2"></i>{{ __('Coupons') }}</h2>
                <p class="text-gray-500 text-sm mt-1">Create and manage discount codes for bookings.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            @php
                $fieldCls = 'w-full px-4 py-2.5 bg-white border border-gray-100 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-bold text-sm';
            @endphp

            <!-- ADD NEW -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ addOpen: false }">
                <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800"><i class="fa-solid fa-plus text-indigo-500 mr-2"></i>New Coupon</h3>
                        <p class="text-gray-500 text-sm">Platform-wide or vendor-specific discount code.</p>
                    </div>
                    <button type="button" @click="addOpen = !addOpen" class="bg-indigo-600 text-white px-4 py-2 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all">+ Add Coupon</button>
                </div>
                <form action="{{ route('admin.coupons.store') }}" method="POST" x-show="addOpen" x-cloak class="p-8 space-y-5 bg-indigo-50/30">
                    @csrf
                    @include('admin.coupons._fields', ['coupon' => null, 'vendors' => $vendors, 'fieldCls' => $fieldCls])
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl font-black text-xs uppercase tracking-widest">Create Coupon</button>
                </form>
            </div>

            <!-- LIST -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800"><i class="fa-solid fa-list text-gray-500 mr-2"></i>All Coupons ({{ $coupons->count() }})</h3>
                </div>

                @if($coupons->isEmpty())
                    <p class="text-sm text-gray-400 font-medium p-8 text-center">No coupons yet. Add one above.</p>
                @else
                    <div class="divide-y divide-gray-100">
                        @foreach($coupons as $coupon)
                            @php
                                $expired = $coupon->expires_at && $coupon->expires_at->isPast();
                                $exhausted = $coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit;
                                $statusLabel = !$coupon->is_active ? 'Inactive' : ($expired ? 'Expired' : ($exhausted ? 'Used Up' : 'Active'));
                                $statusCls = match(true) {
                                    !$coupon->is_active => 'bg-gray-100 text-gray-500',
                                    $expired || $exhausted => 'bg-red-50 text-red-600',
                                    default => 'bg-emerald-50 text-emerald-600',
                                };
                            @endphp
                            <div class="p-6" x-data="{ editOpen: false }">
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <div class="flex items-center gap-3">
                                        <span class="font-mono font-black text-gray-800 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100 tracking-wider">{{ $coupon->code }}</span>
                                        <span class="text-xs font-black uppercase tracking-wider px-2.5 py-1 rounded-full {{ $statusCls }}">{{ $statusLabel }}</span>
                                        <span class="text-sm font-bold text-gray-600">
                                            {{ $coupon->type === 'percent' ? $coupon->value . '% off' : 'PKR ' . number_format($coupon->value) . ' off' }}
                                        </span>
                                        @if($coupon->vendor)
                                            <span class="text-xs font-bold text-purple-600 bg-purple-50 px-2.5 py-1 rounded-full"><i class="fa-solid fa-store"></i> {{ $coupon->vendor->name }}</span>
                                        @else
                                            <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-full"><i class="fa-solid fa-globe"></i> Platform-wide</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button type="button" @click="editOpen = !editOpen" class="text-indigo-600 hover:text-indigo-800 text-xs font-black uppercase tracking-widest"><i class="fa-solid fa-pen"></i> Edit</button>
                                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('Delete this coupon?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-black uppercase tracking-widest"><i class="fa-solid fa-trash-can"></i> Delete</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-4 mt-3 text-xs font-bold text-gray-400">
                                    <span><i class="fa-solid fa-coins mr-1"></i> Min order: PKR {{ number_format($coupon->min_order_amount) }}</span>
                                    <span><i class="fa-solid fa-repeat mr-1"></i> Used: {{ $coupon->used_count }}{{ $coupon->usage_limit ? ' / ' . $coupon->usage_limit : ' (unlimited)' }}</span>
                                    <span><i class="fa-solid fa-calendar-xmark mr-1"></i> Expires: {{ $coupon->expires_at ? $coupon->expires_at->format('M j, Y') : 'Never' }}</span>
                                </div>

                                <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST" x-show="editOpen" x-cloak class="mt-5 p-5 bg-gray-50 rounded-2xl border border-gray-100 space-y-5">
                                    @csrf @method('PUT')
                                    @include('admin.coupons._fields', ['coupon' => $coupon, 'vendors' => $vendors, 'fieldCls' => $fieldCls])
                                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-xl font-black text-xs uppercase tracking-widest">Save Changes</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
