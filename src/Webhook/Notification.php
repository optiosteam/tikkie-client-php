<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Webhook;

/**
 * Class Notification
 * @package Optios\Tikkie\Webhook
 */
class Notification
{
    /**
     * @var string
     */
    private $subscriptionId;

    /**
     * @var string
     */
    private $notificationType;

    /**
     * @var string
     */
    private $paymentRequestToken;

    /**
     * @var string
     */
    private $paymentToken;

    /**
     * @param string $subscriptionId
     * @param string $notificationType
     * @param string $paymentRequestToken
     * @param string $paymentToken
     */
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

    /**
     * @param array $array
     *
     * @return $this
     */
    public function createFromArray(array $array): self
    {
        return new self(
            $array[ 'subscriptionId' ],
            $array[ 'notificationType' ],
            $array[ 'paymentRequestToken' ],
            $array[ 'paymentToken' ]
        );
    }

    /**
     * @return string
     */
    public function getSubscriptionId(): string
    {
        return $this->subscriptionId;
    }

    /**
     * @return string
     */
    public function getNotificationType(): string
    {
        return $this->notificationType;
    }

    /**
     * @return string
     */
    public function getPaymentRequestToken(): string
    {
        return $this->paymentRequestToken;
    }

    /**
     * @return string
     */
    public function getPaymentToken(): string
    {
        return $this->paymentToken;
    }
}
