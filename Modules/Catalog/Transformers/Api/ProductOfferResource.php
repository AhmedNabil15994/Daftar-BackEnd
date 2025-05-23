<?php

namespace Modules\Catalog\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

class ProductOfferResource extends Resource
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
            'start_at'      => $this->start_at,
            'end_at'        => $this->end_at,
            'offer_price'   => $this->offer_price,
       ];
    }
}
