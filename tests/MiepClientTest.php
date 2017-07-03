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
    /** @var MiepClient */
    private $miepClient;

    public function setUp()
    {
        $this->client = $this->createMock('MaxImmo\ExternalParties\Client');
        $this->accessToken = $this->createMock('MaxImmo\ExternalParties\AccessToken');
        $this->miepClient = new MiepClient('client_id', 'secret', $this->client);
    }

    /**
     * GetBrokers
     */
    public function test GetBrokers Calls Client GetBrokers Once On Immediate Success()
    {
        $this->client->expects($this->once())->method('getBrokers');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $this->miepClient->getBrokers();
    }

    public function test GetBrokers Calls Client GetBrokers Should Return Client Result()
    {
        $this->client->expects($this->any())->method('getBrokers')->willReturn('something');
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $result = $this->miepClient->getBrokers();
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

        $this->miepClient->getBrokers();
    }

    /**
     * GetInformationForBroker
     */
    public function test GetInformationForBroker Calls Client GetInformationForBroker Once On Immediate Success()
    {
        $this->client->expects($this->once())->method('getInformationForBroker');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $this->miepClient->getInformationForBroker('brokerId');
    }

    public function test GetInformationForBroker Calls Client GetInformationForBroker Should Return Client Result()
    {
        $this->client->expects($this->any())->method('getInformationForBroker')->willReturn('something');
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $result = $this->miepClient->getInformationForBroker('brokerId');
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

        $this->miepClient->getInformationForBroker('brokerId');
    }

    /**
     * GetRealEstateListForBroker
     */
    public function test GetRealEstateListForBroker Calls Client GetRealEstateListForBroker Once On Immediate Success()
    {
        $this->client->expects($this->once())->method('getRealEstateListForBroker');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $this->miepClient->getRealEstateListForBroker('brokerId');
    }

    public function test GetRealEstateListForBroker Calls Client GetRealEstateListForBroker Should Return Client Result()
    {
        $this->client->expects($this->any())->method('getRealEstateListForBroker')->willReturn('something');
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $result = $this->miepClient->getRealEstateListForBroker('brokerId');
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

        $this->miepClient->getRealEstateListForBroker('brokerId');
    }

    /**
     * GetPropertyForBroker
     */
    public function test GetPropertyForBroker Calls Client GetPropertyForBroker Once On Immediate Success()
    {
        $this->client->expects($this->once())->method('getPropertyForBroker');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $this->miepClient->getPropertyForBroker('brokerId', 'propertyId');
    }

    public function test GetPropertyForBroker Calls Client GetPropertyForBroker Should Return Client Result()
    {
        $this->client->expects($this->any())->method('getPropertyForBroker')->willReturn('something');
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $result = $this->miepClient->getPropertyForBroker('brokerId', 'propertyId');
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

        $this->miepClient->getPropertyForBroker('brokerId', 'propertyId');
    }

    /**
     * GetProjectForBroker
     */
    public function test GetProjectForBroker Calls Client GetProjectForBroker Once On Immediate Success()
    {
        $this->client->expects($this->once())->method('getProjectForBroker');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $this->miepClient->getProjectForBroker('brokerId', 'projectId');
    }

    public function test GetProjectForBroker Calls Client GetProjectForBroker Should Return Client Result()
    {
        $this->client->expects($this->any())->method('getProjectForBroker')->willReturn('something');
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $result = $this->miepClient->getProjectForBroker('brokerId', 'projectId');
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

        $this->miepClient->getProjectForBroker('brokerId', 'projectId');
    }
}
