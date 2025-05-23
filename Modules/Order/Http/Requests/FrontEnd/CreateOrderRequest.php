<?php

namespace Modules\Order\Http\Requests\FrontEnd;

use Illuminate\Foundation\Http\FormRequest;
use Cart;

class CreateOrderRequest extends FormRequest
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
                  'payment' => 'required',
                  'time'    => 'required',
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
            'date.required'     =>   __('order::frontend.orders.validations.date.required'),
            'time.required'     =>   __('order::frontend.orders.validations.time.required'),
            'payment.required'  =>   __('order::frontend.orders.validations.payment.required'),
        ];

        return $v;
    }

    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {
    //
    //       if (Cart::getTotal() < Cart::getCondition('vendor')->getValue()) {
    //           $validator->errors()->add(
    //             'orderLimit' , __('catalog::frontend.checkout.validation.order_limit').' '.Cart::getCondition('vendor')->getValue().' KWD'
    //           );
    //       }
    //
    //     });
    //
    //     return;
    // }
}
