<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository extends UserRepository
{
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }

}
