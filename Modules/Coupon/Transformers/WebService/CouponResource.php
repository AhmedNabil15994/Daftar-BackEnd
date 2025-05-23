<?php

namespace Modules\Coupon\Transformers\WebService;

use Illuminate\Http\Resources\Json\Resource;

class CouponResource extends Resource
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
            'discount_type'        => $this->discount_type,
            'discount_value'        => $this->discount_value,
            'discount_percentage'        => $this->discount_percentage,
            'max_discount_percentage_value'        => $this->max_discount_percentage_value,
        ];
    }
}
