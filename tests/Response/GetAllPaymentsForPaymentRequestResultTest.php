<?php
declare(strict_types = 1);

namespace Tests\Optios\Tikkie\Response;

use Optios\Tikkie\Response\GetAllPaymentsForPaymentRequestResult;
use PHPUnit\Framework\TestCase;

class GetAllPaymentsForPaymentRequestResultTest extends TestCase
{
    public function testGetAllPaymentsForPaymentRequestResult(): void
    {
        $result = GetAllPaymentsForPaymentRequestResult::createFromArray(
            [
                'totalElementCount' => 2,
                'payments' => [
                    [
                        'paymentToken' => '132465',
                        'tikkieId' => 10233456,
                        'counterPartyName' => 'Optios',
                        'counterPartyAccountNumber' => 'NL01ABNA1234567890',
                        'amountInCents' => 600,
                        'description' => 'payment description',
                        'createdDateTime' => '2022-08-31 11:22:33',
                        'refunds' => [
                            [
                                'refundToken' => '123456abc',
                                'amountInCents' => 250,
                                'description' => 'Refund description',
                                'createdDateTime' => '2022-08-31 22:33:44',
                                'status' => 'PENDING',
                            ],
                        ],
                    ],
                    [
                        'paymentToken' => '987654',
                        'tikkieId' => 999999,
                        'counterPartyName' => 'Optios',
                        'counterPartyAccountNumber' => 'NL01ABNA1234567890',
                        'amountInCents' => 200,
                        'description' => 'payment description',
                        'createdDateTime' => '2022-09-01 11:22:33',
                        'refunds' => [
                            [
                                'refundToken' => '987654xyz',
                                'amountInCents' => 250,
                                'description' => 'Refund description',
                                'createdDateTime' => '2022-09-01 22:33:44',
                                'status' => 'PENDING',
                            ],
                        ],
                    ],
                ],
            ]
        );

        $this->assertCount(2, $result->getPayments());
        $this->assertEquals(2, $result->getTotalElementCount());
    }
}
