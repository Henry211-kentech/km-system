<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Job extends Model
{
    protected $table = 'garage_jobs';
    protected $fillable = ['job_number', 'garage_client_id', 'garage_vehicle_id', 'description', 'assigned_mechanic', 'status'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'garage_client_id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'garage_vehicle_id');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'garage_job_id');
    }
}
