<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    protected $table = 'garage_vehicles';
    protected $fillable = ['garage_client_id', 'car_model', 'number_plate'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'garage_client_id');
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'garage_vehicle_id');
    }
}
