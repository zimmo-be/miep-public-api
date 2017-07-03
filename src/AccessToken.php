<?php

namespace MaxImmo\ExternalParties;

use Assert\Assertion;
use Assert\InvalidArgumentException;
use MaxImmo\ExternalParties\Exception\InvalidAccessTokenException;

class AccessToken
{
    /** @var  string */
    private $accessToken;

    /**
     * AccessToken constructor.
     *
     * @param string $accessToken
     *
     * @throws InvalidAccessTokenException
     */
    public function __construct($accessToken)
    {
        try {
            Assertion::notEmpty($accessToken);
            Assertion::string($accessToken);
        } catch (InvalidArgumentException $e) {
            throw InvalidAccessTokenException::reason($e);
        }

        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }
}
