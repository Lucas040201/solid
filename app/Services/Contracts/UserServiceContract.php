<?php

namespace App\Services\Contracts;

use App\Models\Contracts\UserContract;

interface UserServiceContract
{
    public function create(array $data): UserContract;
    public function index(): array;
}
