<?php

namespace App\Services;

use App\Models\Contracts\UserContract;
use App\Repositories\CustomerRepository;
use App\Services\Contracts\UserServiceContract;

class CustomerService extends ServiceBase implements UserServiceContract
{

    public function __construct(
        private readonly CustomerRepository $repository
    )
    {
        parent::__construct($repository);
    }

    public function create(array $data): UserContract
    {
        return $this->repository->create($data);
    }
}
