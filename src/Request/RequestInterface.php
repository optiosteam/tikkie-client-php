<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Request;

interface RequestInterface
{
    public function toArray(): array;
}
