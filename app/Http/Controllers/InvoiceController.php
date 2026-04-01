<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Job;
use App\Services\LoggingService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('job', 'items')->paginate(15);
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $jobs = Job::whereDoesntHave('invoice')->with('client', 'vehicle')->get();
        return view('invoices.create', compact('jobs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_id' => 'required|exists:garage_jobs,id|unique:garage_invoices,garage_job_id',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        // Calculate total amount
        $totalAmount = 0;
        foreach ($validated['items'] as $item) {
            $totalAmount += $item['quantity'] * $item['unit_price'];
        }

        // Generate invoice number
        $lastInvoice = Invoice::orderBy('id', 'desc')->first();
        $invoiceNumber = 'INV-' . str_pad((($lastInvoice?->id ?? 0) + 1), 4, '0', STR_PAD_LEFT);

        // Create invoice
        $invoice = Invoice::create([
            'garage_job_id' => $validated['job_id'],
            'invoice_number' => $invoiceNumber,
            'total_amount' => $totalAmount,
            'status' => 'Unpaid',
        ]);

        // Create invoice items
        foreach ($validated['items'] as $item) {
            InvoiceItem::create([
                'garage_invoice_id' => $invoice->id,
                'item_name' => $item['item_name'],
                'quantity' => (int) $item['quantity'],
                'unit_price' => (float) $item['unit_price'],
                'total_price' => (float) ($item['quantity'] * $item['unit_price']),
            ]);
        }

        return redirect()->route('invoices.show', $invoice)->with('success', 'Invoice created successfully!');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('job.client', 'job.vehicle', 'items', 'payments');
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $invoice->load('items');
        $jobs = Job::with('client', 'vehicle')->get();
        return view('invoices.edit', compact('invoice', 'jobs'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        // Calculate total amount
        $totalAmount = 0;
        foreach ($validated['items'] as $item) {
            $totalAmount += $item['quantity'] * $item['unit_price'];
        }

        $invoice->update(['total_amount' => $totalAmount]);

        // Delete old items and create new ones
        $invoice->items()->delete();
        foreach ($validated['items'] as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_name' => $item['item_name'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        return redirect()->route('invoices.show', $invoice)->with('success', 'Invoice updated successfully!');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully!');
    }

    public function pdf(Invoice $invoice)
    {
        $invoice->load('job.client', 'job.vehicle', 'items');
        
        // Log the PDF download
        LoggingService::logDownload(
            'Invoice',
            $invoice->id,
            "Invoice PDF downloaded: {$invoice->invoice_number}"
        );

        try {
            \PDF::setOptions(['isRemoteEnabled' => true]);
            $pdf = \PDF::loadView('invoices.pdf', compact('invoice'));
            return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['pdf' => 'PDF generation failed. Please install/enable PHP GD extension and restart Apache.']);
        }
    }
}
