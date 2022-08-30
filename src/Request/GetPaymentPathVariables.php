<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Request;

/**
 * Class GetPaymentPathVariables
 * @package Optios\Tikkie\Request
 */
class GetPaymentPathVariables
{
    /**
     * @var string
     */
    protected $paymentRequestToken;

    /**
     * @var string
     */
    protected $paymentToken;

    /**
     * @param string $paymentRequestToken
     * @param string $paymentToken
     */
    public function __construct(string $paymentRequestToken, string $paymentToken)
    {
        $this->paymentRequestToken = $paymentRequestToken;
        $this->paymentToken        = $paymentToken;
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
