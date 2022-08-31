<?php
declare(strict_types = 1);

namespace Tests\Optios\Tikkie\Request;

use Carbon\Carbon;
use Optios\Tikkie\Request\CreatePaymentRequest;
use Optios\Tikkie\Request\TransactionBase;
use PHPUnit\Framework\TestCase;

class CreatePaymentRequestTest extends TestCase
{
    public function testCreatePaymentRequest(): void
    {
        $request = new CreatePaymentRequest('my description');
        $this->assertEquals('my description', $request->getDescription());

        $this->assertNull($request->getAmountInCents());
        $request->setAmountInCents(200);
        $this->assertEquals(200, $request->getAmountInCents());

        $this->assertNull($request->getReferenceId());
        $request->setReferenceId('ref_1234');
        $this->assertEquals('ref_1234', $request->getReferenceId());

        $this->assertNull($request->getExpiryDate());
        $request->setExpiryDate(new Carbon('2030-01-01'));
        $this->assertEquals('2030-01-01', $request->getExpiryDate()->format('Y-m-d'));

        $this->assertEquals(
            [
                'description' => 'my description',
                'referenceId' => 'ref_1234',
                'amountInCents' => 200,
                'expiryDate' => '2030-01-01',
            ],
            $request->toArray()
        );
    }

    public function testDescriptionException(): void
    {
        $this->expectException(\LogicException::class);
        new CreatePaymentRequest('with a description longer than 35 characters');
    }

    public function testReferenceIdException(): void
    {
        $request = new CreatePaymentRequest('valid description');

        $this->expectException(\LogicException::class);
        $request->setReferenceId('123@');
    }
}
