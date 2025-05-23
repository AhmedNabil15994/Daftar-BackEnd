<?php

namespace Modules\Slider\Transformers\Api;

use Modules\Vendor\Entities\Vendor;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    public function toArray($request)
    {
        $title = optional($this->translate(locale()))->title;

        if ($this->morph_model == 'Vendor')
        {
            if( !is_null($vendor = Vendor::find($this->sliderable_id)) )
            {
                $title = $vendor->translate(locale())->title ?? '';
            }
        }

        $result = [
            'id' => $this->id,
            'image' => $this->image ? url($this->image) : null,
            'link' => is_null($this->sliderable_id) ? $this->link : $this->sliderable_id,
            'title' => $title,
            'short_description' => optional($this->translate(locale()))->short_description,
            'sort' => $this->sort,
        ];

        if ($this->morph_model == 'Category') {
            $result['target'] = 'categories';
        } elseif ($this->morph_model == 'Product') {
            $result['target'] = 'products';
        } elseif ($this->morph_model == 'Vendor') {
            $result['target'] = 'vendors';
        } elseif ($this->morph_model == 'Brand') {
            $result['target'] = 'brand';
        } else {
            $result['target'] = 'external';
        }
        return $result;
    }
}
