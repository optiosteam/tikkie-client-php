<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Request;

interface RequestInterface
{
    /**
     * @return array
     */
    public function toArray(): array;
}
