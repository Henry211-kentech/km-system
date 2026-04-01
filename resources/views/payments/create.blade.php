@extends('layouts.app')

@section('title', 'Create Payment')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold">Record New Payment</h1>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('payments.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Invoice</label>
            <select name="invoice_id" id="invoice_id" class="w-full px-4 py-2 border rounded @error('invoice_id') border-red-500 @enderror" required onchange="updateInvoiceDetails()">
                <option value="">Select an unpaid invoice</option>
                @foreach($unpaidInvoices as $invoice)
                    <option value="{{ $invoice->id }}" data-total="{{ $invoice->total_amount }}" data-paid="{{ $invoice->payments->sum('amount_paid') }}">
                        {{ $invoice->invoice_number }} - {{ $invoice->job->client->name }} - UGX {{ number_format($invoice->total_amount - $invoice->payments->sum('amount_paid'), 2) }} outstanding
                    </option>
                @endforeach
            </select>
            @error('invoice_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="bg-blue-50 p-4 rounded mb-4" id="invoiceInfo" style="display:none;">
            <p class="text-sm"><strong>Invoice Total:</strong> <span id="invoiceTotal">0.00</span> UGX</p>
            <p class="text-sm"><strong>Total Paid:</strong> <span id="invoicePaid">0.00</span> UGX</p>
            <p class="text-sm"><strong>Outstanding:</strong> <span id="invoiceOutstanding">0.00</span> UGX</p>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Amount Paid</label>
            <input type="number" name="amount_paid" id="amount_paid" class="w-full px-4 py-2 border rounded @error('amount_paid') border-red-500 @enderror" step="0.01" required placeholder="0.00">
            @error('amount_paid')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Payment Method</label>
            <select name="payment_method" class="w-full px-4 py-2 border rounded @error('payment_method') border-red-500 @enderror" required>
                <option value="">Select payment method</option>
                <option value="Cash">Cash</option>
                <option value="Cheque">Cheque</option>
                <option value="Mobile Money">Mobile Money</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="Card">Card</option>
            </select>
            @error('payment_method')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex space-x-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Record Payment</button>
            <a href="{{ route('payments.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</a>
        </div>
    </form>
</div>

<script>
function updateInvoiceDetails() {
    const select = document.getElementById('invoice_id');
    const option = select.options[select.selectedIndex];
    
    if (option.value) {
        const total = parseFloat(option.dataset.total);
        const paid = parseFloat(option.dataset.paid);
        const outstanding = total - paid;
        
        document.getElementById('invoiceTotal').textContent = total.toFixed(2);
        document.getElementById('invoicePaid').textContent = paid.toFixed(2);
        document.getElementById('invoiceOutstanding').textContent = outstanding.toFixed(2);
        document.getElementById('invoiceInfo').style.display = 'block';
        document.getElementById('amount_paid').value = outstanding.toFixed(2);
    } else {
        document.getElementById('invoiceInfo').style.display = 'none';
    }
}
</script>
@endsection
