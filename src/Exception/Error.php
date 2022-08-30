<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Exception;

/**
 * Class Error
 * @package Optios\Tikkie\Exception
 */
class Error
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $reference;

    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $traceId;

    /**
     * @param string $code
     * @param string $message
     * @param string $reference
     * @param int    $status
     * @param string $traceId
     */
    public function __construct(string $code, string $message, string $reference, int $status, string $traceId)
    {
        $this->code      = $code;
        $this->message   = $message;
        $this->reference = $reference;
        $this->status    = $status;
        $this->traceId   = $traceId;
    }

    /**
     * @param array $error
     *
     * @return static
     */
    public static function createFromArray(array $error): self
    {
        return new self(
            $error[ 'code' ],
            $error[ 'message' ],
            $error[ 'reference' ],
            $error[ 'status' ],
            $error[ 'traceId' ]
        );
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getTraceId(): string
    {
        return $this->traceId;
    }
}
