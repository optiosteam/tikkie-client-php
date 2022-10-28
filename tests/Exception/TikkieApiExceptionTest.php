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
    public function testCreateFromClientException(): void
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

        $tikkieException = TikkieApiException::createFromClientException($exception);
        $this->assertCount(1, $tikkieException->getErrors());
        $this->assertEquals('PAYMENT_TOKEN_INVALID', $tikkieException->getErrors()[ 0 ]->getCode());
        $this->assertEquals('paymentToken is in an invalid format.', $tikkieException->getErrors()[ 0 ]->getMessage());
        $this->assertEquals('https://developer.abnamro.com', $tikkieException->getErrors()[ 0 ]->getReference());
        $this->assertEquals(400, $tikkieException->getErrors()[ 0 ]->getStatus());
        $this->assertEquals('5e332871-7f05-4de6-975e-27de0a369629', $tikkieException->getErrors()[ 0 ]->getTraceId());
    }

    public function testCreateFromClientExceptionWithEmptyBody(): void
    {
        $body = $this->createMock(StreamInterface::class);
        $body->expects($this->once())->method('getContents')->willReturn('');
        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())->method('getBody')->willReturn($body);

        $request = $this->createMock(RequestInterface::class);

        $exception = new ClientException(
            'Test message',
            $request,
            $response
        );

        $tikkieException = TikkieApiException::createFromClientException($exception);
        $this->assertNull($tikkieException->getErrors());
        $this->assertEquals('Test message', $tikkieException->getMessage());
    }

    public function testCreateFromClientExceptionWithoutErrors(): void
    {
        $body = $this->createMock(StreamInterface::class);
        $body->expects($this->once())->method('getContents')->willReturn(json_encode(['test' => 'test']));
        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())->method('getBody')->willReturn($body);

        $request = $this->createMock(RequestInterface::class);

        $exception = new ClientException(
            'Test message',
            $request,
            $response
        );

        $tikkieException = TikkieApiException::createFromClientException($exception);
        $this->assertNull($tikkieException->getErrors());
        $this->assertEquals('Test message', $tikkieException->getMessage());
    }
}
