<?php
declare(strict_types=1);

namespace Tests\Optios\Tikkie\Request;

use Optios\Tikkie\Request\GetPaymentPathVariables;
use PHPUnit\Framework\TestCase;

class GetPaymentPathVariablesTest extends TestCase
{
    public function testGetPaymentPathVariables(): void
    {
        $pathVariables = new GetPaymentPathVariables('abc', '123');
        $this->assertEquals('abc', $pathVariables->getPaymentRequestToken());
        $this->assertEquals('123', $pathVariables->getPaymentToken());
    }
}
