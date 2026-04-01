<?php

namespace App\Observers;

use App\Models\Client;
use App\Services\LoggingService;

class ClientObserver
{
    public function created(Client $client): void
    {
        LoggingService::logCreate(
            'Client',
            $client->id,
            "New client created: {$client->name} ({$client->phone})",
            $client->toArray()
        );
    }

    public function updated(Client $client): void
    {
        $changes = $client->getChanges();
        LoggingService::logUpdate(
            'Client',
            $client->id,
            "Client updated: {$client->name}",
            $client->getOriginal(),
            $changes
        );
    }

    public function deleted(Client $client): void
    {
        LoggingService::logDelete(
            'Client',
            $client->id,
            "Client deleted: {$client->name}",
            $client->toArray()
        );
    }
}
