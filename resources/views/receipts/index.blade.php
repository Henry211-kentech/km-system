@extends('layouts.app')

@section('title', 'Receipts')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Receipts</h1>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold">Receipt #</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Invoice #</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Client</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Amount Paid</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Date</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($receipts as $receipt)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-semibold">{{ $receipt->receipt_number }}</td>
                    <td class="px-6 py-4">{{ $receipt->payment->invoice->invoice_number }}</td>
                    <td class="px-6 py-4">{{ $receipt->payment->invoice->job->client->name }}</td>
                    <td class="px-6 py-4">UGX {{ number_format($receipt->payment->amount_paid, 2) }}</td>
                    <td class="px-6 py-4 text-sm">{{ $receipt->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('receipts.show', $receipt) }}" class="text-blue-600 hover:underline">View</a>
                        <a href="{{ route('receipts.pdf', $receipt) }}" class="text-purple-600 hover:underline">PDF</a>
                        <form action="{{ route('receipts.destroy', $receipt) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No receipts found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $receipts->links() }}
</div>
@endsection
