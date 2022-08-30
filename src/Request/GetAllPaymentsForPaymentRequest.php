<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Request;

/**
 * Class GetAllPaymentsForPaymentRequest
 * @package Optios\Tikkie\Request
 */
class GetAllPaymentsForPaymentRequest extends GetAllRequestBase
{
    /**
     * @var string
     */
    private $paymentRequestToken;

    /**
     * @var bool
     */
    private $includeRefunds;

    /**
     * @param string $paymentRequestToken
     * @param int    $page
     * @param int    $size
     * @param bool   $includeRefunds
     */
    public function __construct(string $paymentRequestToken, int $page = 0, int $size = 50, bool $includeRefunds = true)
    {
        parent::__construct($page, $size);

        $this->paymentRequestToken = $paymentRequestToken;
        $this->includeRefunds      = $includeRefunds;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        $array = parent::toArray();

        $array[ 'includeRefunds' ] = $this->includeRefunds ? 'true' : 'false';

        return $array;
    }

    /**
     * @return string
     */
    public function getPaymentRequestToken(): string
    {
        return $this->paymentRequestToken;
    }

    /**
     * @return bool
     */
    public function isIncludeRefunds(): bool
    {
        return $this->includeRefunds;
    }
}
