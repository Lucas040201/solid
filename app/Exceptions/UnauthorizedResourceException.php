<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedResourceException extends Exception
{
    public function __construct(string $message = "Unauthorized Resource", int $code = 401, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
