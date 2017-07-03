<?php

namespace Tests\MaxImmo\ExternalParties;

use MaxImmo\ExternalParties\AccessToken;
use MaxImmo\ExternalParties\Client;
use MaxImmo\ExternalParties\Exception\UnauthorizedException;
use MaxImmo\ExternalParties\MiepClient;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

class ApiClientTest extends PHPUnit_Framework_TestCase
{
    /** @var Client | \PHPUnit_Framework_MockObject_MockObject */
    private $client;
    /** @var AccessToken | PHPUnit_Framework_MockObject_MockObject */
    private $accessToken;
    /** @var string */
    private $brokerId;
    /** @var string */
    private $propertyId;
    /** @var string */
    private $projectId;

    public function setUp()
    {
        $this->client = $this->createMock('MaxImmo\ExternalParties\Client');
        $this->accessToken = $this->createMock('MaxImmo\ExternalParties\AccessToken');
        $this->brokerId = 'broker';
        $this->propertyId = 'property';
        $this->projectId = 'project';
    }

    /**
     * GetBrokers
     */
    public function test GetBrokers Calls Client GetBrokers Once On Immediate Success()
    {
        $this->client->expects($this->once())->method('getBrokers');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $apiClient = new MiepClient('client_id', 'secret', $this->client);
        $apiClient->getBrokers();
    }

    public function test GetBrokers Calls Client GetBrokers Should Return Client Result()
    {
        $this->client->expects($this->any())->method('getBrokers')->willReturn('something');
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $apiClient = new MiepClient('client_id', 'secret', $this->client);
        $result = $apiClient->getBrokers();
        $this->assertEquals('something', $result);
    }

    public function test GetBrokers Calls Client GetBrokers Exactly Twice When First Call Throws UnauthorizedException()
    {
        $this->expectException(UnauthorizedException::class);
        $this->client
            ->expects($this->exactly(2))
            ->method('getBrokers')
            ->willThrowException(new UnauthorizedException());
        $this->client
            ->expects($this->exactly(2))
            ->method('getAccessToken')
            ->willReturn($this->accessToken);

        $apiClient = new MiepClient('client_id', 'secret', $this->client);
        $apiClient->getBrokers();
    }

    /**
     * GetInformationForBroker
     */
    public function test GetInformationForBroker Calls Client GetInformationForBroker Once On Immediate Success()
    {
        $this->client->expects($this->once())->method('getInformationForBroker');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $apiClient = new MiepClient('client_id', 'secret', $this->client);
        $apiClient->getInformationForBroker($this->brokerId);
    }

    public function test GetInformationForBroker Calls Client GetInformationForBroker Should Return Client Result()
    {
        $this->client->expects($this->any())->method('getInformationForBroker')->willReturn('something');
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $apiClient = new MiepClient('client_id', 'secret', $this->client);
        $result = $apiClient->getInformationForBroker($this->brokerId);
        $this->assertEquals('something', $result);
    }

    public function test GetInformationForBroker Calls Client GetInformationForBroker Exactly Twice When First Call Throws UnauthorizedException()
    {
        $this->expectException(UnauthorizedException::class);
        $this->client
            ->expects($this->exactly(2))
            ->method('getInformationForBroker')
            ->willThrowException(new UnauthorizedException());
        $this->client
            ->expects($this->exactly(2))
            ->method('getAccessToken')
            ->willReturn($this->accessToken);

        $apiClient = new MiepClient('client_id', 'secret', $this->client);
        $apiClient->getInformationForBroker($this->brokerId);
    }

    /**
     * GetRealEstateListForBroker
     */
    public function test GetRealEstateListForBroker Calls Client GetRealEstateListForBroker Once On Immediate Success()
    {
        $this->client->expects($this->once())->method('getRealEstateListForBroker');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $apiClient = new MiepClient('client_id', 'secret', $this->client);
        $apiClient->getRealEstateListForBroker($this->brokerId);
    }

    public function test GetRealEstateListForBroker Calls Client GetRealEstateListForBroker Should Return Client Result()
    {
        $this->client->expects($this->any())->method('getRealEstateListForBroker')->willReturn('something');
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $apiClient = new MiepClient('client_id', 'secret', $this->client);
        $result = $apiClient->getRealEstateListForBroker($this->brokerId);
        $this->assertEquals('something', $result);
    }

    public function test GetRealEstateListForBroker Calls Client GetRealEstateListForBroker Exactly Twice When First Call Throws UnauthorizedException()
    {
        $this->expectException(UnauthorizedException::class);
        $this->client
            ->expects($this->exactly(2))
            ->method('getRealEstateListForBroker')
            ->willThrowException(new UnauthorizedException());
        $this->client
            ->expects($this->exactly(2))
            ->method('getAccessToken')
            ->willReturn($this->accessToken);

        $apiClient = new MiepClient('client_id', 'secret', $this->client);
        $apiClient->getRealEstateListForBroker($this->brokerId);
    }

    /**
     * GetPropertyForBroker
     */
    public function test GetPropertyForBroker Calls Client GetPropertyForBroker Once On Immediate Success()
    {
        $this->client->expects($this->once())->method('getPropertyForBroker');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $apiClient = new MiepClient('client_id', 'secret', $this->client);
        $apiClient->getPropertyForBroker($this->brokerId, $this->propertyId);
    }

    public function test GetPropertyForBroker Calls Client GetPropertyForBroker Should Return Client Result()
    {
        $this->client->expects($this->any())->method('getPropertyForBroker')->willReturn('something');
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $apiClient = new MiepClient('client_id', 'secret', $this->client);
        $result = $apiClient->getPropertyForBroker($this->brokerId, $this->propertyId);
        $this->assertEquals('something', $result);
    }

    public function test GetPropertyForBroker Calls Client GetPropertyForBroker Exactly Twice When First Call Throws UnauthorizedException()
    {
        $this->expectException(UnauthorizedException::class);
        $this->client
            ->expects($this->exactly(2))
            ->method('getPropertyForBroker')
            ->willThrowException(new UnauthorizedException());
        $this->client
            ->expects($this->exactly(2))
            ->method('getAccessToken')
            ->willReturn($this->accessToken);

        $apiClient = new MiepClient('client_id', 'secret', $this->client);
        $apiClient->getPropertyForBroker($this->brokerId, $this->propertyId);
    }

    /**
     * GetProjectForBroker
     */
    public function test GetProjectForBroker Calls Client GetProjectForBroker Once On Immediate Success()
    {
        $this->client->expects($this->once())->method('getProjectForBroker');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $apiClient = new MiepClient('client_id', 'secret', $this->client);
        $apiClient->getProjectForBroker($this->brokerId, $this->projectId);
    }

    public function test GetProjectForBroker Calls Client GetProjectForBroker Should Return Client Result()
    {
        $this->client->expects($this->any())->method('getProjectForBroker')->willReturn('something');
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $apiClient = new MiepClient('client_id', 'secret', $this->client);
        $result = $apiClient->getProjectForBroker($this->brokerId, $this->projectId);
        $this->assertEquals('something', $result);
    }

    public function test GetProjectForBroker Calls Client GetProjectForBroker Exactly Twice When First Call Throws UnauthorizedException()
    {
        $this->expectException(UnauthorizedException::class);
        $this->client
            ->expects($this->exactly(2))
            ->method('getProjectForBroker')
            ->willThrowException(new UnauthorizedException());
        $this->client
            ->expects($this->exactly(2))
            ->method('getAccessToken')
            ->willReturn($this->accessToken);

        $apiClient = new MiepClient('client_id', 'secret', $this->client);
        $apiClient->getProjectForBroker($this->brokerId, $this->projectId);
    }
}
