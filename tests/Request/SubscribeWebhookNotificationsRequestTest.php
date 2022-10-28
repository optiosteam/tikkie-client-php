<?php
declare(strict_types = 1);

namespace Tests\Optios\Tikkie\Request;

use Optios\Tikkie\Request\SubscribeWebhookNotificationsRequest;
use PHPUnit\Framework\TestCase;

class SubscribeWebhookNotificationsRequestTest extends TestCase
{
    public function testSubscribeWebhookNotificationsRequest(): void
    {
        $request = new SubscribeWebhookNotificationsRequest('http://www.google.com/webhook');
        $this->assertEquals('http://www.google.com/webhook', $request->getUrl());

        $this->assertEquals(
            [
                'url' => 'http://www.google.com/webhook',
            ],
            $request->toArray()
        );
    }

    public function testSubscribeWebhookNotificationsRequestException(): void
    {
        $this->expectException(\LogicException::class);
        new SubscribeWebhookNotificationsRequest('exception');
    }
}
