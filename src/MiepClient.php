<?php

namespace MaxImmo\ExternalParties;

use MaxImmo\ExternalParties\Exception\BadRequestException;
use MaxImmo\ExternalParties\Exception\NoAccessTokenException;
use MaxImmo\ExternalParties\Exception\NotFoundException;
use MaxImmo\ExternalParties\Exception\ServiceUnavailableException;
use MaxImmo\ExternalParties\Exception\TooManyRequestsException;
use MaxImmo\ExternalParties\Exception\UnauthorizedException;
use MaxImmo\ExternalParties\Exception\UnexpectedResponseException;

class MiepClient
{
    /** @var string */
    private $clientId;
    /** @var string */
    private $secret;
    /** @var Client */
    private $client;
    /** @var  AccessToken */
    private $accessToken;

    /**
     * ApiClient constructor.
     *
     * @param        $clientId
     * @param        $secret
     * @param Client $client
     */
    public function __construct($clientId, $secret, Client $client)
    {
        $this->clientId = $clientId;
        $this->secret = $secret;
        $this->client = $client;
    }

    /**
     * @param $brokerId
     *
     * @return array
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws NotFoundException
     * @throws TooManyRequestsException
     * @throws ServiceUnavailableException
     * @throws UnexpectedResponseException
     * @throws NoAccessTokenException
     */
    public function getChangesForBroker($brokerId)
    {
        try {
            return $this->client->getChangesForBroker($brokerId, $this->getAccessToken());
        } catch (UnauthorizedException $e) {
            $this->resetAccessToken();

            return $this->client->getChangesForBroker($brokerId, $this->getAccessToken());
        }
    }

    /**
     * @param $brokerId
     * @param $propertyId
     *
     * @return array
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws NotFoundException
     * @throws ServiceUnavailableException
     * @throws UnexpectedResponseException
     * @throws NoAccessTokenException
     */
    public function getPropertyForBroker($brokerId, $propertyId)
    {
        try {
            return $this->client->getPropertyForBroker($brokerId, $propertyId, $this->getAccessToken());
        } catch (UnauthorizedException $e) {
            $this->resetAccessToken();

            return $this->client->getPropertyForBroker($brokerId, $propertyId, $this->getAccessToken());
        }
    }

    /**
     * @param $brokerId
     * @param $projectId
     *
     * @return array
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws NotFoundException
     * @throws ServiceUnavailableException
     * @throws UnexpectedResponseException
     * @throws NoAccessTokenException
     */
    public function getProjectForBroker($brokerId, $projectId)
    {
        try {
            return $this->client->getProjectForBroker($brokerId, $projectId, $this->getAccessToken());
        } catch (UnauthorizedException $e) {
            $this->resetAccessToken();

            return $this->client->getProjectForBroker($brokerId, $projectId, $this->getAccessToken());
        }
    }

    /**
     * Reset the access token
     *
     * @throws NoAccessTokenException
     */
    private function resetAccessToken()
    {
        $this->accessToken = null;
        $this->getAccessToken();
    }

    /**
     * @return AccessToken
     *
     * @throws NoAccessTokenException
     */
    private function getAccessToken()
    {
        $authorizationKey = base64_encode($this->clientId . ':' . $this->secret);
        if (!$this->accessToken) {
            $this->accessToken = $this->client->getAccessToken($authorizationKey);
        }

        return $this->accessToken;
    }
}
