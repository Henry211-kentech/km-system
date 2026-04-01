@extends('layouts.app')

@section('title', 'Edit Job')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold">Edit Job</h1>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('jobs.update', $job) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Client</label>
            <select name="client_id" class="w-full px-4 py-2 border rounded @error('client_id') border-red-500 @enderror" required>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ $job->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                @endforeach
            </select>
            @error('client_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Vehicle</label>
            <select name="vehicle_id" class="w-full px-4 py-2 border rounded @error('vehicle_id') border-red-500 @enderror" required>
                @foreach($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}" {{ $job->vehicle_id == $vehicle->id ? 'selected' : '' }}>{{ $vehicle->car_model }} ({{ $vehicle->number_plate }})</option>
                @endforeach
            </select>
            @error('vehicle_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Description</label>
            <textarea name="description" class="w-full px-4 py-2 border rounded @error('description') border-red-500 @enderror" required rows="4">{{ $job->description }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Assigned Mechanic</label>
            <input type="text" name="assigned_mechanic" value="{{ $job->assigned_mechanic }}" class="w-full px-4 py-2 border rounded @error('assigned_mechanic') border-red-500 @enderror">
            @error('assigned_mechanic')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Status</label>
            <select name="status" class="w-full px-4 py-2 border rounded @error('status') border-red-500 @enderror" required>
                <option value="Pending" {{ $job->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="In Progress" {{ $job->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                <option value="Completed" {{ $job->status === 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
            @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex space-x-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Job</button>
            <a href="{{ route('jobs.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</a>
        </div>
    </form>
</div>
@endsection
