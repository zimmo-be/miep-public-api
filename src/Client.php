<?php

namespace MaxImmo\ExternalParties;

use MaxImmo\ExternalParties\Exception\BadRequestException;
use MaxImmo\ExternalParties\Exception\NoAccessTokenException;
use MaxImmo\ExternalParties\Exception\NotFoundException;
use MaxImmo\ExternalParties\Exception\ServiceUnavailableException;
use MaxImmo\ExternalParties\Exception\TooManyRequestsException;
use MaxImmo\ExternalParties\Exception\UnauthorizedException;
use MaxImmo\ExternalParties\Exception\UnexpectedResponseException;

class Client extends AbstractClient
{
    /**
     * @param AccessToken $accessToken
     *
     * @return array
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws NotFoundException
     * @throws TooManyRequestsException
     * @throws ServiceUnavailableException
     * @throws UnexpectedResponseException
     */
    public function getBrokers(AccessToken $accessToken)
    {
        $response = $this->sendGetCall(
            '/api/brokers',
            $this->getAuthorizationHeader($accessToken->getAccessToken())
        );

        return $this->responseEvaluator->evaluateResponse($response);
    }

    /**
     * @param             $brokerId
     * @param AccessToken $accessToken
     *
     * @return array
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws NotFoundException
     * @throws TooManyRequestsException
     * @throws ServiceUnavailableException
     * @throws UnexpectedResponseException
     */
    public function getInformationForBroker($brokerId, AccessToken $accessToken)
    {
        $response = $this->sendGetCall(
            '/api/brokers/' . $brokerId,
            $this->getAuthorizationHeader($accessToken->getAccessToken())
        );

        return $this->responseEvaluator->evaluateResponse($response);
    }

    /**
     * @param             $brokerId
     * @param AccessToken $accessToken
     *
     * @return array
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws NotFoundException
     * @throws TooManyRequestsException
     * @throws ServiceUnavailableException
     * @throws UnexpectedResponseException
     */
    public function getRealEstateListForBroker($brokerId, AccessToken $accessToken)
    {
        $response = $this->sendGetCall(
            '/api/brokers/' . $brokerId . '/real-estate',
            $this->getAuthorizationHeader($accessToken->getAccessToken())
        );

        return $this->responseEvaluator->evaluateResponse($response);
    }

    /**
     * @param             $brokerId
     * @param             $propertyId
     * @param AccessToken $accessToken
     *
     * @return array
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws NotFoundException
     * @throws ServiceUnavailableException
     * @throws UnexpectedResponseException
     */
    public function getPropertyForBroker($brokerId, $propertyId, AccessToken $accessToken)
    {
        $response = $this->sendGetCall(
            '/api/brokers/' . $brokerId . '/real-estate/properties/' . $propertyId,
            $this->getAuthorizationHeader($accessToken->getAccessToken())
        );

        return $this->responseEvaluator->evaluateResponse($response);
    }

    /**
     * @param             $brokerId
     * @param             $projectId
     * @param AccessToken $accessToken
     *
     * @return array
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws NotFoundException
     * @throws ServiceUnavailableException
     * @throws UnexpectedResponseException
     */
    public function getProjectForBroker($brokerId, $projectId, AccessToken $accessToken)
    {
        $response = $this->sendGetCall(
            '/api/brokers/' . $brokerId . '/real-estate/projects/' . $projectId,
            $this->getAuthorizationHeader($accessToken->getAccessToken())
        );

        return $this->responseEvaluator->evaluateResponse($response);
    }

    /**
     * @param $authorization
     *
     * @return AccessToken
     *
     * @throws BadRequestException
     * @throws UnauthorizedException
     * @throws NotFoundException
     * @throws ServiceUnavailableException
     * @throws UnexpectedResponseException
     * @throws NoAccessTokenException
     */
    public function getAccessToken($authorization)
    {
        $accessTokenResponse = $this->sendGetCall(
            '/api/oauth',
            $this->getAuthorizationHeader($authorization, 'Basic')
        );
        $accessTokenArray = $this->responseEvaluator->evaluateResponse($accessTokenResponse);

        if (!isset($accessTokenArray['access_token'])) {
            throw new NoAccessTokenException();
        }

        return new AccessToken($accessTokenArray['access_token']);
    }
}
