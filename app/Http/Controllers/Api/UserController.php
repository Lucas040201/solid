<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\UserTypeNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Services\UserService;
use Mockery\Exception;

class UserController extends Controller
{

    public function __construct(
        private readonly UserService $userService
    )
    {
    }

    public function create(CreateUserRequest $request, string $provider)
    {
        try {
            $data = $request->validated();

            $user = $this->userService->createUser($data, $provider);

            return response([
                'message' => 'User created Successfully',
                'id' => $user->uuid->toString()
            ]);

        } catch (UserTypeNotFoundException|Exception $exception) {
            return response([
                'error' => [
                    'message' => $exception->getMessage()
                ]
            ], $exception->getCode());
        }
    }

    public function index()
    {
        try {
            return response([
                'data' => $this->userService->index()
            ]);
        } catch (Exception $exception) {
            return response([
                'error' => [
                    'message' => $exception->getMessage()
                ]
            ], $exception->getCode());
        }
    }
}
