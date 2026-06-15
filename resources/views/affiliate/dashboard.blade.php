<x-app-layout>
    @push('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .gradient-text {
            background: linear-gradient(135deg, #0A3A7A 0%, #ED1C24 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
    @endpush

    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                    Welcome back, <span class="gradient-text">{{ Auth::user()->name }}</span>
                </h2>
                <p class="text-gray-500 mt-1">Here's your affiliate performance overview.</p>
            </div>
            <div class="mt-4 md:mt-0 flex gap-3">
                <a href="{{ route('affiliate.resources') }}" class="px-6 py-2.5 bg-[#0A3A7A] text-white rounded-xl shadow-lg hover:bg-[#0D4E9A] transition transform hover:-translate-y-1 font-medium">
                    <i class="fa-solid fa-bullhorn mr-2"></i> Marketing Kit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Hero Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Earnings -->
                <div class="glass-card rounded-2xl p-6 shadow-sm hover:shadow-md transition relative overflow-hidden group">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-green-50 rounded-full translate-x-8 -translate-y-8 group-hover:scale-110 transition-transform"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-green-100 text-green-600 rounded-xl">
                                <i class="fa-solid fa-wallet text-xl"></i>
                            </div>
                            <span class="text-xs font-bold px-2 py-1 bg-green-50 text-green-600 rounded-lg">+12% this month</span>
                        </div>
                        <p class="text-gray-500 text-sm font-medium">Total Earnings</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">
                            <span class="text-sm align-top text-gray-400 font-normal mr-1">PKR</span>{{ number_format($stats['total_earnings']) }}
                        </h3>
                    </div>
                </div>

                <!-- Pending -->
                <div class="glass-card rounded-2xl p-6 shadow-sm hover:shadow-md transition relative overflow-hidden group">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-amber-50 rounded-full translate-x-8 -translate-y-8 group-hover:scale-110 transition-transform"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-amber-100 text-amber-600 rounded-xl">
                                <i class="fa-solid fa-hourglass-start text-xl"></i>
                            </div>
                            <span class="text-xs font-bold px-2 py-1 bg-amber-50 text-amber-600 rounded-lg">Processing</span>
                        </div>
                        <p class="text-gray-500 text-sm font-medium">Pending Payout</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">
                            <span class="text-sm align-top text-gray-400 font-normal mr-1">PKR</span>{{ number_format($stats['pending_earnings']) }}
                        </h3>
                    </div>
                </div>

                <!-- Leads -->
                <div class="glass-card rounded-2xl p-6 shadow-sm hover:shadow-md transition relative overflow-hidden group">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-blue-50 rounded-full translate-x-8 -translate-y-8 group-hover:scale-110 transition-transform"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-blue-100 text-[#0A3A7A] rounded-xl">
                                <i class="fa-solid fa-users text-xl"></i>
                            </div>
                            <span class="text-xs font-bold px-2 py-1 bg-blue-50 text-blue-600 rounded-lg">Active</span>
                        </div>
                        <p class="text-gray-500 text-sm font-medium">Total Leads</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['total_leads']) }}</h3>
                    </div>
                </div>

                <!-- Conversion Rate -->
                <div class="glass-card rounded-2xl p-6 shadow-sm hover:shadow-md transition relative overflow-hidden group">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-purple-50 rounded-full translate-x-8 -translate-y-8 group-hover:scale-110 transition-transform"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-purple-100 text-purple-600 rounded-xl">
                                <i class="fa-solid fa-chart-line text-xl"></i>
                            </div>
                            <span class="text-xs font-bold px-2 py-1 bg-purple-50 text-purple-600 rounded-lg">Target: 25%</span>
                        </div>
                        <p class="text-gray-500 text-sm font-medium">Conversion Rate</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['conversion_rate'] }}%</h3>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Data Visualization & Tools -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Referral Link Card -->
                    <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-8 opacity-5">
                            <i class="fa-solid fa-link text-9xl"></i>
                        </div>
                        <div class="relative z-10">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Your Unique Referral Link</h3>
                            <p class="text-gray-500 mb-6 max-w-lg">Share this link to earn 5% commission on every booking made by your referrals. Use our marketing resources to boost your reach.</p>
                            
                            <div class="flex flex-col sm:flex-row gap-4 p-2 bg-gray-50 rounded-xl border border-gray-200">
                                <div class="flex-1 flex items-center px-4">
                                    <i class="fa-solid fa-link text-gray-400 mr-3"></i>
                                    <input type="text" readonly value="{{ url('/register?ref=' . Auth::id()) }}" class="w-full bg-transparent border-none focus:ring-0 text-sm font-medium text-gray-600">
                                </div>
                                <button onclick="navigator.clipboard.writeText('{{ url('/register?ref=' . Auth::id()) }}'); alert('Link copied!');" class="px-6 py-3 bg-[#0A3A7A] hover:bg-[#0D4E9A] text-white rounded-lg font-medium transition shadow-sm flex items-center justify-center">
                                    <i class="fa-regular fa-copy mr-2"></i> Copy Link
                                </button>
                            </div>
                            
                            <div class="mt-6 flex gap-4">
                                <button class="w-10 h-10 rounded-full bg-[#1877F2] text-white flex items-center justify-center hover:scale-110 transition"><i class="fa-brands fa-facebook-f"></i></button>
                                <button class="w-10 h-10 rounded-full bg-[#1DA1F2] text-white flex items-center justify-center hover:scale-110 transition"><i class="fa-brands fa-twitter"></i></button>
                                <button class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:scale-110 transition"><i class="fa-brands fa-whatsapp"></i></button>
                                <button class="w-10 h-10 rounded-full bg-[#E4405F] text-white flex items-center justify-center hover:scale-110 transition"><i class="fa-brands fa-instagram"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Leads Table -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-bold text-lg text-gray-800">Recent Leads</h3>
                            <a href="{{ route('affiliate.leads') }}" class="text-[#0A3A7A] text-sm font-medium hover:underline">View All Leads</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">User</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Source</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($recentLeads as $lead)
                                        <tr class="hover:bg-gray-50/50 transition">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-xs font-bold mr-3">
                                                        {{ substr($lead->name, 0, 1) }}
                                                    </div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $lead->name }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ ucfirst($lead->source ?? 'Direct') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($lead->status === 'converted')
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                                        <i class="fa-solid fa-check mr-1 self-center"></i> Converted
                                                    </span>
                                                @elseif($lead->status === 'verified')
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                                        Verified
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 border border-gray-200">
                                                        New Lead
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $lead->created_at->diffForHumans() }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                                <div class="flex flex-col items-center">
                                                    <i class="fa-regular fa-folder-open text-2xl mb-2 opacity-30"></i>
                                                    <p>No activity recorded yet.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Sidebar / Performance -->
                <div class="space-y-8">
                    <!-- Quick Actions -->
                    <div class="bg-[#0A3A7A] rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                        <div class="absolute top-0 right-0 opacity-10 transform translate-x-10 -translate-y-10">
                            <i class="fa-solid fa-rocket text-9xl"></i>
                        </div>
                        <h3 class="font-bold text-lg mb-4 relative z-10">Boost Your Earnings</h3>
                        <div class="space-y-3 relative z-10">
                            <a href="{{ route('affiliate.resources') }}" class="flex items-center p-3 bg-white/10 hover:bg-white/20 rounded-xl transition cursor-pointer backdrop-blur-sm">
                                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-3">
                                    <i class="fa-solid fa-image"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-sm">Download Banners</p>
                                    <p class="text-xs text-blue-100">High converting assets</p>
                                </div>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center p-3 bg-white/10 hover:bg-white/20 rounded-xl transition cursor-pointer backdrop-blur-sm">
                                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-3">
                                    <i class="fa-solid fa-gear"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-sm">Payment Settings</p>
                                    <p class="text-xs text-blue-100">Setup withdrawal methods</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Performance Chart (Placeholder) -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-lg text-gray-800 mb-4">Earnings History</h3>
                        <div class="relative h-48 w-full">
                            <canvas id="earningsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('earningsChart').getContext('2d');
            
            // Gradient
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(10, 58, 122, 0.2)');
            gradient.addColorStop(1, 'rgba(10, 58, 122, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Earnings (PKR)',
                        data: [0, 400, 300, 800, 600, 1200, {{ $stats['total_earnings'] > 0 ? $stats['total_earnings'] / 5 : 0 }}], // Dummy data for visual
                        borderColor: '#0A3A7A',
                        backgroundColor: gradient,
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#FFFFFF',
                        pointBorderColor: '#0A3A7A',
                        pointBorderWidth: 2
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
                            grid: { display: false }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>

