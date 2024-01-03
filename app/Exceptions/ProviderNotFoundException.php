<?php

namespace App\Exceptions;

use Exception;

class ProviderNotFoundException extends Exception
{
    public function __construct(string $message = "The provided provider was not found", int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
