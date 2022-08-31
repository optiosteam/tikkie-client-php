<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Request;

class GetAllPaymentsForPaymentRequest extends GetAllRequestBase
{
    private string $paymentRequestToken;

    private bool $includeRefunds;

    public function __construct(string $paymentRequestToken, int $page = 0, int $size = 50, bool $includeRefunds = true)
    {
        parent::__construct($page, $size);

        $this->paymentRequestToken = $paymentRequestToken;
        $this->includeRefunds      = $includeRefunds;
    }

    public function toArray(): array
    {
        $array = parent::toArray();

        $array[ 'includeRefunds' ] = $this->includeRefunds ? 'true' : 'false';

        return $array;
    }

    public function getPaymentRequestToken(): string
    {
        return $this->paymentRequestToken;
    }

    public function isIncludeRefunds(): bool
    {
        return $this->includeRefunds;
    }
}
