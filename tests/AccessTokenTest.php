<?php

namespace Tests\MaxImmo\ExternalParties;

use MaxImmo\ExternalParties\AccessToken;
use MaxImmo\ExternalParties\Exception\InvalidAccessTokenException;
use PHPUnit_Framework_TestCase;

class AccessTokenTest extends PHPUnit_Framework_TestCase
{
    public function test Constructor Throws InvalidArgumentException When Input Is Empty()
    {
        $this->expectException(InvalidAccessTokenException::class);
        new AccessToken('');
    }

    public function test Constructor Throws InvalidArgumentException When Input Is Not A String()
    {
        $this->expectException(InvalidAccessTokenException::class);
        new AccessToken(1);
    }

    public function test GetAccessTokenR eturns Correct Value()
    {
        $accessToken = new AccessToken('value');
        $this->assertEquals('value', $accessToken->getAccessToken());
    }
}
