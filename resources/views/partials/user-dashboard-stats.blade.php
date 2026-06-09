<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Bookings -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 group hover:shadow-xl hover:border-primary-200 transition-all duration-300 relative overflow-hidden">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-primary-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
        <div class="relative flex items-center">
            <div class="w-16 h-16 bg-gradient-to-br from-[#0A3A7A] to-[#0D4E9A] rounded-2xl flex items-center justify-center mr-5 shadow-lg shadow-primary-500/30 transform group-hover:scale-110 group-hover:rotate-3 transition-all">
                <i class="fa-solid fa-calendar-check text-white text-2xl"></i>
            </div>
            <div>
                <p class="text-4xl font-bold text-gray-800">{{ Auth::user()->bookings()->count() }}</p>
                <p class="text-gray-500 text-sm font-medium">Total Bookings</p>
            </div>
        </div>
    </div>
    
    <!-- Pending -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 group hover:shadow-xl hover:border-yellow-200 transition-all duration-300 relative overflow-hidden">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-yellow-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
        <div class="relative flex items-center">
            <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center mr-5 shadow-lg shadow-yellow-500/30 transform group-hover:scale-110 group-hover:rotate-3 transition-all">
                <i class="fa-solid fa-clock text-white text-2xl"></i>
            </div>
            <div>
                <p class="text-4xl font-bold text-gray-800">{{ Auth::user()->bookings()->where('status', 'pending')->count() }}</p>
                <p class="text-gray-500 text-sm font-medium">Pending</p>
            </div>
        </div>
    </div>
    
    <!-- Completed -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 group hover:shadow-xl hover:border-green-200 transition-all duration-300 relative overflow-hidden">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
        <div class="relative flex items-center">
            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mr-5 shadow-lg shadow-green-500/30 transform group-hover:scale-110 group-hover:rotate-3 transition-all">
                <i class="fa-solid fa-circle-check text-white text-2xl"></i>
            </div>
            <div>
                <p class="text-4xl font-bold text-gray-800">{{ Auth::user()->bookings()->where('status', 'completed')->count() }}</p>
                <p class="text-gray-500 text-sm font-medium">Completed</p>
            </div>
        </div>
    </div>
</div>


