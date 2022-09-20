<?php
declare(strict_types = 1);

namespace Tests\Optios\Tikkie\Response;

use Optios\Tikkie\Response\PaymentRequestResult;
use PHPUnit\Framework\TestCase;

class PaymentRequestResultTest extends TestCase
{
    public function testPaymentRequestResult(): void
    {
        $data = [
            'paymentRequestToken' => 'qzdnzr8hnVWTgXXcFRLUMc',
            'url' => 'https://tikkie.me/pay/Tikkie/qzdnzr8hnVWTgXXcFRLUMc',
            'amountInCents' => 2000,
            'description' => 'Invoice 1815',
            'createdDateTime' => '2022-08-31T11:22:33.000Z',
            'expiryDate' => '2022-09-14',
            'status' => 'OPEN',
            'numberOfPayments' => 1,
            'totalAmountPaidInCents' => 1000,
            'referenceId' => null,
        ];

        $result = PaymentRequestResult::createFromArray($data);

        $this->assertEquals('qzdnzr8hnVWTgXXcFRLUMc', $result->getPaymentRequestToken());
        $this->assertEquals('https://tikkie.me/pay/Tikkie/qzdnzr8hnVWTgXXcFRLUMc', $result->getUrl());
        $this->assertEquals(2000, $result->getAmountInCents());
        $this->assertEquals('Invoice 1815', $result->getDescription());
        $this->assertNull($result->getReferenceId());
        $this->assertEquals('2022-08-31 11:22:33', $result->getCreatedDateTime()->format('Y-m-d H:i:s'));
        $this->assertEquals('2022-09-14', $result->getExpiryDate()->format('Y-m-d'));
        $this->assertEquals('OPEN', $result->getStatus());
        $this->assertEquals(1, $result->getNumberOfPayments());
        $this->assertEquals(1000, $result->getTotalAmountPaidInCents());
        $this->assertNull($result->getReferenceId());
        $this->assertEquals($data, $result->toArray());
    }
}
