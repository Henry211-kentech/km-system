<?php

namespace App\Observers;

use App\Models\InvoiceItem;
use App\Services\LoggingService;

class InvoiceItemObserver
{
    public function created(InvoiceItem $item): void
    {
        LoggingService::logCreate(
            'InvoiceItem',
            $item->id,
            "Invoice item added: {$item->item_name} x{$item->quantity}",
            $item->toArray()
        );
    }

    public function deleted(InvoiceItem $item): void
    {
        LoggingService::logDelete(
            'InvoiceItem',
            $item->id,
            "Invoice item removed: {$item->item_name}",
            $item->toArray()
        );
    }
}
