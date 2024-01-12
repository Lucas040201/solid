<?php

namespace App\Repositories;

use App\Models\Contracts\ModelContract;
use App\Repositories\Contracts\RepositoryContract;

abstract class RepositoryBase implements RepositoryContract
{
    public function __construct(
        protected readonly ModelContract $model
    )
    {
    }

    public function create(array $data): ModelContract
    {
        return $this->model::create($data);
    }

    public function index(): array
    {
        return $this->model->all()->toArray();
    }

    public function findBy(string $search, string|int $param)
    {
        return $this->model::where($search, $param)->first();
    }

}
