<?php
declare(strict_types = 1);

namespace Tests\Optios\Tikkie\Response;

use Optios\Tikkie\Response\SubscriptionResult;
use PHPUnit\Framework\TestCase;

class SubscriptionResultTest extends TestCase
{
    public function testSubscriptionResult(): void
    {
        $result = SubscriptionResult::createFromArray(['subscriptionId' => '123456abc']);

        $this->assertEquals('123456abc', $result->getSubscriptionId());
    }
}
