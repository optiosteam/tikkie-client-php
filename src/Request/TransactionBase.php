<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Request;

/**
 * Class TransactionBase
 * @package Optios\Tikkie\Request
 */
abstract class TransactionBase implements RequestInterface
{
    /**
     * @var string;
     */
    protected $description;

    /**
     * @var string|null
     */
    protected $referenceId;

    /**
     * @param string $description
     */
    public function __construct(string $description)
    {
        if (strlen($description) > 35) {
            throw new \LogicException('Payment request description can not be more than 35 characters');
        }

        $this->description = $description;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        $array = [
            'description' => $this->description,
            'referenceId' => $this->referenceId,
        ];

        return array_filter($array);
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getReferenceId(): ?string
    {
        return $this->referenceId;
    }

    /**
     * @param string|null $referenceId
     */
    public function setReferenceId(?string $referenceId): void
    {
        if (null !== $referenceId && ! preg_match("/^[a-zA-Z0-9!&'()+-.\/:?_`, ]{1,35}$/", $referenceId)) {
            throw new \LogicException('Invalid reference id, please refer to the API documentation');
        }

        $this->referenceId = $referenceId;
    }
}
