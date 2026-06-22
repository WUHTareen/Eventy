<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center text-gray-600 transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight"><i class="fa-solid fa-chart-line text-indigo-600 mr-2"></i>{{ __('Analytics') }}</h2>
                <p class="text-gray-500 text-sm mt-1">Revenue, bookings, users & top performers — last 12 months</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            @php
                $kpiCards = [
                    ['label' => 'Total Revenue', 'value' => 'PKR ' . number_format($kpis['revenue']), 'icon' => 'fa-sack-dollar', 'color' => 'from-emerald-500 to-green-600'],
                    ['label' => 'Commission Earned', 'value' => 'PKR ' . number_format($kpis['commission']), 'icon' => 'fa-hand-holding-dollar', 'color' => 'from-indigo-500 to-purple-600'],
                    ['label' => 'Avg. Order Value', 'value' => 'PKR ' . number_format($kpis['aov']), 'icon' => 'fa-receipt', 'color' => 'from-amber-500 to-orange-600'],
                    ['label' => 'Total Bookings', 'value' => number_format($kpis['bookings']), 'icon' => 'fa-calendar-check', 'color' => 'from-blue-500 to-cyan-600'],
                    ['label' => 'Completed', 'value' => number_format($kpis['completed']), 'icon' => 'fa-circle-check', 'color' => 'from-teal-500 to-emerald-600'],
                    ['label' => 'Clients', 'value' => number_format($kpis['users']), 'icon' => 'fa-users', 'color' => 'from-pink-500 to-rose-600'],
                    ['label' => 'Vendors', 'value' => number_format($kpis['vendors']), 'icon' => 'fa-store', 'color' => 'from-violet-500 to-fuchsia-600'],
                    ['label' => 'Services', 'value' => number_format($kpis['services']), 'icon' => 'fa-box-open', 'color' => 'from-slate-500 to-gray-700'],
                ];
            @endphp

            <!-- KPI CARDS -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($kpiCards as $card)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $card['color'] }} flex items-center justify-center text-white mb-3">
                            <i class="fa-solid {{ $card['icon'] }}"></i>
                        </div>
                        <p class="text-2xl font-black text-gray-800 leading-none">{{ $card['value'] }}</p>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mt-1.5">{{ $card['label'] }}</p>
                    </div>
                @endforeach
            </div>

            <!-- REVENUE TREND -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h3 class="text-lg font-bold text-gray-800 mb-1"><i class="fa-solid fa-money-bill-trend-up text-emerald-500 mr-2"></i>Revenue Trend</h3>
                <p class="text-gray-500 text-sm mb-5">Completed-booking revenue per month (PKR).</p>
                <canvas id="revenueChart" height="90"></canvas>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- BOOKINGS PER MONTH -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8 lg:col-span-2">
                    <h3 class="text-lg font-bold text-gray-800 mb-1"><i class="fa-solid fa-calendar-days text-blue-500 mr-2"></i>Bookings &amp; New Users</h3>
                    <p class="text-gray-500 text-sm mb-5">Monthly volume over the last year.</p>
                    <canvas id="bookingsChart" height="150"></canvas>
                </div>

                <!-- STATUS DOUGHNUT -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-1"><i class="fa-solid fa-chart-pie text-purple-500 mr-2"></i>Booking Status</h3>
                    <p class="text-gray-500 text-sm mb-5">All-time breakdown.</p>
                    <canvas id="statusChart" height="200"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- TOP CATEGORIES -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-1"><i class="fa-solid fa-layer-group text-amber-500 mr-2"></i>Top Categories</h3>
                    <p class="text-gray-500 text-sm mb-5">By number of bookings.</p>
                    @if($topCategories->isEmpty())
                        <p class="text-sm text-gray-400 bg-gray-50 rounded-xl p-5 text-center">No booking data yet.</p>
                    @else
                        <canvas id="categoriesChart" height="200"></canvas>
                    @endif
                </div>

                <!-- TOP VENDORS -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-1"><i class="fa-solid fa-trophy text-yellow-500 mr-2"></i>Top Vendors</h3>
                    <p class="text-gray-500 text-sm mb-5">By completed revenue (PKR).</p>
                    @if($topVendors->isEmpty())
                        <p class="text-sm text-gray-400 bg-gray-50 rounded-xl p-5 text-center">No completed revenue yet.</p>
                    @else
                        <div class="space-y-3">
                            @php $maxVendor = max($topVendors->values()->toArray() ?: [1]); @endphp
                            @foreach($topVendors as $name => $total)
                                <div>
                                    <div class="flex items-center justify-between text-sm mb-1">
                                        <span class="font-bold text-gray-700 truncate pr-2">{{ $name }}</span>
                                        <span class="font-black text-gray-800 whitespace-nowrap">PKR {{ number_format($total) }}</span>
                                    </div>
                                    <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full" style="width: {{ $maxVendor > 0 ? round($total / $maxVendor * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') return;
            Chart.defaults.font.family = 'inherit';
            Chart.defaults.color = '#6b7280';

            const months = @json($monthLabels);

            // Revenue line
            new Chart(document.getElementById('revenueChart'), {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Revenue (PKR)',
                        data: @json($revenueSeries),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16,185,129,0.12)',
                        fill: true, tension: 0.4, borderWidth: 3,
                        pointBackgroundColor: '#10b981', pointRadius: 3,
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: true,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { callback: v => 'PKR ' + v.toLocaleString() } } }
                }
            });

            // Bookings + users bars
            new Chart(document.getElementById('bookingsChart'), {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [
                        { label: 'Bookings', data: @json($bookingsSeries), backgroundColor: '#3b82f6', borderRadius: 6 },
                        { label: 'New Users', data: @json($usersSeries), backgroundColor: '#a855f7', borderRadius: 6 },
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: true,
                    plugins: { legend: { position: 'bottom' } },
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                }
            });

            // Status doughnut
            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($statusLabels),
                    datasets: [{
                        data: @json($statusData),
                        backgroundColor: ['#f59e0b', '#3b82f6', '#10b981', '#ef4444', '#8b5cf6', '#6b7280'],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: true, cutout: '62%',
                    plugins: { legend: { position: 'bottom' } }
                }
            });

            // Top categories (horizontal bar)
            const catEl = document.getElementById('categoriesChart');
            if (catEl) {
                new Chart(catEl, {
                    type: 'bar',
                    data: {
                        labels: @json($topCategories->keys()),
                        datasets: [{
                            label: 'Bookings',
                            data: @json($topCategories->values()),
                            backgroundColor: '#f59e0b', borderRadius: 6,
                        }]
                    },
                    options: {
                        indexAxis: 'y', responsive: true, maintainAspectRatio: true,
                        plugins: { legend: { display: false } },
                        scales: { x: { beginAtZero: true, ticks: { precision: 0 } } }
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
