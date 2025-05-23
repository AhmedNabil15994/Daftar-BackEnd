<?php

namespace Modules\Order\Transformers\Dashboard;

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
           'id'                     => $this->id,
           'driver'                 => $this->driver ? optional($this->driver->driver)->name : null,
           'time'                   => $this->time,
           'unread'                 => $this->unread,
           'total'                  => $this->total,
           'shipping'               => $this->shipping,
           'total_profit_comission' => $this->total_profit_comission,
           'subtotal'               => $this->subtotal,
           'transaction'            => $this->transactions->method,
           'order_status_id'        => $this->orderStatus->translate(locale())->title,
           'delivery_status'        => optional(optional($this->deliveryStatus)->translate(locale()))->title ?? '',
           // 'vendor_id'              => $this->vendor->translate(locale())->title,
           'deleted_at'             => $this->deleted_at,
           'created_at'             => date('Y-m-d H:i:s' , strtotime($this->created_at)),
       ];
    }
}
