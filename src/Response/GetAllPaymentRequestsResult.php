<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Response;

class GetAllPaymentRequestsResult extends GetAllResultBase
{
    /**
     * @var PaymentRequestResult[]
     */
    private array $paymentRequests;

    /**
     * @param int                    $totalElementCount
     * @param PaymentRequestResult[] $paymentRequests
     */
    public function __construct(int $totalElementCount, array $paymentRequests)
    {
        parent::__construct($totalElementCount);

        $this->paymentRequests = $paymentRequests;
    }

    public static function createFromArray(array $array): self
    {
        $paymentRequests = [];
        foreach ($array[ 'paymentRequests' ] as $paymentRequestArray) {
            $paymentRequests[] = PaymentRequestResult::createFromArray($paymentRequestArray);
        }

        return new self((int) $array[ 'totalElementCount' ], $paymentRequests);
    }

    /**
     * @return PaymentRequestResult[]
     */
    public function getPaymentRequests(): array
    {
        return $this->paymentRequests;
    }
}
