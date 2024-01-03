<?php

namespace App\Repositories;

use App\Models\Contracts\ModelContract;
use App\Repositories\Contracts\RepositoryContract;
use Illuminate\Database\Eloquent\Model;

abstract class RepositoryBase implements RepositoryContract
{
    public function __construct(
        protected readonly Model $model
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
