<?php

namespace App\Observers;

use App\Models\User;
use App\Services\LoggingService;

class UserObserver
{
    public function created(User $user): void
    {
        LoggingService::logCreate(
            'User',
            $user->id,
            "New user created: {$user->name} ({$user->email})",
            $user->toArray()
        );
    }

    public function updated(User $user): void
    {
        $changes = $user->getChanges();
        LoggingService::logUpdate(
            'User',
            $user->id,
            "User updated: {$user->name}",
            $user->getOriginal(),
            $changes
        );
    }

    public function deleted(User $user): void
    {
        LoggingService::logDelete(
            'User',
            $user->id,
            "User deleted: {$user->name}",
            $user->toArray()
        );
    }
}
