<?php

namespace MaxImmo\ExternalParties;

use MaxImmo\ExternalParties\Exception\BadRequestException;
use MaxImmo\ExternalParties\Exception\NotFoundException;
use MaxImmo\ExternalParties\Exception\ServiceUnavailableException;
use MaxImmo\ExternalParties\Exception\TooManyRequestsException;
use MaxImmo\ExternalParties\Exception\UnauthorizedException;
use MaxImmo\ExternalParties\Exception\UnexpectedResponseException;
use MaxImmo\ExternalParties\Http\StatusCode;
use Psr\Http\Message\ResponseInterface;

class JsonResponseEvaluator implements ResponseEvaluator
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
    public function evaluateResponse(ResponseInterface $response)
    {
        switch ($response->getStatusCode()) {
            case StatusCode::OK:
                return $this->handleResponseOk($response);
            case StatusCode::BAD_REQUEST:
                $this->handleResponseBadRequest($response);
                break;
            case StatusCode::UNAUTHORIZED:
                $this->handleResponseUnauthorized($response);
                break;
            case StatusCode::NOT_FOUND:
                $this->handleResponseNotFound($response);
                break;
            case StatusCode::TOO_MANY_REQUESTS:
                $this->handleResponseTooManyRequests($response);
                break;
            case StatusCode::SERVICE_UNAVAILABLE:
                $this->handleResponseServiceUnavailable($response);
                break;
            default:
                $this->handleUnexpectedResponse($response);
                break;
        }
    }

    /**
     * @param ResponseInterface $response
     *
     * @return mixed
     */
    protected function handleResponseOk(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws BadRequestException
     */
    protected function handleResponseBadRequest(ResponseInterface $response)
    {
        throw new BadRequestException($response->getBody()->getContents());
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws UnauthorizedException
     */
    protected function handleResponseUnauthorized(ResponseInterface $response)
    {
        throw new UnauthorizedException($response->getBody()->getContents());
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws NotFoundException
     */
    protected function handleResponseNotFound(ResponseInterface $response)
    {
        throw new NotFoundException($response->getBody()->getContents());
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws TooManyRequestsException
     */
    protected function handleResponseTooManyRequests(ResponseInterface $response)
    {
        throw new TooManyRequestsException($response->getBody()->getContents());
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws ServiceUnavailableException
     */
    protected function handleResponseServiceUnavailable(ResponseInterface $response)
    {
        throw new ServiceUnavailableException($response->getBody()->getContents());
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws UnexpectedResponseException
     */
    protected function handleUnexpectedResponse(ResponseInterface $response)
    {
        throw new UnexpectedResponseException($response->getBody()->getContents());
    }
}
