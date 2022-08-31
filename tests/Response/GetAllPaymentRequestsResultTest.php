<?php
declare(strict_types = 1);

namespace Tests\Optios\Tikkie\Response;

use Optios\Tikkie\Response\GetAllPaymentRequestsResult;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class GetAllPaymentRequestsResultTest extends TestCase
{
    public function testGetAllPaymentRequestsResult(): void
    {
        $result = GetAllPaymentRequestsResult::createFromArray(
            [
                'totalElementCount' => 2,
                'paymentRequests' => [
                    [
                        'paymentRequestToken' => 'qzdnzr8hnVWTgXXcFRLUMc',
                        'url' => 'https://tikkie.me/pay/Tikkie/qzdnzr8hnVWTgXXcFRLUMc',
                        'amountInCents' => 2000,
                        'description' => 'Invoice 1815',
                        'createdDateTime' => '2022-08-31 11:22:33',
                        'expiryDate' => '2022-09-14',
                        'status' => 'OPEN',
                        'numberOfPayments' => 1,
                        'totalAmountPaidInCents' => 1000,
                    ],
                    [
                        'paymentRequestToken' => 'xxxxxx',
                        'url' => 'https://tikkie.me/pay/Tikkie/xxxxxx',
                        'amountInCents' => 100,
                        'description' => 'Invoice 1000',
                        'createdDateTime' => '2022-08-31 11:22:33',
                        'expiryDate' => '2022-09-14',
                        'status' => 'OPEN',
                        'numberOfPayments' => 0,
                        'totalAmountPaidInCents' => 0,
                    ],
                ],
            ]
        );

        $this->assertCount(2, $result->getPaymentRequests());
        $this->assertEquals(2, $result->getTotalElementCount());
    }

    public function testcreateFromResponse(): void
    {
        $payload = [
            'totalElementCount' => 2,
            'paymentRequests' => [
                [
                    'paymentRequestToken' => 'qzdnzr8hnVWTgXXcFRLUMc',
                    'url' => 'https://tikkie.me/pay/Tikkie/qzdnzr8hnVWTgXXcFRLUMc',
                    'amountInCents' => 2000,
                    'description' => 'Invoice 1815',
                    'createdDateTime' => '2022-08-31 11:22:33',
                    'expiryDate' => '2022-09-14',
                    'status' => 'OPEN',
                    'numberOfPayments' => 1,
                    'totalAmountPaidInCents' => 1000,
                ],
                [
                    'paymentRequestToken' => 'xxxxxx',
                    'url' => 'https://tikkie.me/pay/Tikkie/xxxxxx',
                    'amountInCents' => 100,
                    'description' => 'Invoice 1000',
                    'createdDateTime' => '2022-08-31 11:22:33',
                    'expiryDate' => '2022-09-14',
                    'status' => 'OPEN',
                    'numberOfPayments' => 0,
                    'totalAmountPaidInCents' => 0,
                ],
            ],
        ];

        $body = $this->createMock(StreamInterface::class);
        $body->expects($this->once())->method('getContents')->willReturn(json_encode($payload));
        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())->method('getBody')->willReturn($body);

        $result = GetAllPaymentRequestsResult::createFromResponse($response);

        $this->assertCount(2, $result->getPaymentRequests());
        $this->assertEquals(2, $result->getTotalElementCount());
    }
}
