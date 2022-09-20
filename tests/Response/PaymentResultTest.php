<?php
declare(strict_types = 1);

namespace Tests\Optios\Tikkie\Response;

use Optios\Tikkie\Response\PaymentResult;
use PHPUnit\Framework\TestCase;

class PaymentResultTest extends TestCase
{
    public function testPaymentResult(): void
    {
        $data = [
            'paymentToken' => '132465',
            'tikkieId' => '10233456',
            'counterPartyName' => 'Optios',
            'counterPartyAccountNumber' => 'NL01ABNA1234567890',
            'amountInCents' => 600,
            'description' => 'payment description',
            'createdDateTime' => '2022-08-31T11:22:33.000Z',
            'refunds' => [
                [
                    'refundToken' => '123456abc',
                    'amountInCents' => 250,
                    'description' => 'Refund description',
                    'createdDateTime' => '2022-08-31T11:22:33.000Z',
                    'status' => 'PENDING',
                    'referenceId' => null,
                ],
            ],
        ];

        $result = PaymentResult::createFromArray($data);

        $this->assertEquals('132465', $result->getPaymentToken());
        $this->assertEquals('10233456', $result->getTikkieId());
        $this->assertEquals('Optios', $result->getCounterPartyName());
        $this->assertEquals('NL01ABNA1234567890', $result->getCounterPartyAccountNumber());
        $this->assertEquals(600, $result->getAmountInCents());
        $this->assertEquals('payment description', $result->getDescription());
        $this->assertEquals('2022-08-31 11:22:33', $result->getCreatedDateTime()->format('Y-m-d H:i:s'));
        $this->assertCount(1, $result->getRefunds());
        $this->assertEquals($data, $result->toArray());
    }
}
