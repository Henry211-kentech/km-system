@extends('layouts.app')

@section('title', 'Create Vehicle')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold">Create New Vehicle</h1>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('vehicles.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Client</label>
            <select name="client_id" class="w-full px-4 py-2 border rounded @error('client_id') border-red-500 @enderror" required>
                <option value="">Select a client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
            @error('client_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Car Model</label>
            <input type="text" name="car_model" class="w-full px-4 py-2 border rounded @error('car_model') border-red-500 @enderror" required placeholder="e.g., Toyota Camry">
            @error('car_model')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Number Plate</label>
            <input type="text" name="number_plate" class="w-full px-4 py-2 border rounded @error('number_plate') border-red-500 @enderror" required placeholder="e.g., KEN-123-A">
            @error('number_plate')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex space-x-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create Vehicle</button>
            <a href="{{ route('vehicles.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</a>
        </div>
    </form>
</div>
@endsection
