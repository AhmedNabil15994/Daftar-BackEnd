<?php

namespace Modules\PopupAdds\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\Resource;

class PopupAddsResource extends Resource
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
            'image' => $this->image ? url($this->image) : url(config('core.config.user_img_path') . '/default.png'),
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'status' => $this->status,
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];

        if ($this->morph_model == 'Category') {
            $result['model'] = __('popup_adds::dashboard.popup_adds.form.popup_adds_type.category') . ' / ' . optional(optional($this->popupable)->translate(locale()))->title;
        } elseif ($this->morph_model == 'Product') {
            $result['model'] = __('popup_adds::dashboard.popup_adds.form.popup_adds_type.product') . ' / ' . optional(optional($this->popupable)->translate(locale()))->title;
        } elseif ($this->morph_model == 'Vendor') {
            $result['model'] = __('popup_adds::dashboard.popup_adds.form.popup_adds_type.vendor') . ' / ' . optional(optional($this->popupable)->translate(locale()))->title;
        } elseif ($this->morph_model == 'Brand') {
            $result['model'] = __('popup_adds::dashboard.popup_adds.form.popup_adds_type.brand') . ' / ' . optional(optional($this->popupable)->translate(locale()))->title;
        } else {
            $result['model'] = __('popup_adds::dashboard.popup_adds.form.popup_adds_type.external');
        }

        return $result;
    }
}
