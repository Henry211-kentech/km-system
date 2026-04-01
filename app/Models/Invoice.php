<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $table = 'garage_invoices';
    protected $fillable = ['invoice_number', 'garage_job_id', 'total_amount', 'status'];
    protected $casts = ['total_amount' => 'decimal:2'];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'garage_job_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'garage_invoice_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'garage_invoice_id');
    }

    public function getTotalPaidAttribute(): float
    {
        return $this->payments()->sum('amount_paid');
    }

    public function updateInvoiceStatus(): void
    {
        $totalAmount = $this->total_amount;
        $totalPaid = $this->getTotalPaidAttribute();

        if ($totalPaid >= $totalAmount) {
            $this->status = 'Paid';
        } elseif ($totalPaid > 0) {
            $this->status = 'Partially Paid';
        } else {
            $this->status = 'Unpaid';
        }

        $this->save();
    }
}
