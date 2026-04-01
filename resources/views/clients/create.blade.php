@extends('layouts.app')

@section('title', 'Create Client')

@section('content')
<!-- Header -->
<div class="mb-8">
    <a href="{{ route('clients.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center gap-1 mb-3">
        <i class="fas fa-arrow-left"></i> Back to Clients
    </a>
    <h1 class="text-3xl sm:text-4xl font-bold text-slate-800 flex items-center gap-2">
        <i class="fas fa-user-plus text-blue-600"></i> Create New Client
    </h1>
    <p class="text-slate-600 mt-2">Add a new customer to your garage</p>
</div>

<!-- Form Card -->
<div class="bg-white rounded-xl shadow-md border border-slate-100 overflow-hidden max-w-2xl">
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
        <h2 class="text-lg font-bold text-white flex items-center gap-2">
            <i class="fas fa-form"></i> Client Information
        </h2>
    </div>

    <form action="{{ route('clients.store') }}" method="POST" class="p-6 sm:p-8">
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

        <!-- Phone Field -->
        <div class="mb-8">
            <label class="block text-sm font-semibold text-slate-700 mb-2 flex items-center gap-2">
                <i class="fas fa-phone text-blue-500"></i> Phone Number
                <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                name="phone" 
                placeholder="e.g., +254712345678"
                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition @error('phone') border-red-500 focus:border-red-500 focus:ring-red-200 @enderror"
                required
                value="{{ old('phone') }}"
            >
            @error('phone')
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
                <i class="fas fa-check"></i> Create Client
            </button>
            <a 
                href="{{ route('clients.index') }}" 
                class="flex-1 bg-slate-200 text-slate-700 px-6 py-3 rounded-lg hover:bg-slate-300 transition font-medium flex items-center justify-center gap-2"
            >
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection
