<?php

namespace Modules\Vendor\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\Resource;

class DeliveryChargeResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
           'id'            => $this->id,
           'state'         => $this->state->translate(locale())->title,
           'delivery'      => $this->delivery,
           'created_at'    => date('d-m-Y' , strtotime($this->created_at)),
       ];
    }
}
