<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Response;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Optios\Tikkie\Request\GetAllRequestBase;

class RefundResult extends MainResultBase
{
    private string $refundToken;

    private int $amountInCents;

    private string $description;

    private CarbonInterface $createdDateTime;

    private string $status;

    private ?string $referenceId = null;

    public function __construct(
        string $refundToken,
        int $amountInCents,
        string $description,
        CarbonInterface $createdDateTime,
        string $status
    ) {
        $this->refundToken     = $refundToken;
        $this->amountInCents   = $amountInCents;
        $this->description     = $description;
        $this->createdDateTime = $createdDateTime;
        $this->status          = $status;
    }

    public static function createFromArray(array $array): self
    {
        $self = new self(
            $array[ 'refundToken' ],
            (int) $array[ 'amountInCents' ],
            $array[ 'description' ],
            new Carbon($array[ 'createdDateTime' ]),
            $array[ 'status' ]
        );

        $self->setReferenceId($array[ 'referenceId' ] ?? null);

        return $self;
    }

    public function getRefundToken(): string
    {
        return $this->refundToken;
    }

    public function getAmountInCents(): int
    {
        return $this->amountInCents;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedDateTime(): CarbonInterface
    {
        return $this->createdDateTime;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getReferenceId(): ?string
    {
        return $this->referenceId;
    }

    public function setReferenceId(?string $referenceId): void
    {
        $this->referenceId = $referenceId;
    }

    public function toArray(): array
    {
        return [
            'refundToken' => $this->getRefundToken(),
            'amountInCents' => $this->getAmountInCents(),
            'description' => $this->getDescription(),
            'createdDateTime' => $this->getCreatedDateTime()->format(GetAllRequestBase::SEARCH_DATE_FORMAT),
            'status' => $this->getStatus(),
            'referenceId' => $this->getReferenceId(),
        ];
    }
}
