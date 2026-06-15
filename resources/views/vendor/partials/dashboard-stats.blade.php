<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Services -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 group hover:shadow-xl hover:border-primary-200 transition-all duration-300 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-primary-50 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="relative flex items-center">
            <div class="w-14 h-14 bg-gradient-to-br from-[#0A3A7A] to-[#0D4E9A] rounded-xl flex items-center justify-center mr-4 shadow-lg shadow-primary-500/30">
                <i class="fa-solid fa-boxes-stacked text-white text-xl"></i>
            </div>
            <div>
                <p class="text-3xl font-bold text-gray-800">{{ $services->count() }}</p>
                <p class="text-gray-500 text-sm font-medium">Total Services</p>
            </div>
        </div>
    </div>
    
    <!-- Active Orders -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 group hover:shadow-xl hover:border-blue-200 transition-all duration-300 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-blue-50 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="relative flex items-center">
            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center mr-4 shadow-lg shadow-blue-500/30">
                <i class="fa-solid fa-clock text-white text-xl"></i>
            </div>
            <div>
                <p class="text-3xl font-bold text-gray-800">{{ Auth::user()->receivedBookings()->where('status', 'pending')->count() }}</p>
                <p class="text-gray-500 text-sm font-medium">Pending Orders</p>
            </div>
        </div>
    </div>

    <!-- Confirmed Orders -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 group hover:shadow-xl hover:border-green-200 transition-all duration-300 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-green-50 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="relative flex items-center">
            <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mr-4 shadow-lg shadow-green-500/30">
                <i class="fa-solid fa-check-double text-white text-xl"></i>
            </div>
            <div>
                <p class="text-3xl font-bold text-gray-800">{{ Auth::user()->receivedBookings()->where('status', 'confirmed')->count() }}</p>
                <p class="text-gray-500 text-sm font-medium">Confirmed</p>
            </div>
        </div>
    </div>

    <!-- Completed Orders -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 group hover:shadow-xl hover:border-secondary-200 transition-all duration-300 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-secondary-50 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="relative flex items-center">
            <div class="w-14 h-14 bg-gradient-to-br from-[#ED1C24] to-[#b2151b] rounded-xl flex items-center justify-center mr-4 shadow-lg shadow-secondary-500/30">
                <i class="fa-solid fa-trophy text-white text-xl"></i>
            </div>
            <div>
                <p class="text-3xl font-bold text-gray-800">{{ Auth::user()->receivedBookings()->where('status', 'completed')->count() }}</p>
                <p class="text-gray-500 text-sm font-medium">Completed</p>
            </div>
        </div>
    </div>
</div>


