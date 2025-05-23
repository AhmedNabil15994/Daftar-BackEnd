<?php

namespace Modules\Catalog\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Catalog\Transformers\Dashboard\CategoryResource;

class ProductResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'title' => optional($this->translate(locale()))->title,
            'image' => $this->image ? url($this->image) : url(config('core.config.product_img_path') . '/default.png'),
            'status' => $this->status,
            'cost_price' => $this->cost_price,
            'sku' => $this->sku,
            'sort' => $this->sort,
            'categories' => CategoryResource::collection($this->categories),
            'sold_qty' => $this->orders->sum('qty'),
            'vendor' => optional(optional($this->vendor)->translate(locale()))->title ?? '',
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];

        if ($this->variants->count() == 0) {
            $result['price'] = is_null($this->offer) ? $this->price : $this->offer->offer_price;
        } else {
            $result['price'] = $this->price;
        }

        if ($this->variants->count() > 0) // Product has variations
        {
            $result['qty'] = $this->variants->sum('qty');
        } else {
            $result['qty'] = $this->qty;
        }

        return $result;
    }
}
