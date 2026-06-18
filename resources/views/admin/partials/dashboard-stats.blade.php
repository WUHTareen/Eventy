            <!-- Compact Stats Strip -->
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3 mb-8">
                <!-- Platform Revenue -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 flex items-center gap-3">
                    <div class="w-9 h-9 shrink-0 bg-gradient-to-br from-indigo-600 to-blue-700 rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-money-bill-trend-up text-white text-xs"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-lg font-black text-gray-800 leading-tight truncate">PKR {{ number_format($totalPlatformRevenue ?? 0) }}</p>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wide truncate">Revenue</p>
                    </div>
                </div>

                <!-- Admin Commission -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 flex items-center gap-3">
                    <div class="w-9 h-9 shrink-0 bg-gradient-to-br from-emerald-500 to-teal-700 rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-chart-line text-white text-xs"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-lg font-black text-emerald-600 leading-tight truncate">PKR {{ number_format($totalCommissionEarned ?? 0) }}</p>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wide truncate">Commission</p>
                    </div>
                </div>

                <!-- Budget Requests -->
                <a href="{{ route('admin.budget-requests') }}" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 flex items-center gap-3">
                    <div class="w-9 h-9 shrink-0 bg-gradient-to-br from-primary-500 to-indigo-700 rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-calculator text-white text-xs"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-lg font-black text-gray-800 leading-tight">{{ $totalBudgetRequests ?? 0 }}</p>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wide truncate">Budget Reqs</p>
                    </div>
                </a>

                <!-- Desk Requests -->
                <a href="{{ route('admin.service-desk.index') }}" class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 flex items-center gap-3">
                    <div class="w-9 h-9 shrink-0 bg-gradient-to-br from-[#ED1C24] to-[#0A3A7A] rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-headset text-white text-xs"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-lg font-black text-gray-800 leading-tight">{{ $serviceDeskPendingCount ?? 0 }}</p>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wide truncate">Desk Reqs</p>
                    </div>
                </a>

                <!-- Total Users -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 flex items-center gap-3">
                    <div class="w-9 h-9 shrink-0 bg-gradient-to-br from-[#0A3A7A] to-blue-900 rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-users text-white text-xs"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-lg font-black text-gray-800 leading-tight">{{ $users->count() }}</p>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wide truncate">Users</p>
                    </div>
                </div>

                <!-- Total Vendors -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 flex items-center gap-3">
                    <div class="w-9 h-9 shrink-0 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-store text-white text-xs"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-lg font-black text-gray-800 leading-tight">{{ $users->where('role', 'vendor')->count() }}</p>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wide truncate">Vendors</p>
                    </div>
                </div>

                <!-- Pending Audit -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 flex items-center gap-3">
                    <div class="w-9 h-9 shrink-0 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-clock text-white text-xs"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-lg font-black text-gray-800 leading-tight">{{ $users->where('role', 'vendor')->where('is_verified', false)->count() }}</p>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wide truncate">Pending</p>
                    </div>
                </div>

                <!-- Verified Vendors -->
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 flex items-center gap-3">
                    <div class="w-9 h-9 shrink-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-user-check text-white text-xs"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-lg font-black text-gray-800 leading-tight">{{ $users->where('role', 'vendor')->where('is_verified', true)->count() }}</p>
                        <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wide truncate">Verified</p>
                    </div>
                </div>
            </div>
