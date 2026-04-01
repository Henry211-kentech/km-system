@extends('layouts.app')

@section('title', 'Clients')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl sm:text-4xl font-bold text-slate-800 flex items-center gap-2">
            <i class="fas fa-users text-blue-600"></i> Clients
        </h1>
        <p class="text-slate-600 mt-1">Manage your garage customers</p>
    </div>
    <a href="{{ route('clients.create') }}" class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:shadow-lg transition flex items-center justify-center gap-2 font-medium">
        <i class="fas fa-plus"></i> New Client
    </a>
</div>

<!-- Desktop Table View -->
<div class="hidden md:block bg-white rounded-xl shadow-md border border-slate-100 overflow-hidden">
    <table class="w-full">
        <thead class="bg-gradient-to-r from-slate-100 to-slate-50 border-b border-slate-200">
            <tr>
                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Name</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Phone</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Vehicles</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-slate-700">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clients as $client)
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                    <td class="px-6 py-4 font-medium text-slate-800">{{ $client->name }}</td>
                    <td class="px-6 py-4 text-slate-600"><i class="fas fa-phone text-blue-500 mr-2"></i>{{ $client->phone }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-car"></i> {{ $client->vehicles->count() }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('clients.show', $client) }}" class="text-blue-600 hover:text-blue-800 transition font-medium text-sm" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('clients.edit', $client) }}" class="text-amber-600 hover:text-amber-800 transition font-medium text-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this client?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition font-medium text-sm" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center">
                        <div class="text-slate-500">
                            <i class="fas fa-inbox text-4xl mb-2 block opacity-30"></i>
                            <p class="text-lg">No clients found</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Mobile Card View -->
<div class="md:hidden space-y-4">
    @forelse($clients as $client)
        <div class="bg-white rounded-lg shadow-md border border-slate-100 p-4 hover:shadow-lg transition">
            <div class="flex justify-between items-start mb-3">
                <h3 class="text-lg font-semibold text-slate-800">{{ $client->name }}</h3>
                <div class="flex gap-2">
                    <a href="{{ route('clients.edit', $client) }}" class="text-amber-600 hover:text-amber-800" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline" onsubmit="return confirm('Delete this client?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            <p class="text-slate-600 text-sm mb-3"><i class="fas fa-phone text-blue-500 mr-2"></i>{{ $client->phone }}</p>
            <div class="flex justify-between items-center">
                <span class="text-xs text-slate-500"><i class="fas fa-car text-blue-500 mr-1"></i>{{ $client->vehicles->count() }} Vehicles</span>
                <a href="{{ route('clients.show', $client) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View Details →</a>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-lg shadow-md border border-slate-100 p-8 text-center">
            <i class="fas fa-inbox text-4xl text-slate-300 mb-3 block"></i>
            <p class="text-slate-500">No clients found</p>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $clients->links() }}
</div>
@endsection
