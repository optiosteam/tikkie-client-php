<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Response;

interface ResultInterface
{
    public static function createFromArray(array $array);
}
