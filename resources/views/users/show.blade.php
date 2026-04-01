@extends('layouts.app')

@section('title', $user->name)

@section('content')
<!-- Header -->
<div class="mb-8">
    <a href="{{ route('users.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center gap-1 mb-3">
        <i class="fas fa-arrow-left"></i> Back to Users
    </a>
    <h1 class="text-3xl sm:text-4xl font-bold text-slate-800 flex items-center gap-2">
        <i class="fas fa-user-circle text-blue-600"></i> {{ $user->name }}
    </h1>
    <p class="text-slate-600 mt-2">User account information</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- User Details Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-md border border-slate-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fas fa-info-circle"></i> User Details
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="bg-slate-50 rounded-lg p-4">
                    <p class="text-xs text-slate-600 uppercase tracking-wide font-semibold">Full Name</p>
                    <p class="text-xl font-bold text-slate-800 mt-1">{{ $user->name }}</p>
                </div>
                <div class="bg-slate-50 rounded-lg p-4">
                    <p class="text-xs text-slate-600 uppercase tracking-wide font-semibold">Email Address</p>
                    <p class="text-lg font-semibold text-slate-800 mt-1 flex items-center gap-2">
                        <i class="fas fa-envelope text-blue-500"></i> {{ $user->email }}
                    </p>
                </div>
                <div class="bg-slate-50 rounded-lg p-4">
                    <p class="text-xs text-slate-600 uppercase tracking-wide font-semibold">Member Since</p>
                    <p class="text-lg font-semibold text-slate-800 mt-1">
                        <i class="fas fa-calendar text-blue-500 mr-2"></i> {{ $user->created_at->format('M d, Y') }}
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 pt-4 border-t border-slate-200">
                    <a
                        href="{{ route('users.edit', $user) }}"
                        class="flex-1 bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition font-medium flex items-center justify-center gap-2 text-sm"
                    >
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form
                        action="{{ route('users.destroy', $user) }}"
                        method="POST"
                        class="flex-1"
                        onsubmit="return confirm('Are you sure you want to delete this user?')"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition font-medium flex items-center justify-center gap-2 text-sm"
                        >
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Activity Section -->
        <div class="bg-white rounded-xl shadow-md border border-slate-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fas fa-history"></i> Account Activity
                </h2>
            </div>
            <div class="p-6">
                <div class="text-center py-8 text-slate-500">
                    <i class="fas fa-clock text-4xl opacity-20 mb-2 block"></i>
                    <p>Activity tracking coming soon</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection