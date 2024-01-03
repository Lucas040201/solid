<?php

namespace App\Services;

use App\Models\Contracts\UserContract;
use App\Repositories\ShopkeeperRepository;
use App\Services\Contracts\UserServiceContract;

class ShopkeeperService extends ServiceBase implements UserServiceContract
{
    public function __construct(
        private readonly ShopkeeperRepository $repository
    )
    {
        parent::__construct($repository);
    }

    public function create(array $data): UserContract
    {
        return $this->repository->create($data);
    }
}
