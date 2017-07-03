<?php

namespace MaxImmo\ExternalParties;

use MaxImmo\ExternalParties\Exception\BadRequestException;
use MaxImmo\ExternalParties\Exception\NotFoundException;
use MaxImmo\ExternalParties\Exception\ServiceUnavailableException;
use MaxImmo\ExternalParties\Exception\TooManyRequestsException;
use MaxImmo\ExternalParties\Exception\UnauthorizedException;
use MaxImmo\ExternalParties\Exception\UnexpectedResponseException;
use Psr\Http\Message\ResponseInterface;

interface ResponseEvaluator
{
    /**
     * @param ResponseInterface $response
     *
     * @return mixed
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws NotFoundException
     * @throws TooManyRequestsException
     * @throws ServiceUnavailableException
     * @throws UnexpectedResponseException
     */
    public function evaluateResponse(ResponseInterface $response);
}
