<?php

namespace App\Entities\ItemTimer;

class IntervalItemTimer extends ItemTimer
{
    public function getType(): string
    {
        return 'interval';
    }

    public function getCommonTime(): int
    {
        $items = $this->items;
        $sum = 0;
        if(!empty($items['before'])){
            $sum += $items['before'];
        }
        $count_sets = $items['sets'] * $items['cycles'];
        $sum += $count_sets * $items['work'];
        if($items['betweenCycles']){
            $sum += ($count_sets - $items['cycles']) * $items['rest'];
            $sum += ($items['cycles'] - 1) * $items['betweenCycles'];
        }else{
            $sum += ($count_sets - 1) * $items['rest'];
        }
        if(!empty($items['after'])){
            $sum += $items['after'];
        }
        return $sum;
    }
}
