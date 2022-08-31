<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Request;

class GetPaymentPathVariables
{
    /**
     * @var string
     */
    protected string $paymentRequestToken;

    protected string $paymentToken;

    public function __construct(string $paymentRequestToken, string $paymentToken)
    {
        $this->paymentRequestToken = $paymentRequestToken;
        $this->paymentToken        = $paymentToken;
    }

    public function getPaymentRequestToken(): string
    {
        return $this->paymentRequestToken;
    }

    public function getPaymentToken(): string
    {
        return $this->paymentToken;
    }
}
