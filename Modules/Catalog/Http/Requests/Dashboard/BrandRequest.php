<?php

namespace Modules\Catalog\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
//                    'title.*' => 'required',
                    'title.*' => 'required|unique:brand_translations,title',
                    'image' => 'required|image|mimes:' . config('core.config.image_mimes') . '|max:' . config('core.config.image_max'),
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
//                    'title.*' => 'required',
                    'title.*' => 'required|unique:brand_translations,title,' . $this->id . ',brand_id',
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
//            'image.required' => __('catalog::dashboard.brands.validation.image.required'),

            'image.required' => __('apps::dashboard.validation.image.required'),
            'image.image' => __('apps::dashboard.validation.image.image'),
            'image.mimes' => __('apps::dashboard.validation.image.mimes') . ': ' . config('core.config.image_mimes'),
            'image.max' => __('apps::dashboard.validation.image.max') . ': ' . config('core.config.image_max'),
        ];
        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v["title." . $key . ".required"] = __('catalog::dashboard.brands.validation.title.required') . ' - ' . $value['native'] . '';
            $v["title." . $key . ".unique"] = __('catalog::dashboard.brands.validation.title.unique') . ' - ' . $value['native'] . '';
        }
        return $v;
    }
}
