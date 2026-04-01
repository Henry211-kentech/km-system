@extends('layouts.app')

@section('title', 'Backups')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-slate-900 flex items-center gap-3">
        <i class="fas fa-database text-green-600"></i> Database Backups
    </h1>
    <p class="text-slate-500 mt-2">Create and manage system backups.</p>
</div>

<!-- Create Backup Form -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form action="{{ route('backups.create') }}" method="POST" class="flex gap-4 items-end">
        @csrf
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Backup Description (Optional)</label>
            <input type="text" name="description" placeholder="e.g., Pre-release backup" class="w-full px-3 py-2 border border-gray-300 rounded-md">
        </div>
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
            <i class="fas fa-plus"></i> Create Backup
        </button>
    </form>
</div>

<!-- Backups Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-slate-50 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Filename</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Size</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Description</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Created By</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-slate-900">Date</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-slate-900">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($backups as $backup)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-3 text-sm font-mono text-slate-600">{{ $backup->filename }}</td>
                    <td class="px-6 py-3 text-sm text-slate-600">{{ $backup->getFileSizeFormatted() }}</td>
                    <td class="px-6 py-3 text-sm text-slate-600">{{ $backup->description ?? '-' }}</td>
                    <td class="px-6 py-3 text-sm text-slate-600">{{ $backup->createdBy->name ?? 'System' }}</td>
                    <td class="px-6 py-3 text-sm text-slate-600">{{ $backup->created_at->format('M d, Y H:i') }}</td>
                    <td class="px-6 py-3 text-center text-sm space-x-2">
                        <a href="{{ route('backups.download', $backup) }}" class="text-blue-600 hover:underline">
                            <i class="fas fa-download"></i> Download
                        </a>
                        <form action="{{ route('backups.destroy', $backup) }}" method="POST" class="inline" onsubmit="return confirm('Delete this backup?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                        <i class="fas fa-box-open text-3xl opacity-20 mb-2 block"></i>
                        <p>No backups found</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Backup Information -->
<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
    <h3 class="font-semibold text-blue-900 mb-2">
        <i class="fas fa-info-circle"></i> Backup Information
    </h3>
    <ul class="text-sm text-blue-800 space-y-1">
        <li>• Backups are stored in the storage/app/backups directory</li>
        <li>• Automatic cleanup keeps only the latest 10 backups</li>
        <li>• All backups require admin privileges to create or restore</li>
        <li>• Backup files contain complete database structure and data</li>
    </ul>
</div>
@endsection
