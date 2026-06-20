<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800"><i class="fa-solid fa-user-pen text-[#0A3A7A] mr-2"></i> User Detail</h2>
                <p class="text-gray-500 text-sm mt-1">{{ $user->name }} — {{ ucfirst($user->role) }}</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="bg-white border border-gray-200 text-gray-700 font-bold py-2.5 px-5 rounded-xl shadow-sm hover:bg-gray-50 transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 font-medium">✓ {{ session('success') }}</div>
            @endif

            {{-- User Info Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-5 mb-6">
                    <img src="{{ $user->getAvatarUrl() }}" class="w-20 h-20 rounded-2xl object-cover border border-gray-200">
                    <div>
                        <h3 class="font-bold text-xl text-gray-800">{{ $user->name }}</h3>
                        <p class="text-gray-500">{{ $user->email }}</p>
                        <div class="flex gap-2 mt-2">
                            <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-bold">{{ ucfirst($user->role) }}</span>
                            @if($user->is_banned ?? false)
                                <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-xs font-bold">Banned</span>
                            @elseif($user->role === 'vendor' && !$user->is_verified)
                                <span class="px-3 py-1 bg-yellow-50 text-yellow-600 rounded-full text-xs font-bold">Pending Verification</span>
                            @else
                                <span class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-xs font-bold">Active</span>
                            @endif
                        </div>
                    </div>
                    <div class="ml-auto flex gap-3">
                        {{-- Ban/Unban --}}
                        <form action="{{ route('admin.users.ban', $user) }}" method="POST">
                            @csrf @method('PUT')
                            <button class="{{ ($user->is_banned ?? false) ? 'bg-green-600 hover:bg-green-700' : 'bg-red-500 hover:bg-red-600' }} text-white px-5 py-2 rounded-xl font-bold text-sm transition">
                                <i class="fa-solid {{ ($user->is_banned ?? false) ? 'fa-unlock' : 'fa-ban' }} mr-1"></i>
                                {{ ($user->is_banned ?? false) ? 'Unban User' : 'Ban User' }}
                            </button>
                        </form>
                        @if($user->role === 'vendor' && !$user->is_verified)
                        <form action="{{ route('admin.users.verify', $user) }}" method="POST">
                            @csrf @method('PUT')
                            <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl font-bold text-sm transition">
                                <i class="fa-solid fa-check mr-1"></i> Verify Vendor
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                {{-- Edit Form --}}
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf @method('PUT')
                    <h4 class="font-bold text-gray-700 mb-4 border-b pb-2">Edit User Details</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Full Name</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">Role</label>
                            <select name="role" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Client</option>
                                <option value="vendor" {{ $user->role === 'vendor' ? 'selected' : '' }}>Vendor</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-1">City</label>
                            <select name="city_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="">-- Select City --</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ $user->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-600 mb-1">New Password <span class="text-gray-400 font-normal">(leave empty to keep current)</span></label>
                            <input type="password" name="password" placeholder="••••••••" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>
                    <div class="mt-4 flex gap-3">
                        <button type="submit" class="bg-[#0A3A7A] text-white px-6 py-2.5 rounded-xl font-bold hover:bg-[#0D4E9A] transition">
                            <i class="fa-solid fa-save mr-1"></i> Save Changes
                        </button>
                    </div>
                </form>

                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Move this user to trash? Their services and bookings will be transferred if a target is selected.')" class="mt-3 flex items-end gap-3">
                    @csrf @method('DELETE')
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Transfer data to <span class="text-gray-400 font-normal">(optional)</span></label>
                        <select name="transfer_to" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">-- Don't transfer --</option>
                            @foreach($transferTargets as $target)
                                <option value="{{ $target->id }}">{{ $target->name }} ({{ ucfirst($target->role) }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-100 px-6 py-2.5 rounded-xl font-bold transition">
                        <i class="fa-solid fa-trash mr-1"></i> Delete User
                    </button>
                </form>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
                    <p class="text-3xl font-black text-[#0A3A7A]">{{ $user->bookings->count() }}</p>
                    <p class="text-sm text-gray-500 mt-1">Total Bookings</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
                    <p class="text-3xl font-black text-green-600">Rs. {{ number_format($user->balance ?? 0) }}</p>
                    <p class="text-sm text-gray-500 mt-1">Wallet Balance</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
                    <p class="text-3xl font-black text-amber-500">{{ $user->reviews->count() }}</p>
                    <p class="text-sm text-gray-500 mt-1">Reviews Given</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
