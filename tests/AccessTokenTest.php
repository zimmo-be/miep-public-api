<?php

namespace Tests\MaxImmo\ExternalParties;

use MaxImmo\ExternalParties\AccessToken;
use PHPUnit_Framework_TestCase;

class AccessTokenTest extends PHPUnit_Framework_TestCase
{
    public function testConstructAccessTokenThrowsInvalidArgumentExceptionWhenInputIsEmpty()
    {
        $this->expectException('MaxImmo\ExternalParties\Exception\InvalidAccessTokenException');
        new AccessToken('');
    }

    public function testConstructAccessTokenThrowsInvalidArgumentExceptionWhenInputIsNotAString()
    {
        $this->expectException('MaxImmo\ExternalParties\Exception\InvalidAccessTokenException');
        new AccessToken(1);
    }

    public function testGetAccessTokenReturnsCorrectValue()
    {
        $accessToken = new AccessToken('value');
        $this->assertEquals('value', $accessToken->getAccessToken());
    }
}
