<?php

namespace App\Observers;

use App\Models\Contracts\UserContract;
use App\Models\Wallet;
use Ramsey\Uuid\Uuid;

class UserObserver
{
    public function creating(UserContract $user)
    {
        $user->uuid = Uuid::uuid4();

        Wallet::create(['user_id' => $user->uuid]);
    }
}
