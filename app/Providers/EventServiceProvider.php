<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Shopkeeper;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Observers\UserObserver;
use App\Observers\UuidObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Customer::observe(UserObserver::class);
        Shopkeeper::observe(UserObserver::class);
        Wallet::observe(UuidObserver::class);
        Transaction::observe(UuidObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
