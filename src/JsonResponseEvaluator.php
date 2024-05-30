<?php

declare(strict_types=1);

namespace MaxImmo\ExternalParties;

use JsonException;
use MaxImmo\ExternalParties\Exception\BadRequest;
use MaxImmo\ExternalParties\Exception\InvalidJson;
use MaxImmo\ExternalParties\Exception\NotFound;
use MaxImmo\ExternalParties\Exception\NotImplemented;
use MaxImmo\ExternalParties\Exception\ServiceUnavailable;
use MaxImmo\ExternalParties\Exception\TooManyRequests;
use MaxImmo\ExternalParties\Exception\Unauthorized;
use MaxImmo\ExternalParties\Exception\UnexpectedResponse;
use MaxImmo\ExternalParties\Http\StatusCode;
use Psr\Http\Message\ResponseInterface;

use function json_decode;

use const JSON_THROW_ON_ERROR;

class JsonResponseEvaluator implements ResponseEvaluator
{
    /**
     * @throws BadRequest
     * @throws InvalidJson
     * @throws NotFound
     * @throws ServiceUnavailable
     * @throws TooManyRequests
     * @throws Unauthorized
     * @throws NotImplemented
     * @throws UnexpectedResponse
     */
    public function evaluateResponse(ResponseInterface $response): mixed
    {
        switch ($response->getStatusCode()) {
            case StatusCode::OK:
                return $this->handleResponseOk($response);

            case StatusCode::NO_CONTENT:
                return null;

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
            case StatusCode::NOT_IMPLEMENTED:
                $this->handleResponseNotImplemented($response);
                break;
            case StatusCode::SERVICE_UNAVAILABLE:
                $this->handleResponseServiceUnavailable($response);
                break;
            default:
                $this->handleUnexpectedResponse($response);
                break;
        }

        throw new UnexpectedResponse();
    }

    /**
     * @throws InvalidJson
     */
    protected function handleResponseOk(ResponseInterface $response): mixed
    {
        $content = $response->getBody()->getContents();

        try {
            return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            throw new InvalidJson($content);
        }
    }

    /**
     * @throws BadRequest
     */
    protected function handleResponseBadRequest(ResponseInterface $response): void
    {
        throw new BadRequest($response->getBody()->getContents());
    }

    /**
     * @throws Unauthorized
     */
    protected function handleResponseUnauthorized(ResponseInterface $response): void
    {
        throw new Unauthorized($response->getBody()->getContents());
    }

    /**
     * @throws NotFound
     */
    protected function handleResponseNotFound(ResponseInterface $response): void
    {
        throw new NotFound($response->getBody()->getContents());
    }

    /**
     * @throws TooManyRequests
     */
    protected function handleResponseTooManyRequests(ResponseInterface $response): void
    {
        throw new TooManyRequests($response->getBody()->getContents());
    }

    /**
     * @throws NotImplemented
     */
    protected function handleResponseNotImplemented(ResponseInterface $response): void
    {
        throw new NotImplemented($response->getBody()->getContents());
    }

    /**
     * @throws ServiceUnavailable
     */
    protected function handleResponseServiceUnavailable(ResponseInterface $response): void
    {
        throw new ServiceUnavailable($response->getBody()->getContents());
    }

    /**
     * @throws UnexpectedResponse
     */
    protected function handleUnexpectedResponse(ResponseInterface $response): void
    {
        throw new UnexpectedResponse($response->getBody()->getContents());
    }
}
