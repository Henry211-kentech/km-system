<?php

namespace App\Observers;

use App\Models\Vehicle;
use App\Services\LoggingService;

class VehicleObserver
{
    public function created(Vehicle $vehicle): void
    {
        LoggingService::logCreate(
            'Vehicle',
            $vehicle->id,
            "New vehicle registered: {$vehicle->car_model} ({$vehicle->registration_number})",
            $vehicle->toArray()
        );
    }

    public function updated(Vehicle $vehicle): void
    {
        $changes = $vehicle->getChanges();
        LoggingService::logUpdate(
            'Vehicle',
            $vehicle->id,
            "Vehicle updated: {$vehicle->car_model}",
            $vehicle->getOriginal(),
            $changes
        );
    }

    public function deleted(Vehicle $vehicle): void
    {
        LoggingService::logDelete(
            'Vehicle',
            $vehicle->id,
            "Vehicle deleted: {$vehicle->car_model}",
            $vehicle->toArray()
        );
    }
}
