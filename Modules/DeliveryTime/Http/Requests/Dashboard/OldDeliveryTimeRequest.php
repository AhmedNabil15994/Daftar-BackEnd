<?php

namespace Modules\DeliveryTime\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class OldDeliveryTimeRequest extends FormRequest
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
                  'delivery_from'   => 'required',
                  'delivery_to'     => 'required',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                  'delivery_from'   => 'required',
                  'delivery_to'     => 'required',
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
            'delivery_from.required'        => __('deliverytime::dashboard.times.validation.delivery_from.required'),
            'delivery_to.required'          => __('deliverytime::dashboard.times.validation.delivery_to.required'),
        ];

        return $v;

    }
}
