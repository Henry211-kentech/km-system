@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<!-- Header -->
<div class="mb-8">
    <a href="{{ route('users.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center gap-1 mb-3">
        <i class="fas fa-arrow-left"></i> Back to Users
    </a>
    <h1 class="text-3xl sm:text-4xl font-bold text-slate-800 flex items-center gap-2">
        <i class="fas fa-user-plus text-blue-600"></i> Create New User
    </h1>
    <p class="text-slate-600 mt-2">Add a new user to the system</p>
</div>

<!-- Form Card -->
<div class="bg-white rounded-xl shadow-md border border-slate-100 overflow-hidden max-w-2xl">
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
        <h2 class="text-lg font-bold text-white flex items-center gap-2">
            <i class="fas fa-form"></i> User Information
        </h2>
    </div>

    <form action="{{ route('users.store') }}" method="POST" class="p-6 sm:p-8">
        @csrf

        <!-- Name Field -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                <i class="fas fa-user text-blue-500"></i> Full Name
                <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                name="name"
                placeholder="e.g., John Doe"
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('name') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror"
                required
                value="{{ old('name') }}"
            >
            @error('name')
                <p class="text-red-600 text-sm mt-2 flex items-center gap-1">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Email Field -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                <i class="fas fa-envelope text-blue-500"></i> Email Address
                <span class="text-red-500">*</span>
            </label>
            <input
                type="email"
                name="email"
                placeholder="e.g., john@example.com"
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('email') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror"
                required
                value="{{ old('email') }}"
            >
            @error('email')
                <p class="text-red-600 text-sm mt-2 flex items-center gap-1">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password Field -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                <i class="fas fa-lock text-blue-500"></i> Password
                <span class="text-red-500">*</span>
            </label>
            <input
                type="password"
                name="password"
                placeholder="Enter a secure password"
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('password') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror"
                required
            >
            @error('password')
                <p class="text-red-600 text-sm mt-2 flex items-center gap-1">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Confirm Password Field -->
        <div class="mb-8">
            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                <i class="fas fa-lock text-blue-500"></i> Confirm Password
                <span class="text-red-500">*</span>
            </label>
            <input
                type="password"
                name="password_confirmation"
                placeholder="Confirm your password"
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('password_confirmation') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror"
                required
            >
            @error('password_confirmation')
                <p class="text-red-600 text-sm mt-2 flex items-center gap-1">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-slate-200">
            <button
                type="submit"
                class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:shadow-lg transition font-medium flex items-center justify-center gap-2"
            >
                <i class="fas fa-check"></i> Create User
            </button>
            <a
                href="{{ route('users.index') }}"
                class="flex-1 bg-slate-200 text-slate-700 px-6 py-3 rounded-lg hover:bg-slate-300 transition font-medium flex items-center justify-center gap-2"
            >
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection