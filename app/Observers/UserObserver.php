<?php

namespace App\Observers;

use App\Models\Contracts\UserContract;
use Ramsey\Uuid\Uuid;

class UserObserver
{
    public function creating(UserContract $user)
    {
        $user->uuid = Uuid::uuid4();
    }
}
