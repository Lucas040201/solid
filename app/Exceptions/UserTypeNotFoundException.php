<?php

namespace App\Exceptions;

use Exception;

class UserTypeNotFoundException extends Exception
{
    public function __construct(string $message = "The provided user type was not found", int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
