<?php

namespace App\Http\Resources\Timer;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TimerCollection extends ResourceCollection
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Support\Collection
     */
    public function toArray($request)
    {
        return $this->collection->map(function($item){
            return new TimerResource($item);
        });
    }
}
