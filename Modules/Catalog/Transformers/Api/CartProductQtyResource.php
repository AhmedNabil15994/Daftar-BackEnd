<?php

namespace Modules\Catalog\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

class CartProductQtyResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => 'product',
            'qty' => $this->qty
        ];
    }
}
