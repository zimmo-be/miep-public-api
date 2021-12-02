<?php

declare(strict_types=1);

namespace Tests\MaxImmo\ExternalParties;

use MaxImmo\ExternalParties\AccessToken;
use MaxImmo\ExternalParties\Client;
use MaxImmo\ExternalParties\Exception\Unauthorized;
use MaxImmo\ExternalParties\MiepClient;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class MiepClientTest extends TestCase
{
    private Client|MockObject $client;
    private AccessToken $accessToken;
    private MiepClient $miepClient;

    protected function setUp(): void
    {
        $this->client      = $this->createMock(Client::class);
        $this->accessToken = new AccessToken('access_token_test');
        $this->miepClient  = new MiepClient('client_id', 'secret', $this->client);
    }

    /**
     * GetBrokers
     */
    public function testGetBrokersCallsClientGetBrokersOnceOnImmediateSuccess(): void
    {
        $this->client->expects($this->once())->method('getBrokers');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $this->miepClient->getBrokers();
    }

    public function testGetBrokersCallsClientGetBrokersShouldReturnClientResult(): void
    {
        $this->client->expects($this->any())->method('getBrokers')->willReturn(['foo' => 'bar']);
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $result = $this->miepClient->getBrokers();
        $this->assertEquals(['foo' => 'bar'], $result);
    }

    public function testGetBrokersCallsClientGetBrokersExactlyTwiceWhenFirstCallThrowsUnauthorizedException(): void
    {
        $this->expectException(Unauthorized::class);
        $this->client
            ->expects($this->exactly(2))
            ->method('getBrokers')
            ->willThrowException(new Unauthorized());
        $this->client
            ->expects($this->exactly(2))
            ->method('getAccessToken')
            ->willReturn($this->accessToken);

        $this->miepClient->getBrokers();
    }

    /**
     * GetInformationForBroker
     */
    public function testGetInformationForBrokerCallsClientGetInformationForBrokerOnceOnImmediateSuccess(): void
    {
        $this->client->expects($this->once())->method('getInformationForBroker');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $this->miepClient->getInformationForBroker('brokerId');
    }

    public function testGetInformationForBrokerCallsClientGetInformationForBrokerShouldReturnClientResult(): void
    {
        $this->client->expects($this->any())->method('getInformationForBroker')->willReturn(['foo' => 'bar']);
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $result = $this->miepClient->getInformationForBroker('brokerId');
        $this->assertEquals(['foo' => 'bar'], $result);
    }

    public function testGetInformationForBrokerCallsClientGetInformationForBrokerExactlyTwiceWhenFirstCallThrowsUnauthorizedException(): void
    {
        $this->expectException(Unauthorized::class);
        $this->client
            ->expects($this->exactly(2))
            ->method('getInformationForBroker')
            ->willThrowException(new Unauthorized());
        $this->client
            ->expects($this->exactly(2))
            ->method('getAccessToken')
            ->willReturn($this->accessToken);

        $this->miepClient->getInformationForBroker('brokerId');
    }

    /**
     * GetRealEstateListForBroker
     */
    public function testGetRealEstateListForBrokerCallsClientGetRealEstateListForBrokerOnceOnImmediateSuccess(): void
    {
        $this->client->expects($this->once())->method('getRealEstateListForBroker');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $this->miepClient->getRealEstateListForBroker('brokerId');
    }

    public function testGetRealEstateListForBrokerCallsClientGetRealEstateListForBrokerShouldReturnClientResult(): void
    {
        $this->client->expects($this->any())->method('getRealEstateListForBroker')->willReturn(['foo' => 'bar']);
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $result = $this->miepClient->getRealEstateListForBroker('brokerId');
        $this->assertEquals(['foo' => 'bar'], $result);
    }

    public function testGetRealEstateListForBrokerCallsClientGetRealEstateListForBrokerExactlyTwiceWhenFirstCallThrowsUnauthorizedException(): void
    {
        $this->expectException(Unauthorized::class);
        $this->client
            ->expects($this->exactly(2))
            ->method('getRealEstateListForBroker')
            ->willThrowException(new Unauthorized());
        $this->client
            ->expects($this->exactly(2))
            ->method('getAccessToken')
            ->willReturn($this->accessToken);

        $this->miepClient->getRealEstateListForBroker('brokerId');
    }

    /**
     * GetPropertyForBroker
     */
    public function testGetPropertyForBrokerCallsClientGetPropertyForBrokerOnceOnImmediateSuccess(): void
    {
        $this->client->expects($this->once())->method('getPropertyForBroker');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $this->miepClient->getPropertyForBroker('brokerId', 1);
    }

    public function testGetPropertyForBrokerCallsClientGetPropertyForBrokerShouldReturnClientResult(): void
    {
        $this->client->expects($this->any())->method('getPropertyForBroker')->willReturn(['foo' => 'bar']);
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $result = $this->miepClient->getPropertyForBroker('brokerId', 1);
        $this->assertEquals(['foo' => 'bar'], $result);
    }

    public function testGetPropertyForBrokerCallsClientGetPropertyForBrokerExactlyTwiceWhenFirstCallThrowsUnauthorizedException(): void
    {
        $this->expectException(Unauthorized::class);
        $this->client
            ->expects($this->exactly(2))
            ->method('getPropertyForBroker')
            ->willThrowException(new Unauthorized());
        $this->client
            ->expects($this->exactly(2))
            ->method('getAccessToken')
            ->willReturn($this->accessToken);

        $this->miepClient->getPropertyForBroker('brokerId', 1);
    }

    /**
     * GetProjectForBroker
     */
    public function testGetProjectForBrokerCallsClientGetProjectForBrokerOnceOnImmediateSuccess(): void
    {
        $this->client->expects($this->once())->method('getProjectForBroker');
        $this->client->expects($this->once())->method('getAccessToken')->willReturn($this->accessToken);

        $this->miepClient->getProjectForBroker('brokerId', 1);
    }

    public function testGetProjectForBrokerCallsClientGetProjectForBrokerShouldReturnClientResult(): void
    {
        $this->client->expects($this->any())->method('getProjectForBroker')->willReturn(['foo' => 'bar']);
        $this->client->expects($this->any())->method('getAccessToken')->willReturn($this->accessToken);

        $result = $this->miepClient->getProjectForBroker('brokerId', 1);
        $this->assertEquals(['foo' => 'bar'], $result);
    }

    public function testGetProjectForBrokerCallsClientGetProjectForBrokerExactlyTwiceWhenFirstCallThrowsUnauthorizedException(): void
    {
        $this->expectException(Unauthorized::class);
        $this->client
            ->expects($this->exactly(2))
            ->method('getProjectForBroker')
            ->willThrowException(new Unauthorized());
        $this->client
            ->expects($this->exactly(2))
            ->method('getAccessToken')
            ->willReturn($this->accessToken);

        $this->miepClient->getProjectForBroker('brokerId', 1);
    }
}
