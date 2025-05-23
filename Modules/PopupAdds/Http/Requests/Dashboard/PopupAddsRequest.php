<?php

namespace Modules\PopupAdds\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class PopupAddsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
            // handle creates
            case 'post':
            case 'POST':

                return [
//                    'image' => 'required',
                    'start_at' => 'required',
                    'end_at' => 'required',
                    'title.*' => 'nullable',
                    'short_description.*' => 'nullable',
                    'popup_adds_type' => 'required|in:external,product,category,vendor,brand',
                    'product_id' => 'required_if:popup_adds_type,==,product',
                    'category_id' => 'required_if:popup_adds_type,==,category',
                    'vendor_id' => 'required_if:popup_adds_type,==,vendor',
                    'brand_id' => 'required_if:popup_adds_type,==,brand',
                    'link' => 'required_if:popup_adds_type,==,external',
                    'image' => 'required|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
//                    'image' => 'nullable',
                    'start_at' => 'required',
                    'end_at' => 'required',
                    'title.*' => 'nullable',
                    'short_description.*' => 'nullable',
                    'popup_adds_type' => 'required|in:external,product,category,vendor,brand',
                    'product_id' => 'required_if:popup_adds_type,==,product',
                    'category_id' => 'required_if:popup_adds_type,==,category',
                    'vendor_id' => 'required_if:popup_adds_type,==,vendor',
                    'brand_id' => 'required_if:popup_adds_type,==,brand',
                    'link' => 'required_if:popup_adds_type,==,external',
                    'image' => 'nullable|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                ];
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $v = [
//            'image.required' => __('popup_adds::dashboard.popup_adds.validation.image.required'),
            'start_at.required' => __('popup_adds::dashboard.popup_adds.validation.start_at.required'),
            'end_at.required' => __('popup_adds::dashboard.popup_adds.validation.end_at.required'),

            'popup_adds_type.required' => __('popup_adds::dashboard.popup_adds.validation.popup_adds_type.required'),
            'popup_adds_type.in' => __('popup_adds::dashboard.popup_adds.validation.popup_adds_type.in') . ' : external,product,category',
            'product_id.required_if' => __('popup_adds::dashboard.popup_adds.validation.product_id.required_if'),
            'product_id.exists' => __('popup_adds::dashboard.popup_adds.validation.product_id.exists'),
            'category_id.required_if' => __('popup_adds::dashboard.popup_adds.validation.category_id.required_if'),
            'category_id.exists' => __('popup_adds::dashboard.popup_adds.validation.category_id.exists'),
            'vendor_id.required_if' => __('popup_adds::dashboard.popup_adds.validation.vendor_id.required_if'),
            'vendor_id.exists' => __('popup_adds::dashboard.popup_adds.validation.vendor_id.exists'),
            'brand_id.required_if' => __('popup_adds::dashboard.popup_adds.validation.brand_id.required_if'),
            'brand_id.exists' => __('popup_adds::dashboard.popup_adds.validation.brand_id.exists'),
            'link.required_if' => __('popup_adds::dashboard.popup_adds.validation.link.required_if'),

            'image.required' => __('apps::dashboard.validation.image.required'),
            'image.image' => __('apps::dashboard.validation.image.image'),
            'image.mimes' => __('apps::dashboard.validation.image.mimes') . ': ' . config('core.config.image_mimes'),
            'image.max' => __('apps::dashboard.validation.image.max') . ': ' . config('core.config.image_max'),
        ];

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v['title.' . $key . '.required'] = __('popup_adds::dashboard.popup_adds.validation.title.required') . ' - ' . $value['native'] . '';
        }

        return $v;

    }
}
