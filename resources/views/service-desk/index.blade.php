<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    <i class="fa-solid fa-headset text-[#0A3A7A] mr-2"></i>{{ __('Service Desk') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Manage customer inquiries and support requests</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 font-bold py-2.5 px-5 rounded-xl shadow-sm transition-all flex items-center gap-2 hover:shadow-md">
                <i class="fa-solid fa-arrow-left text-gray-400"></i> Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($requests->isEmpty())
                <div class="bg-white rounded-3xl p-16 text-center border border-gray-100 shadow-sm">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl text-gray-400">
                        <i class="fa-solid fa-inbox"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">No Requests Yet</h3>
                    <p class="text-gray-500">Service desk requests from customers and vendors will appear here.</p>
                </div>
            @else
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                                    <th class="p-6">Reference</th>
                                    <th class="p-6">Customer</th>
                                    <th class="p-6">Desk Type</th>
                                    <th class="p-6">Event Details</th>
                                    <th class="p-6">Priority</th>
                                    <th class="p-6">Status</th>
                                    <th class="p-6">Created</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($requests as $request)
                                    <tr class="hover:bg-gray-50/50 transition-colors group">
                                        <td class="p-6">
                                            <span class="font-mono text-xs font-bold text-primary-500">{{ $request->reference }}</span>
                                        </td>
                                        <td class="p-6">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-500 text-xs font-bold">
                                                    {{ substr($request->customer_name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-900">{{ $request->customer_name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $request->customer_email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-6">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold capitalize bg-blue-50 text-blue-700">
                                                <i class="fa-solid fa-{{ $request->desk_type === 'catering' ? 'utensils' : ($request->desk_type === 'photography' ? 'camera' : 'video') }}"></i>
                                                {{ $request->desk_type }}
                                            </span>
                                        </td>
                                        <td class="p-6">
                                            <div class="font-bold text-gray-900 capitalize">{{ $request->service_type }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ $request->event_location }} • {{ $request->guest_count }} guests
                                                @if($request->event_date)
                                                    • {{ $request->event_date->format('M d, Y') }}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="p-6">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold capitalize
                                                {{ $request->priority === 'high' ? 'bg-red-50 text-red-700' : '' }}
                                                {{ $request->priority === 'medium' ? 'bg-yellow-50 text-yellow-700' : '' }}
                                                {{ $request->priority === 'low' ? 'bg-gray-50 text-gray-700' : '' }}">
                                                {{ $request->priority }}
                                            </span>
                                        </td>
                                        <td class="p-6">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold capitalize
                                                {{ $request->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : '' }}
                                                {{ $request->status === 'active' ? 'bg-green-50 text-green-700' : '' }}
                                                {{ $request->status === 'closed' ? 'bg-gray-100 text-gray-700' : '' }}">
                                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                                {{ $request->status }}
                                            </span>
                                        </td>
                                        <td class="p-6 text-gray-500 text-xs">
                                            {{ $request->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-6 border-t border-gray-100">
                        {{ $requests->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>


