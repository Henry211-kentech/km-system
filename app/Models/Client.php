<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $table = 'garage_clients';
    protected $fillable = ['name', 'phone'];

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'garage_client_id');
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'garage_client_id');
    }
}