<?php

namespace App\Models\Contracts;

interface UserContract extends ModelContract
{
    public function document();

    public function getNameFullName(): string;

    public function wallet();
}
