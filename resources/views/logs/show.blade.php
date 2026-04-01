@extends('layouts.app')

@section('title', 'Log Details')

@section('content')
<div class="mb-8">
    <a href="{{ route('logs.index') }}" class="text-blue-600 hover:underline mb-3 inline-block">&larr; Back to Logs</a>
    <h1 class="text-4xl font-bold text-slate-900 mt-2">Activity Details</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold mb-4">Log Information</h2>
        <div class="space-y-4">
            <div>
                <p class="text-gray-600 text-sm">Action</p>
                <p class="font-semibold">
                    <span class="px-2 py-1 rounded text-xs font-bold
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
                </p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Model Type</p>
                <p class="font-semibold">{{ $log->model_type }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Model ID</p>
                <p class="font-semibold">{{ $log->model_id }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">User</p>
                <p class="font-semibold">{{ $log->user->name ?? 'System' }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">IP Address</p>
                <p class="font-semibold">{{ $log->ip_address }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Timestamp</p>
                <p class="font-semibold">{{ $log->created_at->setTimezone('Africa/Nairobi')->format('M d, Y H:i:s') }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Description</p>
                <p class="font-semibold">{{ $log->description }}</p>
            </div>
        </div>
    </div>

    <div>
        @if($log->old_values)
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-bold mb-4">Old Values</h2>
            <div class="bg-red-50 p-4 rounded border border-red-200 max-h-96 overflow-y-auto">
                <pre class="text-sm text-red-900">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
        @endif

        @if($log->new_values)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold mb-4">New Values</h2>
            <div class="bg-green-50 p-4 rounded border border-green-200 max-h-96 overflow-y-auto">
                <pre class="text-sm text-green-900">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="mt-6 flex gap-2">
    <form action="{{ route('logs.destroy', $log) }}" method="POST" onsubmit="return confirm('Delete this log?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            <i class="fas fa-trash"></i> Delete Log
        </button>
    </form>
</div>
@endsection
