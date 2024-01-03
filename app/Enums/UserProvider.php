<?php

namespace App\Enums;

enum UserProvider: string
{
    case customer = 'customer';
    case shopkeeper = 'shopkeeper';
}
