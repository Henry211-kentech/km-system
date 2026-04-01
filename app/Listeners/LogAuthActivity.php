<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Services\LoggingService;

class LogAuthActivity
{
    public function onLogin(Login $event): void
    {
        LoggingService::log(
            'LOGIN',
            'User',
            $event->user->id,
            "User logged in: {$event->user->name} ({$event->user->email})"
        );
    }

    public function onLogout(Logout $event): void
    {
        LoggingService::log(
            'LOGOUT',
            'User',
            $event->user->id,
            "User logged out: {$event->user->name}"
        );
    }
}
