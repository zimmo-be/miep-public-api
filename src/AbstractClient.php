<?php

namespace MaxImmo\ExternalParties;

use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractClient
{
    /** @var ResponseEvaluator */
    protected $responseEvaluator;

    /** @var HttpClient */
    private $httpClient;

    /** @var MessageFactory */
    private $messageFactory;

    /** @var array */
    private $defaultHeaders = ['Content-Type' => 'application/problem+json'];

    /**
     * AbstractClient constructor.
     *
     * @param HttpClient        $httpClient
     * @param MessageFactory    $messageFactory
     * @param ResponseEvaluator $responseEvaluator
     */
    public function __construct(HttpClient $httpClient, MessageFactory $messageFactory, ResponseEvaluator $responseEvaluator)
    {
        $this->httpClient = $httpClient;
        $this->messageFactory = $messageFactory;
        $this->responseEvaluator = $responseEvaluator;
    }

    /**
     * @param       $uri
     * @param array $headers
     * @param array $queryParams
     *
     * @return ResponseInterface
     */
    protected function sendGetCall($uri, array $headers = [], array $queryParams = [])
    {
        return $this->send(
            'GET',
            $this->createUrl($uri, $queryParams),
            $headers
        );
    }

    /**
     * @param       $method
     * @param       $uri
     * @param array $headers
     * @param null  $body
     *
     * @return ResponseInterface
     */
    protected function send($method, $uri, array $headers = [], $body = null)
    {
        return $this->httpClient->sendRequest(
            $this->messageFactory->createRequest(
                $method,
                $uri,
                $this->mergeDefaultHeaders($headers),
                $body
            )
        );
    }

    /**
     * @param string $url
     * @param array  $queryParams
     *
     * @return string
     */
    protected function createUrl($url, array $queryParams = [])
    {
        if (empty($queryParams)) {
            return $url;
        }

        return $url . '?' . http_build_query($queryParams);
    }

    /**
     * @param        $authorization
     * @param string $type
     *
     * @return array
     */
    protected function getAuthorizationHeader($authorization, $type = 'Bearer')
    {
        return ['Authorization' => $type . ' ' . $authorization];
    }

    /**
     * @param array $headers
     *
     * @return array
     */
    private function mergeDefaultHeaders(array $headers = [])
    {
        return array_merge($headers, $this->defaultHeaders);
    }
}
