<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Webhook;

class Notification
{
    const NOTIFICATION_TYPE_PAYMENT = 'PAYMENT';
    const NOTIFICATION_TYPE_REFUND  = 'REFUND';

    private string $subscriptionId;

    private string $notificationType;

    private string $paymentRequestToken;

    private string $paymentToken;

    private ?string $refundToken = null;

    public function __construct(
        string $subscriptionId,
        string $notificationType,
        string $paymentRequestToken,
        string $paymentToken
    ) {
        $this->subscriptionId      = $subscriptionId;
        $this->notificationType    = $notificationType;
        $this->paymentRequestToken = $paymentRequestToken;
        $this->paymentToken        = $paymentToken;
    }

    public static function createFromArray(array $array): self
    {
        $self = new self(
            $array[ 'subscriptionId' ],
            $array[ 'notificationType' ],
            $array[ 'paymentRequestToken' ],
            $array[ 'paymentToken' ]
        );

        $self->setRefundToken($array[ 'refundToken' ] ?? null);

        return $self;
    }

    public function getSubscriptionId(): string
    {
        return $this->subscriptionId;
    }

    public function getNotificationType(): string
    {
        return $this->notificationType;
    }

    public function getPaymentRequestToken(): string
    {
        return $this->paymentRequestToken;
    }

    public function getPaymentToken(): string
    {
        return $this->paymentToken;
    }

    /**
     * @return string|null
     */
    public function getRefundToken(): ?string
    {
        return $this->refundToken;
    }

    /**
     * @param string|null $refundToken
     */
    public function setRefundToken(?string $refundToken): void
    {
        $this->refundToken = $refundToken;
    }

    public function toArray(): array
    {
        return [
            'subscriptionId' => $this->getSubscriptionId(),
            'notificationType' => $this->getNotificationType(),
            'paymentRequestToken' => $this->getPaymentRequestToken(),
            'paymentToken' => $this->getPaymentToken(),
            'refundToken' => $this->getRefundToken(),
        ];
    }
}
