<?php

declare(strict_types=1);

namespace Tests\MaxImmo\ExternalParties;

use MaxImmo\ExternalParties\AccessToken;
use MaxImmo\ExternalParties\Client;
use MaxImmo\ExternalParties\Exception\NoAccessToken;
use MaxImmo\ExternalParties\ResponseEvaluator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ClientTest extends TestCase
{
    private ClientInterface|MockObject $httpClient;
    private RequestFactoryInterface|MockObject $requestFactory;
    private ResponseEvaluator|MockObject $responseEvaluator;
    private AccessToken $accessToken;
    private RequestInterface|MockObject $request;
    private ResponseInterface|MockObject $response;
    private Client $client;

    protected function setUp(): void
    {
        $this->httpClient        = $this->createMock(ClientInterface::class);
        $this->requestFactory    = $this->createMock(RequestFactoryInterface::class);
        $this->responseEvaluator = $this->createMock(ResponseEvaluator::class);
        $this->accessToken       = new AccessToken('access_token_test');
        $this->request           = $this->createMock(RequestInterface::class);
        $this->response          = $this->createMock(ResponseInterface::class);
        $this->client            = new Client($this->httpClient, $this->requestFactory, $this->responseEvaluator);

        $this->httpClient
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn($this->response);
    }

    public function testGetBrokersShouldPerformRequestUsingCorrectParameters(): void
    {
        $this->requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('GET', '/api/brokers')
            ->willReturn($this->request);

        $this->request
            ->expects($this->exactly(2))
            ->method('withHeader')
            ->withConsecutive(
                ['Content-Type', 'application/json'],
                ['Authorization', 'Bearer access_token_test'],
            )
            ->willReturn($this->request);

        $this->responseEvaluator
            ->method('evaluateResponse')
            ->willReturn(['foo' => 'bar']);

        $this->client->getBrokers($this->accessToken);
    }

    public function testGetRealEstateListForBrokerShouldPerformRequestUsingCorrectParameters(): void
    {
        $this->requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('GET', '/api/brokers/brokerId/real-estate')
            ->willReturn($this->request);

        $this->request
            ->expects($this->exactly(2))
            ->method('withHeader')
            ->withConsecutive(
                ['Content-Type', 'application/json'],
                ['Authorization', 'Bearer access_token_test'],
            )
            ->willReturn($this->request);

        $this->responseEvaluator
            ->method('evaluateResponse')
            ->willReturn(['foo' => 'bar']);

        $this->client->getRealEstateListForBroker('brokerId', $this->accessToken);
    }

    public function testGetPropertyForBrokerShouldPerformRequestUsingCorrectParameters(): void
    {
        $this->requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('GET', '/api/brokers/brokerId/real-estate/properties/1')
            ->willReturn($this->request);

        $this->request
            ->expects($this->exactly(2))
            ->method('withHeader')
            ->withConsecutive(
                ['Content-Type', 'application/json'],
                ['Authorization', 'Bearer access_token_test'],
            )
            ->willReturn($this->request);

        $this->responseEvaluator
            ->method('evaluateResponse')
            ->willReturn(['foo' => 'bar']);

        $this->client->getPropertyForBroker('brokerId', 1, $this->accessToken);
    }

    public function testGetProjectForBrokerShouldPerformRequestUsingCorrectParameters(): void
    {
        $this->requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('GET', '/api/brokers/brokerId/real-estate/projects/1')
            ->willReturn($this->request);

        $this->request
            ->expects($this->exactly(2))
            ->method('withHeader')
            ->withConsecutive(
                ['Content-Type', 'application/json'],
                ['Authorization', 'Bearer access_token_test'],
            )
            ->willReturn($this->request);

        $this->responseEvaluator
            ->method('evaluateResponse')
            ->willReturn(['foo' => 'bar']);

        $this->client->getProjectForBroker('brokerId', 1, $this->accessToken);
    }

    public function testGetAccessTokenShouldPerformRequestUsingCorrectParameters(): void
    {
        $this->expectException(NoAccessToken::class);
        $this->requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('GET', '/api/oauth')
            ->willReturn($this->request);

        $this->request
            ->expects($this->exactly(2))
            ->method('withHeader')
            ->withConsecutive(
                ['Content-Type', 'application/json'],
                ['Authorization', 'Basic authorization'],
            )
            ->willReturn($this->request);

        $this->client->getAccessToken('authorization');
    }

    public function testGetAccessTokenShouldReturnAccessTokenIfExists(): void
    {
        $this->requestFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with('GET', '/api/oauth')
            ->willReturn($this->request);

        $this->request
            ->expects($this->exactly(2))
            ->method('withHeader')
            ->withConsecutive(
                ['Content-Type', 'application/json'],
                ['Authorization', 'Basic authorization'],
            )
            ->willReturn($this->request);

        $this->responseEvaluator
            ->expects($this->any())
            ->method('evaluateResponse')
            ->willReturn(['access_token' => 'random_token']);

        $token = $this->client->getAccessToken('authorization');
        $this->assertEquals(new AccessToken('random_token'), $token);
    }
}
