<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Payment;
use App\Services\LoggingService;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function index()
    {
        $receipts = Receipt::with('payment.invoice')->paginate(15);
        return view('receipts.index', compact('receipts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_id' => 'required|exists:garage_payments,id|unique:garage_receipts,garage_payment_id',
        ]);

        $payment = Payment::find($validated['payment_id']);

        // Generate receipt number
        $lastReceipt = Receipt::orderBy('id', 'desc')->first();
        $receiptNumber = 'RCPT-' . str_pad((($lastReceipt?->id ?? 0) + 1), 4, '0', STR_PAD_LEFT);

        $receipt = Receipt::create([
            'garage_payment_id' => $validated['payment_id'],
            'receipt_number' => $receiptNumber,
        ]);

        return redirect()->route('receipts.index')->with('success', 'Receipt created successfully!');
    }

    public function show(Receipt $receipt)
    {
        $receipt->load('payment.invoice.job.client', 'payment.invoice.items', 'payment.invoice.payments');
        return view('receipts.show', compact('receipt'));
    }

    public function destroy(Receipt $receipt)
    {
        $receipt->delete();
        return redirect()->route('receipts.index')->with('success', 'Receipt deleted successfully!');
    }

    public function pdf(Receipt $receipt)
    {
        $receipt->load('payment.invoice.job.client', 'payment.invoice.items', 'payment.invoice.payments');
        
        // Log the PDF download
        LoggingService::logDownload(
            'Receipt',
            $receipt->id,
            "Receipt PDF downloaded: {$receipt->receipt_number}"
        );

        try {
            \PDF::setOptions(['isRemoteEnabled' => true]);
            $pdf = \PDF::loadView('receipts.pdf', compact('receipt'));
            return $pdf->download('receipt-' . $receipt->receipt_number . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['pdf' => 'PDF generation failed. Please install/enable PHP GD extension and restart Apache.']);
        }
    }
}
