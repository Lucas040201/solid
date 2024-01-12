<?php

namespace App\Providers;

use App\Repositories\CustomerRepository;
use App\Repositories\ShopkeeperRepository;
use App\Repositories\TransactionRepository;
use App\Services\CustomerService;
use App\Services\ShopkeeperService;
use App\Services\TransactionService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

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
        $this->app->bind(CustomerService::class, function(Application $app) {
            return new CustomerService($app->make(CustomerRepository::class));
        });

        $this->app->bind(ShopkeeperService::class, function(Application $app) {
            return new ShopkeeperService($app->make(ShopkeeperRepository::class));
        });

        $this->app->bind(TransactionService::class, function(Application $app) {
            return new TransactionService($app->make(TransactionRepository::class));
        });
    }
}
