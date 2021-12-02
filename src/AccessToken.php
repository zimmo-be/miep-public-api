<?php

declare(strict_types=1);

namespace MaxImmo\ExternalParties;

use MaxImmo\ExternalParties\Exception\InvalidAccessToken;

class AccessToken
{
    private string $accessToken;

    /**
     * @throws InvalidAccessToken
     */
    public function __construct(string $accessToken)
    {
        if ($accessToken === '') {
            throw new InvalidAccessToken('Access token cannot be empty.');
        }

        $this->accessToken = $accessToken;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }
}
