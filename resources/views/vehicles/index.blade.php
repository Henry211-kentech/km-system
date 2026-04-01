@extends('layouts.app')

@section('title', 'Vehicles')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Vehicles</h1>
    <a href="{{ route('vehicles.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ New Vehicle</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold">Model</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Number Plate</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Client</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Jobs</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vehicles as $vehicle)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $vehicle->car_model }}</td>
                    <td class="px-6 py-4"><strong>{{ $vehicle->number_plate }}</strong></td>
                    <td class="px-6 py-4">{{ $vehicle->client->name }}</td>
                    <td class="px-6 py-4">{{ $vehicle->jobs->count() }}</td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('vehicles.show', $vehicle) }}" class="text-blue-600 hover:underline">View</a>
                        <a href="{{ route('vehicles.edit', $vehicle) }}" class="text-yellow-600 hover:underline">Edit</a>
                        <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No vehicles found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $vehicles->links() }}
</div>
@endsection
