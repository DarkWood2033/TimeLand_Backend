<?php

namespace App\Entities\ItemTimer;

abstract class ItemTimer
{
    /**
     * @var array
     */
    protected $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    abstract public function getType(): string;

    abstract public function getCommonTime(): int;
}
