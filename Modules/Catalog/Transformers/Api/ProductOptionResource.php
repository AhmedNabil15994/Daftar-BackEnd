<?php

namespace Modules\Catalog\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

class ProductOptionResource extends Resource
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
            'id' => $this->id,
            'title' => $this->option->translate(locale())->title,
            'option_id' => $this->option_id,
            'option_values' => ProductVariantValueResource::collection($this->productValues->unique('option_value_id')),
        ];
        
        /*return [
            'id'            => $this->id,
            'title'         => $this->translate(locale())->title,
            'description'   => $this->translate(locale())->description,
       ];*/
    }
}
