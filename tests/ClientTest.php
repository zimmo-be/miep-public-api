<?php

namespace Tests\MaxImmo\ExternalParties;

use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use MaxImmo\ExternalParties\AccessToken;
use MaxImmo\ExternalParties\Client;
use MaxImmo\ExternalParties\Exception\NoAccessTokenException;
use MaxImmo\ExternalParties\ResponseEvaluator;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ClientTest extends PHPUnit_Framework_TestCase
{
    /** @var HttpClient | PHPUnit_Framework_MockObject_MockObject */
    private $httpClient;
    /** @var MessageFactory | PHPUnit_Framework_MockObject_MockObject */
    private $messageFactory;
    /** @var ResponseEvaluator | PHPUnit_Framework_MockObject_MockObject */
    private $responseEvaluator;
    /** @var AccessToken | PHPUnit_Framework_MockObject_MockObject */
    private $accessToken;
    /** @var RequestInterface | PHPUnit_Framework_MockObject_MockObject */
    private $request;
    /** @var ResponseInterface | PHPUnit_Framework_MockObject_MockObject */
    private $response;
    /** @var Client */
    private $client;

    public function setUp()
    {
        $this->httpClient = $this->createMock(HttpClient::class);
        $this->messageFactory = $this->createMock(MessageFactory::class);
        $this->responseEvaluator = $this->createMock(ResponseEvaluator::class);
        $this->accessToken = $this->createMock(AccessToken::class);
        $this->request = $this->createMock(RequestInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);
        $this->client = new Client($this->httpClient, $this->messageFactory, $this->responseEvaluator);

        $this->httpClient
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn($this->response);
    }

    public function test GetBrokers Should Perform Request Using Correct Parameters()
    {
        $this->messageFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with(
                'GET',
                '/api/brokers',
                ['Authorization' => 'Bearer ', 'Content-Type' => 'application/problem+json']
            )
            ->willReturn($this->request);

        $this->client->getBrokers($this->accessToken);
    }

    public function test GetRealEstateListForBroker Should Perform Request Using Correct Parameters()
    {
        $this->messageFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with(
                'GET',
                '/api/brokers/brokerId/real-estate',
                ['Authorization' => 'Bearer ', 'Content-Type' => 'application/problem+json']
            )
            ->willReturn($this->request);

        $this->client->getRealEstateListForBroker('brokerId', $this->accessToken);
    }

    public function test GetPropertyForBroker Should Perform Request Using Correct Parameters()
    {
        $this->messageFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with(
                'GET',
                '/api/brokers/brokerId/real-estate/properties/propertyId',
                ['Authorization' => 'Bearer ', 'Content-Type' => 'application/problem+json']
            )
            ->willReturn($this->request);

        $this->client->getPropertyForBroker('brokerId', 'propertyId', $this->accessToken);
    }

    public function test GetProjectForBroker Should Perform Request Using Correct Parameters()
    {
        $this->messageFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with(
                'GET',
                '/api/brokers/brokerId/real-estate/projects/projectId',
                ['Authorization' => 'Bearer ', 'Content-Type' => 'application/problem+json']
            )
            ->willReturn($this->request);

        $this->client->getProjectForBroker('brokerId', 'projectId', $this->accessToken);
    }

    public function test GetAccessToken Should Perform Request Using Correct Parameters()
    {
        $this->expectException(NoAccessTokenException::class);
        $this->messageFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with(
                'GET',
                '/api/oauth',
                ['Authorization' => 'Basic ', 'Content-Type' => 'application/problem+json']
            )
            ->willReturn($this->request);

        $this->client->getAccessToken(null);
    }

    public function test GetAccessToken Should Return AccessToken If Exists()
    {
        $this->messageFactory
            ->expects($this->once())
            ->method('createRequest')
            ->with(
                'GET',
                '/api/oauth',
                ['Authorization' => 'Basic ', 'Content-Type' => 'application/problem+json']
            )
            ->willReturn($this->request);
        $this->responseEvaluator
            ->expects($this->any())
            ->method('evaluateResponse')
            ->willReturn(['access_token' => 'random_token']);

        $token = $this->client->getAccessToken(null);
        $this->assertEquals(new AccessToken('random_token'), $token);
    }
}
