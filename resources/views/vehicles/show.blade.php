@extends('layouts.app')

@section('title', $vehicle->car_model)

@section('content')
<div class="mb-6">
    <a href="{{ route('vehicles.index') }}" class="text-blue-600 hover:underline">&larr; Back to Vehicles</a>
    <h1 class="text-3xl font-bold mt-2">{{ $vehicle->car_model }}</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-1 bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold mb-4">Vehicle Details</h2>
        <p><strong>Model:</strong> {{ $vehicle->car_model }}</p>
        <p><strong>Number Plate:</strong> {{ $vehicle->number_plate }}</p>
        <p><strong>Client:</strong> {{ $vehicle->client->name }}</p>
        <div class="mt-4 space-x-2">
            <a href="{{ route('vehicles.edit', $vehicle) }}" class="text-yellow-600 hover:underline">Edit</a>
            <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:underline">Delete</button>
            </form>
        </div>
    </div>

    <div class="md:col-span-2 bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold mb-4">Jobs</h2>
        <div class="space-y-3">
            @forelse($vehicle->jobs as $job)
                <div class="border p-4 rounded">
                    <p><strong>{{ $job->job_number }}</strong></p>
                    <p class="text-gray-600">{{ $job->description }}</p>
                    <p class="mt-2"><span class="text-xs px-2 py-1 rounded {{ $job->status === 'Completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ $job->status }}</span></p>
                    <a href="{{ route('jobs.show', $job) }}" class="text-blue-600 hover:underline text-sm">View Job</a>
                </div>
            @empty
                <p class="text-gray-500">No jobs for this vehicle</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
