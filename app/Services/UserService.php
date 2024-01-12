<?php

namespace App\Services;

use App\Enums\UserTypeEnum;
use App\Exceptions\UserTypeNotFoundException;
use App\Models\Contracts\UserContract;
use Illuminate\Support\Facades\App;

class UserService
{

    /**
     * @throws UserTypeNotFoundException
     */
    public function createUser(array $data, string $userType): UserContract
    {
        $providerService = UserTypeService::getService($userType);
        return $providerService->create($data);
    }


    /**
     * @throws UserTypeNotFoundException
     */
    private function getProvider(string $provider)
    {
        return match ($provider) {
            UserTypeEnum::customer->value => App::make(CustomerService::class),
            UserTypeEnum::shopkeeper->value => App::make(ShopkeeperService::class),
            default => throw new UserTypeNotFoundException()
        };
    }


    /**
     * @throws UserTypeNotFoundException
     */
    public function index(): array
    {
        $customerService = UserTypeService::getService(UserTypeEnum::customer->value);
        $shopkeeperService = UserTypeService::getService(UserTypeEnum::shopkeeper->value);

        return array_merge(
            $customerService->index(),
            $shopkeeperService->index()
        );
    }
}
