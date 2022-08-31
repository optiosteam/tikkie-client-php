<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Response;

class SubscriptionResult extends MainResultBase
{
    private string $subscriptionId;

    public function __construct(string $subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;
    }

    public static function createFromArray(array $array)
    {
        return new self($array[ 'subscriptionId' ]);
    }

    public function getSubscriptionId(): string
    {
        return $this->subscriptionId;
    }
}
