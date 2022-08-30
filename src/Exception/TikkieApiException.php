<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Exception;

use GuzzleHttp\Exception\ClientException;

/**
 * Class TikkieApiException
 * @package Optios\Tikkie\Exception
 */
class TikkieApiException extends \Exception
{
    /**
     * @var bool
     */
    private $useProd;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @param ClientException $e
     *
     * @return static
     */
    public static function createFromClientException(bool $useProd, ClientException $e): self
    {
        $self = new self($e->getMessage(), $e->getCode());
        $self->setUseProd($useProd);

        $contents = $e->getResponse()->getBody()->getContents() ?: null;

        if (null === $contents) {
            return $self;
        }

        $message = json_decode($contents, true);
        foreach ($message[ 'errors' ] as $error) {
            $self->addError(Error::createFromArray($error));
        }

        return $self;
    }

    /**
     * @return bool
     */
    public function isUseProd(): bool
    {
        return $this->useProd;
    }

    /**
     * @param bool $useProd
     */
    public function setUseProd(bool $useProd): void
    {
        $this->useProd = $useProd;
    }

    /**
     * @return Error[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param Error $error
     */
    public function addError(Error $error): void
    {
        $this->errors[] = $error;
    }
}
