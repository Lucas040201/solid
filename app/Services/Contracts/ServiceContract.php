<?php

namespace App\Services\Contracts;

use App\Models\Contracts\ModelContract;

interface ServiceContract
{
    public function create(array $data): ModelContract;

    public function index(): array;

    public function findBy(string $search, string|int $param);
}
