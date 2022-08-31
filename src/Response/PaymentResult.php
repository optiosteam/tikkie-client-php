<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Response;

use Carbon\Carbon;
use Carbon\CarbonInterface;

class PaymentResult extends MainResultBase
{
    private string $paymentToken;

    private string $tikkieId;

    private string $counterPartyName;

    private string $counterPartyAccountNumber;

    private int $amountInCents;

    private string $description;

    private CarbonInterface $createdDateTime;

    /**
     * @var RefundResult[]
     */
    private array $refunds;

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

    public static function createFromArray(array $array): self
    {
        $refunds = [];
        if (array_key_exists('refunds', $array)) {
            foreach ($array[ 'refunds' ] as $refundArray) {
                $refunds[] = RefundResult::createFromArray($refundArray);
            }
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

    public function getPaymentToken(): string
    {
        return $this->paymentToken;
    }

    public function getTikkieId(): string
    {
        return $this->tikkieId;
    }

    public function getCounterPartyName(): string
    {
        return $this->counterPartyName;
    }

    public function getCounterPartyAccountNumber(): string
    {
        return $this->counterPartyAccountNumber;
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

    /**
     * @return RefundResult[]
     */
    public function getRefunds(): array
    {
        return $this->refunds;
    }
}
