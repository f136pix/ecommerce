<?php

namespace App\Application\Exceptions;

use Exception;

class PublicException extends Exception
{
    private string $publicMessage;

    public function __construct(string $publicMessage, int $code = 0, Exception $previous = null)
    {
        $this->publicMessage = $publicMessage;
        parent::__construct($publicMessage, $code, $previous);
    }

    public function getPublicMessage(): string
    {
        return $this->publicMessage;
    }
}