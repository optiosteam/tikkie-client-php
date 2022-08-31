<?php
declare(strict_types = 1);

namespace Tests\Optios\Tikkie\Request;

use Optios\Tikkie\Request\CreateRefund;
use Optios\Tikkie\Request\GetPaymentPathVariables;
use PHPUnit\Framework\TestCase;

class CreateRefundTest extends TestCase
{
    public function testCreateRefund()
    {
        $pathVariables = new GetPaymentPathVariables('xyz', '123');
        $request       = new CreateRefund(
            $pathVariables,
            'Refund of €5',
            500
        );
        $this->assertEquals('xyz', $request->getPathVariables()->getPaymentRequestToken());
        $this->assertEquals('123', $request->getPathVariables()->getPaymentToken());
        $this->assertEquals('Refund of €5', $request->getDescription());
        $this->assertEquals(500, $request->getAmountInCents());

        $this->assertNull($request->getReferenceId());
        $request->setReferenceId('ref_1234');
        $this->assertEquals('ref_1234', $request->getReferenceId());

        $this->assertEquals(
            [
                'description' => 'Refund of €5',
                'referenceId' => 'ref_1234',
                'amountInCents' => 500,
            ],
            $request->toArray()
        );
    }
}
