<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50/50 to-white flex justify-between items-center">
        <div>
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-solid fa-users text-[#0A3A7A]"></i> Recent Clients
            </h3>
            <p class="text-gray-500 text-sm mt-1">Latest registered customers</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1 transition-colors">
            View All <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-50/50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                    <th class="px-8 py-5">Client</th>
                    <th class="px-6 py-5">Joined</th>
                    <th class="px-8 py-5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($recentClients as $client)
                    <tr class="hover:bg-indigo-50/30 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mr-4">
                                    {{ substr($client->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900">{{ $client->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $client->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-500">
                            {{ $client->created_at->diffForHumans() }}
                        </td>
                        <td class="px-8 py-5 text-right">
                            <button class="w-9 h-9 bg-gray-50 hover:bg-white text-gray-400 hover:text-indigo-600 rounded-lg flex items-center justify-center transition-all shadow-sm border border-transparent hover:border-indigo-100">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-8 py-10 text-center text-gray-400">No recent clients found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

