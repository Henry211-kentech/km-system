@extends('layouts.app')

@section('title', 'Activity Logs')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-slate-900 flex items-center gap-3">
        <i class="fas fa-history text-blue-600"></i> Activity Logs
    </h1>
    <p class="text-slate-500 mt-2">System activity tracking and monitoring.</p>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form action="{{ route('logs.filter') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Action</label>
            <select name="action" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">All Actions</option>
                <option value="LOGIN" {{ request('action') === 'LOGIN' ? 'selected' : '' }}>Login</option>
                <option value="LOGOUT" {{ request('action') === 'LOGOUT' ? 'selected' : '' }}>Logout</option>
                <option value="LOGIN_FAILED" {{ request('action') === 'LOGIN_FAILED' ? 'selected' : '' }}>Failed Login</option>
                <option value="CREATE" {{ request('action') === 'CREATE' ? 'selected' : '' }}>Create</option>
                <option value="UPDATE" {{ request('action') === 'UPDATE' ? 'selected' : '' }}>Update</option>
                <option value="DELETE" {{ request('action') === 'DELETE' ? 'selected' : '' }}>Delete</option>
                <option value="VIEW" {{ request('action') === 'VIEW' ? 'selected' : '' }}>View</option>
                <option value="DOWNLOAD" {{ request('action') === 'DOWNLOAD' ? 'selected' : '' }}>Download</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Model Type</label>
            <select name="model_type" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="">All Models</option>
                <option value="Invoice" {{ request('model_type') === 'Invoice' ? 'selected' : '' }}>Invoice</option>
                <option value="Payment" {{ request('model_type') === 'Payment' ? 'selected' : '' }}>Payment</option>
                <option value="Job" {{ request('model_type') === 'Job' ? 'selected' : '' }}>Job</option>
                <option value="Client" {{ request('model_type') === 'Client' ? 'selected' : '' }}>Client</option>
                <option value="Vehicle" {{ request('model_type') === 'Vehicle' ? 'selected' : '' }}>Vehicle</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md">
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
        </div>
    </form>
</div>

<!-- Logs Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-slate-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Timestamp</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">User</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Action</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Model</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Description</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">IP Address</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-slate-900">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($logs as $log)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-3 text-sm text-slate-600">{{ $log->created_at->setTimezone('Africa/Nairobi')->format('M d, Y H:i:s') }}</td>
                    <td class="px-6 py-3 text-sm text-slate-600">{{ $log->user->name ?? 'System' }}</td>
                    <td class="px-6 py-3 text-sm">
                        <span class="px-2 py-1 rounded text-xs font-semibold 
                            @if($log->action === 'CREATE') bg-green-100 text-green-800
                            @elseif($log->action === 'UPDATE') bg-blue-100 text-blue-800
                            @elseif($log->action === 'DELETE') bg-red-100 text-red-800
                            @elseif($log->action === 'LOGIN') bg-green-100 text-green-800
                            @elseif($log->action === 'LOGOUT') bg-yellow-100 text-yellow-800
                            @elseif($log->action === 'LOGIN_FAILED') bg-red-100 text-red-800
                            @elseif($log->action === 'VIEW') bg-gray-100 text-gray-800
                            @elseif($log->action === 'DOWNLOAD') bg-purple-100 text-purple-800
                            @endif">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-sm text-slate-600">{{ $log->model_type }}</td>
                    <td class="px-6 py-3 text-sm text-slate-600">{{ Str::limit($log->description, 50) }}</td>
                    <td class="px-6 py-3 text-sm text-slate-600">{{ $log->ip_address }}</td>
                    <td class="px-6 py-3 text-center text-sm">
                        <a href="{{ route('logs.show', $log) }}" class="text-blue-600 hover:underline">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                        <i class="fas fa-inbox text-3xl opacity-20 mb-2 block"></i>
                        <p>No logs found</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $logs->links() }}
</div>

<!-- Clear Old Logs Button -->
<div class="mt-6 flex gap-2">
    <form action="{{ route('logs.clearOldLogs') }}" method="POST" onsubmit="return confirm('Delete logs older than 90 days?')">
        @csrf
        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            <i class="fas fa-trash"></i> Clear Old Logs (90+ days)
        </button>
    </form>
</div>
@endsection
