<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800"><i class="fa-solid fa-users text-[#0A3A7A] mr-2"></i> User Management</h2>
                <p class="text-gray-500 text-sm mt-1">Manage all clients, vendors and admins</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.users.create') }}" class="bg-[#0A3A7A] text-white font-bold py-2.5 px-6 rounded-xl shadow hover:bg-[#0D4E9A] transition flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Add User
                </a>
                <a href="{{ route('admin.dashboard') }}" class="bg-white border border-gray-200 text-gray-700 font-bold py-2.5 px-5 rounded-xl shadow-sm hover:bg-gray-50 transition flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 font-medium">✓ {{ session('success') }}</div>
            @endif

            {{-- Filters --}}
            <form method="GET" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6 flex flex-wrap gap-3 items-end">
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or Email..." class="border border-gray-200 rounded-xl px-4 py-2 text-sm w-52 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1">Role</label>
                    <select name="role" class="border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">All Roles</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Client</option>
                        <option value="vendor" {{ request('role') == 'vendor' ? 'selected' : '' }}>Vendor</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1">Status</label>
                    <select name="status" class="border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">All</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>Banned</option>
                    </select>
                </div>
                <button type="submit" class="bg-[#0A3A7A] text-white px-5 py-2 rounded-xl font-bold text-sm hover:bg-[#0D4E9A] transition">
                    <i class="fa-solid fa-search mr-1"></i> Filter
                </button>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-100 text-gray-600 px-5 py-2 rounded-xl font-bold text-sm hover:bg-gray-200 transition">Reset</a>
            </form>

            {{-- Users Table --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800">All Users <span class="text-gray-400 font-normal text-sm">({{ $users->total() }} total)</span></h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 text-left">#</th>
                                <th class="px-6 py-4 text-left">User</th>
                                <th class="px-6 py-4 text-left">Email</th>
                                <th class="px-6 py-4 text-left">Role</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <th class="px-6 py-4 text-left">Joined</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($users as $i => $user)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-400">{{ $users->firstItem() + $i }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $user->getAvatarUrl() }}" class="w-10 h-10 rounded-full object-cover border border-gray-100">
                                        <span class="font-semibold text-gray-800 text-sm">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    @if($user->role === 'vendor')
                                        <span class="px-3 py-1 bg-cyan-50 text-cyan-700 rounded-full text-xs font-bold">Vendor</span>
                                    @elseif($user->role === 'admin')
                                        <span class="px-3 py-1 bg-purple-50 text-purple-700 rounded-full text-xs font-bold">Admin</span>
                                    @else
                                        <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-bold">Client</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->is_banned ?? false)
                                        <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-xs font-bold">Banned</span>
                                    @elseif($user->role === 'vendor' && !$user->is_verified)
                                        <span class="px-3 py-1 bg-yellow-50 text-yellow-600 rounded-full text-xs font-bold">Pending</span>
                                    @else
                                        <span class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-xs font-bold">Active</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.users.show', $user) }}" class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                            <i class="fa-solid fa-eye"></i> View
                                        </a>
                                        @if($user->role === 'vendor' && !$user->is_verified)
                                        <form action="{{ route('admin.users.verify', $user) }}" method="POST" class="inline">
                                            @csrf @method('PUT')
                                            <button class="bg-green-50 text-green-600 hover:bg-green-100 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                                <i class="fa-solid fa-check"></i> Verify
                                            </button>
                                        </form>
                                        @endif
                                        <form action="{{ route('admin.users.ban', $user) }}" method="POST" class="inline">
                                            @csrf @method('PUT')
                                            <button class="{{ ($user->is_banned ?? false) ? 'bg-green-50 text-green-600 hover:bg-green-100' : 'bg-red-50 text-red-600 hover:bg-red-100' }} px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                                <i class="fa-solid {{ ($user->is_banned ?? false) ? 'fa-unlock' : 'fa-ban' }}"></i>
                                                {{ ($user->is_banned ?? false) ? 'Unban' : 'Ban' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user permanently?')">
                                            @csrf @method('DELETE')
                                            <button class="bg-gray-50 text-gray-500 hover:bg-red-50 hover:text-red-600 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-400">No users found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-5 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
