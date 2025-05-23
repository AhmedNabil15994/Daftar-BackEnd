<?php

namespace Modules\Slider\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
                    'slider_type' => 'required|in:external,product,category,vendor,brand',
                    'product_id' => 'required_if:slider_type,==,product',
                    'category_id' => 'required_if:slider_type,==,category',
                    'vendor_id' => 'required_if:slider_type,==,vendor',
                    'brand_id' => 'required_if:slider_type,==,brand',
                    'link' => 'required_if:slider_type,==,external',
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
                    'slider_type' => 'required|in:external,product,category,vendor,brand',
                    'product_id' => 'required_if:slider_type,==,product',
                    'category_id' => 'required_if:slider_type,==,category',
                    'vendor_id' => 'required_if:slider_type,==,vendor',
                    'brand_id' => 'required_if:slider_type,==,brand',
                    'link' => 'required_if:slider_type,==,external',
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
//            'image.required' => __('slider::dashboard.slider.validation.image.required'),
            'start_at.required' => __('slider::dashboard.slider.validation.start_at.required'),
            'end_at.required' => __('slider::dashboard.slider.validation.end_at.required'),

            'slider_type.required' => __('slider::dashboard.slider.validation.slider_type.required'),
            'slider_type.in' => __('slider::dashboard.slider.validation.slider_type.in') . ' : external,product,category',
            'product_id.required_if' => __('slider::dashboard.slider.validation.product_id.required_if'),
            'category_id.required_if' => __('slider::dashboard.slider.validation.category_id.required_if'),
            'vendor_id.required_if' => __('slider::dashboard.slider.validation.vendor_id.required_if'),
            'brand_id.required_if' => __('slider::dashboard.slider.validation.brand_id.required_if'),
            'link.required_if' => __('slider::dashboard.slider.validation.link.required_if'),

            'image.required' => __('apps::dashboard.validation.image.required'),
            'image.image' => __('apps::dashboard.validation.image.image'),
            'image.mimes' => __('apps::dashboard.validation.image.mimes') . ': ' . config('core.config.image_mimes'),
            'image.max' => __('apps::dashboard.validation.image.max') . ': ' . config('core.config.image_max'),
        ];

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v['title.' . $key . '.required'] = __('slider::dashboard.slider.validation.title.required') . ' - ' . $value['native'] . '';
        }

        return $v;

    }
}
