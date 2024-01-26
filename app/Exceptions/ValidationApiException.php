<?php

namespace App\Exceptions;


class ValidationApiException extends \Exception
{

    public function __construct(string $message = "", int $code = 422)
    {
        parent::__construct($message, $code);
    }
}
