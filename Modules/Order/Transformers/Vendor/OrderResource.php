<?php

namespace Modules\Order\Transformers\Vendor;

use Illuminate\Http\Resources\Json\Resource;

class OrderResource extends Resource
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
            'time' => $this->time,
            'unread' => $this->unread,

            'subtotal' => $this->orderProducts->sum('cost_price'),
            'total' => $this->orderProducts->sum('cost_total'),

            /*'subtotal' => number_format($this->subtotal, 3),
            'total' => number_format($this->total, 3),*/

            'transaction' => $this->transactions->method,
            'order_status_id' => $this->orderStatus->translate(locale())->title,
            'delivery_status' => optional(optional($this->deliveryStatus)->translate(locale()))->title ?? '',
            'deleted_at' => $this->deleted_at,
            'created_at' => date('Y-m-d H:i:s', strtotime($this->created_at)),
        ];
    }
}
