<?php

namespace App\Services;

use App\Exceptions\UserTypeNotFoundException;
use App\Exceptions\WrongCredentialsException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    /**
     * @throws WrongCredentialsException
     * @throws UserTypeNotFoundException
     */
    public function login(array $data, string $userType)
    {

        $serviceProvider = UserTypeService::getService($userType);

        $user = $serviceProvider->findBy('email', $data['email']);

        if(empty($user)) {
            throw new WrongCredentialsException();
        }

        if (Hash::check($data['password'], $user->password)) {
            return $user->createToken($userType)->plainTextToken;
        }

        throw new WrongCredentialsException();
    }


    public function currentUser()
    {
        $user = Auth::user();

        return [
            'uuid' => $user->uuid,
            'name' => $user->getNameFullName(),
            'document' => $user->document()->document,
            'email' => $user->email,
            'wallet' => [
                'balance' => $user->wallet()->first()->balance
            ]
        ];
    }
}

