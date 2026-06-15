@extends('layouts.admin')

@section('title', 'Service Desk Request Details')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold mb-4">Request #{{ $request->id }}</h1>
        <div class="bg-white rounded-2xl shadow p-6 mb-6">
            <h2 class="text-lg font-bold mb-2">Customer Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div><span class="font-bold">Name:</span> {{ $request->customer_name }}</div>
                <div><span class="font-bold">Email:</span> {{ $request->customer_email }}</div>
                <div><span class="font-bold">Phone:</span> {{ $request->customer_phone }}</div>
                <div><span class="font-bold">Service Type:</span> {{ $request->service_type }}</div>
            </div>
            <h2 class="text-lg font-bold mb-2 mt-4">Request Details</h2>
            <pre class="bg-gray-50 rounded-xl p-4 text-xs text-gray-700">{{ json_encode($request->request_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
        <div class="bg-white rounded-2xl shadow p-6 mb-6">
            <h2 class="text-lg font-bold mb-2">Admin Actions</h2>
            <form method="POST" action="{{ route('admin.service-desk.assign', $request) }}" class="mb-4 flex gap-2 items-center">
                @csrf
                <label class="font-bold">Assign to:</label>
                <select name="assigned_to" class="border rounded-xl px-3 py-2">
                    <option value="">Select user...</option>
                    @foreach($admins as $admin)
                        <option value="{{ $admin->id }}" {{ $request->assigned_to == $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl font-bold">Assign</button>
            </form>
            <form method="POST" action="{{ route('admin.service-desk.status', $request) }}">
                @csrf
                @method('PATCH')
                <label class="font-bold">Status:</label>
                <select name="status" class="border rounded-xl px-3 py-2">
                    @foreach(config('service-desks.status') as $key => $status)
                        <option value="{{ $key }}" {{ $request->status == $key ? 'selected' : '' }}>{{ $status['label'] }}</option>
                    @endforeach
                </select>
                <input type="text" name="admin_notes" class="border rounded-xl px-3 py-2 ml-2" placeholder="Add admin notes..." value="{{ $request->admin_notes }}">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-xl font-bold ml-2">Update Status</button>
            </form>
        </div>
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-bold mb-2">Timeline</h2>
            <ul class="text-xs text-gray-600">
                <li>Created: {{ $request->created_at->format('M d, Y H:i') }}</li>
                @if($request->responded_at)
                    <li>Responded: {{ $request->responded_at->format('M d, Y H:i') }}</li>
                @endif
                @if($request->completed_at)
                    <li>Completed: {{ $request->completed_at->format('M d, Y H:i') }}</li>
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection


