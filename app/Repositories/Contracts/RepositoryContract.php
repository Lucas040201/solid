<?php

namespace App\Repositories\Contracts;

use App\Models\Contracts\ModelContract;

interface RepositoryContract
{
    public function create(array $data): ModelContract;

    public function index(): array;

}
