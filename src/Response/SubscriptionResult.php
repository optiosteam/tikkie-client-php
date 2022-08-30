<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Response;

/**
 * Class SubscriptionResult
 * @package Optios\Tikkie\Response
 */
class SubscriptionResult extends MainResultBase
{
    /**
     * @var string
     */
    private $subscriptionId;

    /**
     * @param string $subscriptionId
     */
    public function __construct(string $subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;
    }

    /**
     * @inheritdoc
     */
    public static function createFromArray(array $array)
    {
        return new self($array[ 'subscriptionId' ]);
    }

    /**
     * @return string
     */
    public function getSubscriptionId(): string
    {
        return $this->subscriptionId;
    }
}
