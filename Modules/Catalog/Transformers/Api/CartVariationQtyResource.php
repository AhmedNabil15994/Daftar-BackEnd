<?php

namespace Modules\Catalog\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

class CartVariationQtyResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => 'variation',
            'qty' => $this->qty
        ];
    }
}
