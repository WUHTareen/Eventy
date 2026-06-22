<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center text-gray-600 transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight"><i class="fa-solid fa-chart-line text-indigo-600 mr-2"></i>{{ __('Analytics') }}</h2>
                <p class="text-gray-500 text-sm mt-1">{{ $rangeMeta['label'] }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- DATE RANGE FILTER -->
            @php
                $ranges = ['7d' => 'Last 7 Days', '30d' => 'Last 30 Days', '90d' => 'Last 90 Days', '12m' => 'Last 12 Months', 'ytd' => 'This Year'];
            @endphp
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex flex-wrap items-center gap-2">
                <span class="text-xs font-black text-gray-400 uppercase tracking-wider mr-2"><i class="fa-solid fa-calendar-range mr-1"></i> Range</span>
                @foreach($ranges as $key => $label)
                    <a href="{{ route('admin.analytics', ['range' => $key]) }}"
                       class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ $rangeMeta['range'] === $key ? 'bg-indigo-600 text-white shadow' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' }}">
                        {{ $label }}
                    </a>
                @endforeach
                <form method="GET" action="{{ route('admin.analytics') }}" class="flex items-center gap-2 ml-auto">
                    <input type="hidden" name="range" value="custom">
                    <input type="date" name="from" value="{{ request('from', $rangeMeta['from']) }}" class="px-3 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm font-bold">
                    <span class="text-gray-400">–</span>
                    <input type="date" name="to" value="{{ request('to', $rangeMeta['to']) }}" class="px-3 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm font-bold">
                    <button type="submit" class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ $rangeMeta['range'] === 'custom' ? 'bg-indigo-600 text-white' : 'bg-gray-800 text-white hover:bg-gray-900' }}">Apply</button>
                </form>
            </div>

            @php
                if (!function_exists('growthBadge')) {
                    function growthBadge($pct) {
                        if ($pct > 0) return '<span class="text-emerald-600 font-bold"><i class="fa-solid fa-arrow-trend-up"></i> ' . $pct . '%</span>';
                        if ($pct < 0) return '<span class="text-rose-600 font-bold"><i class="fa-solid fa-arrow-trend-down"></i> ' . abs($pct) . '%</span>';
                        return '<span class="text-gray-400 font-bold">—</span>';
                    }
                }
                $kpiCards = [
                    ['label' => 'Revenue', 'value' => 'PKR ' . number_format($kpis['revenue']), 'icon' => 'fa-sack-dollar', 'color' => 'from-emerald-500 to-green-600', 'growth' => $kpis['g_revenue']],
                    ['label' => 'Commission', 'value' => 'PKR ' . number_format($kpis['commission']), 'icon' => 'fa-hand-holding-dollar', 'color' => 'from-indigo-500 to-purple-600', 'growth' => null],
                    ['label' => 'Avg. Order Value', 'value' => 'PKR ' . number_format($kpis['aov']), 'icon' => 'fa-receipt', 'color' => 'from-amber-500 to-orange-600', 'growth' => null],
                    ['label' => 'Bookings', 'value' => number_format($kpis['bookings']), 'icon' => 'fa-calendar-check', 'color' => 'from-blue-500 to-cyan-600', 'growth' => $kpis['g_bookings']],
                    ['label' => 'Completed', 'value' => number_format($kpis['completed']), 'icon' => 'fa-circle-check', 'color' => 'from-teal-500 to-emerald-600', 'growth' => null],
                    ['label' => 'New Clients', 'value' => number_format($kpis['users']), 'icon' => 'fa-user-plus', 'color' => 'from-pink-500 to-rose-600', 'growth' => $kpis['g_users']],
                    ['label' => 'Cancellation Rate', 'value' => $kpis['cancel_rate'] . '%', 'icon' => 'fa-circle-xmark', 'color' => 'from-rose-500 to-red-600', 'growth' => null],
                    ['label' => 'Pending Payouts', 'value' => 'PKR ' . number_format($kpis['pending_payouts']), 'icon' => 'fa-money-bill-transfer', 'color' => 'from-violet-500 to-fuchsia-600', 'growth' => null],
                ];
            @endphp

            <!-- KPI CARDS -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($kpiCards as $card)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                        <div class="flex items-start justify-between">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $card['color'] }} flex items-center justify-center text-white mb-3">
                                <i class="fa-solid {{ $card['icon'] }}"></i>
                            </div>
                            @if(!is_null($card['growth']))
                                <span class="text-xs">{!! growthBadge($card['growth']) !!}</span>
                            @endif
                        </div>
                        <p class="text-2xl font-black text-gray-800 leading-none">{{ $card['value'] }}</p>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mt-1.5">{{ $card['label'] }}</p>
                    </div>
                @endforeach
            </div>

            <!-- VENDOR FUNNEL + PAYOUTS STRIP -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <p class="text-xs font-black text-gray-400 uppercase tracking-wider mb-3"><i class="fa-solid fa-store text-green-600 mr-1"></i> Vendor Verification</p>
                    @php $vp = $funnel['vendors_total'] > 0 ? round($funnel['vendors_verified'] / $funnel['vendors_total'] * 100) : 0; @endphp
                    <div class="flex items-end justify-between mb-2">
                        <span class="text-3xl font-black text-gray-800">{{ $funnel['vendors_verified'] }}<span class="text-gray-300 text-xl">/{{ $funnel['vendors_total'] }}</span></span>
                        <span class="text-sm font-bold text-gray-500">{{ $vp }}% verified</span>
                    </div>
                    <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden mb-2">
                        <div class="h-full bg-gradient-to-r from-green-500 to-emerald-600 rounded-full" style="width: {{ $vp }}%"></div>
                    </div>
                    @if($funnel['vendors_pending'] > 0)
                        <a href="{{ route('admin.vendors.index') }}" class="text-xs font-bold text-amber-600 hover:underline"><i class="fa-solid fa-clock"></i> {{ $funnel['vendors_pending'] }} awaiting approval</a>
                    @else
                        <span class="text-xs font-bold text-emerald-600"><i class="fa-solid fa-check"></i> All vendors verified</span>
                    @endif
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <p class="text-xs font-black text-gray-400 uppercase tracking-wider mb-3"><i class="fa-solid fa-hourglass-half text-amber-500 mr-1"></i> Payouts Pending</p>
                    <p class="text-3xl font-black text-gray-800 mb-1">PKR {{ number_format($funnel['pending_payouts']) }}</p>
                    <a href="{{ route('admin.withdrawals') }}" class="text-xs font-bold text-indigo-600 hover:underline">{{ $funnel['pending_payouts_count'] }} request(s) to process →</a>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <p class="text-xs font-black text-gray-400 uppercase tracking-wider mb-3"><i class="fa-solid fa-circle-check text-emerald-500 mr-1"></i> Total Paid Out</p>
                    <p class="text-3xl font-black text-gray-800 mb-1">PKR {{ number_format($funnel['paid_payouts']) }}</p>
                    <span class="text-xs font-bold text-gray-400">All-time vendor payouts</span>
                </div>
            </div>

            <!-- REVENUE TREND -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h3 class="text-lg font-bold text-gray-800 mb-1"><i class="fa-solid fa-money-bill-trend-up text-emerald-500 mr-2"></i>Revenue Trend</h3>
                <p class="text-gray-500 text-sm mb-5">Completed-booking revenue (PKR).</p>
                <canvas id="revenueChart" height="90"></canvas>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8 lg:col-span-2">
                    <h3 class="text-lg font-bold text-gray-800 mb-1"><i class="fa-solid fa-calendar-days text-blue-500 mr-2"></i>Bookings &amp; New Users</h3>
                    <p class="text-gray-500 text-sm mb-5">Volume over the selected range.</p>
                    <canvas id="bookingsChart" height="150"></canvas>
                </div>
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-1"><i class="fa-solid fa-chart-pie text-purple-500 mr-2"></i>Booking Status</h3>
                    <p class="text-gray-500 text-sm mb-5">Breakdown in range.</p>
                    <canvas id="statusChart" height="200"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- TOP CATEGORIES -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-1"><i class="fa-solid fa-layer-group text-amber-500 mr-2"></i>Top Categories</h3>
                    <p class="text-gray-500 text-sm mb-5">By number of bookings.</p>
                    @if($topCategories->isEmpty())
                        <p class="text-sm text-gray-400 bg-gray-50 rounded-xl p-5 text-center">No booking data in this range.</p>
                    @else
                        <canvas id="categoriesChart" height="200"></canvas>
                    @endif
                </div>

                <!-- TOP SERVICES -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-1"><i class="fa-solid fa-star text-yellow-500 mr-2"></i>Top Services</h3>
                    <p class="text-gray-500 text-sm mb-5">Most-booked individual services.</p>
                    @if($topServices->isEmpty())
                        <p class="text-sm text-gray-400 bg-gray-50 rounded-xl p-5 text-center">No booking data in this range.</p>
                    @else
                        @php $maxSvc = max($topServices->values()->toArray() ?: [1]); @endphp
                        <div class="space-y-3">
                            @foreach($topServices as $name => $c)
                                <div>
                                    <div class="flex items-center justify-between text-sm mb-1">
                                        <span class="font-bold text-gray-700 truncate pr-2">{{ $name }}</span>
                                        <span class="font-black text-gray-800 whitespace-nowrap">{{ $c }} bookings</span>
                                    </div>
                                    <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-amber-400 to-orange-500 rounded-full" style="width: {{ $maxSvc > 0 ? round($c / $maxSvc * 100) : 0 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- TOP VENDORS -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-1"><i class="fa-solid fa-trophy text-yellow-500 mr-2"></i>Top Vendors</h3>
                    <p class="text-gray-500 text-sm mb-5">By completed revenue (PKR).</p>
                    @if($topVendors->isEmpty())
                        <p class="text-sm text-gray-400 bg-gray-50 rounded-xl p-5 text-center">No completed revenue in this range.</p>
                    @else
                        @php $maxVendor = max($topVendors->values()->toArray() ?: [1]); @endphp
                        <div class="space-y-3">
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

                <!-- TOP CITIES -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-1"><i class="fa-solid fa-city text-teal-500 mr-2"></i>Top Cities</h3>
                    <p class="text-gray-500 text-sm mb-5">Revenue by service location (PKR).</p>
                    @if($topCities->isEmpty())
                        <p class="text-sm text-gray-400 bg-gray-50 rounded-xl p-5 text-center">No location revenue in this range.</p>
                    @else
                        @php $maxCity = max($topCities->pluck('total')->toArray() ?: [1]); @endphp
                        <div class="space-y-3">
                            @foreach($topCities as $city)
                                <div>
                                    <div class="flex items-center justify-between text-sm mb-1">
                                        <span class="font-bold text-gray-700 truncate pr-2">{{ $city->name }} <span class="text-gray-400 font-medium">({{ $city->c }})</span></span>
                                        <span class="font-black text-gray-800 whitespace-nowrap">PKR {{ number_format($city->total) }}</span>
                                    </div>
                                    <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-teal-400 to-cyan-600 rounded-full" style="width: {{ $maxCity > 0 ? round($city->total / $maxCity * 100) : 0 }}%"></div>
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

            new Chart(document.getElementById('revenueChart'), {
                type: 'line',
                data: { labels: months, datasets: [{
                    label: 'Revenue (PKR)', data: @json($revenueSeries),
                    borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.12)',
                    fill: true, tension: 0.4, borderWidth: 3, pointBackgroundColor: '#10b981', pointRadius: 3,
                }]},
                options: { responsive: true, maintainAspectRatio: true,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { callback: v => 'PKR ' + v.toLocaleString() } } } }
            });

            new Chart(document.getElementById('bookingsChart'), {
                type: 'bar',
                data: { labels: months, datasets: [
                    { label: 'Bookings', data: @json($bookingsSeries), backgroundColor: '#3b82f6', borderRadius: 6 },
                    { label: 'New Users', data: @json($usersSeries), backgroundColor: '#a855f7', borderRadius: 6 },
                ]},
                options: { responsive: true, maintainAspectRatio: true,
                    plugins: { legend: { position: 'bottom' } },
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
            });

            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: { labels: @json($statusLabels), datasets: [{
                    data: @json($statusData),
                    backgroundColor: ['#f59e0b', '#3b82f6', '#10b981', '#ef4444', '#8b5cf6', '#6b7280'], borderWidth: 0,
                }]},
                options: { responsive: true, maintainAspectRatio: true, cutout: '62%',
                    plugins: { legend: { position: 'bottom' } } }
            });

            const catEl = document.getElementById('categoriesChart');
            if (catEl) {
                new Chart(catEl, {
                    type: 'bar',
                    data: { labels: @json($topCategories->keys()), datasets: [{
                        label: 'Bookings', data: @json($topCategories->values()),
                        backgroundColor: '#f59e0b', borderRadius: 6,
                    }]},
                    options: { indexAxis: 'y', responsive: true, maintainAspectRatio: true,
                        plugins: { legend: { display: false } },
                        scales: { x: { beginAtZero: true, ticks: { precision: 0 } } } }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
