<?php

namespace Modules\Order\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

class OrderResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'subtotal'          => $this->subtotal,
            'time'              => $this->time,
            'shipping'          => $this->shipping,
            'off'               => $this->off,
            'total'             => $this->total,
            'transaction'       => $this->transactions->method,
            'order_status_id'   => $this->orderStatus->translate(locale())->title,
            'created_at'        => date('Y-m-d H:i:s' , strtotime($this->created_at)),
            'products'          => OrderProductResource::collection($this->orderProducts),
        ];
    }
}
