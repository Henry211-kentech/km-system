@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Invoices</h1>
    <a href="{{ route('invoices.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ New Invoice</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold">Invoice #</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Job</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Client</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Amount</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoices as $invoice)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-semibold">{{ $invoice->invoice_number }}</td>
                    <td class="px-6 py-4">{{ $invoice->job->job_number }}</td>
                    <td class="px-6 py-4">{{ $invoice->job->client->name }}</td>
                    <td class="px-6 py-4">UGX {{ number_format($invoice->total_amount, 2) }}</td>
                    <td class="px-6 py-4">
                        <span class="text-xs px-2 py-1 rounded {{ $invoice->status === 'Paid' ? 'bg-green-100 text-green-800' : ($invoice->status === 'Partially Paid' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                            {{ $invoice->status }}
                        </span>
                    </td>
                    ...
<td class="px-6 py-4 space-x-2">
    <a href="{{ route('invoices.show', $invoice) }}" class="text-blue-600 hover:underline">View</a>
    <a href="{{ route('invoices.pdf', $invoice) }}" class="text-purple-600 hover:underline">PDF</a>
    <a href="{{ route('invoices.edit', $invoice) }}" class="text-yellow-600 hover:underline">Edit</a>
    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:underline">Delete</button>
    </form>
</td>
...
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No invoices found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $invoices->links() }}
</div>
@endsection
