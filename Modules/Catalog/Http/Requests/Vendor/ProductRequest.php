<?php

namespace Modules\Catalog\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
                    'title.*'             => 'required',
                    'brand_id'            => 'required',
                    'vendor_id'           => 'required',
                    'image'               => 'required',
                    'category_id'         => 'required',
                    'price'               => 'required|numeric',
                    'cost_price'          => 'required|numeric|lt:price',
                    'qty'                 => 'required|numeric',
                    'sku'                 => 'required',
                    'offer_price'         => 'sometimes|required|numeric',
                    'start_at'            => 'sometimes|required|date',
                    'end_at'              => 'sometimes|required|date',
                    'arrival_start_at'    => 'sometimes|required|date',
                    'arrival_end_at'      => 'sometimes|required|date',
                    'variation_price.*'   => 'sometimes|required',
                    'variation_qty.*'     => 'sometimes|required',
                    'variation_status.*'  => 'sometimes|required',
                    'variation_sku.*'     => 'sometimes|required',
                    'sort' => 'nullable|unique:products,sort',
                ];

                //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*'             => 'required',
                    'brand_id'            => 'required',
                    'vendor_id'           => 'required',
                    'category_id'         => 'required',
                    'price'               => 'required|numeric',
                    'cost_price'          => 'required|numeric|lt:price',
                    'qty'                 => 'required|numeric',
                    'sku'                 => 'required',
                    'offer_price'         => 'sometimes|required|numeric',
                    'start_at'            => 'sometimes|required|date',
                    'end_at'              => 'sometimes|required|date',
                    'arrival_start_at'    => 'sometimes|required|date',
                    'arrival_end_at'      => 'sometimes|required|date',
                    'variation_price.*'   => 'sometimes|required',
                    'variation_qty.*'     => 'sometimes|required',
                    'variation_status.*'  => 'sometimes|required',
                    'variation_sku.*'     => 'sometimes|required',
                    'sort' => 'nullable|unique:products,sort,' . $this->id,
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
            'variation_price.*.required'    => __('catalog::vendor.products.validation.variation_price.required'),
            'variation_qty.*.required'      => __('catalog::vendor.products.validation.variation_qty.required'),
            'variation_status.*.required'   => __('catalog::vendor.products.validation.variation_status.required'),
            'variation_sku.*.required'      => __('catalog::vendor.products.validation.variation_sku.required'),
            'category_id.required'          => __('catalog::vendor.products.validation.category_id.required'),
            'brand_id.required'             => __('catalog::vendor.products.validation.brand_id.required'),
            'vendor_id.required'            => __('catalog::vendor.products.validation.vendor_id.required'),
            'image.required'                => __('catalog::vendor.products.validation.image.required'),
            'price.required'                => __('catalog::vendor.products.validation.price.required'),
            'price.numeric'                 => __('catalog::vendor.products.validation.price.numeric'),
            'cost_price.required'           => __('catalog::vendor.products.validation.cost_price.required'),
            'cost_price.lt'                 => __('catalog::vendor.products.validation.cost_price.lt'),
            'cost_price.numeric'            => __('catalog::vendor.products.validation.cost_price.numeric'),
            'sku.required'                  => __('catalog::vendor.products.validation.sku.required'),
            'qty.required'                  => __('catalog::vendor.products.validation.qty.required'),
            'qty.numeric'                   => __('catalog::vendor.products.validation.qty.numeric'),
            'offer_price.required'          => __('catalog::vendor.products.validation.offer_price.required'),
            'offer_price.numeric'           => __('catalog::vendor.products.validation.offer_price.numeric'),
            'start_at.required'             => __('catalog::vendor.products.validation.start_at.required'),
            'start_at.date'                 => __('catalog::vendor.products.validation.start_at.date'),
            'end_at.required'               => __('catalog::vendor.products.validation.end_at.required'),
            'end_at.date'                   => __('catalog::vendor.products.validation.end_at.date'),
            'arrival_start_at.required'     => __('catalog::vendor.products.validation.arrival_start_at.required'),
            'arrival_start_at.date'         => __('catalog::vendor.products.validation.arrival_start_at.date'),
            'arrival_end_at.required'       => __('catalog::vendor.products.validation.arrival_end_at.required'),
            'arrival_end_at.date'           => __('catalog::vendor.products.validation.arrival_end_at.date'),

            'image.required' => __('apps::dashboard.validation.image.required'),
            'image.image' => __('apps::dashboard.validation.image.image'),
            'image.mimes' => __('apps::dashboard.validation.image.mimes') . ': ' . config('core.config.image_mimes'),
            'image.max' => __('apps::dashboard.validation.image.max') . ': ' . config('core.config.image_max'),

            'sort.unique' => __('catalog::dashboard.products.validation.sort.unique'),
        ];

        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v["title." . $key . ".required"]  = __('catalog::vendor.products.validation.title.required') . ' - ' . $value['native'] . '';
        }
        return $v;
    }
}
