<?php

namespace Tests\Optios\Tikkie\Exception;

use GuzzleHttp\Exception\ClientException;
use Optios\Tikkie\Exception\TikkieApiException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class TikkieApiExceptionTest extends TestCase
{
    public function testCreateFromClientException()
    {
        $errors = [
            'errors' => [
                [
                    'code' => 'PAYMENT_TOKEN_INVALID',
                    'message' => 'paymentToken is in an invalid format.',
                    'reference' => 'https://developer.abnamro.com',
                    'status' => 400,
                    'traceId' => '5e332871-7f05-4de6-975e-27de0a369629',
                ],
            ],
        ];

        $body = $this->createMock(StreamInterface::class);
        $body->expects($this->once())->method('getContents')->willReturn(json_encode($errors));
        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())->method('getBody')->willReturn($body);

        $request = $this->createMock(RequestInterface::class);

        $exception = new ClientException(
            'Test message',
            $request,
            $response
        );

        $tikkeException = TikkieApiException::createFromClientException($exception);
        $this->assertCount(1, $tikkeException->getErrors());
        $this->assertEquals('PAYMENT_TOKEN_INVALID', $tikkeException->getErrors()[ 0 ]->getCode());
        $this->assertEquals('paymentToken is in an invalid format.', $tikkeException->getErrors()[ 0 ]->getMessage());
        $this->assertEquals('https://developer.abnamro.com', $tikkeException->getErrors()[ 0 ]->getReference());
        $this->assertEquals(400, $tikkeException->getErrors()[ 0 ]->getStatus());
        $this->assertEquals('5e332871-7f05-4de6-975e-27de0a369629', $tikkeException->getErrors()[ 0 ]->getTraceId());
    }
}
