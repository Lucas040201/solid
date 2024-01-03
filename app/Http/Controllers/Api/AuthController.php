<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\WrongCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Exception;

class AuthController extends Controller
{

    public function __construct(
        private readonly AuthService $authService
    )
    {
    }

    public function login(LoginRequest $request, string $provider)
    {
        try {
            return [
                'token' =>$this->authService->login($request->validated(), $provider),
            ];
        } catch (WrongCredentialsException|Exception $exception) {
            return response([
                'error' => [
                    'message' => $exception->getMessage()
                ]
            ], $exception->getCode());
        }
    }
}
