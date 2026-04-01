<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Services\LoggingService;

class InvoiceObserver
{
    public function created(Invoice $invoice): void
    {
        LoggingService::logCreate(
            'Invoice',
            $invoice->id,
            "New invoice created: {$invoice->invoice_number} - UGX {$invoice->total_amount}",
            $invoice->toArray()
        );
    }

    public function updated(Invoice $invoice): void
    {
        $changes = $invoice->getChanges();
        $statusChange = isset($changes['status']) ? " (Status: {$invoice->getOriginal('status')} → {$invoice->status})" : '';
        LoggingService::logUpdate(
            'Invoice',
            $invoice->id,
            "Invoice updated: {$invoice->invoice_number}{$statusChange}",
            $invoice->getOriginal(),
            $changes
        );
    }

    public function deleted(Invoice $invoice): void
    {
        LoggingService::logDelete(
            'Invoice',
            $invoice->id,
            "Invoice deleted: {$invoice->invoice_number}",
            $invoice->toArray()
        );
    }
}
