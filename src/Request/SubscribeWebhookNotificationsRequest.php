<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Request;

class SubscribeWebhookNotificationsRequest implements RequestInterface
{
    private string $url;

    public function __construct(string $url)
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \LogicException('Invalid url');
        }

        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function toArray(): array
    {
        return [
            'url' => $this->url,
        ];
    }
}
