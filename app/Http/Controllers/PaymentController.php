<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Receipt;
use App\Services\LoggingService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('invoice', 'receipt')->paginate(15);
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $unpaidInvoices = Invoice::whereIn('status', ['Unpaid', 'Partially Paid'])->with('job')->get();
        return view('payments.create', compact('unpaidInvoices'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:garage_invoices,id',
            'amount_paid' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|max:255',
        ]);

        $invoice = Invoice::find($validated['invoice_id']);

        // Validate payment amount
        $totalPaid = $invoice->payments()->sum('amount_paid') + $validated['amount_paid'];
        if ($totalPaid > $invoice->total_amount) {
            return back()->withErrors(['amount_paid' => 'Payment exceeds invoice total amount.'])->withInput();
        }

        $payment = Payment::create([
            'garage_invoice_id' => $validated['invoice_id'],
            'amount_paid' => $validated['amount_paid'],
            'payment_method' => $validated['payment_method'],
        ]);

        // Log the payment creation
        LoggingService::logCreate(
            'Payment',
            $payment->id,
            "Payment of UGX {$validated['amount_paid']} created for invoice {$invoice->invoice_number}",
            $payment->toArray()
        );

        // Generate receipt number
        $lastReceipt = Receipt::orderBy('id', 'desc')->first();
        $receiptNumber = 'RCPT-' . str_pad((($lastReceipt?->id ?? 0) + 1), 4, '0', STR_PAD_LEFT);

        Receipt::create([
            'garage_payment_id' => $payment->id,
            'receipt_number' => $receiptNumber,
        ]);

        // Update invoice status
        $invoice->updateInvoiceStatus();

        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully!');
    }

    public function show(Payment $payment)
    {
        $payment->load('invoice.job', 'receipt');
        return view('payments.show', compact('payment'));
    }

    public function destroy(Payment $payment)
    {
        $invoice = $payment->invoice;
        
        // Log the payment deletion
        LoggingService::logDelete(
            'Payment',
            $payment->id,
            "Payment of UGX {$payment->amount_paid} deleted from invoice {$invoice->invoice_number}",
            $payment->toArray()
        );
        $payment->delete();

        // Update invoice status after payment removal
        $invoice->updateInvoiceStatus();

        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully!');
    }
}
