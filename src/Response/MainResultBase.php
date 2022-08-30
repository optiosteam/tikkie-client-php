<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Response;

use Psr\Http\Message\ResponseInterface;

/**
 * Class MainResultBase
 * @package Optios\Tikkie\Response
 */
abstract class MainResultBase implements ResultInterface
{
    /**
     * @param ResponseInterface $response
     *
     * @return static
     */
    public static function createFromResponse(ResponseInterface $response)
    {
        $responseArray = json_decode($response->getBody()->getContents(), true);

        return static::createFromArray($responseArray);
    }
}
