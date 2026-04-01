@extends('layouts.app')

@section('title', 'Payments')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Payments</h1>
    <a href="{{ route('payments.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ New Payment</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold">Invoice #</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Client</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Amount Paid</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Method</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Date</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Receipt</th>
                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-semibold">{{ $payment->invoice->invoice_number }}</td>
                    <td class="px-6 py-4">{{ $payment->invoice->job->client->name }}</td>
                    <td class="px-6 py-4">UGX {{ number_format($payment->amount_paid, 2) }}</td>
                    <td class="px-6 py-4">{{ $payment->payment_method }}</td>
                    <td class="px-6 py-4 text-sm">{{ $payment->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        @if($payment->receipt)
                            <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-800">Created</span>
                        @else
                            <span class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-800">Pending</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('payments.show', $payment) }}" class="text-blue-600 hover:underline">View</a>
                        <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">No payments found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $payments->links() }}
</div>
@endsection
