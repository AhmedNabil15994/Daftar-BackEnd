<?php

return [
    'users' => [
        'validation'    => [
            'current_password'  => [
                'required'  => 'Current password is required',
            ],
            'email'             => [
                'required'  => 'Please enter the email of user',
                'unique'    => 'This email is taken before',
            ],
            'mobile'            => [
                'digits_between'    => 'Please add mobile number only 8 digits',
                'numeric'           => 'Please enter the mobile only numbers',
                'required'          => 'Please enter the mobile of user',
                'unique'            => 'This mobile is taken before',
            ],
            'name'              => [
                'required'  => 'Please enter the name of user',
            ],
            'password'          => [
                'min'       => 'Password must be more than 6 characters',
                'required'  => 'Please enter the password of user',
                'same'      => 'The Password confirmation not matching',
            ],
        ],
        'alerts' => [
            'user_deleted_before' => 'Account has already been deleted',
            'user_deleted_successfully' => 'Account has been deleted successfully',
            'user_not_found' => 'User account not match our records',
        ],
    ],
];
