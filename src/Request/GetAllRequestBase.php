<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Request;

use Carbon\CarbonInterface;

/**
 * Class GetAllRequestBase
 * @package Optios\Tikkie\Request
 */
abstract class GetAllRequestBase implements RequestInterface
{
    public const SEARCH_DATE_FORMAT = 'Y-m-d\TH:i:s.v\Z';

    /**
     * Note: For the API, the first page is 0, not 1
     *
     * @var int
     */
    protected $page;

    /**
     * @var int
     */
    protected $size;

    /**
     * @var CarbonInterface|null
     */
    protected $fromDateTime;

    /**
     * @var CarbonInterface|null
     */
    protected $toDateTime;

    /**
     * @param int $page
     * @param int $size
     */
    public function __construct(int $page = 0, int $size = 50)
    {
        if ($size > 50) {
            throw new \LogicException('Max page size is 50');
        }

        $this->page = $page;
        $this->size = $size;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        $array = [
            'pageNumber' => $this->page,
            'pageSize' => $this->size,
        ];

        if ($this->fromDateTime) {
            $array[ 'fromDateTime' ] = $this->fromDateTime->format(self::SEARCH_DATE_FORMAT);
        }
        if ($this->toDateTime) {
            $array[ 'toDateTime' ] = $this->toDateTime->format(self::SEARCH_DATE_FORMAT);
        }

        return $array;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * @return CarbonInterface|null
     */
    public function getFromDateTime(): ?CarbonInterface
    {
        return $this->fromDateTime;
    }

    /**
     * @param CarbonInterface|null $fromDateTime
     */
    public function setFromDateTime(?CarbonInterface $fromDateTime): void
    {
        $this->fromDateTime = $fromDateTime;
    }

    /**
     * @return CarbonInterface|null
     */
    public function getToDateTime(): ?CarbonInterface
    {
        return $this->toDateTime;
    }

    /**
     * @param CarbonInterface|null $toDateTime
     */
    public function setToDateTime(?CarbonInterface $toDateTime): void
    {
        $this->toDateTime = $toDateTime;
    }
}
