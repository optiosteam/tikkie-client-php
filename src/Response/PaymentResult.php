<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Response;

use Carbon\Carbon;
use Carbon\CarbonInterface;

/**
 * Class PaymentResult
 * @package Optios\Tikkie\Response
 */
class PaymentResult extends MainResultBase
{
    /**
     * @var string
     */
    private $paymentToken;

    /**
     * @var string
     */
    private $tikkieId;

    /**
     * @var string
     */
    private $counterPartyName;

    /**
     * @var string
     */
    private $counterPartyAccountNumber;

    /**
     * @var int
     */
    private $amountInCents;

    /**
     * @var string
     */
    private $description;

    /**
     * @var CarbonInterface
     */
    private $createdDateTime;

    /**
     * @var RefundResult[]
     */
    private $refunds;

    /**
     * @param string          $paymentToken
     * @param string          $tikkieId
     * @param string          $counterPartyName
     * @param string          $counterPartyAccountNumber
     * @param int             $amountInCents
     * @param string          $description
     * @param CarbonInterface $createdDateTime
     * @param RefundResult[]  $refunds
     */
    public function __construct(
        string $paymentToken,
        string $tikkieId,
        string $counterPartyName,
        string $counterPartyAccountNumber,
        int $amountInCents,
        string $description,
        CarbonInterface $createdDateTime,
        array $refunds
    ) {
        $this->paymentToken              = $paymentToken;
        $this->tikkieId                  = $tikkieId;
        $this->counterPartyName          = $counterPartyName;
        $this->counterPartyAccountNumber = $counterPartyAccountNumber;
        $this->amountInCents             = $amountInCents;
        $this->description               = $description;
        $this->createdDateTime           = $createdDateTime;
        $this->refunds                   = $refunds;
    }


    /**
     * @param array $array
     *
     * @return static
     */
    public static function createFromArray(array $array): self
    {
        $refunds = [];
        foreach ($array[ 'refunds' ] as $refundArray) {
            $refunds[] = RefundResult::createFromArray($refundArray);
        }

        return new self(
            $array[ 'paymentToken' ],
            (string) $array[ 'tikkieId' ],
            $array[ 'counterPartyName' ],
            $array[ 'counterPartyAccountNumber' ],
            $array[ 'amountInCents' ],
            $array[ 'description' ],
            new Carbon($array[ 'createdDateTime' ]),
            $refunds
        );
    }

    /**
     * @return string
     */
    public function getPaymentToken(): string
    {
        return $this->paymentToken;
    }

    /**
     * @return string
     */
    public function getTikkieId(): string
    {
        return $this->tikkieId;
    }

    /**
     * @return string
     */
    public function getCounterPartyName(): string
    {
        return $this->counterPartyName;
    }

    /**
     * @return string
     */
    public function getCounterPartyAccountNumber(): string
    {
        return $this->counterPartyAccountNumber;
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
     * @return CarbonInterface
     */
    public function getCreatedDateTime(): CarbonInterface
    {
        return $this->createdDateTime;
    }

    /**
     * @return RefundResult[]
     */
    public function getRefunds(): array
    {
        return $this->refunds;
    }
}
