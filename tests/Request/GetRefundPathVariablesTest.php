<?php
declare(strict_types = 1);

namespace Tests\Optios\Tikkie\Request;

use Optios\Tikkie\Request\GetRefundPathVariables;
use PHPUnit\Framework\TestCase;

class GetRefundPathVariablesTest extends TestCase
{
    public function testGetRefundPathVariables(): void
    {
        $pathVariables = new GetRefundPathVariables('abc', '123', 'lalala');
        $this->assertEquals('lalala', $pathVariables->getRefundToken());
    }
}
