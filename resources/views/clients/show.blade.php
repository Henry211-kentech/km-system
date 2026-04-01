@extends('layouts.app')

@section('title', $client->name)

@section('content')
<!-- Header -->
<div class="mb-8">
    <a href="{{ route('clients.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center gap-1 mb-3">
        <i class="fas fa-arrow-left"></i> Back to Clients
    </a>
    <h1 class="text-3xl sm:text-4xl font-bold text-slate-800 flex items-center gap-2">
        <i class="fas fa-user-circle text-blue-600"></i> {{ $client->name }}
    </h1>
    <p class="text-slate-600 mt-2">Manage customer information and related items</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Client Details Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-md border border-slate-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fas fa-info-circle"></i> Client Details
                </h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="bg-slate-50 rounded-lg p-4">
                    <p class="text-xs text-slate-600 uppercase tracking-wide font-semibold">Full Name</p>
                    <p class="text-xl font-bold text-slate-800 mt-1">{{ $client->name }}</p>
                </div>
                <div class="bg-slate-50 rounded-lg p-4">
                    <p class="text-xs text-slate-600 uppercase tracking-wide font-semibold">Phone Number</p>
                    <p class="text-lg font-semibold text-slate-800 mt-1 flex items-center gap-2">
                        <i class="fas fa-phone text-blue-500"></i> {{ $client->phone }}
                    </p>
                </div>
                <div class="bg-slate-50 rounded-lg p-4">
                    <p class="text-xs text-slate-600 uppercase tracking-wide font-semibold">Member Since</p>
                    <p class="text-lg font-semibold text-slate-800 mt-1">
                        <i class="fas fa-calendar text-blue-500 mr-2"></i> {{ $client->created_at->format('M d, Y') }}
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 pt-4 border-t border-slate-200">
                    <a 
                        href="{{ route('clients.edit', $client) }}" 
                        class="flex-1 bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 transition font-medium flex items-center justify-center gap-2 text-sm"
                    >
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form 
                        action="{{ route('clients.destroy', $client) }}" 
                        method="POST" 
                        class="flex-1"
                        onsubmit="return confirm('Are you sure you want to delete this client and all related data?')"
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
        <!-- Vehicles Section -->
        <div class="bg-white rounded-xl shadow-md border border-slate-100 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4 flex justify-between items-center">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fas fa-car"></i> Vehicles ({{ $client->vehicles->count() }})
                </h2>
                <a 
                    href="{{ route('vehicles.create') }}" 
                    class="bg-white text-green-600 px-3 py-1 rounded-lg hover:bg-green-50 transition text-sm font-medium flex items-center gap-1"
                >
                    <i class="fas fa-plus"></i> Add
                </a>
            </div>
            <div class="p-6">
                @forelse($client->vehicles as $vehicle)
                    <div class="bg-gradient-to-r from-green-50 to-green-50 border border-green-200 rounded-lg p-4 mb-4 last:mb-0 hover:shadow-md transition">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="text-lg font-bold text-slate-800">{{ $vehicle->car_model }}</p>
                                <p class="text-slate-600 flex items-center gap-2 mt-1">
                                    <i class="fas fa-id-badge text-green-600"></i> {{ $vehicle->number_plate }}
                                </p>
                            </div>
                            <a 
                                href="{{ route('vehicles.show', $vehicle) }}" 
                                class="text-green-600 hover:text-green-800 font-medium text-sm py-1 px-3 bg-green-100 rounded hover:bg-green-200 transition"
                            >
                                <i class="fas fa-eye"></i> View
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-slate-500">
                        <i class="fas fa-car text-4xl opacity-20 mb-2 block"></i>
                        <p>No vehicles added yet</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Jobs Section -->
        <div class="bg-white rounded-xl shadow-md border border-slate-100 overflow-hidden">
            <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-4 flex justify-between items-center">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fas fa-tools"></i> Jobs ({{ $client->jobs->count() }})
                </h2>
                <a 
                    href="{{ route('jobs.create') }}" 
                    class="bg-white text-amber-600 px-3 py-1 rounded-lg hover:bg-amber-50 transition text-sm font-medium flex items-center gap-1"
                >
                    <i class="fas fa-plus"></i> New
                </a>
            </div>
            <div class="p-6">
                @forelse($client->jobs as $job)
                    <div class="bg-gradient-to-r from-amber-50 to-amber-50 border border-amber-200 rounded-lg p-4 mb-4 last:mb-0 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex-1">
                                <p class="text-lg font-bold text-slate-800">{{ $job->job_number }}</p>
                                <p class="text-slate-600 mt-1">{{ Str::limit($job->description, 60) }}</p>
                            </div>
                            <span class="text-xs px-3 py-1 rounded-full font-medium
                                {{ $job->status === 'Completed' ? 'bg-green-100 text-green-700' : ($job->status === 'In Progress' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ $job->status }}
                            </span>
                        </div>
                        <a 
                            href="{{ route('jobs.show', $job) }}" 
                            class="text-amber-600 hover:text-amber-800 font-medium text-sm inline-flex items-center gap-1"
                        >
                            <i class="fas fa-arrow-right"></i> View Details
                        </a>
                    </div>
                @empty
                    <div class="text-center py-8 text-slate-500">
                        <i class="fas fa-tools text-4xl opacity-20 mb-2 block"></i>
                        <p>No jobs created yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
