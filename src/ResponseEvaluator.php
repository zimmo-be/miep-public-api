<?php

declare(strict_types=1);

namespace MaxImmo\ExternalParties;

use MaxImmo\ExternalParties\Exception\BadRequest;
use MaxImmo\ExternalParties\Exception\NotFound;
use MaxImmo\ExternalParties\Exception\ServiceUnavailable;
use MaxImmo\ExternalParties\Exception\TooManyRequests;
use MaxImmo\ExternalParties\Exception\Unauthorized;
use MaxImmo\ExternalParties\Exception\UnexpectedResponse;
use Psr\Http\Message\ResponseInterface;

interface ResponseEvaluator
{
    /**
     * @throws BadRequest
     * @throws Unauthorized
     * @throws NotFound
     * @throws TooManyRequests
     * @throws ServiceUnavailable
     * @throws UnexpectedResponse
     */
    public function evaluateResponse(ResponseInterface $response): mixed;
}
