<?php

namespace Modules\User\Http\Requests\FrontEnd;

use Illuminate\Foundation\Http\FormRequest;
use Hash;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'               => 'required',
            'mobile'             => 'required|unique:users,mobile,'.auth()->id().'|numeric',
            'email'              => 'required|email|unique:users,email,'.auth()->id(),
            'current_password'   => 'required_with:password',
            'password'           => 'nullable|required_with:current_password|confirmed|min:6',
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
            'name.required'                   =>   __('user::frontend.profile.index.validation.name.required'),
            'mobile.required'                 =>   __('user::frontend.profile.index.validation.mobile.required'),
            'mobile.unique'                   =>   __('user::frontend.profile.index.validation.mobile.unique'),
            'mobile.numeric'                  =>   __('user::frontend.profile.index.validation.mobile.numeric'),
            'email.required'                  =>   __('user::frontend.profile.index.validation.email.required'),
            'email.unique'                    =>   __('user::frontend.profile.index.validation.email.unique'),
            'email.email'                     =>   __('user::frontend.profile.index.validation.email.email'),
            'password.required'               =>   __('user::frontend.profile.index.validation.password.required'),
            'password.min'                    =>   __('user::frontend.profile.index.validation.password.min'),
            'password.confirmed'              =>   __('user::frontend.profile.index.validation.password.confirmed'),
            'password.required_with'          =>   __('user::frontend.profile.index.validation.password.required_with'),
            'current_password.required_with'  =>   __('user::frontend.profile.index.validation.current_password.required_with'),
        ];

        return $v;
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if ($this->current_password != null) {

              if ( !Hash::check($this->current_password, $this->user()->password) ) {
                  $validator->errors()->add(
                    'current_password' , __('user::frontend.profile.index.validation.current_password.not_matchh')
                  );
              }

            }

        });

        return;
    }
}
