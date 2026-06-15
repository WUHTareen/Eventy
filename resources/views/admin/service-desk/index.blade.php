@extends('layouts.admin')

@section('title', 'Service Desk Requests')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6">Service Desk Requests</h1>
        <div class="mb-6 flex flex-wrap gap-4">
            <form method="GET" class="flex gap-2">
                <select name="desk_type" class="px-3 py-2 border rounded-xl">
                    <option value="">All Desks</option>
                    @foreach(config('service-desks.desks') as $key => $desk)
                        <option value="{{ $key }}" {{ request('desk_type') == $key ? 'selected' : '' }}>{{ $desk['name'] }}</option>
                    @endforeach
                </select>
                <select name="status" class="px-3 py-2 border rounded-xl">
                    <option value="">All Statuses</option>
                    @foreach(config('service-desks.status') as $key => $status)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $status['label'] }}</option>
                    @endforeach
                </select>
                <select name="priority" class="px-3 py-2 border rounded-xl">
                    <option value="">All Priorities</option>
                    @foreach(config('service-desks.priority') as $key => $label)
                        <option value="{{ $key }}" {{ request('priority') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl font-bold">Filter</button>
            </form>
        </div>
        <div class="overflow-x-auto bg-white rounded-2xl shadow border border-gray-100">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50 text-xs font-bold text-gray-500 uppercase">
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-4 py-4">Desk</th>
                        <th class="px-4 py-4">Status</th>
                        <th class="px-4 py-4">Priority</th>
                        <th class="px-4 py-4">Created</th>
                        <th class="px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                        <tr class="border-b hover:bg-indigo-50/20">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $request->customer_name }}</div>
                                <div class="text-xs text-gray-500">{{ $request->customer_email }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center gap-1">
                                    <i class="fa-solid {{ config('service-desks.desks')[$request->desk_type]['icon'] ?? '' }} text-{{ config('service-desks.desks')[$request->desk_type]['color'] ?? 'gray' }}-500"></i>
                                    {{ config('service-desks.desks')[$request->desk_type]['name'] ?? ucfirst($request->desk_type) }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 rounded-full text-xs font-bold bg-{{ config('service-desks.status')[$request->status]['color'] ?? 'gray' }}-100 text-{{ config('service-desks.status')[$request->status]['color'] ?? 'gray' }}-700">
                                    {{ config('service-desks.status')[$request->status]['label'] ?? ucfirst($request->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-2 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700">
                                    {{ config('service-desks.priority')[$request->priority] ?? ucfirst($request->priority) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-xs text-gray-500">{{ $request->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.service-desk.show', $request) }}" class="text-indigo-600 font-bold hover:underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-8 text-gray-400">No service desk requests found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $requests->links() }}</div>
    </div>
</div>
@endsection


