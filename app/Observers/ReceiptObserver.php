<?php

namespace App\Observers;

use App\Models\Receipt;
use App\Services\LoggingService;

class ReceiptObserver
{
    public function created(Receipt $receipt): void
    {
        LoggingService::logCreate(
            'Receipt',
            $receipt->id,
            "Receipt generated: {$receipt->receipt_number}",
            $receipt->toArray()
        );
    }

    public function deleted(Receipt $receipt): void
    {
        LoggingService::logDelete(
            'Receipt',
            $receipt->id,
            "Receipt deleted: {$receipt->receipt_number}",
            $receipt->toArray()
        );
    }
}
