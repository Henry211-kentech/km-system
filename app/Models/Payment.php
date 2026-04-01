<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    protected $table = 'garage_payments';
    protected $fillable = ['garage_invoice_id', 'amount_paid', 'payment_method'];
    protected $casts = ['amount_paid' => 'decimal:2'];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'garage_invoice_id');
    }

    public function receipt(): HasOne
    {
        return $this->hasOne(Receipt::class, 'garage_payment_id');
    }
}
