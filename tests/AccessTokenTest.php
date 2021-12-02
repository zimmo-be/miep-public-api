<?php

declare(strict_types=1);

namespace Tests\MaxImmo\ExternalParties;

use MaxImmo\ExternalParties\AccessToken;
use MaxImmo\ExternalParties\Exception\InvalidAccessToken;
use PHPUnit\Framework\TestCase;

class AccessTokenTest extends TestCase
{
    public function testConstructorThrowsInvalidArgumentExceptionWhenInputIsEmpty(): void
    {
        $this->expectException(InvalidAccessToken::class);
        new AccessToken('');
    }

    public function testGetAccessTokenReturnsCorrectValue(): void
    {
        $accessToken = new AccessToken('value');
        $this->assertEquals('value', $accessToken->getAccessToken());
    }
}
