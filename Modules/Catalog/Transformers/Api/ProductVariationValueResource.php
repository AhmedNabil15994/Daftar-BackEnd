<?php

namespace Modules\Catalog\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

class ProductVariationValueResource extends Resource
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
            'option_value' => new ProductOptionsValuesResource($this->optionValue)
       ];
    }
}
