<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Response;

use Carbon\Carbon;
use Carbon\CarbonInterface;

/**
 * Class RefundResult
 * @package Optios\Tikkie\Response
 */
class RefundResult extends MainResultBase
{
    /**
     * @var string
     */
    private $refundToken;

    /**
     * @var int
     */
    private $amountInCents;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $referenceId;

    /**
     * @var CarbonInterface
     */
    private $createdDateTime;

    /**
     * @var string
     */
    private $status;

    /**
     * @param string          $refundToken
     * @param int             $amountInCents
     * @param string          $description
     * @param string          $referenceId
     * @param CarbonInterface $createdDateTime
     * @param string          $status
     */
    public function __construct(
        string $refundToken,
        int $amountInCents,
        string $description,
        string $referenceId,
        CarbonInterface $createdDateTime,
        string $status
    ) {
        $this->refundToken     = $refundToken;
        $this->amountInCents   = $amountInCents;
        $this->description     = $description;
        $this->referenceId     = $referenceId;
        $this->createdDateTime = $createdDateTime;
        $this->status          = $status;
    }

    /**
     * @param array $array
     *
     * @return static
     */
    public static function createFromArray(array $array): self
    {
        return new self(
            $array[ 'refundToken' ],
            (int) $array[ 'amountInCents' ],
            $array[ 'description' ],
            $array[ 'referenceId' ],
            new Carbon($array[ 'createdDateTime' ]),
            $array[ 'status' ]
        );
    }

    /**
     * @return string
     */
    public function getRefundToken(): string
    {
        return $this->refundToken;
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
     * @return string
     */
    public function getReferenceId(): string
    {
        return $this->referenceId;
    }

    /**
     * @return CarbonInterface
     */
    public function getCreatedDateTime(): CarbonInterface
    {
        return $this->createdDateTime;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
