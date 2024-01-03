<?php

namespace App\Exceptions;

use Exception;

class WrongCredentialsException extends Exception
{
    public function __construct(string $message = "Incorrect email or password", int $code = 401, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
