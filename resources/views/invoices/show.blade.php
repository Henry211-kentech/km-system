@extends('layouts.app')

@section('title', $invoice->invoice_number)

@section('content')
<div class="mb-6">
    <a href="{{ route('invoices.index') }}" class="text-blue-600 hover:underline">&larr; Back to Invoices</a>
    <h1 class="text-3xl font-bold mt-2">{{ $invoice->invoice_number }}</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-bold mb-4">Invoice Details</h2>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-gray-600 text-sm">Job</p>
                    <p class="font-semibold">{{ $invoice->job->job_number }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Client</p>
                    <p class="font-semibold">{{ $invoice->job->client->name }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Vehicle</p>
                    <p class="font-semibold">{{ $invoice->job->vehicle->car_model }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Date</p>
                    <p class="font-semibold">{{ $invoice->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-bold mb-4">Items</h2>
            <table class="w-full text-sm">
                <thead class="border-b">
                    <tr>
                        <th class="text-left py-2">Item</th>
                        <th class="text-center py-2">Qty</th>
                        <th class="text-right py-2">Unit Price</th>
                        <th class="text-right py-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->items as $item)
                        <tr class="border-b">
                            <td class="py-2">{{ $item->item_name }}</td>
                            <td class="text-center py-2">{{ $item->quantity }}</td>
                            <td class="text-right py-2">UGX {{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-right py-2">UGX {{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold mb-4">Payments</h2>
            @if($invoice->payments->count() > 0)
                <table class="w-full text-sm">
                    <thead class="border-b">
                        <tr>
                            <th class="text-left py-2">Date</th>
                            <th class="text-left py-2">Method</th>
                            <th class="text-right py-2">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->payments as $payment)
                            <tr class="border-b">
                                <td class="py-2">{{ $payment->created_at->format('M d, Y') }}</td>
                                <td class="py-2">{{ $payment->payment_method }}</td>
                                <td class="text-right py-2">UGX {{ number_format($payment->amount_paid, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500">No payments yet</p>
            @endif
        </div>
    </div>

    <div>
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-bold mb-4">Summary</h2>
            <div class="space-y-3 mb-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Grand Total</span>
                    <span class="font-bold">UGX {{ number_format($invoice->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Paid</span>
                    <span class="font-bold">UGX {{ number_format($invoice->payments->sum('amount_paid'), 2) }}</span>
                </div>
                <div class="flex justify-between border-t pt-2">
                    <span class="text-gray-600">Outstanding</span>
                    <span class="font-bold">UGX {{ number_format($invoice->total_amount - $invoice->payments->sum('amount_paid'), 2) }}</span>
                </div>
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-1">Status</p>
                <p><span class="text-xs px-2 py-1 rounded {{ $invoice->status === 'Paid' ? 'bg-green-100 text-green-800' : ($invoice->status === 'Partially Paid' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">{{ $invoice->status }}</span></p>
            </div>

            <div class="space-y-2">
                <a href="{{ route('invoices.pdf', $invoice) }}" class="block text-center bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Download PDF</a>
                @if($invoice->status !== 'Paid')
                    <a href="{{ route('payments.create') }}?invoice_id={{ $invoice->id }}" class="block text-center bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Add Payment</a>
                @endif
                <a href="{{ route('invoices.edit', $invoice) }}" class="block text-center bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Edit</a>
            </div>
        </div>
    </div>
</div>
@endsection
