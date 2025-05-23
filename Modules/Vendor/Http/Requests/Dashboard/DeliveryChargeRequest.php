<?php

namespace Modules\Vendor\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryChargeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod())
        {
            // handle creates
            case 'post':
            case 'POST':

                return [
                  'delivery'    => 'required|numeric',
                  'state'       => 'required|numeric',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                  'delivery' => 'required|numeric',
                  'state'    => 'required|numeric',
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
            'delivery.required'         => __('vendor::dashboard.delivery_charges.validation.delivery.required'),
            'delivery.numeric'          => __('vendor::dashboard.delivery_charges.validation.delivery.numeric'),
            'state.required'            => __('vendor::dashboard.delivery_charges.validation.state.required'),
            'state.numeric'             => __('vendor::dashboard.delivery_charges.validation.state.numeric'),
            'vendor.required'           => __('vendor::dashboard.delivery_charges.validation.vendor.required'),
            'vendor.numeric'            => __('vendor::dashboard.delivery_charges.validation.state.numeric'),
        ];

        return $v;

    }
}
