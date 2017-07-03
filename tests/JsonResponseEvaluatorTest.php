<?php

namespace Tests\MaxImmo\ExternalParties;

use MaxImmo\ExternalParties\Exception\BadRequestException;
use MaxImmo\ExternalParties\Exception\NotFoundException;
use MaxImmo\ExternalParties\Exception\ServiceUnavailableException;
use MaxImmo\ExternalParties\Exception\TooManyRequestsException;
use MaxImmo\ExternalParties\Exception\UnauthorizedException;
use MaxImmo\ExternalParties\Exception\UnexpectedResponseException;
use MaxImmo\ExternalParties\Http\StatusCode;
use MaxImmo\ExternalParties\JsonResponseEvaluator;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class JsonResponseEvaluatorTest extends PHPUnit_Framework_TestCase
{
    /** @var JsonResponseEvaluator */
    private $evaluator;
    /** @var ResponseInterface | PHPUnit_Framework_MockObject_MockObject */
    private $response;
    /** @var StreamInterface | PHPUnit_Framework_MockObject_MockObject */
    private $body;

    public function setUp()
    {
        $this->evaluator = new JsonResponseEvaluator();
        $this->response = $this->createMock(ResponseInterface::class);
        $this->body = $this->createMock(StreamInterface::class);
        $this->response->expects($this->any())->method('getBody')->willReturn($this->body);
    }

    public function test EvaluateResponse Should Return JsonDecoded Content()
    {
        $this->response->expects($this->any())->method('getStatusCode')->willReturn(StatusCode::OK);
        $this->body->expects($this->any())->method('getContents')->willReturn('{"someKey": "someValue"}');
        $result = $this->evaluator->evaluateResponse($this->response);
        $this->assertEquals(['someKey' => 'someValue'], $result);
    }

    public function test EvaluateResponse Should Throw BadRequestException On Bad Request()
    {
        $this->expectException(BadRequestException::class);
        $this->response->expects($this->any())->method('getStatusCode')->willReturn(StatusCode::BAD_REQUEST);
        $this->evaluator->evaluateResponse($this->response);
    }

    public function test EvaluateResponse Should Throw UnauthorizedException On Unauthorized()
    {
        $this->expectException(UnauthorizedException::class);
        $this->response->expects($this->any())->method('getStatusCode')->willReturn(StatusCode::UNAUTHORIZED);
        $this->evaluator->evaluateResponse($this->response);
    }

    public function test EvaluateResponse Should Throw NotFoundException On Not Found()
    {
        $this->expectException(NotFoundException::class);
        $this->response->expects($this->any())->method('getStatusCode')->willReturn(StatusCode::NOT_FOUND);
        $this->evaluator->evaluateResponse($this->response);
    }

    public function test EvaluateResponse Should Throw TooManyRequestsException On Too Many Requests()
    {
        $this->expectException(TooManyRequestsException::class);
        $this->response->expects($this->any())->method('getStatusCode')->willReturn(StatusCode::TOO_MANY_REQUESTS);
        $this->evaluator->evaluateResponse($this->response);
    }

    public function test EvaluateResponse Should Throw TooManyRequestsException On Service Unavailable()
    {
        $this->expectException(ServiceUnavailableException::class);
        $this->response->expects($this->any())->method('getStatusCode')->willReturn(StatusCode::SERVICE_UNAVAILABLE);
        $this->evaluator->evaluateResponse($this->response);
    }

    public function test EvaluateResponse Should Throw UnexpectedResponseException On Unknown StatusCode()
    {
        $this->expectException(UnexpectedResponseException::class);
        $this->response->expects($this->any())->method('getStatusCode')->willReturn('unknown');
        $this->evaluator->evaluateResponse($this->response);
    }
}
