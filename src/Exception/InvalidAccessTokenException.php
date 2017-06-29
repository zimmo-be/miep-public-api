<?php

namespace MaxImmo\ExternalParties\Exception;

use Exception;

class InvalidAccessTokenException extends Exception
{
    public static function reason(Exception $exception)
    {
        $message = 'Invalid access token because ' . $exception->getMessage();

        return new self($message, $exception->getCode(), $exception);
    }
}
