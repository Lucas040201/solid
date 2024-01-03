<?php

namespace App\Services;

use App\Models\Contracts\ModelContract;
use App\Repositories\Contracts\RepositoryContract;
use App\Services\Contracts\ServiceContract;

abstract class ServiceBase implements ServiceContract
{
    public function __construct(
        private readonly RepositoryContract $repository
    )
    {
    }

    public function create(array $data): ModelContract
    {
        return $this->repository->create($data);
    }

    public function index(): array
    {
        return $this->repository->index();
    }

    public function findBy(string $search, string|int $param)
    {
        return $this->repository->findBy($search, $param);
    }
}
