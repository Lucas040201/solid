<?php

namespace App\Repositories;

use App\Models\Shopkeeper;

class ShopkeeperRepository extends UserRepository
{
    public function __construct(Shopkeeper $model)
    {
        parent::__construct($model);
    }
}
