<?php

namespace MaxImmo\ExternalParties\Exception;

use Exception;

abstract class ApiClientException extends Exception
{
    /** @var string */
    private $rawContent;

    /**
     * ApiClientException constructor.
     * @param string $rawContent
     * @param string $message
     * @param int $code
     * @param Exception|null $previousException
     */
    public function __construct($rawContent = '', $message = '', $code = 0, Exception $previousException = null)
    {
        parent::__construct($message, $code, $previousException);
        $this->rawContent = $rawContent;
    }

    /**
     * @return string
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }
}
