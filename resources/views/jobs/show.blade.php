@extends('layouts.app')

@section('title', $job->job_number)

@section('content')
<div class="mb-6">
    <a href="{{ route('jobs.index') }}" class="text-blue-600 hover:underline">&larr; Back to Jobs</a>
    <h1 class="text-3xl font-bold mt-2">{{ $job->job_number }}</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2 bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-bold mb-4">Job Details</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-sm">Client</p>
                <p class="font-semibold">{{ $job->client->name }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Vehicle</p>
                <p class="font-semibold">{{ $job->vehicle->car_model }} ({{ $job->vehicle->number_plate }})</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Mechanic</p>
                <p class="font-semibold">{{ $job->assigned_mechanic ?? 'Not assigned' }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Status</p>
                <p><span class="text-xs px-2 py-1 rounded {{ $job->status === 'Completed' ? 'bg-green-100 text-green-800' : ($job->status === 'In Progress' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">{{ $job->status }}</span></p>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <p class="text-gray-600 text-sm mb-2">Description</p>
            <p>{{ $job->description }}</p>
        </div>
        <div class="mt-4 space-x-2">
            <a href="{{ route('jobs.edit', $job) }}" class="text-yellow-600 hover:underline">Edit</a>
            <form action="{{ route('jobs.destroy', $job) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:underline">Delete</button>
            </form>
        </div>
    </div>

    <div>
        @if($job->invoice)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold mb-4">Invoice</h2>
                <p><strong>{{ $job->invoice->invoice_number }}</strong></p>
                <p class="text-sm text-gray-600">Total: UGX {{ $job->invoice->total_amount }}</p>
                <p><span class="text-xs px-2 py-1 rounded {{ $job->invoice->status === 'Paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $job->invoice->status }}</span></p>
                <a href="{{ route('invoices.show', $job->invoice) }}" class="block mt-4 text-blue-600 hover:underline">View Invoice</a>
            </div>
        @else
            <div class="bg-blue-50 rounded-lg shadow p-6">
                <p class="text-sm text-blue-700 mb-4">No invoice created yet</p>
                <a href="{{ route('invoices.create') }}" class="block text-blue-600 hover:underline">Create Invoice</a>
            </div>
        @endif
    </div>
</div>
@endsection
