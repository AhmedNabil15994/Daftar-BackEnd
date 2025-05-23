<?php

namespace Modules\Catalog\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

class CategoryResource extends Resource
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
            'title' => $this->translate(locale())->title,
            'image' => url($this->image),
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'sub_categories' => CategoryResource::collection($this->whenLoaded('children')),
        ];
    }
}
