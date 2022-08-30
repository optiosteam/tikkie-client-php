<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Response;

use Carbon\Carbon;
use Carbon\CarbonInterface;

/**
 * Class PaymentRequestResult
 * @package Optios\Tikkie\Response
 */
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
    private $paymentRequestToken;

    /**
     * @var string
     */
    private $url;

    /**
     * @var int|null
     */
    private $amountInCents;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string|null
     */
    private $referenceId;

    /**
     * @var CarbonInterface
     */
    private $createdDateTime;

    /**
     * @var CarbonInterface
     */
    private $expiryDate;

    /**
     * @var string
     */
    private $status;

    /**
     * @var int
     */
    private $numberOfPayments;

    /**
     * @var int
     */
    private $totalAmountPaidInCents;

    /**
     * @param string          $paymentRequestToken
     * @param string          $url
     * @param string          $description
     * @param CarbonInterface $createdDateTime
     * @param CarbonInterface $expiryDate
     * @param string          $status
     * @param int             $numberOfPayments
     * @param int             $totalAmountPaidInCents
     */
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

    /**
     * @param array $array
     *
     * @return static
     */
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
    public function getUrl(): string
    {
        return $this->url;
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

    /**
     * @return CarbonInterface
     */
    public function getCreatedDateTime(): CarbonInterface
    {
        return $this->createdDateTime;
    }

    /**
     * @return CarbonInterface
     */
    public function getExpiryDate(): CarbonInterface
    {
        return $this->expiryDate;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getNumberOfPayments(): int
    {
        return $this->numberOfPayments;
    }

    /**
     * @return int
     */
    public function getTotalAmountPaidInCents(): int
    {
        return $this->totalAmountPaidInCents;
    }
}
