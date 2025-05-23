<?php

namespace Modules\Order\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Catalog\Transformers\Api\ProductResource;

class OrderProductResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'price'             => $this->price,
            'qty'               => $this->qty,
            'total'             => $this->total,
            'title'             => $this->product->translate(locale())->title,
            'image'             => url($this->product->image),
            'notes'             => $this->notes,
        ];
    }
}
