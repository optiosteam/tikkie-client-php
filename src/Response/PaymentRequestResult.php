<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Response;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Optios\Tikkie\Request\GetAllRequestBase;

class PaymentRequestResult extends MainResultBase
{
    const STATUS_OPEN                            = 'OPEN';
    const STATUS_CLOSED                          = 'CLOSED';
    const STATUS_EXPIRED                         = 'EXPIRED';
    const STATUS_MAX_YIELD_REACHED               = 'MAX_YIELD_REACHED';
    const STATUS_MAX_SUCCESSFUL_PAYMENTS_REACHED = 'MAX_SUCCESSFUL_PAYMENTS_REACHED';

    /**
     * @var string
     */
    private string $paymentRequestToken;

    private string $url;

    private ?int $amountInCents = null;

    private string $description;

    private ?string $referenceId = null;

    private CarbonInterface $createdDateTime;

    private CarbonInterface $expiryDate;

    private string $status;

    private int $numberOfPayments;

    private int $totalAmountPaidInCents;

    public function __construct(
        string $paymentRequestToken,
        string $url,
        string $description,
        CarbonInterface $createdDateTime,
        CarbonInterface $expiryDate,
        string $status,
        int $numberOfPayments,
        int $totalAmountPaidInCents
    ) {
        $this->paymentRequestToken    = $paymentRequestToken;
        $this->url                    = $url;
        $this->description            = $description;
        $this->createdDateTime        = $createdDateTime;
        $this->expiryDate             = $expiryDate;
        $this->status                 = $status;
        $this->numberOfPayments       = $numberOfPayments;
        $this->totalAmountPaidInCents = $totalAmountPaidInCents;
    }

    public static function createFromArray(array $array): self
    {
        $self = new self(
            $array[ 'paymentRequestToken' ],
            $array[ 'url' ],
            $array[ 'description' ],
            new Carbon($array[ 'createdDateTime' ]),
            new Carbon($array[ 'expiryDate' ]),
            $array[ 'status' ],
            $array[ 'numberOfPayments' ],
            $array[ 'totalAmountPaidInCents' ]
        );

        $self->setAmountInCents($array[ 'amountInCents' ] ?? null);
        $self->setReferenceId($array[ 'referenceId' ] ?? null);

        return $self;
    }

    public function getPaymentRequestToken(): string
    {
        return $this->paymentRequestToken;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getAmountInCents(): ?int
    {
        return $this->amountInCents;
    }

    public function setAmountInCents(?int $amountInCents): void
    {
        $this->amountInCents = $amountInCents;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getReferenceId(): ?string
    {
        return $this->referenceId;
    }

    public function setReferenceId(?string $referenceId): void
    {
        $this->referenceId = $referenceId;
    }

    public function getCreatedDateTime(): CarbonInterface
    {
        return $this->createdDateTime;
    }

    public function getExpiryDate(): CarbonInterface
    {
        return $this->expiryDate;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getNumberOfPayments(): int
    {
        return $this->numberOfPayments;
    }

    public function getTotalAmountPaidInCents(): int
    {
        return $this->totalAmountPaidInCents;
    }

    public function toArray(): array
    {
        return [
            'paymentRequestToken' => $this->getPaymentRequestToken(),
            'url' => $this->getUrl(),
            'description' => $this->getDescription(),
            'createdDateTime' => $this->getCreatedDateTime()->format(GetAllRequestBase::SEARCH_DATE_FORMAT),
            'expiryDate' => $this->getExpiryDate()->format('Y-m-d'),
            'status' => $this->getStatus(),
            'numberOfPayments' => $this->getNumberOfPayments(),
            'totalAmountPaidInCents' => $this->getTotalAmountPaidInCents(),
            'amountInCents' => $this->getAmountInCents(),
            'referenceId' => $this->getReferenceId(),
        ];
    }
}
