<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50/50 to-white flex justify-between items-center">
        <div>
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-solid fa-store text-indigo-600"></i> Pending Verifications
            </h3>
            <p class="text-gray-500 text-sm mt-1">Vendors awaiting approval</p>
        </div>
        <a href="{{ route('admin.vendors.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 transition-colors">
            Manage All <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-50/50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                    <th class="px-8 py-5">Vendor</th>
                    <th class="px-6 py-5">Specialization</th>
                    <th class="px-8 py-5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pendingVendors as $vendor)
                    <tr class="hover:bg-yellow-50/30 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-xl bg-indigo-900 flex items-center justify-center text-white font-bold mr-4">
                                    {{ substr($vendor->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900">{{ $vendor->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $vendor->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-indigo-50 text-indigo-700">
                                {{ $vendor->vendor_type ?? 'General' }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('admin.vendors.verify', $vendor->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-xs font-bold shadow-sm transition-all flex items-center gap-2">
                                        <i class="fa-solid fa-check"></i> Verify
                                    </button>
                                </form>
                                <a href="{{ route('admin.vendors.show', $vendor->id) }}" class="w-9 h-9 bg-gray-50 hover:bg-white text-gray-400 hover:text-gray-600 rounded-lg flex items-center justify-center transition-all shadow-sm border border-transparent hover:border-gray-100">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-8 py-10 text-center text-gray-400">No pending verifications found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

