<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Request;

/**
 * Class CreateRefund
 * @package Optios\Tikkie\Request
 */
class CreateRefund extends TransactionBase
{
    /**
     * @var GetPaymentPathVariables
     */
    private $query;

    /**
     * @var int
     */
    private $amountInCents;

    /**
     * @param GetPaymentPathVariables $query
     * @param int                     $amountInCents
     * @param string                  $description
     */
    public function __construct(
        GetPaymentPathVariables $query,
        string $description,
        int $amountInCents
    ) {
        parent::__construct($description);

        $this->query         = $query;
        $this->amountInCents = $amountInCents;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        $array = parent::toArray();

        $array[ 'amountInCents' ] = $this->amountInCents;

        return array_filter($array);
    }

    /**
     * @return GetPaymentPathVariables
     */
    public function getPathVariables(): GetPaymentPathVariables
    {
        return $this->query;
    }

    /**
     * @return int
     */
    public function getAmountInCents(): int
    {
        return $this->amountInCents;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getReferenceId(): ?string
    {
        return $this->referenceId;
    }

    /**
     * @param string|null $referenceId
     */
    public function setReferenceId(?string $referenceId): void
    {
        $this->referenceId = $referenceId;
    }
}
