<?php

namespace Modules\Coupon\Http\Requests\WebService;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
                    'code'    => 'required|exists:coupons,code',
                    'product_id'    => 'required|array',
                    // 'vendor_id' => 'required|exists:vendors,id',
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
            'code.required'         => __('coupon::frontend.coupons.validation.code.required'),
            'code.exists'         => __('coupon::frontend.coupons.validation.code.exists'),

            'vendor_id.required'     =>   __('order::frontend.orders.validations.vendor.required'),
            'vendor_id.exists'     =>   __('order::frontend.orders.validations.vendor.exists'),

            'product_id.required'     =>   __('coupon::frontend.coupons.validation.product.required'),
            'product_id.array'     =>   __('coupon::frontend.coupons.validation.product.array'),
        ];


        return $v;
    }
}
