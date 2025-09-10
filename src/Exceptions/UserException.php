<?php

namespace App\Exceptions;

use Exception;

class UserException extends Exception
{
    private string $userMessage;

    public function __construct(string $userMessage, string $devMessage = "", int $code = 0, Exception $previous = null)
    {
        $this->userMessage = $userMessage;
        parent::__construct($devMessage, $code, $previous);
    }

    public function getUserMessage(): string
    {
        return $this->userMessage;
    }
}