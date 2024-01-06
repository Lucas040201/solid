<?php

namespace App\Utils;

use App\Enums\UserProvider;
use App\Exceptions\UserTypeNotFoundException;
use App\Services\CustomerService;
use App\Services\ShopkeeperService;
use Illuminate\Support\Facades\App;

class GetUserTypeService
{
    /**
     * @throws UserTypeNotFoundException
     */
    static function getService(string $provider)
    {
        return match ($provider) {
            UserProvider::customer->value => App::make(CustomerService::class),
            UserProvider::shopkeeper->value => App::make(ShopkeeperService::class),
            default => throw new UserTypeNotFoundException()
        };
    }
}
