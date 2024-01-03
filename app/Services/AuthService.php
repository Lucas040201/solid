<?php

namespace App\Services;

use App\Enums\UserProvider;
use App\Exceptions\ProviderNotFoundException;
use App\Exceptions\WrongCredentialsException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    /**
     * @throws WrongCredentialsException
     * @throws ProviderNotFoundException
     */
    public function login(array $data, string $provider)
    {

        $serviceProvider = $this->getProvider($provider);

        $user = $serviceProvider->findBy('email', $data['email']);

        if(empty($user)) {
            throw new WrongCredentialsException();
        }

        if (Hash::check($data['password'], $user->password)) {
            return $user->createToken($provider)->accessToken;
        }

        throw new WrongCredentialsException();
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


}