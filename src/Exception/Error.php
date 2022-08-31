<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Exception;

class Error
{
    private string $code;

    private string $message;

    private string $reference;

    private int $status;

    private string $traceId;

    public function __construct(string $code, string $message, string $reference, int $status, string $traceId)
    {
        $this->code      = $code;
        $this->message   = $message;
        $this->reference = $reference;
        $this->status    = $status;
        $this->traceId   = $traceId;
    }

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

    public function getCode(): string
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getTraceId(): string
    {
        return $this->traceId;
    }
}
