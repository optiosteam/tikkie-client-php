<?php
declare(strict_types = 1);

namespace Tests\Optios\Tikkie\Response;

use Optios\Tikkie\Response\RefundResult;
use PHPUnit\Framework\TestCase;

class RefundResultTest extends TestCase
{
    public function testRefundResult(): void
    {
        $data = [
            'refundToken' => '123456abc',
            'amountInCents' => 250,
            'description' => 'Refund description',
            'createdDateTime' => '2022-08-31T11:22:33.000Z',
            'status' => 'PENDING',
        ];

        $result = RefundResult::createFromArray($data);

        $this->assertEquals('123456abc', $result->getRefundToken());
        $this->assertEquals(250, $result->getAmountInCents());
        $this->assertEquals('Refund description', $result->getDescription());
        $this->assertEquals('2022-08-31 11:22:33', $result->getCreatedDateTime()->format('Y-m-d H:i:s'));
        $this->assertEquals('PENDING', $result->getStatus());
        $this->assertNull($result->getReferenceId());

        $result->setReferenceId('ref_123');
        $this->assertEquals('ref_123', $result->getReferenceId());
        $this->assertEquals(array_merge(['referenceId' => 'ref_123'], $data), $result->toArray());
    }
}
