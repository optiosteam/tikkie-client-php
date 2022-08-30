<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Request;

use Carbon\CarbonInterface;

/**
 * Class CreatePaymentRequest
 * @package Optios\Tikkie\Request
 */
class CreatePaymentRequest extends TransactionBase
{
    /**
     * @var int|null
     */
    private $amountInCents;

    /**
     * @var CarbonInterface|null
     */
    private $expiryDate;

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        $array = parent::toArray();

        if ($this->amountInCents) {
            $array[ 'amountInCents' ] = $this->amountInCents;
        }

        if ($this->expiryDate) {
            $array[ 'expiryDate' ] = $this->expiryDate->format('Y-m-d');
        }

        return array_filter($array);
    }

    /**
     * @return int|null
     */
    public function getAmountInCents(): ?int
    {
        return $this->amountInCents;
    }

    /**
     * @param int|null $amountInCents
     */
    public function setAmountInCents(?int $amountInCents): void
    {
        $this->amountInCents = $amountInCents;
    }

    /**
     * @return CarbonInterface|null
     */
    public function getExpiryDate(): ?CarbonInterface
    {
        return $this->expiryDate;
    }

    /**
     * @param CarbonInterface|null $expiryDate
     */
    public function setExpiryDate(?CarbonInterface $expiryDate): void
    {
        $this->expiryDate = $expiryDate;
    }
}
