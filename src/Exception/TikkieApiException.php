<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Exception;

use GuzzleHttp\Exception\ClientException;

class TikkieApiException extends \Exception
{
    /**
     * @var Error[]|null
     */
    private ?array $errors = null;

    public static function createFromClientException(ClientException $e): self
    {
        $self = new self($e->getMessage(), $e->getCode());

        $contents = $e->getResponse()->getBody()->getContents() ?: null;

        if (null === $contents) {
            return $self;
        }

        $message = json_decode($contents, true);

        if (! isset($message[ 'errors' ])) {
            return $self;
        }

        foreach ($message[ 'errors' ] as $error) {
            $self->addError(Error::createFromArray($error));
        }

        return $self;
    }

    /**
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    public function addError(Error $error): void
    {
        $this->errors[] = $error;
    }
}
