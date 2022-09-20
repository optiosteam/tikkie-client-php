<?php
declare(strict_types = 1);

namespace Tests\Optios\Tikkie\Webhook;

use Optios\Tikkie\Webhook\Notification;
use PHPUnit\Framework\TestCase;

class NotificationTest extends TestCase
{
    public function testNotification(): void
    {
        $data = [
            'subscriptionId' => 'sub123',
            'notificationType' => 'PAYMENT',
            'paymentRequestToken' => 'xyz',
            'paymentToken' => '123456abc',
        ];

        $notification = Notification::createFromArray($data);

        $this->assertEquals('sub123', $notification->getSubscriptionId());
        $this->assertEquals('PAYMENT', $notification->getNotificationType());
        $this->assertEquals('xyz', $notification->getPaymentRequestToken());
        $this->assertEquals('123456abc', $notification->getPaymentToken());
        $this->assertNull($notification->getRefundToken());
        $notification->setRefundToken('refund123');
        $this->assertEquals('refund123', $notification->getRefundToken());
        $this->assertEquals(array_merge(['refundToken' => 'refund123'], $data), $notification->toArray());
    }
}
