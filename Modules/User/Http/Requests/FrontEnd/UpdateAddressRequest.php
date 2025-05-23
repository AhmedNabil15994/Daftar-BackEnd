<?php

namespace Modules\User\Http\Requests\FrontEnd;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
                  'username'            => 'required|string|min:2',
                  'mobile'              => 'required|numeric|digits_between:8,8',
                  'email'               => 'required|email',
                  'state'               => 'required|numeric',
                  'block'               => 'required|string',
                  'street'              => 'required|string',
                  'building'            => 'required|string',
                  // 'address'             => 'required|string|min:10',
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
            'username.required'           =>   __('user::frontend.addresses.validations.username.required'),
            'username.string'             =>   __('user::frontend.addresses.validations.username.string'),
            'username.min'                =>   __('user::frontend.addresses.validations.username.min'),
            'mobile.required'             =>   __('user::frontend.addresses.validations.mobile.required'),
            'mobile.numeric'              =>   __('user::frontend.addresses.validations.mobile.numeric'),
            'mobile.digits_between'       =>   __('user::frontend.addresses.validations.mobile.digits_between'),
            'email.required'              =>   __('user::frontend.addresses.validations.email.required'),
            'email.email'                 =>   __('user::frontend.addresses.validations.email.email'),
            'state.required'              =>   __('user::frontend.addresses.validations.state.required'),
            'state.numeric'               =>   __('user::frontend.addresses.validations.state.numeric'),
            'address.required'            =>   __('user::frontend.addresses.validations.address.required'),
            'address.string'              =>   __('user::frontend.addresses.validations.address.string'),
            'address.min'                 =>   __('user::frontend.addresses.validations.address.min'),
            'block.required'              =>   __('user::frontend.addresses.validations.block.required'),
            'block.string'                =>   __('user::frontend.addresses.validations.block.string'),
            'street.required'             =>   __('user::frontend.addresses.validations.street.required'),
            'street.string'               =>   __('user::frontend.addresses.validations.street.string'),
            'building.required'           =>   __('user::frontend.addresses.validations.building.required'),
            'building.string'             =>   __('user::frontend.addresses.validations.building.string'),
        ];

        return $v;
    }
}
