<?php

namespace Modules\DeliveryTime\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

class DeliveryTimeResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'from' => $this->from,
            'to' => $this->to,
            'last_order' => $this->last_order,
        ];
    }
}
