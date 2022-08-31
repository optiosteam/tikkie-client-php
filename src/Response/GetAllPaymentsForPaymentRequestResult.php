<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Response;

class GetAllPaymentsForPaymentRequestResult extends GetAllResultBase
{
    /**
     * @var PaymentResult[]
     */
    private $payments;

    /**
     * @param int             $totalElementCount
     * @param PaymentResult[] $payments
     */
    public function __construct(int $totalElementCount, array $payments)
    {
        parent::__construct($totalElementCount);

        $this->payments = $payments;
    }

    public static function createFromArray(array $array): self
    {
        $payments = [];
        foreach ($array[ 'payments' ] as $paymentsArray) {
            $payments[] = PaymentResult::createFromArray($paymentsArray);
        }

        return new self((int) $array[ 'totalElementCount' ], $payments);
    }

    /**
     * @return PaymentResult[]
     */
    public function getPayments(): array
    {
        return $this->payments;
    }
}
