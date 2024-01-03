<?php

namespace App\Repositories\Contracts;

use App\Models\Contracts\ModelContract;

interface RepositoryContract
{
    public function create(array $data): ModelContract;

    public function index(): array;

    public function findBy(string $search, string|int $param);

}
