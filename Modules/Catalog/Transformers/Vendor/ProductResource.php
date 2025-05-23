<?php

namespace Modules\Catalog\Transformers\Vendor;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Catalog\Transformers\Dashboard\CategoryResource;

class ProductResource extends Resource
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
           'title'         => $this->translate(locale())->title,
           'image'         => url($this->image),
           'status'        => $this->status,
           'qty'           => $this->qty,
           'price'         => $this->price,
           'cost_price'    => $this->cost_price,
           'sku'           => $this->sku,
           'categories'    => CategoryResource::collection($this->categories),
           'sold_qty'      => $this->orders->sum('qty'),
           'vendor'        => $this->vendor->translate(locale())->title,
           'deleted_at'    => $this->deleted_at,
           'created_at'    => date('d-m-Y' , strtotime($this->created_at)),
       ];
    }
}
