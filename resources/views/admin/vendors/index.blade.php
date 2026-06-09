<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    <i class="fa-solid fa-store text-indigo-600 mr-2"></i>{{ __('Vendor Management') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Review and verify professional service providers</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.dashboard') }}" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold py-2.5 px-5 rounded-xl shadow-sm transition-all flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-100 bg-gradient-to-r from-gray-50/50 to-white flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Professional Network</h3>
                        <p class="text-gray-500 text-sm mt-1">{{ $vendors->total() }} total vendors onboarded</p>
                    </div>
                    <div class="flex gap-4">
                        <select class="bg-gray-50 border-gray-100 rounded-xl text-sm font-bold text-gray-600 focus:ring-primary-500 focus:border-primary-500 py-2.5 px-4">
                            <option>All Specializations</option>
                            <option>Pending Only</option>
                            <option>Verified Only</option>
                        </select>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50/50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                <th class="px-8 py-5">Corporate Identity</th>
                                <th class="px-6 py-5">Specialization</th>
                                <th class="px-6 py-5 text-center">Protocol Status</th>
                                <th class="px-8 py-5 text-right">Strategic Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($vendors as $vendor)
                                <tr class="hover:bg-indigo-50/30 transition-colors group">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center">
                                            <div class="relative">
                                                <div class="w-12 h-12 rounded-2xl bg-indigo-900 flex items-center justify-center text-white font-black text-xl shadow-lg border-2 border-white transform group-hover:scale-110 transition-transform">
                                                    {{ substr($vendor->name, 0, 1) }}
                                                </div>
                                                @if($vendor->is_verified)
                                                    <div class="absolute -top-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                                                        <i class="fa-solid fa-check text-[10px] text-white"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-black text-slate-900 group-hover:text-indigo-600 transition-colors uppercase tracking-tight">{{ $vendor->name }}</div>
                                                <div class="text-xs text-slate-400 font-medium">{{ $vendor->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-black bg-indigo-50 text-indigo-700 border border-indigo-100 uppercase tracking-wider">
                                            {{ $vendor->vendor_type ?? 'Unspecified' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        @if($vendor->is_verified)
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-widest">
                                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2"></span> Verified
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-4 py-2 rounded-full text-[10px] font-black bg-amber-50 text-amber-700 border border-amber-100 uppercase tracking-widest animate-pulse">
                                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-2"></span> Evaluation
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            @if(!$vendor->is_verified)
                                                <form method="POST" action="{{ route('admin.vendors.verify', $vendor->id) }}">
                                                    @csrf
                                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-black py-2 px-6 rounded-xl text-[10px] uppercase tracking-widest shadow-lg shadow-indigo-500/20 transition-all transform hover:-translate-y-0.5">
                                                        Approve Protocol
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('vendors.show', $vendor) }}" target="_blank" class="w-10 h-10 bg-white border border-gray-100 text-indigo-600 rounded-xl flex items-center justify-center hover:bg-slate-50 transition-all shadow-sm" title="View Portfolio">
                                                <i class="fa-solid fa-external-link"></i>
                                            </a>
                                            <a href="{{ route('admin.vendors.show', $vendor->id) }}" class="w-10 h-10 bg-white border border-gray-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all shadow-sm" title="Internal View">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.vendors.destroy', $vendor->id) }}" method="POST" onsubmit="return confirm('CRITICAL: Purge this vendor and all associated services?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-10 h-10 bg-white border border-gray-100 text-red-400 rounded-xl flex items-center justify-center hover:bg-red-500 hover:text-white hover:border-red-500 transition-all shadow-sm">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($vendors->hasPages())
                    <div class="p-8 border-t border-gray-50 bg-gray-50/30">
                        {{ $vendors->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

