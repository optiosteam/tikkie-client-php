<?php
declare(strict_types = 1);

namespace Optios\Tikkie\Request;

use Carbon\CarbonInterface;

abstract class GetAllRequestBase implements RequestInterface
{
    public const SEARCH_DATE_FORMAT = 'Y-m-d\TH:i:s.v\Z';

    /**
     * Note: For the API, the first page is 0, not 1
     */
    protected int $page;

    protected int $size;

    protected ?CarbonInterface $fromDateTime = null;

    protected ?CarbonInterface $toDateTime = null;

    public function __construct(int $page = 0, int $size = 50)
    {
        if ($size > 50) {
            throw new \LogicException('Max page size is 50');
        }

        $this->page = $page;
        $this->size = $size;
    }

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

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function getFromDateTime(): ?CarbonInterface
    {
        return $this->fromDateTime;
    }

    public function setFromDateTime(?CarbonInterface $fromDateTime): void
    {
        $this->fromDateTime = $fromDateTime;
    }

    public function getToDateTime(): ?CarbonInterface
    {
        return $this->toDateTime;
    }

    public function setToDateTime(?CarbonInterface $toDateTime): void
    {
        $this->toDateTime = $toDateTime;
    }
}
