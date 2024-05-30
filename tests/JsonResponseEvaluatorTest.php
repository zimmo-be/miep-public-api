<?php

declare(strict_types=1);

namespace Tests\MaxImmo\ExternalParties;

use MaxImmo\ExternalParties\Exception\BadRequest;
use MaxImmo\ExternalParties\Exception\NotFound;
use MaxImmo\ExternalParties\Exception\NotImplemented;
use MaxImmo\ExternalParties\Exception\ServiceUnavailable;
use MaxImmo\ExternalParties\Exception\TooManyRequests;
use MaxImmo\ExternalParties\Exception\Unauthorized;
use MaxImmo\ExternalParties\Exception\UnexpectedResponse;
use MaxImmo\ExternalParties\Http\StatusCode;
use MaxImmo\ExternalParties\JsonResponseEvaluator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class JsonResponseEvaluatorTest extends TestCase
{
    private JsonResponseEvaluator $evaluator;
    private ResponseInterface|MockObject $response;
    private StreamInterface|MockObject $body;

    protected function setUp(): void
    {
        $this->evaluator = new JsonResponseEvaluator();
        $this->response  = $this->createMock(ResponseInterface::class);
        $this->body      = $this->createMock(StreamInterface::class);
        $this->response->expects($this->any())->method('getBody')->willReturn($this->body);
    }

    public function testEvaluateResponseShouldReturnJsonDecodedContent(): void
    {
        $this->response->expects($this->any())->method('getStatusCode')->willReturn(StatusCode::OK);
        $this->body->expects($this->any())->method('getContents')->willReturn('{"someKey": "someValue"}');
        $result = $this->evaluator->evaluateResponse($this->response);
        $this->assertEquals(['someKey' => 'someValue'], $result);
    }

    public function testEvaluateResponseShouldThrowBadRequestExceptionOnBadRequest(): void
    {
        $this->body->expects($this->any())->method('getContents')->willReturn('Bad Request');
        $this->expectException(BadRequest::class);
        $this->response->expects($this->any())->method('getStatusCode')->willReturn(StatusCode::BAD_REQUEST);
        $this->evaluator->evaluateResponse($this->response);
    }

    public function testEvaluateResponseShouldThrowUnauthorizedExceptionOnUnauthorized(): void
    {
        $this->body->expects($this->any())->method('getContents')->willReturn('Unauthorized');
        $this->expectException(Unauthorized::class);
        $this->response->expects($this->any())->method('getStatusCode')->willReturn(StatusCode::UNAUTHORIZED);
        $this->evaluator->evaluateResponse($this->response);
    }

    public function testEvaluateResponseShouldThrowNotFoundExceptionOnNotFound(): void
    {
        $this->body->expects($this->any())->method('getContents')->willReturn('Not Found');
        $this->expectException(NotFound::class);
        $this->response->expects($this->any())->method('getStatusCode')->willReturn(StatusCode::NOT_FOUND);
        $this->evaluator->evaluateResponse($this->response);
    }

    public function testEvaluateResponseShouldThrowTooManyRequestsExceptionOnTooManyRequests(): void
    {
        $this->body->expects($this->any())->method('getContents')->willReturn('Too Many Requests');
        $this->expectException(TooManyRequests::class);
        $this->response->expects($this->any())->method('getStatusCode')->willReturn(StatusCode::TOO_MANY_REQUESTS);
        $this->evaluator->evaluateResponse($this->response);
    }

    public function testEvaluateResponseShouldThrowNotImplementedExceptionOnNotImplemented(): void
    {
        $this->body->expects($this->any())->method('getContents')->willReturn('Not Implemented');
        $this->expectException(NotImplemented::class);
        $this->response->expects($this->any())->method('getStatusCode')->willReturn(StatusCode::NOT_IMPLEMENTED);
        $this->evaluator->evaluateResponse($this->response);
    }

    public function testEvaluateResponseShouldThrowTooManyRequestsExceptionOnServiceUnavailable(): void
    {
        $this->body->expects($this->any())->method('getContents')->willReturn('Service Unavailable');
        $this->expectException(ServiceUnavailable::class);
        $this->response->expects($this->any())->method('getStatusCode')->willReturn(StatusCode::SERVICE_UNAVAILABLE);
        $this->evaluator->evaluateResponse($this->response);
    }

    public function testEvaluateResponseShouldThrowUnexpectedResponseExceptionOnUnknownStatusCode(): void
    {
        $this->body->expects($this->any())->method('getContents')->willReturn('Unknown Status Code');
        $this->expectException(UnexpectedResponse::class);
        $this->response->expects($this->any())->method('getStatusCode')->willReturn('unknown');
        $this->evaluator->evaluateResponse($this->response);
    }
}
