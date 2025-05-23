<?php

namespace Modules\Coupon\Transformers\WebService;

use Illuminate\Http\Resources\Json\Resource;

class CouponProductResource extends Resource
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
            'id'        => $this->id,
        ];
    }
}
