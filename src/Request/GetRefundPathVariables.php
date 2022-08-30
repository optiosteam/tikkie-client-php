<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Request;

/**
 * Class GetRefundPathVariables
 * @package Optios\Tikkie\Request
 */
class GetRefundPathVariables extends GetPaymentPathVariables
{
    /**
     * @var string
     */
    private $refundToken;

    /**
     * @param string $paymentRequestToken
     * @param string $paymentToken
     * @param string $refundToken
     */
    public function __construct(string $paymentRequestToken, string $paymentToken, string $refundToken)
    {
        parent::__construct($paymentRequestToken, $paymentToken);

        $this->refundToken = $refundToken;
    }

    /**
     * @return string
     */
    public function getRefundToken(): string
    {
        return $this->refundToken;
    }
}
