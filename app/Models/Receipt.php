<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receipt extends Model
{
    protected $table = 'garage_receipts';
    protected $fillable = ['receipt_number', 'garage_payment_id'];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'garage_payment_id');
    }
}
