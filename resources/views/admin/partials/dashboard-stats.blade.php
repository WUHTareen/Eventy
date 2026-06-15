                <!-- Platform Revenue Card -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-gradient-to-br from-indigo-100 to-blue-100 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-blue-700 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/30">
                                <i class="fa-solid fa-money-bill-trend-up text-white"></i>
                            </div>
                            <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full uppercase tracking-wider ">Gross Flux</span>
                        </div>
                        <p class="text-3xl font-black text-gray-800 tracking-tighter">
                            PKR {{ number_format($totalPlatformRevenue ?? 0) }}
                        </p>
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-[0.2em] mt-2">Platform Throughput</p>
                    </div>
                </div>

                <!-- Admin Commission Card -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-gradient-to-br from-emerald-100 to-green-100 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-700 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/30">
                                <i class="fa-solid fa-chart-line text-white"></i>
                            </div>
                            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full uppercase tracking-wider ">Elite Yield</span>
                        </div>
                        <p class="text-3xl font-black text-emerald-600 tracking-tighter">
                            PKR {{ number_format($totalCommissionEarned ?? 0) }}
                        </p>
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-[0.2em] mt-2">Net Platform Surplus</p>
                    </div>
                </div>

                <!-- Strategic Budget Requests -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-indigo-700 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                                <i class="fa-solid fa-calculator text-white"></i>
                            </div>
                            <span class="text-xs font-bold text-primary-500 bg-blue-50 px-2 py-1 rounded-full ">Projections</span>
                        </div>
                        <p class="text-3xl font-black text-gray-800 tracking-tighter">{{ $totalBudgetRequests ?? 0 }}</p>
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-[0.2em] mt-2">Active Inquiries</p>
                        <a href="{{ route('admin.budget-requests') }}" class="mt-4 block text-[9px] text-primary-500 font-black uppercase tracking-widest hover:text-indigo-600 transition-colors">Analyze Manifests <i class="fa-solid fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>


            <!-- Main Admin Grid -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
                <!-- Desk Requests -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-gradient-to-br from-[#ED1C24]/10 to-[#0A3A7A]/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#ED1C24] to-[#0A3A7A] rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30">
                                <i class="fa-solid fa-headset text-white"></i>
                            </div>
                            <span class="text-xs font-bold text-[#ED1C24] bg-red-50 px-2 py-1 rounded-full uppercase tracking-wider">Desks</span>
                        </div>
                        <p class="text-3xl font-bold text-gray-800">
                            {{ $serviceDeskPendingCount ?? 0 }}
                        </p>
                        <p class="text-gray-500 text-sm font-medium">Pending Desk Requests</p>
                        <a href="{{ route('admin.service-desk.index') }}" class="mt-2 inline-block text-xs text-[#ED1C24] font-bold hover:underline">Manage Service Desk</a>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-gradient-to-br from-[#0A3A7A]/10 to-[#0A3A7A]/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#0A3A7A] to-blue-900 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30">
                                <i class="fa-solid fa-users text-white"></i>
                            </div>
                            <span class="text-xs font-bold text-[#0A3A7A] bg-blue-50 px-2 py-1 rounded-full">All Time</span>
                        </div>
                        <p class="text-3xl font-bold text-gray-800">{{ $users->count() }}</p>
                        <p class="text-gray-500 text-sm font-medium">Total Users</p>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                                <i class="fa-solid fa-store text-white"></i>
                            </div>
                            <span class="text-xs font-bold text-primary-500 bg-blue-50 px-2 py-1 rounded-full tracking-wider uppercase text-[10px]">Active</span>
                        </div>
                        <p class="text-3xl font-bold text-gray-800">{{ $users->where('role', 'vendor')->count() }}</p>
                        <p class="text-gray-500 text-sm font-medium">Total Vendors</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-gradient-to-br from-yellow-100 to-orange-100 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg shadow-yellow-500/30">
                                <i class="fa-solid fa-clock text-white"></i>
                            </div>
                            <span class="text-xs font-bold text-yellow-700 bg-yellow-50 px-2 py-1 rounded-full tracking-wider uppercase text-[10px]">Verification</span>
                        </div>
                        <p class="text-3xl font-bold text-gray-800">{{ $users->where('role', 'vendor')->where('is_verified', false)->count() }}</p>
                        <p class="text-gray-500 text-sm font-medium">Pending Audit</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-green-500/30">
                                <i class="fa-solid fa-user-check text-white"></i>
                            </div>
                            <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full tracking-wider uppercase text-[10px]">Verified</span>
                        </div>
                        <p class="text-3xl font-bold text-gray-800">{{ $users->where('role', 'vendor')->where('is_verified', true)->count() }}</p>
                        <p class="text-gray-500 text-sm font-medium">Elite Partners</p>
                    </div>
                </div>
            </div>


