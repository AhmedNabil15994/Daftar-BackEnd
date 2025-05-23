<?php

namespace Modules\Coupon\Http\Requests\Dashboard;

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
                    'discount_type' => 'required',
                    'code' => 'unique:coupons,code',
                    'coupon_flag' => 'nullable|in:code,vendors,categories,products',
                    'discount_percentage' => 'required_if:discount_type,==,percentage',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'discount_type' => 'required',
                    'code' => 'unique:coupons,code,' . $this->id,
                    'coupon_flag' => 'nullable|in:code,vendors,categories,products',
                    'discount_percentage' => 'required_if:discount_type,==,percentage',
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
            'discount_type.required' => __('coupon::dashboard.coupons.validation.discount_type.required'),
            'code.unique' => __('coupon::dashboard.coupons.validation.code.unique'),
            'coupon_flag.in' => __('coupon::dashboard.coupons.validation.coupon_flag.in'),
            'discount_percentage.required_if' => __('coupon::dashboard.coupons.validation.discount_percentage.required_if'),
        ];
        return $v;
    }
}
