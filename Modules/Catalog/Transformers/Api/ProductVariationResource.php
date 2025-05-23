<?php

namespace Modules\Catalog\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

class ProductVariationResource extends Resource
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
            'image'         => url($this->image),
            'qty'           => $this->qty,
            'price'         => $this->price,
            'sku'           => $this->sku,
            'values'        => ProductVariationValueResource::collection($this->productValues)
       ];
    }
}
