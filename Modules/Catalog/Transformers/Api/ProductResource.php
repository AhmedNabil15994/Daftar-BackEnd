<?php

namespace Modules\Catalog\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

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
        return [
            'id' => $this->id,
            'title' => $this->translate(locale())->title,
            'image' => url($this->image),
            'qty' => $this->qty,
            'sku' => $this->sku,
            'price' => $this->price,
            'description' => htmlView($this->translate(locale())->description),
            // 'new_arrival'   => $this->new_arrival == 0 ? false : true,
            'new_arrival' => $this->newArrival && $this->newArrival->active()->unexpired()->started()->first() != null,
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'offer' => new ProductOfferResource($this->whenLoaded('offer')),
            'images' => ProductImagesResource::collection($this->whenLoaded('images')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'options' => (count($this->whenLoaded('variants')) > 0) ? getVariantsOfProduct($this) : null,
            'variations_values' => ProductVariantResource::collection($this->variants),
        ];
    }
}
