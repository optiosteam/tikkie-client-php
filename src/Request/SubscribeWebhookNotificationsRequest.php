<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Request;

/**
 * Class SubscribeWebhookNotificationsRequest
 * @package Optios\Tikkie\Request
 */
class SubscribeWebhookNotificationsRequest implements RequestInterface
{
    /**
     * @var string
     */
    private $url;

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \LogicException('Invalid url');
        }

        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'url' => $this->url,
        ];
    }
}
