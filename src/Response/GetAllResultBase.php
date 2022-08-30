<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Response;

/**
 * Class GetAllResultBase
 * @package Optios\Tikkie\Response
 */
abstract class GetAllResultBase extends MainResultBase
{
    /**
     * @var int
     */
    protected $totalElementCount;

    /**
     * @param int $totalElementCount
     */
    public function __construct(int $totalElementCount)
    {
        $this->totalElementCount = $totalElementCount;
    }

    /**
     * @return int
     */
    public function getTotalElementCount(): int
    {
        return $this->totalElementCount;
    }
}
