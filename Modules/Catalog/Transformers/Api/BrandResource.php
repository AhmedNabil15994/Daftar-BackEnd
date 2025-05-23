<?php

namespace Modules\Catalog\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

class BrandResource extends Resource
{
    public function toArray($request)
    {
        return [
           'id'    => $this->id,
           'title' => $this->translate(locale())->title,
           'image' => url($this->image),
        ];
    }
}
