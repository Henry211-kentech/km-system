@extends('layouts.app')

@section('title', 'Payment Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('payments.index') }}" class="text-blue-600 hover:underline">&larr; Back to Payments</a>
    <h1 class="text-3xl font-bold mt-2">Payment Details</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold mb-4">Payment Information</h2>
        <div class="space-y-3">
            <div>
                <p class="text-gray-600 text-sm">Invoice</p>
                <p class="font-semibold">{{ $payment->invoice->invoice_number }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Amount Paid</p>
                <p class="font-semibold text-lg text-green-600">UGX {{ number_format($payment->amount_paid, 2) }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Payment Method</p>
                <p class="font-semibold">{{ $payment->payment_method }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Date</p>
                <p class="font-semibold">{{ $payment->created_at->format('M d, Y - H:i') }}</p>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t space-x-2">
            <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:underline">Delete Payment</button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold mb-4">Invoice Summary</h2>
        <div class="space-y-3">
            <div>
                <p class="text-gray-600 text-sm">Client</p>
                <p class="font-semibold">{{ $payment->invoice->job->client->name }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Job</p>
                <p class="font-semibold">{{ $payment->invoice->job->job_number }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Invoice Total</p>
                <p class="font-semibold">UGX {{ number_format($payment->invoice->total_amount, 2) }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Total Paid</p>
                <p class="font-semibold">UGX {{ number_format($payment->invoice->payments->sum('amount_paid'), 2) }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Outstanding</p>
                <p class="font-semibold text-red-600">UGX {{ number_format($payment->invoice->total_amount - $payment->invoice->payments->sum('amount_paid'), 2) }}</p>
            </div>
            <div class="pt-2 border-t">
                <p class="text-gray-600 text-sm">Status</p>
                <p><span class="text-xs px-2 py-1 rounded {{ $payment->invoice->status === 'Paid' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">{{ $payment->invoice->status }}</span></p>
            </div>
        </div>

        @if($payment->receipt)
            <div class="mt-6 pt-4 border-t">
                <p class="text-green-600 font-semibold mb-2">✓ Receipt Generated</p>
                <p class="text-sm text-gray-600 mb-3">{{ $payment->receipt->receipt_number }}</p>
                <a href="{{ route('receipts.show', $payment->receipt) }}" class="text-blue-600 hover:underline">View Receipt</a>
            </div>
        @else
            <div class="mt-6 pt-4 border-t">
                <form action="{{ route('receipts.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Generate Receipt</button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
