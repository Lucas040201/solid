<?php

namespace App\Services;

use App\Enums\UserProvider;
use App\Exceptions\UserTypeNotFoundException;
use App\Models\Contracts\UserContract;
use App\Utils\GetUserTypeService;
use Illuminate\Support\Facades\App;

class UserService
{

    /**
     * @throws UserTypeNotFoundException
     */
    public function createUser(array $data, string $userType): UserContract
    {
        $providerService = GetUserTypeService::getService($userType);
        return $providerService->create($data);
    }


    /**
     * @throws UserTypeNotFoundException
     */
    private function getProvider(string $provider)
    {
        return match ($provider) {
            UserProvider::customer->value => App::make(CustomerService::class),
            UserProvider::shopkeeper->value => App::make(ShopkeeperService::class),
            default => throw new UserTypeNotFoundException()
        };
    }


    /**
     * @throws UserTypeNotFoundException
     */
    public function index(): array
    {
        $customerService = GetUserTypeService::getService(UserProvider::customer->value);
        $shopkeeperService = GetUserTypeService::getService(UserProvider::shopkeeper->value);

        return array_merge(
            $customerService->index(),
            $shopkeeperService->index()
        );
    }
}
