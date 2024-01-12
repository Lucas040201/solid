<?php

namespace App\Observers;

use App\Models\Contracts\ModelContract;
use Ramsey\Uuid\Uuid;

class UuidObserver
{
    public function creating(ModelContract $model)
    {
        $model->uuid = Uuid::uuid4();
    }
}
