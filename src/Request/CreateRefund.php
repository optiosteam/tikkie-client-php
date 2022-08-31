<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Request;

class CreateRefund extends TransactionBase
{
    private GetPaymentPathVariables $pathVariables;

    private int $amountInCents;

    public function __construct(
        GetPaymentPathVariables $pathVariables,
        string $description,
        int $amountInCents
    ) {
        parent::__construct($description);

        $this->pathVariables = $pathVariables;
        $this->amountInCents = $amountInCents;
    }

    public function toArray(): array
    {
        $array = parent::toArray();

        $array[ 'amountInCents' ] = $this->amountInCents;

        return $array;
    }

    public function getPathVariables(): GetPaymentPathVariables
    {
        return $this->pathVariables;
    }

    public function getAmountInCents(): int
    {
        return $this->amountInCents;
    }
}
