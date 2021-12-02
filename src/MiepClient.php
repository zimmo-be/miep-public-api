<?php

declare(strict_types=1);

namespace MaxImmo\ExternalParties;

use MaxImmo\ExternalParties\Exception\BadRequest;
use MaxImmo\ExternalParties\Exception\NoAccessToken;
use MaxImmo\ExternalParties\Exception\NotFound;
use MaxImmo\ExternalParties\Exception\ServiceUnavailable;
use MaxImmo\ExternalParties\Exception\TooManyRequests;
use MaxImmo\ExternalParties\Exception\Unauthorized;
use MaxImmo\ExternalParties\Exception\UnexpectedResponse;

use function base64_encode;

class MiepClient
{
    private string $clientId;
    private string $secret;
    private Client $client;
    private ?AccessToken $accessToken = null;

    public function __construct(string $clientId, string $secret, Client $client)
    {
        $this->clientId = $clientId;
        $this->secret   = $secret;
        $this->client   = $client;
    }

    /**
     * @return mixed[]
     *
     * @throws BadRequest
     * @throws NoAccessToken
     * @throws NotFound
     * @throws ServiceUnavailable
     * @throws TooManyRequests
     * @throws Unauthorized
     * @throws UnexpectedResponse
     */
    public function getBrokers(): array
    {
        try {
            return $this->client->getBrokers($this->getAccessToken());
        } catch (Unauthorized $e) {
            $this->resetAccessToken();

            return $this->client->getBrokers($this->getAccessToken());
        }
    }

    /**
     * @return mixed[]
     *
     * @throws BadRequest
     * @throws NoAccessToken
     * @throws NotFound
     * @throws ServiceUnavailable
     * @throws TooManyRequests
     * @throws Unauthorized
     * @throws UnexpectedResponse
     */
    public function getInformationForBroker(string $brokerId): array
    {
        try {
            return $this->client->getInformationForBroker($brokerId, $this->getAccessToken());
        } catch (Unauthorized $e) {
            $this->resetAccessToken();

            return $this->client->getInformationForBroker($brokerId, $this->getAccessToken());
        }
    }

    /**
     * @return mixed[]
     *
     * @throws BadRequest
     * @throws NoAccessToken
     * @throws NotFound
     * @throws ServiceUnavailable
     * @throws TooManyRequests
     * @throws Unauthorized
     * @throws UnexpectedResponse
     */
    public function getRealEstateListForBroker(string $brokerId): array
    {
        try {
            return $this->client->getRealEstateListForBroker($brokerId, $this->getAccessToken());
        } catch (Unauthorized $e) {
            $this->resetAccessToken();

            return $this->client->getRealEstateListForBroker($brokerId, $this->getAccessToken());
        }
    }

    /**
     * @return mixed[]
     *
     * @throws BadRequest
     * @throws NoAccessToken
     * @throws NotFound
     * @throws ServiceUnavailable
     * @throws TooManyRequests
     * @throws Unauthorized
     * @throws UnexpectedResponse
     */
    public function getPropertyForBroker(string $brokerId, int $propertyId): array
    {
        try {
            return $this->client->getPropertyForBroker($brokerId, $propertyId, $this->getAccessToken());
        } catch (Unauthorized $e) {
            $this->resetAccessToken();

            return $this->client->getPropertyForBroker($brokerId, $propertyId, $this->getAccessToken());
        }
    }

    /**
     * @return mixed[]
     *
     * @throws BadRequest
     * @throws NoAccessToken
     * @throws NotFound
     * @throws ServiceUnavailable
     * @throws TooManyRequests
     * @throws Unauthorized
     * @throws UnexpectedResponse
     */
    public function getProjectForBroker(string $brokerId, int $projectId): array
    {
        try {
            return $this->client->getProjectForBroker($brokerId, $projectId, $this->getAccessToken());
        } catch (Unauthorized $e) {
            $this->resetAccessToken();

            return $this->client->getProjectForBroker($brokerId, $projectId, $this->getAccessToken());
        }
    }

    /**
     * @throws NoAccessToken
     */
    private function resetAccessToken(): void
    {
        $this->accessToken = null;
        $this->getAccessToken();
    }

    private function getAccessToken(): AccessToken
    {
        $authorizationKey = base64_encode($this->clientId . ':' . $this->secret);
        if (! $this->accessToken) {
            $this->accessToken = $this->client->getAccessToken($authorizationKey);
        }

        return $this->accessToken;
    }
}
