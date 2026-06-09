<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Vendor Dashboard') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Welcome back, {{ Auth::user()->name }}! Here's your business overview.</p>
            </div>
            <div class="flex gap-3">
                @if(Auth::user()->is_verified)
                    <a href="{{ route('vendor.orders') }}" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold py-2.5 px-5 rounded-xl shadow-sm transition-all flex items-center gap-2 hover:shadow-md">
                        <i class="fa-solid fa-clipboard-list text-primary-500"></i> Manage Orders
                    </a>
                    <a href="{{ route('vendor.custom-orders') }}" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold py-2.5 px-5 rounded-xl shadow-sm transition-all flex items-center gap-2 hover:shadow-md">
                        <i class="fa-solid fa-puzzle-piece text-indigo-500"></i> Ensemble Requests
                    </a>
                    <a href="{{ route('vendors.show', Auth::user()) }}" target="_blank" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold py-2.5 px-5 rounded-xl shadow-sm transition-all flex items-center gap-2 hover:shadow-md">
                        <i class="fa-solid fa-external-link text-indigo-500"></i> View Portfolio
                    </a>
                    <a href="{{ route('vendor.create-service') }}" class="bg-gradient-to-r from-[#0A3A7A] to-[#0D4E9A] hover:shadow-primary-500/30 text-white font-bold py-2.5 px-5 rounded-xl shadow-lg transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-plus"></i> Add Service
                    </a>
                @else
                    <div class="flex items-center gap-2 bg-yellow-50 text-yellow-700 px-4 py-2 rounded-xl border border-yellow-200">
                        <i class="fa-solid fa-clock"></i>
                        <span class="font-medium text-sm">Verification Pending</span>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(!Auth::user()->is_verified)
                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 p-6 mb-8 rounded-2xl shadow-sm animate-pulse">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fa-solid fa-hourglass-half text-yellow-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-yellow-800 text-lg">Account Verification Pending</h4>
                            <p class="text-yellow-700 mt-1">Your account is currently under review by an administrator. You'll receive full access once verified.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Stats Grid with Enhanced Polling -->
            <div x-data="{
                refreshStats() {
                    fetch('{{ route('vendor.dashboard') }}', {
                        headers: { 'X-Partial': 'vendor-stats', 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(response => response.text())
                    .then(html => {
                        $refs.statsContainer.innerHTML = html;
                    });
                },
                init() {
                    setInterval(() => this.refreshStats(), 5000);
                }
            }" x-init="init()">
                <div x-ref="statsContainer">
                    @include('vendor.partials.dashboard-stats')
                </div>
            </div>

            <!-- Services Section -->
            <div class="grid lg:grid-cols-3 gap-8 mb-8">
                <!-- Revenue Chart -->
                <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Performance Analytics</h3>
                            <p class="text-xs text-gray-500">6-month revenue & growth trend</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-indigo-500"></span>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Revenue (PKR)</span>
                        </div>
                    </div>
                    <div class="h-[300px] w-full">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- Booking Mix -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Booking Volume</h3>
                            <p class="text-xs text-gray-500">Monthly reservation counts</p>
                        </div>
                    </div>
                    <div class="h-[300px] w-full">
                        <canvas id="bookingsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50/50 to-white flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-sparkles text-primary-500"></i> My Services
                        </h3>
                        <p class="text-gray-500 text-sm mt-1">Manage and track your listed services</p>
                    </div>
                    <span class="bg-primary-50 text-primary-700 px-4 py-2 rounded-full text-sm font-bold">{{ $services->count() }} {{ Str::plural('Service', $services->count()) }}</span>
                </div>

                @if($services->isEmpty())
                    <div class="p-16 text-center">
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-primary-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                            <i class="fa-solid fa-box-open text-primary-500 text-4xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-800 mb-2">No Services Yet</h4>
                        <p class="text-gray-500 mb-6 max-w-md mx-auto">Start by adding your first service to showcase your skills to potential customers.</p>
                        @if(Auth::user()->is_verified)
                            <a href="{{ route('vendor.create-service') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-600 to-primary-800 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-primary-500/30 transition-all transform hover:-translate-y-0.5">
                                <i class="fa-solid fa-plus"></i> Create Your First Service
                            </a>
                        @endif
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                        @foreach($services as $service)
                            <div class="group bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-2xl hover:border-indigo-200 transition-all duration-500 transform hover:-translate-y-1">
                                <div class="h-40 overflow-hidden relative">
                                    @php $featuredImage = $service->getFeaturedImage(); @endphp
                                    @if($featuredImage)
                                        <img src="{{ Str::startsWith($featuredImage, ['http', 'https']) ? $featuredImage : asset('storage/' . $featuredImage) }}" alt="{{ $service->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-primary-400 to-secondary-500 flex items-center justify-center">
                                            <i class="fa-regular fa-image text-white text-3xl opacity-50"></i>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <div class="absolute bottom-3 left-3 right-3 flex justify-between items-end opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">
                                        <span class="bg-white/90 backdrop-blur-sm text-primary-700 px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                            {{ $service->bookings()->count() }} Bookings
                                        </span>
                                        <a href="{{ route('services.show', $service) }}" class="bg-white/90 backdrop-blur-sm text-gray-700 px-3 py-1 rounded-full text-xs font-bold shadow-lg hover:bg-white">
                                            <i class="fa-solid fa-eye mr-1"></i> View
                                        </a>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h4 class="font-bold text-lg text-gray-800 mb-2 group-hover:text-primary-600 transition-colors line-clamp-1">{{ $service->name }}</h4>
                                    <p class="text-gray-500 text-sm mb-4 line-clamp-2 leading-relaxed">{{ $service->description }}</p>
                                    <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                                        <span class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-secondary-600">PKR {{ number_format($service->price, 0) }}</span>
                                        <div class="flex gap-2">
                                            <a href="{{ route('vendor.services.availability', $service) }}" class="w-9 h-9 bg-gray-50 hover:bg-primary-50 text-gray-400 hover:text-primary-600 rounded-lg flex items-center justify-center transition-all" title="Manage Availability">
                                                <i class="fa-solid fa-calendar-days"></i>
                                            </a>
                                            <a href="{{ route('vendor.edit-service', $service) }}" class="w-9 h-9 bg-gray-50 hover:bg-primary-50 text-gray-400 hover:text-primary-600 rounded-lg flex items-center justify-center transition-all" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('vendor.destroy-service', $service) }}" method="POST" onsubmit="return confirm('Delete this service?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-9 h-9 bg-gray-50 hover:bg-red-50 text-gray-400 hover:text-red-600 rounded-lg flex items-center justify-center transition-all" title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartData = @json($chartData);
            
            // Revenue Chart
            const revCtx = document.getElementById('revenueChart').getContext('2d');
            const revenueChart = new Chart(revCtx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Revenue',
                        data: chartData.revenue,
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        borderWidth: 4,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#4f46e5',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { display: false },
                            ticks: {
                                font: { size: 10, weight: '600' },
                                callback: function(value) { return 'Rs ' + value.toLocaleString(); }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: '600' } }
                        }
                    }
                }
            });

            // Bookings Chart
            const bookCtx = document.getElementById('bookingsChart').getContext('2d');
            const bookingsChart = new Chart(bookCtx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Bookings',
                        data: chartData.bookings,
                        backgroundColor: '#0A3A7A',
                        borderRadius: 8,
                        barThickness: 20
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: '600' } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: '600' } }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>


