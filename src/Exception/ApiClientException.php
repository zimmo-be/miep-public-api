<?php

declare(strict_types=1);

namespace MaxImmo\ExternalParties\Exception;

use Exception;
use Throwable;

abstract class ApiClientException extends Exception
{
    private string $rawContent;

    public function __construct(string $rawContent = '', string $message = '', int $code = 0, ?Throwable $previousException = null)
    {
        parent::__construct($message, $code, $previousException);
        $this->rawContent = $rawContent;
    }

    public function getRawContent(): string
    {
        return $this->rawContent;
    }
}
