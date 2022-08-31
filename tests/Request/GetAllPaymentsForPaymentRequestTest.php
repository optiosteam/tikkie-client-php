<?php
declare(strict_types = 1);

namespace Tests\Optios\Tikkie\Request;

use Carbon\Carbon;
use Optios\Tikkie\Request\GetAllPaymentsForPaymentRequest;
use Optios\Tikkie\Request\GetAllRequestBase;
use PHPUnit\Framework\TestCase;

class GetAllPaymentsForPaymentRequestTest extends TestCase
{
    public function testGetAllPaymentsForPaymentRequest(): void
    {
        $request = new GetAllPaymentsForPaymentRequest('123abc');

        $this->assertEquals('123abc', $request->getPaymentRequestToken());

        $this->assertEquals(0, $request->getPage());
        $request->setPage(1);
        $this->assertEquals(1, $request->getPage());

        $this->assertEquals(50, $request->getSize());
        $request->setSize(20);
        $this->assertEquals(20, $request->getSize());

        $this->assertNull($request->getFromDateTime());
        $request->setFromDateTime(new Carbon('2022-08-31'));
        $this->assertEquals('2022-08-31', $request->getFromDateTime()->format('Y-m-d'));

        $this->assertNull($request->getToDateTime());
        $request->setToDateTime(new Carbon('2022-09-30'));
        $this->assertEquals('2022-09-30', $request->getToDateTime()->format('Y-m-d'));

        $this->assertTrue($request->isIncludeRefunds());

        $this->assertEquals(
            [
                'pageNumber' => 1,
                'pageSize' => 20,
                'fromDateTime' => '2022-08-31T00:00:00.000Z',
                'toDateTime' => '2022-09-30T00:00:00.000Z',
                'includeRefunds' => 'true',
            ],
            $request->toArray()
        );
    }

    public function testPageSizeException(): void
    {
        $this->expectException(\LogicException::class);
        new GetAllPaymentsForPaymentRequest('123abc', 0, 51);
    }
}
