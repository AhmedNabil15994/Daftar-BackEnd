<?php

namespace Modules\Catalog\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

class ProductImagesResource extends Resource
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
       ];
    }
}
