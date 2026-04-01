@extends('layouts.app')

@section('title', 'Receipt - ' . $receipt->receipt_number)

@section('content')
@php
    $payment = $receipt->payment;
    $invoice = $payment->invoice;
    $job = $invoice->job;
    $client = $job->client;
    $items = $invoice->items;

    // Calculate financial values
    $subtotal = $items->sum('total_price');
    $total = $subtotal;
    $totalPaid = $invoice->payments->sum('amount_paid');
    $balanceRemaining = max(0, $total - $totalPaid);
@endphp

<style>
    .receipt-container {
        page-break-after: avoid;
        height: auto;
    }
    .action-buttons {
        margin-top: 1rem;
    }
    @media print {
        .action-buttons {
            display: none;
        }
    }
</style>

<div class="max-w-4xl mx-auto p-3 bg-white receipt-container">
    <!-- Header Section -->
    <div class="flex justify-between items-start mb-3 pb-2 border-b-2 border-gray-300">
        <div>
            <p class="text-xl font-bold text-blue-900">KM AUTOMOBILE</p>
            <p class="text-xs text-gray-700">Kampala, Uganda</p>
        </div>
        <div class="text-right">
            <div class="w-16 h-12 border-2 border-dashed border-gray-400 flex items-center justify-center text-xs text-gray-500">Logo</div>
            <p class="text-xs text-gray-700 font-semibold mt-1">+256 768 123 456</p>
            <p class="text-xs text-gray-700">info@km-automobile.com</p>
        </div>
    </div>

    <!-- Receipt Title -->
    <div class="text-center mb-2">
        <p class="text-3xl font-bold text-blue-900">RECEIPT</p>
    </div>

    <!-- Receipt Details (Right-aligned single line) -->
    <div class="flex justify-end gap-6 mb-3 text-xs">
        <div><span class="font-semibold">Receipt #:</span> {{ $receipt->receipt_number }}</div>
        <div><span class="font-semibold">Date:</span> {{ $receipt->created_at->format('d/m/Y') }}</div>
        <div><span class="font-semibold">Invoice #:</span> {{ $invoice->invoice_number }}</div>
    </div>

    <!-- FROM / BILL TO Section -->
    <div class="grid grid-cols-2 gap-3 mb-3">
        <!-- FROM Section -->
        <div class="border-2 border-gray-300 bg-gray-50 p-2">
            <p class="text-xs font-bold text-gray-700 uppercase mb-1">From</p>
            <p class="font-semibold text-xs text-gray-900">KM-Automobile Garage</p>
            <p class="text-xs text-gray-700">Kampala, Uganda</p>
            <p class="text-xs text-gray-700">Phone: +256 768 123 456</p>
            <p class="text-xs text-gray-700">Email: info@km-automobile.com</p>
        </div>

        <!-- BILL TO Section -->
        <div class="border-2 border-gray-300 bg-gray-50 p-2">
            <p class="text-xs font-bold text-gray-700 uppercase mb-1">Bill To</p>
            <p class="font-semibold text-xs text-gray-900">{{ $client->name }}</p>
            <p class="text-xs text-gray-700">Phone: {{ $client->phone }}</p>
            <p class="text-xs text-gray-700">Vehicle: {{ $job->vehicle->car_model ?? 'N/A' }}</p>
            <p class="text-xs text-gray-700">Plate: {{ $job->vehicle->number_plate ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Items/Services Table -->
    <table class="w-full mb-3 text-xs border-collapse">
        <thead>
            <tr class="border-b-2 border-gray-400 bg-gray-50">
                <th class="text-left py-1 px-1 font-bold text-gray-700 w-8">QTY</th>
                <th class="text-left py-1 px-1 font-bold text-gray-700 flex-1">DESCRIPTION</th>
                <th class="text-right py-1 px-1 font-bold text-gray-700 w-20">UNIT PRICE</th>
                <th class="text-right py-1 px-1 font-bold text-gray-700 w-20">AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $index => $item)
                <tr class="border-b border-gray-200 {{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                    <td class="py-1 px-1 text-center">{{ $item->quantity }}</td>
                    <td class="py-1 px-1">{{ $item->item_name }} - {{ $item->description ?? 'Service' }}</td>
                    <td class="py-1 px-1 text-right">UGX {{ number_format($item->unit_price, 2) }}</td>
                    <td class="py-1 px-1 text-right">UGX {{ number_format($item->total_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals Section (Right-aligned) -->
    <div class="flex justify-end mb-2">
        <div class="w-48 text-xs">
            <div class="flex justify-between py-0.5 border-b border-gray-300">
                <span>Subtotal:</span>
                <span>UGX {{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between py-1 px-1 bg-blue-900 text-white font-bold">
                <span>Total:</span>
                <span>UGX {{ number_format($total, 2) }}</span>
            </div>
            <div class="flex justify-between py-0.5 border-b border-gray-300 mt-1">
                <span>Amount Paid:</span>
                <span class="text-green-600 font-semibold">UGX {{ number_format($totalPaid, 2) }}</span>
            </div>
            <div class="flex justify-between py-0.5 font-bold">
                <span>Balance Remaining:</span>
                <span class="text-red-600">UGX {{ number_format($balanceRemaining, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Payment Details (One Line) -->
    <div class="flex justify-end gap-4 text-xs mb-2 pb-2 border-b-2 border-gray-300">
        <span><span class="font-semibold">Payment Method:</span> {{ $payment->payment_method }}</span>
        <span><span class="font-semibold">Status:</span> 
            @if($balanceRemaining > 0)
                <span class="text-orange-600 font-semibold">Partial Payment</span>
            @else
                <span class="text-green-600 font-semibold">Paid in Full</span>
            @endif
        </span>
    </div>

    <!-- Terms and Conditions -->
    <div class="bg-gray-50 border-2 border-gray-300 p-2 mb-2 text-xs text-gray-700">
        <p class="font-bold text-gray-900 mb-1">TERMS AND CONDITIONS</p>
        <ul class="text-xs space-y-0.5 list-disc list-inside">
            <li>Payment is due within 14 days of project completion.</li>
            <li>All checks to be made out to KM Automobile.</li>
        </ul>
    </div>

    <!-- Thank You Message -->
    <div class="text-center text-xs font-semibold text-gray-800 mb-2">
        Thank you for your business!
    </div>

    <!-- Footer Contact Details (Centered) -->
    <div class="text-center text-xs text-gray-700 py-2 border-t-2 border-gray-300">
        <p>Phone: +256 768 123 456 | Email: info@km-automobile.com | Website: www.km-automobile.com</p>
    </div>

    <!-- Action Buttons -->
    <div class="mt-4 flex gap-4 justify-center action-buttons">
        <a href="{{ route('receipts.pdf', $receipt) }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-semibold">Download PDF</a>
        <a href="{{ route('receipts.index') }}" class="inline-block bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 font-semibold">Back to Receipts</a>
    </div>
</div>
@endsection
