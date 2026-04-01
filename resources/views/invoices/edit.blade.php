@extends('layouts.app')

@section('title', 'Edit Invoice')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold">Edit Invoice</h1>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('invoices.update', $invoice) }}" method="POST" id="invoiceForm">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <p class="text-sm text-gray-600">Job: <strong>{{ $invoice->job->job_number }}</strong></p>
        </div>

        <h2 class="text-lg font-bold mb-4">Invoice Items</h2>
        
        <div id="items-container" class="mb-6 space-y-4">
            @foreach($invoice->items as $index => $item)
                <div class="item-row grid grid-cols-4 gap-2">
                    <input type="text" name="items[{{ $index }}][item_name]" value="{{ $item->item_name }}" placeholder="Item Name" class="px-4 py-2 border rounded" required>
                    <input type="number" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}" placeholder="Qty" class="px-4 py-2 border rounded" required>
                    <input type="number" name="items[{{ $index }}][unit_price]" value="{{ $item->unit_price }}" placeholder="Unit Price" class="px-4 py-2 border rounded" step="0.01" required>
                    <button type="button" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 remove-item">Remove</button>
                </div>
            @endforeach
        </div>

        <button type="button" id="addItem" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mb-6">+ Add Item</button>

        <div class="bg-gray-100 p-4 rounded mb-6">
            <p class="text-lg font-bold">Total Amount: <span id="totalAmount">{{ number_format($invoice->total_amount, 2) }}</span> Ksh</p>
        </div>

        <div class="flex space-x-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Invoice</button>
            <a href="{{ route('invoices.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</a>
        </div>
    </form>
</div>

<script>
let itemCount = {{ count($invoice->items) }};

document.getElementById('addItem').addEventListener('click', function() {
    const container = document.getElementById('items-container');
    const newRow = document.createElement('div');
    newRow.className = 'item-row grid grid-cols-4 gap-2';
    newRow.innerHTML = `
        <input type="text" name="items[${itemCount}][item_name]" placeholder="Item Name" class="px-4 py-2 border rounded" required>
        <input type="number" name="items[${itemCount}][quantity]" placeholder="Qty" class="px-4 py-2 border rounded" value="1" required>
        <input type="number" name="items[${itemCount}][unit_price]" placeholder="Unit Price" class="px-4 py-2 border rounded" step="0.01" required>
        <button type="button" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 remove-item">Remove</button>
    `;
    container.appendChild(newRow);
    itemCount++;
    attachRemoveListeners();
    attachPriceListeners();
});

function attachRemoveListeners() {
    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.addEventListener('click', function() {
            if (document.querySelectorAll('.item-row').length > 1) {
                this.parentElement.remove();
                calculateTotal();
            } else {
                alert('At least one item is required');
            }
        });
    });
}

function attachPriceListeners() {
    document.querySelectorAll('input[name*="[quantity]"], input[name*="[unit_price]"]').forEach(input => {
        input.addEventListener('change', calculateTotal);
    });
}

function calculateTotal() {
    let total = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const qty = parseFloat(row.querySelector('input[name*="[quantity]"]').value) || 0;
        const price = parseFloat(row.querySelector('input[name*="[unit_price]"]').value) || 0;
        total += qty * price;
    });
    document.getElementById('totalAmount').textContent = total.toFixed(2);
}

attachRemoveListeners();
attachPriceListeners();
</script>
@endsection
