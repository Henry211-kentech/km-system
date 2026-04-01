@extends('layouts.app')

@section('title', 'Users')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl sm:text-4xl font-bold text-slate-800 flex items-center gap-2">
            <i class="fas fa-user-shield text-blue-600"></i> Users
        </h1>
        <p class="text-slate-600 mt-1">Manage system users</p>
    </div>
    <a href="{{ route('users.create') }}" class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:shadow-lg transition flex items-center justify-center gap-2 font-medium">
        <i class="fas fa-plus"></i> New User
    </a>
</div>

<!-- Desktop Table View -->
<div class="hidden md:block bg-white rounded-xl shadow-md border border-slate-100 overflow-hidden">
    <table class="w-full">
        <thead class="bg-gradient-to-r from-slate-100 to-slate-50 border-b border-slate-200">
            <tr>
                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Name</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Email</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Created</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-slate-700">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                    <td class="px-6 py-4 font-medium text-slate-800">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-slate-600"><i class="fas fa-envelope text-blue-500 mr-2"></i>{{ $user->email }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('users.show', $user) }}" class="text-blue-600 hover:text-blue-800 transition font-medium text-sm" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('users.edit', $user) }}" class="text-amber-600 hover:text-amber-800 transition font-medium text-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
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
                            <p class="text-lg">No users found</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Mobile Card View -->
<div class="md:hidden space-y-4">
    @forelse($users as $user)
        <div class="bg-white rounded-lg shadow-md border border-slate-100 p-4 hover:shadow-lg transition">
            <div class="flex justify-between items-start mb-3">
                <h3 class="text-lg font-semibold text-slate-800">{{ $user->name }}</h3>
                <div class="flex gap-2">
                    <a href="{{ route('users.edit', $user) }}" class="text-amber-600 hover:text-amber-800" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            <p class="text-slate-600 text-sm mb-3"><i class="fas fa-envelope text-blue-500 mr-2"></i>{{ $user->email }}</p>
            <div class="flex justify-between items-center">
                <span class="text-xs text-slate-500">Created {{ $user->created_at->format('M d, Y') }}</span>
                <a href="{{ route('users.show', $user) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View Details →</a>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-lg shadow-md border border-slate-100 p-8 text-center">
            <i class="fas fa-inbox text-4xl text-slate-300 mb-3 block"></i>
            <p class="text-slate-500">No users found</p>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $users->links() }}
</div>
@endsection