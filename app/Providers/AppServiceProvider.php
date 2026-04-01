<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Client;
use App\Models\Vehicle;
use App\Models\Job;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Receipt;
use App\Models\User;
use App\Observers\ClientObserver;
use App\Observers\VehicleObserver;
use App\Observers\JobObserver;
use App\Observers\InvoiceObserver;
use App\Observers\InvoiceItemObserver;
use App\Observers\ReceiptObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Listeners\LogAuthActivity;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register model observers for automatic activity logging
        Client::observe(ClientObserver::class);
        Vehicle::observe(VehicleObserver::class);
        Job::observe(JobObserver::class);
        Invoice::observe(InvoiceObserver::class);
        InvoiceItem::observe(InvoiceItemObserver::class);
        Receipt::observe(ReceiptObserver::class);
        User::observe(UserObserver::class);

        // Register event listeners for authentication
        $this->app['events']->listen(Login::class, [LogAuthActivity::class, 'onLogin']);
        $this->app['events']->listen(Logout::class, [LogAuthActivity::class, 'onLogout']);
    }
}

