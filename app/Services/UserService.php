<?php

namespace App\Services;

use App\Enums\UserProvider;
use App\Exceptions\ProviderNotFoundException;
use App\Models\Contracts\UserContract;
use Illuminate\Support\Facades\App;

class UserService
{

    /**
     * @throws ProviderNotFoundException
     */
    public function createUser(array $data, string $provider): UserContract
    {
        $providerService = $this->getProvider($provider);
        return $providerService->create($data);
    }


    /**
     * @throws ProviderNotFoundException
     */
    private function getProvider(string $provider)
    {
        return match ($provider) {
            UserProvider::customer->value => App::make(CustomerService::class),
            UserProvider::shopkeeper->value => App::make(ShopkeeperService::class),
            default => throw new ProviderNotFoundException()
        };
    }


    /**
     * @throws ProviderNotFoundException
     */
    public function index(): array
    {
        $customerService = $this->getProvider(UserProvider::customer->value);
        $shopkeeperService = $this->getProvider(UserProvider::shopkeeper->value);

        return array_merge(
            $customerService->index(),
            $shopkeeperService->index()
        );
    }
}
