<?php
declare(strict_types=1);

namespace Tests\Optios\Tikkie\Request;

use Optios\Tikkie\Request\TransactionBase;
use PHPUnit\Framework\TestCase;

class TransactionBaseTest extends TestCase
{
    public function testTransactionBase(): void
    {
        $abstract = $this->getMockForAbstractClass(TransactionBase::class, ['test description']);
        $this->assertEquals('test description', $abstract->getDescription());
    }

    public function testDescriptionException(): void
    {
        $this->expectException(\LogicException::class);
        $this->getMockForAbstractClass(
            TransactionBase::class,
            ['with a description longer than 35 characters']
        );
    }

    public function testReferenceIdException(): void
    {
        $abstract = $this->getMockForAbstractClass(
            TransactionBase::class,
            ['valid description']
        );

        $this->expectException(\LogicException::class);
        $abstract->setReferenceId('123@');
    }
}
