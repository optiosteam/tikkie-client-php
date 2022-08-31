<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Request;

class GetRefundPathVariables extends GetPaymentPathVariables
{
    private string $refundToken;

    public function __construct(string $paymentRequestToken, string $paymentToken, string $refundToken)
    {
        parent::__construct($paymentRequestToken, $paymentToken);

        $this->refundToken = $refundToken;
    }

    public function getRefundToken(): string
    {
        return $this->refundToken;
    }
}
