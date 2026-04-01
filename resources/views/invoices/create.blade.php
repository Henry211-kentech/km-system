@extends('layouts.app')

@section('title', 'Create Invoice')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold">Create New Invoice</h1>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm">
        @csrf
        
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Job</label>
            <select name="job_id" class="w-full px-4 py-2 border rounded @error('job_id') border-red-500 @enderror" required>
                <option value="">Select a job</option>
                @foreach($jobs as $job)
                    <option value="{{ $job->id }}">{{ $job->job_number }} - {{ $job->client->name }} ({{ $job->vehicle->car_model }})</option>
                @endforeach
            </select>
            @error('job_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <h2 class="text-lg font-bold mb-4">Invoice Items</h2>
        
        <div id="items-container" class="mb-6 space-y-4">
            <div class="item-row grid grid-cols-4 gap-2">
                <input type="text" name="items[0][item_name]" placeholder="Item Name" class="px-4 py-2 border rounded @error('items.0.item_name') border-red-500 @enderror" required>
                <input type="number" name="items[0][quantity]" placeholder="Qty" class="px-4 py-2 border rounded @error('items.0.quantity') border-red-500 @enderror" value="1" required>
                <input type="number" name="items[0][unit_price]" placeholder="Unit Price" class="px-4 py-2 border rounded @error('items.0.unit_price') border-red-500 @enderror" step="0.01" required>
                <button type="button" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 remove-item">Remove</button>
            </div>
        </div>

        <button type="button" id="addItem" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mb-6">+ Add Item</button>

        <div class="bg-gray-100 p-4 rounded mb-6">
            <p class="text-lg font-bold">Total Amount: UGX <span id="totalAmount">0.00</span></p>
        </div>

        <div class="flex space-x-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create Invoice</button>
            <a href="{{ route('invoices.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</a>
        </div>
    </form>
</div>

<script>
let itemCount = 1;

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
    document.getElementById('totalAmount').textContent = 'UGX ' + total.toFixed(2);
}

attachRemoveListeners();
attachPriceListeners();
</script>
@endsection
