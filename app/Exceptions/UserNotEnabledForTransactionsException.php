<?php

namespace App\Exceptions;

use Exception;
class UserNotEnabledForTransactionsException extends Exception
{
    public function __construct(string $message = "User Not Enabled for transactions", int $code = 401, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
