<?php

declare(strict_types=1);

namespace MaxImmo\ExternalParties;

use MaxImmo\ExternalParties\Exception\NoAccessToken;
use MaxImmo\ExternalParties\Exception\UnexpectedResponse;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;

use function http_build_query;
use function is_array;
use function is_string;

class Client
{
    protected ResponseEvaluator $responseEvaluator;
    private ClientInterface $httpClient;
    private RequestFactoryInterface $requestFactory;

    public function __construct(ClientInterface $httpClient, RequestFactoryInterface $requestFactory, ResponseEvaluator $responseEvaluator)
    {
        $this->httpClient        = $httpClient;
        $this->requestFactory    = $requestFactory;
        $this->responseEvaluator = $responseEvaluator;
    }

    /**
     * @return mixed[]
     *
     * @throws Exception\BadRequest
     * @throws Exception\NotFound
     * @throws Exception\ServiceUnavailable
     * @throws Exception\TooManyRequests
     * @throws Exception\Unauthorized
     * @throws Exception\UnexpectedResponse
     */
    public function getBrokers(AccessToken $accessToken): array
    {
        $response = $this->sendGetCall(
            '/api/brokers',
            $this->getAuthorizationHeader($accessToken->getAccessToken())
        );

        $evaluatedResponse = $this->responseEvaluator->evaluateResponse($response);
        if (! is_array($evaluatedResponse)) {
            throw new UnexpectedResponse();
        }

        return $evaluatedResponse;
    }

    /**
     * @return mixed[]
     *
     * @throws Exception\BadRequest
     * @throws Exception\NotFound
     * @throws Exception\ServiceUnavailable
     * @throws Exception\TooManyRequests
     * @throws Exception\Unauthorized
     * @throws Exception\UnexpectedResponse
     */
    public function getInformationForBroker(string $brokerId, AccessToken $accessToken): array
    {
        $response = $this->sendGetCall(
            '/api/brokers/' . $brokerId,
            $this->getAuthorizationHeader($accessToken->getAccessToken())
        );

        $evaluatedResponse = $this->responseEvaluator->evaluateResponse($response);
        if (! is_array($evaluatedResponse)) {
            throw new UnexpectedResponse();
        }

        return $evaluatedResponse;
    }

    /**
     * @return mixed[]
     *
     * @throws Exception\BadRequest
     * @throws Exception\NotFound
     * @throws Exception\ServiceUnavailable
     * @throws Exception\TooManyRequests
     * @throws Exception\Unauthorized
     * @throws Exception\UnexpectedResponse
     */
    public function getRealEstateListForBroker(string $brokerId, AccessToken $accessToken): array
    {
        $response = $this->sendGetCall(
            '/api/brokers/' . $brokerId . '/real-estate',
            $this->getAuthorizationHeader($accessToken->getAccessToken())
        );

        $evaluatedResponse = $this->responseEvaluator->evaluateResponse($response);
        if (! is_array($evaluatedResponse)) {
            throw new UnexpectedResponse();
        }

        return $evaluatedResponse;
    }

    /**
     * @return mixed[]
     *
     * @throws Exception\BadRequest
     * @throws Exception\NotFound
     * @throws Exception\ServiceUnavailable
     * @throws Exception\TooManyRequests
     * @throws Exception\Unauthorized
     * @throws Exception\UnexpectedResponse
     */
    public function getPropertyForBroker(string $brokerId, int $propertyId, AccessToken $accessToken): array
    {
        $response = $this->sendGetCall(
            '/api/brokers/' . $brokerId . '/real-estate/properties/' . $propertyId,
            $this->getAuthorizationHeader($accessToken->getAccessToken())
        );

        $evaluatedResponse = $this->responseEvaluator->evaluateResponse($response);
        if (! is_array($evaluatedResponse)) {
            throw new UnexpectedResponse();
        }

        return $evaluatedResponse;
    }

    /**
     * @return mixed[]
     *
     * @throws Exception\BadRequest
     * @throws Exception\NotFound
     * @throws Exception\ServiceUnavailable
     * @throws Exception\TooManyRequests
     * @throws Exception\Unauthorized
     * @throws Exception\UnexpectedResponse
     */
    public function getProjectForBroker(string $brokerId, int $projectId, AccessToken $accessToken): array
    {
        $response = $this->sendGetCall(
            '/api/brokers/' . $brokerId . '/real-estate/projects/' . $projectId,
            $this->getAuthorizationHeader($accessToken->getAccessToken())
        );

        $evaluatedResponse = $this->responseEvaluator->evaluateResponse($response);
        if (! is_array($evaluatedResponse)) {
            throw new UnexpectedResponse();
        }

        return $evaluatedResponse;
    }

    /**
     * @throws Exception\BadRequest
     * @throws Exception\InvalidAccessToken
     * @throws Exception\NotFound
     * @throws Exception\ServiceUnavailable
     * @throws Exception\TooManyRequests
     * @throws Exception\Unauthorized
     * @throws Exception\UnexpectedResponse
     * @throws NoAccessToken
     */
    public function getAccessToken(string $authorization): AccessToken
    {
        $accessTokenResponse = $this->sendGetCall(
            '/api/oauth',
            $this->getAuthorizationHeader($authorization, 'Basic')
        );

        $accessTokenArray = $this->responseEvaluator->evaluateResponse($accessTokenResponse);
        if (! is_array($accessTokenArray)) {
            throw new NoAccessToken();
        }

        $accessToken = $accessTokenArray['access_token'] ?? null;
        if (! is_string($accessToken)) {
            throw new NoAccessToken();
        }

        return new AccessToken($accessToken);
    }

    /**
     * @param array<string, string> $headers
     * @param string[]              $queryParams
     *
     * @throws ClientExceptionInterface
     */
    private function sendGetCall(string $uri, array $headers = [], array $queryParams = []): ResponseInterface
    {
        return $this->send(
            'GET',
            $this->createUrl($uri, $queryParams),
            $headers
        );
    }

    /**
     * @param array<string, string> $headers
     *
     * @throws ClientExceptionInterface
     */
    private function send(string $method, string $uri, array $headers = []): ResponseInterface
    {
        $request = $this->requestFactory->createRequest($method, $uri)
            ->withHeader('Content-Type', 'application/problem+json');

        foreach ($headers as $headerName => $headerValue) {
            $request = $request->withHeader($headerName, $headerValue);
        }

        return $this->httpClient->sendRequest($request);
    }

    /**
     * @param string[] $queryParams
     */
    private function createUrl(string $url, array $queryParams = []): string
    {
        if (empty($queryParams)) {
            return $url;
        }

        return $url . '?' . http_build_query($queryParams);
    }

    /**
     * @return array{Authorization: string}
     */
    private function getAuthorizationHeader(string $authorization, string $type = 'Bearer'): array
    {
        return ['Authorization' => $type . ' ' . $authorization];
    }
}
