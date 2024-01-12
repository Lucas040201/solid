<?php

namespace App\Services;

use App\Enums\UserTypeEnum;
use App\Exceptions\UserTypeNotFoundException;
use App\Services\Contracts\UserServiceContract;
use Illuminate\Support\Facades\App;

class UserTypeService
{
    /**
     * @throws UserTypeNotFoundException
     */
    static function getService(string $userType): UserServiceContract
    {
        return match ($userType) {
            UserTypeEnum::customer->value => App::make(CustomerService::class),
            UserTypeEnum::shopkeeper->value => App::make(ShopkeeperService::class),
            default => throw new UserTypeNotFoundException()
        };
    }
}
