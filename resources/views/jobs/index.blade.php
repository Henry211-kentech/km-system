@extends('layouts.app')

@section('title', 'Jobs')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Jobs</h1>
    <a href="{{ route('jobs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ New Job</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold">Job #</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Client</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Vehicle</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Description</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jobs as $job)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-semibold">{{ $job->job_number }}</td>
                    <td class="px-6 py-4">{{ $job->client->name }}</td>
                    <td class="px-6 py-4">{{ $job->vehicle->car_model }}</td>
                    <td class="px-6 py-4 text-sm">{{ Str::limit($job->description, 30) }}</td>
                    <td class="px-6 py-4">
                        <span class="text-xs px-2 py-1 rounded {{ $job->status === 'Completed' ? 'bg-green-100 text-green-800' : ($job->status === 'In Progress' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ $job->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('jobs.show', $job) }}" class="text-blue-600 hover:underline">View</a>
                        <a href="{{ route('jobs.edit', $job) }}" class="text-yellow-600 hover:underline">Edit</a>
                        <form action="{{ route('jobs.destroy', $job) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No jobs found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $jobs->links() }}
</div>
@endsection
