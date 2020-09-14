<?php

namespace App\Entities\ItemTimer;

class ConstructorItemTimer extends ItemTimer
{
    public function getType(): string
    {
        return 'constructor';
    }

    public function getCommonTime(): int
    {
        return array_reduce($this->items, function($prevVal, $item){
            return $prevVal + $item['time'];
        }, 0);
    }

    public function getItems(): array
    {
        return $this->items = array_map(function ($item){
            return [
                'name' => $item['name'],
                'type' => $item['type'],
                'time' => $item['time'],
            ];
        }, parent::getItems());
    }
}
