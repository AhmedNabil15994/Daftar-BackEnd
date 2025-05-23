<?php

namespace Modules\Vendor\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\Resource;

class VendorResource extends Resource
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
            // 'delivery_charges'   => count($this->deliveryCharge),
            'title' => optional($this->translate(locale()))->title,
            'description' => optional($this->translate(locale()))->description,
            'image' => $this->image ? url($this->image) : url(config('core.config.vendor_img_path') . '/default.png'),
            'status' => $this->status,
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
