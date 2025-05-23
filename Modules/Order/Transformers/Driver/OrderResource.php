<?php

namespace Modules\Order\Transformers\Driver;

use Illuminate\Http\Resources\Json\Resource;

class OrderResource extends Resource
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
           'id'                   => $this->id,
           'time'                 => $this->time,
           'username'             => $this->orderAddress->username,
           'mobile'               => $this->orderAddress->mobile,
           'state'                => $this->orderAddress->state->translate(locale())->title,
           'total'                => $this->total,
           'shipping'             => $this->shipping,
           'subtotal'             => $this->subtotal,
           'transaction'          => $this->transactions->method,
           'deleted_at'           => $this->deleted_at,
           'created_at'           => date('Y-m-d H:i:s' , strtotime($this->created_at)),
       ];
    }
}
