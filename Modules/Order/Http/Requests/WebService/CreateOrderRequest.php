<?php

namespace Modules\Order\Http\Requests\WebService;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'nullable|email',
            'date' => 'required|date',
            'time.from' => 'required',
            'time.to' => 'required',
        ];
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
            'email.required' => __('order::api.address.validations.email.required'),
            'email.email' => __('order::api.address.validations.email.email'),
            'date.required' => __('order::api.orders.validations.date.required'),
            'date.date' => __('order::api.orders.validations.date.date'),
            'time.from.required' => __('order::api.orders.validations.time.from.required'),
            'time.to.required' => __('order::api.orders.validations.time.to.required'),
        ];
        return $v;
    }
}
