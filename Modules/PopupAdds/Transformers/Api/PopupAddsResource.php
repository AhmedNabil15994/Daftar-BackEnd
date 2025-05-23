<?php

namespace Modules\PopupAdds\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class PopupAddsResource extends JsonResource
{
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'image' => $this->image ? url($this->image) : null,
            'sort' => $this->sort,
        ];

        if (is_null($this->popupable_id) && !is_null($this->link)) {
            $result['target'] = 'external';
            $result['link'] = $this->link;
        } elseif (!is_null($this->popupable_id) && $this->morph_model == 'Product') {
            $result['target'] = 'product';
            $result['link'] = $this->popupable_id;
        } elseif (!is_null($this->popupable_id) && $this->morph_model == 'Category') {
            $result['target'] = 'category';
            $result['link'] = $this->popupable_id;
        } elseif (!is_null($this->popupable_id) && $this->morph_model == 'Vendor') {
            $result['target'] = 'vendor';
            $result['link'] = $this->popupable_id;
        } elseif (!is_null($this->popupable_id) && $this->morph_model == 'Brand') {
            $result['target'] = 'brand';
            $result['link'] = $this->popupable_id;
        }

        return $result;
    }
}
