<?php

namespace App\Repositories\Contracts;

use App\Models\Contracts\UserContract;

interface UserRepositoryContract extends RepositoryContract
{
    public function create(array $data): UserContract;
}
