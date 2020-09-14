<?php

namespace App\Http\Resources\Timer;

use App\Entities\Timer;
use Illuminate\Http\Resources\Json\JsonResource;

class TimerResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->getId(),
            'name' => $this->resource->getName(),
            'type' => $this->resource->getType(),
            'common_time' => $this->resource->getCommonTime(),
            'items' => $this->resource->getItems()
        ];
    }
}
