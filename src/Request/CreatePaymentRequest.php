<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Request;

use Carbon\CarbonInterface;

class CreatePaymentRequest extends TransactionBase
{
    private ?int $amountInCents = null;

    private ?CarbonInterface $expiryDate = null;

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

        return $array;
    }

    public function getAmountInCents(): ?int
    {
        return $this->amountInCents;
    }

    public function setAmountInCents(?int $amountInCents): void
    {
        $this->amountInCents = $amountInCents;
    }

    public function getExpiryDate(): ?CarbonInterface
    {
        return $this->expiryDate;
    }

    public function setExpiryDate(?CarbonInterface $expiryDate): void
    {
        $this->expiryDate = $expiryDate;
    }
}
