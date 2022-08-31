<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Response;

abstract class GetAllResultBase extends MainResultBase
{
    protected int $totalElementCount;

    public function __construct(int $totalElementCount)
    {
        $this->totalElementCount = $totalElementCount;
    }

    public function getTotalElementCount(): int
    {
        return $this->totalElementCount;
    }
}
